<?php

use Bitrix\Main\Config\Option;
use Bitrix\Main\EventManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

class dbdev_tgevents extends CModule
{
    var $MODULE_ID = "dbdev.tgevents";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;
    private array $defaultConfiguration = [];

    public function __construct()
    {
        if (is_file(__DIR__ . "/version.php")) {
            include(__DIR__ . "/version.php");
            if (isset($arModuleVersion) && is_array($arModuleVersion)) {
                if (array_key_exists("VERSION", $arModuleVersion)) {
                    $this->MODULE_VERSION = $arModuleVersion["VERSION"];
                }
                if (array_key_exists("VERSION_DATE", $arModuleVersion)) {
                    $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
                }
            }
        }

        if (is_file(__DIR__ . "/defaults.php")) {
            include(__DIR__ . "/defaults.php");
            if (isset($arModuleDefaultConfig) && is_array($arModuleDefaultConfig)) {
                $this->defaultConfiguration = $arModuleDefaultConfig;
            }
        }

        $this->MODULE_NAME = Loc::getMessage("DBDEV_TGEVENTS_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("DBDEV_TGEVENTS_MODULE_DESCRIPTION");
        $this->PARTNER_NAME = Loc::getMessage("DBDEV_TGEVENTS_MODULE_PARTNER_NAME");
        $this->PARTNER_URI = "https://daniilborisenko.dev/";
    }

    public function doInstall()
    {
        global $APPLICATION;

        if (CheckVersion(ModuleManager::getVersion("main"), "14.00.00")) {
            $this->installFiles();
            $this->installDB();
            ModuleManager::registerModule($this->MODULE_ID);
            $this->InstallOptions();
            $this->InstallEvents();
            $this->InstallAgents();
        } else {
            $APPLICATION->ThrowException(
                Loc::getMessage("DBDEV_TGEVENTS_INSTALL_ERROR_VERSION")
            );
        }

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage("DBDEV_TGEVENTS_INSTALL_TITLE") . " \"" .
            Loc::getMessage("DBDEV_TGEVENTS_MODULE_NAME") . "\"",
            __DIR__ . "/step.php"
        );
    }

    public function installFiles()
    {
    }

    public function installDB()
    {
    }

    public function installOptions()
    {
        foreach ($this->defaultConfiguration as $code => $value) {
            Option::set($this->MODULE_ID, $code, $value);
        }
    }

    public function installEvents()
    {
        EventManager::getInstance()->registerEventHandler(
            "main",
            "OnEventLogGetAuditTypes",
            $this->MODULE_ID,
            "\\DBDevTgEvents\\Main",
            "onEventLogGetAuditTypes"
        );
    }

    public function installAgents()
    {
    }

    public function doUninstall()
    {
        global $APPLICATION;

        $this->UnInstallFiles();
        $this->UnInstallDB();
        $this->UnInstallEvents();
        $this->UnInstallAgents();
        $this->UnInstallOptions();

        ModuleManager::unRegisterModule($this->MODULE_ID);

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage("DBDEV_TGEVENTS_UNINSTALL_TITLE") . " \"" .
            Loc::getMessage("DBDEV_TGEVENTS_MODULE_NAME") . "\"",
            __DIR__ . "/unstep.php"
        );
    }

    public function unInstallFiles()
    {
    }

    public function unInstallDB()
    {
    }

    public function unInstallEvents()
    {
        EventManager::getInstance()->unRegisterEventHandler(
            "main",
            "OnEventLogGetAuditTypes",
            $this->MODULE_ID,
            "\\DBDevTgEvents\\Main",
            "OnEventLogGetAuditTypes"
        );
    }

    public function unInstallAgents()
    {
        CAgent::RemoveModuleAgents($this->MODULE_ID);
    }

    public function unInstallOptions()
    {
        Option::delete($this->MODULE_ID);
    }
}
