<?php
include 'conexion.php';

$tipo = $_GET["tipo"];
$IDB = $_GET["IDB"];
$key = $_GET["keyword"];

if (!empty($key)) {
    $query = "select codcte01,coddest01,nomcte01 from maepag WHERE nomcte01 LIKE '%$key%' AND tipcte01='$tipo' ORDER BY nomcte01 LIMIT 10";
    $result = mysql_query($query, $conexion);
    if (!empty($result)) {
        ?>
        <ul id="country-list">
            <?php
            while ($row = mysql_fetch_assoc($result)) {
                ?>
                <li onClick="selectprovedor('<?php echo $row["nomcte01"]; ?>','<?php echo $row["codcte01"]; ?>');"><?php echo $row["nomcte01"] ; ?></li>
            <?php } ?>
        </ul>
        <?php
    }
}