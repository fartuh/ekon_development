<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if(!isset($_GET['page']) || $_GET['page'] == ''){
    header("Location: ?page=home");   
    exit();
}
session_start();
//defines
define("ROOT", getcwd());
define("CONTROLLERS", ROOT . "/controllers");
define("CORE", ROOT . "/core");
define("CONFIG", ROOT . "/config");
define("DB", ROOT . "/db");
define("MODELS", ROOT . "/models");
define("MIDDLEWARES", ROOT . "/middlewares");

$traits = glob(CORE . '/traits/*.php');
foreach ($traits as $trait) {
    require $trait;
}

//classes
require(CONTROLLERS . "/controller.php");
require(CORE . "/factory.php");


$config['db'] = require (CONFIG . "/config.db.php");

$count = 0;

$routes = require(ROOT . "/routes/routes.php");

$page = $_GET['page'];

foreach($routes as $route => $controller_arr){
    if($route == $page){
        //code
        $controller_r = explode("@", $controller_arr);
        $middlewares = glob(MIDDLEWARES . '/*.php');
        foreach ($middlewares as $md) {
            require $md;
        }
        $middlewares_r = require_once(ROOT . "/routes/middlewares.php");
        foreach($middlewares_r as $md){
            $m = new $md();
            $count_m = 0;
            foreach($controller_r as $middlew){
                if($count_m < 2) {
                    $count_m++;
                    continue;
                }
                if($md != $middlew) continue;
                $pass = $m->pass(['get' => $_GET, 'post' => $_POST]);
                if($pass != true){
                    if(method_exists($m, 'failed')){
                        $m->failed();
                        die();
                    }
                    die("Ошибка");
                }
            }
        }
        require_once(CONTROLLERS . '/' . $controller_r[0] . ".php");
        $controller = Core\Factory::getController($controller_r[0]);
        
        //var_dump($controller);
        $method = $controller_r[1];
        if($config['db']['use'] == true){
            global $db;
                require(DB . "/db.php");
                $db = new db\db($config['db']);
                $models = glob(MODELS . '/*.php');
                foreach ($models as $model_) {
                    require $model_;
                }
        }
        $controller->$method($_GET);

        if($config['db']['use'] == true){
            $db->close($db->link);
        }
        //count
        $count++;
    }    
}
if($count == 0){
    echo "Страница не найдена";
}
