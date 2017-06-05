<script type="text/javascript" src="../js/jquery.js"></script>

<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'conexion.php';



$IDB = $_GET["IDB"];
$tipo = $_GET["tipo"];
$desde = $_GET["desde"];
$hasta = $_GET["hasta"];


switch ($tipo) {
    case 01:
        $query = "SELECT 
        d.fecha_emision as fecha,
        d.numero_factura as documento,
        c.nocte31 as codigo,
        d.codigo_cliente as codigo2,
        c.nomcte31 as nombre,
        d.total_factura as total,
        d.rechazada as codestado,
        d.observacion as obser,
        d.rechazada as estado       
        FROM
        factura_electronica as d
        INNER JOIN maefac as c ON d.numero_factura = c.nofact31
        WHERE d.fecha_emision BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND d.rechazada != '9' ORDER BY fecha DESC; ";
        $result = mysql_query($query, $conexion);
        ?>        
        <?php if (mysql_num_rows($result) > 0) { ?>
        <div align="right">
            <input type="button" id="enviar" name="enviar" value="enviar" />
        </div>
            <table class="table table-striped table-hover table-bordered" >
                <tr>
                    <th>FECHA</th>
                    <th>DOCUMENTO</th>
                    <th>CEDULA</th>
                    <th>CLIENTE</th>
                    <th>VALOR</th>
                    <th>ESTADO</th>  
                    <th>AUTORIZACION</th>
                    <th>ACCIONES</th>
                </tr>
                <?php while ($row = mysql_fetch_assoc($result)) { ?>
                    <tr>                          
                        <td align="center"><?php echo $row['fecha']; ?></td>
                        <td align="center"><?php echo $row['documento']; ?></td>
                        <td align="center"><?php echo $row['codigo']; ?></td>
                        <td align="center"><?php echo $row['nombre']; ?></td>
                        <td align="center"><?php echo $row['total']; ?></td>
                        <?php $sqlautorizacion = mysql_query("SELECT autocompra43 FROM mrbooks.movcte WHERE numdoc43 = '" . $row['documento'] . "' AND codcte43 = '" . $row['codigo2'] . "' AND tipodoc43 = '02' LIMIT 1 "); ?>                       
                        <?php $row2 = mysql_fetch_assoc($sqlautorizacion); ?>
                        <?php if ($row2['autocompra43'] != '') { ?>
                        <td align="center">AUTORIZADO</td>
                        <?php } else if ($row2['autocompra43'] == '') { ?> 
                        <td align="center">ESPERANDO AUTORIZACION</td>
                        <?php } else if($row['estado'] == '1') { ?>
                        <td align="center">DEVULTA</td>
                        <?php } else if($row['estado'] == '2') {?>
                        <td align="center">RECHAZADA</td>
                        <?php } ?>
                        <?php if($row2['autocompra43'] != '') { ?>
                        <td align="center"><?php echo $row2['autocompra43'];?></td>
                        <?php } else { ?>
                        <td align="center"> -- </td>
                        <?php } ?>
                        <?php if($row2['autocompra43'] != '') { ?>
                        <td align="center">PDF</td>
                        <?php } else { ?>
                        <td align="center" onclick="alert('<?php echo $row['obser'];?>')"><a href="#">Aviso</a></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <?php echo "NO SE ENCONTRARON REGISTROS"; ?>
        <?php } ?>
        
                   
        <?php
        break;
    case 02:
        echo "notas";
        break;
    case 03:
        echo "reten";
        break;
    case 04:
        echo "guias";
        break;
}