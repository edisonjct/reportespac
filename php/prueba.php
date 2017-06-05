<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<?php
include 'conexion.php';
$IDB = $_GET['IDB'];

$sql = "SELECT * FROM pivot order by codigo";
$bodegas = "select codtab as codigo,siglastab as nombre from maetab WHERE numtab = '97' AND codtab != '' AND ad4tab != '0' AND siglastab IS NOT NULL ORDER BY ad6tab";
$result = mysql_query($sql, $conexion);
$result2 = mysql_query($bodegas, $conexion);

while ($col = mysql_fetch_row($result2)){
    $sql = "SELECT * FROM pivot order by codigo where bodega='$col[0]'";    
        echo '<table>
            <tr>';
        while($row = mysql_fetch_row($result)){
                echo '<td></td>
            </tr>';}
           echo '</table>';
        echo '<script type="text/javascript">alert("columna = " + "'.$col[1].'" + " fila= " + "'.$row[0].'");</script>';
    
    
}