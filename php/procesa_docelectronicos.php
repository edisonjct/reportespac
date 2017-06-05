<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'conexion.php';



$tipo = $_GET['tipo'];
$IDB = $_GET['IDB'];
$proceso = $_GET['proceso'];

if ($proceso == '01') {
    switch ($tipo) {
        case '01';
            $sql = "UPDATE factura_electronica SET rechazada='0' WHERE rechazada = '2' AND observacion = 'El comprobante ya se encuentra cargado al sistema';";
            $query = mysql_query($sql);
            echo  mysql_affected_rows(), " Registros Actualizados de Estado";     
            break;
        case '02';
            $sql = "UPDATE nota_credito_electronica SET rechazada='0' WHERE rechazada = '2' AND observacion = 'El comprobante ya se encuentra cargado al sistema';";
            $query = mysql_query($sql);
            echo  mysql_affected_rows(), " Registros Actualizados de Estado";
            break;
        case '03';
            $sql = "UPDATE retencion_electronica SET rechazada='0' WHERE rechazada = '2' AND observacion = 'El comprobante ya se encuentra cargado al sistema';";
            $query = mysql_query($sql);
            echo  mysql_affected_rows(), " Registros Actualizados de Estado";
            break;
        case '04';
            $sql = "UPDATE guia_remision_electronica SET rechazada='0' WHERE rechazada = '2' AND observacion = 'El comprobante ya se encuentra cargado al sistema';";
            $query = mysql_query($sql);
            echo  mysql_affected_rows(), " Registros Actualizados de Estado";
            break;
    }
} else {
    switch ($tipo) {
        case '01':
            $query = "SELECT 
        numero_factura as documento,
        fecha_emision as fecha,
        codigo_cliente as codigo_cliente,
        nomcte01 as cliente,
        total_factura as valor,
        case WHEN rechazada = '2' THEN 'Rechazada' WHEN rechazada = '0' THEN 'Esperando Autorizacion' END as estado,
        observacion as observacion
        from factura_electronica
        INNER JOIN mrbooks.maecte ON factura_electronica.codigo_cliente = maecte.codcte01
        WHERE rechazada = '2' AND observacion = 'El comprobante ya se encuentra cargado al sistema'";
            $result = mysql_query($query, $conexion);
            if (mysql_num_rows($result) > 0) {
                ?>
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>FACTURA</th>
                        <th>FECHA EMISION</th>
                        <th>CODIGO CLIENTE</th>
                        <th>CLIENTE</th>
                        <th>VALOR</th>
                        <th>ESTADO</th>
                        <th>OBSERVACION</th>                    
                    </tr>
                    <?php while ($row = mysql_fetch_assoc($result)) { ?>
                        <tr>
                            <th><?php echo $row['documento']; ?></th>
                            <td><?php echo $row['fecha']; ?></td>
                            <td><?php echo $row['codigo_cliente']; ?></td>
                            <td><?php echo $row['cliente']; ?></td>
                            <td><?php echo $row['valor']; ?></td>
                            <td><?php echo $row['estado']; ?></td>
                            <td><?php echo $row['observacion']; ?></td>                        
                        </tr>
                    <?php } ?>                
                </table>
                <?php
            } else {
                echo "Sin registros";
                mysql_free_result($result);
            }
            break;
        case '02':
            $query = "SELECT 
        numero_nota_credito as documento,
        fecha_emision as fecha,
        codigo_cliente as codigo_cliente,
        nomcte01 as cliente,
        total_nota as valor,
        CASE WHEN rechazada = '2' THEN 'Rechazada' WHEN rechazada = '0' THEN 'Esperando Autorizacion' END as estado,
        observacion as observacion
        FROM 
        nota_credito_electronica
        INNER JOIN mrbooks.maecte ON nota_credito_electronica.codigo_cliente = maecte.codcte01
        WHERE rechazada = '2' AND observacion = 'El comprobante ya se encuentra cargado al sistema';";
            $result = mysql_query($query, $conexion);
            if (mysql_num_rows($result) > 0) {
                ?>
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>NOTA DE CREDITO</th>
                        <th>FECHA EMISION</th>
                        <th>CODIGO CLIENTE</th>
                        <th>CLIENTE</th>
                        <th>VALOR</th>
                        <th>ESTADO</th>
                        <th>OBSERVACION</th>                    
                    </tr>
                    <?php while ($row = mysql_fetch_assoc($result)) { ?>
                        <tr>
                            <th><?php echo $row['documento']; ?></th>
                            <td><?php echo $row['fecha']; ?></td>
                            <td><?php echo $row['codigo_cliente']; ?></td>
                            <td><?php echo $row['cliente']; ?></td>
                            <td><?php echo $row['valor']; ?></td>
                            <td><?php echo $row['estado']; ?></td>
                            <td><?php echo $row['observacion']; ?></td>                        
                        </tr>
                    <?php } ?>                
                </table>
                <?php
            } else {
                echo "Sin registros";
                mysql_free_result($result);
            }
            break;
        case '03':
            $query = "SELECT 
        retencion_electronica.numero_retencion as documento,
        fecha_emision_retencion as fecha,
        codigo_cliente as codigo_cliente,
        nomcte01 as cliente,
        sum(valor_retenido) as valor,
        CASE WHEN rechazada = '2' THEN 'Rechazada' WHEN rechazada = '0' THEN 'Esperando Autorizacion' END as estado,
        observacion as observacion
        FROM 
        retencion_electronica
        INNER JOIN mrbooks.maepag ON retencion_electronica.codigo_cliente = maepag.codcte01
        INNER JOIN detalle_retencion on retencion_electronica.numero_retencion = detalle_retencion.numero_retencion
        WHERE rechazada = '2' AND observacion = 'El comprobante ya se encuentra cargado al sistema'
        GROUP BY detalle_retencion.numero_retencion;";
            $result = mysql_query($query, $conexion);
            if (mysql_num_rows($result) > 0) {
                ?>
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>NOTA DE RETENCION</th>
                        <th>FECHA EMISION</th>
                        <th>CODIGO PROVEDOR</th>
                        <th>CLIENTE</th>
                        <th>VALOR RETENIDO</th>
                        <th>ESTADO</th>
                        <th>OBSERVACION</th>                    
                    </tr>
                    <?php while ($row = mysql_fetch_assoc($result)) { ?>
                        <tr>
                            <th><?php echo $row['documento']; ?></th>
                            <td><?php echo $row['fecha']; ?></td>
                            <td><?php echo $row['codigo_cliente']; ?></td>
                            <td><?php echo $row['cliente']; ?></td>
                            <td><?php echo $row['valor']; ?></td>
                            <td><?php echo $row['estado']; ?></td>
                            <td><?php echo $row['observacion']; ?></td>                        
                        </tr>
                    <?php } ?>                
                </table>
                <?php
            } else {
                echo "Sin registros";
                mysql_free_result($result);
            }
            break;
        case '04':
            $query = "SELECT numero_guia_remision as documento,
            fecha_emision as fecha,
            codigo_cliente as codigo_cliente,
            nombre_cliente as cliente,
            case WHEN rechazada = '2' THEN 'Rechazada' WHEN rechazada = '0' THEN 'Esperando Autorizacion' END as estado,
            observacion as observacion
            FROM guia_remision_electronica 
            WHERE rechazada = '2' AND observacion = 'El comprobante ya se encuentra cargado al sistema'";
            $result = mysql_query($query, $conexion);
            if (mysql_num_rows($result) > 0) {
                ?>
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>NOTA DE GUIA</th>
                        <th>FECHA EMISION</th>
                        <th>CODIGO CLIENTE</th>
                        <th>CLIENTE</th>
                        <th>ESTADO</th>
                        <th>OBSERVACION</th>                    
                    </tr>
                    <?php while ($row = mysql_fetch_assoc($result)) { ?>
                        <tr>
                            <th><?php echo $row['documento']; ?></th>
                            <td><?php echo $row['fecha']; ?></td>
                            <td><?php echo $row['codigo_cliente']; ?></td>
                            <td><?php echo $row['cliente']; ?></td>
                            <td><?php echo $row['estado']; ?></td>
                            <td><?php echo $row['observacion']; ?></td>                        
                        </tr>
                    <?php } ?>                
                </table>
                <?php
            } else {
                echo "Sin registros";
                mysql_free_result($result);
            }
            break;
    }
}



