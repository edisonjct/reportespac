<?php

include 'conexion.php';

$IDB        = $_GET['IDB'];
$ID         = $_GET['ID'];
$proceso    = $_GET['proceso'];
$contjarros = 0;
$contmaleta = 0;
$contdescu  = 0;
$cont       = 0;

if ($IDB == '03' or $IDB == '04' or $IDB == '05' or $IDB == '06' or $IDB == '07' or $IDB == '18' or $IDB == '01') {
    switch ($proceso) {
        case 'diamadre2017':
            # code...
            $desde = $_GET['desde'];
            $hasta = $_GET['hasta'];
            // echo "si";
            $query = "SELECT
        f.nofact31 as factura,
        f.fecfact31 as fecha,
        f.nocte31 as cedula,
        f.nomcte31 as cliente,
        f.vtabta31 as valor,
        CASE WHEN f.vtabta31 BETWEEN '10.00' AND '15.00' THEN 'Maleta' WHEN f.vtabta31 BETWEEN '15.01' AND '25.00' THEN 'Jarro' WHEN f.vtabta31 >= '25.01' THEN 'Descuento de 15%' END as premio,
        CASE WHEN f.vtabta31 BETWEEN '10.00' AND '15.00' THEN '1' WHEN f.vtabta31 BETWEEN '15.01' AND '25.00' THEN '2' WHEN f.vtabta31 >= '25.01' THEN '3' END as cm,
        f.campo231 as validador
        FROM
        maefac f
        WHERE f.fecfact31 BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND f.vtabta31 >= '10' AND f.condpag31 = '0' ORDER BY f.fecfact31 DESC ";
            $result = mysql_query($query, $conexion);
            ?>
        <table class="table table-striped table-condensed table-hover table-bordered" >
        <tr>
          <th>FACTURA</th>
          <th>FECHA</th>
          <th>CEDULA</th>
          <th>CLIENTE</th>
          <th>V.BTA</th>
          <th>PREMIO</th>
          <th width="3%"></th>
        </tr>
        <?php
if (mysql_num_rows($result) > 0) {
                while ($row = mysql_fetch_array($result)) {
                    ?>
            <tr>
                <td><?php echo $row['factura']; ?></td>
                <td><?php echo $row['fecha']; ?></td>
                <td><?php echo $row['cedula']; ?></td>
                <td><?php echo $row['cliente']; ?></td>
                <td><?php echo $row['valor']; ?></td>
                <td><?php echo $row['premio']; ?></td>
                <?php if ($row['validador'] == '') {
                        ?>
                <?php if ($row['cm'] == '1') {?>
                <td><button type="button" class="btn btn-info btn-xs" onclick="imprimircupon('<?php echo $row['factura']; ?>','<?php echo $row['cm']; ?>','<?php echo $IDB; ?>'),refresh();">
                    <span class="glyphicon glyphicon-print"></span> Imprimir Cupon
                </button></td>
                <?php } else if ($row['cm'] == '2') {?>
                <td><button type="button" class="btn btn-info btn-xs" onclick="imprimircupon('<?php echo $row['factura']; ?>','<?php echo $row['cm']; ?>','<?php echo $IDB; ?>'),refresh();">
                    <span class="glyphicon glyphicon-print"></span> Imprimir Cupon
                </button></td>
                <?php } else if ($row['cm'] == '3') {?>
                <td><button type="button" class="btn btn-info btn-xs" onclick="imprimircupon('<?php echo $row['factura']; ?>','<?php echo $row['cm']; ?>','<?php echo $IDB; ?>'),refresh();">
                    <span class="glyphicon glyphicon-print"></span> Imprimir Cupon
                </button></td>
                <?php }
                    } else {?>
                <td></td>
                <?php }?>
            </tr>
            <?php
$cont = $cont + 1;
                    if ($row['cm'] == '1') {
                        $contmaleta = $contmaleta + 1;
                    } else if ($row['cm'] == '2') {
                        $contjarros = $contjarros + 1;
                    } else if ($row['cm'] == '3') {
                        $contdescu = $contdescu + 1;
                    }

                }?>
            <tr>
            <th colspan="3"></th>
            <th>Total Cupones Emitidos: Maletas</th>
            <th></th>
            <th colspan="2"><?php echo $contmaleta; ?></th>
            </tr>
            <tr>
            <th colspan="3"></th>
            <th>Total Cupones Emitidos: Jarros</th>
            <th></th>
            <th colspan="2"><?php echo $contjarros; ?></th>
            </tr>
            <tr>
            <th colspan="3"></th>
            <th>Total Cupones Emitidos: Descuentos</th>
            <th></th>
            <th colspan="2"><?php echo $contdescu; ?></th>
            </tr>
            <tr>
            <th colspan="3"></th>
            <th>Total Cupones Emitidos: </th>
            <th></th>
            <th colspan="2"><?php echo $cont; ?></th>
            </tr>
            <?php } else {
                ?>
            <tr><td colspan="7">No se encontro resultados</td></tr>
            <?php
}
            break;

    }
} else {?>
    <img src="../recursos/spa.png" width="100%" height="480px">
<?php }