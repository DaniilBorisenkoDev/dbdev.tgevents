<?php

$arModuleDefaultConfig = array(
    "ACTIVE" => "",
    "URL" => ($_SERVER["HTTPS"] == "on" ? "https://" : "http://") . $_SERVER["SERVER_NAME"],
    "TOKEN" => "",
    "ADMINS" => "",
    "PERIOD" => "3600",
    "MESSAGE_PREFIX" => "",
    "MESSAGE_DETAIL" => "",
    "SEVERITIES" => "EMERGENCY,CRITICAL,ERROR",
    "AUDIT_TYPES" => "",
    "LOG_ACTIVE" => "",
);
