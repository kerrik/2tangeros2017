<?php

$db_connect['dsn']            = 'mysql:host=2tang-utv-159065.mysql.binero.se;dbname=159065-2tang-utv;';
    $db_connect['username']       = '159065_py15151';
    $db_connect['password']       = '2t4ng[tv';
    $db_connect['driver_options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");

$include = '';
if (isset($_POST['logout'])) {
    unset($_SESSION['user']);
    $include = 'webroot/start.php';
} elseif ($_SERVER['REQUEST_URI'] === '/' || stristr($_SERVER['REQUEST_URI'], '/?') != FALSE) {
    $include = 'webroot/start.php';
} elseif (stristr($_SERVER['REQUEST_URI'], '.php') != FALSE) {
    $include = 'webroot/' . stristr($_SERVER['REQUEST_URI'], '.php', TRUE) . '.php';
} else {
    $include = (stristr($_SERVER['REQUEST_URI'], '?', TRUE) ? stristr($_SERVER['REQUEST_URI'], '?', TRUE) : $_SERVER['REQUEST_URI']);
    $include = "webroot/{$include}.php";
}

$include = (file_exists($include))? $include: 'webroot/error.php';
INCLUDE $include;