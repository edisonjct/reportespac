
<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include('conexion.php');


$IDB = $_GET['IDB'];

$proforma = $_GET['proforma'];
$proceso = $_GET['proceso'];
$cantactal = 0;
$subtotal = 0;
$totaliva14 = 0;
$total = 0;
$sumcantidad = 0;


switch ($proceso) {
    case 'cabecera':
        $cedula = $_GET['cedula'];
        $eliminar_proformas = mysql_query("UPDATE mrb_proformas_cabecera SET estado='2' WHERE (idproforma='$proforma' AND cedula_cliente='$cedula')");
        $eliminar_proformas_detalle = mysql_query("UPDATE mrb_proformas_detalle SET estado='2' WHERE (id_proforma='$proforma')");


        $sql = "select idproforma,id,cedula_cliente,nombre_cliente,fecha from mrb_proformas_cabecera WHERE estado = 1 ORDER BY id DESC";

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
                    <td align="center"><a href="../php/agregar_proforma_detalle.php?IDB=<?php echo $IDB; ?>&proforma=<?php echo $row['idproforma']; ?>&idpro=<?php echo $id; ?>&cedula=<?php echo $row['cedula_cliente']; ?>&nombre=<?php echo $row['nombre_cliente']; ?>&fecha=<?php echo $row['fecha']; ?>" ><?php echo $row['idproforma']; ?></a></td>
                    <td align="center"><?php echo $row['cedula_cliente']; ?></td>
                    <td align="center"><?php echo $row['nombre_cliente']; ?></td>
                    <td align="center"><?php echo $row['fecha']; ?></td>
                    <td align="center"><a href="javascript:eliminarProforma('<?php echo $row['idproforma']; ?>','<?php echo $row['cedula_cliente']; ?>')" class="glyphicon glyphicon-remove-circle"></a></td>
                </tr>
            <?php } ?>
        </table>
        <?php
        break;

    case 'detalle':

        $codigo = $_GET['codigo'];
        $eliminar_producto_proforma = mysql_query("DELETE FROM mrb_proformas_detalle WHERE (id_proforma='$proforma' AND cod_barras='$codigo');");

        $sql_select = "SELECT
            d.cod_barras AS codigo,
            p.desprod01 AS nombre,
            Sum(d.cantidad) AS cantidad,
            p.cantact01 as stock,
            a.nombres AS autor,
            e.razon AS editorial,
            c.desccate AS categoria,
            p.precvta01 AS pvp,
            ((p.precvta01 * p.porciva01)/100) AS iva,
            d.descuento as descuento,
            Sum(d.cantidad) * (p.precvta01) as totalsiniva,
            Sum(d.cantidad) * (((p.precvta01 * p.porciva01)/100)+p.precvta01) as totaliva
            FROM
            mrb_proformas_detalle AS d
            INNER JOIN maepro AS p ON d.cod_barras = p.codbar01
            INNER JOIN mrbooks.autores AS a ON p.infor01 = a.codigo
            INNER JOIN mrbooks.editoriales AS e ON p.infor02 = e.codigo
            INNER JOIN mrbooks.categorias as c ON p.catprod01 = c.codcate
            WHERE d.id_proforma = '$proforma' AND cantidad != '0'
            GROUP BY d.id_proforma,d.cod_barras
            HAVING Sum(d.cantidad) <> '0'
            ORDER BY cont DESC";

        $resul = mysql_query($sql_select, $conexion) or die('Error al ejecutar la consulta ' . mysql_error());
        ?> 
        <table class="table table-condensed table-bordered table-hover">
            <tbody>
                <tr>
                    <th>OP</th>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Autor</th>
                    <th>Editorial</th>
                    <th>Categoria</th>
                    <th>PVP</th>
                    <th>Iva</th>
                    <th>Stock</th>
                    <th>Cant.</th>
                    <th>Total</th>
                </tr>

                <?php
                while ($row = mysql_fetch_array($resul)) {
                    $subtotal = $subtotal + $row['totalsiniva'];
                    $total = $total + $row['totaliva'];
                    $sumcantidad = $sumcantidad + $row['cantidad'];
                    ?>
                    <tr>
                        <td align='center'><a href="javascript:eliminarProductoProforma('<?php echo $proforma; ?>','<?php echo $row['codigo']; ?>')" class="glyphicon glyphicon-remove-circle"></a></td>
                        <td align='center'><?php echo $row['codigo']; ?></td>
                        <td align='left'><?php echo $row['nombre']; ?></td>
                        <td align='center'><?php echo $row['autor']; ?></td>
                        <td align='center'><?php echo $row['editorial']; ?></td>
                        <td align='center'><?php echo $row['categoria']; ?></td>
                        <td align='center'><?php echo number_format($row['pvp'], 2, '.', ','); ?></td>
                        <td align='center'><?php echo number_format($row['iva'], 2, '.', ','); ?></td>
                        <td align='center'><?php echo number_format($row['stock'], 0, '.', ','); ?></td>
                        <td align='center'><?php echo number_format($row['cantidad'], 0, '.', ','); ?></td>                    
                        <td align='center'><?php echo number_format($row['totalsiniva'], 2, '.', ','); ?></td>
                    </tr>
                    <?php
                }
                $totaliva14 = $total - $subtotal;
                ?>
                <tr>
                    <td colspan="9" rowspan="2"></td>
                    <th>Cant: <?php echo number_format($sumcantidad, 0, '.', ','); ?></th>
                    <th><?php echo number_format($subtotal, 2, '.', ','); ?></th>
                </tr>
                <tr>                
                    <th colspan="1">Iva 14:</th>
                    <th><?php echo number_format($totaliva14, 2, '.', ','); ?></th>
                </tr>
                <tr>
                    <td align="center" colspan="4"><b>FIRMA ADMINISTRADOR</b></td>
                    <td align="center" colspan="5"><b>FIRMA CLIENTE</b></td>
                    <th>Total:</th>
                    <th><?php echo number_format($total, 2, '.', ','); ?></th>
                </tr>
            </tbody>
        </table>        
        <?php
        break;
}
