<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FacturasElectronicasModelo
 *
 * @author EChulde
 */
require_once 'conexion.php';

class FacturasElectronicasModelo extends Conexion {

    //put your code here
    public function FacturasElectronicasModelo() {
        parent::__construct();
    }

    public function buscar_facturas($bodega,$desde,$hasta) {
        $query = "SELECT
        fac.numero_factura as numero,
        fac.codigo_cliente as codigocliente,
        fac.fecha_emision as fecha,
        fac.valor_factura as valor,
        fac.observacion as observacion,
        fac.rechazada as estado,
        CASE WHEN fac.rechazada = 1 THEN 'AUTORIZADO' WHEN fac.rechazada = 2 THEN 'RECHAZADO' WHEN fac.rechazada = 0 THEN 'VOLVER A ENVIAR' END AS esta
        FROM
        $bodega.factura_electronica as fac
        WHERE fac.fecha_emision BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND fac.rechazada != 1";
        $result = $this->conexion_db->query($query);
        $cliente = $result->fetch_all(MYSQL_ASSOC);
        $result->close();
        $this->conexion_db->close();
        return $cliente;
    }

}
