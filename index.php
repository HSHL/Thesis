<?php

require 'vendor/autoload.php';
require 'model/ValidationError.php';
require 'model/Topic.php';
require 'model/TopicRepository.php';
require 'controller/TopicController.php';
require 'model/User.php';
require 'model/UserRepository.php';
require 'controller/UserController.php';

$smarty = new Smarty();
$smarty->template_dir = "view";
$smarty->compile_dir = "compile";
$smarty->cache_dir = "cache";

try {
    $db = new PDO("mysql:host=localhost;dbname=thesis", "root");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die;
}

session_start();

if (isset($_SESSION['user_id'])) {
    $repo = new UserRepository();
    $current_user = $repo->getUser($_SESSION['user_id']);
    $smarty->assign("current_user", $current_user);
} else {
    $current_user = NULL;
}

if (isset($_REQUEST['controller'])) {
    $controller_name = $_REQUEST['controller'];
} else {
    $controller_name = "TopicController";
}

if (isset($_REQUEST['action'])) {
    $action_name = $_REQUEST['action'];
} else {
    $action_name = "defaultAction";
}

$content = "";
$controller = new $controller_name();
$controller->$action_name($content);
$smarty->assign("body_content", $content);
$smarty->display("main.html");