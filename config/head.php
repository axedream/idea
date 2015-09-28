<?php
//--теги заголовка страницы--//

return array(
    "ext"       =>      [
                        "js"        =>      [
                                            /*
                                            "bootstrap"         =>      [
                                                                        "directory"         =>          "bootstrap/js/bootstrap.min.js",
                                                                        ],
                                            */
                                            "jquery"            =>      [
                                                                        "directory"         =>          "jquery/jquery-2.1.4.min.js",
                                                                        ],
                                            "phpgrid"           =>      [
                                                                        "directory"         =>          [
                                                                                                        "phpgrid/lib/js/jqgrid/js/i18n/grid.locale-ru.js",
                                                                                                        "phpgrid/lib/js/jqgrid/js/jquery.jqGrid.min.js",
                                                                                                        ],
                                                                        ],
                                            ],
                        "css"       =>      [
                                            "bootstrap"         =>      [
                                                                        "directory"         =>          "bootstrap/css/bootstrap.min.css",
                                                                        ],
                                            "phpgrid"           =>      [
                                                                        "directory"         =>          [
                                                                                                        "phpgrid/lib/js/themes/smoothness/jquery-ui.custom.css",
                                                                                                        "phpgrid/lib/js/jqgrid/css/ui.jqgrid.css",
                                                                                                        ],
                                                                        ],
                                            ],
                        ],

    "local"     =>      [
                        "css"        =>      [
                                            "shop-base.css",
                                            "uppper.css"
                                            ],
                        "js"        =>      [
                                            "shop-base.js",
                                            ],
                        "font"      =>      [
                                            "9MkmcXCF.ttf",
                                            "open-sans.ttf",
                                            ],
                        ],

    "description"   =>  [
                        'text'      =>      'Описание',
                        ],

    "keywords"      =>  [
                        'text'      =>      'Ключевые слова',
                        ],

    "title"         =>  [
                        'text'      =>      'Заголовок сайта',
                        ],

);