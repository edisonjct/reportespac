<?php

include('conexion.php');

$IDB = $_GET['IDB'];
$clientes = $_GET['clientes'];
$contador = 0;
if (strlen($clientes) <= 0) {
    echo '<script type="text/javascript">alert("SELECIONE EL CLIENTE");</script>';
} else {
    $registro = "SELECT
                gs.codigo as cod,
                gs.codcte as codcte,
                gs.codprod AS codprod,
                m.desprod01 AS titulo,
                categorias.desccate as cate,
                gs.categoria AS catgs,
                au.nombres AS autor,
                ed.razon as editorial,
                maepag.nomcte01 as provedor
                FROM
                productos_grandes_superficies AS gs
                INNER JOIN maepro AS m ON gs.codprod = m.codbar01
                LEFT JOIN autores AS au ON m.infor01 = au.codigo
                INNER JOIN editoriales AS ed ON m.infor02 = ed.codigo
                INNER JOIN categorias ON m.catprod01 = categorias.codcate
                LEFT JOIN maepag ON m.proved101 = maepag.codcte01
                WHERE gs.codcte IN ($clientes) AND categorias.tipocate = '02' ;";

    $resultado = mysql_query($registro, $conexion);

    echo '<table class="table table-striped table-condensed table-hover" >
        <tr>
            <th>#</th>
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Categoria</th> 
            <th>CategoriaGS</th>
            <th>Autor</th>
            <th>Editorial</th>
            <th>Provedor</th>
            <th>Opcio</th>
        </tr>';
    if (mysql_num_rows($resultado) > 0) {
        while ($row = mysql_fetch_array($resultado)) {
            $contador = $contador + 1;         
           echo '<tr>
            <td>' . $contador . '</td>
            <td>' . $row["codprod"] . '</td>
            <td>' . $row["titulo"] . '</td>
            <td>' . $row["cate"] . '</td>
            <td>' . $row["catgs"] . '</td>
            <td>' . $row["autor"] . '</td>
            <td>' . $row["editorial"] . '</td> 
            <td>' . $row["provedor"] . '</td>
            <td>
                <a href="javascript:editarProducto('.$row['codprod'].','.$row['codcte'].');" class="glyphicon glyphicon-edit"></a>
                <a href="javascript:eliminarProducto('.$row['codprod'].','.$row['codcte'].');" class="glyphicon glyphicon-remove-circle"></a>
            </td>
          </tr>';
        }
        
    } else {
        echo '<tr>
		<td colspan="9">No se encontraron resultados</td>
	</tr>';
    }
    echo '</table>';
}
