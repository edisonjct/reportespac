<?php
include_once '../php/conexion.php';
$IDB = $_GET['IDB'];
$ID = $_GET['ID'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $nombreb; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="icon" type="image/png" href="../recursos/icono.ico">
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <link href="../css/bootstrap-datetimepicker.css" rel="stylesheet">
        <script type="text/javascript" src="../js/jquery-1.12.4.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="../js/myjava.js"></script>
    </head>
    <body>
        <div>
            <?php include_once './Header.php'; ?>
        </div>
        <div class="container">             
            <form class="form-inline" role="form" method="GET" id="formbusqueda">
                <center>
                    <input class="hide" type="text" required="required" readonly="readonly" id="IDB" value=<?php echo $IDB; ?> >
                    <input class="hide" type="text" required="required" readonly="readonly" id="ID" value=<?php echo $ID; ?> >
                    <div class="form-group">
                        <select id="cb-doc-electronicos" class="form-control" onchange="cargar_documentos_electronicos()">
                            <option value=''>SELECCIONE DOCUMENTOS</option>
                            <option value='01'>FACTURAS</option>
                            <option value='02'>NOTAS DE CREDITO</option>
                            <option value='03'>RETENCION</option>
                            <option value='04'>GUIAS DE REMISIÓN</option>
                        </select>
                    </div>                    
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" onclick="updatedocelectronicos()"><span class="glyphicon glyphicon-search"></span> Actualizar</button>
                    </div>
                    <div class="form-group" id="btn-procesa-script">
                        <button type="button" class="btn btn-danger" onclick="llamascriptactualizaautorizacion()"><span class="glyphicon glyphicon-search"></span>  Procesar</button>
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
    </body>            
</html>