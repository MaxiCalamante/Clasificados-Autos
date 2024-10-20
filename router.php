<?php

require_once 'libs/response.php';
require_once 'app/controllers/cars-controller.php';
require_once 'app/controllers/user-controller.php';
require_once 'app/middlewares/session.auth.middleware.php';
require_once 'app/middlewares/verify.auth.middleware.php';

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

$res = new Response();

if (!empty($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'listar';
}

$params = explode('/', $action);


switch($params[0]){
    case 'listar':
        sessionAuthMiddleware($res);
        $CarsController = new CarsController();
        $CarsController->showCars();
        $CarsController->showBrands();
        break;
    case 'addCar':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $CarsController = new CarsController();
        $CarsController->addCars();
        break;
    case 'addBrand':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $CarsController = new CarsController();
        $CarsController->addBrands();
        break;
    case 'deleteCar':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $CarsController = new CarsController();
        $CarsController->deleteCars($params[1]);
        break;
    case 'editCar': 
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $CarsController = new CarsController();
        $CarsController->editCar($params[1]);
        break;
    case 'carDetails':
        $CarsController = new CarsController();
        $CarsController->carDetails($params[1]);
        break;
    case 'updateCar':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $CarsController = new CarsController();
        $CarsController->updateCar();
        break; 
    case 'deleteBrand':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $CarsController = new CarsController();
        $CarsController->eliminarMarca();
        break;
    case 'updateBrand':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $CarsController = new CarsController();
        $CarsController->modificarMarca();
        break;
    case 'filterCars':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $CarsController = new CarsController();
        $CarsController->filteredCars();
        break;
    case 'showLogin':
        $UserController = new UserController();
        $UserController->showLogin();
        break;
    case 'login':
        $UserController = new UserController();
        $UserController->login();
        break;
    case 'registerUser':
        $UserController = new UserController();
        $UserController->register();
        break;
    case 'logOut':
        $UserController = new UserController();
        $UserController->logout();
        break;
    } 
?>
