<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VentasModelo
 *
 * @author EChulde
 */
require_once 'conexion.php';

class VentasModelo extends Conexion {

    //put your code here

    public function VentasModelo() {
        parent::__construct();
    }

    public function get_ventaslocal() {
        $query = "select * from mrbooks.maepro where cantact01 > 100";
        $result = $this->conexion_db->query($query);
        $ventas = $result->fetch_all(MYSQL_ASSOC);
        $result->close();
        $this->conexion_db->close();
        return $ventas;
    }

    public function get_productos($bodega) {
        $query = "select * from $bodega.maepro where cantact01 > 1000";
        $result = $this->conexion_db->query($query);
        $productos = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();
        $this->conexion_db->close();
        return $productos;
    }

    public function get_ventas_nacional_diaria($bodega,$desde,$hasta) {
        $query = "SELECT
        Sum(d.CANTID03) AS cantidad,
        (Sum(d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03)) AS venta,
        t.nomtab as bodega
        FROM
        $bodega.movpro AS d
        INNER JOIN $bodega.maefac AS c ON d.NOCOMP03 = c.nofact31
        LEFT JOIN $bodega.maetab as t ON c.coddest31 = t.codtab
        WHERE d.TIPOTRA03 = '80' AND c.cvanulado31 != '9' AND d.FECMOV03 BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND t.numtab = '97' AND t.codtab != ''
        GROUP BY c.coddest31";
        $result = $this->conexion_db->query($query);
        $ventanacionaldiaria = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();
        $this->conexion_db->close();
        return $ventanacionaldiaria;
    }
    
    public function get_ventas_nacional_diaria_graficos($bodega,$desde,$hasta) {
        $query = "SELECT
        (Sum(d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03)) AS venta
        FROM
        $bodega.movpro AS d
        INNER JOIN $bodega.maefac AS c ON d.NOCOMP03 = c.nofact31
        WHERE d.TIPOTRA03 = '80' AND c.cvanulado31 != '9' AND d.FECMOV03 BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59'
        GROUP BY c.coddest31";
        $result = $this->conexion_db->query($query);
        $ventanacionaldiaria = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();
        return $ventanacionaldiaria;
    }
    
    public function truncate_masvendidos(){
        $query = "truncate table mrb_tmp_masvendidos;";
        $result = $this->conexion_db->query($query);
        $this->conexion_db->close();
        return $result;
    }
    
    public function set_masvendidos($bodega,$fecha){
        $query = "INSERT INTO mrb_tmp_masvendidos(codbar01,cantidad) 
        SELECT
        d.CODPROD03 as codigo,
        Sum(d.CANTID03) AS cantidad
        FROM
        $bodega.movpro AS d
        INNER JOIN $bodega.maefac AS c ON d.NOCOMP03 = c.nofact31
        WHERE d.TIPOTRA03 = '80' AND c.cvanulado31 != '9' AND d.FECMOV03 BETWEEN '2016-09-28 00:00:00' AND '2016-09-28 23:59:59'
        GROUP BY d.CODPROD03
        LIMIT 15;";
        $result = $this->conexion_db->query($query);
        $this->conexion_db->close();
        return $result;
    }

        public function get_masvendidos(){
        $query = "SELECT
        m.codbar01 AS codigo,
        SUBSTRING(m.desprod01,1,15) AS titulo,
        Sum(v.cantidad) AS cantidad,
        SUBSTRING(autores.nombres,1,15) AS autor,
        SUBSTRING(editoriales.razon,1,15) AS editorial,
        SUBSTRING(maepag.nomcte01,1,15) as provedor
        FROM
        mrb_tmp_masvendidos AS v
        INNER JOIN maepro AS m ON v.codbar01 = m.codprod01
        INNER JOIN autores ON m.infor01 = autores.codigo
        INNER JOIN editoriales ON m.infor03 = editoriales.codigo
        LEFT JOIN maepag ON m.proved101 = maepag.coddest01
        GROUP BY v.codbar01
        ORDER BY sum(v.cantidad) DESC
        LIMIT 15";
        $result = $this->conexion_db->query($query);
        $masvendidos = $result->fetch_all(MYSQL_ASSOC);
        $result->close();
        $this->conexion_db->close();
        return $masvendidos;
    }

}
