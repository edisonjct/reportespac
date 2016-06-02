<?php
$IDB = $_GET['IDB'];
$UID = $_GET['UID'];
include_once '../php/conexion.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $nombreb; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        
        <link rel="stylesheet" href="../css/bootstrap-select.css">        
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>        
        <script type="text/javascript" src="../js/jquery.js"></script>              
        <script type="text/javascript" src="../js/myjava.js"></script>
        <script type="text/javascript" src="../js/bootstrap-select.js"></script>
        
        
    </head>
    <body id="buscarproducto">
        <br>
        <div class="container">    
            <form class="form-inline" role="form" method="GET">
                <center>
                    <input class="hide" type="text" required="required" readonly="readonly" id="IDB" value=<?php echo $IDB; ?> />
                    <input class="hide" type="text" required="required" readonly="readonly" id="UID" value=<?php echo $UID; ?> />
                    <div class="form-group">            
                        <input type="number" class="form-control" placeholder="Buscar Codigo" id="bs-prod"/>
                    </div>
                    <div class="form-group">            
                        <input type="text" class="form-control" placeholder="Buscar Titulo" id="bs-titulo"/>
                    </div>
                    <button id="bt-buscaproductosinv" class="btn btn-primary">Buscar</button>                   
                </center>
            </form>      
            <br>
            <div class="table-responsive" id="agrega-registros"></div>
        </div>

        <!-- MODAL PARA EL REGISTRO DE PRODUCTOS-->
        <div class="modal fade" id="registra-producto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel"><b>Registra o Edita un Producto</b></h4>
                    </div>
                    <form id="formulario" class="formulario" onsubmit="return agregaRegistro();">
                        <div class="modal-body">
                            <table border="0" width="100%">
                                <tr>
                                    <td colspan="2"><input type="text" required="required" readonly="readonly" id="id-prod" name="id-prod" readonly="readonly" style="visibility:hidden; height:5px;"/></td>
                                </tr>
                                <tr>
                                    <td width="150">Proceso: </td>
                                    <td><input type="text" required="required" readonly="readonly" id="pro" name="pro"/></td>
                                </tr>
                                <tr>
                                    <td>Nombre: </td>
                                    <td><input type="text" required="required" name="nombre" id="nombre" maxlength="100"/></td>
                                </tr>
                                <tr>
                                    <td>Tipo: </td>
                                    <td><select required="required" name="tipo" id="tipo">
                                            <option value="enlatados">Enlatados</option>
                                            <option value="organicos">Organicos</option>
                                            <option value="nocomestibles">No Comestibles</option>
                                            <option value="otros">Otros</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>Precio Unitario: </td>
                                    <td><input type="number" required="required" name="precio-uni" id="precio-uni"/></td>
                                </tr>
                                <tr>
                                    <td>Precio Distribuidor: </td>
                                    <td><input type="number"  required="required" name="precio-dis" id="precio-dis"/></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div id="mensaje"></div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="modal-footer">
                            <input type="submit" value="Registrar" class="btn btn-success" id="reg"/>
                            <input type="submit" value="Editar" class="btn btn-warning"  id="edi"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>       
    </body>
</html>