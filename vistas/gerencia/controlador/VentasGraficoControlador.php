<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$cd = 0;
$jr = 0;
$sl = 0;
$wb = 0;
$ev = 0;
$cn = 0;
$sc = 0;
$vl = 0;
$qc = 0;
$sls = 0;
$slm = 0;
$cm = 0;


require_once '../modelo/VentasModelo.php';

$ventas = new VentasModelo();
$matriz = $ventas->get_ventas_nacional_diaria_graficos('mrbooks', $desde, $hasta);
foreach ($matriz as $cd) { $cd['venta']; }
$jardin = $ventas->get_ventas_nacional_diaria_graficos('mrbookjardin', $desde, $hasta);
foreach ($jardin as $jr) { $cd['venta']; }
$sol = $ventas->get_ventas_nacional_diaria_graficos('mrbooksol', $desde, $hasta);
foreach ($sol as $sl) { $sl['venta']; }
$condado = $ventas->get_ventas_nacional_diaria_graficos('mrbookcondado', $desde, $hasta);
foreach ($condado as $cn) { $cn['venta']; }
$scala = $ventas->get_ventas_nacional_diaria_graficos('mrbooktumbaco', $desde, $hasta);
foreach ($scala as $sc) { $sc['venta']; }
$village = $ventas->get_ventas_nacional_diaria_graficos('mrbookvill', $desde, $hasta);
foreach ($village as $vl) { $vl['venta']; }
$quicentro = $ventas->get_ventas_nacional_diaria_graficos('mrbookquicentro', $desde, $hasta);
foreach ($quicentro as $qc) { $qc['venta']; }
$sluis = $ventas->get_ventas_nacional_diaria_graficos('mrbooksluis', $desde, $hasta);
foreach ($sluis as $sls) { $sls['venta']; }
$smarino = $ventas->get_ventas_nacional_diaria_graficos('mrbooksmarino', $desde, $hasta);
foreach ($smarino as $slm) { $slm['venta']; }
$cumbaya = $ventas->get_ventas_nacional_diaria_graficos('mrbookcumbaya', $desde, $hasta);
foreach ($cumbaya as $cm) { $cm['venta']; }
$web = $ventas->get_ventas_nacional_diaria_graficos('mrbookweb', $desde, $hasta);
foreach ($web as $wb) { $wb['venta']; }
$eventos = $ventas->get_ventas_nacional_diaria_graficos('mrbookeventos', $desde, $hasta);
foreach ($eventos as $ev) { $ev['venta']; }

$data = array(
    0 => round($cd['venta'],1),
    1 => round($jr['venta'],1),
    2 => round($sl['venta'],1),
    3 => round($cn['venta'],1),
    4 => round($sc['venta'],1),
    5 => round($vl['venta'],1),
    6 => round($qc['venta'],1),
    7 => round($sls['venta'],1),
    8 => round($slm['venta'],1),
    9 => round($cm['venta'],1),
    10 => round($wb['venta'],1),
    11 => round($ev['venta'],1),
    );

echo json_encode($data);