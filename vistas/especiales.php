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
        <link rel="icon" type="image/png" href="../recursos/icono.ico"/>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/bootstrap-select.css">        
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">
        <script src="../js/jquery.js"></script>
        <script src="../js/myjava.js"></script>
        <script src="../js/bootstrap-select.js"></script> 
    </head>
    <body>
        <div>
            <?php include_once './Header.php'; ?>
        </div>
        <br>
        <div class="container">
            <form class="form-inline" role="form" method="GET">
                <center>
                    <input class="hide" type="text" required="required" readonly="readonly" id="IDB" name="IDB" value=<?php echo $IDB; ?> />
                    <div class="form-group" >                        
                        <select required="required" id="locales" name="locales" class="selectpicker" multiple data-actions-box="true" data-selected-text-format="count > 3" data-toggle="tooltip" title="Bodegas">
                            <?php
                            include_once '../php/conexionC.php';
                            $query = mysql_query("SELECT codtab,nomtab FROM maetab WHERE numtab = '97' AND ad4tab = '1' AND ad0tab != '' ORDER BY codtab ASC");
                            if (mysql_num_rows($query) > 0) {
                                while ($row = mysql_fetch_array($query)) {
                                    echo "<option value='" . $row['codtab'] . "'>" . $row['nomtab'] . "</option>\n";
                                }
                            }
                            ?>
                        </select>   
                    </div>
                    <div class="form-group">                        
                        <select class="form-control" id="operador" name="operador">
                            <option value="1">>=</option>
                            <option value="2">=</option>
                            <option value="3"><=</option>
                        </select>
                    </div>
                    <div class="form-group">                        
                        <input type="number" class="form-control" id="cantidad" name="cantidad" value="3">
                    </div>
                    <div class="form-group">
<!--                        <button id="proceso" class="btn btn-warning" name="proceso" value="mrbooks">Mr Books</button>-->
                    </div>
                    <div class="form-group">                        
                        <button id="crearvista" class="btn btn-danger" >Procesar</button>
                    </div>                         

                </center>
            </form>      
            <br>
            <div class="table-responsive" id="agrega-registros"></div>
        </div>
        <script src="../js/bootstrap.min.js"></script>
    </body>


    <footer>

    </footer>

</html>