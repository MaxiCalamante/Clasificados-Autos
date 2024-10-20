<?php 

 Class UserModel {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=vehiculos-db-mod;charset=utf8', 'root', '');
    }

    public function getAccountByEmail ($email) {
        $query = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $query->execute([$email]);

        $user=$query->fetch(PDO::FETCH_OBJ);

        return $user;
    }    

    public function insertUser ($email,$hashedPassword) {
        $query = $this->db->prepare("INSERT INTO usuarios (email, password) VALUES (?, ?)");
        $query->execute([$email,$hashedPassword]);
    }

}