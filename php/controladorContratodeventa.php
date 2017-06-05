<?php

include 'conexion.php';

$IDB     = $_GET['IDB'];
$ID      = $_GET['ID'];
$UID     = $_GET['UID'];
$proceso = $_GET['proceso'];

switch ($proceso) {
    case 'secuencual':
        $establecimiento        = "SELECT ad7tab as establecimiento FROM maetab WHERE numtab = '01' AND codtab = '26' LIMIT 1; ";
        $result_establecimiento = mysql_query($establecimiento);
        $row_establecimiento    = mysql_fetch_array($result_establecimiento);
        $secuencual             = "SELECT ad1tab as ultimo FROM maetab WHERE numtab = '41' AND codtab = '85.1' LIMIT 1;";
        $result_secuencial      = mysql_query($secuencual);
        $row_secuencial         = mysql_fetch_array($result_secuencial);
        $ultimo                 = number_format($row_secuencial['ultimo'], 0, '', '');
        if (strlen($ultimo) == 1) {
            $ultimosecuencial = '00000000' . $ultimo;
        } else if (strlen($ultimo) == 2) {
            $ultimosecuencial = '0000000' . $ultimo;
        } else if (strlen($ultimo) == 3) {
            $ultimosecuencial = '000000' . $ultimo;
        } else if (strlen($ultimo) == 4) {
            $ultimosecuencial = '00000' . $ultimo;
        } else if (strlen($ultimo) == 5) {
            $ultimosecuencial = '0000' . $ultimo;
        } else if (strlen($ultimo) == 6) {
            $ultimosecuencial = '000' . $ultimo;
        } else if (strlen($ultimo) == 7) {
            $ultimosecuencial = '00' . $ultimo;
        } else if (strlen($ultimo) == 8) {
            $ultimosecuencial = '0' . $ultimo;
        } else if (strlen($ultimo) == 9) {
            $ultimosecuencial = $ultimo;
        }

        echo $numero_ultimo_documento = $row_establecimiento['establecimiento'] . $ultimosecuencial;

        //echo "desde del swith";
        break;

    case 'ultimo':

        $secuencual        = "SELECT ad1tab as ultimo FROM maetab WHERE numtab = '41' AND codtab = '85.1' LIMIT 1;";
        $result_secuencial = mysql_query($secuencual);
        $row_secuencial    = mysql_fetch_array($result_secuencial);
        $ultimo            = number_format($row_secuencial['ultimo'], 0, '', '');
        $utimosec          = $ultimo + 1;
        //echo "desde del swith";
        break;

    case 'addformadepago':
        $documento   = $_GET['documento'];
        $codtemp     = $_GET['codtemp'];
        $total_valor = "SELECT sum(valor) as total FROM mrbtmpdcvg WHERE cod_tmp = '$codtemp' AND codigo_documento = '$documento';";
        $row         = mysql_fetch_array(mysql_query($total_valor));
        $total       = $row['total'];
        $total_fp    = "SELECT sum(total) as total FROM mrbtmpfpcvg WHERE cod_tmp = '$codtemp' AND numero_documento = '$documento';";
        $row_fp      = mysql_fetch_array(mysql_query($total_fp));
        $to_fp       = $row_fp['total'];
        $subtotal    = $total - $to_fp;
        //$insertfp    = "INSERT INTO mrbtmpfpcvg (cod_tmp, numero_documento, fecha, codigo_forma_pago, observacion, total) VALUES ('$codtemp', '$documento', NOW(), '2', '' ,  '$total');";
        //$result_insert = mysql_query($insertfp);
        $consulta = "SELECT
                        t.numero_documento as documento,
                        t.fecha as fecha,
                        t.codigo_forma_pago as codfp,
                        t.total as valor,
                        f.nomtab as fp,
                        t.observacion as observacion,
                        t.cod_tmp as codtmp
                        FROM
                        mrbtmpfpcvg AS t
                        INNER JOIN mrb_fp_contratos as f ON t.codigo_forma_pago = f.codtab
                        WHERE t.cod_tmp = '$codtemp' AND t.numero_documento = '$documento' ORDER BY t.fecha ASC; ";
        $result_addfp = mysql_query($consulta);
        ?>
                        <table width="40%" border="0" id="detalle">
                        <input class="hide" type="text" size="5%" id="txt-total-productos" value="<?php echo round($subtotal, 2); ?>">
                        <?php while ($row2 = mysql_fetch_array($result_addfp)) {?>
                            <tr>
                                <td><img src="../recursos/b_drop.png" onclick="eliminaritem();"></td>
                                <td><input type="text" size="31%" id="txt-formadepago" value="<?php echo $row2['fp']; ?>"></td>
                                <td><input type="text" size="15%" id="txt-emisor"></td>
                                <td><input type="text" size="15%" id="txt-fechactual" value="<?php echo date("Y/m/d"); ?>"></td>
                                <td><input type="text" disabled="true" size="5%" id="txt-subtotal" value="<?php echo round($row2['valor'], 2); ?>"></td>
                            </tr>
                        <?php }?>
                        </table>
                        <table width="40%" border="0" id="detalle">
                            <tr>
                                <td><img src="../recursos/b_drop.png" onclick="eliminaritem();"></td>
                                <td>
                                    <select id="tipoformadepago">
                                    <?php $query = mysql_query("SELECT codtab,nomtab FROM mrbooks.maetab WHERE numtab = '78' AND ad5tab = '0' AND codtab != '';");?>
                                    <?php if (mysql_num_rows($query) > 0) {?>
                                        <?php while ($row = mysql_fetch_array($query)) {?>
                                                 <option value="<?php echo $row['codtab'] ?>"><?php echo $row['nomtab']; ?></option>
                                        <?php }}?>
                                    </select>
                                </td>
                                <td><input type="text" size="15%" id="txt-emisor"></td>
                                <td><input type="text" size="15%" id="txt-fechactual" value="<?php echo date("Y/m/d"); ?>"></td>
                                <td><input type="text" size="5%" id="txt-total" onchange="validamayor(this.value);" value="<?php echo round($subtotal, 2); ?>"></td>
                            </tr>
                        </table>

                <?php
break;

    case 'addformadepago2':
        $documento     = $_GET['documento'];
        $codtemp       = $_GET['codtemp'];
        $fp            = $_GET['fp'];
        $valor         = $_GET['valor'];
        $total_valor   = "SELECT sum(valor) as total FROM mrbtmpdcvg WHERE cod_tmp = '$codtemp' AND codigo_documento = '$documento';";
        $row           = mysql_fetch_array(mysql_query($total_valor));
        $total         = $row['total'];
        $insertfp      = "INSERT INTO mrbtmpfpcvg (cod_tmp, numero_documento, fecha, codigo_forma_pago, observacion, total) VALUES ('$codtemp', '$documento', NOW(), '$fp', '' ,  '$valor');";
        $result_insert = mysql_query($insertfp);
        $total_fp      = "SELECT sum(total) as total FROM mrbtmpfpcvg WHERE cod_tmp = '$codtemp' AND numero_documento = '$documento';";
        $row_fp        = mysql_fetch_array(mysql_query($total_fp));
        $to_fp         = $row_fp['total'];
        $subtotal      = $total - $to_fp;
        $consulta      = "SELECT
                        t.numero_documento as documento,
                        t.fecha as fecha,
                        t.codigo_forma_pago as codfp,
                        t.total as valor,
                        f.nomtab as fp,
                        t.observacion as observacion,
                        t.cod_tmp as codtmp
                        FROM
                        mrbtmpfpcvg AS t
                        INNER JOIN mrb_fp_contratos as f ON t.codigo_forma_pago = f.codtab
                        WHERE t.cod_tmp = '$codtemp' AND t.numero_documento = '$documento' ORDER BY t.fecha ASC; ";
        $result_addfp = mysql_query($consulta);
        ?>
                        <table width="40%" border="0" id="detalle">
                        <input class="hide" type="text" size="5%" id="txt-total-productos" value="<?php echo round($subtotal, 2); ?>">
                        <?php while ($row2 = mysql_fetch_array($result_addfp)) {?>
                            <tr>
                                <td><img src="../recursos/b_drop.png" onclick="eliminaritem();"></td>
                                <td><input type="text" size="31%" id="txt-formadepago" value="<?php echo $row2['fp']; ?>"></td>
                                <td><input type="text" size="15%" id="txt-emisor"></td>
                                <td><input type="text" size="15%" id="txt-fechactual" value="<?php echo date("Y/m/d"); ?>"></td>
                                <td><input type="text" disabled="true" size="5%" id="txt-subtotal" value="<?php echo round($row2['valor'], 2); ?>"></td>
                            </tr>
                        <?php }?>
                        </table>
                        <table width="40%" border="0" id="detalle">
                            <tr>
                                <td><img src="../recursos/b_drop.png" onclick="eliminaritem();"></td>
                                <td>
                                    <select id="tipoformadepago">
                                    <?php $query = mysql_query("SELECT codtab,nomtab FROM mrbooks.maetab WHERE numtab = '78' AND ad5tab = '0' AND codtab != '';");?>
                                    <?php if (mysql_num_rows($query) > 0) {?>
                                        <?php while ($row = mysql_fetch_array($query)) {?>
                                                 <option value="<?php echo $row['codtab'] ?>"><?php echo $row['nomtab']; ?></option>
                                        <?php }}?>
                                    </select>
                                </td>
                                <td><input type="text" size="15%" id="txt-emisor"></td>
                                <td><input type="text" size="15%" id="txt-fechactual" value="<?php echo date("Y/m/d"); ?>"></td>
                                <td><input type="text" size="5%" id="txt-total" onchange="validamayor(this.value);" value="<?php echo round($subtotal, 2); ?>"></td>
                            </tr>
                        </table>

                <?php
break;

    case 'buscar_cliente':
        $cedula               = $_GET['cedula'];
        $query_buscar_cliente = "SELECT
        cascte01 as cedula,
        nomcte01 as nombre,
        dircte01 as direccion,
        telcte01 as telefono,
        emailcte01 as correo
        FROM maecte
        WHERE cascte01 = '$cedula'
        LIMIT 1;";
        $result_buscar_cliente = mysql_query($query_buscar_cliente);
        if (mysql_num_rows($result_buscar_cliente) > 0) {
            $row       = mysql_fetch_array($result_buscar_cliente);
            $nombre    = $row['nombre'];
            $direccion = $row['direccion'];
            $telefono  = $row['telefono'];
            $correo    = $row['correo'];
            ?>
        <script type="text/javascript">
            $('#txt-cliente').val('<?php echo $nombre ?>');
            $('#txt-direccion').val('<?php echo $direccion ?>');
            $('#txt-telefono').val('<?php echo $telefono ?>');
            $('#txt-correo').val('<?php echo $correo ?>');
        </script>
        <?php
} else {
            $url = "'../../../ccprog/creacliente.php?IDB=01&ID=1088'";
            echo '<script>alert("Cliente No Existente");abrir(' . $url . ');</script>';
            echo '<script>limpiardatos();</script>';
        }

        break;

    case 'agregaritem':
        $codigo       = $_GET['codigo'];
        $cantidad     = $_GET['cantidad'];
        $documento    = $_GET['documento'];
        $codtemp      = $_GET['codtemp'];
        $cont         = 0;
        $query_select = mysql_query("SELECT * FROM stk_contrato_bonos WHERE codbar01 = '$codigo';");
        $row_insert   = mysql_fetch_array($query_select);
        $valor_item   = (($row_insert['precvta01'] * $row_insert['porciva01']) / 100) + $row_insert['precvta01'];
        if (mysql_num_rows($query_select) > 0) {
            $insert_tmp     = mysql_query("INSERT INTO mrbtmpdcvg (cod_tmp, codigo_documento, codigo_producto, cantidad, valor) VALUES ('$codtemp', '$documento', '$codigo', '$cantidad', '" . round($valor_item) . "')");
            $query_select_2 = mysql_query("SELECT
                            t.codigo_producto AS codigo,
                            s.desprod01 AS titulo,
                            t.cantidad AS cantidad,
                            t.valor AS valor,
                            s.cantact01 as stock,
                            t.ocurren as ocurrencia,
                            t.cod_tmp as codtmp
                            FROM
                            mrbtmpdcvg as t
                            INNER JOIN stk_contrato_bonos as s ON t.codigo_producto = s.codbar01
                            WHERE t.cod_tmp = '$codtemp' AND t.codigo_documento = '$documento' ORDER BY ocurren ASC");?>
            <table width="50%" border="0" id="detalle">
                <?php while ($row = mysql_fetch_array($query_select_2)) {?>
                <tr>
                    <td width="1%"><img src="../recursos/b_drop.png" onclick="eliminaritem('<?php echo $row['ocurrencia']; ?>','<?php echo $codtemp; ?>','<?php echo $row['codigo']; ?>','<?php echo $documento; ?>');"></td>
                    <td width="1%"><input type="text" size="15%" id="txt-cod" value="<?php echo $row['codigo']; ?>"></td>
                    <td width="10%"><div align="left" size="15%"><?php echo $row['titulo']; ?></div></td>
                    <td width="1%"><div align="center" size="10%"><?php echo $row['stock']; ?></div></td>
                    <td width="1%"><div align="center"><input type="text" size="3%" name="txt-cant" id="txt-cant" onchange="cambiarcantidad(this.value,'<?php echo $row['ocurrencia']; ?>','<?php echo $codtemp; ?>','<?php echo $documento; ?>')" value="<?php echo $row['cantidad'] ?>"></div></td>
                    <td width="1%"><div align="center"><?php echo round($row['valor'], 2); ?></div></td>
                    <td width="1%"><div align="center"><?php echo ($row['cantidad'] * $row['valor']); ?></div></td>
                </tr>
                <?php }?>
            </table>
        <?php
} else {
            echo '<script>alert("Codigo No Pertenece a los contratos de venta");</script>';
            $query_select_2 = mysql_query("SELECT
                            t.codigo_producto AS codigo,
                            s.desprod01 AS titulo,
                            t.cantidad AS cantidad,
                            t.valor AS valor,
                            s.cantact01 as stock,
                            t.ocurren as ocurrencia,
                            t.cod_tmp as codtmp
                            FROM
                            mrbtmpdcvg as t
                            INNER JOIN stk_contrato_bonos as s ON t.codigo_producto = s.codbar01
                            WHERE t.cod_tmp = '$codtemp' AND t.codigo_documento = '$documento'");?>
            <table width="50%" border="0" id="detalle">
                <?php while ($row = mysql_fetch_array($query_select_2)) {?>
                <tr>
                    <td width="1%"><img src="../recursos/b_drop.png" onclick="eliminaritem('<?php echo $row['ocurrencia']; ?>','<?php echo $codtemp; ?>','<?php echo $row['codigo']; ?>','<?php echo $documento; ?>');"></td>
                    <td width="1%"><input type="text" size="15%" id="txt-cod" value="<?php echo $row['codigo']; ?>"></td>
                    <td width="10%"><div align="left" size="15%"><?php echo $row['titulo']; ?></div></td>
                    <td width="1%"><div align="center" size="10%"><?php echo $row['stock']; ?></div></td>
                    <td width="1%"><div align="center"><input type="text" size="3%" name="txt-cant" id="txt-cant" onchange="cambiarcantidad(this.value,'<?php echo $row['ocurrencia']; ?>','<?php echo $codtemp; ?>','<?php echo $documento; ?>')" value="<?php echo $row['cantidad'] ?>"></div></td>
                    <td width="1%"><div align="center"><?php echo $row['valor']; ?></div></td>
                    <td width="1%"><div align="center"><?php echo ($row['cantidad'] * $row['valor']); ?></div></td>
                </tr>
                <?php }?>
            </table>
        <?php

        }

        break;

    case 'eliminaritem':
        $codtemp        = $_GET['cod_tmp'];
        $ocurrencia     = $_GET['ocurrencia'];
        $codigo         = $_GET['codigo'];
        $documento      = $_GET['documento'];
        $delete_item    = mysql_query("DELETE FROM mrbtmpdcvg WHERE (ocurren='$ocurrencia') AND (cod_tmp='$codtemp');");
        $query_select_2 = mysql_query("SELECT
                            t.codigo_producto AS codigo,
                            s.desprod01 AS titulo,
                            t.cantidad AS cantidad,
                            t.valor AS valor,
                            s.cantact01 as stock,
                            t.ocurren as ocurrencia,
                            t.cod_tmp as codtmp
                            FROM
                            mrbtmpdcvg as t
                            INNER JOIN stk_contrato_bonos as s ON t.codigo_producto = s.codbar01
                            WHERE t.cod_tmp = '$codtemp' AND t.codigo_documento = '$documento'");?>
            <table width="50%" border="0" id="detalle">
                <?php while ($row = mysql_fetch_array($query_select_2)) {?>
                <tr>
                   <td width="1%"><img src="../recursos/b_drop.png" onclick="eliminaritem('<?php echo $row['ocurrencia']; ?>','<?php echo $codtemp; ?>','<?php echo $row['codigo']; ?>','<?php echo $documento; ?>');"></td>
                    <td width="1%"><input type="text" size="15%" id="txt-cod" value="<?php echo $row['codigo']; ?>"></td>
                    <td width="10%"><div align="left" size="15%"><?php echo $row['titulo']; ?></div></td>
                    <td width="1%"><div align="center" size="10%"><?php echo $row['stock']; ?></div></td>
                    <td width="1%"><div align="center"><input type="text" size="3%" name="txt-cant" id="txt-cant" onchange="cambiarcantidad(this.value,'<?php echo $row['ocurrencia']; ?>','<?php echo $codtemp; ?>','<?php echo $documento; ?>')" value="<?php echo $row['cantidad'] ?>"></div></td>
                    <td width="1%"><div align="center"><?php echo $row['valor']; ?></div></td>
                    <td width="1%"><div align="center"><?php echo ($row['cantidad'] * $row['valor']); ?></div></td>
                </tr>
                <?php }?>
            </table>
            <?php
break;

    case 'modificaritem':
        $codtemp        = $_GET['cod_tmp'];
        $cantidad       = $_GET['cantidad'];
        $ocurrencia     = $_GET['ocurrencia'];
        $documento      = $_GET['documento'];
        $delete_item    = mysql_query("UPDATE mrbtmpdcvg SET cantidad='$cantidad' WHERE (ocurren='$ocurrencia') LIMIT 1;");
        $query_select_2 = mysql_query("SELECT
                            t.codigo_producto AS codigo,
                            s.desprod01 AS titulo,
                            t.cantidad AS cantidad,
                            t.valor AS valor,
                            s.cantact01 as stock,
                            t.ocurren as ocurrencia,
                            t.cod_tmp as codtmp
                            FROM
                            mrbtmpdcvg as t
                            INNER JOIN stk_contrato_bonos as s ON t.codigo_producto = s.codbar01
                            WHERE t.cod_tmp = '$codtemp' AND t.codigo_documento = '$documento'");?>
            <table width="50%" border="0" id="detalle">
                <?php while ($row = mysql_fetch_array($query_select_2)) {?>
                <tr>
                   <td width="1%"><img src="../recursos/b_drop.png" onclick="eliminaritem('<?php echo $row['ocurrencia']; ?>','<?php echo $codtemp; ?>','<?php echo $row['codigo']; ?>','<?php echo $documento; ?>');"></td>
                    <td width="1%"><input type="text" size="15%" id="txt-cod" value="<?php echo $row['codigo']; ?>"></td>
                    <td width="10%"><div align="left" size="15%"><?php echo $row['titulo']; ?></div></td>
                    <td width="1%"><div align="center" size="10%"><?php echo $row['stock']; ?></div></td>
                    <td width="1%"><div align="center"><input type="text" size="3%" name="txt-cant" id="txt-cant" onchange="cambiarcantidad(this.value,'<?php echo $row['ocurrencia']; ?>','<?php echo $codtemp; ?>','<?php echo $documento; ?>')" value="<?php echo $row['cantidad'] ?>"></div></td>
                    <td width="1%"><div align="center"><?php echo $row['valor']; ?></div></td>
                    <td width="1%"><div align="center"><?php echo ($row['cantidad'] * $row['valor']); ?></div></td>
                </tr>
                <?php }?>
            </table>
            <?php
break;

}
