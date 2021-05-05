<?php
session_start();

use App\Controllers\ShopController;

require_once "Controllers/ShopController.php";

if (isset($_GET['method'])) {
    $controller = new ShopController();
    if (method_exists($controller, $_GET['method'])) {
        $_SESSION['data'] = $controller->{$_GET['method']}($_POST);
    }
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
