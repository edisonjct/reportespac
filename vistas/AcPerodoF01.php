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
        <link href="../css/bootstrap-datetimepicker.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>        
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
        <script src="../js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="../js/myjava.js"></script>
        <script type="text/javascript">
            $(function () {
                
                $('#datetimepicker10').datetimepicker({
                    viewMode: 'years',
                    format: 'MM/YYYY'
                });
                
            });
        </script>
    </head>
    <body>
        <br>
        <div class="container">    
            <form class="form-inline" role="form" method="GET">
                <center>
                    <input class="hide" type="text" required="required" readonly="readonly" id="IDB" value=<?php echo $IDB; ?> />
                    <input class="hide" type="text" required="required" readonly="readonly" id="ID" value=<?php echo $ID; ?> />
                    <div class="form-group">
                        <label><b>PERIODO FISCAL </b></label>
                    </div>
                    <div class="form-group">
                        <div class="input-group date" id="datetimepicker10">
                            <input type="text" class="form-control" id="periodo" />
                            <span class="input-group-addon" id="calendario">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>                        
                    </div>
                    <button id="bt-periodofiscal" class="btn btn-warning">Guardar</button>                                               
                </center>
            </form>      
            <br>
            <div class="table-responsive" id="agrega-registros"></div>
        </div>        

    </body>
</html>