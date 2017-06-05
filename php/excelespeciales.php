<?php
include('conexion.php');
header('Content-Type: text/html; charset=UTF-8');
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=especiales.xls");
header("Pragma: no-cache");
header("Expires: 0");
$IDB = $_GET['IDB'];
$proceso = $_GET['proceso'];
$operador = $_GET['operador'];
$cantidad = $_GET['cantidad'];
$valor = '';
$valor2 = '';


switch ($operador) {
    case 1:
        $op = '>=';
        break;
    case 2:
        $op = '=';
        break;
    case 3:
        $op = '<=';
        break;
}

function acentos($string) {
    $string = trim($string);
    $string = str_replace(array('Ã‘'), array('Ñ'), $string);
    return $string;
}

switch ($proceso) {
    case 'excel':
        $registro = "SELECT
        m.codbar01 AS codigobarras,
        m.desprod01 AS titulo,
        a.nombres AS autor,
        e.razon AS editorial,
        cp.desccate AS categoriaPadre,
        c.desccate AS categoria,
        i.nomtab AS idioma,
        m.precvta01 AS precioweb,
        s.stock as stock,        
        CASE WHEN m.clasific01 = 'NG' THEN 'SI' ELSE '' END AS novedad,
        CASE WHEN m.clasific01 = 'RG' THEN 'SI' ELSE '' END AS recomendado,
        CASE WHEN m.clasific01 = 'MVG' THEN 'SI' ELSE '' END AS masvendidos,
        CASE WHEN m.clasific01 = 'MVI' THEN 'SI' ELSE '' END AS masvendidosinfantil,
        CASE WHEN m.clasific01 = 'RI' THEN 'SI' ELSE '' END AS recomendadoinfantil,
        m.detprod01 as resumen,
        m.orden as posicion,
        m.Precio_WEB as precionormal,
        CASE WHEN m.porciva01 = '0' THEN 'N' ELSE 'S' END AS iva
        FROM
        maepro AS m
        LEFT JOIN autores AS a ON m.infor01 = a.codigo
        LEFT JOIN editoriales AS e ON m.infor02 = e.codigo
        LEFT JOIN categorias AS c ON m.catprod01 = c.codcate
        LEFT JOIN categorias AS cp ON c.codcatep = cp.codcate
        LEFT JOIN maetab AS i ON m.infor03 = i.codtab
        INNER JOIN stockespeciales as s ON m.codprod01 = s.codigo
        WHERE m.clasific01 != '' AND c.tipocate = '02' AND cp.tipocate = '02' AND i.numtab = '602' AND i.codtab != '' AND s.stock $op $cantidad;";
        $resultado = mysql_query($registro, $conexion);
        ?>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <table class="table table-striped table-condensed table-hover" >
            <tr>
                <th>codigobarras</th>
                <th>titulo</th>
                <th>autor</th>
                <th>editorial</th> 
                <th>categoriaPadre</th>
                <th>categoria</th>
                <th>idioma</th>
                <th>PRECIO WEB</th>
                <th>STOCK</th>
                <th>NOVEDAD</th>
                <th>RECOMENDADO</th>
                <th>MAS VENDIDO</th>
                <th>MAS VENDIDO INFANTIL</th>
                <th>RECOMENDADOS INFANTIL</th>
                <th>RESUMEN</th>
                <th>POSICION</th>
                <th>PRECIO NORMAL</th>
                <th>IVA S/N</th>
            </tr>
            <?php if (mysql_num_rows($resultado) > 0) { ?>
                <?php while ($row = mysql_fetch_array($resultado)) { ?>
                    <tr>                
                        <td><?php echo $row["codigobarras"]; ?></td>
                        <td><?php echo acentos($row["titulo"]); ?></td>
                        <td><?php echo $row["autor"]; ?></td>
                        <td><?php echo $row["editorial"]; ?></td>
                        <td><?php echo $row["categoriaPadre"]; ?></td>            
                        <td><?php echo $row["categoria"]; ?></td>
                        <td><?php echo acentos($row["idioma"]); ?></td>
                        <td><?php echo $row["precioweb"]; ?></td>
                        <td><?php echo $row["stock"]; ?></td>
                        <td><?php echo $row["novedad"]; ?></td>
                        <td><?php echo $row["recomendado"]; ?></td> 
                        <td><?php echo $row["masvendidos"]; ?></td>
                        <td><?php echo $row["masvendidosinfantil"]; ?></td>
                        <td><?php echo $row["recomendadoinfantil"]; ?></td>
                        <td><?php echo $row["resumen"]; ?></td>
                        <td><?php echo $row["posicion"]; ?></td>
                        <td><?php echo $row["precionormal"]; ?></td> 
                        <td><?php echo $row["iva"]; ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="18">No se encontraron resultados</td>
                </tr>
            <?php } ?>
        </table>

        <?php
        break;
    case 'vista':
        $bodegas = $_GET['locales'];
        $row_bodega = spliti(",", $bodegas);
        
        foreach ($row_bodega as $row) {
            if($row == '01'){
                $script1 = "mrbooks.maepro.cantact01";
                $script2 = "";
                $valor .= $script1 . "+";
                $valor2 .= $script2 . "";
            } else if ($row == '03'){
                $script1 = "mrbookjardin.maepro.cantact01";
                $script2 = "LEFT JOIN mrbookjardin.maepro ON mrbookjardin.maepro.codprod01 = mrbooks.maepro.codprod01";
                $valor .= $script1 . "+";
                $valor2 .= $script2 . " ";
            } else if ($row == '04'){
                $script1 = "mrbooksol.maepro.cantact01 ";
                $script2 = "LEFT JOIN mrbooksol.maepro ON mrbooksol.maepro.codprod01 = mrbooks.maepro.codprod01";
                $valor .= $script1 . "+";
                $valor2 .= $script2 . " ";
            } else if ($row == '05'){
                $script1 = "mrbookcondado.maepro.cantact01";
                $script2 = "LEFT JOIN mrbookcondado.maepro ON mrbookcondado.maepro.codprod01 = mrbooks.maepro.codprod01";
                $valor .= $script1 . "+";
                $valor2 .= $script2 . " ";
            } else if ($row == '06'){
                $script1 = "mrbooktumbaco.maepro.cantact01";
                $script2 = "LEFT JOIN mrbooktumbaco.maepro ON mrbooktumbaco.maepro.codprod01 = mrbooks.maepro.codprod01";
                $valor .= $script1 . "+";
                $valor2 .= $script2 . " ";
            } else if ($row == '07'){
                $script1 = "mrbookvill.maepro.cantact01";
                $script2 = "LEFT JOIN mrbookvill.maepro ON mrbookvill.maepro.codprod01 = mrbooks.maepro.codprod01";
                $valor .= $script1 . "+";
                $valor2 .= $script2 . " ";
            } else if ($row == '09'){
                $script1 = "mrbookeventos.maepro.cantact01 ";
                $script2 = "LEFT JOIN mrbookeventos.maepro ON mrbookeventos.maepro.codprod01 = mrbooks.maepro.codprod01";
                $valor .= $script1 . "+";
                $valor2 .= $script2 . " ";
            } else if ($row == '13'){
                $script1 = "mrbookcumbaya.maepro.cantact01 ";
                $script2 = "LEFT JOIN mrbookcumbaya.maepro ON mrbookcumbaya.maepro.codprod01 = mrbooks.maepro.codprod01";
                $valor .= $script1 . "+";
                $valor2 .= $script2 . " ";
            } else if ($row == '14'){
                $script1 = "mrbooksmarino.maepro.cantact01 ";
                $script2 = "LEFT JOIN mrbooksmarino.maepro ON mrbooksmarino.maepro.codprod01 = mrbooks.maepro.codprod01";
                $valor .= $script1 . "+";
                $valor2 .= $script2 . " ";
            } else if ($row == '15'){
                $script1 = "mrbooksluis.maepro.cantact01 ";
                $script2 = "LEFT JOIN mrbooksluis.maepro ON mrbooksluis.maepro.codprod01 = mrbooks.maepro.codprod01";
                $valor .= $script1 . "+";
                $valor2 .= $script2 . " ";
            } else if ($row == '16'){
                $script1 = "mrbookquicentro.maepro.cantact01 ";
                $script2 = "LEFT JOIN mrbookquicentro.maepro ON mrbookquicentro.maepro.codprod01 = mrbooks.maepro.codprod01";
                $valor .= $script1 . "+";
                $valor2 .= $script2 . " ";
            }  
        }        
        $valor = substr($valor, 0, -1);
        $valor2 = substr($valor2, 0, -1);
        
        $query = "CREATE OR REPLACE VIEW stockespeciales AS
                SELECT
                mrbooks.maepro.codprod01 AS codigo,
                $valor AS stock
                FROM
                mrbooks.maepro
                $valor2
                WHERE
                mrbooks.maepro.statuspro01 = _utf8 'S'
                AND mrbooks.maepro.codbar01 <> _utf8 ''";
        $rsult_view = mysql_query($query) or die("NO Se pudo generar la Vista");

        echo '<form id="form" name="form" method="post" action="../php/excelespeciales.php?IDB=' . $IDB . '&operador=' . $operador . '&cantidad=' . $cantidad . '&proceso=excel">
            <center><button id="exportarespeciales" class="btn btn-success" >Excel</button></center>
            <br><br>
        </form>';

        break;
}



