<?php

$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_TITLE"] = "Settings";

$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_GROUP1"] = "Module settings";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_1"] = "<b>Path to the site root</b> is necessary for correct generation of " .
    "the link in the message from the Telegram bot. The path must be specified together with the http(s) protocol " .
    "and the port (if any)";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_ACTIVE"] = "The module is active";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_URL"] = "Path to the site root";

$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_GROUP2"] = "Telegram settings";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_2_1"] = "To get the chat/group/channel ID, you can use bots, for example " .
    "Get My ID. Group chats usually start with a \"-\" sign, and super groups with \"-100\"";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_2_2"] = "If you need to send a message to a specific topic in a group, " .
    "specify its ID separated by a colon. For example: -1002223334445:1234";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_2_3"] = "To send a test message, click on the button, having previously " .
    "saved the settings: #BUTTON#";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_2_3_1"] = "Send";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_TOKEN"] = "Telegram bot Token";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_ADMINS"] = "List of chats to send (comma separated)";

$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_GROUP3"] = "Tracking settings";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_3_1"] = "<b>Check period</b> cannot be less than 1 second. If the check " .
    "period is changed, the next check will be performed at the next agent check. <b>Attention!</b> If agents are " .
    "executed on cron, the check period cannot be less than specified in the cron settings and will be a multiple of " .
    "this time. If agents are configured on hits, the check time may be longer than specified if there are no active " .
    "clients on the site";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_3_2"] = "If no value is selected in the <b>Event Types/Severities to " .
    "Track</b> fields, the default value will be automatically selected";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_PERIOD"] = "Check period (in seconds)";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_AUDIT_TYPES"] = "Event types to Track";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_SEVERITIES"] = "Event severities to Track";

$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_GROUP4"] = "Settings for the message being sent";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_4_1"] = "If the <b>Additional text to the beginning of the sent message</b> " .
    "parameter is filled in, the entered text will be placed at the beginning of each sent message";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_4_2"] = "The <b>Message Informativeness</b> parameter can be used to control " .
    "how detailed the message sent will be. In the first case, only the number of new messages will be sent. In the " .
    "second case, information on the number of messages for each urgency will be added. In the third case, event " .
    "identifiers with their number of messages will be added";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_MESSAGE_PREFIX"] = "Additional text to the beginning of the message being sent";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_MESSAGE_DETAIL"] = "Informativeness of the message";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_MESSAGE_DETAIL_0"] = "Only the number of new events";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_MESSAGE_DETAIL_1"] = "Previous + information on the urgency of events";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_MESSAGE_DETAIL_2"] = "Previous + information by event ID";

$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_GROUP5"] = "Logging settings";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_5_1"] = "If the <b>Logging enabled</b> parameter is activated, then errors " .
    "of requests to Telegram API will be written to the event log. The errors written will be excluded from tracking " .
    "by this module";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_5_2"] = "<a href=\"#URL#\" target=\"_blank\">View log</a>";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_LOG_ACTIVE"] = "Logging is enabled";

$MESS["DBDEV_TGEVENTS_OPTIONS_TAB2_TITLE"] = "Support";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB2_SUPPORT_INFO"] = "You can send your questions about the module operation or about " .
    "the functionality improvements by email to #EMAIL#, or by filling out the form on the #SITE# website";

$MESS["DBDEV_TGEVENTS_OPTIONS_BUTTON_APPLY"] = "Apply";
$MESS["DBDEV_TGEVENTS_OPTIONS_BUTTON_DEFAULT"] = "Set default";
$MESS["DBDEV_TGEVENTS_OPTIONS_BUTTON_DEFAULT_CONFIRM"] = "Are you sure? All saved settings will be reset!";

$MESS["DBDEV_TGEVENTS_OPTIONS_SAVE_AGENTS_ERROR"] = "An unknown error occurred while saving the agent";
$MESS["DBDEV_TGEVENTS_OPTIONS_TG_TEST_MESSAGE"] = "Test message";
$MESS["DBDEV_TGEVENTS_OPTIONS_TG_TEST_MESSAGE_SUCCESS"] = "Test message sent successfully";
$MESS["DBDEV_TGEVENTS_OPTIONS_TG_TEST_MESSAGE_ERROR"] = "Error sending test message: #ERROR#";
