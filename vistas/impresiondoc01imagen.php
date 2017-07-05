<?php
$IDB = $_GET['IDB'];
$ID = $_GET['ID'];
$admin = $_GET['admin'];
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
        <script></script>
    </head>
    <body onload="cargaventadiaria();">
        <br>
        <div class="container">    
            <form class="form-inline" role="form" method="GET">
                <center>
                    <input class="hide" type="text" required="required" readonly="readonly" id="IDB" value=<?php echo $IDB; ?> />
                    <input class="hide" type="text" required="required" readonly="readonly" id="ID" value=<?php echo $ID; ?> />
                    <input class="hide" type="text" required="required" readonly="readonly" id="admin" value=<?php echo $admin; ?> />
                    <div class="form-group">
                        <select required="required" id="cb-tipo" class="form-control">
                            <option value="80">FACTURA</option>
                            <option value="22">NOTA DE CREDITO</option>
                        </select>                     
                    </div>
                    <div class="form-group">
                        <div class="input-group date" id="datedesde">
                            <input type="text" class="form-control" id="desde"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>                        
                    </div>
                    <div class="form-group">
                        <div class="input-group date" id="datehasta">
                            <input type="text" class="form-control" id="hasta"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>                        
                    </div>
                    <button type="button" class="btn btn-primary" id="bt-buscatipodoc">
                        <span class="glyphicon glyphicon-search"></span> Buscar
                    </button>                                                                 
                </center>
            </form>      
            <br>
            <div class="table-responsive" id="agrega-registros"></div>
        </div>        

    </body>
</html>