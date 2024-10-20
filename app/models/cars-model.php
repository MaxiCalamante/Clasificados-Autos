<?php 

require_once 'app/models/config.php';

class CarsModel {

    private $db;

    public function __construct() {
        $this->db = new PDO(
            "mysql:host=".MYSQL_HOST .";dbname=".MYSQL_DB.";charset=utf8", 
            MYSQL_USER, MYSQL_PASS
        );
        $this->deploy(); 
    }

    private function deploy() {

        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        if (count($tables) == 0) {

            $sql = <<<END
                CREATE TABLE IF NOT EXISTS `marcas` (
                    `ID_Marca` int(11) NOT NULL,
                    `Marca` varchar(20) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                INSERT INTO `marcas` (`ID_Marca`, `Marca`) VALUES
                (1, 'Volkswagen'), (2, 'Ford'), (3, 'Fiat'), (4, 'Honda'), 
                (8, 'Subaru'), (9, 'Ferrari'), (10, 'Susuki'), 
                (11, 'Chevrolet'), (12, 'Scania'), (13, 'volvo');

                CREATE TABLE IF NOT EXISTS `modelos` (
                    `ID_Modelo` int(11) NOT NULL,
                    `ID_Marca` int(11) NOT NULL,
                    `Modelo` varchar(20) NOT NULL,
                    `Motor` varchar(20) NOT NULL,
                    `Combustible` varchar(20) NOT NULL,
                    `Transmision` varchar(20) NOT NULL,
                    `Tipo` varchar(20) NOT NULL,
                    PRIMARY KEY (`ID_Modelo`),
                    KEY `ID_Marca` (`ID_Marca`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                INSERT INTO `modelos` (`ID_Modelo`, `ID_Marca`, `Modelo`, `Motor`, `Combustible`, `Transmision`, `Tipo`) VALUES
                (23, 2, 'F1000', 'IN LINE 6', 'Gasoil', 'Manual', 'Camioneta'),
                (24, 3, 'Uno', 'i4', 'Gasoil', 'Manual', 'Sedan'),
                (25, 1, 'Passat', 'V6', 'Nafta', 'Manual', 'Sedan'),
                (26, 11, 'Corsa', 'i4', 'Nafta', 'Manual', 'Sedan'),
                (27, 4, 'Civic', 'i4', 'Nafta', 'Manual', 'Coupe');

                CREATE TABLE IF NOT EXISTS `usuarios` (
                    `id` int(11) NOT NULL,
                    `email` varchar(250) NOT NULL,
                    `password` char(60) NOT NULL,
                    PRIMARY KEY (`id`),
                    UNIQUE KEY `email` (`email`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                INSERT INTO `usuarios` (`id`, `email`, `password`) VALUES
                (1, 'webadmin@gmail.com', 'admin');
            END;
            $this->db->exec($sql);
        }
    }

    public function getAllCars() {
        $query = "SELECT modelos.ID_Modelo, modelos.Modelo, marcas.Marca FROM modelos JOIN marcas ON modelos.ID_Marca = marcas.ID_Marca";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    public function getCar($id) {

        $query = $this->db->prepare('SELECT * FROM modelos WHERE ID_Modelo = ?');
        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_OBJ);   
    }

    public function insertCars ($ID_Marca, $Modelo, $Motor, $Combustible, $Transmision, $Tipo) {

        $query = $this->db->prepare('INSERT INTO modelos(ID_Marca, Modelo, Motor, Combustible, Transmision, Tipo) VALUES (?,?,?,?,?,?)');
        $query->execute([$ID_Marca, $Modelo, $Motor, $Combustible, $Transmision, $Tipo]);

        $id = $this->db->lastInsertId();

        return $id;
    }
 
    public function insertBrands ($Marca) {
        $query = $this -> db -> prepare('INSERT INTO marcas(Marca) VALUES (?)');
        $query -> execute([$Marca]);

        $id = $this->db->lastInsertId();

        return $id;
    }   

    public function getAllBrands() {
        $query = $this->db->prepare('SELECT * FROM marcas');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }  

    public function eraseCar($id) {
        $query = $this -> db ->prepare('DELETE FROM modelos WHERE ID_Modelo = ?');
        $query->execute([$id]);
    }

    public function updateCar($ID_Modelo, $ID_Marca, $Modelo, $Motor, $Combustible, $Transmision, $Tipo) {
        $query = $this->db->prepare('UPDATE modelos SET ID_Marca = ?, Modelo = ?, Motor = ?, Combustible = ?, Transmision = ?, Tipo = ? WHERE ID_Modelo = ?');
        $query->execute([$ID_Marca, $Modelo, $Motor, $Combustible, $Transmision, $Tipo, $ID_Modelo]);
    }

    public function getFilteredCars ($filters) {
        $query = 'SELECT * FROM modelos WHERE 1=1';
        $params = [];

        if (isset($filters['ID_Marca'])) {
            $query .= ' AND ID_Marca = ?';
            $params[] = $filters['ID_Marca'];
        }

        if (isset($filters['Tipo'])) {
            $query .= ' AND Tipo = ?';
            $params[] = $filters['Tipo'];
        }

        if (isset($filters['Combustible'])) {
            $query .= ' AND Combustible = ?';
            $params[] = $filters['Combustible'];
        }

        if (isset($filters['Transmision'])) {
            $query .= ' AND Transmision = ?';
            $params[] = $filters['Transmision'];
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params); 

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function eliminarMarca($idMarca) {
        $query = $this->db->prepare('DELETE FROM marcas WHERE ID_Marca = ?');
        return $query->execute([$idMarca]);
    }

    public function modificarMarca($idMarca, $nuevoNombre) {
        $query = $this->db->prepare("UPDATE marcas SET Marca = ? WHERE ID_Marca = ?");
        $query->execute([$nuevoNombre, $idMarca]);
    }

    public function tieneModelosAsociados($idMarca) {
        $query = $this->db->prepare('SELECT COUNT(*) FROM modelos WHERE ID_Marca = ?');
        $query->execute([$idMarca]);
        return $query->fetchColumn() > 0;
    }
}
