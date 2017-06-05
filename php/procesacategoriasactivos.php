<?php

include('conexionC.php');

if (isset($_GET["idccatpadre"])) {
    $categoria = $_GET["idccatpadre"];
    $query = mysql_query("SELECT codcate ,desccate FROM mrbooks.categorias WHERE tipocate = '07' AND codcate <> '0' AND LENGTH(codcate) > 2 AND SUBSTRING(codcate,1,2) = '$categoria' ORDER BY codcate ASC");
    echo '<option value="" >TODOS</option>';
    if (mysql_num_rows($query) > 0) {
        while ($row = mysql_fetch_array($query)) {
            echo "<option value='" . $row['codcate'] . "'>" . $row['desccate'] . "</option>\n";
        }
    }
}
 

