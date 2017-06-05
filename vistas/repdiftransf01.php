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
                        <select required="required" id="cb-bodega" class="form-control">
                            <?php
                            $query = mysql_query("select codtab,nomtab from mrbooks.maetab WHERE numtab = '97' and codtab <> '' ORDER BY nomtab ASC");
                            if (mysql_num_rows($query) > 0) {
                                while ($row = mysql_fetch_array($query)) {
                                    echo "<option value='" . $row['codtab'] . "'>" . $row['nomtab'] . "</option>\n";
                                }
                            }
                            ?> 
                        </select>                     
                    </div>
                    <div class="form-group">
                        <select required="required" id="cb-estado" class="form-control">
                            <option value="TD">Todos</option>
                            <option value="R">Procesado</option>
                            <option value="RR">Revisado</option>
                            <option value="T">Transito</option>
                            <option value="P">Parcial</option>
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
                    <button type="button" class="btn btn-primary" id="bt-buscadiftranf">
                        <span class="glyphicon glyphicon-search"></span> Buscar
                    </button>                                                                 
                </center>
            </form>      
            <br>
            <div class="table-responsive" id="agrega-registros"></div>
        </div>
        
    </body>
</html>