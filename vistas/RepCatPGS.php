<?php
include_once '../php/conexion.php';
$IDB = $_GET['IDB'];
$UID = $_GET['UID'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $nombreb; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <script type="text/javascript" src="../js/jquery.js"></script>   

<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="../bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="../bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/bootstrap.js"></script>

        
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/bootstrap-select.css">        
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>        
                   
        <script type="text/javascript" src="../js/myjava.js"></script>
        <script type="text/javascript" src="../js/bootstrap-select.js"></script>
    </head>
    <div>
        <?php include_once './Header.php';?>
    </div>
    <body>
        <object type="text/html" data="RepCatPGS01.php?IDB=<?php echo $IDB;?>&UID=<?php echo $UID;?>" width="100%" height="620"></object>        
    </body>
    <footer>
        
    </footer>
</html>