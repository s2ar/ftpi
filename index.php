<?php
//error_reporting(E_ALL | E_STRICT) ;
//ini_set('display_errors', 'On');
// Используем автозагрузчик
require_once 'libs/Bootstrap.php';
require_once 'libs/Controller.php';
require_once 'libs/Model.php';
require_once 'libs/View.php';

//require_once 'libs/config/paths.php';
require_once 'libs/config/config.php';
require_once 'libs/config/database.php';

require_once 'libs/Session.php';

$app = new Bootstrap();