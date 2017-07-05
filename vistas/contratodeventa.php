<?php
session_start();
$_SESSION['UID'] = '1158';
if ($_SESSION['UID']) {
    include_once './Header.php';
    include_once '../php/conexion.php';
    $IDB = $_GET['IDB'];
    $ID = $_GET['ID'];
    $UID = $_SESSION['UID'];
    $n = rand(0, 1000000);

    $secuencual = "SELECT ad1tab as ultimo FROM maetab WHERE numtab = '41' AND codtab = '85.1' LIMIT 1;";
    $result_secuencial = mysql_query($secuencual);
    $row_secuencial = mysql_fetch_array($result_secuencial);
    $ultimo = number_format($row_secuencial['ultimo'], 0, '', '');
    $utimosec = $ultimo + 1;
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <title><?php echo $nombreb; ?></title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
            <link rel="stylesheet" href="../css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="../css/estilo.css">
            <link href="../css/bootstrap-datetimepicker.css" rel="stylesheet">
            <script src="../js/jquery-1.12.4.min.js" type="text/javascript"></script>
            <script src="../js/bootstrap.min.js"></script>
            <script type="text/javascript" src="../js/moment.js"></script>
            <script src="../js/bootstrap-datetimepicker.min.js"></script>
            <script type="text/javascript" src="../js/facturacion.js"></script>
            <style>
                #cabecera {
                    width: 70%;
                    height: 10px;
                }
                #contacto {
                    width: 30%;
                    height: 10px;
                }
                #nombrecb{
                    text-align: right;
                }

                input[type="text"] {
                    height: 13px;
                }

                #datoscontrado{
                    max-height: 400px;
                }

                #modificarcorreocliente{
                    height: 15px;
                }
                .wrapper {
                    position: relative;
                    padding-bottom: 0px;
                    overflow-y: scroll;
                }
                .botonfacturar{
                    -webkit-border-radius: 4;
                    -moz-border-radius: 4;
                    border-radius: 4px;                    
                    color: #000000;
                    font-size: 12px;
                    background: #ebebeb;
                    padding: 2px 35px 2px 35px;
                    border: solid #0e6c9e 1px;
                    text-decoration: none;
                }
            </style>
        </head>
        <br>
        <body onload="carga_secuencual()">
            <div class="container">
                <div class="wrapper" id="datoscontrado">
                    <form class="form-inline" role="form" method="POST" id="formulario">
                        <center>
                            <input class="hide" type="text" required="required" readonly="readonly" id="IDB" value=<?php echo $IDB; ?> />
                            <input class="hide" type="text" required="required" readonly="readonly" id="UID" value=<?php echo $UID; ?> />
                            <input class="hide" type="text" required="required" readonly="readonly" id="rando" value=<?php echo $n; ?> />
                            <input class="hide" type="text" required="required" readonly="readonly" id="txt-ultimo-doc" value=<?php echo $utimosec; ?> />

                            <table id="cabecera">
                                <tr>
                                    <th colspan="6">INGRESO DE CONTRATO DE VENTA</th>
                                </tr>
                                <tr>
                                    <td width="15%" id="nombrecb">* TIPO DE DOCUMENTO:&nbsp&nbsp</td>
                                    <td width="30%">
                                        <SELECT  SIZE="1" id="tipodocumento">
                                            <OPTION VALUE="01">Contrato de Venta</OPTION>
                                        </SELECT>
                                    </td>
                                    <td width="10%"></td>
                                    <td width="15%" id="nombrecb">FECHA FACTURA:&nbsp&nbsp</td>
                                    <td width="30%"><label><?php echo date("m/d/Y"); ?></label></td>
                                </tr>
                                <tr>
                                    <td width="15%" id="nombrecb">* CLIENTE:&nbsp&nbsp</td>
                                    <td width="30%">
                                        <input type="text" size="15%" id="txt-cedula-cliente" onchange="buscar_clientes();">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                        <a href="javascript:abrir('../../../ccprog/creacliente.php?IDB=01&ID=1088')"><img src="../recursos/cte.png" border="0" width="15" height="15"></a>

                                    </td>
                                    <td width="10%"></td>
                                    <td width="15%" id="nombrecb">* NOMBRE:&nbsp&nbsp</td>
                                    <td width="30%"><input type="text" name="fname" size="35%" disabled="true" id="txt-cliente"></td>
                                </tr>
                                <tr>
                                    <td width="15%" id="nombrecb">* DIRECCION:&nbsp&nbsp</td>
                                    <td width="30%">
                                        <input type="text" name="fname" size="50%" id="txt-direccion" disabled="true">
                                    </td>
                                    <td width="10%"></td>
                                    <td width="15%" id="nombrecb">* TELEFONO:&nbsp&nbsp</td>
                                    <td width="30%"><input type="text" name="fname" size="35%" id="txt-telefono" disabled="true"></td>
                                </tr>
                                <tr>
                                    <td width="15%" id="nombrecb">* VENDEDOR:&nbsp&nbsp</td>
                                    <td width="30%">
                                        <select required="required" id="cmb-vendedores" name="cmb-vendedores">
                                            <option value="0000">OFICINA</option>
                                            <?php
                                            include_once '../php/conexionC.php';
                                            $query = mysql_query("SELECT t.codtab AS codigo, t.nomtab as nombre FROM mrbooks.maetab as t WHERE t.numtab = '73' AND t.codtab != '' AND t.ad2tab != '9' ORDER BY t.nomtab");
                                            if (mysql_num_rows($query) > 0) {
                                                while ($row = mysql_fetch_array($query)) {
                                                    echo "<option value='" . $row['codigo'] . "'>" . $row['nombre'] . "</option>\n";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td width="10%"></td>
                                    <td width="15%" id="nombrecb">* CORREO:&nbsp&nbsp</td>
                                    <td width="30%"><input type="text" name="txt-correo" size="35%" id="txt-correo" maxlength="100" onkeyup="validateMail('txt-correo')"></td>
                                </tr>
                                <tr>
                                    <td width="15%" id="nombrecb">* ULTIMO DOCUMENTO:&nbsp&nbsp</td>
                                    <td width="30%"><label id="ultimodocumento"></label></td>
                                    <td width="10%"></td>
                                    <td width="10%"></td>
                                    <td width="10%"></td>
                                </tr>
                            </table>
                            <div id="contacto-detalle">
                                <table id="contacto">
                                    <tr>
                                        <th colspan="2">DETALLE DEL CONTACTO</th>
                                    </tr>
                                    <tr>
                                        <td width="10%" id="nombrecb">* CEDULA:&nbsp&nbsp</td>
                                        <td width="30%"><input type="text" size="25%" id="txt-contacto-cedula"></td>
                                    </tr>
                                    <tr>
                                        <td width="10%" id="nombrecb">* NOMBRE:&nbsp&nbsp</td>
                                        <td width="30%"><input type="text" size="55%" id="txt-contacto-nombre"></td>
                                    </tr>
                                    <tr>
                                        <td width="10%" id="nombrecb">* TELEFONO:&nbsp&nbsp</td>
                                        <td width="30%"><input type="text" size="25%" id="txt-contacto-telefono"></td>
                                    </tr>
                                    <tr>
                                        <td width="10%" id="nombrecb">* CORREO:&nbsp&nbsp</td>
                                        <td width="30%"><input type="text" size="55%" id="txt-contacto-correo" maxlength="100" onkeyup="validateMail('txt-contacto-correo')"></td>
                                    </tr>
                                </table>
                            </div>
                            <br>
                            <div id="detalleproductos">
                                <table width="50%" border="0" id="detalle">
                                    <tr>
                                        <th colspan="7">DETALLE DE CONTRATO</th>
                                    </tr>
                                    <tr>
                                        <td width="1%"></td>
                                        <td width="2%">* CODIGO</td>
                                        <td width="10%" align="center">TITULO:</td>
                                        <td width="1%" align="right">* STOCK:</td>
                                        <td width="1%" align="center">* CANTID.</td>
                                        <td width="1%" align="center">* P. UNIT.</td>
                                        <td width="1%" align="center">TOTAL</td>
                                    </tr>
                                </table>
                                <table width="50%" border="0" id="detalle">
                                    <div id="detalleagregado" ></div>
                                </table>
                                <div id="detallenuevo">
                                    <table width="50%" border="0" id="detalle">
                                        <tr>
                                            <td width="1%"><img src="../recursos/b_drop.png" onclick="eliminarultimalinea(), addformadepago();"></td>
                                            <td width="5%"><input type="text" size="15%" id="txt-codigo" onchange="agregaritemtmp();"></td>
                                            <td width="2%"></td>
                                            <td width="2%"></td>
                                            <td width="3%"></td>
                                            <td width="2%"><div align="center"><input type="text" size="2%" id="txt-cant" value="1"></div></td>
                                            <td width="3%"></td>
                                        </tr>
                                    </table>
                                </div>
                                <div id="agregarnuevo">
                                    <table width="50%" border="0" id="detalle">
                                        <tr>
                                            <td><img src="../recursos/b_ins row.png" onclick="agregarlinea();"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <div id="formasdepago">
                                <table width="40%" border="0" id="detalle">
                                    <tr>
                                        <th colspan="4">DETALLE DEL PAGO</th>
                                    </tr>
                                    <tr>
                                        <td>* FORMA DE PAGO</td>
                                        <td>CUENTA/LOTE:</td>
                                        <td>FECHA:</td>
                                        <td>VALOR:</td>
                                    </tr>
                                </table>
                                <table width="40%" border="0" id="detalle">
                                    <div id="detalleformadepago"></div>
                                </table>
                                <table width="40%" border="0" id="detalle">
                                    <tr>
                                        <td><img src="../recursos/b_ins row.png" onclick="agregarlineafp();"></td>
                                    </tr>
                                </table>
                                <br>
                                <table width="7%">
                                    <tr>
                                        <td colspan="2"><input class="botonfacturar" size="15%" type="button" onclick="generarfactura();" value="FACTURAR"></td>
                                    </tr>
                                    <tr>
                                        <th>DINERO</th>
                                        <th>CAMBIO</th>
                                    </tr>
                                    <tr>
                                        <td><input type="text" size="10%" id="txt"></td>
                                        <td><label id="ultimodocumento"></label></td>
                                    </tr>
                                </table>
                            </div>
                        </center>
                    </form>
                </div>
                <div id="">

                </div>
                <br>
                <center>
                    <div id="respuesta"></div>
                </center>
            </div>
            <script src="../js/bootstrap.min.js"></script>
        </body>
    </html>

    <?php
} else {
    echo "No Se a Inicado Session";
}
