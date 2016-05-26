<?php

include('conexion.php');
$IDB = $_GET['IDB'];

if ($_FILES['csv']['size'] > 0) {
    $csv = $_FILES['csv']['tmp_name'];
    $handle = fopen($csv, 'r');
    $vaciartabla = "TRUNCATE mrb_ubicacionestmp";
    mysql_query($vaciartabla);
    while ($data = fgetcsv($handle, 1000, ";", "'")) {
        if ($data[0]) {
            $sql = "INSERT INTO mrb_ubicacionestmp (codigo, ubicacion) VALUES('" . $data[0] . "','" . $data[1] . "');";
            mysql_query($sql);
            echo $sql,'<br>';
        }
    }
}