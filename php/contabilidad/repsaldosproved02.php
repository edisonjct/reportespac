<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include('../conexionc.php');

$provedores = $_POST['provedor'];
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$ID = $_POST['ID'];
$IDB = $_POST['IDB'];
$grupotabla = '';
$cont = 0;
$totalsaldo = 0;
$totalanticipo = 0;
$saldoneto = 0;
$saldoactualtipo = 0;

$query = "SELECT 
p.tipcte01 as tipo,
t.nomtab as nomtipo,
p.codcte01 as codigo,
p.nomcte01 as provedor,
(SELECT (SUM(CASE WHEN m.tipodoc43 IN (01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50) THEN m.totdoc43 ELSE 0 END)) - (SUM(CASE WHEN m.tipodoc43 IN (51,52,53,53.1,54,55,56,57,57.1,58,58.1,58.2,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,99.1) THEN m.valorabono43 ELSE 0 END)) FROM movpag as m WHERE m.codcte43 = p.codcte01 AND m.fecdoc43 BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' GROUP BY m.codcte43) as saldo,
(SELECT (SUM(CASE WHEN mm.tipodoc43 IN (01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50) THEN mm.valorabono43 ELSE 0 END)) - (SUM(CASE WHEN mm.tipodoc43 IN (51,52,53,53.1,54,55,56,57,57.1,58,58.1,58.2,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,99.1) THEN mm.valorabono43 ELSE 0 END)) FROM movpag2 as mm WHERE mm.codcte43 = p.codcte01 AND mm.fecdoc43 BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' GROUP BY mm.codcte43) as antic,
p.sdoact01 as saldoac
FROM
maepag p
INNER JOIN maetab as t ON p.tipcte01 = t.codtab
WHERE p.codcte01 IN ($provedores) AND t.numtab = '69' AND t.codtab != ''
GROUP BY p.codcte01
ORDER BY p.tipcte01,p.nomcte01;";
$result = mysql_query($query);
?>
<?php if (mysql_num_rows($result) > 0) { ?>
    <?php while ($row = mysql_fetch_assoc($result)) { ?>
        <?php
        $sql_maxGrupos = "SELECT count(p.tipcte01) as max FROM maepag p WHERE p.tipcte01 = '" . $row['tipo'] . "' AND p.codcte01 IN ($provedores) ORDER BY p.tipcte01,p.nomcte01 ";
        $result_maxGrupos = mysql_query($sql_maxGrupos);
        $rowsubtotal = mysql_fetch_assoc($result_maxGrupos);
        $maximo_grupos = $rowsubtotal['max'];
        $totalsaldo = $totalsaldo + $row['saldo'];        
        $totalanticipo = $totalanticipo + $row['antic'];
        $saldoneto = $saldoneto + ($row['saldo'] + $row['antic']);
        $saldoactualtipo = $saldoactualtipo + $row['saldoac'];
        $grupoant = $grupotabla;
        $grupotabla = $row['tipo'];
        ?>
        <?php if ($grupoant != $grupotabla) { ?>
            <table class="table table-striped table-hover table-bordered table-condensed">
                <tr>
                    <th colspan="6"><?php echo $row['nomtipo'] ?></th>
                </tr>
                <tr>        
                    <th>CATEGORIA</th>
                    <th>PROVEDOR</th>
                    <th>SALDO</th>
                    <th>ANTICIPO</th>
                    <th>SALDO NETO</th>
                    <th>SALDO ACTUAL</th>
                </tr>                
        <?php $cont = 0; } ?>
            <tr>
                <td><?php echo $row['nomtipo'] ?></td>
                <td><a href="../../php/contabilidad/darioxprovedor.php?provedor=<?php echo $row['codigo']?>&desde=<?php echo $desde?>&hasta=<?php echo $hasta?>&IDB=<?php echo $IDB?>" target="_blank" onclick="window.open(this.href,this.target,'width=1200,height=680,top=1,left=1,toolbar=no,location=no,status=no,menubar=no');return false;"><?php echo $row['provedor'] ?></a></td>                
                <td align="center"><?php if ($row['saldo'] == null) { echo number_format(0, 2, '.', ','); } else { echo number_format($row['saldo'], 2, '.', ','); } ?></td>
                <td align="center"><?php if ($row['antic'] == null) { echo number_format(0, 2, '.', ','); } else { echo number_format($row['antic'], 2, '.', ','); } ?></td>
                <td align="center"><?php echo number_format(($row['saldo'] + $row['antic']), 2, '.', ',') ?></td>
                <td align="center"><?php if ($row['saldoac'] == null) { echo number_format(0, 2, '.', ','); } else { echo number_format($row['saldoac'], 2, '.', ','); } ?></td>
            </tr>
            
            <?php $cont = $cont + 1;?>
            <?php  if ($cont == $maximo_grupos) { ?>
            <tr>
                <th colspan="2">TOTAL <?php echo $row['nomtipo'].': '.$cont ?>: </th>
                <th><?php echo number_format($totalsaldo, 2, '.', ',');?></th>
                <th><?php echo number_format($totalanticipo, 2, '.', ',');?></th>
                <th><?php echo number_format($saldoneto, 2, '.', ',');?></th>
                <th><?php echo number_format($saldoactualtipo, 2, '.', ',');?></th>
            </tr>
            <hr width=90% align="center">
            <?php 
            $totalsaldo = 0;
            $totalanticipo = 0;
            $saldoneto = 0;
            $saldoactualtipo = 0;            
            } ?>
    <?php } ?> 
            
    </table>

<?php } else { ?>        
    <tr>
        <td colspan="20">No se encontraron resultados</td>
    </tr>
<?php } 