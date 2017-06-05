<?php
$IDB = $_GET['IDB'];
$ID = $_GET['ID'];
include_once '../php/conexion.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $nombreb; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/bootstrap-select.css">        
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>        
        <script type="text/javascript" src="../js/jquery.js"></script>              
        <script type="text/javascript" src="../js/myjava.js"></script>
        <script type="text/javascript" src="../js/bootstrap-select.js"></script>

    </head>
    <body>
        <br>
        <div class="container">    
            <form class="form-inline" role="form" method="GET">
                <center>
                    <input class="hide" type="text" required="required" readonly="readonly" id="IDB" value=<?php echo $IDB; ?> />
                    <input class="hide" type="text" required="required" readonly="readonly" id="ID" value=<?php echo $ID; ?> />
                    <div class="form-group">            
                        <input type="text" class="form-control" placeholder="Buscar Codigo" id="bs-prod"/>
                    </div>
                    <button id="bt-buscaproductosinv" class="btn btn-primary">Buscar</button>                                               
                </center>
            </form>      
            <br>
            <div class="table-responsive" id="agrega-registros"></div>
        </div>

        <div class="modal fade" id="registra-producto" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><a class="btn btn-danger">X</a></button>
                        <h4 class="modal-title" id="myModalLabel"><b>Edita un Ficha de Producto</b></h4>
                    </div>
                    <form id="formulario" class="formulario" onsubmit="return agregaRegistro();">
                        <div class="modal-body">
                            <table border="0" width="100%">     
                                <tr>
                                    <td colspan="6"><input class="hide" type="text" required="required" readonly="readonly" id="cliente" name="cliente" /></td>
                                    <td colspan="6"><input class="hide" type="text" required="required" readonly="readonly" id="pro" name="pro"/></td>
                                </tr>                
                                <tr>
                                    <td>Codigo: </td>                        
                                    <td><input class="form-control" type="text" required="required" readonly="readonly" id="codigo"/></td>
                                    <td>&nbsp;&nbsp;Referencia: </td>
                                    <td><input class="form-control" type="text" required="required" id="referencia" name="referencia"/></td>
                                    <td>&nbsp;&nbsp;Titulo: </td>
                                    <td><input class="form-control" type="text" required="required" id="titulo" name="titulo"/></td>
                                </tr>
                                <tr>
                                    <td>Autor: </td>                        
                                    <td><select required="required" id="cb-clientesgs" class="selectpicker" data-actions-box="true" data-live-search="true" data-selected-text-format="count > 3" data-toggle="tooltip" title="Filtrar Autores">
                                            <?php
                                            $query = mysql_query("select codigo,nombres from autores ORDER BY nombres ASC");
                                            if (mysql_num_rows($query) > 0) {
                                                while ($row = mysql_fetch_array($query)) {
                                                    echo "<option value='" . $row['codigo'] . "'>" . $row['nombres'] . "</option>\n";
                                                }
                                            }
                                            ?>                                                                    
                                        </select> </td>
                                    <td>&nbsp;&nbsp;Editorial: </td>
                                    <td><input class="form-control" type="text" required="required" id="titulo" name="titulo"/></td>
                                    <td>&nbsp;&nbsp;Categoria: </td>
                                    <td><input class="form-control" type="text" required="required" id="titulo" name="titulo"/></td>
                                </tr>
                                <tr>
                                    <td>Provedor: </td>                        
                                    <td><input class="form-control" type="text" required="required" id="codigo" name="codigo"/></td>
                                    <td>&nbsp;&nbsp;Idioma: </td>
                                    <td><input class="form-control" type="text" required="required" id="titulo" name="titulo"/></td>
                                    <td>&nbsp;&nbsp;FechaUF: </td>
                                    <td><input class="form-control" type="text" required="required" id="titulo" name="titulo"/></td>
                                </tr>
                                <tr>
                                    <td>Precio: </td>                        
                                    <td><input class="form-control" type="text" required="required" readonly="readonly" id="codigo" name="codigo"/></td>
                                    <td>&nbsp;&nbsp;Descuento: </td>
                                    <td><input class="form-control" type="text" required="required" readonly="readonly" id="titulo" name="titulo"/></td>
                                    <td>&nbsp;&nbsp;Costo: </td>
                                    <td><input class="form-control" type="text" required="required" readonly="readonly" id="titulo" name="titulo"/></td>
                                </tr>                    
                                <tr>
                                    <td>Tipo: </td>                        
                                    <td><input class="form-control" type="text" required="required" id="codigo" name="codigo"/></td>
                                    <td>&nbsp;&nbsp;Tipo2: </td>
                                    <td><input class="form-control" type="text" required="required" id="titulo" name="titulo"/></td>
                                    <td>&nbsp;&nbsp;Ubicacion: </td>
                                    <td><input class="form-control" type="text" required="required" id="titulo" name="titulo"/></td>
                                </tr>                                 
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Portada: </td>                        
                                    <td><input class="form-control" type="text" required="required" id="codigo" name="codigo"/></td>                                    
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <div id="mensaje"></div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="modal-footer">
                            <input type="submit" value="Registrar" class="btn btn-success" id="reg"/>
                            <input type="submit" value="Modificar" class="btn btn-warning"  id="edi"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="../js/bootstrap.min.js"></script>

    </body>
</html>