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
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <link href="../css/bootstrap-datetimepicker.css" rel="stylesheet">  
        <script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
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
                        <input type="text" class="form-control" id="txt-provedor-consignado" placeholder="Buscar Provedor"/>
                        <input type="hidden" class="form-control" id="txt-provedor-consignado-codigo"/>
                        <div id="resultado-provedor-consignado"></div>                        
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="bt-busca-doc-consignado">
                            <span class="glyphicon glyphicon-search"></span> Buscar
                        </button>                                                                 
                    </div>

                </center>
            </form>      
            <br>
            <div class="table-responsive" id="agrega-registros"></div>
        </div>

    </body>
</html>