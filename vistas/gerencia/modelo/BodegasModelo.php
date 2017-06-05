<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BodegasModelo
 *
 * @author EChulde
 */
require_once 'conexion.php';

class BodegasModelo extends Conexion{

    //put your code here
    public function BodegasModelo() {
        parent::__construct();
    }

    public function get_BodegasBase() {
        $bodegas = array('mrbooks', 'mrbookjardin','mrbooksol','mrbookcondado','mrbooktumbaco','mrbookvill','mrbookeventos','mrbookquicentro','mrbooksmarino','mrbooksluis','mrbookcumbaya','mrbookweb');
        //$bodegas = array('mrbooks', 'mrbookjardin','mrbooksol','mrbookcondado','mrbooktumbaco','mrbookvillage','mrbookweb','mrbookeventos');
        return $bodegas;
    }

}
