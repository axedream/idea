��� ������ ������� ������� ����������:

1. ��������� ���������������� ���� conf/db.php
	'host' 		=> '��� ����� ���� ������',
	'port'		=> '���� ���� ������',
	'user' 		=> '��� ������������ ���� ������',
	'password' 	=> '������ ���� ������',

2. C������ ������� ���������� ����:

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
