<?php
class eArray extends Singleton{
	private static $instance; // ��������� ������.
	private $Array; // ������, ������� ��� ������� ������.

	function __construct(){}
	
	public static function getInstance(){
		if(null === self::$instance) self::$instance = new self();
		return self::$instance;
	}

	public function loadArray($newArray){
        if(is_array($newArray)){
            $this->Array = $newArray;
            return $this;
        }else{
            $error = '� ��������� �� �������� �� ������.';
            throw new Exception($error);
        }
    }
	
    public function __get($index){
        if(isset($this->Array[$index])){
            if(is_array($this->Array[$index])){
                $this->loadArray($this->Array[$index]);
                
                return $this;
            }else{
                return $this->Array[$index];
            }
        }else{
            $error = '����������� ���� ('.$index.') � �������';
            throw new Exception($error);
        }
    }

    public function arrayReturn(){
        return $this->Array;
    }	

	public function eA($newArray){
		return self::getInstance()->loadArray($newArray);
	}
}
	//�������� ������������� ������������ �������
	/*
	function easyA($newArray){
		return easyArray::getInstance()->loadArray($newArray);
	}
	*/