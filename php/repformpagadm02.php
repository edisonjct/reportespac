<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include('conexion.php');

$desde = $_GET['desde'];
$IDB = $_GET['IDB'];
$grupotabla = '';
$subtotaldoc = 0;
$subtotalvalor = 0;
$subtotalreg = 0;
$subtotaldif = 0;
$totalvalor = 0;
$totalreg = 0;
$cont = 0;

$vaciartablatm = mysql_query("TRUNCATE table mrb_tmp_fpagos;", $conexion);
$tmp_fpagos = mysql_query("INSERT INTO mrb_tmp_fpagos (tipo,documento,fpago,nomfpago,valor,usuario,bodega,fecha)
SELECT movcte.tipodoc43,movcte.numdocdb43,movcte.efectcheque43,maetab.nomtab,movcte.valorabono43,movcte.UID,
movcte.IDB,movcte.fecdoc43 FROM mrbooks.movcte
INNER JOIN mrbooks.maetab ON movcte.efectcheque43 = maetab.codtab
WHERE tipodoc43 = '80' AND fecdoc43 BETWEEN '$desde 00:00:00' AND '$desde 23:59:59' 
AND tipodocdb43 = '02' AND numtab = '78' AND codtab != '';", $conexion);
$tmp_notas = mysql_query("INSERT INTO mrb_tmp_fpagos (tipo,documento,fpago,nomfpago,valor,usuario,bodega,fecha)
SELECT mrbooks.movcte.tipodoc43,mrbooks.movcte.numdocdb43,mrbooks.movcte.efectcheque43,'NOTA DE CREDITO',
mrbooks.movcte.valorabono43,mrbooks.movcte.UID,mrbooks.movcte.IDB,mrbooks.movcte.fecdoc43
FROM mrbooks.movcte WHERE mrbooks.movcte.fecdoc43 BETWEEN '$desde 00:00:00' AND '$desde 23:59:59' AND
mrbooks.movcte.tipodocdb43 = '02' AND mrbooks.movcte.tipodoc43 = '77';", $conexion);
$tmp_creditos = mysql_query("INSERT INTO mrb_tmp_fpagos (tipo,documento,fpago,nomfpago,valor,usuario,bodega,fecha)
SELECT tipodoc43,numdoc43,'4','CREDITO EMPRESARIAL',valormov43,UID,IDB,fecdoc43
FROM mrbooks.movcte WHERE fecdoc43 BETWEEN '$desde 00:00:00' AND '$desde 23:59:59' AND 
tipodoc43 = '02' AND codpagounif43 = '1';", $conexion);
$vaciartablatmp2 = mysql_query("TRUNCATE table mrb_tmp_fpagos2;", $conexion);
$tmp_cierre2 = mysql_query("INSERT INTO mrb_tmp_fpagos2 (tipo,nombre,valor,conteo,uid,usuario,fecha)
SELECT p.fpago as tipo,p.nomfpago as nombre,sum(p.valor) as valor,count(p.fpago) as conteo,p.usuario as uid,
u.nombreusuario as usuario,'$desde 00:00:00' as fecha
FROM
mrb_tmp_fpagos p
INNER JOIN maefac as f ON p.documento = f.nofact31
INNER JOIN mrbooks_infosac.usuario as u ON p.usuario = u.UID
WHERE p.fecha BETWEEN '$desde 00:00:00' AND '$desde 23:59:59' AND 
f.fecfact31 BETWEEN '$desde 00:00:00' AND '$desde 23:59:59' AND f.cvanulado31 != '9'
GROUP BY p.usuario,p.fpago
ORDER BY p.usuario,p.fpago", $conexion);

$vaciartablatmp3 = mysql_query("TRUNCATE table cierres_tmp", $conexion);
$tmp_cierre3 = mysql_query("INSERT INTO cierres_tmp(codfpago,valor_cajero,uid)
SELECT codtipopago,valor_caja,UID FROM cierres
WHERE fecha = '$desde 00:00:00' AND tipocierre = 'I'", $conexion);

$function_usuarios = mysql_query("SELECT u.UID as user FROM mrbooks_infosac.usuario as u WHERE u.estusuario = 1");
while ($rowusuario = mysql_fetch_assoc($function_usuarios)) {
    $insertar_creditos = mysql_query("INSERT INTO cierres_tmp (codfpago, valor_cajero, uid) VALUES ('4', null, '" . $rowusuario['user'] . "');");
    $insertar_notas = mysql_query("INSERT INTO cierres_tmp (codfpago, valor_cajero, uid) VALUES ('39', null, '" . $rowusuario['user'] . "');");
}

$registro = "SELECT
f.tipo as tipo,
f.nombre as fpago,
f.conteo as cantidad,
f.valor as vsistema,
CASE WHEN f.tipo = 39 THEN f.valor
WHEN f.tipo = 4 THEN f.valor ELSE c.valor_cajero END as vcajero,
f.fecha as fecha,
(CASE WHEN f.tipo = 39 THEN f.valor
WHEN f.tipo = 4 THEN f.valor ELSE c.valor_cajero END) - f.valor as dif,
f.usuario as usuario,
f.uid as uid,
CASE WHEN (c.valor_cajero - f.valor) = 0 THEN 'OK'
WHEN (c.valor_cajero - f.valor) > 0 THEN 'SOBRANTE'
WHEN (c.valor_cajero - f.valor) < 0 THEN 'FALTANTE' END as estado
FROM
mrb_tmp_fpagos2 AS f
LEFT JOIN cierres_tmp as c ON c.codfpago = f.tipo WHERE c.uid = f.uid
ORDER BY uid,tipo";

$resultado = mysql_query($registro, $conexion);
?>
<?php if (mysql_num_rows($resultado) > 0) { ?>    
    <?php
    while ($row = mysql_fetch_assoc($resultado)) {
        $sql_maxGrupos = "SELECT count(uid) as max FROM mrb_tmp_fpagos2 as s WHERE s.fecha = '$desde 00:00:00' AND uid = '" . $row['uid'] . "'";
        $result_maxGrupos = mysql_query($sql_maxGrupos);
        $rowsubtotal = mysql_fetch_assoc($result_maxGrupos);
        $maximo_grupos = $rowsubtotal['max'];
        $grupoant = $grupotabla;
        $grupotabla = $row['uid'];
        $subtotaldoc = $subtotaldoc + $row['cantidad'];
        $subtotalvalor = $subtotalvalor + $row['vsistema'];
        $subtotalreg = $subtotalreg + $row['vcajero'];
        $subtotaldif = $subtotaldif + $row['dif'];
        ?>
        <?php if ($grupoant != $grupotabla) { ?>
            <table class="table table-striped table-condensed table-hover table-bordered" >    
                <tr>
                    <th colspan="7"><div align="center"><?php echo $row['usuario'] . ' - ' . $row['fecha']; ?></div></th>
                </tr>
                <tr>        
                    <th>TIPO</th>
                    <th>F.PAGO</th>
                    <th>CANTIDAD</th>
                    <th>VALOR.SISTEMA</th>
                    <th>VALOR.CAJA</th>
                    <th>DIFERENCIA</th>
                    <th>ESTADO</th>
                </tr>
            <?php } ?>                           
            <?php if ($row['tipo'] == 4) { ?>                
                <tr>
                    <td><?php echo $row['tipo']; ?></td>
                    <td><?php echo $row['fpago']; ?></td>
                    <td><?php echo $row['cantidad']; ?></td>
                    <td><?php echo number_format($row['vsistema'], 2, '.', ','); ?></td>
                    <td><?php echo number_format($row['vcajero'], 2, '.', ','); ?></td>
                    <td><?php echo number_format($row['dif'], 2, '.', ','); ?></td>
                    <td class="notasycreditos"><div align="center"><b>CREDITOS EMPRESARIALES</b></div></td>
                </tr>
            <?php } else if ($row['tipo'] == 39) { ?>
                <tr>
                    <td><?php echo $row['tipo']; ?></td>
                    <td><?php echo $row['fpago']; ?></td>
                    <td><?php echo $row['cantidad']; ?></td>
                    <td><?php echo number_format($row['vsistema'], 2, '.', ','); ?></td>
                    <td><?php echo number_format($row['vcajero'], 2, '.', ','); ?></td>
                    <td><?php echo number_format($row['dif'], 2, '.', ','); ?></td>
                    <td class="notasycreditos"><div align="center"><b>NOTAS DE CREDITO</b></div></td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td>
                        <a href="javascript:ventanaSecundaria('detalleformapago.php')">
                            <div class="item-container">                                                           
                                <?php echo $row['tipo']; ?></td>
                            </div>
                        </a>
                    <td><?php echo $row['fpago']; ?></td>
                    <td><?php echo $row['cantidad']; ?></td>
                    <td><?php echo number_format($row['vsistema'], 2, '.', ','); ?></td>
                    <td><?php echo number_format($row['vcajero'], 2, '.', ','); ?></td>
                    <td><?php echo number_format($row['dif'], 2, '.', ','); ?></td>
                    <?php if ($row['dif'] == 0) { ?>
                        <td bgcolor="#67b168"><div align="center"><b><?php echo $row['estado']; ?></b></div></td>
                    <?php } else if ($row['dif'] > 0) { ?>
                        <td bgcolor="yellow"><div align="center"><b><?php echo $row['estado']; ?></b></div></td>
                    <?php } else if ($row['dif'] < 0) { ?>
                        <td bgcolor="tomato"><div align="center"><b><?php echo $row['estado']; ?></b></div></td>
                    <?php } ?>
                </tr>
            <?php } ?>

        </tr>
        <?php $cont = $cont + 1; ?>
        <?php if ($cont == $maximo_grupos) { ?>
            <tr>
                <th colspan="2"></th>
                <th><?php echo number_format($subtotaldoc, 0, '.', ','); ?></th>
                <th><?php echo number_format($subtotalvalor, 2, '.', ','); ?></th>
                <th><?php echo number_format($subtotalreg, 2, '.', ','); ?></th>
                <th><?php echo number_format($subtotaldif, 2, '.', ','); ?></th>
                <th></th>
            </tr>
            <?php
            $cont = 0;
            $subtotaldoc = 0;
            $subtotalvalor = 0;
            $subtotalreg = 0;
            $subtotaldif = 0;
        }
        ?>
    <?php } ?>
    </table>
    <table class="table table-striped table-condensed table-hover table-bordered">
        <tr>
            <th colspan="4" class="totalfpagos">RESUMEN TOTALIZADO</th>
        </tr>
        <tr>
            <th class="totalfpagos">CODIGO</th>
            <th class="totalfpagos">NOMBRE</th>
            <th class="totalfpagos">VALOR</th>
            <th class="totalfpagos">REGISTROS</th> 
        </tr>
        <?php
        $registrototal = "SELECT
        p.fpago as codigo,
        p.nomfpago as nombre,
        sum(p.valor) as valor,
        count(p.fpago) as registros
        FROM
        mrb_tmp_fpagos p
        INNER JOIN maefac as f ON p.documento = f.nofact31
        INNER JOIN mrbooks_infosac.usuario as u ON p.usuario = u.UID
        WHERE p.fecha BETWEEN '$desde 00:00:00' AND '$desde 23:59:59' AND 
        f.fecfact31 BETWEEN '$desde 00:00:00' AND '$desde 23:59:59' AND f.cvanulado31 != '9'
        GROUP BY p.fpago
        ORDER BY p.fpago";
        $resultadototal = mysql_query($registrototal, $conexion);
        while ($rowtotal = mysql_fetch_assoc($resultadototal)) {
            $totalvalor = $totalvalor + $rowtotal['valor'];
            $totalreg = $totalreg + $rowtotal['registros'];
            ?>
            <tr>        
                <td><?php echo $rowtotal['codigo']; ?></td>
                <td><?php echo $rowtotal['nombre']; ?></td>
                <td><font color="#4169E1"><?php echo number_format($rowtotal['valor'], 2, '.', ','); ?></font></td>
                <td><font color="#A52A2A"><?php echo number_format($rowtotal['registros'], 0, '.', ','); ?></font></td>                
            </tr>
        <?php } ?>
        <tr>
            <th colspan="2" class="totalfpagos">Totales</th>
            <th class="totalfpagos"><?php echo number_format($totalvalor, 2, '.', ','); ?></th>
            <th class="totalfpagos"><?php echo number_format($totalreg, 0, '.', ','); ?></th>
        </tr>
    </table>
    <?php
} else {
    echo "No se encontraron Resultados";
}    