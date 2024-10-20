<?php 

require_once 'app/models/user-model.php';
require_once 'app/views/auth-view.php';


Class UserController {
    private $model;
    private $view;


    public function __construct() {
        $this->model = new UserModel();
        $this->view = new AuthView();   
    }

    public function showLogin() {
        return $this->view->showLogin();
    }

    public function showRegister() {
        return $this->view->showRegister();
    }

    public function login() {
        if (!isset($_POST['email']) || empty($_POST['email'])) {
            return $this->view->showLogin('Falta completar el nombre de usuario');
        }
    
        if (!isset($_POST['password']) || empty($_POST['password'])) {
            return $this->view->showLogin('Falta completar la contraseña');
        }
    
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        $userFromDB = $this->model->getAccountByEmail($email);
    
        if ($userFromDB && password_verify($password, $userFromDB->password)) {
            session_start();
            $_SESSION['ID_USER'] = $userFromDB->id;
            $_SESSION['EMAIL_USER'] = $userFromDB->email;
            $_SESSION['LAST_ACTIVITY'] = time();
    
            header('Location: ' . BASE_URL);
            exit();
        } else {
            return $this->view->showLogin('Credenciales incorrectas');
        }
    }

    public function register() {
        if (!isset($_POST['email']) || empty($_POST['email'])) {
            return $this->view->showRegister();
        }
        
        if (!isset($_POST['password']) || empty($_POST['password'])) {
            return $this->view->showRegister();
        }
    
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        
        if ($this->model->getAccountByEmail($email)) {
            return $this->view->showRegister('Este email ya está registrado');
        }
    
        
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
        
        $this->model->insertUser($email, $hashedPassword);
    
        
        header('Location: ' . BASE_URL . 'showLogin');
        exit();
    }

    public function logout() {
        session_start();
        session_destroy(); 
        header('Location: ' . BASE_URL);
    }

}