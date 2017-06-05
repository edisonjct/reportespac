<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../modelo/VentasModelo.php';
require_once '../modelo/BodegasModelo.php';

$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$sum_ventas = 0;
$sum_libros = 0;
$bodegas = new BodegasModelo();
$arraybodegasbase = $bodegas->get_BodegasBase();
?>

<table class="table table-bordered table-condensed table-hover table-striped">
    <thead>
        <tr>
            <th>LOCAL</th>
            <th>VENTA</th>
            <th>LIBROS</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($arraybodegasbase as $bodegaarray) {
            $ventas = new VentasModelo();
            $arrayventas = $ventas->get_ventas_nacional_diaria($bodegaarray, $desde, $hasta);
            foreach ($arrayventas as $row) {
                $sum_ventas = $sum_ventas + $row['venta'];
                $sum_libros = $sum_libros + $row['cantidad'];
                ?>
                <tr>
                    <td><?php echo $row['bodega']; ?></td>
                    <td><?php echo number_format($row['venta'], 2, '.', ','); ?></td>
                    <td><?php echo number_format($row['cantidad'], 0, '.', ','); ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
    <thead>
        <tr>
            <th> TOTALES: </th>
            <th><?php echo number_format($sum_ventas, 2, '.', ','); ?></th>
            <th><?php echo number_format($sum_libros, 0, '.', ','); ?></th>
        </tr>
    </thead>

</tbody>
</table>





