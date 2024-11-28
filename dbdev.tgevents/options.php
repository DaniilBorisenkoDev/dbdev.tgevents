<?php

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

use Bitrix\Main\Config\Option;
use Bitrix\Main\HttpApplication;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use DBDevTgEvents\Main as DBMain;

if ($USER->IsAdmin()) :
    $request = HttpApplication::getInstance()->getContext()->getRequest();
    $module_id = htmlspecialcharsbx($request["mid"] != "" ? $request["mid"] : $request["id"]);
    Loader::includeModule($module_id);

    $arModuleDefaultConfiguration = [];
    if (is_file(__DIR__ . "/install/defaults.php")) {
        include(__DIR__ . "/install/defaults.php");
        if (isset($arModuleDefaultConfig) && is_array($arModuleDefaultConfig)) {
            $arModuleDefaultConfiguration = $arModuleDefaultConfig;
        }
    }

    $noteHelperFunction = function (string|array $info, array $replaces = []): array {
        if (!is_array($info)) {
            $info = [$info];
        }

        $result = "";

        foreach ($info as $item) {
            $result .= "<p>" .
                (Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_" . $item, $replaces[$item] ?? [])) .
                "</p>";
        }
        return ["note" => $result];
    };

    $aTabs = [
        [
            "DIV" => "tabSettings",
            "TAB" => Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB1_TITLE"),
            "TITLE" => Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB1_TITLE"),
            "OPTIONS" => [
                /** Group 1 */
                Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB1_GROUP1"),
                $noteHelperFunction("1"),
                [
                    "ACTIVE",
                    Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB1_ACTIVE"),
                    $arModuleDefaultConfiguration["ACTIVE"] ?? "",
                    ["checkbox"]
                ],
                [
                    "URL",
                    Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB1_URL"),
                    $arModuleDefaultConfiguration["URL"] ?? "",
                    ["text", 70]
                ],

                /** Group 2 */
                Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB1_GROUP2"),
                $noteHelperFunction(["2_1", "2_2", "2_3"], ["2_3" => [
                    "#BUTTON#" =>
                        "<button class=\"adm-btn adm-btn-save\" name=\"send-tg-example\" value=\"1\">" .
                        Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_2_3_1") . "</button>"]]),
                [
                    "TOKEN",
                    Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB1_TOKEN"),
                    $arModuleDefaultConfiguration["TOKEN"] ?? "",
                    ["text", 70]
                ],
                [
                    "ADMINS",
                    Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB1_ADMINS"),
                    $arModuleDefaultConfiguration["ADMINS"] ?? "",
                    ["text", 70]
                ],

                /** Group 3 */
                Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB1_GROUP3"),
                $noteHelperFunction(["3_1", "3_2"]),
                [
                    "PERIOD",
                    Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB1_PERIOD"),
                    $arModuleDefaultConfiguration["PERIOD"] ?? "",
                    ["text", 70]
                ],
                [
                    "AUDIT_TYPES",
                    Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB1_AUDIT_TYPES"),
                    $arModuleDefaultConfiguration["AUDIT_TYPES"] ?? "",
                    ["multiselectbox", DBMain::getEventTypes()]
                ],
                [
                    "SEVERITIES",
                    Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB1_SEVERITIES"),
                    $arModuleDefaultConfiguration["SEVERITIES"] ?? "",
                    ["multiselectbox", DBMain::getErrorTypes()]
                ],

                /** Group 4 */
                Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB1_GROUP4"),
                $noteHelperFunction(["4_1", "4_2"]),
                [
                    "MESSAGE_PREFIX",
                    Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB1_MESSAGE_PREFIX"),
                    $arModuleDefaultConfiguration["MESSAGE_PREFIX"] ?? "",
                    ["text", 70]
                ],
                [
                    "MESSAGE_DETAIL",
                    Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB1_MESSAGE_DETAIL"),
                    $arModuleDefaultConfiguration["MESSAGE_DETAIL"] ?? "",
                    ["selectbox", [
                        "" => Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB1_MESSAGE_DETAIL_0"),
                        "1" => Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB1_MESSAGE_DETAIL_1"),
                        "2" => Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB1_MESSAGE_DETAIL_2")
                    ]]
                ],

                /** Group 5 */
                Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB1_GROUP5"),
                $noteHelperFunction(["5_1", "5_2"], ["5_2" => ["#URL#" => "/bitrix/admin/event_log.php?" .
                    http_build_query([
                        "PAGEN_1" => "1",
                        "SIZEN_1" => "20",
                        "lang" => CSite::GetDefSite(),
                        "set_filter" => "Y",
                        "adm_filter_applied" => "0",
                        "find_type" => "audit_type_id",
                        "find_severity" => ["NOT_REF"],
                        "find_audit_type" => [DBMain::LOG_ID],
                    ])
                ]]),
                [
                    "LOG_ACTIVE",
                    Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB1_LOG_ACTIVE"),
                    $arModuleDefaultConfiguration["LOG_ACTIVE"] ?? "",
                    ["checkbox"]
                ],
            ]
        ],
        [
            "DIV" => "tabSupport",
            "TAB" => Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB2_TITLE"),
            "TITLE" => Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB2_TITLE"),
            "OPTIONS" => [
                Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB2_TITLE"),
                [
                    "note" => Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TAB2_SUPPORT_INFO", [
                        "#EMAIL#" => "<a href=\"mailto:daniilborisenkodev@gmail.com\">daniilborisenkodev@gmail.com</a>",
                        "#SITE#" => "<a href=\"https://daniilborisenko.dev/\" target=\"_blank\">DaniilBorisenko.dev</a>"
                    ])
                ],
            ]
        ]
    ];

    if ($request->isPost() && check_bitrix_sessid()) {
        if ($request["send-tg-example"] == 1) {
            $error = DBMain::sendMessage(Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TG_TEST_MESSAGE"));
            if ($error == "") {
                CAdminMessage::showNote(Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_TG_TEST_MESSAGE_SUCCESS"));
            } else {
                CAdminMessage::ShowMessage(Loc::getMessage(
                    "DBDEV_TGEVENTS_OPTIONS_TG_TEST_MESSAGE_ERROR",
                    ["#ERROR#" => $error]
                ));
            }
        } else {
            $oldPeriod = DBMain::getOption("PERIOD");
            foreach ($aTabs as $aTab) {
                if (!isset($aTab["OPTIONS"]) || !is_array($aTab["OPTIONS"])) {
                    continue;
                }

                foreach ($aTab["OPTIONS"] as $arOption) {
                    if (!is_array($arOption) || isset($arOption["note"])) {
                        continue;
                    }

                    if ($request["apply"]) {
                        $optionValue = $request->getPost($arOption[0]);
                        if ($arOption[0] == "ACTIVE" || $arOption[0] == "LOG_ACTIVE") {
                            $optionValue = $optionValue == "Y" ? "Y" : "";
                        } elseif ($arOption[0] == "PERIOD") {
                            $optionValue = (int)$optionValue;
                            if ($optionValue < 1) {
                                $optionValue = $arOption[2];
                            }
                        } elseif ($arOption[0] == "URL") {
                            if (is_string($optionValue) && strlen($optionValue) > 0) {
                                while (
                                    strlen($optionValue) > 0 &&
                                    $optionValue[$pos = strlen($optionValue) - 1] == "/"
                                ) {
                                    $optionValue = substr($optionValue, 0, $pos);
                                }
                            }
                            if (is_string($optionValue) && strlen($optionValue) == 0) {
                                $optionValue = $arOption[2];
                            }
                        } elseif ($arOption[0] == "AUDIT_TYPES" || $arOption[0] == "SEVERITIES") {
                            if (is_null($optionValue)) {
                                $optionValue = $arOption[2];
                            } else {
                                if (!is_array($optionValue)) {
                                    $optionValue = [$optionValue];
                                }

                                $newOptionValue = [];
                                foreach ($optionValue as $value) {
                                    if ($value == "") {
                                        $newOptionValue = "";
                                        break;
                                    }

                                    if (isset($arOption[3][1][$value])) {
                                        $newOptionValue[] = $value;
                                    }
                                }

                                $optionValue = $newOptionValue;
                            }
                        } elseif ($arOption[0] == "MESSAGE_DETAIL") {
                            if (!isset($arOption[3][1][$optionValue])) {
                                $optionValue = "";
                            }
                        }

                        Option::set(
                            $module_id,
                            $arOption[0],
                            is_array($optionValue) ? implode(",", $optionValue) : $optionValue
                        );
                    } elseif ($request["default"]) {
                        Option::set($module_id, $arOption[0], $arOption[2]);
                    }
                }
            }

            if (!DBMain::refreshAgent($oldPeriod)) {
                if ($ex = $APPLICATION->GetException()) {
                    $agentSaveError = $ex;
                } else {
                    $agentSaveError = Loc::getMessage("DBDEV_TGEVENTS_OPTIONS_SAVE_AGENTS_ERROR");
                }
                CAdminMessage::ShowMessage($agentSaveError);
            }
        }
    }

    CAdminMessage::ShowMessage(DBMain::showOptionModuleState());
    ?>
    <style>
        #bx-admin-prefix #tabSettings_edit_table .adm-info-message {
            width: 95%;
            text-align: left;
        }

        #bx-admin-prefix #tabSettings_edit_table td.adm-detail-content-cell-l {
            width: 25%;
        }

        #bx-admin-prefix #tabSettings_edit_table td.adm-detail-content-cell-r {
            width: 75%;
        }

        .adm-workarea #tabSettings_edit_table .adm-btn.adm-btn-save:active {
            height: 29px !important;
        }

        #bx-admin-prefix #tabSupport .adm-info-message {
            width: 95%;
            text-align: left;
            padding: 15px 30px 15px 18px;
        }
    </style>
    <?php
    $tabControl = new CAdminTabControl("tabControl", $aTabs, true, false);
    $tabControl->Begin();
    ?>
    <form action="<?= $APPLICATION->GetCurPage() ?>?lang=<?= LANGUAGE_ID ?>&mid=<?= urlencode($module_id) ?>&mid_menu=1"
          method="post">
        <?= bitrix_sessid_post(); ?>
        <?php foreach ($aTabs as $aTab) {
            $tabControl->BeginNextTab();
            if (isset($aTab["OPTIONS"]) && is_array($aTab["OPTIONS"])) {
                __AdmSettingsDrawList($module_id, $aTab["OPTIONS"]);
            }
        }
        $tabControl->Buttons(); ?>
        <input class="adm-btn-save" type="submit" name="apply"
               value="<?= Loc::GetMessage("DBDEV_TGEVENTS_OPTIONS_BUTTON_APPLY"); ?>"/>
        <input type="submit" name="default"
               value="<?= Loc::GetMessage("DBDEV_TGEVENTS_OPTIONS_BUTTON_DEFAULT"); ?>"
               onclick="return confirm('<?= Loc::GetMessage("DBDEV_TGEVENTS_OPTIONS_BUTTON_DEFAULT_CONFIRM"); ?>')"/>
    </form>
    <script>
        (function (d) {
            const tabSupport = d.getElementById("tabSupport");
            if (tabSupport) {
                const msg = tabSupport.querySelector(".adm-info-message");
                if (msg) {
                    msg.parentNode.classList.add("adm-info-message-green");
                }
            }
        })(document)
    </script>
    <?php $tabControl->End();
else :
    CAdminMessage::showMessage(Loc::getMessage("ACCESS_DENIED"));
endif;