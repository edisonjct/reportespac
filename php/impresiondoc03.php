<HTML>
    <HEAD>
        <script>
            function imprimir() {
                window.print(this);
                setTimeout(window.close,100);
            }
        </script>
        <STYLE type="text/css">
            span {
                font-family: monospace;
                font-size: 13px;
            }
            td {
                font-family: monospace;
                font-size: 12px;
            }
            #detallef{
                font-family: monospace;
                font-size: 12px;
                height:375px;
            }
            #formasdp{
                font-family: monospace;
                font-size: 34px;
                float:left;
                width: 125px;
                min-width: 125px;
            }
            #total{
                font-family: monospace;
                font-size: 14px;
                float:left;
                width: 125px;
            }
        </STYLE>
    <body onload="imprimir();">

        <?php
$IDB       = $_GET['IDB'];
$tipo      = $_GET['tipo'];
$documento = $_GET['documento'];
$cliente   = $_GET['cliente'];
$cajero    = $_GET['cajero'];
$fecha     = $_GET['fecha'];

$link = mysql_connect('localhost', 'root', '');
mysql_select_db('mrbooks') or die('No se pudo seleccionar la base de datos');

switch ($tipo) {
    case '80':
        $query  = "SELECT substring(nomcte01,1,24) as nombre,substring(dircte01,1,25) as dir,cascte01 as ruc from maecte WHERE codcte01 = '$cliente'";
        $result = mysql_query($query, $link) or die('Consulta fallida: ' . mysql_error());
        $row    = mysql_fetch_array($result);

        $queryff = "select substring(nomtab,1,8) as fpago, valorabono43 as valor
                from movcte
                INNER JOIN maetab ON movcte.efectcheque43 = maetab.codtab
                WHERE numdocdb43 = '$documento' AND codcte43 = '$cliente' AND tipodocdb43='02' AND numtab = '78' AND codtab <> ''";
        $resultff = mysql_query($queryff, $link) or die('Consulta fallida: ' . mysql_error());

        echo '<div>
                <div><span>COD:&nbsp&nbsp&nbsp</span><span>' . $documento . '</span></div>
                <div><span>CLIENTE:&nbsp</span><span>' . $row['nombre'] . '</span></div>
                <div><span>RUC:&nbsp&nbsp&nbsp&nbsp</span><span>' . $cliente . '</span></div>
                <div><span>DIRECCION:&nbsp&nbsp</span><span>' . $row['dir'] . '</span></div>
                <div><span>FECHA:&nbsp&nbsp&nbsp&nbsp</span><span>' . $fecha . '</span></div>
                <div><span>ATENDIDO:&nbsp&nbsp&nbsp&nbsp</span><span>' . $cajero . '</span></div>
                <div><span>_____________________________________</span></div>
             </div>';
        mysql_free_result($result);
        mysql_close($link);

        include 'conexion.php';
        $sql = "SELECT
                m.codbar01 as codigo,
                substring(m.desprod01,1,21) as titulo,
                d.CANTID03 as cant,
                d.PRECVTA03 as pvpu,
                d.iva03 as iva,
                d.DESCVTA03 as desct
                FROM
                movpro as d
                INNER JOIN maepro m ON d.CODPROD03 = m.codprod01
                WHERE TIPOTRA03 = '$tipo' AND NOCOMP03 = '$documento'";
        $resultdeta = mysql_query($sql, $conexion);

        $sqltotal = "SELECT
                sum(d.PRECVTA03) as subtotal,
                Sum(d.desctotvta03+d.DESCVTA03+d.desctotfp03) AS DESCUENTO,
                (select if(sum(c.PRECVTA03) IS NULL,'0.00',sum(c.PRECVTA03)) from movpro c WHERE c.TIPOTRA03 = '$tipo' AND c.NOCOMP03 = '$documento' AND c.iva03='0') as tarifa0,
                (select if(sum(c.PRECVTA03) IS NULL,'0.00',sum(c.PRECVTA03)) from movpro c WHERE c.TIPOTRA03 = '$tipo' AND c.NOCOMP03 = '$documento' AND c.iva03<>'0') as tarifaiva,
                ROUND(Sum(((d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03)*d.iva03)/100),2) AS IVA,
                (Sum(d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03))+(ROUND(Sum(((d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03)*d.iva03)/100),2)) AS TOTAL
                FROM
                movpro AS d
                WHERE d.TIPOTRA03 = '$tipo' AND d.NOCOMP03 = '$documento'
                GROUP BY d.NOCOMP03";
        $resulttotal = mysql_query($sqltotal, $conexion);
        $rowtt       = mysql_fetch_array($resulttotal);

        $contador = 0;
        echo '<div id="detallef">
                <table width="300px" border="0px" cellspacing="0">';
        while ($rowdeta = mysql_fetch_array($resultdeta)) {
            $contador = $contador + $rowdeta['cant'];
            echo '
                        <tr>
                            <td colspan="2" width="78px">' . $rowdeta['codigo'] . '&nbsp&nbsp</td>
                            <td colspan="3" width="200px">' . $rowdeta['titulo'] . '</td>
                        </tr>
                        <tr>
                            <td width="40px">' . number_format($rowdeta['cant'], 0, '.', ',') . '</td>
                            <td width="30px">' . $rowdeta['pvpu'] . '</td>
                            <td width="55px">' . number_format($rowdeta['iva'], 0, '.', ',') . ' %</td>
                            <td width="55px">' . number_format($rowdeta['desct'], 2, '.', ',') . '</td>
                            <td width="55px">' . number_format($rowdeta['pvpu'], 2, '.', ',') . '</td>
                        </tr>
                    ';
        }
        echo '</table></div>';
        mysql_free_result($resultdeta);
        mysql_close($conexion);

        echo '<table cellspacing="0">
            <tr>
                <td>Total de item: ' . $contador . '<td>
                <td>&nbsp&nbsp_________________<td>
            </tr>
            </table>';

        echo '<div id="formasdp">
            <table cellspacing="0">';
        if (mysql_num_rows($resultff) > 0) {
            while ($rowff = mysql_fetch_array($resultff)) {
                echo '<tr>
                        <td width="65px">' . $rowff['fpago'] . '</td>
                        <td width="40px">' . $rowff['valor'] . '</td>
                    <tr>';
            }
        } else {
            echo '<tr>
                <td width="65px"></td>
             <tr>';
        }
        echo '</table>
          </div>';
        mysql_free_result($resultff);

        echo '<div id="total">
            <table cellspacing="0">
                <tr>
                    <td width="80px">SUBTOTAL</td>
                    <td align="right">' . $rowtt['subtotal'] . '</td>
                <tr>
                <tr>
                    <td width="80px">DESCUENTO</td>
                    <td align="right">' . number_format($rowtt['DESCUENTO'], 2, '.', ',') . '</td>
                <tr>
                <tr>
                    <td width="80px">TARIFA 0</td>
                    <td align="right">' . $rowtt['tarifa0'] . '</td>
                <tr>
                <tr>
                    <td width="80px">TARIFA 12</td>
                    <td align="right">' . $rowtt['tarifaiva'] . '</td>
                <tr>
                <tr>
                    <td width="80px">IVA 12%</td>
                    <td align="right">' . $rowtt['IVA'] . '</td>
                <tr>
                <tr>
                    <td width="80px">TOTAL</td>
                    <td align="right">' . number_format($rowtt['TOTAL'], 2, '.', ',') . '</td>
                <tr>
            </table>
          </div>';

        break;

    case '22':
        $query  = "SELECT substring(nomcte01,1,24) as nombre,substring(dircte01,1,25) as dir,cascte01 as ruc from maecte WHERE codcte01 = '$cliente'";
        $result = mysql_query($query, $link) or die('Consulta fallida: ' . mysql_error());
        $row    = mysql_fetch_array($result);

        $docm = $_GET['docm'];

        $queryff = "select substring(nomtab,1,8) as fpago, valorabono43 as valor
        from movcte
        INNER JOIN maetab ON movcte.efectcheque43 = maetab.codtab
        WHERE numdocdb43 = '$documento' AND codcte43 = '$cliente' AND tipodocdb43='02' AND numtab = '78' AND codtab <> ''";
        $resultff = mysql_query($queryff, $link) or die('Consulta fallida: ' . mysql_error());

        echo '<div>
                <div><span>COD:&nbsp&nbsp&nbsp</span><span>' . $docm . '</span></div>
                <div><span>CLIENTE:&nbsp</span><span>' . $row['nombre'] . '</span></div>
                <div><span>RUC:&nbsp&nbsp&nbsp&nbsp</span><span>' . $cliente . '</span></div>
                <div><span>DIRECCION:&nbsp&nbsp</span><span>' . $row['dir'] . '</span></div>
                <div><span>FECHA:&nbsp&nbsp&nbsp&nbsp</span><span>' . $fecha . '</span></div>
                <div><span>ATENDIDO:&nbsp&nbsp&nbsp&nbsp</span><span>' . $cajero . '</span></div>
                <div><span>______________________________________</span></div>
             </div>';
        mysql_free_result($result);
        mysql_close($link);
        include 'conexion.php';
        $sql = "SELECT
                m.codbar01 as codigo,
                substring(m.desprod01,1,21) as titulo,
                d.CANTID03 as cant,
                d.PRECVTA03 as pvpu,
                d.iva03 as iva,
                d.DESCVTA03 as desct
                FROM
                movpro as d
                INNER JOIN maepro m ON d.CODPROD03 = m.codprod01
                WHERE TIPOTRA03 = '$tipo' AND NOCOMP03 = '$documento'";
        $resultdeta = mysql_query($sql, $conexion);

        $sqltotal = "SELECT
        sum(d.PRECVTA03) as subtotal,
        Sum(d.desctotvta03+d.DESCVTA03+d.desctotfp03) AS DESCUENTO,
        (select if(sum(c.PRECVTA03) IS NULL,'0.00',sum(c.PRECVTA03)) from movpro c WHERE c.TIPOTRA03 = '$tipo' AND c.NOCOMP03 = '$documento' AND c.iva03='0') as tarifa0,
        (select if(sum(c.PRECVTA03) IS NULL,'0.00',sum(c.PRECVTA03)) from movpro c WHERE c.TIPOTRA03 = '$tipo' AND c.NOCOMP03 = '$documento' AND c.iva03<>'0') as tarifaiva,
        ROUND(Sum(((d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03)*d.iva03)/100),2) AS IVA,
        (Sum(d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03))+(ROUND(Sum(((d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03)*d.iva03)/100),2)) AS TOTAL
        FROM
        movpro AS d
        WHERE d.TIPOTRA03 = '$tipo' AND d.NOCOMP03 = '$documento'
        GROUP BY d.NOCOMP03";
        $resulttotal = mysql_query($sqltotal, $conexion);
        $rowtt       = mysql_fetch_array($resulttotal);

        $contador = 0;
        echo '<div id="detallef">
                <table width="250px" border="0px" cellspacing="0">';
        while ($rowdeta = mysql_fetch_array($resultdeta)) {
            $contador = $contador + $rowdeta['cant'];
            echo '
                        <tr>
                            <td colspan="2" width="80px">' . $rowdeta['codigo'] . '&nbsp&nbsp</td>
                            <td colspan="3" width="170px">' . $rowdeta['titulo'] . '</td>
                        </tr>
                        <tr>
                            <td width="40px">' . number_format($rowdeta['cant'], 0, '.', ',') . '</td>
                            <td width="30px">' . $rowdeta['pvpu'] . '</td>
                            <td width="55px"> %</td>
                            <td width="55px"></td>
                            <td width="55px">' . number_format($rowdeta['pvpu'], 2, '.', ',') . '</td>
                        </tr>
                    ';
        }
        echo '</table></div>';
        mysql_free_result($resultdeta);
        mysql_close($conexion);

        echo '<table cellspacing="0">
            <tr>
                <td>Total de items: ' . $contador . '<td>
                <td>&nbsp&nbsp_________________<td>
            </tr>
            </table>';

        echo '<div id="formasdp">
            <table cellspacing="0">';
        if (mysql_num_rows($resultff) > 0) {
            while ($rowff = mysql_fetch_array($resultff)) {
                echo '<tr>
                        <td width="65px">' . $rowff['fpago'] . '</td>
                        <td width="40px">' . $rowff['valor'] . '</td>
                    <tr>';
            }
        } else {
            echo '<tr>
                <td width="65px"></td>
             <tr>';
        }
        echo '</table>
          </div>';
        mysql_free_result($resultff);

        echo '<div id="total">
            <table cellspacing="0">
                <tr>
                    <td width="80px">SUBTOTAL</td>
                    <td align="right">' . $rowtt['subtotal'] . '</td>
                <tr>
                <tr>
                    <td width="80px">DESCUENTO</td>
                    <td align="right">' . number_format($rowtt['DESCUENTO'], 2, '.', ',') . '</td>
                <tr>
                <tr>
                    <td width="80px">TARIFA 0</td>
                    <td align="right">' . $rowtt['tarifa0'] . '</td>
                <tr>
                <tr>
                    <td width="80px">TARIFA 12</td>
                    <td align="right">' . $rowtt['tarifaiva'] . '</td>
                <tr>
                <tr>
                    <td width="80px">IVA 12%</td>
                    <td align="right">' . $rowtt['IVA'] . '</td>
                <tr>
                <tr>
                    <td width="80px">TOTAL</td>
                    <td align="right">' . number_format($rowtt['TOTAL'], 2, '.', ',') . '</td>
                <tr>
            </table>
          </div>';

        break;
}
?>
    </div>
</body>
</HTML>