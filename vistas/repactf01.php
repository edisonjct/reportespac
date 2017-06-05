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
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <link href="../css/bootstrap-datetimepicker.css" rel="stylesheet">             
        <script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>        
        <script src="../js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../js/moment.js"></script>
        <script src="../js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="../js/myjava.js"></script>
    </head>
    <body>
        <br>
        <div class="container">    
            <form class="form-inline" role="form" method="GET">
                <center>
                    <input class="hide" type="text" required="required" readonly="readonly" id="IDB" value=<?php echo $IDB; ?> />
                    <input class="hide" type="text" required="required" readonly="readonly" id="ID" value=<?php echo $ID; ?> />
                    <div class="form-group">
                        <select required="required" id="cb-ubicacion" class="form-control" data-toggle="tooltip" title="Seleccione Ubicacion">
                            <option value="todos">TODOS</option>
                            <?php
                            $query = mysql_query("select u.codtab as codigo,u.nomtab as nombre from mrbooks.maetab u WHERE u.numtab = '0401' and u.codtab <> '' ORDER BY u.nomtab ASC");
                            if (mysql_num_rows($query) > 0) {
                                while ($row = mysql_fetch_array($query)) {
                                    echo "<option value='" . $row['codigo'] . "'>" . $row['nombre'] . "</option>\n";
                                }
                            }
                            ?>                                                                    
                        </select>                                     
                        </select>                   
                    </div>
                    <div class="form-group">
                        <select required="required" id="cb-grupo" class="form-control" data-toggle="tooltip" title="Seleccione Grupo">
                            <option value="todos">TODOS</option>
                            <?php
                            $query = mysql_query("SELECT codcate as codigo,desccate as nombre FROM mrbooks.mrb_categoria_activos");
                            if (mysql_num_rows($query) > 0) {
                                while ($row = mysql_fetch_array($query)) {
                                    echo "<option value='" . $row['codigo'] . "'>" . $row['nombre'] . "</option>\n";
                                }
                            }
                            ?>                                                                    
                        </select>                                     
                        </select>                   
                    </div>
                    <div class="form-group">
                        <div class="input-group date" id="datedesde">
                            <input type="text" class="form-control" id="desde" data-toggle="tooltip" title="Fecha Desde">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>                        
                    </div>
                    <div class="form-group">
                        <div class="input-group date" id="datehasta">
                            <input type="text" class="form-control" id="hasta" data-toggle="tooltip" title="Fecha Hasta">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>                        
                    </div>
                                                                                   
                </center>
                <br>
                <div class="table-responsive" id="agrega-registros"></div>            
            </form>      
            
        </div>        
        <div class="footer">
            <form class="form-inline" role="form" method="GET">
            <div align="center">                
                <button type="button" class="buttonfooter" id="bt-buscaactivosf"><img src="../recursos/move_f2.png" class="img-rounded" width="15" height="15"> BUSCAR</button>
                <a data-toggle="tooltip" title="Exportar a Excel" target="_blank" href="javascript:excelactf();"><button type="button" class="buttonfooter"><img src="../recursos/excel.png" class="img-rounded" width="15" height="15"> EXCEL </button></a>
                <button type="button" class="buttonfooter" id="bt-recargar"><img src="../recursos/controlpanel.png" class="img-rounded" width="15" height="15"> RECARGAR</button>
                <button type="button" name="" value="" onclick="window.close();" class="buttonfooter"><img src="../recursos/OOFL.png" class="img-rounded" width="15" height="15"> SALIR</button>
            </div>
                </form>
        </div>
    </body>
</html>


