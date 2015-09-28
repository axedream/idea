<?php
//--базовый класс для работы и взаимодействия объектов приложения--//

class Core extends Singleton {
//class Core {

    public $config = array();   //массив конфигурации системы
    public $router = array();   //массив строки запроса пользователя
    public $request = array();  //массив запросов GET, POST


    //метод инициализации переменных конфигцрации
    public function readConfig() {
        $this->config = include CONF.'config.php';
        }

    //метод получение параметро запроса пользователя и остальных данных
    public function getParamRequest() {
        $this->router['all']    = trim($_SERVER['REQUEST_URI']);            //строка после хоста
        $this->router['host']   = trim($_SERVER["HTTP_HOST"]);              //строка до параметров, напранная польхователем
        $this->router['ip']     = trim($_SERVER["REMOTE_ADDR"]);            //ip адресс пользователя
        }

    //метод парсинга запроса пользователя (предполагаем что максимальная длинна запроса /controller/action/id
    public function parserParamRequest() {
        $_temp = explode('/', $this->router['all']);

        //обязательная проверка по регулярному выражению из конфигурационного файла
        //если проверка прошла присваиваем новые значения

        //контроллер
        if (!empty($_temp[1])){
            if ($this->config['regexp']['core']['controller'])
            if (preg_match($this->config['regexp']['core']['controller'], trim($_temp[1]))) $this->router['controller']= mb_strtolower($_temp[1]);
            }

        //действие
        if (!empty($_temp[2])){
            if ($this->config['regexp']['core']['action'])
            if (preg_match($this->config['regexp']['core']['action'], trim($_temp[2]))) $this->router['action']= mb_strtolower($_temp[2]);
            }

        //ид (ID)
        if (!empty($_temp[3])){
            if ($this->config['regexp']['core']['id'])
            if (preg_match($this->config['regexp']['core']['id'], trim($_temp[3]))) $this->router['id']= mb_strtolower($_temp[3]);
            }
        }

    //выполнение контроллера, действия с передачей параметра Id в конструктор пользовательского объекта
    public function execConActId(){
        //логирование на экран =1
        $i=FALSE;
        //$i=TRUE;

        //устанавливаем ментроллер и метод полученный из URL
		$controller	= ucfirst($this->router['controller']);             //преобразуем первый символ контроллера в верхний регистр
        $action     = mb_strtolower($this->router['action']);
        if ($i) {
            echo "Контроллер1: ".$controller."<br>";
            echo "Действие1: ".$action."<br>";
            }

        if(method_exists($controller, $action)) {                       //проверяем существование контроллера и метода в нем
            if ($i) echo "Выполняется алгоритм 1<br>";
			$controller = new $controller;                              //создаем объект
			$controller->$action($this->router['id']);                  //выполняем метод переданный пользователем
            }
        else {                                                          //если метода  не существует оставляем тот же контроллер но пробуем дефолтный метод else 1
            $action = $this->config['default']['action'];               //дефолтный метод
            if ($i) {
                echo "Контроллер2: ".$controller."<br>";
                echo "Действие2: ".$action."<br>";
                }
            if(method_exists($controller, $action)) {
                if ($i) echo "Выполняется алгоритм 2<br>";
                $controller = new $controller;                          //дефолтный объект
                $controller->$action($this->router['id']);              //выполняем дефолтный метод, дефолтного класса с заданным id
                }
            else {                                                      //если дефолтный метод не проходим задаем дефолтный контроллер (он всегда существует так как загружается из модулей приложения) else2
                $controller	= $this->config['default']['contorller'];   //дефолтный контроллер
                $action     = $this->config['default']['action'];       //дефолтный метод
                if ($i) {
                    echo "Контроллер3: ".$controller."<br>";
                    echo "Действие3: ".$action."<br>";
                    }
                if(method_exists($controller, $action)) {               //если и дефолтынй контроллер/метод не найден выдаем сообщение об ошибке
                    if ($i) echo "Выполняется алгоритм 3<br>";
                    $controller = new $controller;
                    $controller->$action($this->router['id']);
                    }
                else {
                    if ($i) echo "Ошибка<br>";
                    die ($this->config['message']['error']['core']['defaultController']);
                    }
                }//end ekse 2
            }//end else 1
        }//end function execConActId;

    //метод групповой обработки событий (старт запуска сайта как единого приложения)
    public function run() {
        $this->readConfig();                            //инициализируем чтение конфигурации
        //$this->setDefaultValue(TRUE,TRUE,TRUE);         //устанавливаем значения конроллера, действия, ИД по умолчанию
        $this->getParamRequest();                       //получаем параметры запроса пользователя
        $this->parserParamRequest();                    //парсим параметры запроса пользователя
        $this->execConActId();                          //попытка выполнения контроллера, действия пользователя, либо дефолтного контроллера
        }//end fucntio run()

    //функция тестирования различных методов (с отключенным дефолтным отображением)
    public function test($key=FALSE) {
        if ($key=="routing") {
            $this->readConfig();
            $this->setDefaultValue(TRUE,TRUE,TRUE);
            $this->getParamRequest();
            $this->parserParamRequest();

            echo "<pre>";
            var_dump($this->config);
            echo "<br>";
            var_dump($this->router);
            echo "</pre>";
            }//end key=ROUTING
        }//end function test()
    }
