<?php
$IDB = $_GET['IDB'];
$ID = $_GET['ID'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $nombreb; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="../../../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../../../css/estilo.css">
        <script type="text/javascript" src="../../../js/jquery.js"></script>
        <script src="../../../js/bootstrap.min.js"></script>
        <link href="../../../css/bootstrap-datetimepicker.css" rel="stylesheet">     
        <script type="text/javascript" src="../../../js/jquery-1.8.0.min.js"></script>
        <script type="text/javascript" src="../../../js/moment.js"></script>
        <script src="../../../js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="../../../js/myjava.js"></script>
    </head>
    <body>
        <br>
        <div class="container">    
            <form class="form-inline" role="form" method="POST" id="subida">
                <center>
                    <input class="hide" type="text" required="required" readonly="readonly" id="IDB" value=<?php echo $IDB; ?> />
                    <input class="hide" type="text" required="required" readonly="readonly" id="ID" value=<?php echo $ID; ?> />                                        
                    <div class="form-group">
                        <select required="required" id="cb-bodega" class="form-control">
                            <option value="01">CDI</option>
                            <option value="03">JARDIN</option>
                            <option value="04">SOL</option>
                            <option value="05">CONDADO</option>
                            <option value="06">SCALA</option>
                            <option value="07">VILLAGE</option>
                            <option value="16">QUICENTRO</option>
                            <option value="15">SAN LUIS</option>
                            <option value="14">SAN MARINO</option>
                            <option value="13">CUMBAYA</option>
                        </select>                     
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control" id="fl-conteo" name="fl-conteo"/>
                    </div>
                    <button type="button" class="btn btn-success" id="subirconteo">
                        <span class="glyphicon glyphicon-upload"></span> Subir
                    </button>
                    <button type="button" class="btn btn-danger" id="procesaconteo" >
                        <span class="glyphicon glyphicon-cog"></span> Procesar
                    </button>
                </center>
            </form>
            <br>
            <div class="table-responsive" id="respuesta"></div>
        </div>

    </body>
</html>