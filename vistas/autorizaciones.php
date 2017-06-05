<?php
session_start();
//$_SESSION['UID'] = '1158';
if ($_SESSION['UID']) {
    include_once './Header.php';
    include '../php/conexion.php';
    $IDB = $_GET['IDB'];
    $ID = $_GET['ID'];
    $UID = $_SESSION['UID'];
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
            <script src="../js/jquery-1.12.4.min.js" type="text/javascript"></script>     
            <script src="../js/bootstrap.min.js"></script>
            <script type="text/javascript" src="../js/moment.js"></script>
            <script src="../js/bootstrap-datetimepicker.min.js"></script>
            <script type="text/javascript" src="../js/myjava.js"></script>
        </head>
        <br>
        <body>
            <div class="container">    
                <form class="form-inline" role="form" method="POST" id="subida">
                    <center>      
                        <input class="hide" type="text" required="required" readonly="readonly" id="IDB" value=<?php echo $IDB; ?> />
                        <input class="hide" type="text" required="required" readonly="readonly" id="UID" value=<?php echo $UID; ?> />
                        <div class="form-group">
                            <input type="file" id="autorizaciones" name="autorizaciones" class="btn btn-default"/>                      
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
                        <div class="form-group">                        
                            <button id="subirautorizaciones" class="btn btn-primary">Cargar</button>
                        </div>                                     
                    </center>
                </form>      
                <br>
            </div>
        <center>
            <div id="respuesta"></div>            
        </center>
        <script src="../js/bootstrap.min.js"></script>         
    </body>
    </html>

    <?php
} else {
    echo "No Se a Inicado Session";
}
