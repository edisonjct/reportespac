<?php
include 'conexion.php';

$IDB = $_GET['IDB'];
$ID = $_GET['ID'];
$UID = $_GET['UID'];
$proceso = $_GET['proceso'];

switch ($proceso) {
    case 'secuencual':
        $establecimiento = "SELECT ad7tab as establecimiento FROM maetab WHERE numtab = '01' AND codtab = '26' LIMIT 1; ";
        $result_establecimiento = mysql_query($establecimiento);
        $row_establecimiento = mysql_fetch_array($result_establecimiento);
        $secuencual = "SELECT ad1tab as ultimo FROM maetab WHERE numtab = '41' AND codtab = '85.1' LIMIT 1;";
        $result_secuencial = mysql_query($secuencual);
        $row_secuencial = mysql_fetch_array($result_secuencial);
        $ultimo = number_format($row_secuencial['ultimo'], 0, '', '');
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

        $secuencual = "SELECT ad1tab as ultimo FROM maetab WHERE numtab = '41' AND codtab = '85.1' LIMIT 1;";
        $result_secuencial = mysql_query($secuencual);
        $row_secuencial = mysql_fetch_array($result_secuencial);
        $ultimo = number_format($row_secuencial['ultimo'], 0, '', '');
        $utimosec = $ultimo + 1;
        //echo "desde del swith";
        break;

    case 'addformadepago':
        $documento = $_GET['documento'];
        $codtemp = $_GET['codtemp'];
        $total_valor = "SELECT sum(valor*cantidad) as total FROM mrbtmpdcvg WHERE cod_tmp = '$codtemp' AND codigo_documento = '$documento';";
        $row = mysql_fetch_array(mysql_query($total_valor));
        $total = $row['total'];
        $total_fp = "SELECT sum(total) as total FROM mrbtmpfpcvg WHERE cod_tmp = '$codtemp' AND numero_documento = '$documento';";
        $row_fp = mysql_fetch_array(mysql_query($total_fp));
        $to_fp = $row_fp['total'];
        $subtotal = $total - $to_fp;
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
            <?php while ($row2 = mysql_fetch_array($result_addfp)) { ?>
                <tr>
                    <td><img src="../recursos/b_drop.png" onClick="eliminarfp('<?php echo $codtemp; ?>', '<?php echo $row2['codfp']; ?>'), addformadepago();"></td>
                    <td><input type="text" size="31%" id="txt-formadepago" value="<?php echo $row2['fp']; ?>"></td>
                    <td><input type="text" size="15%" id="txt-emisor"></td>
                    <td><input type="text" size="15%" id="txt-fechactual" value="<?php echo date("Y/m/d"); ?>"></td>
                    <td><input type="text" disabled="true" size="5%" id="txt-subtotal" value="<?php echo round($row2['valor'], 2); ?>"></td>
                </tr>
            <?php } ?>
        </table>
        <table width="40%" border="0" id="detalle">
            <tr>
                <td><img src="../recursos/b_drop.png" onClick="eliminarfp2();"></td>
                <td>
                    <select id="tipoformadepago">
                        <?php $query = mysql_query("SELECT codtab,nomtab FROM mrbooks.maetab WHERE numtab = '78' AND ad5tab = '0' AND codtab != '';"); ?>
                        <?php if (mysql_num_rows($query) > 0) { ?>
                            <?php while ($row = mysql_fetch_array($query)) { ?>
                                <option value="<?php echo $row['codtab'] ?>"><?php echo $row['nomtab']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>
                <td><input type="text" size="15%" id="txt-emisor"></td>
                <td><input type="text" size="15%" id="txt-fechactual" value="<?php echo date("Y/m/d"); ?>"></td>
                <td><input type="text" size="5%" id="txt-total" onChange="validamayor(this.value);" value="<?php echo round($subtotal, 2); ?>"></td>
            </tr>
        </table>

        <?php
        break;

    case 'addformadepago2':
        $documento = $_GET['documento'];
        $codtemp = $_GET['codtemp'];
        $fp = $_GET['fp'];
        $valor = $_GET['valor'];
        $total_valor = "SELECT sum(valor*cantidad) as total FROM mrbtmpdcvg WHERE cod_tmp = '$codtemp' AND codigo_documento = '$documento';";
        $row = mysql_fetch_array(mysql_query($total_valor));
        $total = $row['total'];
        $insertfp = "INSERT INTO mrbtmpfpcvg (cod_tmp, numero_documento, fecha, codigo_forma_pago, observacion, total) VALUES ('$codtemp', '$documento', NOW(), '$fp', '' ,  '$valor');";
        $result_insert = mysql_query($insertfp);
        $total_fp = "SELECT sum(total) as total FROM mrbtmpfpcvg WHERE cod_tmp = '$codtemp' AND numero_documento = '$documento';";
        $row_fp = mysql_fetch_array(mysql_query($total_fp));
        $to_fp = $row_fp['total'];
        $subtotal = $total - $to_fp;
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
            <?php while ($row2 = mysql_fetch_array($result_addfp)) { ?>
                <tr>
                    <td><img src="../recursos/b_drop.png" onClick="eliminarfp('<?php echo $codtemp; ?>', '<?php echo $row2['codfp']; ?>'), addformadepago();"></td>
                    <td><input type="text" size="31%" id="txt-formadepago" value="<?php echo $row2['fp']; ?>"></td>
                    <td><input type="text" size="15%" id="txt-emisor"></td>
                    <td><input type="text" size="15%" id="txt-fechactual" value="<?php echo date("Y/m/d"); ?>"></td>
                    <td><input type="text" disabled="true" size="5%" id="txt-subtotal" value="<?php echo round($row2['valor'], 2); ?>"></td>
                </tr>
            <?php } ?>
        </table>
        <table width="40%" border="0" id="detalle">
            <tr>
                <td><img src="../recursos/b_drop.png" onClick="eliminarfp2();"></td>
                <td>
                    <select id="tipoformadepago">
                        <?php $query = mysql_query("SELECT codtab,nomtab FROM mrbooks.maetab WHERE numtab = '78' AND ad5tab = '0' AND codtab != '';"); ?>
                        <?php if (mysql_num_rows($query) > 0) { ?>
                            <?php while ($row = mysql_fetch_array($query)) { ?>
                                <option value="<?php echo $row['codtab'] ?>"><?php echo $row['nomtab']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>
                <td><input type="text" size="15%" id="txt-emisor"></td>
                <td><input type="text" size="15%" id="txt-fechactual" value="<?php echo date("Y/m/d"); ?>"></td>
                <td><input type="text" size="5%" id="txt-total" onChange="validamayor(this.value);" value="<?php echo round($subtotal, 2); ?>"></td>
            </tr>
        </table>

        <?php
        break;

    case 'buscar_cliente':
        $cedula = $_GET['cedula'];
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
            $row = mysql_fetch_array($result_buscar_cliente);
            $nombre = $row['nombre'];
            $direccion = $row['direccion'];
            $telefono = $row['telefono'];
            $correo = $row['correo'];
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
        $codigo = $_GET['codigo'];
        $cantidad = $_GET['cantidad'];
        $documento = $_GET['documento'];
        $codtemp = $_GET['codtemp'];
        $cont = 0;
        $query_select = mysql_query("SELECT * FROM stk_contrato_bonos WHERE codbar01 = '$codigo' AND cantact01 > '0' ;");
        $row_insert = mysql_fetch_array($query_select);
        $valor_item = (($row_insert['precvta01'] * $row_insert['porciva01']) / 100) + $row_insert['precvta01'];
        if (mysql_num_rows($query_select) > 0) {
            $insert_tmp = mysql_query("INSERT INTO mrbtmpdcvg (cod_tmp, codigo_documento, codigo_producto, cantidad, valor) VALUES ('$codtemp', '$documento', '$codigo', '$cantidad', '" . round($valor_item) . "')");
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
                            WHERE t.cod_tmp = '$codtemp' AND t.codigo_documento = '$documento' ORDER BY ocurren ASC");
            ?>
            <table width="50%" border="0" id="detalle">
                <?php while ($row = mysql_fetch_array($query_select_2)) { ?>
                    <tr>
                        <td width="1%"><img src="../recursos/b_drop.png" onClick="eliminaritem('<?php echo $row['ocurrencia']; ?>', '<?php echo $codtemp; ?>', '<?php echo $row['codigo']; ?>', '<?php echo $documento; ?>');"></td>
                        <td width="1%"><input type="text" size="15%" id="txt-cod" value="<?php echo $row['codigo']; ?>"></td>
                        <td width="10%"><div align="left" size="15%"><?php echo $row['titulo']; ?></div></td>
                        <td width="1%"><div align="center" size="10%"><?php echo $row['stock']; ?></div></td>
                        <td width="1%"><div align="center"><input type="text" size="3%" name="txt-cant" id="txt-cant" onChange="cambiarcantidad(this.value, '<?php echo $row['ocurrencia']; ?>', '<?php echo $codtemp; ?>', '<?php echo $documento; ?>')" value="<?php echo $row['cantidad'] ?>"></div></td>
                        <td width="1%"><div align="center"><?php echo round($row['valor'], 2); ?></div></td>
                        <td width="1%"><div align="center"><?php echo ($row['cantidad'] * $row['valor']); ?></div></td>
                    </tr>
                <?php } ?>
            </table>
            <?php
        } else {
            echo '<script>alert("Codigo No Pertenece a los contratos de venta o no tiene Stock");</script>';
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
                            WHERE t.cod_tmp = '$codtemp' AND t.codigo_documento = '$documento'");
            ?>
            <table width="50%" border="0" id="detalle">
                <?php while ($row = mysql_fetch_array($query_select_2)) { ?>
                    <tr>
                        <td width="1%"><img src="../recursos/b_drop.png" onClick="eliminaritem('<?php echo $row['ocurrencia']; ?>', '<?php echo $codtemp; ?>', '<?php echo $row['codigo']; ?>', '<?php echo $documento; ?>');"></td>
                        <td width="1%"><input type="text" size="15%" id="txt-cod" value="<?php echo $row['codigo']; ?>"></td>
                        <td width="10%"><div align="left" size="15%"><?php echo $row['titulo']; ?></div></td>
                        <td width="1%"><div align="center" size="10%"><?php echo $row['stock']; ?></div></td>
                        <td width="1%"><div align="center"><input type="text" size="3%" name="txt-cant" id="txt-cant" onChange="cambiarcantidad(this.value, '<?php echo $row['ocurrencia']; ?>', '<?php echo $codtemp; ?>', '<?php echo $documento; ?>')" value="<?php echo $row['cantidad'] ?>"></div></td>
                        <td width="1%"><div align="center"><?php echo $row['valor']; ?></div></td>
                        <td width="1%"><div align="center"><?php echo ($row['cantidad'] * $row['valor']); ?></div></td>
                    </tr>
                <?php } ?>
            </table>
            <?php
        }

        break;

    case 'eliminaritem':
        $codtemp = $_GET['cod_tmp'];
        $ocurrencia = $_GET['ocurrencia'];
        $codigo = $_GET['codigo'];
        $documento = $_GET['documento'];
        $delete_item = mysql_query("DELETE FROM mrbtmpdcvg WHERE (ocurren='$ocurrencia') AND (cod_tmp='$codtemp');");
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
                            WHERE t.cod_tmp = '$codtemp' AND t.codigo_documento = '$documento'");
        ?>
        <table width="50%" border="0" id="detalle">
            <?php while ($row = mysql_fetch_array($query_select_2)) { ?>
                <tr>
                    <td width="1%"><img src="../recursos/b_drop.png" onClick="eliminaritem('<?php echo $row['ocurrencia']; ?>', '<?php echo $codtemp; ?>', '<?php echo $row['codigo']; ?>', '<?php echo $documento; ?>');"></td>
                    <td width="1%"><input type="text" size="15%" id="txt-cod" value="<?php echo $row['codigo']; ?>"></td>
                    <td width="10%"><div align="left" size="15%"><?php echo $row['titulo']; ?></div></td>
                    <td width="1%"><div align="center" size="10%"><?php echo $row['stock']; ?></div></td>
                    <td width="1%"><div align="center"><input type="text" size="3%" name="txt-cant" id="txt-cant" onChange="cambiarcantidad(this.value, '<?php echo $row['ocurrencia']; ?>', '<?php echo $codtemp; ?>', '<?php echo $documento; ?>')" value="<?php echo $row['cantidad'] ?>"></div></td>
                    <td width="1%"><div align="center"><?php echo $row['valor']; ?></div></td>
                    <td width="1%"><div align="center"><?php echo ($row['cantidad'] * $row['valor']); ?></div></td>
                </tr>
            <?php } ?>
        </table>
        <?php
        break;

    case 'modificaritem':
        $codtemp = $_GET['cod_tmp'];
        $cantidad = $_GET['cantidad'];
        $ocurrencia = $_GET['ocurrencia'];
        $documento = $_GET['documento'];
        $delete_item = mysql_query("UPDATE mrbtmpdcvg SET cantidad='$cantidad' WHERE (ocurren='$ocurrencia') LIMIT 1;");
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
                            WHERE t.cod_tmp = '$codtemp' AND t.codigo_documento = '$documento'");
        ?>
        <table width="50%" border="0" id="detalle">
            <?php while ($row = mysql_fetch_array($query_select_2)) { ?>
                <tr>
                    <td width="1%"><img src="../recursos/b_drop.png" onClick="eliminaritem('<?php echo $row['ocurrencia']; ?>', '<?php echo $codtemp; ?>', '<?php echo $row['codigo']; ?>', '<?php echo $documento; ?>');"></td>
                    <td width="1%"><input type="text" size="15%" id="txt-cod" value="<?php echo $row['codigo']; ?>"></td>
                    <td width="10%"><div align="left" size="15%"><?php echo $row['titulo']; ?></div></td>
                    <td width="1%"><div align="center" size="10%"><?php echo $row['stock']; ?></div></td>
                    <td width="1%"><div align="center"><input type="text" size="3%" name="txt-cant" id="txt-cant" onChange="cambiarcantidad(this.value, '<?php echo $row['ocurrencia']; ?>', '<?php echo $codtemp; ?>', '<?php echo $documento; ?>')" value="<?php echo $row['cantidad'] ?>"></div></td>
                    <td width="1%"><div align="center"><?php echo $row['valor']; ?></div></td>
                    <td width="1%"><div align="center"><?php echo ($row['cantidad'] * $row['valor']); ?></div></td>
                </tr>
            <?php } ?>
        </table>
        <?php
        break;

    case 'eliminafp':
        $codtemp = $_GET['codtemp'];
        $fp = $_GET['fp'];
        $documento = $_GET['documento'];
        $sql = "DELETE FROM mrbtmpfpcvg WHERE (cod_tmp='$codtemp') AND (codigo_forma_pago='$fp');";
        $result = mysql_query($sql);
        $total_valor = "SELECT sum(valor*cantidad) as total FROM mrbtmpdcvg WHERE cod_tmp = '$codtemp' AND codigo_documento = '$documento';";
        $row = mysql_fetch_array(mysql_query($total_valor));
        $total = $row['total'];
        $total_fp = "SELECT sum(total) as total FROM mrbtmpfpcvg WHERE cod_tmp = '$codtemp' AND numero_documento = '$documento';";
        $row_fp = mysql_fetch_array(mysql_query($total_fp));
        $to_fp = $row_fp['total'];
        $subtotal = $total - $to_fp;
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
            <?php while ($row2 = mysql_fetch_array($result_addfp)) { ?>
                <tr>
                    <td><img src="../recursos/b_drop.png" onClick="eliminarfp('<?php echo $codtemp; ?>', '<?php echo $row2['codfp']; ?>'), addformadepago();"></td>
                    <td><input type="text" size="31%" id="txt-formadepago" value="<?php echo $row2['fp']; ?>"></td>
                    <td><input type="text" size="15%" id="txt-emisor"></td>
                    <td><input type="text" size="15%" id="txt-fechactual" value="<?php echo date("Y/m/d"); ?>"></td>
                    <td><input type="text" disabled="true" size="5%" id="txt-subtotal" value="<?php echo round($row2['valor'], 2); ?>"></td>
                </tr>
            <?php } ?>
        </table>
        <table width="40%" border="0" id="detalle">
            <tr>
                <td><img src="../recursos/b_drop.png" onClick="eliminarfp2();"></td>
                <td>
                    <select id="tipoformadepago">
                        <?php $query = mysql_query("SELECT codtab,nomtab FROM mrbooks.maetab WHERE numtab = '78' AND ad5tab = '0' AND codtab != '';"); ?>
                        <?php if (mysql_num_rows($query) > 0) { ?>
                            <?php while ($row = mysql_fetch_array($query)) { ?>
                                <option value="<?php echo $row['codtab'] ?>"><?php echo $row['nomtab']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>
                <td><input type="text" size="15%" id="txt-emisor"></td>
                <td><input type="text" size="15%" id="txt-fechactual" value="<?php echo date("Y/m/d"); ?>"></td>
                <td><input type="text" size="5%" id="txt-total" onChange="validamayor(this.value);" value="<?php echo round($subtotal, 2); ?>"></td>
            </tr>
        </table>

        <?php
        break;
    case 'generarfactura':
        $documento = $_GET['documento'];
        $codtemp = $_GET['codtemp'];
        $fp = $_GET['fp'];
        $valor = $_GET['valor'];
        $cedula = $_GET['cedula'];
        $cedulacontacto = $_GET['cedulacontacto'];
        $nombrecontacto = $_GET['nombrecontacto'];
        $telefonocontacto = $_GET['telefonocontacto'];
        $correocontacto = $_GET['correocontacto'];
        $vendedor = $_GET['vendedor'];
        $insertfp = "INSERT INTO mrbtmpfpcvg (cod_tmp, numero_documento, fecha, codigo_forma_pago, observacion, total) VALUES ('$codtemp', '$documento', NOW(), '$fp', '' ,  '$valor');";
        $result_insert = mysql_query($insertfp);
        $establecimiento = "SELECT ad7tab as establecimiento FROM maetab WHERE numtab = '01' AND codtab = '26' LIMIT 1; ";
        $result_establecimiento = mysql_query($establecimiento);
        $row_establecimiento = mysql_fetch_array($result_establecimiento);
        $secuencual = "SELECT ad1tab as ultimo FROM maetab WHERE numtab = '41' AND codtab = '85.1' LIMIT 1;";
        $result_secuencial = mysql_query($secuencual);
        $row_secuencial = mysql_fetch_array($result_secuencial);
        $ultimo = number_format($row_secuencial['ultimo'], 0, '', '') + 1;
        mysql_query("UPDATE maetab SET ad1tab='$ultimo' WHERE (numtab='41') AND (codtab='85.1') LIMIT 1;");
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
        $numero_ultimo_documento = $row_establecimiento['establecimiento'] . $ultimosecuencial;
        //DETALLE
        $sqldetalle = "INSERT INTO mrbdcvg
        SELECT '$numero_ultimo_documento',codigo_producto,cantidad,valor,NOW(),'1' FROM mrbtmpdcvg WHERE cod_tmp = '$codtemp';";
        mysql_query($sqldetalle);
        //FORMAS DE PAGO
        $sqlformas = "INSERT INTO mrbfpcvg
        SELECT '$numero_ultimo_documento',fecha,codigo_forma_pago,observacion,total FROM mrbtmpfpcvg WHERE cod_tmp = '$codtemp';";
        mysql_query($sqlformas);
        // CABECERA
        $row = mysql_fetch_array(mysql_query("SELECT sum(cantidad*precio) as total FROM mrbdcvg WHERE codigo_documento = '$numero_ultimo_documento';"));
        $totalfactura = $row['total'];
        $sqlcabecera = "INSERT INTO mrbcvg (codigo_documento, codigo_cliente, fecha_emision ,total_factura, id_vendedor, usuario, estado, contacto_cedula, contacto_nombre, contacto_telefono, contacto_correo) VALUES ('$numero_ultimo_documento', '$cedula',NOW() ,'$totalfactura', '$vendedor', '$UID', '1', '$cedulacontacto', '$nombrecontacto', '$telefonocontacto', '$correocontacto')";
        mysql_query($sqlcabecera);
        ?>

        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="UTF-8">
                <title>Factura</title>
                <style>
                    table{
                        border-spacing: 0px;
                        border-collapse: collapse;
                        font-size: 10px;
                    }

                    #contortable {
                        border-spacing: 0px;
                        border-collapse: collapse;
                    }
                    #contortablei{
                        border: solid #000 1px;
                    }

                    .container {
                        background-color: #fafafa;
                        margin: 1rem;
                        padding: 0.5rem;
                        border: 2px solid #ccc;
                        /* IMPORTANTE */

                    }

                    #nombrecb{
                        text-align: left;
                        font-weight: bold;
                    }

                    #contorno {
                        border: solid #000 0.1px;
                        letter-spacing: 3px;
                        padding: 1px;
                    }
                    span {
                        padding: 4px;

                    }
                </style>
            </head>

            <body>
                <?php
                $secuencual = explode("-", $numero_ultimo_documento);
                $string1 = $secuencual[0];
                $string2 = $secuencual[1];
                $string3 = $secuencual[2];
                $estab = str_split($string1, 1);
                $pemi = str_split($string2, 1);
                $secu = str_split($string3, 1);
                $querycabecera = "SELECT
                c.codigo_documento AS documento,
                DATE_FORMAT(c.fecha_emision,'%m-%d-%Y') AS fecha,
                c.codigo_cliente AS ruc,
                cl.nomcte01 AS cliente,
                cl.razcte01 AS razon,
                cl.dircte01 AS direcion,
                cl.telcte01 AS telefono,
                cl.emailcte01 AS correo,
                c.contacto_cedula AS ccedula,
                c.contacto_nombre AS cnombre,
                c.contacto_telefono AS ctelefono,
                c.contacto_correo AS ccorreo,
                t.nomtab AS vendedor,
                t.ad7tab AS cedulavendedor,
                cu.nomtab as ciudad
                FROM
                mrbcvg AS c
                INNER JOIN mrbooks.maecte AS cl ON c.codigo_cliente = cl.cascte01
                LEFT JOIN mrbooks.maetab AS t ON c.id_vendedor = t.codtab
                INNER JOIN mrbooks.maetab AS cu ON cl.loccte01 = cu.codtab
                WHERE
                c.codigo_documento = '$numero_ultimo_documento' AND t.numtab = '73' AND cu.numtab = '74' LIMIT 1";
                $row = mysql_fetch_array(mysql_query($querycabecera));
                $fecha = explode("-", $row['fecha']);
                $fechadia = $fecha[0];
                $fechames = $fecha[1];
                $fechaanio = $fecha[2];
                $dia = str_split($fechadia, 1);
                $mes = str_split($fechames, 1);
                $anio = str_split($fechaanio, 1);
                $cedulavendedor = str_split($row['cedulavendedor'], 1);
                $ruccliente = str_split($row['ruc'], 1);
                $telefonocli = str_split($row['telefono'], 1);
                $ccedula = str_split($row['ccedula'], 1);
                $ctelefono = str_split($row['ctelefono'], 1);
                ?>
                <div class="container">                   
                    <table border="0" width="">
                        <tr>
                            <td colspan="7" align="center"><b>CONTRATO DE VENT DE TARJETAS DE REGALO</b></td>
                        </tr>
                        <tr>
                            <td id="nombrecb" width="233">NO:</td>
                            <td width="29">
                                <table id="contortable">
                                    <tr>
                                        <?php foreach ($estab as $rowestab) { ?>
                                            <td width="28" id="contortablei"><span><?php echo $rowestab[0]; ?></span></td>                                                                          
                                        <?php } ?>
                                    </tr>
                                </table>
                            </td>
                            <td width="7">-</td>
                            <td width="29">
                                <table id="contortable">
                                    <tr>
                                        <?php foreach ($pemi as $rowpemi) { ?>
                                            <td id="contortablei"><span><?php echo $rowpemi[0]; ?></span></td>                                                                          
                                        <?php } ?>
                                    </tr>
                                </table>
                            </td>
                            <td width="13">-</td>
                            <td width="557">
                                <table id="contortable">
                                    <tr>
                                        <?php foreach ($secu as $rowsecu) { ?>
                                            <td id="contortablei"><span><?php echo $rowsecu[0]; ?></span></td>                                                                          
                                        <?php } ?>
                                    </tr>
                                </table>
                            </td>
                            <td width="192" rowspan="2" align="center"><img src="../recursos/logoMrBooks.png" width="120" height="40"></td>
                        </tr>
                        <tr>
                            <td id="nombrecb" width="233">RAZON SOCIAL:</td>
                            <td colspan="5" align="center"><b>MISTERBOOKS S.A.</b></td>
                        </tr>
                        <tr>
                            <td id="nombrecb" width="233">RUC:</td>
                            <td colspan="5" align="left">
                                <table id="contortable">
                                    <tr>
                                        <td id="contortablei"><span>1</span></td>
                                        <td id="contortablei"><span>7</span></td>
                                        <td id="contortablei"><span>9</span></td>
                                        <td id="contortablei"><span>1</span></td>
                                        <td id="contortablei"><span>3</span></td>
                                        <td id="contortablei"><span>9</span></td>
                                        <td id="contortablei"><span>7</span></td>
                                        <td id="contortablei"><span>3</span></td>
                                        <td id="contortablei"><span>3</span></td>
                                        <td id="contortablei"><span>9</span></td>
                                        <td id="contortablei"><span>0</span></td>
                                        <td id="contortablei"><span>0</span></td>
                                        <td id="contortablei"><span>1</span></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td id="nombrecb" width="233">FECHA:</td>
                            <td>
                                <table id="contortable">
                                    <tr>
                                        <?php foreach ($dia as $rowdia) { ?>
                                            <td id="contortablei"><span><?php echo $rowdia[0]; ?></span></td>                                                                          
                                        <?php } ?>
                                    </tr>
                                </table>
                            </td>
                            <td>/</td>
                            <td>
                                <table id="contortable">
                                    <tr>
                                        <?php foreach ($mes as $rowmes) { ?>
                                            <td id="contortablei"><span><?php echo $rowmes[0]; ?></span></td>                                                                          
                                        <?php } ?>
                                    </tr>
                                </table>
                            </td>
                            <td>/</td>
                            <td>
                                <table id="contortable">
                                    <tr>
                                        <?php foreach ($anio as $rowanio) { ?>
                                            <td id="contortablei"><span><?php echo $rowanio[0]; ?></span></td>                                                                          
                                        <?php } ?>
                                    </tr>
                                </table>
                            </td>
                            <td width="192" rowspan="2" align="center"><img src="../recursos/librimundi.png" width="120" height="40"></td>
                        </tr>
                        <tr>
                            <td id="nombrecb" width="233">LIBRERIA:</td>
                            <td colspan="5" id="contorno"><?php echo $nomcc; ?></td>
                        </tr>
                    </table>
                </div>
                <div class="container">
                    <table border="0" width="">
                        <tr>
                            <td colspan="2" align="center"><b>VENDEDOR</b></td>
                        </tr>
                        <tr>
                            <td id="nombrecb" width="200">CEDULA:</td>
                            <td width="880">
                                <table id="contortable">
                                    <tr>
                                        <?php
                                        if ((strlen($row['cedulavendedor']) > 0)) {
                                            foreach ($cedulavendedor as $rowcedulavendedor) {
                                                ?>
                                                <td id="contortablei"><span><?php echo $rowcedulavendedor[0]; ?></span></td>                                                                          
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <td></td>
                                        <?php } ?>
                                    </tr>
                                </table>
                            </td>                            
                        </tr>
                        <tr>
                            <td id="nombrecb" width="200">NOMBRE:</td>
                            <td width="880" id="contorno" align="left"><b><?php echo $row['vendedor']; ?></b></td>
                        </tr>                        
                    </table>
                </div>
                <div class="container">
                    <table border="0" width="">
                        <tr>
                            <td colspan="4" align="center"><b>CLIENTE</b></td>
                        </tr>
                        <tr>
                            <td id="nombrecb" width="202">RAZON SOCIAL:</td>
                            <td align="left" id="contorno" colspan="3"><b><?php echo $row['razon']; ?></b></td>
                        </tr>
                        <tr>
                            <td id="nombrecb" width="202">RUC:</td>
                            <td width="438">
                                <table id="contortable">
                                    <tr>
                                        <?php foreach ($ruccliente as $rowruccliente) { ?>
                                            <td id="contortablei"><span><?php echo $rowruccliente[0]; ?></span></td>                                                                          
                                        <?php } ?>
                                    </tr>
                                </table>
                            </td>
                            <td id="nombrecb" width="113">CIUDAD:</td>
                            <td width="319" id="contorno"><b><?php echo $row['ciudad']; ?></b></td>
                        </tr>
                        <tr>   
                            <td id="nombrecb" width="202">DIRECCIÓN:</td>
                            <td align="left" id="contorno" colspan="3"><b><?php echo $row['direcion']; ?></b></td>
                        </tr>  
                        <tr>
                            <td id="nombrecb" width="202">TELEFONO:</td>
                            <td width="438">
                                <table id="contortable">
                                    <tr>
                                        <?php foreach ($telefonocli as $rowtelefonocli) { ?>
                                            <td id="contortablei"><span><?php echo $rowtelefonocli[0]; ?></span></td>                                                                          
                                        <?php } ?>
                                    </tr>
                                </table>
                            </td>
                        </tr>    
                        <tr>   
                            <td id="nombrecb" width="202">CORREO:</td>
                            <td align="left" colspan="3" id="contorno"><b><?php echo $row['correo']; ?></b></td>
                        </tr>                                      
                    </table>
                </div>
                <?php if (strlen($cedula) >= 13) { ?>
                    <div class="container">
                        <table border="0" width="">
                            <tr>
                                <td colspan="2" align="center"><b>CONTACTO</b></td>
                            </tr>
                            <tr>
                                <td id="nombrecb" width="236">CEDULA:</td>
                                <td align="left" colspan="3">
                                    <table id="contortable">
                                        <tr>
                                            <?php
                                            if (strlen($row['ccedula']) > 0) {
                                                foreach ($ccedula as $rowccedula) {
                                                    ?>
                                                    <td id="contortablei"><span><?php echo $rowccedula[0]; ?></span></td>                                                                          
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <td></td>
                                            <?php } ?>    
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td id="nombrecb" width="236">NOMBRE:</td>
                                <?php if (strlen($row['cnombre']) > 0) { ?>
                                    <td id="contorno" width="861"><b><?php echo $row['cnombre']; ?></b></td>
                                <?php } else { ?>
                                    <td width="861"></td>
                                <?php } ?>
                            </tr>
                            <tr>   
                                <td id="nombrecb" width="236">TELEFONO:</td>
                                <td align="left">
                                    <table id="contortable">
                                        <tr>
                                            <?php
                                            if (strlen($row['ctelefono']) > 0) {
                                                foreach ($ctelefono as $rowctelefono) {
                                                    ?>
                                                    <td id="contortablei"><span><?php echo $rowctelefono[0]; ?></span></td>                                                                          
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <td></td>
                                            <?php } ?>    
                                        </tr>
                                    </table>
                                </td>
                            </tr>  
                            <tr>
                                <td id="nombrecb" width="236">CORREO:</td>
                                <?php if (strlen($row['ccorreo']) > 0) { ?>
                                    <td width="861" id="contorno"><b><?php echo $row['ccorreo']; ?></b></td>
                                <?php } else { ?>
                                    <td width="861"></td>
                                <?php } ?>
                            </tr>                                                              
                        </table>
                    </div>
                <?php } ?>
                <div class="container">
                    <?php
                    $cont = 0;
                    $total = 0;
                    $querydetalle = "SELECT
                    d.codigo_producto as codigo,
                    d.cantidad as cantidad,
                    d.precio as pvp,
                    (d.cantidad * d.precio) as subtotal,
                    m.desprod01 as denominacion
                    FROM
                    mrbdcvg as d
                    INNER JOIN maepro as m ON d.codigo_producto = m.codbar01
                    WHERE d.codigo_documento = '$numero_ultimo_documento'";
                    $resultdetalle = mysql_query($querydetalle);
                    ?>
                    <table border="0" width="">
                        <tr>
                            <td colspan="5" id="contorno" align="center"><b>PRODUCTOS</b></td>
                        </tr>
                        <tr>
                            <th id="contorno" width="48" align="center">No.</th>
                            <th id="contorno" width="438" align="center">DENOMINACION</th>
                            <th id="contorno" width="168" align="center">CANTIDAD</th>
                            <th id="contorno" width="268" align="center">VALOR UNITARIO</th>
                            <th id="contorno" width="146" align="center">SUBTOTAL</th>                            
                        </tr>
                        <?php
                        while ($rowdetalle = mysql_fetch_array($resultdetalle)) {
                            $cont = $cont + 1;
                            $total = $total + $rowdetalle['subtotal'];
                            ?>
                            <tr>
                                <td id="contorno" width="48" align="center"><?php echo $cont; ?></td>
                                <td id="contorno" width="48" align="center"><?php echo $rowdetalle['denominacion']; ?></td>
                                <td id="contorno" width="48" align="center"><?php echo $rowdetalle['cantidad']; ?></td>
                                <td id="contorno" width="48" align="center"><?php echo number_format($rowdetalle['pvp'], 0); ?></td>
                                <td id="contorno" width="48" align="center"><?php echo number_format($rowdetalle['subtotal'], 0); ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="2"></th>
                            <th id="contorno" colspan="2">TOTAL PEDIDO:</th>
                            <th id="contorno"><?php echo number_format($total, 0); ?></th>
                        </tr>                        
                    </table>
                </div>
                <div class="container">
                    <?php
                    $queryformas = "SELECT
                    f.numero_documento as documento,
                    f.codigo_forma_pago as codfp,
                    f.fecha as fecha,
                    f.observacion as lote,
                    f.total as valor,
                    t.nomtab as forma
                    FROM
                    mrbfpcvg AS f
                    INNER JOIN maetab as t ON f.codigo_forma_pago = t.codtab
                    WHERE f.numero_documento = '$numero_ultimo_documento' AND t.numtab = '78'";
                    $resultformas = mysql_query($queryformas);
                    ?>
                    <table border="0" width="">
                        <tr>
                            <td id="contorno" colspan="4" align="center"><b>FORMAS DE PAGO</b></td>
                        </tr>
                        <tr>
                            <th id="contorno" width="198" align="center">FORMA DE PAGO</th>
                            <th id="contorno" width="395" align="center">LOTE</th>
                            <th id="contorno" width="173" align="center">FECHA</th>
                            <th id="contorno" width="156" align="center">VALOR</th>                            
                        </tr>
                        <?php while ($rowforma = mysql_fetch_array($resultformas)) { ?>
                            <tr>
                                <th id="contorno" width="198" align="center"><?php echo $rowforma['forma']; ?></th>
                                <th id="contorno" width="395" align="center"><?php echo $rowforma['lote']; ?></th>
                                <th id="contorno" width="173" align="center"><?php echo $rowforma['fecha']; ?></th>
                                <th id="contorno" width="156" align="center"><?php echo number_format($rowforma['valor'], 0); ?></th>                            
                            </tr>
                        <?php } ?>

                    </table>
                </div>
                <div class="container">
                    <table border="0" width="">
                        <tr>
                            <td colspan="2" align="center"><b>REGLAMENTO DE COMPROBANTES DE VENTA, RETENCION Y COMPLEMENTARIOS</b></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">Art. 4.- Otros documentos autorizados.- Son documentos autorizados, siempre que se identifique, por una parte, al emisor con su razón social o denominación, completa o abreviada, o con sus nombres y apellidos y número de RUC; por otra, al adquiriente o al sujeto con su número de RUC o cédula de identidad o pasaporte, razón social, denominación; y, además, se haga constar la fecha de emisión y por separado el valor de los tributos que correspondan.</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">En el pago de este contrato de venta de gifts cards no se debe realizar retenciones ya que no representa una factura.</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">Esta tarjeta constituye un documento al portador y un valor preestablecido, usted podrá utilizarlos en cualquiera de las librerias Mr</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">Mr. Books S. A. no asume ninguna responsabilidad en caso de pérdida o mutilaciónes que invaliden al producto adquirido.</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">El consumo de este bono se debe realizar por el valor total</td>
                        </tr>
                        <tr><td><br><br><br><br></td></tr>                        
                        <tr>
                            <th align="center">________________________________</th>
                            <th align="center">________________________________</th>
                        </tr>
                        <tr>
                            <td align="center">RECIBÍ CONFORME</td>
                            <td align="center">ENTREGÉ CONFORME</td>
                        </tr>
                    </table>
                </div>
            </body>

        </html>

        <?php
        break;


    case 'cargarcontratos':
        $IDB = $_GET['IDB'];
        $desde = $_GET['desde'];
        $hasta = $_GET['hasta'];
        $query = "SELECT
        c.codigo_documento AS documento,
        c.fecha_emision AS fecha_e,
        mrbooks.maecte.nomcte01 AS cliente,
        c.total_factura AS valor,
        sum(d.cantidad) as cantidad
        FROM
        mrbcvg AS c
        INNER JOIN mrbooks.maecte ON c.codigo_cliente = mrbooks.maecte.cascte01
        INNER JOIN mrbdcvg AS d ON d.codigo_documento = c.codigo_documento
        WHERE c.estado = '1' AND ISNULL(cierre) AND fecha_emision BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59'
        GROUP BY d.codigo_documento
        ORDER BY fecha_emision ASC";
        $resultado = mysql_query($query);
        ?>
        <table class="table table-striped table-condensed table-hover">
            <tr>
                <th>DOCUMENTO</th>
                <th>FECHA</th>
                <th>CLIENTE</th>
                <th>CANTIDAD</th>
                <th>VALOR</th>
                <th>AJUSTE</th>
                <th></th>
            </tr>
            <?php
            if (mysql_num_rows($resultado) > 0) {
                while ($row = mysql_fetch_array($resultado)) {
                    ?>
                    <tr>
                        <td><div align="center"><?php echo $row['documento']; ?></div></td>
                        <td><div align="center"><?php echo $row['fecha_e']; ?></div></td>
                        <td><div align="center"><?php echo $row['cliente']; ?></div></td>
                        <td><div align="center"><?php echo $row['cantidad']; ?></div></td>
                        <td><div align="center"><?php echo $row['valor']; ?></div></td>                        
                        <td><div align="center">
                                <button type="button" class="btn btn-default btn-sm" onclick="abrirasignacion('<?php echo $row['documento']; ?>');">
                                    <span class="glyphicon glyphicon-cog"></span> Asignar
                                </button>
                            </div></td>
                    </tr>

                    <?php
                }
            } else {
                ?>
                <tr><td colspan="6">NO SE ENCONTRO NINGUN RESULTADO</td></tr>
            <?php } ?>
        </table>
        <?php
        break;

    case 'abrirasignacion':
        $documento = $_GET['documento'];
        $query = "SELECT
        c.codigo_documento AS documento,
        c.fecha_emision AS fecha_e,
        mrbooks.maecte.nomcte01 AS cliente,
        c.total_factura AS valor,
        sum(d.cantidad) as cantidad
        FROM
        mrbcvg AS c
        INNER JOIN mrbooks.maecte ON c.codigo_cliente = mrbooks.maecte.cascte01
        INNER JOIN mrbdcvg AS d ON d.codigo_documento = c.codigo_documento
        WHERE c.codigo_documento = '$documento'
        GROUP BY d.codigo_documento";
        $resultado = mysql_query($query);
        $row = mysql_fetch_array($resultado);
        $query_ajustes = "SELECT
        d.TIPOTRA03 AS tipo,
        d.NOCOMP03 AS ajuste,
        DATE_FORMAT(d.FECMOV03,'%Y-%m-%d') AS fecha,
        Sum(d.CANTID03) AS cantidad,
        Sum(ROUND(m.precvta01+((m.precvta01 * m.porciva01)/100))*d.CANTID03) AS valor,
        d.detalle03 as detalle
        FROM
        movpro as d
        INNER JOIN maepro as m ON d.CODPROD03 = m.codprod01
        WHERE d.TIPOTRA03 = '85' AND d.lotfabrica03 = ''
        GROUP BY d.TIPOTRA03;";
        $resultado_ajustes = mysql_query($query_ajustes);
        ?>
        <style>
            #izquierda {
                float:left;
                width: 500px;
            }
            #centro {
                float:left;
                width: 20px;
                margin-top: 45px;
                padding-left: 20px;
                padding-right: 40px;
            }
            #derecha {
                float:left;
                width:600px;
            }
        </style>
        <div class="container">
            <form>
                <div id="izquierda">
                    <table class="table table-striped table-condensed table-bordered">
                        <thead>
                            <tr><th colspan="6">NUMEROS DE CONTRATOS</th></tr>
                            <tr>
                                <th></th>
                                <th>DOCUMENTO</th>
                                <th>FECHA</th>
                                <th>CLIENTE</th>
                                <th>CANTIDAD</th>
                                <th>VALOR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="checkbox" checked="true"/></td>
                                <td><?php echo $row['documento']; ?></td>
                                <td><?php echo $row['fecha_e']; ?></td>
                                <td><?php echo $row['cliente']; ?></td>
                                <td><?php echo $row['cantidad']; ?></td>
                                <td><?php echo $row['valor']; ?></td>
                            </tr>                        
                        </tbody>                    
                    </table>
                </div>
                <div id="centro">
                    <table class="table table-striped table-condensed table-hover">                       
                        <tbody>                            
                            <tr>
                                <td><span class="glyphicon glyphicon-chevron-right"></span></td>
                                <td><span class="glyphicon glyphicon-chevron-right"></span></td>                                
                            </tr>
                        </tbody>                    
                    </table>
                </div>    
                <div id="derecha">
                    <table class="table table-striped table-condensed table-bordered">
                        <thead>
                            <tr><th colspan="6">SELECCIONAR AJUSTES</th></tr>
                            <tr>
                                <th></th>
                                <th>AJUSTE</th>
                                <th>FECHA</th>
                                <th>DETALLE</th>
                                <th>CANTIDAD</th>
                                <th>VALOR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysql_num_rows($resultado_ajustes) > 0) {
                                while ($row2 = mysql_fetch_array($resultado_ajustes)) {
                                    ?>
                                    <tr>
                                        <td><input type="checkbox"/></td>
                                        <td><?php echo $row2['ajuste']; ?></td>
                                        <td><?php echo $row2['fecha']; ?></td>
                                        <td><?php echo $row2['detalle']; ?></td>
                                        <td><?php echo $row2['cantidad']; ?></td>
                                        <td><?php echo $row2['valor']; ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                            <?php } ?>
                        </tbody>                    
                    </table>
                </div>
            </form>
        </div>
        <?php
        break;
}
    