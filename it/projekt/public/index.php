<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../config/config.php';
require_once PROJECT_ROOT . '/src/functions.php';
require_once PROJECT_ROOT . '/src/Router.php';

$router = new Router();

$router->add('GET', '/', 'src/views/home.php');
$router->add('GET', '/home', 'src/views/home.php');
$router->add('GET', '/login', 'src/views/login.php');
$router->add('GET', '/register', 'src/views/register.php');
$router->add('GET', '/menu', 'src/views/menu.php');
$router->add('GET', '/about', 'src/views/about.php');
$router->add('GET', '/contact', 'src/views/contact.php');
$router->add('GET', '/logout', 'src/views/logout.php');
$router->add('GET', '/admin', 'public/admin/index.php');
$router->add('GET', '/admin/products', 'public/admin/products.php');
$router->add('GET', '/admin/orders', 'public/admin/orders.php');


$router->add('POST', '/login-action', 'src/actions/login_action.php');
$router->add('POST', '/register-action', 'src/actions/register_action.php');
$router->add('POST', '/order-action', 'src/actions/order_action.php');
$router->add('POST', '/save-order', 'src/actions/save_order.php');
$router->add('POST', '/admin/check-product', 'public/admin/check_product.php');
$router->add('POST', '/check_contact', 'src/actions/check_contact.php');


$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);