<?php

$codigo = $_GET['codigo'];
$titulo = $_GET['titulo'];
$IDB = $_GET['IDB'];
$UID = $_GET['UID'];
include('conexion.php');

switch ($codigo) {
    case (true):
        $registro = "SELECT
        m.codprod01 AS interno,
        m.codbar01 AS barras,
        m.desprod01 AS titulo,
        a.nombres AS autor,
        e.razon AS editorial,
        c.desccate as categoria,
        pr.nomcte01 AS provedor,
        m.precvta01 as pvp,
        m.infor08 as ubicacion,
        m.cantact01 as cantidad,
        SUBSTRING(m.fotoprod01,28,17) as portada
        FROM
        maepro AS m
        INNER JOIN autores AS a ON m.infor01 = a.codigo
        INNER JOIN editoriales e ON m.infor02 = e.codigo
        INNER JOIN categorias c ON m.catprod01 = c.codcate
        LEFT JOIN maepag pr ON m.proved101 = pr.codcte01
        WHERE c.tipocate = 02 AND m.codbar01 = '$codigo' ORDER BY m.desprod01 ASC";
        break;
    case (false):
        $registro = "SELECT
        m.codprod01 AS interno,
        m.codbar01 AS barras,
        m.desprod01 AS titulo,
        a.nombres AS autor,
        e.razon AS editorial,
        c.desccate as categoria,
        pr.nomcte01 AS provedor,
        m.precvta01 as pvp,
        m.infor08 as ubicacion,
        m.cantact01 as cantidad,
        SUBSTRING(m.fotoprod01,28,17) as portada
        FROM
        maepro AS m
        INNER JOIN autores AS a ON m.infor01 = a.codigo
        INNER JOIN editoriales e ON m.infor02 = e.codigo
        INNER JOIN categorias c ON m.catprod01 = c.codcate
        LEFT JOIN maepag pr ON m.proved101 = pr.codcte01
        WHERE c.tipocate = 02 AND m.desprod01 LIKE '%$titulo%' ORDER BY m.desprod01 ASC";
        break;
}

//echo $registro;
$resultado = mysql_query($registro, $conexion);
echo '<table class="table table-striped table-condensed table-hover" >
        <tr>
        <th>Cod. Inte</th>
        <th>Cod. Barras</th>
          <th>Titulo</th>
          <th>Autor</th>
          <th>Editorial</th>  
          <th>Categoria</th>
          <th>Provedor</th>
          <th>PVP</th>
          <th>Cantidad</th>   
          <th>Ubicacion</th>
          <th>Portada</th>          
        </tr>';
if (mysql_num_rows($resultado) > 0) {
    while ($row = mysql_fetch_array($resultado)) {
        echo '<tr> 
                <td>' . $row['interno'] . '</td>
                <td>' . $row['barras'] . '</td>
                <td>' . $row['titulo'] . '</td>
                <td>' . $row['autor'] . '</td>
                <td>' . $row['editorial'] . '</td>
                <td>' . $row['categoria'] . '</td>
                <td>' . $row['provedor'] . '</td>
                <td>' . $row['pvp'] . '</td>
                <td>' . $row['cantidad'] . '</td>
                <td>' . $row['ubicacion'] . '</td>
                <td><a href="javascript:editarProducto(' . $row['interno'] . ');"><img src="'.'../portadas/'. $row['portada'] . '"  width="40" height="60"></a></td>
            </tr>';
    }
} else {
    echo '<tr>
		<td colspan="11">No se encontraron resultados</td>
	</tr>';
}
echo '</table>';






