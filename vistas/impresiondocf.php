<?php
include_once '../php/conexion.php';
$IDB = $_GET['IDB'];
$ID = $_GET['ID'];
$admin = $_GET['a'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $nombreb . 'REIMPRESION DE FACTURAS/NOTAS DE CREDITO'; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">         
        <link rel="icon" type="image/png" href="../recursos/icono.ico"/>     
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">        
    </head>
    <div>
        <?php include_once './Header.php';?>
    </div>
    <body>
        <object type="text/html" data="impresiondoc01f.php?IDB=<?php echo $IDB;?>&ID=<?php echo $ID;?>&admin=<?php echo $admin;?>" width="100%" height="580"></object>        
    </body>
    <footer>
        
    </footer>
</html>