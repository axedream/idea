<?php
namespace idea;
//--базовый класс для работы и взаимодействия объектов приложения--//

class Core extends Singleton {
//    class Core {

    public $config = array();   //массив конфигурации системы
    public $router = array();   //массив строки запроса пользователя
    public $request = array();  //массив запросов GET, POST


    //метод инициализации переменных конфигцрации
    public function readConfig() {
        $this->config = include CONF.'config.php';
        }

    //метод получение параметро запроса пользователя
    public function getParamRequest() {
        $this->router['all']  = $_SERVER['REQUEST_URI'];
        }

    //метод парсинга запроса пользователя (предполагаем что максимальная длинна запроса /controller/action/id
    public function parserParamRequest() {
        $_temp = explode('/', $this->router['all']);

        //контроллер
        if (!empty($_temp[1])){
            if ($this->config['regexp']['core']['controller'])
            if (preg_match($this->config['regexp']['core']['controller'], trim($_temp[1]))) $this->router['controller']=$_temp[1];
            }

        //действие
        if (!empty($_temp[2])){
            if ($this->config['regexp']['core']['action'])
            if (preg_match($this->config['regexp']['core']['action'], trim($_temp[2]))) $this->router['action']=$_temp[2];;
            }

        //ид (ID)
        if (!empty($_temp[3])){
            if ($this->config['regexp']['core']['id'])
            if (preg_match($this->config['regexp']['core']['id'], trim($_temp[3]))) $this->router['id']=$_temp[3];;
            }
        }

    //установка дефолтных значений роутинга (controller=TRUE,action=TRUE,id=TRUE)
    public function setDefaultValue ($p1=FALSE,$p2=FALSE,$p3=FALSE) {
        if ($p1) $this->router['controller']     = $this->config['default']['contorller'];
        if ($p2) $this->router['action']         = $this->config['default']['action'];
        if ($p3) $this->router['id']             = $this->config['default']['id'];
        }

    //функция тестирования различных методов (с отключенным дефолтным отображением)
    public function test($key) {
        if ($key=="routing") {
            $this->readConfig();                        //инициализируем чтение конфигурации
            $this->setDefaultValue(TRUE,TRUE,TRUE);     //устанавливаем значения конроллера, действия, ИД по умолчанию
            $this->getParamRequest();                   //получаем параметры запроса пользователя
            $this->parserParamRequest();                //парсим параметры запроса пользователя
            }//end key=ROUTING


        echo "<pre>";
        var_dump($this->config);
        echo "<br>";
        var_dump($this->router);
        echo "</pre>";

        }//end function test()
    }
