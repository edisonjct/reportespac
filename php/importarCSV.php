<?php

include('conexion.php');
$IDB = $_GET['IDB'];
$contador = 0;
$bandera = 0;

if ($_FILES['csv']['size'] > 0) {
    $csv = $_FILES['csv']['tmp_name'];
    $handle = fopen($csv, 'r');
    $vaciartabla = "TRUNCATE mrb_ubicacionestmp";
    mysql_query($vaciartabla);
    while ($data = fgetcsv($handle, 1000, ";", "'")) {
        $contador = $contador + 1;
        if ($data[0] != '' && $data[1] != '' && strlen($data[0]) < 14 && strlen($data[1]) < 6) {
            $sql = "INSERT INTO mrb_ubicacionestmp (codigo, ubicacion) VALUES('" . $data[0] . "','" . $data[1] . "');";
            mysql_query($sql);
            
            $bandera = 1;
        } else {
            echo '<font color="red">Linea ' . $contador . ' No se pudo subir verifique</font><br>';
            $vaciartabla = "TRUNCATE mrb_ubicacionestmp";
            mysql_query($vaciartabla);
            $bandera = 2;
            break;
        }
    }
    if ($bandera == 1) {
        $actualiza = "UPDATE maepro SET infor08 = (select mrb_ubicacionestmp.ubicacion from mrb_ubicacionestmp WHERE mrb_ubicacionestmp.codigo = maepro.codbar01) WHERE maepro.codbar01 = (SELECT mrb_ubicacionestmp.codigo FROM mrb_ubicacionestmp WHERE maepro.codbar01 = mrb_ubicacionestmp.codigo)";
        mysql_query($actualiza);
        $vaciartabla = "TRUNCATE mrb_ubicacionestmp";
        mysql_query($vaciartabla);
        echo '<font color="Green">SE ACTUALIZO CON EXITO</font><br>';
    } else {
        echo '<font color="red">NINGUN REGISTRO ACTUALIZADO</font><br>';
    }
}