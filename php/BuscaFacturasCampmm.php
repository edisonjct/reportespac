<?php

include('conexion.php');

$desde = $_GET['desde'];
$hasta = $_GET['hasta'];
$IDB = $_GET['IDB'];
$ID = $_GET['ID'];
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
        c.nomcte31 AS NOMBRE,
	maetab.nomtab as condicion,
        c.lineaprod31 as observacion,
        CASE
        WHEN c.lineaprod31 = '2481' THEN 'AGROPESA'
        WHEN c.lineaprod31 = '2900' THEN 'KYWI'
        WHEN c.lineaprod31 = '2901' THEN 'TVENTAS'
        WHEN c.lineaprod31 = '2902' THEN 'MAXITEC'
        WHEN c.lineaprod31 = '2903' THEN 'TATOO'
        WHEN c.lineaprod31 = '2904' THEN 'BEBEMUNDO'
        WHEN c.lineaprod31 = '2905' THEN 'AUTOMAX'
        WHEN c.lineaprod31 = '2906' THEN 'SUKASA'
        WHEN c.lineaprod31 = '2907' THEN 'LIBRIMUNDI'
        WHEN c.lineaprod31 = '2908' THEN 'MR BOOKS'
        WHEN c.lineaprod31 = '2909' THEN 'INVEDE'
        WHEN c.lineaprod31 = '2910' THEN 'POFASA'
        WHEN c.lineaprod31 = '2911' THEN 'MAXIPAN'
        WHEN c.lineaprod31 = '2912' THEN 'FAVIMATIC'
        WHEN c.lineaprod31 = '2913' THEN 'FLEXIPLAST'
        WHEN c.lineaprod31 = '2914' THEN 'ENERMAX'
        WHEN c.lineaprod31 = '2915' THEN 'IMPORPOINT'
        WHEN c.lineaprod31 = '2916' THEN 'SERUVI S.A.'
        WHEN c.lineaprod31 = '2050' THEN 'SUPERMAXI' ELSE 'SIN ASIGNACION' END AS empresa
        FROM
        movpro AS d
        LEFT JOIN maefac AS c ON d.NOCOMP03 = c.nofact31
        LEFT JOIN maecte ON c.nocte31 = maecte.codcte01
	INNER JOIN maetab ON c.condpag31 = maetab.codtab
        WHERE
        d.TIPOTRA03 = '80' AND maetab.numtab = '72' AND maetab.codtab != '' AND
        c.cvanulado31 != '9' AND
        c.condpag31 IN ($condicion) AND 		
        d.FECMOV03 BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' 
        GROUP BY d.NOCOMP03        
        ORDER BY d.FECMOV03 DESC";
        
    $resultado = mysql_query($registro, $conexion);
    echo '<div align="right"><a href="../php/buscafacturascampmmadm.php?IDB=' . $IDB . '&condicion=' . $condicion . '&desde='.$desde.'&hasta='.$hasta.'"><img src="../recursos/excel.png" width="20" height="20"></a></div>';
    echo '<table class="table table-striped table-condensed table-hover table-bordered" >        
        <tr>
          <th>CONDICION</th>
          <th>FECHA</th>
          <th>FACTURA</th>
          <th>V.BTA</th>
          <th>DSCT</th>  
          <th>V.NETA</th>
          <th>IVA</th>
          <th>TOTAL</th>
          <th>CEDULA</th>
          <th>NOMBRE</th>
          <th>CODIGO</th>
          <th>EMPRESA</th>
        </tr>';
        $ventab = 0;
        $contador = 0;
        $desceunto = 0;
        $ventan = 0;
        $iva = 0;
        $total = 0;
    if (mysql_num_rows($resultado) > 0) {
        while ($row = mysql_fetch_array($resultado)) {
            $ventab = $ventab + $row['VENTABTA'];
            $desceunto = $desceunto + $row['DESCUENTO'];
            $ventan = $ventan + $row['VENTANET'];
            $iva = $iva + $row['IVA'];
            $total = $total + $row['TOTAL'];
            echo '<tr>
                <td align="center">' . $row['condicion'] . '</td>
                <td align="center">' . $row['FECHA'] . '</td>
                <td align="center">' . $row['FACTURA'] . '</td>     
                <td align="center">' . number_format($row['VENTABTA'], 2, '.', ',') . '</td>
                <td align="center">' . number_format($row['DESCUENTO'], 2, '.', ',') . '</td>
                <td align="center">' . number_format($row['VENTANET'], 2, '.', ',') . '</td>
                <td align="center"><b>' . number_format($row['IVA'], 2, '.', ',') . '</b></td>
                <td align="center"><b>' . number_format($row['TOTAL'], 2, '.', ',') . '</b></td>
                <td align="center">' . $row['CEDULA'] . '</td>
                <td align="center">' . $row['NOMBRE'] . '</td>
                <td align="center">' . $row['observacion'] . '</td>
                <td align="center">' . $row['empresa'] . '</td>';            
            echo '</tr>';
        }
        echo '<tr>
        <th></th>
        <th></th>
        <th></th>
        <th>' . number_format($ventab, 2, '.', ',') . '</th>
        <th>' . number_format($desceunto, 2, '.', ',') . '</th>
        <th>' . number_format($ventan, 2, '.', ',') . '</th>
        <th>' . number_format($iva, 2, '.', ',') . '</th>
        <th>' . number_format($total, 2, '.', ',') . '</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        </tr>';
    } else {
        echo '<tr>
		<td colspan="12">No se encontraron resultados</td>
	</tr>';
    }
    echo '</table>';

