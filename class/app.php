<?php
/**
 * Created by PhpStorm.
 * User: Пользователь
 * Date: 15.11.2016
 * Time: 11:10
 * Входной скрипт по умолчанию
 */

class App {

    public function index() {
        View::gi()->title = 'Тест (неавторизированный пользователь)';
        View::gi()->show('form_login',[],0);
    }

}