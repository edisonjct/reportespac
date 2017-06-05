<?php
$proceso = $_GET['proceso'];
include('conexion.php');


$IDB = $_GET['IDB'];
$provedor = $_GET['provedor'];


switch ($proceso) {
    case 'buscarprovedor':
        $query = "select codcte01,coddest01,nomcte01 from maepag WHERE nomcte01 LIKE '%$provedor%' AND tipcte01='0003' ORDER BY nomcte01 LIMIT 10";
        $result = mysql_query($query, $conexion);
        ?>
        <?php if (!empty($result)) { ?>
            <ul id="consignado-list">
                <?php
                while ($row = mysql_fetch_assoc($result)) {
                    ?>
                    <li onClick="selectprovedorconsignado('<?php echo $row["nomcte01"]; ?>', '<?php echo $row["codcte01"]; ?>');"><?php echo $row["nomcte01"]; ?></li>
                <?php } ?>
            </ul>
            <?php
        }
        break;
    case 'buscardocumentos':
         echo $queryconsignados = "SELECT
	p.codbar01 AS codigo,
	d.nomprod30 AS titulo,
	autores.nombres AS autor,
	editoriales.razon AS editorial,
	categorias.desccate AS categoria,
	Sum(d.cantres30) AS consignado,
	d.precuni30 AS pvp,
	pr.desctocte01 AS descuento
        FROM
                maeord30 AS d
        INNER JOIN maepro AS p ON d.codprod30 = p.codprod01
        LEFT JOIN autores ON p.infor01 = autores.codigo
        LEFT JOIN editoriales ON p.infor02 = editoriales.codigo
        LEFT JOIN categorias ON p.catprod01 = categorias.codcate
        LEFT JOIN maepag AS pr ON d.codcte30 = pr.codcte01
        WHERE
                d.codcte30 = '$provedor'
        AND d.status30 = '02'
        AND d.cantres30 > 0
        AND categorias.tipocate = '02'
        GROUP BY
                d.codprod30";
        $result = mysql_query($queryconsignados);
        ?>
        <?php if (mysql_num_rows($result) > 0) { ?>
            <table class="table table-striped table-hover table-bordered" >
                <tr>
                    <th>CODIGO</th>
                    <th>TITULO</th>
                    <th>AUTOR</th>
                    <th>EDITORIAL</th>
                    <th>CATEGORIA</th>
                    <th>CONSIGNADO</th>  
                    <th>STOCK</th>
                    <th>PVP</th>
                    <th>DESCUENTO</th>
                </tr>
                <?php while ($row = mysql_fetch_assoc($result)) { ?>
                <?php
                    $codigo = $row['codigo'];
                    $querystock = "SELECT
                    mrbooks.maepro.codprod01 AS codigo,
                    (mrbooks.maepro.cantact01 + mrbookjardin.maepro.cantact01 + mrbooksol.maepro.cantact01 + mrbookcondado.maepro.cantact01 + mrbooktumbaco.maepro.cantact01 + mrbookvill.maepro.cantact01 + mrbookquicentro.maepro.cantact01 + mrbooksluis.maepro.cantact01 + mrbooksmarino.maepro.cantact01 + mrbookcumbaya.maepro.cantact01) AS stock	
                    FROM
                    mrbooks.maepro
                    LEFT JOIN mrbookjardin.maepro ON mrbookjardin.maepro.codprod01 = mrbooks.maepro.codprod01
                    LEFT JOIN mrbooksol.maepro ON mrbooksol.maepro.codprod01 = mrbooks.maepro.codprod01
                    LEFT JOIN mrbookcondado.maepro ON mrbookcondado.maepro.codprod01 = mrbooks.maepro.codprod01
                    LEFT JOIN mrbooktumbaco.maepro ON mrbooktumbaco.maepro.codprod01 = mrbooks.maepro.codprod01
                    LEFT JOIN mrbookvill.maepro ON mrbookvill.maepro.codprod01 = mrbooks.maepro.codprod01
                    LEFT JOIN mrbookquicentro.maepro ON mrbookquicentro.maepro.codprod01 = mrbooks.maepro.codprod01
                    LEFT JOIN mrbooksmarino.maepro ON mrbooksmarino.maepro.codprod01 = mrbooks.maepro.codprod01
                    LEFT JOIN mrbooksluis.maepro ON mrbooksluis.maepro.codprod01 = mrbooks.maepro.codprod01
                    LEFT JOIN mrbookcumbaya.maepro ON mrbookcumbaya.maepro.codprod01 = mrbooks.maepro.codprod01
                    WHERE
                    mrbooks.maepro.statuspro01 = _utf8 'S' AND mrbooks.maepro.codbar01 <> _utf8 '' AND mrbooks.maepro.codprod01 = '$codigo'";
                ?>
                    <tr>                          
                        <td><?php echo $row['codigo']; ?></td>
                        <td><?php echo $row['titulo']; ?></td>
                        <td><?php echo $row['autor']; ?></td>
                        <td><?php echo $row['editorial']; ?></td>
                        <td><?php echo $row['categoria']; ?></td>
                        <td><?php echo $row['consignado']; ?></td>
                        <td>STOCK</td>
                        <td><?php echo $row['pvp']; ?></td>
                        <td><?php echo $row['descuento']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <?php echo "NO SE ENCONTRARON REGISTROS"; ?>

        <?php } ?>

        <?php        
        break;
}
