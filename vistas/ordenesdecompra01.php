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
        <link href="../css/bootstrap-datetimepicker.css" rel="stylesheet">             
        <script src="../js/jquery-1.12.4.min.js" type="text/javascript"></script>     
        <script src="../js/bootstrap.min.js"></script>
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
                        <select required="required" id="cb-tipo-provedor" class="form-control" data-toggle="tooltip" onchange="selectinternacional()">
                            <option value="todos">Selecione Tipo Provedor</option>
                            <?php
                            $query = mysql_query("select codtab as codigo,nomtab as nombre from maetab WHERE numtab = '69' and codtab IN ('0001','0002','0003')");
                            if (mysql_num_rows($query) > 0) {
                                while ($row = mysql_fetch_array($query)) {
                                    echo "<option value='" . $row['codigo'] . "'>" . $row['nombre'] . "</option>\n";
                                }
                            }
                            ?>                                                                    
                        </select>                 
                    </div>                    
                    <div id="select-provedor-nacional">   
                        <br>
                        <input type="text" class="form-control" id="txt-provedor-nacional" placeholder="Buscar Provedor"/>
                        <input type="hidden" class="form-control" id="txt-provedor-nacional-codigo"/>
                        <div id="resultado-provedor"></div>                        
                    </div>                                      
                    <div class="form-group" id="select-provedor-internacional">
                        <select id="cb-importacion" class="form-control" data-toggle="tooltip" onchange="selectimportacion()">
                                                                                            
                        </select> 
                    </div>
                    <div class="" id="select-ordenes-general">
                        <br>
                        <select multiple id="select-ordenes" size="8" class="form-control" data-toggle="tooltip"></select> 
                    </div>
                    <div class="" id="procesa-ordenes">
                        <br>
                        <div class="form-group">
                            <button id="procesar-ordenes-compras" type="button" class="btn btn-default" value="CONSOLIDADO"><span class="glyphicon glyphicon-list-alt"></span> CONSOLIDADO</button>                            
                        </div>
                        <div class="form-group">
                            <button id="procesar-compras-detallado" type="button" class="btn btn-default" value="DETALLADO"><span class="glyphicon glyphicon-list"></span> DETALLADO</button>
                        </div>
                        <div class="form-group">
                            <a data-toggle="tooltip" id="excelordenesconsolidado" title="Exportar a Excel" target="_blank" href="javascript:excelordenesconsolidado();"><button type="button" id="excel-consolidado" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> EXCEL</button></a>
                            <a data-toggle="tooltip" id="excelordenesdetallado" title="Exportar a Excel" target="_blank" href="javascript:excelordenesdetallado();"><button type="button" id="exceldetallado" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> EXCEL</button></a>
                        </div> 
                    </div>
                </center>
                <br>
                <div id="agrega-registros"></div>            
            </form>
        </div>                
    </body>
</html>


