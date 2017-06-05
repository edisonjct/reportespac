<?php

require_once 'conexion.php';

class Prueba extends Conexion {

    public function prueba() {
        parent::__construct();
    }
    
    public function get_productos($cantidad){
        $query="select * from maepro where cantact01 > $cantidad";
        $result = $this->conexion_db->query($query);
        $productos = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();
        $this->conexion_db->close();
        return $productos;
    }

}
