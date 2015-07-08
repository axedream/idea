Для работы данного сервиса необходимо:

1. Настроить конфигурационный файл conf/db.php
	'host' 		=> 'Имя хоста базы данных',
	'port'		=> 'Порт базы данных',
	'user' 		=> 'Имя пользователя базы данных',
	'password' 	=> 'Пароль базы данных',

2. Cоздать таблицу следующего вида:

CREATE TABLE xiag.xiag_sl (
  id int(11) NOT NULL AUTO_INCREMENT,
  hesh varchar(100) NOT NULL,
  gen varchar(10) NOT NULL,
  `real` text NOT NULL,
  dcreate datetime DEFAULT NULL,
  dip varchar(15) DEFAULT NULL,
  PRIMARY KEY (id, hesh)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci;
