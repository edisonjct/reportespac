<?php

include('conexionC.php');

if (isset($_GET["idcliente"])) {
    $clientes = $_GET["idcliente"];
    $query = mysql_query("SELECT ca.codcate as codcate,CONCAT(ca.codcate,'-',ca.desccate) as detalle
                FROM
                categorias ca
                INNER JOIN maecte c ON ca.alias = c.nomcte01
                WHERE ca.tipocate = '09' AND ca.codcatep <> '0' AND ca.codcatep <> '' AND ca.codcatep <> 'SMX' AND ca.codcatep <> 'LM' AND c.codcte01 in ($clientes) ");
    if (mysql_num_rows($query) > 0) {
        while ($row = mysql_fetch_array($query)) {
            echo "<option value='" . $row['codcate'] . "'>" . $row['detalle'] . "</option>\n";
        }
    }
}
 

