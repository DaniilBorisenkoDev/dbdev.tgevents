<?php

namespace DBDevTgEvents;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Web\HttpClient;
use CAgent;
use CEventLog;
use CSite;

class Main
{
    public const MODULE_ID = "dbdev.tgevents";

    public const LOG_ID = "DBDEV_TGEVENTS_API";

    public const ERROR_TYPES = [
        "EMERGENCY" => "EMERGENCY",
        "CRITICAL" => "CRITICAL",
        "ERROR" => "ERROR",
        "SECURITY" => "SECURITY",
        "NOTICE" => "NOTICE",
        "WARNING" => "WARNING",
        "ALERT" => "ALERT",
        "INFO" => "INFO",
        "DEBUG" => "DEBUG",
        "UNKNOWN" => "UNKNOWN"
    ];

    public static function onEventLogGetAuditTypes(): array
    {
        return [self::LOG_ID => "[" . self::LOG_ID . "] " . Loc::getMessage("DBDEV_TGEVENTS_LIB_MAIN_LOG_TITLE")];
    }

    public static function getEventTypes(): array
    {
        $arEventTypes = CEventLog::GetEventTypes();
        if (!is_array($arEventTypes)) {
            $arEventTypes = [];
        }
        if (isset($arEventTypes[self::LOG_ID])) {
            unset($arEventTypes[self::LOG_ID]);
        }
        return array_merge(["" => Loc::getMessage("DBDEV_TGEVENTS_LIB_MAIN_EVENTS_ALL")], $arEventTypes);
    }

    public static function getErrorTypes(): array
    {
        return array_merge(["" => Loc::getMessage("DBDEV_TGEVENTS_LIB_MAIN_EVENTS_ALL")], self::ERROR_TYPES);
    }

    public static function showOptionModuleState(): array
    {
        if (self::isModuleActive()) {
            $message = Loc::getMessage("DBDEV_TGEVENTS_LIB_MAIN_MODULE_IS_ACTIVE");
            $isError = false;
        } else {
            $message = Loc::getMessage("DBDEV_TGEVENTS_LIB_MAIN_MODULE_IS_INACTIVE");
            $isError = true;
        }

        $arAgent = self::getEventAgentData();
        if (!$arAgent) {
            $message .= "<br><br>" . Loc::getMessage("DBDEV_TGEVENTS_LIB_MAIN_AGENT_NOT_FOUND");
            $isError = true;
        } elseif ($arAgent["ACTIVE"] !== "Y") {
            if (self::isModuleActive()) {
                $message .= "<br><br>" . Loc::getMessage("DBDEV_TGEVENTS_LIB_MAIN_AGENT_IS_INACTIVE_1", $arAgent);
            } else {
                $message .= "<br><br>" . Loc::getMessage("DBDEV_TGEVENTS_LIB_MAIN_AGENT_IS_INACTIVE_2", $arAgent);
            }
            $isError = true;
        } else {
            $arAgent["LAST_EXEC"] = $arAgent["LAST_EXEC"] ?:
                Loc::getMessage("DBDEV_TGEVENTS_LIB_MAIN_AGENT_NOT_LAUNCHED");
            $message .= "<br><br>" . Loc::getMessage("DBDEV_TGEVENTS_LIB_MAIN_AGENT_IS_ACTIVE", $arAgent);
        }

        return ["MESSAGE" => $message, "TYPE" => $isError ? "ERROR" : "OK"];
    }

    public static function isModuleActive(): string
    {
        return self::getOption("ACTIVE") == "Y";
    }

    public static function getOption($optionCode): string
    {
        return Option::get(self::MODULE_ID, $optionCode);
    }

    private static function getEventAgentData(): array|null
    {
        $dbAgents = CAgent::GetList(["ID" => "DESC"], [
            "MODULE_ID" => self::MODULE_ID,
            "NAME" => "\\DBDevTgEvents\\Main::checkEvents();"]);
        if ($arAgent = $dbAgents->Fetch()) {
            return $arAgent;
        }

        return null;
    }

    public static function refreshAgent(string $oldPeriod): bool
    {
        $arAgent = self::getEventAgentData();
        if (self::isModuleActive()) {
            $period = self::getOption("PERIOD");
            if ($oldPeriod != $period || !$arAgent || $arAgent["ACTIVE"] != "Y") {
                $objDateTime = new DateTime();
                $agentDate = $objDateTime->toString();

                if ($arAgent && $arAgent["ID"]) {
                    CAgent::Update($arAgent["ID"], [
                        "ACTIVE" => "Y",
                        "AGENT_INTERVAL" => $period,
                        "IS_PERIOD" => "Y",
                        "NEXT_EXEC" => $agentDate
                    ]);
                } else {
                    $agentId = CAgent::AddAgent(
                        "\\DBDevTgEvents\\Main::checkEvents();",
                        self::MODULE_ID,
                        "Y",
                        $period,
                        $agentDate,
                        "Y",
                        $agentDate
                    );

                    global $APPLICATION;
                    if (!$agentId && $ex = $APPLICATION->GetException()) {
                        $APPLICATION->throwException($ex);
                        return false;
                    }
                }
            }
        } elseif ($arAgent && $arAgent["ID"] && $arAgent["ACTIVE"] == "Y") {
            CAgent::Update($arAgent["ID"], [
                "ACTIVE" => "N",
            ]);
        }

        return true;
    }

    public static function checkEvents(): string
    {
        if (self::isModuleActive()) {
            $objDateTime = new DateTime();
            $arAgent = self::getEventAgentData();
            $period = (int)self::getOption("PERIOD");
            $severities = self::getOption("SEVERITIES");
            $auditTypes = self::getOption("AUDIT_TYPES");
            $arFilter = [];

            $arFilter["TIMESTAMP_X_2"] = $objDateTime->toString();
            if ($arAgent && $arAgent["LAST_EXEC"]) {
                $arFilter["TIMESTAMP_X_1"] = $arAgent["LAST_EXEC"];
            } else {
                $objDateTime->add("- " . ($period - 1) . " seconds");
                $arFilter["TIMESTAMP_X_1"] = $objDateTime->toString();
            }

            if ($severities != "") {
                $arFilter["SEVERITY"] = str_replace(",", "|", $severities);
            }

            if ($auditTypes != "") {
                $arFilter["AUDIT_TYPE_ID"] = str_replace(",", "|", $auditTypes);
            }

            $count = 0;
            $arLogInfo = [];
            $queryEventLogs = CEventLog::GetList(["ID" => "DESC"], $arFilter, false);
            while ($arEventLog = $queryEventLogs->Fetch()) {
                $eventAuditTypeId = $arEventLog["AUDIT_TYPE_ID"];
                $eventSeverityCode = $arEventLog["SEVERITY"];
                if ($eventAuditTypeId == self::LOG_ID) {
                    continue;
                }

                if (!isset($arLogInfo[$eventSeverityCode])) {
                    $arLogInfo[$eventSeverityCode] = [
                        "COUNT" => 0,
                        "AUDIT_TYPES" => [

                        ]
                    ];
                }

                if (!isset($arLogInfo[$eventSeverityCode]["AUDIT_TYPES"][$eventAuditTypeId])) {
                    $arLogInfo[$eventSeverityCode]["AUDIT_TYPES"][$eventAuditTypeId] = 0;
                }

                $arLogInfo[$eventSeverityCode]["COUNT"]++;
                $arLogInfo[$eventSeverityCode]["AUDIT_TYPES"][$eventAuditTypeId]++;
                $count++;
            }

            if ($count > 0) {
                $detailMsg = self::getOption("MESSAGE_PREFIX");
                if (self::getOption("MESSAGE_PREFIX") != "") {
                    $detailMsg .= "\n\n";
                }

                $detailMsg .= Loc::getMessage("DBDEV_TGEVENTS_LIB_MAIN_TG_MESSAGE_PERIOD", [
                    "#DATA_1#" => $arFilter["TIMESTAMP_X_1"],
                    "#DATA_2#" => $arFilter["TIMESTAMP_X_2"],
                ]);
                $detailMsg .= "\n\n";
                $detailMsg .= Loc::getMessage("DBDEV_TGEVENTS_LIB_MAIN_TG_MESSAGE", ["#COUNT#" => $count]);

                $detailMsgType = self::getOption("MESSAGE_DETAIL");
                if ($detailMsgType == "1" || $detailMsgType == "2") {
                    foreach ($arLogInfo as $severityCode => $arData) {
                        $detailMsg .= "\n\n$severityCode: {$arData["COUNT"]}";
                        if ($detailMsgType == "2") {
                            foreach ($arData["AUDIT_TYPES"] as $auditTypeId => $auditCount) {
                                $detailMsg .= "\n\t$auditTypeId: $auditCount";
                            }
                        }
                    }
                }

                $url = self::getOption("URL") . "/bitrix/admin/event_log.php?" . http_build_query([
                        "PAGEN_1" => "1",
                        "SIZEN_1" => "20",
                        "lang" => CSite::GetDefSite(),
                        "set_filter" => "Y",
                        "adm_filter_applied" => "0",
                        "find_type" => "audit_type_id",
                        "find_timestamp_x_1" => $arFilter["TIMESTAMP_X_1"],
                        "find_timestamp_x_2" => $arFilter["TIMESTAMP_X_2"],
                        "find_severity" => $severities != "" ? explode(",", $severities) : ["NOT_REF"],
                        "find_audit_type" => $auditTypes != "" ? explode(",", $auditTypes) : ["NOT_REF"],
                    ]);

                self::sendMessage($detailMsg, $url);
            }
        }
        return "\\DBDevTgEvents\\Main::checkEvents();";
    }

    public static function sendMessage(string $message, string $url = ""): string
    {
        $error = "";
        if (empty($token = trim(self::getOption("TOKEN")))) {
            $error = Loc::getMessage("DBDEV_TGEVENTS_LIB_MAIN_TG_MISSING_TOKEN");
        } elseif (empty($adminsId = self::getOption("ADMINS"))) {
            $error = Loc::getMessage("DBDEV_TGEVENTS_LIB_MAIN_TG_MISSING_ADMINS");
        } else {
            $arAdmins = explode(",", $adminsId);
            foreach ($arAdmins as $adminId) {
                if ((strpos($adminId, ":")) !== false) {
                    $info = explode(":", $adminId);
                    $adminId = $info[0];
                    $topicId = $info[1];
                }

                $arRequest = ["chat_id" => $adminId, "text" => $message];

                if (isset($topicId)) {
                    $arRequest["message_thread_id"] = $topicId;
                }

                if (!empty($url)) {
                    $arRequest["reply_markup"] = json_encode([
                        "inline_keyboard" => [
                            [
                                [
                                    "text" => Loc::getMessage("DBDEV_TGEVENTS_LIB_MAIN_TG_BUTTON"),
                                    "url" => $url,
                                ]
                            ]
                        ],
                    ]);
                }

                $httpClient = new HttpClient();
                $response = $httpClient->get("https://api.telegram.org/bot$token/sendMessage?" .
                    http_build_query($arRequest));
                if ($response) {
                    $arResponse = json_decode($response, true);
                    if (isset($arResponse["ok"])) {
                        if ($arResponse["ok"] != 1) {
                            $error = Loc::getMessage("DBDEV_TGEVENTS_LIB_MAIN_TG_API_ERROR") .
                                "[{$arResponse["error_code"]}] {$arResponse["description"]}";
                        }
                    } else {
                        $error = Loc::getMessage("DBDEV_TGEVENTS_LIB_MAIN_TG_RESPONSE_ERROR");
                    }
                } else {
                    $error = Loc::getMessage("DBDEV_TGEVENTS_LIB_MAIN_TG_REQUEST_ERROR");
                    $arErrors = $httpClient->getError();
                    if (is_array($arErrors) && !empty($arErrors)) {
                        $error .= json_encode($httpClient->getError());
                    }
                }
            }
        }

        if (self::getOption("LOG_ACTIVE") == "Y" && $error != "") {
            CEventLog::Add([
                "SEVERITY" => "ERROR",
                "AUDIT_TYPE_ID" => self::LOG_ID,
                "MODULE_ID" => self::MODULE_ID,
                "DESCRIPTION" => $error,
            ]);
        }

        return $error;
    }
}
