<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'conexion.php';
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=ordenes_de_compras.xls");
header("Pragma: no-cache");
header("Expires: 0");

$IDB         = $_GET["IDB"];
$ordenes     = $_GET["ordenes"];
$tipo        = $_GET["tipo"];
$op          = $_GET["op"];
$cont        = 0;
$sumcd       = 0;
$sumjr       = 0;
$sumsl       = 0;
$sumcn       = 0;
$sumsc       = 0;
$sumvl       = 0;
$sumpc       = 0;
$sumqc       = 0;
$sumlsl      = 0;
$sumlsm      = 0;
$sumcm       = 0;
$sumtotal    = 0;
$vacia_tabla = mysql_query("truncate table mrb_tmp_pivot");

if ($tipo == '0001') {
    if ($op == '1') {
        $query_tmp = "INSERT INTO mrb_tmp_pivot (codigo,CD,MJR,MSL,MCN,MSC,MVL,MPC,LQC,LSL,LSM,LCM,orden,provedor)
        SELECT
        r.codprod AS codinterno,
        sum(case when r.codbodega = '01' THEN r.cantidad ELSE '0' END) as '01',
        sum(case when r.codbodega = '03' THEN r.cantidad ELSE '0' END) as '03',
        sum(case when r.codbodega = '04' THEN r.cantidad ELSE '0' END) as '04',
        sum(case when r.codbodega = '05' THEN r.cantidad ELSE '0' END) as '05',
        sum(case when r.codbodega = '06' THEN r.cantidad ELSE '0' END) as '06',
        sum(case when r.codbodega = '07' THEN r.cantidad ELSE '0' END) as '07',
        sum(case when r.codbodega = '18' THEN r.cantidad ELSE '0' END) as '18',
        sum(case when r.codbodega = '16' THEN r.cantidad ELSE '0' END) as '16',
        sum(case when r.codbodega = '15' THEN r.cantidad ELSE '0' END) as '15',
        sum(case when r.codbodega = '14' THEN r.cantidad ELSE '0' END) as '14',
        sum(case when r.codbodega = '13' THEN r.cantidad ELSE '0' END) as '13',
        r.ordenimportacion as orden,
        r.codproveed AS nomprovedor
        FROM
        reqbodega AS r
        WHERE
        r.ordenimportacion in ($ordenes) AND r.estado = 'N'
        GROUP BY ordenimportacion,codprod";
        $tmp = mysql_query($query_tmp, $conexion);
        $sql = "SELECT
        r.codigo as codinterno,
        p.codbar01 as codigo,
        p.desprod01 as nombre,
        a.nombres as autor,
        e.razon as editorial,
        c.desccate as categoria,
        p.cantact01 as stockmatriz,
        pro.nomcte01 as provedor,
        sum(r.CD) as 'CD',
        sum(r.MJR) as 'MJR',
        sum(r.MSL) AS 'MSL',
        sum(r.MCN) AS 'MCN',
        sum(r.MSC) AS 'MSC',
        sum(r.MVL) AS 'MVL',
        sum(r.MPC) AS 'MPC',
        sum(r.LQC) AS 'LQC',
        sum(r.LSL) AS 'LSL',
        sum(r.LSM) AS 'LSM',
        sum(r.LCM) AS 'LCM',
        r.provedor as nomprovedor
        FROM mrb_tmp_pivot as r
        INNER JOIN maepro as p ON r.codigo = p.codprod01
        LEFT JOIN autores as a ON p.infor01 = a.codigo
        LEFT JOIN editoriales as e ON p.infor02 = e.codigo
        LEFT JOIN categorias as c ON p.catprod01 = c.codcate
        LEFT JOIN maepag as pro ON p.proved101 = pro.coddest01
        WHERE r.orden in ($ordenes) AND c.tipocate = '02'
        GROUP BY nomprovedor,codigo";
        $result = mysql_query($sql, $conexion);
        if (mysql_num_rows($result) > 0) {
            ?>
            <table class="table table-striped table-hover table-bordered">
                <tr>
                    <th>#</th>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Autor</th>
                    <th>Editorial</th>
                    <th>Categoria</th>
                    <th>Provedor</th>
                    <th>STK.CD</th>
                    <th>CD</th>
                    <th>MJR</th>
                    <th>MSL</th>
                    <th>MCN</th>
                    <th>MSC</th>
                    <th>MVL</th>
                    <th>MPC</th>
                    <th>LQC</th>
                    <th>LSL</th>
                    <th>LSM</th>
                    <th>MCM</th>
                    <th>TOTAL</th>
                </tr>
                <?php while ($row = mysql_fetch_assoc($result)) {
                $cont     = $cont + 1;
                $sumcd    = $sumcd + $row['CD'];
                $sumjr    = $sumjr + $row['MJR'];
                $sumsl    = $sumsl + $row['MSL'];
                $sumcn    = $sumcn + $row['MCN'];
                $sumsc    = $sumsc + $row['MSC'];
                $sumvl    = $sumvl + $row['MVL'];
                $sumpc    = $sumpc + $row['MPC'];
                $sumqc    = $sumqc + $row['LQC'];
                $sumlsl   = $sumlsl + $row['LSL'];
                $sumlsm   = $sumlsm + $row['LSM'];
                $sumcm    = $sumcm + $row['LCM'];
                $sumtotal = $sumtotal + $row['CD'] + $row['MJR'] + $row['MSL'] + $row['MCN'] + $row['MVL'] + $row['MPC'] + $row['MSC'] + $row['LQC'] + $row['LSL'] + $row['LSM'] + $row['LCM'];
                ?>
                    <tr>
                        <td><?php echo $cont; ?></td>
                        <td><?php echo $row['codigo']; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['autor']; ?></td>
                        <td><?php echo $row['editorial']; ?></td>
                        <td><?php echo $row['categoria']; ?></td>
                        <td><?php echo $row['provedor']; ?></td>
                        <td align="center"><?php echo number_format($row['stockmatriz'], 0, '.', ','); ?></td>
                        <td align="center"><?php echo $row['CD']; ?></td>
                        <td align="center"><?php echo $row['MJR']; ?></td>
                        <td align="center"><?php echo $row['MSL']; ?></td>
                        <td align="center"><?php echo $row['MCN']; ?></td>
                        <td align="center"><?php echo $row['MSC']; ?></td>
                        <td align="center"><?php echo $row['MVL']; ?></td>
                        <td align="center"><?php echo $row['MPC']; ?></td>
                        <td align="center"><?php echo $row['LQC']; ?></td>
                        <td align="center"><?php echo $row['LSL']; ?></td>
                        <td align="center"><?php echo $row['LSM']; ?></td>
                        <td align="center"><?php echo $row['LCM']; ?></td>
                        <td align="center"><?php echo $row['CD'] + $row['MJR'] + $row['MSL'] + $row['MCN'] + $row['MVL'] + $row['MPC'] + $row['MSC'] + $row['LQC'] + $row['LSL'] + $row['LSM'] + $row['LCM']; ?></td>

                    </tr>
                <?php }?>
                    <tr>
                        <th colspan="8" align="center">TOTALES:</th>
                        <th><?php echo number_format($sumcd, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumjr, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumsl, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumcn, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumsc, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumvl, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumpc, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumqc, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumlsl, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumlsm, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumcm, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumtotal, 0, '.', ','); ?></th>
                    </tr>
            </table>
            <?php
} else {
            echo "Sin registros";
            mysql_free_result($result);
        }
    } else {
        $query_tmp = "INSERT INTO mrb_tmp_pivot (codigo,CD,MJR,MSL,MCN,MSC,MVL,MPC,LQC,LSL,LSM,LCM,orden,provedor)
        SELECT
        r.codprod AS codinterno,
        sum(case when r.codbodega = '01' THEN r.cantidad ELSE '0' END) as '01',
        sum(case when r.codbodega = '03' THEN r.cantidad ELSE '0' END) as '03',
        sum(case when r.codbodega = '04' THEN r.cantidad ELSE '0' END) as '04',
        sum(case when r.codbodega = '05' THEN r.cantidad ELSE '0' END) as '05',
        sum(case when r.codbodega = '06' THEN r.cantidad ELSE '0' END) as '06',
        sum(case when r.codbodega = '07' THEN r.cantidad ELSE '0' END) as '07',
        sum(case when r.codbodega = '18' THEN r.cantidad ELSE '0' END) as '18',
        sum(case when r.codbodega = '16' THEN r.cantidad ELSE '0' END) as '16',
        sum(case when r.codbodega = '15' THEN r.cantidad ELSE '0' END) as '15',
        sum(case when r.codbodega = '14' THEN r.cantidad ELSE '0' END) as '14',
        sum(case when r.codbodega = '13' THEN r.cantidad ELSE '0' END) as '13',
        r.ordenimportacion as orden,
        r.codproveed AS nomprovedor
        FROM
        reqbodega AS r
        WHERE
        r.ordenimportacion in ($ordenes) AND r.estado = 'N'
        GROUP BY ordenimportacion,codprod";
        $tmp = mysql_query($query_tmp, $conexion);
        $sql = "SELECT
        r.codigo as codinterno,
        p.codbar01 as codigo,
        p.desprod01 as nombre,
        a.nombres as autor,
        e.razon as editorial,
        c.desccate as categoria,
        p.cantact01 as stockmatriz,
        pro.nomcte01 as provedor,
        r.CD as 'CD',
        r.MJR as 'MJR',
        r.MSL AS 'MSL',
        r.MCN AS 'MCN',
        r.MSC AS 'MSC',
        r.MVL AS 'MVL',
        r.MPC AS 'MPC',
        r.LQC AS 'LQC',
        r.LSL AS 'LSL',
        r.LSM AS 'LSM',
        r.LCM AS 'LCM',
        r.orden as orden,
        r.provedor as nomprovedor
        FROM mrb_tmp_pivot as r
        INNER JOIN maepro as p ON r.codigo = p.codprod01
        LEFT JOIN autores as a ON p.infor01 = a.codigo
        LEFT JOIN editoriales as e ON p.infor02 = e.codigo
        LEFT JOIN categorias as c ON p.catprod01 = c.codcate
        INNER JOIN maepag as pro ON p.proved101 = pro.coddest01
        WHERE r.orden in ($ordenes) AND c.tipocate = '02'
        GROUP BY orden,nomprovedor,codigo";
        $result = mysql_query($sql, $conexion);
        if (mysql_num_rows($result) > 0) {
            ?>
            <table class="table table-striped table-hover table-bordered">
                <tr>
                    <th>#</th>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Autor</th>
                    <th>Editorial</th>
                    <th>Categoria</th>
                    <th>Provedor</th>
                    <th>Orden</th>
                    <th>STK.CD</th>
                    <th>CD</th>
                    <th>MJR</th>
                    <th>MSL</th>
                    <th>MCN</th>
                    <th>MSC</th>
                    <th>MVL</th>
                    <th>MPC</th>
                    <th>LQC</th>
                    <th>LSL</th>
                    <th>LSM</th>
                    <th>MCM</th>
                    <th>TOTAL</th>
                </tr>
                <?php while ($row = mysql_fetch_assoc($result)) {
                $cont     = $cont + 1;
                $sumcd    = $sumcd + $row['CD'];
                $sumjr    = $sumjr + $row['MJR'];
                $sumsl    = $sumsl + $row['MSL'];
                $sumcn    = $sumcn + $row['MCN'];
                $sumsc    = $sumsc + $row['MSC'];
                $sumvl    = $sumvl + $row['MVL'];
                $sumpc    = $sumpc + $row['MPC'];
                $sumqc    = $sumqc + $row['LQC'];
                $sumlsl   = $sumlsl + $row['LSL'];
                $sumlsm   = $sumlsm + $row['LSM'];
                $sumcm    = $sumcm + $row['LCM'];
                $sumtotal = $sumtotal + $row['CD'] + $row['MJR'] + $row['MSL'] + $row['MCN'] + $row['MVL'] + $row['MPC'] + $row['MSC'] + $row['LQC'] + $row['LSL'] + $row['LSM'] + $row['LCM'];
                ?>
                    <tr>
                        <td><?php echo $cont; ?></td>
                        <td><?php echo $row['codigo']; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['autor']; ?></td>
                        <td><?php echo $row['editorial']; ?></td>
                        <td><?php echo $row['categoria']; ?></td>
                        <td><?php echo $row['provedor']; ?></td>
                        <td><?php echo $row['orden']; ?></td>
                        <td align="center"><?php echo number_format($row['stockmatriz'], 0, '.', ','); ?></td>
                        <td align="center"><?php echo $row['CD']; ?></td>
                        <td align="center"><?php echo $row['MJR']; ?></td>
                        <td align="center"><?php echo $row['MSL']; ?></td>
                        <td align="center"><?php echo $row['MCN']; ?></td>
                        <td align="center"><?php echo $row['MSC']; ?></td>
                        <td align="center"><?php echo $row['MVL']; ?></td>
                        <td align="center"><?php echo $row['MPC']; ?></td>
                        <td align="center"><?php echo $row['LQC']; ?></td>
                        <td align="center"><?php echo $row['LSL']; ?></td>
                        <td align="center"><?php echo $row['LSM']; ?></td>
                        <td align="center"><?php echo $row['LCM']; ?></td>
                        <td align="center"><?php echo $row['CD'] + $row['MJR'] + $row['MSL'] + $row['MCN'] + $row['MVL'] + $row['MPC'] + $row['MSC'] + $row['LQC'] + $row['LSL'] + $row['LSM'] + $row['LCM']; ?></td>

                    </tr>
                <?php }?>
                    <tr>
                        <th colspan="9" align="center">TOTALES:</th>
                        <th><?php echo number_format($sumcd, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumjr, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumsl, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumcn, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumsc, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumvl, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumpc, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumqc, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumlsl, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumlsm, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumcm, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumtotal, 0, '.', ','); ?></th>
                    </tr>
            </table>
            <?php
} else {
            echo "Sin registros";
            mysql_free_result($result);
        }
    }
} else {
    if ($op == '1') {
        $query_tmp = "INSERT INTO mrb_tmp_pivot (codigo,CD,MJR,MSL,MCN,MSC,MVL,MPC,LQC,LSL,LSM,LCM,orden,provedor)
        SELECT
        r.codprod AS codinterno,
        sum(case when r.codbodega = '01' THEN r.cantidad ELSE '0' END) as '01',
        sum(case when r.codbodega = '03' THEN r.cantidad ELSE '0' END) as '03',
        sum(case when r.codbodega = '04' THEN r.cantidad ELSE '0' END) as '04',
        sum(case when r.codbodega = '05' THEN r.cantidad ELSE '0' END) as '05',
        sum(case when r.codbodega = '06' THEN r.cantidad ELSE '0' END) as '06',
        sum(case when r.codbodega = '07' THEN r.cantidad ELSE '0' END) as '07',
        sum(case when r.codbodega = '18' THEN r.cantidad ELSE '0' END) as '18',
        sum(case when r.codbodega = '16' THEN r.cantidad ELSE '0' END) as '16',
        sum(case when r.codbodega = '15' THEN r.cantidad ELSE '0' END) as '15',
        sum(case when r.codbodega = '14' THEN r.cantidad ELSE '0' END) as '14',
        sum(case when r.codbodega = '13' THEN r.cantidad ELSE '0' END) as '13',
        r.ordencompra as orden,
        r.codproveed AS nomprovedor
        FROM
        reqbodega AS r
        WHERE
        r.ordencompra in ($ordenes) AND r.estado = 'N'
        GROUP BY ordencompra,codprod";
        $tmp = mysql_query($query_tmp, $conexion);
        $sql = "SELECT
        r.codigo as codinterno,
        p.codbar01 as codigo,
        p.desprod01 as nombre,
        a.nombres as autor,
        e.razon as editorial,
        c.desccate as categoria,
        p.cantact01 as stockmatriz,
        pro.nomcte01 as provedor,
        sum(r.CD) as 'CD',
        sum(r.MJR) as 'MJR',
        sum(r.MSL) AS 'MSL',
        sum(r.MCN) AS 'MCN',
        sum(r.MSC) AS 'MSC',
        sum(r.MVL) AS 'MVL',
        sum(r.MPC) AS 'MPC',
        sum(r.LQC) AS 'LQC',
        sum(r.LSL) AS 'LSL',
        sum(r.LSM) AS 'LSM',
        sum(r.LCM) AS 'LCM',
        r.provedor as nomprovedor
        FROM mrb_tmp_pivot as r
        INNER JOIN maepro as p ON r.codigo = p.codprod01
        LEFT JOIN autores as a ON p.infor01 = a.codigo
        LEFT JOIN editoriales as e ON p.infor02 = e.codigo
        LEFT JOIN categorias as c ON p.catprod01 = c.codcate
        INNER JOIN maepag as pro ON p.proved101 = pro.coddest01
        WHERE r.orden in ($ordenes) AND c.tipocate = '02'
        GROUP BY nomprovedor,codigo";
        $result = mysql_query($sql, $conexion);
        if (mysql_num_rows($result) > 0) {
            ?>
            <table class="table table-striped table-hover table-bordered">
                <tr>
                    <th>#</th>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Autor</th>
                    <th>Editorial</th>
                    <th>Categoria</th>
                    <th>Provedor</th>
                    <th>STK.CD</th>
                     <th>CD</th>
                    <th>MJR</th>
                    <th>MSL</th>
                    <th>MCN</th>
                    <th>MSC</th>
                    <th>MVL</th>
                    <th>MPC</th>
                    <th>LQC</th>
                    <th>LSL</th>
                    <th>LSM</th>
                    <th>MCM</th>
                    <th>TOTAL</th>
                </tr>
                <?php while ($row = mysql_fetch_assoc($result)) {
                $cont     = $cont + 1;
                $sumcd    = $sumcd + $row['CD'];
                $sumjr    = $sumjr + $row['MJR'];
                $sumsl    = $sumsl + $row['MSL'];
                $sumcn    = $sumcn + $row['MCN'];
                $sumsc    = $sumsc + $row['MSC'];
                $sumvl    = $sumvl + $row['MVL'];
                $sumpc    = $sumpc + $row['MPC'];
                $sumqc    = $sumqc + $row['LQC'];
                $sumlsl   = $sumlsl + $row['LSL'];
                $sumlsm   = $sumlsm + $row['LSM'];
                $sumcm    = $sumcm + $row['LCM'];
                $sumtotal = $sumtotal + $row['CD'] + $row['MJR'] + $row['MSL'] + $row['MCN'] + $row['MVL'] + $row['MPC'] + $row['MSC'] + $row['LQC'] + $row['LSL'] + $row['LSM'] + $row['LCM'];
                ?>
                    <tr>
                        <td><?php echo $cont; ?></td>
                        <td><?php echo $row['codigo']; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['autor']; ?></td>
                        <td><?php echo $row['editorial']; ?></td>
                        <td><?php echo $row['categoria']; ?></td>
                        <td><?php echo $row['provedor']; ?></td>
                        <td align="center"><?php echo number_format($row['stockmatriz'], 0, '.', ','); ?></td>
                        <td align="center"><?php echo $row['CD']; ?></td>
                        <td align="center"><?php echo $row['MJR']; ?></td>
                        <td align="center"><?php echo $row['MSL']; ?></td>
                        <td align="center"><?php echo $row['MCN']; ?></td>
                        <td align="center"><?php echo $row['MSC']; ?></td>
                        <td align="center"><?php echo $row['MVL']; ?></td>
                        <td align="center"><?php echo $row['MPC']; ?></td>
                        <td align="center"><?php echo $row['LQC']; ?></td>
                        <td align="center"><?php echo $row['LSL']; ?></td>
                        <td align="center"><?php echo $row['LSM']; ?></td>
                        <td align="center"><?php echo $row['LCM']; ?></td>
                        <td align="center"><?php echo $row['CD'] + $row['MJR'] + $row['MSL'] + $row['MCN'] + $row['MVL'] + $row['MPC'] + $row['MSC'] + $row['LQC'] + $row['LSL'] + $row['LSM'] + $row['LCM']; ?></td>

                    </tr>
                <?php }?>
                    <tr>
                        <th colspan="8" align="center">TOTALES:</th>
                        <th><?php echo number_format($sumcd, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumjr, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumsl, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumcn, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumsc, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumvl, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumpc, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumqc, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumlsl, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumlsm, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumcm, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumtotal, 0, '.', ','); ?></th>
                    </tr>
            </table>
            <?php
} else {
            echo "Sin registros";
            mysql_free_result($result);
        }
    } else {
        $query_tmp = "INSERT INTO mrb_tmp_pivot (codigo,CD,MJR,MSL,MCN,MSC,MVL,MPC,LQC,LSL,LSM,LCM,orden,provedor)
        SELECT
        r.codprod AS codinterno,
        sum(case when r.codbodega = '01' THEN r.cantidad ELSE '0' END) as '01',
        sum(case when r.codbodega = '03' THEN r.cantidad ELSE '0' END) as '03',
        sum(case when r.codbodega = '04' THEN r.cantidad ELSE '0' END) as '04',
        sum(case when r.codbodega = '05' THEN r.cantidad ELSE '0' END) as '05',
        sum(case when r.codbodega = '06' THEN r.cantidad ELSE '0' END) as '06',
        sum(case when r.codbodega = '07' THEN r.cantidad ELSE '0' END) as '07',
        sum(case when r.codbodega = '18' THEN r.cantidad ELSE '0' END) as '18',
        sum(case when r.codbodega = '16' THEN r.cantidad ELSE '0' END) as '16',
        sum(case when r.codbodega = '15' THEN r.cantidad ELSE '0' END) as '15',
        sum(case when r.codbodega = '14' THEN r.cantidad ELSE '0' END) as '14',
        sum(case when r.codbodega = '13' THEN r.cantidad ELSE '0' END) as '13',
        r.ordencompra as orden,
        r.codproveed AS nomprovedor
        FROM
        reqbodega AS r
        WHERE
        r.ordencompra in ($ordenes) AND r.estado = 'N'
        GROUP BY ordencompra,codprod";
        $tmp = mysql_query($query_tmp, $conexion);
        $sql = "SELECT
        r.codigo as codinterno,
        p.codbar01 as codigo,
        p.desprod01 as nombre,
        a.nombres as autor,
        e.razon as editorial,
        c.desccate as categoria,
        p.cantact01 as stockmatriz,
        pro.nomcte01 as provedor,
        r.CD as 'CD',
        r.MJR as 'MJR',
        r.MSL AS 'MSL',
        r.MCN AS 'MCN',
        r.MSC AS 'MSC',
        r.MVL AS 'MVL',
        r.MPC AS 'MPC',
        r.LQC AS 'LQC',
        r.LSL AS 'LSL',
        r.LSM AS 'LSM',
        r.LCM AS 'LCM',
        r.orden as orden,
        r.provedor as nomprovedor
        FROM mrb_tmp_pivot as r
        INNER JOIN maepro as p ON r.codigo = p.codprod01
        LEFT JOIN autores as a ON p.infor01 = a.codigo
        LEFT JOIN editoriales as e ON p.infor02 = e.codigo
        LEFT JOIN categorias as c ON p.catprod01 = c.codcate
        INNER JOIN maepag as pro ON p.proved101 = pro.coddest01
        WHERE r.orden in ($ordenes) AND c.tipocate = '02'
        GROUP BY orden,nomprovedor,codigo";
        $result = mysql_query($sql, $conexion);
        if (mysql_num_rows($result) > 0) {
            ?>
            <table class="table table-striped table-hover table-bordered">
                <tr>
                    <th>#</th>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Autor</th>
                    <th>Editorial</th>
                    <th>Categoria</th>
                    <th>Provedor</th>
                    <th>Orden</th>
                    <th>STK.CD</th>
                    <th>CD</th>
                    <th>MJR</th>
                    <th>MSL</th>
                    <th>MCN</th>
                    <th>MSC</th>
                    <th>MVL</th>
                    <th>MPC</th>
                    <th>LQC</th>
                    <th>LSL</th>
                    <th>LSM</th>
                    <th>MCM</th>
                    <th>TOTAL</th>
                </tr>
                <?php while ($row = mysql_fetch_assoc($result)) {
                $cont     = $cont + 1;
                $sumcd    = $sumcd + $row['CD'];
                $sumjr    = $sumjr + $row['MJR'];
                $sumsl    = $sumsl + $row['MSL'];
                $sumcn    = $sumcn + $row['MCN'];
                $sumsc    = $sumsc + $row['MSC'];
                $sumvl    = $sumvl + $row['MVL'];
                $sumpc    = $sumpc + $row['MPC'];
                $sumqc    = $sumqc + $row['LQC'];
                $sumlsl   = $sumlsl + $row['LSL'];
                $sumlsm   = $sumlsm + $row['LSM'];
                $sumcm    = $sumcm + $row['LCM'];
                $sumtotal = $sumtotal + $row['CD'] + $row['MJR'] + $row['MSL'] + $row['MCN'] + $row['MVL'] + $row['MPC'] + $row['MSC'] + $row['LQC'] + $row['LSL'] + $row['LSM'] + $row['LCM'];
                ?>
                    <tr>
                        <td><?php echo $cont; ?></td>
                        <td><?php echo $row['codigo']; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['autor']; ?></td>
                        <td><?php echo $row['editorial']; ?></td>
                        <td><?php echo $row['categoria']; ?></td>
                        <td><?php echo $row['provedor']; ?></td>
                        <td><?php echo $row['orden']; ?></td>
                        <td align="center"><?php echo number_format($row['stockmatriz'], 0, '.', ','); ?></td>
                        <td align="center"><?php echo $row['CD']; ?></td>
                        <td align="center"><?php echo $row['MJR']; ?></td>
                        <td align="center"><?php echo $row['MSL']; ?></td>
                        <td align="center"><?php echo $row['MCN']; ?></td>
                        <td align="center"><?php echo $row['MSC']; ?></td>
                        <td align="center"><?php echo $row['MVL']; ?></td>
                        <td align="center"><?php echo $row['MPC']; ?></td>
                        <td align="center"><?php echo $row['LQC']; ?></td>
                        <td align="center"><?php echo $row['LSL']; ?></td>
                        <td align="center"><?php echo $row['LSM']; ?></td>
                        <td align="center"><?php echo $row['LCM']; ?></td>
                        <td align="center"><?php echo $row['CD'] + $row['MJR'] + $row['MSL'] + $row['MCN'] + $row['MVL'] + $row['MPC'] + $row['MSC'] + $row['LQC'] + $row['LSL'] + $row['LSM'] + $row['LCM']; ?></td>

                    </tr>
                <?php }?>
                    <tr>
                        <th colspan="9" align="center">TOTALES:</th>
                        <th><?php echo number_format($sumcd, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumjr, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumsl, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumcn, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumsc, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumvl, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumpc, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumqc, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumlsl, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumlsm, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumcm, 0, '.', ','); ?></th>
                        <th><?php echo number_format($sumtotal, 0, '.', ','); ?></th>
                    </tr>
            </table>
            <?php
} else {
            echo "Sin registros";
            mysql_free_result($result);
        }
    }
}