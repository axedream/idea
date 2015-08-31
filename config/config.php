<?php
namespace idea;
//--файл загрузки конфигурационных файлов--//

return array (
    'mysqldb'       =>      include \idea\CONF.'mysqldb.php',      //  настройки mysql
    'regexp'        =>      include \idea\CONF.'regexp.php',       //  регулярные выражения
    'message'       =>      include \idea\CONF.'message.php',      //  сообщения
    'default'       =>      include \idea\CONF.'default.php',      //  дефолтные настройки для контроллеров, отображений...
    'head'          =>      include \idea\CONF.'head.php',         //  теги заголовка страницы
);