<?php
include 'conexion.php';
$IDB     = $_GET['IDB'];
$cupon   = $_GET['cupon'];
$factura = $_GET['factura'];
?>
<html>
    <head>
        <script>
            function imprimir1() {
                window.print(this);
                setTimeout(window.close, 100);
            }


        </script>
        <style type="text/css">
        #cupon {
            text-align: center;
            font: sans-serif;
            font-size: 16px;
        }
        </style>
        <body onload="imprimir();">
            <?php

$query  = "UPDATE maefac SET campo231='$cupon' WHERE (tipodocto31='02') AND (nofact31='$factura') LIMIT 1;";
$result = mysql_query($query, $conexion);

switch ($cupon) {
    case '1': ?>
    <table>
        <tr>
            <td><img src="../recursos/mamac2.fw.png" width="300px" height="120px"></td>
        </tr>
        <tr>
             <td><div id="cupon"><img src="../recursos/regalo bolso.fw.png" width="200px" height="200px"></div></td>
        </tr>
        <tr>
             <td><div id="cupon"><img src="../recursos/maletacodigo.png" width="160px" height="80px"></div></td>
        </tr>
        <tr>
             <td><div id="cupon">Promoción valida del 1 al 20 de Mayo</div></td>
        </tr>
        <tr>
             <td><div id="cupon">Promoción valida hasta agotar stock</div></td>
        </tr>
        <tr>
             <td><div id="cupon">Promoción valida en su siguiente compra</div></td>
        </tr>
        <tr>
             <td><div id="cupon"><img src="../recursos/mrbooks.png" width="100px" height="60px"></div></td>
        </tr>
    </table>
    <?php
break;
    case '2':

        if ($IDB == '03') {?>
        <table>
            <tr>
                <td><img src="../recursos/mamac2.fw.png" width="300px" height="120px"></td>
            </tr>
            <tr>
                 <td><div id="cupon"><img src="../recursos/portaretratos2.png" width="200px" height="200px"></div></td>
            </tr>
            <tr>
                 <td><div id="cupon"><img src="../recursos/codigoporta.png" width="160px" height="80px"></div></td>
            </tr>
            <tr>
                 <td><div id="cupon">Promoción valida del 1 al 20 de Mayo</div></td>
            </tr>
            <tr>
                 <td><div id="cupon">Promoción valida hasta agotar stock</div></td>
            </tr>
            <tr>
                 <td><div id="cupon">Promoción valida en su siguiente compra</div></td>
            </tr>
            <tr>
                 <td><div id="cupon"><img src="../recursos/mrbooks.png" width="100px" height="60px"></div></td>
            </tr>
        </table>
        <?php } else {?>
         <table>
            <tr>
                <td><img src="../recursos/mamac2.fw.png" width="300px" height="120px"></td>
            </tr>
            <tr>
                 <td><div id="cupon"><img src="../recursos/regalo jarro.fw.png" width="200px" height="200px"></div></td>
            </tr>
            <tr>
                 <td><div id="cupon"><img src="../recursos/jarrocodigo.png" width="160px" height="80px"></div></td>
            </tr>
            <tr>
                 <td><div id="cupon">Promoción valida del 1 al 20 de Mayo</div></td>
            </tr>
            <tr>
                 <td><div id="cupon">Promoción valida hasta agotar stock</div></td>
            </tr>
            <tr>
                 <td><div id="cupon">Promoción valida en su siguiente compra</div></td>
            </tr>
            <tr>
                 <td><div id="cupon"><img src="../recursos/mrbooks.png" width="100px" height="60px"></div></td>
            </tr>
        </table>
    <?php }
        break;
    case '3': ?>
    <table>
        <tr>
            <td><img src="../recursos/mamac2.fw.png" width="300px" height="120px"></td>
        </tr>
        <tr>
             <td><div id="cupon"><img src="../recursos/quince.fw.png" width="200px" height="200px"></div></td>
        </tr>
        <tr>
             <td><div id="cupon">Promoción valida del 1 al 20 de Mayo</div></td>
        </tr>
        <tr>
             <td><div id="cupon">Promoción valida hasta agotar stock</div></td>
        </tr>
        <tr>
             <td><div id="cupon">Promoción valida en su siguiente compra</div></td>
        </tr>
        <tr>
             <td><div id="cupon"><img src="../recursos/mrbooks.png" width="100px" height="60px"></div></td>
        </tr>
    </table>
    <?php
break;
}
