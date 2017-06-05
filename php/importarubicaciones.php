<?php

include('conexion.php');
$IDB = $_GET['IDB'];
$num_lineas = 0;

$contador = 0;
$contador2 = 0;
//$banderatrue = 0;
//$banderafalse = 0;
if ($_FILES['ubicaciones']['size'] > 0) {
    $csv = $_FILES['ubicaciones']['tmp_name'];
    $archivo = fopen($csv, 'r');
    while ($data = fgetcsv($archivo, 10000, ";", "'")) {
        $contador = $contador + 1;
        if ($data[0] == '') {
            echo 'Linea ' . $contador . ': En Blanco' . '<br>';
        } else if (strlen($data[0]) != 5) {
            echo 'Linea ' . $contador . ': Tiene ' . strlen($data[0]) . ' caracteres no cumple los parametros permitidos' . '<br>';
        } else {
            //echo 'LLEGO'.'<br>';
            $query_verificar = "select cod_ubicacion from ubicacionMRB WHERE cod_ubicacion = '$data[0]';";
            $result_verificar = mysql_query($query_verificar);
            if (mysql_num_rows($result_verificar) > 0) {
                echo 'Linea ' . $contador . ': La Ubicacion ' . $data[0] . ' ya Existe' . '<br>';
            } else {
                $contador2 = $contador2 + 1;
            }
        }
    }

    if ($contador != $contador2) {
        echo '<br>
            <div class="container"><div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <a href="#" class="alert-link">No se Inserto ninguna Ubicación: Corriga el archivo y vuelva a Subir</a>
          </div></div>';
    } else {
        $archivo = fopen($csv, 'r');
        while ($insert = fgetcsv($archivo, 10000, ";", "'")) {
            $query_insertar = 'INSERT INTO ubicacionMRB (cod_ubicacion, observacion, detalle) VALUES ('."'$insert[0]'".', '."'$insert[0]'".', '."'$insert[0]'".');';
            $result_insertar = mysql_query($query_insertar);
        }
        echo '<div class="container"><div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <a href="#" class="alert-link">Ubicaciones Ingresadas Con Exito</a>
          </div></div>';
    }
}