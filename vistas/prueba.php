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
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/bootstrap-select.css">        
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <link href="../css/bootstrap-datetimepicker.css" rel="stylesheet">  
        <script type="text/javascript" src="../js/jquery-1.12.4.min.js"></script>        
        <script type="text/javascript" src="../js/jquery.js"></script>             
        <script type="text/javascript" src="../js/bootstrap-select.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../js/moment.js"></script>        
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
                    
                    <button type="button" class="btn btn-group" onclick="pruebacheck()">
                        <span class="glyphicon glyphicon-search"></span> Buscar
                    </button>
                </center>
                <br>
                <div class="table-responsive" id="agrega-registros"></div>
            </form>            
        </div>  
    </body>            
</html>