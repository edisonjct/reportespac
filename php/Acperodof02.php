<?php

include 'conexionC.php';
$IDB     = $_GET['IDB'];
$ID      = $_GET['ID'];
$periodo = $_GET['periodo'];

$sql    = "select codtab,nomtab,ad7tab from maetab WHERE numtab = 97 AND codtab <> '' ORDER BY codtab";
$result = mysql_query($sql, $conexionmatriz);
if (mysql_num_rows($result) > 0) {

    while ($row = mysql_fetch_array($result)) {
        switch ($row['codtab']) {
            case '01':$base = 'mrbooks';
                break;
            case '02':$base = 'mrbookweb';
                break;
            case '03':$base = 'mrbookjardin';
                break;
            case '04':$base = 'mrbooksol';
                break;
            case '05':$base = 'mrbookcondado';
                break;
            case '06':$base = 'mrbooktumbaco';
                break;
            case '07':$base = 'mrbookvill';
                break;
            case '08':$base = 'mrbooksaldos';
                break;
            case '09':$base = 'mrbookeventos';
                break;
            case '10':$base = 'mrbookcuenca';
                break;
            case '11':$base = 'mrbookkiwy';
                break;
            case '12':$base = 'mrbookreservados';
                break;
            case '13':$base = 'mrbookcumbaya';
                break;
            case '14':$base = 'mrbooksmarino';
                break;
            case '15':$base = 'mrbooksluis';
                break;
            case '16':$base = 'mrbookquicentro';
                break;
            case '17':$base = 'mrbookjlmera';
                break;
        }
        $sql2    = "UPDATE $base.maetab SET ad7tab='$periodo' WHERE (numtab='55') AND (codtab='PF');";
        $result2 = mysql_query($sql2, $conexionmatriz);
    }
    echo '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <a href="#" class="alert-link">Cambios Realizados Con Exito</a>
          </div>';
} else {
    echo "Sin registros";
    mysql_free_result($result);
}
