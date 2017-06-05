<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FacturasElectronicasControlador
 *
 * @author EChulde
 */
$tipo = $_GET['tipo'];
$bodega = $_GET['bodega'];
$desde = $_GET['desde'];
$hasta = $_GET['hasta'];

require_once '../modelo/FacturasElectronicasModelo.php';

switch ($tipo) {
    case 'FAC':


        $facturas = new FacturasElectronicasModelo();
        ?>
        <table class="table table-bordered table-hover table-condensed">
            <thead>
                <tr>
        <!--                    <th width="15%">FECHA</th>
                    <th width="15%">DOCUMENTO</th>
                    <th width="10%">CEDULA</th>
                    <th width="25%">CLIENTE</th>
                    <th width="25%">AUTORIZACION</th>
                    <th width="10%">ESTADO</th>-->
                    <th>FECHA</th>
                    <th>DOCUMENTO</th>
                    <th>CEDULA</th>
                    <th>CLIENTE</th>
                    <th>AUTORIZACION</th>
                    <th>ESTADO</th>
                    <th>LINK</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $arrayfactura = $facturas->buscar_facturas($bodega, $desde, $hasta);
                foreach ($arrayfactura as $row) {
                    ?>
                    <tr>
                        <td><?php echo $row['fecha']; ?></td>
                        <td><?php echo $row['numero']; ?></td>
                        <td><input class="" type="text" value="<?php echo $row['codigocliente']; ?>"></td>
                        <td><?php echo $row['codigocliente']; ?></td>
                        <td><input class="" type="text" value="<?php echo $row['observacion']; ?>"></td>
                        <td><select class="">
                                <option value="<?php echo $row['observacion']; ?>"><?php echo $row['esta']; ?></option>
                                <option value="1">AUTORIZADO</option>
                                <option value="2">RECHAZADO</option>
                                <option value="0">VOLVER A ENVIAR</option>
                            </select>
                        </td>
                        <td>
                            <table class="table table-bordered table-condensed"> 
                                <tr> 
                                    <td>Autorizada</td> 
                                    <td>213333333333333333333333544888888888888877777</td> 
                                </tr>                                 
                            </table> 
                        </td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>
        <?php
        break;
}