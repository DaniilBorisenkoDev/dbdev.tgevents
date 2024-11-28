<?php

$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_TITLE"] = "Настройки";

$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_GROUP1"] = "Настройки модуля";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_1"] = "<b>Путь до корня сайта</b> необходим для правильной генерации ссылки " .
    "в сообщении от Telegram бота. Путь необходимо указывать вместе с протоколом http(s) и портом (если таковой " .
    "имеется)";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_ACTIVE"] = "Модуль активен";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_URL"] = "Путь до корня сайта";

$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_GROUP2"] = "Настройки Telegram";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_2_1"] = "Для получения идентификатора чата/группы/канала можно " .
    "воспользоваться ботами, например Get My ID. Чаты групп обычно начинаются со знака \"-\", а супер-групп с \"-100\"";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_2_2"] = "Если необходимо отправить сообщение в конкретный топик группы, " .
    "укажите его ID через двоеточие. Например: -1002223334445:1234";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_2_3"] = "Для отправки тестового сообщения, нажмите на кнопку, предварительно " .
    "сохранив настройки: #BUTTON#";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_2_3_1"] = "Отправить";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_TOKEN"] = "Токен Telegram бота";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_ADMINS"] = "Список чатов для отправки (через запятую)";

$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_GROUP3"] = "Настройки отслеживания";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_3_1"] = "<b>Период проверки</b> не может быть меньше 1 секунды. Если период " .
    "проверки изменён, то следующая проверка будет выполнена в ближайшую проверку агентов. <b>Внимание!</b> " .
    "Если агенты выполняются на cron, то период проверки не может быть меньше, указанного в настройках cron и будет " .
    "кратно этому времени. Если агенты настроены на хитах, время проверки может быть больше указанного, если " .
    "на сайте не будет активных клиентов";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_3_2"] = "Если не выбрано ни одно значение в полях " .
    "<b>Отслеживаемые типы/важности событий</b>, будет автоматически выбрано значение по умолчанию";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_PERIOD"] = "Период проверки (в секундах)";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_AUDIT_TYPES"] = "Отслеживаемые типы событий";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_SEVERITIES"] = "Отслеживаемые важности событий";

$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_GROUP4"] = "Настройки отправляемого сообщения";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_4_1"] = "Если заполнен параметр " .
    "<b>Дополнительный текст в начало отправляемого сообщения</b>, то введённый текст будет расположен в начале " .
    "каждого отправляемого сообщения";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_4_2"] = "Параметром <b>Информативность сообщения</b> можно регулировать то, " .
    "насколько подробным будет присылаемое сообщение. В первом случае будет отправлено только количество новых " .
    "сообщений. Во втором будет добавлена информация по количеству сообщений по каждой срочности. В третьем будут " .
    "добавлены идентификаторы событий с их количеством сообщений";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_MESSAGE_PREFIX"] = "Дополнительный текст в начало отправляемого сообщения";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_MESSAGE_DETAIL"] = "Информативность сообщения";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_MESSAGE_DETAIL_0"] = "Только количество новых событий";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_MESSAGE_DETAIL_1"] = "Предыдущее + информация по срочности событий";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_MESSAGE_DETAIL_2"] = "Предыдущее + информация по ID событий";

$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_GROUP5"] = "Настройки логирования";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_5_1"] = "Если параметр <b>Логирование включено</b> активирован, то в журнал " .
    "событий будут записываться ошибки запросов к Telegram API. Записываемые ошибки будут исключены из отслеживания " .
    "данным модулем";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_NOTE_5_2"] = "<a href=\"#URL#\" target=\"_blank\">Посмотреть лог</a>";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB1_LOG_ACTIVE"] = "Логирование включено";

$MESS["DBDEV_TGEVENTS_OPTIONS_TAB2_TITLE"] = "Поддержка";
$MESS["DBDEV_TGEVENTS_OPTIONS_TAB2_SUPPORT_INFO"] = "Свои вопросы по работе модуля либо по доработке функционала " .
    "можно отправить по электронной почте #EMAIL#, либо заполнив форму на сайте #SITE#";

$MESS["DBDEV_TGEVENTS_OPTIONS_BUTTON_APPLY"] = "Применить";
$MESS["DBDEV_TGEVENTS_OPTIONS_BUTTON_DEFAULT"] = "По умолчанию";
$MESS["DBDEV_TGEVENTS_OPTIONS_BUTTON_DEFAULT_CONFIRM"] = "Вы уверены? Все сохранённые настройки будут сброшены!";

$MESS["DBDEV_TGEVENTS_OPTIONS_SAVE_AGENTS_ERROR"] = "Во время сохранения агента произошла неизвестная ошибка";
$MESS["DBDEV_TGEVENTS_OPTIONS_TG_TEST_MESSAGE"] = "Тестовое сообщение";
$MESS["DBDEV_TGEVENTS_OPTIONS_TG_TEST_MESSAGE_SUCCESS"] = "Тестовое сообщение успешно отправлено";
$MESS["DBDEV_TGEVENTS_OPTIONS_TG_TEST_MESSAGE_ERROR"] = "Ошибка отправки тестового сообщения: #ERROR#";
