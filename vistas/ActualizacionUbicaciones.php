<?php
include '../php/conexion.php';
$IDB = $_GET['IDB'];
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
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script type="text/javascript" src="../js/jquery.js"></script>              
        <script type="text/javascript" src="../js/myjava.js"></script>
        <script type="text/javascript" src="../js/bootstrap-select.js"></script>
        
    </head>
    <body>
        <div class="container">    
            <form class="form-inline" role="form" method="POST" id="subida">
                <center>      
                    <h2><?php echo $nombreb; ?></h2>
                    <input class="hide" type="text" required="required" readonly="readonly" id="IDB" value=<?php echo $IDB; ?> />
                    <div class="form-group">                        
                        <input type="file" id="csv" name="csv" class="btn btn-default"/>                      
                    </div> 
                    <div class="form-group">                        
                        <input id="submit" type="submit" value="Importar" class="btn btn-primary"/>                      
                    </div> 
                    <div class="form-group">                        
                        <input id="submit" type="procesar" value="Procesar" class="btn btn-danger"/>                      
                    </div>
                    <button onclick="window.close();" class="btn btn-warning">Salir</button>                    
                </center>
            </form>      
            <br>
            <center>
            <div class="table-responsive" id="respuesta"></div>
            <div class="table-responsive" id="agrega-registros"></div>
            </center>
        </div>        
        <script src="../js/bootstrap.min.js"></script>
         
    </body>
</html>