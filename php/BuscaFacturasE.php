<?php

include('conexion.php');
header("Content-type: application/vnd.ms-excel; name='excel'"); 
header("Content-Disposition: filename=Reporte De Facturas.xls"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 
$desde = $_GET['desde'];
$hasta = $_GET['hasta'];
$IDB = $_GET['IDB'];
$condicion = $_GET['condicion'];


$registro = "SELECT
DATE_FORMAT(d.FECMOV03,'%Y/%m/%d') AS FECHA,
d.NOCOMP03 AS FACTURA,
Sum(d.PRECVTA03) AS VENTABTA,
Sum(d.desctotvta03+d.DESCVTA03+d.desctotfp03) AS DESCUENTO,
Sum(d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03) AS VENTANET,
ROUND(Sum(((d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03)*d.iva03)/100),2) AS IVA,
(Sum(d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03))+(ROUND(Sum(((d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03)*d.iva03)/100),2)) AS TOTAL,
c.ruc31 AS CEDULA,
c.nomcte31 AS NOMBRE
FROM
movpro AS d
LEFT JOIN maefac AS c ON d.NOCOMP03 = c.nofact31
LEFT JOIN maecte ON c.nocte31 = maecte.codcte01
WHERE
d.TIPOTRA03 = '80' AND
c.cvanulado31 <> '9' AND
c.condpag31 = '$condicion' AND 
d.FECMOV03 BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59'
GROUP BY d.NOCOMP03
ORDER BY d.FECMOV03 DESC";

$resultado = mysql_query($registro, $conexion);


echo '<table class="table table-striped table-condensed table-hover" >
        <tr>
          <th>#</th>
          <th>FECHA</th>
          <th>FACTURA</th>
          <th>VENTABTA</th>
          <th>DESCUENTO</th>  
          <th>VENTANETA</th>
          <th>IVA</th>
          <th>TOTAL</th>
          <th>CEDULA</th>
          <th>NOMBRE</th>          
        </tr>';
        $ventab = 0;
        $contador = 0;
        $desceunto = 0;
        $ventan = 0;
        $iva = 0;
        $total = 0;
if (mysql_num_rows($resultado) > 0) {
    while ($row = mysql_fetch_array($resultado)) {
        $contador = $contador + 1;
        $ventab = $ventab + $row['VENTABTA'];
        $desceunto = $desceunto + $row['DESCUENTO'];
        $ventan = $ventan + $row['VENTANET'];
        $iva = $iva + $row['IVA'];
        $total = $total + $row['TOTAL'];
        echo '<tr>
        <td>' . $contador . '</td>    
        <td>' . $row['FECHA'] . '</td>
        <td>' . $row['FACTURA'] . '</td>     
        <td>' . number_format($row['VENTABTA'], 2, '.', ',') . '</td>
        <td>' . number_format($row['DESCUENTO'], 2, '.', ',') . '</td>
        <td>' . number_format($row['VENTANET'], 2, '.', ',') . '</td>
        <td><b>' . number_format($row['IVA'], 2, '.', ',') . '</b></td>
        <td><b>' . number_format($row['TOTAL'], 2, '.', ',') . '</b></td>
        <td>' . $row['CEDULA'] . '</td>
        <td colspan="2">' . $row['NOMBRE'] . '</td>        
        </tr>';
    }
    echo '<tr>
        <th></th>
        <th></th>
        <th>' . number_format($contador, 0, '.', ',') . '</th>
        <th>' . number_format($ventab, 2, '.', ',') . '</th>
        <th>' . number_format($desceunto, 2, '.', ',') . '</th>
        <th>' . number_format($ventan, 2, '.', ',') . '</th>
        <th>' . number_format($iva, 2, '.', ',') . '</th>
        <th>' . number_format($total, 2, '.', ',') . '</th>
        <th></th>
        <th></th>        
        </tr>';
} else {
    echo '<tr>
		<td colspan="11">No se encontraron resultados</td>
	</tr>';
}
echo '</table>';


