<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//echo 'Desde detalle de proforma';

include('conexion.php');


$IDB = $_GET['IDB'];
$idpro = $_GET['idpro'];
$proforma = $_GET['proforma'];
$cedula = $_GET['cedula'];
$nombre = $_GET['nombre'];
$fecha = $_GET['fecha'];

?>
<html lang="en">
    <head>
        <title>CREADOR DE PROFORMAS MR BOOKS</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">       
        <link rel="stylesheet" href="../css/bootstrap.min.css">           
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">                  
        <script type="text/javascript" src="../js/jquery-1.12.4.min.js"></script>        
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../js/myjava.js"></script>


    </head>
    <body onload="cargaproformas();">
        <div class="container">
            <form class="form-inline" role="form" method="GET" id="formbusqueda">
                <div id="printableArea">                    
                    <table class="table table-bordered">                        
                        <tr>     
                        <input class="hide" type="text" required="required" readonly="readonly" id="IDB" value=<?php echo $IDB; ?> />                        
                        <input class="hide" type="text" required="required" readonly="readonly" id="idpro" value=<?php echo $idpro; ?> />
                        <input class="hide" type="text" required="required" readonly="readonly" id="proforma" value=<?php echo $proforma; ?> />
                        <td colspan="10"><div align="center"><font size="6">P R O F O R M A : <?php echo $proforma; ?></font></div></td>                    
                        </tr>
                        <tr>
                            <td width="260" rowspan="2"><div align="center"><img src="../recursos/<?php echo $logo; ?>" border="0" width="150" height="65"></div></td>
                            <td colspan="1"><b>Nombre: </b> <?php echo $nombre; ?></td> 
                            <td colspan="1"><b>Cedula: </b> <?php echo $cedula; ?></td>                   
                            <td colspan="2"><b>Fecha: </b> <?php echo $fecha; ?></td>                    
                        </tr>
                        <tr>                    
                            <td colspan="1"><b>Direccion Establecimiento: <?php echo $direccion; ?></b></td>
                            <td colspan="3"><b>Telefono: <?php echo $telefono; ?></b></td>
                        </tr>
                    </table>
                    <table class="table" id="botones-proforma">
                        <tr>
                            <td colspan="1">
                                <div align="center">
                                    <div class="form-group">
                                        <input type="number" class="form-control" id="cantiad-proforma" value="1"/>            
                                    </div>
                                </div>
                            </td>
                            <td colspan="1">
                                <div align="center">
                                    <div class="form-group">
                                        <input type="text" class="form-control" required="required" id="codigo-proforma" placeholder="Ingrese el Codigo"/>            
                                    </div>
                                </div>
                            </td>
                            <td colspan="1">
                                <div align="center">
                                    <div class="form-group">
                                        <button  id="agregar-codigo-proforma" required="required" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> AGREGAR</button>                                  
                                    </div>
                                </div>
                            </td>
                            <td colspan="1">
                                <div align="center">
                                    <div class="form-group">
                                        <button class="btn btn-success" id="btnExport-proformas"><span class="glyphicon glyphicon-floppy-disk"></span> EXCEL</button>                              
                                    </div>
                                </div>
                            </td>
                            <td colspan="1">
                                <div align="center">
                                    <div class="form-group">
                                        <button onclick="printDiv('printableArea')" id="imprimir-proforma" class="btn btn-default"><span class="glyphicon glyphicon-print"></span> IMPRIMIR</button>                                  
                                    </div>
                                </div>
                            </td>
                        </tr>                        
                    </table>                  
                    <div id="agrega-detalle-proformas"></div>
                </div>
            </form>
        </div>
    </body>
</html>