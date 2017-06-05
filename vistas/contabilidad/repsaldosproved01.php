<?php
$IDB = $_GET['IDB'];
$ID = $_GET['ID'];
include_once '../../php/conexion.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $nombreb; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/bootstrap-select.css">        
        <link rel="stylesheet" type="text/css" href="../../css/estilo.css">
        <link href="../../css/bootstrap-datetimepicker.css" rel="stylesheet">  
        <script type="text/javascript" src="../../js/jquery-1.12.4.min.js"></script>        
        <script type="text/javascript" src="../../js/jquery.js"></script>     
        
        <script type="text/javascript" src="../../js/bootstrap-select.js"></script>
        <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../../js/moment.js"></script>        
        <script src="../../js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="../../js/myjava.js"></script>
        
    </head>
    <body>
        <br>
        <div class="container">    
            <form class="form-inline" role="form" method="GET">
                <center>
                    <input class="hide" type="text" required="required" readonly="readonly" id="IDB" value=<?php echo $IDB; ?> />
                    <input class="hide" type="text" required="required" readonly="readonly" id="ID" value=<?php echo $ID; ?> />
                    <div class="form-group">
                        <select required="required" id="cb-provedor" class="selectpicker" multiple data-actions-box="true" data-live-search="true" data-selected-text-format="count > 1" title="Provedores">
                            <?php
                            $query = mysql_query("select codcte01,nomcte01 from maepag ORDER BY tipcte01,nomcte01");
                            if (mysql_num_rows($query) > 0) {
                                while ($row = mysql_fetch_array($query)) {
                                    echo "<option value='" . $row['codcte01'] . "'>" . $row['nomcte01'] . "</option>\n";
                                }
                            }
                            ?>                                                                    
                        </select>                
                    </div>
                    <div class="form-group">
                        <div class="input-group date" id="datedesde" >
                            <input type="text" class="form-control" id="desde" data-toggle="tooltip" title="Fecha Inicio"/>
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
                    <button type="button" class="btn btn-group" id="bt-buscasaldoproved">
                        <span class="glyphicon glyphicon-search"></span> Buscar
                    </button>                                                               
                </center>
            </form>      
            <br>
            <div class="table-responsive" id="agrega-registros"></div>
        </div>        

    </body>
</html>