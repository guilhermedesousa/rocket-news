<?php

session_start();

use src\DatabaseConnection;
use app\controllers\EmailController;

define('ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);

require_once ROOT_PATH . 'app/src/DatabaseConnection.php';
require_once ROOT_PATH . 'app/src/Validation.php';
require_once ROOT_PATH . 'app/src/ValidationEmail.php';
require_once ROOT_PATH . 'app/models/Email.php';

// Connect to a MySQL database using driver invocation
DatabaseConnection::connect('localhost', 'rocket_news', 'root', '');
$dbh = DatabaseConnection::getInstance();
$dbc = $dbh->getConnection();

$action = $_POST['action'] ?? 'default';
$controllerFile = ROOT_PATH . 'app/controllers/EmailController.php';

include $controllerFile;

$controller = new EmailController();
$controller->dbc = $dbc;
$controller->runAction($action);