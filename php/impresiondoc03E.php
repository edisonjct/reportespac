<HTML>
    <HEAD>
        <script>
            function imprimir() {
                window.print(this);
                setTimeout(window.close, 100);
            }
        </script>
        <STYLE type="text/css">
            span {
                font-family: monospace;
                font-size: 13px;
            }
            #cabeceralocalesfinal {
                font-family: monospace;
                font-size: 14px;
                text-align: center;
                width: 250px;
            }
            #cabeceralocalesfinal2 {
                font-family: monospace;
                font-size: 14px;
                text-align: left;
                width: 250px;
            }

            td {
                font-family: monospace;
                font-size: 12px;
            }
            #detallef{
                font-family: monospace;
                font-size: 14px;
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
            #fin{
                font-family: monospace;
                font-size: 13px;
                width: 250px;
                text-align: center;
            }
            #datoscliente{
                font-family: monospace;
                font-size: 11px;
                width: 250px;
                text-align: left;
            }
        </STYLE>
    <body onload="imprimir();">

        <?php
include 'conexion.php';
echo $IDB  = $_GET['IDB'];
$tipo      = $_GET['tipo'];
$documento = $_GET['documento'];
$cliente   = $_GET['cliente'];
$cajero    = $_GET['cajero'];
$fecha     = $_GET['fecha'];

$link = mysql_connect('localhost', 'root', '');
mysql_select_db('mrbooks') or die('No se pudo seleccionar la base de datos');
?>
        <div id="cabeceralocalesfinal">
            <a>MISTERBOOKS S.A.</a><br>
            <a>R.U.C. 1791397339001</a><br>
            <a>CONTRIBUYENTE ESPECIAL</a><br>
            <a>Resolución 155 del 24/04/2000</a><br>
        </div>
        <br>
        <div id="cabeceralocalesfinal2">
            <a>MATRIZ-QUITO: Eloy Alfaro s/n y Avigiras</a><br>
            <a>TELEFONO: 281-1065 FAX:5932 281-1070</a><br>
            <a><?php echo $nomcc; ?>: <?php echo $direccion; ?></a><br>
            <a>TELEFONO: <?php echo $telefono; ?></a><br><br>
        </div>
        <?php
switch ($tipo) {
    case '80':
        $query = "SELECT
                substring(nomcte01,1,24) AS nombre,
                substring(dircte01,1,25) AS dir,
                maecte.cascte01 AS ruc,
                maecte.emailcte01 AS correo
                from maecte
                WHERE codcte01 = '$cliente'";
        $result = mysql_query($query, $link) or die('Consulta fallida: ' . mysql_error());
        $row    = mysql_fetch_array($result);

        $queryff = "select substring(nomtab,1,8) as fpago, valorabono43 as valor
                from movcte
                INNER JOIN maetab ON movcte.efectcheque43 = maetab.codtab
                WHERE numdocdb43 = '$documento' AND codcte43 = '$cliente' AND tipodocdb43='02' AND numtab = '78' AND codtab <> ''";
        $resultff = mysql_query($queryff, $link) or die('Consulta fallida: ' . mysql_error());
        ?>



                <div id="datoscliente">
                    <div><span>FACTURA:&nbsp</span><span><?php echo $documento; ?></span></div>
                    <div><span>CLIENTE:&nbsp</span><span><?php echo $row['nombre']; ?></span></div>
                    <div><span>RUC:&nbsp&nbsp&nbsp&nbsp</span><span><?php echo $cliente; ?></span></div>
                    <div><span>DIRECCION:&nbsp&nbsp</span><span><?php echo $row['dir']; ?></span></div>
                    <div><span>FECHA:&nbsp&nbsp&nbsp&nbsp</span><span><?php echo $fecha; ?></span></div>
                    <div><span>CORREO:&nbsp&nbsp</span><span><?php echo $row['correo']; ?></span></div>
                    <div><span>ATENDIDO:&nbsp&nbsp&nbsp&nbsp</span><span><?php echo $cajero; ?></span></div>
                    <div><span>__________________________________</span></div>
                </div>

                <?php
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
        ?>
                <div id="detallef">
                    <table width="300px" border="0px" cellspacing="0">
                        <?php
while ($rowdeta = mysql_fetch_array($resultdeta)) {
            $contador = $contador + $rowdeta['cant'];
            ?>
                            <tr>
                                <td colspan="2" width="78px"><?php echo $rowdeta['codigo']; ?>&nbsp&nbsp</td>
                                <td colspan="3" width="200px"><?php echo $rowdeta['titulo']; ?></td>
                            </tr>
                            <tr>
                                <td width="40px"><?php echo number_format($rowdeta['cant'], 0, '.', ','); ?></td>
                                <td width="30px"><?php echo $rowdeta['pvpu']; ?></td>
                                <td width="55px"><?php echo number_format($rowdeta['iva'], 0, '.', ','); ?> %</td>
                                <td width="55px"><?php echo number_format($rowdeta['desct'], 2, '.', ','); ?></td>
                                <td width="55px"><?php echo number_format($rowdeta['pvpu'], 2, '.', ','); ?></td>
                            </tr>
                        <?php }?>
                    </table>
                </div>
                <?php
mysql_free_result($resultdeta);
        mysql_close($conexion);
        ?>
                <br><br>
                <table cellspacing="0">
                    <tr>
                        <td>Total de item: <?php echo $contador; ?><td>
                        <td>&nbsp&nbsp&nbsp&nbsp__________________<td>
                    </tr>
                </table>

                <div id="formasdp">
                    <table cellspacing="0">
                        <?php
if (mysql_num_rows($resultff) > 0) {
            while ($rowff = mysql_fetch_array($resultff)) {
                ?>
                                <tr>
                                    <td width="65px"><?php echo $rowff['fpago']; ?></td>
                                    <td width="40px"><?php echo $rowff['valor']; ?></td>
                                <tr>
                                    <?php
}
        } else {
            ?>
                            <tr>
                                <td width="65px"></td>
                            <tr>
                            <?php }?>
                    </table>
                </div>
                <?php
mysql_free_result($resultff);
        ?>
                <div id="total">
                    <table cellspacing="0">
                        <tr>
                            <td width="80px">SUBTOTAL</td>
                            <td align="right"><?php echo $rowtt['subtotal']; ?></td>
                        <tr>
                        <tr>
                            <td width="80px">DESCUENTO</td>
                            <td align="right"><?php echo number_format($rowtt['DESCUENTO'], 2, '.', ','); ?></td>
                        <tr>
                        <tr>
                            <td width="80px">TARIFA 0</td>
                            <td align="right"><?php echo $rowtt['tarifa0']; ?></td>
                        <tr>
                        <tr>
                            <td width="80px">TARIFA 12</td>
                            <td align="right"><?php echo $rowtt['tarifaiva']; ?></td>
                        <tr>
                        <tr>
                            <td width="80px">IVA 12%</td>
                            <td align="right"><?php echo $rowtt['IVA']; ?></td>
                        <tr>
                        <tr>
                            <td width="80px">TOTAL</td>
                            <td align="right"><?php echo number_format($rowtt['TOTAL'], 2, '.', ','); ?></td>
                        <tr>
                    </table>
                </div>



                <?php
break;

    case '22':
        $query   = "SELECT substring(nomcte01,1,24) as nombre,substring(dircte01,1,25) as dir,cascte01 as ruc from maecte WHERE codcte01 = '$cliente'";
        $result  = mysql_query($query, $link) or die('Consulta fallida: ' . mysql_error());
        $row     = mysql_fetch_array($result);
        $docm    = $_GET['docm'];
        $queryff = "select substring(nomtab,1,8) as fpago, valorabono43 as valor
                from movcte
                INNER JOIN maetab ON movcte.efectcheque43 = maetab.codtab
                WHERE numdocdb43 = '$documento' AND codcte43 = '$cliente' AND tipodocdb43='02' AND numtab = '78' AND codtab <> ''";
        $resultff = mysql_query($queryff, $link) or die('Consulta fallida: ' . mysql_error());
        ?>
                <div>
                    <div><span>NOTA DE CREDITO:&nbsp&nbsp&nbsp</span><span><?php echo $docm; ?></span></div>
                    <div><span>CLIENTE:&nbsp</span><span><?php echo $row['nombre']; ?></span></div>
                    <div><span>RUC:&nbsp&nbsp&nbsp&nbsp</span><span><?php echo $cliente; ?></span></div>
                    <div><span>DIRECCION:&nbsp&nbsp</span><span><?php echo $row['dir']; ?></span></div>
                    <div><span>FECHA:&nbsp&nbsp&nbsp&nbsp</span><span><?php echo $fecha; ?></span></div>
                    <div><span>ATENDIDO:&nbsp&nbsp&nbsp&nbsp</span><span><?php echo $cajero; ?></span></div>
                    <div><span>______________________________________</span></div>
                </div>
                <?php
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
        ?>
                <div id="detallef">
                    <table width="300px" border="0px" cellspacing="0">
                        <?php
while ($rowdeta = mysql_fetch_array($resultdeta)) {
            $contador = $contador + $rowdeta['cant'];
            ?>
                            <tr>
                                <td colspan="2" width="78px"><?php echo $rowdeta['codigo']; ?>&nbsp&nbsp</td>
                                <td colspan="3" width="200px"><?php echo $rowdeta['titulo']; ?></td>
                            </tr>
                            <tr>
                                <td width="40px"><?php echo number_format($rowdeta['cant'], 0, '.', ','); ?></td>
                                <td width="30px"><?php echo $rowdeta['pvpu']; ?></td>
                                <td width="55px"><?php echo number_format($rowdeta['iva'], 0, '.', ','); ?> %</td>
                                <td width="55px"><?php echo number_format($rowdeta['desct'], 2, '.', ','); ?></td>
                                <td width="55px"><?php echo number_format($rowdeta['pvpu'], 2, '.', ','); ?></td>
                            </tr>
                        <?php }?>
                    </table>
                </div>
                <?php
mysql_free_result($resultdeta);
        mysql_close($conexion);
        ?>
                <table cellspacing="0">
                    <tr>
                        <td>Total de item: <?php echo $contador; ?><td>
                        <td>&nbsp&nbsp_________________<td>
                    </tr>
                </table>

                <div id="formasdp">
                    <table cellspacing="0">
                        <?php
if (mysql_num_rows($resultff) > 0) {
            while ($rowff = mysql_fetch_array($resultff)) {
                ?>
                                <tr>
                                    <td width="65px"><?php echo $rowff['fpago']; ?></td>
                                    <td width="40px"><?php echo $rowff['valor']; ?></td>
                                <tr>
                                    <?php
}
        } else {
            ?>
                            <tr>
                                <td width="65px"></td>
                            <tr>
                            <?php }?>
                    </table>
                </div>
                <?php
mysql_free_result($resultff);
        ?>
                <div id="total">
                    <table cellspacing="0">
                        <tr>
                            <td width="80px">SUBTOTAL</td>
                            <td align="right"><?php echo $rowtt['subtotal']; ?></td>
                        <tr>
                        <tr>
                            <td width="80px">DESCUENTO</td>
                            <td align="right"><?php echo number_format($rowtt['DESCUENTO'], 2, '.', ','); ?></td>
                        <tr>
                        <tr>
                            <td width="80px">TARIFA 0</td>
                            <td align="right"><?php echo $rowtt['tarifa0']; ?></td>
                        <tr>
                        <tr>
                            <td width="80px">TARIFA 12</td>
                            <td align="right"><?php echo $rowtt['tarifaiva']; ?></td>
                        <tr>
                        <tr>
                            <td width="80px">IVA 12%</td>
                            <td align="right"><?php echo $rowtt['IVA']; ?></td>
                        <tr>
                        <tr>
                            <td width="80px">TOTAL</td>
                            <td align="right"><?php echo number_format($rowtt['TOTAL'], 2, '.', ','); ?></td>
                        <tr>
                    </table>
                </div>
                <?php
break;
}
?>
        <div id="fin">
            <a>&nbsp&nbsp&nbsp</a><br>
            <a>Comprobantes Electronicos en: www.mrbooks.com/facturacion</a><br>
            <a>Para mas información: 1800-LIBROS</a><br>
            <a>Documento sin valor tributario</a><br>
            <a>SE ACEPTA CAMBIOS HASTA 7 DÍAS</a>
        </div>
    </body>
</HTML>