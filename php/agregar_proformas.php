<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$IDB = $_GET['IDB'];

include('conexion.php');

$establecimiento = mysql_query("select ad7tab from maetab WHERE numtab = '01' AND codtab = '26' LIMIT 1", $conexion);
$codestablecimiento = mysql_fetch_array($establecimiento);
$idant = 0;
$cero = 0;
$ultimo = mysql_query('select max(id) as max from mrb_proformas_cabecera');
$resultultimo = mysql_fetch_array($ultimo);
$ultimoconsecutivo = $cero + $resultultimo['max'];
$consecutivo = $ultimoconsecutivo + 1;

$id = $idant + $resultultimo['max'];

$cedula = $_GET['cedula'];
$nombre = $_GET['nombre'];
$fecha = date('Y-m-d');

if (strlen($consecutivo) == 1) {
    $secuencial = '00000000';
    $proforma = $codestablecimiento[0] . $secuencial . $consecutivo;
} else if (strlen($consecutivo) == 2) {
    $secuencial = '0000000';
    $proforma = $codestablecimiento[0] . $secuencial . $consecutivo;
} else if (strlen($consecutivo) == 3) {
    $secuencial = '000000';
    $proforma = $codestablecimiento[0] . $secuencial . $consecutivo;
} else if (strlen($consecutivo) == 4) {
    $secuencial = '00000';
    $proforma = $codestablecimiento[0] . $secuencial . $consecutivo;
} else if (strlen($consecutivo) == 5) {
    $secuencial = '0000';
    $proforma = $codestablecimiento[0] . $secuencial . $consecutivo;
} else if (strlen($consecutivo) == 6) {
    $secuencial = '000';
    $proforma = $codestablecimiento[0] . $secuencial . $consecutivo;
} else if (strlen($consecutivo) == 7) {
    $secuencial = '00';
    $proforma = $codestablecimiento[0] . $secuencial . $consecutivo;
} else if (strlen($consecutivo) == 8) {
    $secuencial = '0';
    $proforma = $codestablecimiento[0] . $secuencial . $consecutivo;
} else if (strlen($consecutivo) == 9) {
    $secuencial = '';
    $proforma = $codestablecimiento[0] . $secuencial . $consecutivo;
} else {
    echo 'Sin Secuencial Consulte con el Administrador';
}


$insertar_nueva_proforma = "INSERT INTO mrb_proformas_cabecera (idproforma, cedula_cliente, nombre_cliente, fecha, estado) VALUES ('$proforma', '$cedula', '$nombre', '$fecha', '1')";
mysql_query($insertar_nueva_proforma, $conexion) or die('Error al ejecutar la consulta ' . mysql_error());

$sql = 'select idproforma,cedula_cliente,nombre_cliente,fecha from mrb_proformas_cabecera WHERE estado = 1 ORDER BY id DESC';


$resul = mysql_query($sql, $conexion) or die('Error al ejecutar la consulta ' . mysql_error());
?>
<table class="table table-striped table-condensed table-hover">
    <tr>
        <th width="300">Proforma</th>
        <th width="200">Cedula</th>
        <th width="150">Nombre</th>
        <th width="150">Fecha</th>
        <th width="35">Opciones</th>
    </tr>
    <?php while ($row = mysql_fetch_array($resul)) { ?>
        <tr>
            <td align="center"><a href="../php/agregar_proforma_detalle.php?IDB=<?php echo $IDB; ?>&proforma=<?php echo $row['idproforma']; ?>&idpro=<?php echo $id; ?>&cedula=<?php echo $row['cedula_cliente']; ?>&nombre=<?php echo $row['nombre_cliente']; ?>&fecha=<?php echo $row['fecha']; ?>" ><?php echo $row['idproforma']; ?></a></td>
            <td align="center"><?php echo $row['cedula_cliente']; ?></td>
            <td align="center"><?php echo $row['nombre_cliente']; ?></td>
            <td align="center"><?php echo $row['fecha']; ?></td>
            <td align="center"><a href="javascript:eliminarProforma('<?php echo $row['idproforma']; ?>','<?php echo $row['cedula_cliente']; ?>')" class="glyphicon glyphicon-remove-circle"></a></td>
        </tr>
    <?php } ?>
</table>
