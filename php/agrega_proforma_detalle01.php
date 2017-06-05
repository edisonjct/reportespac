<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include('conexion.php');

$id = '';
$IDB = $_GET['IDB'];
$idpro = $_GET['idpro'];
$codigo = $_GET['codigo'];
$descuento = $_GET['descuento'];
$cantidad = $_GET['cantidad'];
$proforma = $_GET['proforma'];
$proceso = $_GET['proceso'];
$cantactal = 0;
$id = $id + $idpro + 1;
$sumcantidad = 0;
$subtotal = 0;
$totaliva14 = 0;
$total = 0;

if ($proceso == '1') {
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
                <th></th>
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
} else {
    $vercodigo = "select codbar01 from maepro WHERE codbar01='$codigo'";
    $vercodigo1 = mysql_query($vercodigo);
    if (mysql_num_rows($vercodigo1) > 0) {

        $sumatoria = mysql_query("select sum(cantidad) as sum from mrb_proformas_detalle WHERE id_proforma = '$proforma' AND cod_barras = '$codigo' GROUP BY id_proforma", $conexion);
        $row_sumas = mysql_fetch_array($sumatoria);
        $vercstock1 = mysql_query("select cantact01 as stock from maepro WHERE codbar01='$codigo'", $conexion);
        $row_stock = mysql_fetch_array($vercstock1);
        $stkactual = $row_stock['stock'] - $row_sumas['sum'];
        $cantactal = $stkactual - $cantidad;
        $cantactual2 = $row_sumas['sum'] + $cantidad;
        if ($row_stock['stock'] > 0) {
            if ($cantactual2 > 0) {
                if ($cantactal < 0) {
                    echo '<script language="javascript">alert("Stock Insuficiente");</script>';
                } else {
                    $sql_insert = "INSERT INTO mrb_proformas_detalle (id, id_proforma, cod_barras, cantidad ,descuento, estado) VALUES ('$id', '$proforma', '$codigo', '$cantidad',$descuento ,'1')";
                    mysql_query($sql_insert, $conexion) or die('Error al ejecutar la consulta ' . mysql_error());
                }
            } else {
                echo '<script language="javascript">alert("No puede Ingresar Valores menores al Stock Actual");</script>';
            }
        } else {
            echo '<script language="javascript">alert("No tiene Stock");</script>';
        }
    } else {
        echo '<script language="javascript">alert("Codigo No existe");</script>';
    }

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
                <th></th>
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
<?php }



