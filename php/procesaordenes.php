<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'conexion.php';



$provedor = $_GET["provedor"];
$IDB = $_GET["IDB"];
$idpro = $_GET["idpro"];
$imp = $_GET["imp"];
$desde = $_GET["desde"];
$hasta = $_GET["hasta"];

if ($idpro == 1) {
    $query = "SELECT
        CONCAT(nopedido30,' - ',fecpedido30) as nombre,
        nopedido30 as orden
        FROM
        maeord30
        WHERE codcte30 = '$provedor' AND fecpedido30 BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND status30 != '09'
        GROUP BY nopedido30
        ORDER BY fecpedido30 DESC";
    $result = mysql_query($query, $conexion);
    while ($row = mysql_fetch_assoc($result)) {
        ?>
        <option value="'<?php echo $row['orden']; ?>'"><?php echo $row['nombre']; ?></option>
        <?php
    }
}
if ($idpro == 2) {
    $query = "SELECT
        CONCAT(nopedido30,' - ',nomcte30,' - ',fecpedido30) as nombre,
        nopedido30 as orden
        FROM
        movproimp30 
        WHERE tipodoc30 = '$imp' AND fecpedido30 BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND status30 != '09'
        GROUP BY
        nopedido30
        ORDER BY fecpedido30 DESC";
    $result = mysql_query($query, $conexion);
    while ($row = mysql_fetch_assoc($result)) {
        ?>
        <option value="'<?php echo $row['orden']; ?>'"><?php echo $row['nombre']; ?></option>
        <?php
    }
}

if ($idpro == 3) {
    $query = "SELECT
        tipodoc30 as codigo,
        tipodoc30 as nombre
        FROM
        movproimp30
        WHERE fecpedido30 BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND status30 != '09'
        GROUP BY
        tipodoc30
        ORDER BY fecpedido30 DESC";
    $result = mysql_query($query, $conexion);
    echo '<option value="todos">Selecione Importacion</option>';
    while ($row = mysql_fetch_assoc($result)) {
        ?>
        <option value="<?php echo $row['codigo']; ?>"><?php echo $row['nombre']; ?></option>
        <?php
    }
}