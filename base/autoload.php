<?php
namespace idea;
//--���� ������������ �������--//

//������ ��� ������� ������� ����� ������������
function baseAutoload($class) {
    $class = str_replace('idea\\','',$class);           //�������� namespace
    $file = mb_strtolower(BCLASS.$class.'.php');        //������� ������ ����
	if( file_exists($file) == false ) return false;     //�������� ��� �� �������������, ���� ��� �� ���������� ���
	require_once ($file);                               //���� ���� ���������� ����

}

spl_autoload_register(__NAMESPACE__.'\\baseAutoload');

