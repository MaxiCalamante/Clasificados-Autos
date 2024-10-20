<?php

require_once 'app/models/cars-model.php';
require_once 'app/views/cars-view.php';

class CarsController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new CarsModel();
        $this->view = new CarsView();
    }

    public function showCars() {
        $cars = $this->model->getAllCars();
        $brands = $this->model->getAllBrands();
        $this->view->showCars($cars,$brands);
    }
    
    public function showBrands() {
        $brands = $this->model->getAllBrands();
        $this->view->showBrands($brands);
    }


    public function addCars () {
        if (!empty($_POST['ID_Marca']) && isset($_POST['Modelo'] , $_POST['Motor'], $_POST['Combustible'], $_POST['Transmision'], $_POST['Tipo'])) {
        }
        
        $ID_Marca = $_POST['ID_Marca'];
        $Modelo = $_POST['Modelo'];
        $Motor = $_POST['Motor'];
        $Combustible = $_POST['Combustible'];
        $Transmision = $_POST['Transmision'];
        $Tipo = $_POST['Tipo'];

        $id = $this->model->insertCars($ID_Marca,$Modelo,$Motor,$Combustible,$Transmision,$Tipo);

        header('Location: ' . BASE_URL);

    }  

    public function addBrands () {
        if (isset($_POST['nueva_marca']) && !empty($_POST['nueva_marca'])) {
            $Marca = $_POST['nueva_marca'];
            $ID_Marca = $this->model->insertBrands($Marca);
        } else {
            $ID_Marca = $_POST['ID_Marca'];
        }
        header('Location: ' . BASE_URL);
    }

    public function deleteCars ($id) {

        $car = $this->model->getCar($id);

        if (!$car) {
            return $this->view->showError("No existe el auto con el nombre =$id");
        }

        $this->model->eraseCar($id);

        header('Location: ' . BASE_URL);
    }

    public function editCar($id) {
        $car = $this->model->getCar($id);
        $brands = $this->model->getAllBrands();
    
        if (!$car) {
            return $this->view->showError("El auto no existe.");
        }
    
        $this->view->showEditForm($car, $brands);
    }

    public function updateCar() {
        if (!empty($_POST['ID_Modelo']) && isset($_POST['ID_Marca'], $_POST['Modelo'], $_POST['Motor'], $_POST['Combustible'], $_POST['Transmision'], $_POST['Tipo'])) {
            $ID_Modelo = $_POST['ID_Modelo'];
            $ID_Marca = $_POST['ID_Marca'];
            $Modelo = $_POST['Modelo'];
            $Motor = $_POST['Motor'];
            $Combustible = $_POST['Combustible'];
            $Transmision = $_POST['Transmision'];
            $Tipo = $_POST['Tipo'];
    
            $this->model->updateCar($ID_Modelo, $ID_Marca, $Modelo, $Motor, $Combustible, $Transmision, $Tipo);
    
            header('Location: ' . BASE_URL);
        } else {
            $this->view->showError('Faltan datos obligatorios.');
        }
    }

    public function filteredCars () {
        
        $filters = [];

        if (isset($_POST['ID_Marca']) && !empty($_POST['ID_Marca'])) {
            $filters['ID_Marca'] = $_POST['ID_Marca'];
        }
    
        if (isset($_POST['Tipo']) && !empty($_POST['Tipo'])) {
            $filters['Tipo'] = $_POST['Tipo'];
        }
    
        if (isset($_POST['Combustible']) && !empty($_POST['Combustible'])) {
            $filters['Combustible'] = $_POST['Combustible'];
        }
    
        if (isset($_POST['Transmision']) && !empty($_POST['Transmision'])) {
            $filters['Transmision'] = $_POST['Transmision'];
        }

        $cars = $this->model->getFilteredCars($filters);
        $brands=$this->model->getAllBrands();
        $this->view->showCars($cars,$brands);
    }

    public function carDetails($id) {      
        $carDetails = $this->model->getCar($id);
            if ($carDetails) {
                $this->view->showCarDetails($carDetails);
  
        }
    }

    public function eliminarMarca() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idMarca = $_POST['ID_Marca']; 
    
           
            if ($this->model->tieneModelosAsociados($idMarca)) {
                echo 'No se puede eliminar la marca porque hay modelos asociados a ella. Primero elimine los modelos.';
            } else {
      
                if ($this->model->eliminarMarca($idMarca)) {
                    header('Location: ' . BASE_URL);
                } else {
                    echo 'Error al eliminar la marca';
                }
            }
        } else {
            require 'templates/listar.phtml';
        }
    }


    public function modificarMarca() {
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idMarca = $_POST['ID_Marca'];
            $nuevaMarca = $_POST['Marca'];
            $this->model->modificarMarca($idMarca, $nuevaMarca);
                header('Location: ' . BASE_URL);
        }
    }
} 
  