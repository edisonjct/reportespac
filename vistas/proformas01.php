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
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="../css/bootstrap.min.css">           
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <link href="../css/bootstrap-datetimepicker.css" rel="stylesheet">             
        <script type="text/javascript" src="../js/jquery-1.12.4.min.js"></script>        
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="../js/myjava.js"></script>
    </head>
    <body>
        <br>
        <div class="container">             
            <form class="form-inline" role="form" method="GET" id="formbusqueda">
                <center>
                    <input class="hide" type="text" required="required" readonly="readonly" id="IDB" value=<?php echo $IDB; ?> />
                    <input class="hide" type="text" required="required" readonly="readonly" id="ID" value=<?php echo $ID; ?> />                    
                    <div class="form-group">
                        <input type="text" class="form-control" id="cedula-cli" placeholder="Buscar Cliente"/>            
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="proforma-cli" placeholder="Buscar Proforma"/>            
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="buscar_proformas"><span class="glyphicon glyphicon-search"></span> Buscar</button>           
                    </div>
                </center>
                <br>
                <div class="table-responsive" id="agrega-registros"></div>
            </form>
            <div class="modal fade" id="registra-proformas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><b>Agregar Proforma</b></h4>
                        </div>
                        <form id="formulario" class="formulario form-inline" onsubmit="return agregaProformas();">
                            <?php
                            $ultimosql = mysql_query('select max(id) as max from mrb_proformas_cabecera');
                            $resultultimo = mysql_fetch_array($ultimosql);
                            $ultimo = $resultultimo['max'];
                            ?>
                            <div class="modal-body">
                                <div class="form-group">                                    
                                    <input type="hidden" required="required" readonly="readonly" value="<?php echo $IDB; ?>" id="IDB" name="IDB" readonly="readonly"/>
                                    <input type="hidden" required="required" readonly="readonly" value="<?php echo $ultimo; ?>" id="ultimo" name="ultimo" readonly="readonly"/>
                                </div>                                
                                <div class="form-group">
                                    <label>Cedula: </label>
                                    <input type="text" class="form-control" required="required" name="cedula" id="cedula" maxlength="15"/>
                                </div>
                                <div class="form-group">
                                    <label>Nombre: </label>
                                    <input type="text" class="form-control" required="required" name="nombre" id="nombre" maxlength="100"/>
                                </div>                                
                            </div>
                            <div id="mensaje"></div>
                            <div class="modal-footer">
                                <input type="submit" value="Agregar" class="btn btn-success" id="reg"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>               

        <div class="footer">
            <form class="form-inline" role="form" method="GET" id="baner1">
                <div align="center">                
                    <button type="button" class="buttonfooter" id="nuevo-proforma" data-toggle="modal" data-target="#myModal"><img src="../recursos/b_save.png" class="img-rounded" width="15" height="15"> INGRESAR</button>
                    <a data-toggle="tooltip" title="Exportar a Excel" href=""><button type="button" class="buttonfooter"><img src="../recursos/excel.png" class="img-rounded" width="15" height="15"> EXCEL </button></a>
                    <button type="button" class="buttonfooter" id="bt-recargar"><img src="../recursos/controlpanel.png" class="img-rounded" width="15" height="15"> RECARGAR</button>
                    <button type="button" name="" value="" onclick="window.close();" class="buttonfooter"><img src="../recursos/OOFL.png" class="img-rounded" width="15" height="15"> SALIR</button>
                </div>
            </form>


        </div>
    </body>
</html>


