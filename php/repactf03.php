<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include('conexion.php');
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=RepActivosFijos.xls");
header("Pragma: no-cache");
header("Expires: 0");

$desde = $_GET['desde'];
$hasta = $_GET['hasta'];
$IDB = $_GET['IDB'];
$ubicacion = $_GET['ubicacion'];
$grupo = $_GET['grupo'];
$subtotalcant = 0;
$subtotalvadq = 0;
$subtotalvdep = 0;
$subtotaldep = 0;
$subtotalvact = 0;
$grupotabla = '';
$cont = '';
$fingrupo = 0;

if ($ubicacion == 'todos' && $grupo == 'todos') {
    $registro = "SELECT
    ac.codacf01 AS codigo,
    ac.nomacf01 AS nombre,
    ac.cantacf01 AS cantidad,
    SUBSTRING(ac.cateacf01,1,2) as codcate,
    mrb_categoria_activos.desccate as descate,
    ca.desccate as subcategoria,
    ac.cateacf01 as codsubcate,
    m.nomtab AS marca,
    ac.modeloacf01 AS modelo,
    ac.tipoacf01 AS tipo,
    c.nomtab AS color,
    ac.serieacf01 AS serie,
    ac.nofactacf01 AS factura,
    ac.ubicacf01 as ubicacion,
    ac.respacf01 as responsable,
    p.nomtab AS provedor,
    ac.fechaAdquision AS fcompra,
    ac.valadqacf01 AS vadq,
    ac.valadepacf01 AS vdep,
    ac.vidautilacf01 AS vutil,
    ac.cuotadepnoracf01 AS dep,
    ac.valactualacf01 as vact,
    ac.ctaacf01 as cact,
    ac.ctadepacf01 as cdep
    FROM
    maeacf AS ac
    LEFT JOIN MRB_MARCAS AS m ON ac.marcaacf01 = m.codtab
    LEFT JOIN MRB_COLORES AS c ON ac.coloracf01 = c.codtab
    LEFT JOIN MRB_PROVED_AC AS p ON ac.provacf01 = p.codtab
    LEFT JOIN mrbooks.categorias ca ON ac.cateacf01 = ca.codcate
    LEFT JOIN mrb_categoria_activos ON SUBSTRING(ac.cateacf01,1,2) = mrb_categoria_activos.codcate
    WHERE ac.fechaAdquision BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND ca.tipocate = '07'
    ORDER BY ca.codcate,SUBSTRING(ac.codacf01,10,2),ac.fechaAdquision ASC
    ";
    $fingrupo = 1;
}
if ($ubicacion == 'todos' && $grupo <> 'todos') {
    $registro = "SELECT
    ac.codacf01 AS codigo,
    ac.nomacf01 AS nombre,
    ac.cantacf01 AS cantidad,
    SUBSTRING(ac.cateacf01,1,2) as codcate,
    mrb_categoria_activos.desccate as descate,
    ca.desccate as subcategoria,
    ac.cateacf01 as codsubcate,
    m.nomtab AS marca,
    ac.modeloacf01 AS modelo,
    ac.tipoacf01 AS tipo,
    c.nomtab AS color,
    ac.serieacf01 AS serie,
    ac.nofactacf01 AS factura,
    ac.ubicacf01 as ubicacion,
    ac.respacf01 as responsable,
    p.nomtab AS provedor,
    ac.fechaAdquision AS fcompra,
    ac.valadqacf01 AS vadq,
    ac.valadepacf01 AS vdep,
    ac.vidautilacf01 AS vutil,
    ac.cuotadepnoracf01 AS dep,
    ac.valactualacf01 as vact,
    ac.ctaacf01 as cact,
    ac.ctadepacf01 as cdep
    FROM
    maeacf AS ac
    LEFT JOIN MRB_MARCAS AS m ON ac.marcaacf01 = m.codtab
    LEFT JOIN MRB_COLORES AS c ON ac.coloracf01 = c.codtab
    LEFT JOIN MRB_PROVED_AC AS p ON ac.provacf01 = p.codtab
    LEFT JOIN mrbooks.categorias ca ON ac.cateacf01 = ca.codcate
    LEFT JOIN mrb_categoria_activos ON SUBSTRING(ac.cateacf01,1,2) = mrb_categoria_activos.codcate
    WHERE ac.fechaAdquision BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND ca.tipocate = '07' AND SUBSTRING(ac.cateacf01,1,2) = '$grupo'
    ORDER BY ca.codcate,SUBSTRING(ac.codacf01,10,2),ac.fechaAdquision ASC;
    ";


    $fingrupo = 2;
}
if ($ubicacion <> 'todos' && $grupo == 'todos') {
    $registro = "SELECT
    ac.codacf01 AS codigo,
    ac.nomacf01 AS nombre,
    ac.cantacf01 AS cantidad,
    SUBSTRING(ac.cateacf01,1,2) as codcate,
    mrb_categoria_activos.desccate as descate,
    ca.desccate as subcategoria,
    ac.cateacf01 as codsubcate,
    m.nomtab AS marca,
    ac.modeloacf01 AS modelo,
    ac.tipoacf01 AS tipo,
    c.nomtab AS color,
    ac.serieacf01 AS serie,
    ac.nofactacf01 AS factura,
    ac.ubicacf01 as ubicacion,
    ac.respacf01 as responsable,
    p.nomtab AS provedor,
    ac.fechaAdquision AS fcompra,
    ac.valadqacf01 AS vadq,
    ac.valadepacf01 AS vdep,
    ac.vidautilacf01 AS vutil,
    ac.cuotadepnoracf01 AS dep,
    ac.valactualacf01 as vact,
    ac.ctaacf01 as cact,
    ac.ctadepacf01 as cdep
    FROM
    maeacf AS ac
    LEFT JOIN MRB_MARCAS AS m ON ac.marcaacf01 = m.codtab
    LEFT JOIN MRB_COLORES AS c ON ac.coloracf01 = c.codtab
    LEFT JOIN MRB_PROVED_AC AS p ON ac.provacf01 = p.codtab
    LEFT JOIN mrbooks.categorias ca ON ac.cateacf01 = ca.codcate
    LEFT JOIN mrb_categoria_activos ON SUBSTRING(ac.cateacf01,1,2) = mrb_categoria_activos.codcate
    WHERE ac.fechaAdquision BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND ca.tipocate = '07' AND SUBSTRING(ac.codacf01,10,2) = '$ubicacion'
    ORDER BY ca.codcate,SUBSTRING(ac.codacf01,10,2),ac.fechaAdquision ASC;";
    $fingrupo = 3;
}
if ($ubicacion <> 'todos' && $grupo <> 'todos') {
    $registro = "SELECT
    ac.codacf01 AS codigo,
    ac.nomacf01 AS nombre,
    ac.cantacf01 AS cantidad,
    SUBSTRING(ac.cateacf01,1,2) as codcate,
    mrb_categoria_activos.desccate as descate,
    ca.desccate as subcategoria,
    ac.cateacf01 as codsubcate,
    m.nomtab AS marca,
    ac.modeloacf01 AS modelo,
    ac.tipoacf01 AS tipo,
    c.nomtab AS color,
    ac.serieacf01 AS serie,
    ac.nofactacf01 AS factura,
    ac.ubicacf01 as ubicacion,
    ac.respacf01 as responsable,
    p.nomtab AS provedor,
    ac.fechaAdquision AS fcompra,
    ac.valadqacf01 AS vadq,
    ac.valadepacf01 AS vdep,
    ac.vidautilacf01 AS vutil,
    ac.cuotadepnoracf01 AS dep,
    ac.valactualacf01 as vact,
    ac.ctaacf01 as cact,
    ac.ctadepacf01 as cdep
    FROM
    maeacf AS ac
    LEFT JOIN MRB_MARCAS AS m ON ac.marcaacf01 = m.codtab
    LEFT JOIN MRB_COLORES AS c ON ac.coloracf01 = c.codtab
    LEFT JOIN MRB_PROVED_AC AS p ON ac.provacf01 = p.codtab
    LEFT JOIN mrbooks.categorias ca ON ac.cateacf01 = ca.codcate
    LEFT JOIN mrb_categoria_activos ON SUBSTRING(ac.cateacf01,1,2) = mrb_categoria_activos.codcate
    WHERE ac.fechaAdquision BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND ca.tipocate = '07' AND SUBSTRING(ac.codacf01,10,2) = '$ubicacion' AND SUBSTRING(ac.cateacf01,1,2) = '$grupo'
    ORDER BY ca.codcate,SUBSTRING(ac.codacf01,10,2),ac.fechaAdquision ASC;
    ";
    
    $fingrupo = 4;
}

$resultado = mysql_query($registro, $conexion);
?>
<?php if (mysql_num_rows($resultado) > 0) {
    ?>
    <?php while ($row = mysql_fetch_assoc($resultado)) { ?>
        <?php
        switch ($fingrupo) {
            case 1: $sql_maxGrupos = "SELECT COUNT(codacf01) as max,SUBSTRING(cateacf01,1,2) from maeacf WHERE SUBSTRING(cateacf01,1,2) = '" . $row['codcate'] . "' AND fechaAdquision BETWEEN '$desde' AND '$hasta' GROUP BY SUBSTRING(cateacf01,1,2) ASC";
                break;
            case 2: $sql_maxGrupos = "SELECT COUNT(codacf01) as max,SUBSTRING(cateacf01,1,2) from maeacf WHERE SUBSTRING(cateacf01,1,2) = '" . $row['codcate'] . "' AND fechaAdquision BETWEEN '$desde' AND '$hasta' AND SUBSTRING(cateacf01,1,2) = '$grupo' GROUP BY SUBSTRING(cateacf01,1,2) ASC";
                break;
            case 3: $sql_maxGrupos = "SELECT COUNT(codacf01) as max,SUBSTRING(cateacf01,1,2),codacf01 from maeacf WHERE SUBSTRING(cateacf01,1,2) = '" . $row['codcate'] . "' AND fechaAdquision BETWEEN '$desde' AND '$hasta' AND SUBSTRING(codacf01,10,2) = '$ubicacion' GROUP BY SUBSTRING(cateacf01,1,2) ASC";
                break;
            case 4: $sql_maxGrupos = "SELECT COUNT(codacf01) as max,SUBSTRING(cateacf01,1,2) from maeacf WHERE SUBSTRING(cateacf01,1,2) = '" . $row['codcate'] . "' AND fechaAdquision BETWEEN '$desde' AND '$hasta' AND SUBSTRING(codacf01,10,2) = '$ubicacion' AND SUBSTRING(cateacf01,1,2) = '$grupo' GROUP BY SUBSTRING(cateacf01,1,2) ASC";
                break;
        }
        $result_maxGrupos = mysql_query($sql_maxGrupos);
        $rowsubtotal = mysql_fetch_assoc($result_maxGrupos);
        $maximo_grupos = $rowsubtotal['max'];
        $grupoant = $grupotabla;
        $grupotabla = $row['codcate'];
        $subtotalcant = $subtotalcant + $row['cantidad'];
        $subtotalvadq = $subtotalvadq + $row['vadq'];
        $subtotalvdep = $subtotalvdep + $row['vdep'];
        $subtotaldep = $subtotaldep + $row['dep'];
        $subtotalvact = $subtotalvact + $row['vact'];
        ?>
        <?php
        if ($grupoant != $grupotabla) {
            ?>
            <table class="table table-striped table-hover table-bordered" >                
                <tr>        
                    <th>CODIGO</th>
                    <th>NOMBRE</th>
                    <th>CATEGORIA</th>
                    <th>SUBCATEGORIA</th>
                    <th>CANT</th>
                    <th>MARCA</th>  
                    <th>MODEL</th>
                    <th>COLOR</th>
                    <th>SERIE</th>
                    <th>FAC.</th>
                    <th>UBICA</th>
                    <th>RESPONS</th>
                    <th>PROV.</th>
                    <th>F.COMP</th>
                    <th>V.ADQ</th>
                    <th>V.DEP</th>
                    <th>V.UTIL</th>
                    <th>DEP.</th>
                    <th>V.ACT</th>
                    <th>C.ACT</th>
                    <th>C.DEP</th>
                </tr>
            <?php } ?>
            <tr>

                <td><?php echo $row['codigo'] ?></td>
                <td><?php echo $row['nombre'] ?></td>
                <td><?php echo $row['descate'] ?></td>
                <td><?php echo $row['subcategoria'] ?></td> 
                <td><?php echo number_format($row['cantidad'], 0, '.', ',') ?></td>
                <td><?php echo $row['marca'] ?></td>  
                <td><?php echo $row['modelo'] ?></td>
                <td><?php echo $row['color'] ?></td>
                <td><?php echo $row['serie'] ?></td>
                <td><?php echo $row['factura'] ?></td>
                <td><?php echo $row['ubicacion'] ?></td>
                <td><?php echo $row['responsable'] ?></td>                      
                <td><?php echo $row['provedor'] ?></td>
                <td><?php echo $row['fcompra'] ?></td>
                <td><?php echo number_format($row['vadq'], 2, '.', ',') ?></td>
                <td><?php echo number_format($row['vdep'], 2, '.', ',') ?></td>
                <td><?php echo number_format($row['vutil'], 2, '.', ',') ?></td>
                <td><?php echo number_format($row['dep'], 2, '.', ',') ?></td>
                <td><?php echo number_format($row['vact'], 2, '.', ',') ?></td>
                <td><?php echo $row['cact'] ?></td>
                <td><?php echo $row['cdep'] ?></td>

                <?php $cont = $cont + 1; ?>
                <?php if ($cont == $maximo_grupos) {
                    ?>
                <tr>
                    <th colspan="4"></th>
                    <th><?php echo $subtotalcant ?></th>
                    <th colspan="10"></th>
                    <th><?php echo number_format($subtotalvadq, 2, '.', ',') ?></th>
                    <th><?php echo number_format($subtotalvdep, 2, '.', ',') ?></th>
                    <th></th>
                    <th><?php echo number_format($subtotaldep, 2, '.', ',') ?></th>
                    <th><?php echo number_format($subtotalvact, 2, '.', ',') ?></th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                $cont = 0;
                $subtotalcant = 0;
                $subtotalvadq = 0;
                $subtotalvdep = 0;
                $subtotaldep = 0;
                $subtotalvact = 0;
            }
            ?>
        <?php } ?>           
    <?php } else { ?>
        <table class="table table-striped table-condensed table-hover" >
            <tr>
                <td colspan="20">No se encontraron resultados</td>
            </tr>
        <?php } ?>
    </table>