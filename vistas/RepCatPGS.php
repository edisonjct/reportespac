<?php
include '../php/conexion.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $nombreb; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">         
        <link rel="icon" type="image/png" href="../recursos/icono.ico"/>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/bootstrap-select.css">        
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <script src="../js/jquery.js"></script>
        <script src="../js/myjava.js"></script>
        <script src="../js/bootstrap-select.js"></script>        
        
    </head>
    <body>
        <div class="container">    
            <form class="form-inline" role="form" method="GET">
                <center>      
                    <h2><?php echo $nombreb; ?></h2>
                    <input class="hide" type="text" required="required" readonly="readonly" id="IDB" value=<?php echo $base; ?> />
                    <div class="form-group">                        
                        <select required="required" id="cb-clientesgs" class="selectpicker" multiple data-actions-box="true" data-live-search="true" data-selected-text-format="count > 3" data-toggle="tooltip" title="Clientes Grandes Superficies">
                            <?php
                            $query = mysql_query("SELECT codcte01,nomcte01 FROM maecte WHERE tipcte01 = '0001' ORDER BY nomcte01 ASC");
                            if (mysql_num_rows($query) > 0) {
                                while ($row = mysql_fetch_array($query)) {
                                    echo "<option value='" . $row['codcte01'] . "'>" . $row['nomcte01'] . "</option>\n";
                                }
                            }
                            ?>                                                                    
                        </select>                        
                    </div>                         
                    <button id="bt-RepCatPGS" class="btn btn-primary">Buscar</button>                    
                    <button onclick="window.close();" class="btn btn-warning">Salir</button>                    
                </center>
            </form>      
            <br>
            <div class="table-responsive" id="agrega-registros"></div>
        </div>

        <div class="modal fade" id="registra-producto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><a class="btn btn-danger">X</a></button>
              <h4 class="modal-title" id="myModalLabel"><b>Edita un Producto Categorizado</b></h4>
            </div>
            <form id="formulario" class="formulario" onsubmit="return agregaRegistro();">
            <div class="modal-body">
                <table border="0" width="100%">     
                     <tr>
                        <td colspan="2"><input class="hide" type="text" required="required" readonly="readonly" id="cliente" name="cliente" /></td>
                        <td><input class="hide" type="text" required="required" readonly="readonly" id="pro" name="pro"/></td>
                     </tr>                
                    <tr>
                        <td>Codigo: </td>                        
                        <td><input class="form-control" type="text" required="required" readonly="readonly" id="codigo" name="codigo"/></td>
                    </tr>
                    <tr>
                        <td>Titulo: </td>
                        <td><input class="form-control" type="text" required="required" readonly="readonly" id="titulo"/></td>
                    </tr>
                    <tr>
                        <td>Categoria: </td>
                        <td><input class="form-control" type="text" required="required" readonly="readonly" id="categoria"/></td>
                    </tr>
                    <tr>
                        <td>Categoria GS: </td>                        
                        <td>
                            <select name="categoriags" id="categoriags" class="form-control">
                                <option value="0">Selecione Pais</option>
                            </select>
                        </td>
                    </tr>                    
                    <tr>
                        <td>Autor: </td>
                        <td><input class="form-control" type="text" required="required" readonly="readonly" id="autor"/></td>
                    </tr> 
                    <tr>
                        <td>Editoria: </td>
                        <td><input class="form-control" type="text" required="required" readonly="readonly" id="editorial"/></td>
                    </tr> 
                    <tr>
                        <td>Provedor: </td>
                        <td><input class="form-control" type="text" required="required" readonly="readonly" id="provedor"/></td>
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
                <input type="submit" value="Modificar" class="btn btn-warning"  id="edi"/>
            </div>
            </form>
          </div>
        </div>
      </div>
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>