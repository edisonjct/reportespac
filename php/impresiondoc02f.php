<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'conexion.php';

$desde = $_GET['desde'];
$hasta = $_GET['hasta'];
$IDB   = $_GET['IDB'];
$tipo  = $_GET['tipo'];

switch ($tipo) {
    case '80':
        $registro = "SELECT
            'FAC' AS TIPO,
            d.NOCOMP03 AS DOCUMENTO,
            d.FECMOV03 AS FECHA,
            c.ruc31 AS CEDULA,
            c.nocte31 as codcli,
            c.nomcte31 AS NOMBRE,
            Sum(d.CANTID03) as cantidad,
            Sum(d.PRECVTA03) AS VENTBTA,
            Sum(d.desctotvta03+d.DESCVTA03+d.desctotfp03) AS DESCUENTO,
            Sum(d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03) AS VENTANET,
            ROUND(Sum(((d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03)*d.iva03)/100),2) AS IVA,
            (Sum(d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03))+(ROUND(Sum(((d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03)*d.iva03)/100),2)) AS TOTAL,
            mrbooks_infosac.usuario.username AS usuario
            FROM
            movpro AS d
            LEFT JOIN maefac AS c ON d.NOCOMP03 = c.nofact31
            LEFT JOIN maecte ON c.nocte31 = maecte.codcte01
            INNER JOIN mrbooks_infosac.usuario ON c.UID = mrbooks_infosac.usuario.UID
            WHERE
            d.TIPOTRA03 = '80' AND
            c.cvanulado31 <> '9' AND
            d.FECMOV03 BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59'
            GROUP BY d.NOCOMP03
            ORDER BY d.FECMOV03 DESC,usuario";
        $resultado = mysql_query($registro, $conexion);
        echo '<table class="table table-striped table-condensed table-hover" >
                <tr>
                  <th>TIPO</th>
                  <th>FACTURA</th>
                  <th>FECHA</th>
                  <th>RUC</th>
                  <th>NOMBRE</th>
                  <th>CANTIDAD</th>
                  <th>VTA.BTA</th>
                  <th>DSCT</th>
                  <th>VTA.NET</th>
                  <th>IVA</th>
                  <th>TOTAL</th>
                  <th>USUARIO</th>
                  <th></th>
                </tr>';
        if (mysql_num_rows($resultado) > 0) {
            while ($row = mysql_fetch_array($resultado)) {
                echo '<tr>
                    <td class="success"><b>' . $row['TIPO'] . '</b></td>
                    <td class="success"><b>' . $row['DOCUMENTO'] . '</b></td>
                    <td class="success">' . $row['FECHA'] . '</td>
                    <td class="success">' . $row['CEDULA'] . '</td>
                    <td class="success">' . $row['NOMBRE'] . '</td>
                    <td class="success">' . number_format($row['cantidad'], 0, '.', ',') . '</td>
                    <td class="success">' . number_format($row['VENTBTA'], 2, '.', ',') . '</td>
                    <td class="success">' . number_format($row['DESCUENTO'], 2, '.', ',') . '</td>
                    <td class="success">' . number_format($row['VENTANET'], 2, '.', ',') . '</td>
                    <td class="success"><b>' . number_format($row['IVA'], 2, '.', ',') . '</b></td>
                    <td class="success"><b>' . number_format($row['TOTAL'], 2, '.', ',') . '</b></td>
                    <td class="success">' . $row['usuario'] . '</td>';
                echo "<td class='success'><a href='../php/impresiondoc03E.php?documento=" . $row['DOCUMENTO'] . "&cliente=" . $row['codcli'] . "&IDB=$IDB&tipo=80&cajero=" . $row['usuario'] . "&fecha=" . $row['FECHA'] . "  ' target='imprimir.php' onclick=\"window.open(this.href, this.target, ' width=600, height=640,top=20,left=300, menubar=no');return false;\"><img src='../recursos/printer.png' width='20' height='20' alt='' /></a></td>";
                echo '</tr>';
            }
        } else {
            echo '<tr>
    <td colspan="12">No se encontraron resultados</td>
  </tr>';
        }
        echo '</table>';

        break;
    case '22':
        $registro = "SELECT
            'N/C' AS TIPO,
            d.NOCOMP03 AS DOCUMENTO,
            d.FECMOV03 AS FECHA,
            c.cascte01 AS CEDULA,
            c.nomcte01 AS NOMBRE,
            Sum(d.CANTID03) AS cantidad,
            Sum(d.PRECVTA03) AS VENTBTA,
            Sum(d.desctotvta03+d.DESCVTA03+d.desctotfp03) AS DESCUENTO,
            Sum(d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03) AS VENTANET,
            ROUND(Sum(((d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03)*d.iva03)/100),2) AS IVA,
            (Sum(d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03))+(ROUND(Sum(((d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03)*d.iva03)/100),2)) AS TOTAL,
            d.NOFACT03 AS docmodi,
            mrbooks_infosac.usuario.username as usuario
            FROM
            movpro AS d
            LEFT JOIN mrbooks.maecte AS c ON d.nomdest03 = c.codcte01
            INNER JOIN mrbooks_infosac.usuario ON d.UID = mrbooks_infosac.usuario.UID
            WHERE d.TIPOTRA03 = '22' AND
            d.FECMOV03 BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND d.cvanulado03 <> 'S'
            GROUP BY d.NOCOMP03
            ORDER BY d.FECMOV03 DESC,usuario
            ";
        $resultado = mysql_query($registro, $conexion);
        echo '<table class="table table-striped table-condensed table-hover" >
                <tr>
                  <th>TIPO</th>
                  <th>NOTACREDITO</th>
                  <th>FECHA</th>
                  <th>RUC</th>
                  <th>NOMBRE</th>
                  <th>CANTIDAD</th>
                  <th>VTA.BTA</th>
                  <th>DSCT</th>
                  <th>VTA.NET</th>
                  <th>IVA</th>
                  <th>TOTAL</th>
                  <th>DOC.MODIFI</th>
                  <th>USUARIO</th>
                  <th></th>
                </tr>';
        if (mysql_num_rows($resultado) > 0) {
            while ($row = mysql_fetch_array($resultado)) {
                echo '<tr>
                    <td class="danger"><b>' . $row['TIPO'] . '</b></td>
                    <td class="danger"><b>' . $row['DOCUMENTO'] . '</b></td>
                    <td class="danger">' . $row['FECHA'] . '</td>
                    <td class="danger">' . $row['CEDULA'] . '</td>
                    <td class="danger">' . $row['NOMBRE'] . '</td>
                    <td class="danger">' . number_format($row['cantidad'], 0, '.', ',') . '</td>
                    <td class="danger">' . number_format($row['VENTBTA'], 2, '.', ',') . '</td>
                    <td class="danger">' . number_format($row['DESCUENTO'], 2, '.', ',') . '</td>
                    <td class="danger">' . number_format($row['VENTANET'], 2, '.', ',') . '</td>
                    <td class="danger"><b>' . number_format($row['IVA'], 2, '.', ',') . '</b></td>
                    <td class="danger"><b>' . number_format($row['TOTAL'], 2, '.', ',') . '</b></td>
                    <td class="danger">' . $row['docmodi'] . '</td>
                   <td class="danger">' . $row['usuario'] . '</td>';
                echo "<td class='danger'><a href='../php/impresiondoc03E.php?documento=" . $row['DOCUMENTO'] . "&cliente=" . $row['CEDULA'] . "&IDB=$IDB&tipo=22&cajero=" . $row['usuario'] . "&fecha=" . $row['FECHA'] . "&docm=" . $row['docmodi'] . "   ' target='imprimir.php' onclick=\"window.open(this.href, this.target, ' width=600, height=640,top=20,left=300, menubar=no');return false;\"><img src='../recursos/printer.png' width='20' height='20' alt='' /></a></td>";
                echo '</tr>';
            }
        } else {
            echo '<tr>
    <td colspan="14">No se encontraron resultados</td>
  </tr>';
        }
        echo '</table>';
        break;
}
