<?php

require 'vendor/autoload.php';
require 'model/Topic.php';
require 'model/Topic.php';
require 'model/TopicRepository.php';
require 'model/User.php';
require 'model/UserRepository.php';
require 'api/UserApi.php';
require 'api/TopicApi.php';

try {
    $db = new PDO("mysql:host=localhost;dbname=thesis", "root");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die;
}

if (isset($_REQUEST['controller'])) {
    $controller_name = $_REQUEST['controller'];
} else {
    $controller_name = "TopicApi";
}

if (isset($_REQUEST['action'])) {
    $action_name = $_REQUEST['action'];
} else {
    $action_name = "defaultAction";
}

$controller = new $controller_name();
$controller->$action_name();