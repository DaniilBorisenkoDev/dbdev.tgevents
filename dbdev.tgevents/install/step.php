<?php

/** @global CMain $APPLICATION */

use Bitrix\Main\Localization\Loc;

if (!check_bitrix_sessid()) {
    return;
}

if ($errorException = $APPLICATION->getException()) :
    CAdminMessage::showMessage(
        Loc::getMessage("DBDEV_TGEVENTS_STEP_FAILED") . ": " . $errorException->GetString()
    );
else :
    CAdminMessage::showNote(Loc::getMessage("DBDEV_TGEVENTS_STEP_SUCCESS"));
    ?>
    <form action="/bitrix/admin/settings.php">
        <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>"/>
        <input type="hidden" name="mid" value="<?= $_REQUEST["id"] ?>"/>
        <input type="hidden" name="mid_menu" value="1"/>
        <input type="submit" value="<?= Loc::getMessage("DBDEV_TGEVENTS_STEP_SETTINGS") ?>">
    </form>
    <br>
<?php endif; ?>
<form action="<?= $APPLICATION->getCurPage(); ?>">
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>"/>
    <input type="submit" value="<?= Loc::getMessage("DBDEV_TGEVENTS_RETURN_MODULES"); ?>">
</form>