<?php

require "../vendor/autoload.php";

use Example\Controllers\AdminController;
use Example\Controllers\AdminPageController;
use Example\Controllers\DefaultController;
use Example\Controllers\PageController;
use Example\Controllers\PageREST;
use HummNGIN\Controllers\DebugController;
use HummNGIN\Controllers\SecurityController;
use HummNGIN\Core\Http\Request;
use HummNGIN\Core\Kernel;
use HummNGIN\Core\Router\Router;
use HummNGIN\Core\Session;
use HummNGIN\Guard\AdminGuard;
use HummNGIN\Guard\AuthGuard;
use HummNGIN\Util\Debug;

include_once "../config.php";

Router::any('home-page', '/', function () {
    return (new DefaultController())->index();
});


Router::any('login', '/login', function () {
    return (new SecurityController())->login();
});
Router::any('register', '/register', function () {
    return (new SecurityController())->register();
});
Router::any('logout', '/logout', function () {
    return (new SecurityController())->logout();
});


Router::anyWithClass('page-index', '/pages', PageController::class, 'index');
Router::anyWithClass('page-show', '/page/{id}', PageController::class, 'get');


Router::anyWithClass('admin-home', '/admin', AdminController::class, 'index')->Guard(AdminGuard::class);
Router::anyWithClass('admin-page-list', '/admin/pages', AdminPageController::class, 'index')->Guard(AdminGuard::class);
Router::anyWithClass('admin-page-post', '/admin/page', AdminPageController::class, 'insert')->Guard(AdminGuard::class);
Router::anyWithClass('admin-page-edit', '/admin/page/{id}', AdminPageController::class, 'select')->Guard(AdminGuard::class);

Router::anyWithClass('api-page', '/api/v1/page', PageREST::class, 'handle')->Guard(AdminGuard::class);




Router::any('debug', '/debug', function () {
    return (new DebugController())->debug();
});

Kernel::RegisterRouter(Router::class);

Session::start();

Debug::DebugMode($_ENV['DEBUG']);

$response = Kernel::Handle(
    Request::capture()
)->send();





