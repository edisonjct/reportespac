<script src="../js/myjava.js"></script>
<?php
$factura = $_GET['factura'];
$cliente = $_GET['cliente'];
$IDB = $_GET['IDB'];

$random = mysql_connect('localhost', 'root', '');
mysql_select_db('mrbooks', $random);
$sql = "select imagen,codigo from mrbmkt WHERE estado = 1 ORDER BY RAND() LIMIT 1;";
$result = mysql_query($sql, $random);
$row = mysql_fetch_array($result);


if($IDB >= '13'){	
	echo '<div id=imprimeme>
	<img src="../recursos/librimundi.png" width="180" height="80" alt="" /><br>
        <img src="../recursos/'.$row['imagen'].'" width="180" height="80" alt="" /><br>
	'.$cliente.'<br><br>
	</div>';
} else {
	echo '<div id=imprimeme align="center">
            <table>
                <tr>
                    <td><center><h3>DESCUENTO EN TU PRÓXIMA COMPRA</h3></center></td>
                </tr>
                <tr>
                    <td><center><img src="../recursos/mrbooks.png" width="60" height="20" alt="" /></center></td>
                </tr>
                <tr>
                    <td><center><img src="../recursos/'.$row['imagen'].'" width="180" height="100" alt="" /></center></td>
                </tr>
                <tr>
                    <td><center><img src="../recursos/'.$row['codigo'].'" width="60" height="20" alt="" /></center></td>
                </tr>
                <tr>
                    <td><center>Valido Hasta 15 de Mayo</center></td>
                </tr>
                <tr>
                    <td><center>Aplican Restricciones</center></td>
                </tr>
            </table><br><br>
	</div>';
}
echo '<center><br><a onclick="confirmation();"><img src="../recursos/impresora.png" width="55" height="55" alt="" /></a></center>';
