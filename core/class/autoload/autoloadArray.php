<?php
class eArray extends Singleton{
	public static $instance; // Состояние класса.
	public $Array; // Массив, который был передан классу.

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
            $error = 'К сожалению вы передали не массив.';
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
            $error = 'Отсутствует ключ ('.$index.') в массиве';
            throw new Exception($error);
        }
    }

    public function arrayReturn(){
        return $this->Array;
    }	

}
	//красивое представление многомерного массива
	
function eA($newArray){
	return eArray::getInstance()->loadArray($newArray);
}
	