<?php

// Clase Conexion para programa de gerencia
require_once 'config.php';

class Conexion {

    protected $conexion_db;

    public function Conexion() {
        $this->conexion_db = new mysqli(DB_HOST, DB_USUARIO, DB_PASS, DB_NOMBRE);

        if ($this->conexion_db->connect_errno) {
            echo "Error en conexion: " . $this->conexion_db->connect_errno;
            return;
        }
        $this->conexion_db->set_charset(DB_CHARSET);
    }


}
