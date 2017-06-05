<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include('conexion.php');

$desde = $_GET['desde'];
$IDB = $_GET['IDB'];
$totaldoc = 0;
$totalvalor = 0;
$totalreg = 0;

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

$tmp_cierre2 = mysql_query("INSERT INTO mrb_tmp_fpagos2 (tipo,nombre,valor,conteo,uid,usuario,fecha)
SELECT p.fpago as tipo,p.nomfpago as nombre,sum(p.valor) as valor,count(p.fpago) as conteo,p.usuario as uid,
u.nombreusuario as usuario,'2016-09-01 00:00:00' as fecha
FROM
mrb_tmp_fpagos p
INNER JOIN maefac as f ON p.documento = f.nofact31
INNER JOIN mrbooks_infosac.usuario as u ON p.usuario = u.UID
WHERE p.fecha BETWEEN '$desde 00:00:00' AND '$desde 23:59:59' AND 
f.fecfact31 BETWEEN '$desde 00:00:00' AND '$desde 23:59:59' AND f.cvanulado31 != '9'
GROUP BY p.usuario,p.fpago
ORDER BY p.usuario,p.fpago", $conexion);

$registro = "SELECT
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

$document = "SELECT 
CASE WHEN cvanulado31 = 9 THEN 'Docuemtos Anulados' ELSE 'Docuentos Validos' END AS doc,
CASE WHEN cvanulado31 = 9 THEN count(cvanulado31) ELSE count(cvanulado31) END AS numdoc
FROM maefac 
WHERE fecfact31 BETWEEN '$desde 00:00:00' AND '$desde 23:59:59'
GROUP BY doc ORDER BY doc DESC";
$result = mysql_query($document, $conexion);
$resultado = mysql_query($registro, $conexion);
?>
<?php if (mysql_num_rows($resultado) > 0) { ?>
    <table class="table table-striped table-condensed table-hover">
        <tr>
            <th colspan="2"><div align="center">RESUMEN DE DOCUMENTOS</div></th>
        </tr>
        <tr>
            <th>NOMBRE</th>
            <th>CANTIDAD</th>
        </tr>
        <?php
        while ($row2 = mysql_fetch_assoc($result)) {
            $totaldoc = $totaldoc + $row2['numdoc'];
            ?>
            <tr>        
                <td><?php echo $row2['doc']; ?></td>
                <td><?php echo $row2['numdoc']; ?></td>                         
            </tr>
        <?php } ?>
        <tr>
            <th>Totales</th>
            <th><?php echo $totaldoc; ?></th>                
        </tr>
    </table>

    <table class="table table-striped table-condensed table-hover" >    
        <tr>
            <th colspan="4"><div align="center">RESUMEN DE FACTURACION POR FORMA DE PAGO</div></th>
        </tr>
        <tr>        
            <th>CODIGO</th>
            <th>NOMBRE</th>
            <th>VALOR</th>
            <th>REGISTROS</th>                
        </tr>

        <?php
        while ($row = mysql_fetch_assoc($resultado)) {
            $totalvalor = $totalvalor + $row['valor'];
            $totalreg = $totalreg + $row['registros'];
            ?>
            <tr>        
                <td><?php echo $row['codigo']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><font color="#4169E1"><?php echo number_format($row['valor'], 2, '.', ','); ?></font></td>
                <td><font color="#A52A2A"><?php echo number_format($row['registros'], 0, '.', ','); ?></font></td>                
            </tr>
    <?php } ?>
        <tr>
            <th colspan="2">Totales</th>
            <th><?php echo number_format($totalvalor, 2, '.', ','); ?></th>
            <th><?php echo number_format($totalreg, 0, '.', ','); ?></th>
        </tr>
<?php } else { ?>        
        <tr>
            <td colspan="20">No se encontraron resultados</td>
        </tr>
<?php } ?>
</table>