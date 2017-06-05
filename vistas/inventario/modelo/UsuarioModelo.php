<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsuarioModelo
 *
 * @author EChulde
 */
require_once 'conexion.php';

class UsuarioModelo extends Conexion {

    //put your code here

    public function UsuarioModelo() {
        parent::__construct();
    }

    public function get_usuario() {
        $query = "SELECT
        u.id as id,
        u.usuario AS usuario,
        u.nombres AS nombres,
        u.password as password,
        c.nombre AS tipo,
        u.logo as logo,
        cc.nombre as estado,
        u.tipo as idtipo,
        u.id_empresa as idempresa,
        u.estado as idestado
        FROM
        tbl_usuarios AS u
        INNER JOIN tbl_configuraciones as c ON u.tipo = c.codtab
        INNER JOIN tbl_configuraciones as cc ON u.estado = cc.codtab
        WHERE c.numtab = 1 AND cc.numtab = 2 AND u.estado IN (1,2) order by id";
        $result = $this->conexion_db->query($query);
        $usuarios = $result->fetch_all(MYSQL_ASSOC);
        $result->close();
        $this->conexion_db->close();
        return $usuarios;
    }
    
    public function estado_usuario() {
        $query = "SELECT c.codtab as codigo,c.nombre as nombre FROM tbl_configuraciones c WHERE numtab = 2 AND codtab != 0";
        $result = $this->conexion_db->query($query);
        $usuarios = $result->fetch_all(MYSQL_ASSOC);
        $result->close();
        $this->conexion_db->close();
        return $usuarios;
    }
    
    public function combo_avatar() {
        $query = "SELECT codtab,nombre,op1 FROM tbl_configuraciones WHERE numtab = 3 AND codtab != 0 AND estado = 1 order by codtab";
        $result = $this->conexion_db->query($query);
        $avatar = $result->fetch_all(MYSQL_ASSOC);
        $result->close();
        $this->conexion_db->close();
        return $avatar;
    }
    
    public function combo_tipo() {
        $query = "SELECT codtab,nombre FROM tbl_configuraciones WHERE numtab = 1 AND codtab != 0 AND estado = 1 order by codtab";
        $result = $this->conexion_db->query($query);
        $tipo = $result->fetch_all(MYSQL_ASSOC);
        $result->close();
        $this->conexion_db->close();
        return $tipo;
    }
    
    public function guardar_usuario($nombre,$usuario,$password,$tipo,$avatar,$estado,$empresa){
        $query = "INSERT INTO tbl_usuarios (nombres, usuario, password, tipo, logo, id_empresa, estado) VALUES ('$nombre', '$usuario', '$password', '$tipo', '$avatar', '$estado', '$empresa')";
        $guardar = $this->conexion_db->query($query);        
        $this->conexion_db->close();
        return $guardar;
    }
    
    public function eliminar_usuario($id){
        $query = "UPDATE tbl_usuarios SET estado='3' WHERE (id='$id');";
        $guardar = $this->conexion_db->query($query);        
        $this->conexion_db->close();
        return $guardar;
    }
    
    public function modificar_usuario($id,$nombre,$usuario,$password,$tipo,$avatar,$estado,$empresa){
        $query = "UPDATE tbl_usuarios SET nombres='$nombre', usuario='$usuario', password='$password', tipo='$tipo', logo='$avatar', id_empresa='$empresa', estado='$estado' WHERE (id='$id')";
        $modificar = $this->conexion_db->query($query);        
        $this->conexion_db->close();
        return $modificar;
    }    

}
