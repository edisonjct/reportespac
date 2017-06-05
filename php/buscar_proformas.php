<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include('conexion.php');

$IDB = $_GET['IDB'];
$cedula = $_GET['cedula'];
$proforma = $_GET['proforma'];



if ($cedula == '' && $proforma == '') {
    $sql = "select idproforma,id,cedula_cliente,nombre_cliente,fecha from mrb_proformas_cabecera WHERE estado = 1 ORDER BY id DESC";
} else if ($cedula != '' && $proforma != '') {
    $sql = "select idproforma,id,cedula_cliente,nombre_cliente,fecha from mrb_proformas_cabecera WHERE estado = 1 AND cedula_cliente = '$cedula' AND idproforma='$proforma' ORDER BY id DESC";
} else if ($cedula == '' && $proforma != '') {
    $sql = "select idproforma,id,cedula_cliente,nombre_cliente,fecha from mrb_proformas_cabecera WHERE estado = 1 AND idproforma='$proforma' ORDER BY id DESC";
} else if ($cedula != '' && $proforma == '') {
    $sql = "select idproforma,id,cedula_cliente,nombre_cliente,fecha from mrb_proformas_cabecera WHERE estado = 1 AND cedula_cliente = '$cedula' ORDER BY id DESC";
}
$idant = 0;
$ultimo = mysql_query('select max(id) as max from mrb_proformas_cabecera');
$resultultimo = mysql_fetch_array($ultimo);
$id = $idant + $resultultimo['max'];

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
            <td align="center"><a href="../php/agregar_proforma_detalle.php?IDB=<?php echo $IDB;?>&proforma=<?php echo $row['idproforma'];?>&idpro=<?php echo $id;?>&cedula=<?php echo $row['cedula_cliente'];?>&nombre=<?php echo $row['nombre_cliente'];?>&fecha=<?php echo $row['fecha'];?>" ><?php echo $row['idproforma']; ?></a></td>
            <td align="center"><?php echo $row['cedula_cliente']; ?></td>
            <td align="center"><?php echo $row['nombre_cliente']; ?></td>
            <td align="center"><?php echo $row['fecha']; ?></td>
            <td align="center"><a href="javascript:eliminarProforma('<?php echo $row['idproforma'] ;?>','<?php echo $row['cedula_cliente'];?>')" class="glyphicon glyphicon-remove-circle"></a></td>
        </tr>
    <?php } ?>
</table>