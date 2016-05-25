<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include('conexionC.php');
$codprod = $_GET['codprod'];
$codcte = $_GET['codcte'];
//OBTENEMOS LOS VALORES DEL PRODUCTO

$valores = mysql_query("SELECT
gs.codigo AS cod,
gs.codcte as cliente,
gs.codprod AS codigo,
m.desprod01 AS titulo,
categorias.desccate AS cate,
gs.categoria AS catgs,
au.nombres AS autor,
ed.razon AS editorial,
maepag.nomcte01 AS provedor
FROM
productos_grandes_superficies AS gs
INNER JOIN maepro AS m ON gs.codprod = m.codbar01
LEFT JOIN autores AS au ON m.infor01 = au.codigo
INNER JOIN editoriales AS ed ON m.infor02 = ed.codigo
INNER JOIN categorias ON m.catprod01 = categorias.codcate
LEFT JOIN maepag ON m.proved101 = maepag.codcte01
WHERE gs.codcte = '$codcte' AND gs.codprod = '$codprod' AND categorias.tipocate = '02'");
$valores2 = mysql_fetch_array($valores);

$datos = array(
        0 => $valores2['cliente'],
	1 => $valores2['codigo'],
	2 => $valores2['titulo'],
	3 => $valores2['cate'],
	4 => $valores2['catgs'],			
	5 => $valores2['autor'],
	6 => $valores2['editorial'],
        7 => $valores2['provedor'],
);
echo json_encode($datos);


