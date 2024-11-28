<?php

/** @global CMain $APPLICATION */

use Bitrix\Main\Localization\Loc;

if (!check_bitrix_sessid()) {
    return;
}

if ($errorException = $APPLICATION->getException()) {
    CAdminMessage::showMessage(
        Loc::getMessage("DBDEV_TGEVENTS_UNSTEP_FAILED") . ": " . $errorException->GetString()
    );
} else {
    CAdminMessage::showNote(
        Loc::getMessage("DBDEV_TGEVENTS_UNSTEP_SUCCESS")
    );
}
?>
<form action="<?= $APPLICATION->getCurPage(); ?>">
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID; ?>"/>
    <input type="submit" value="<?= Loc::getMessage("DBDEV_TGEVENTS_RETURN_MODULES"); ?>">
</form>