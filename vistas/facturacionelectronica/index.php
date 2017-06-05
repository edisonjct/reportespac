<!DOCTYPE html>
<html lang="en">
    <head>
        <title>MR BOOKS</title>
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

        <div class="container">
            <center> 
                <h3>FACTURACION ELECTRONICA</h3>
                <form class="form-inline" role="form" method="GET">
                    <div class="form-group">
                        <select class="form-control" id="cmb-bodegas">
                            <option value="">Bodega</option>
                            <option value="mrbooks">CDI</option>
                            <option value="mrbookcondado">CONDADO</option>
                        </select>                         
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="cmb-tipo">
                            <option value="">Tipo Documento</option>
                            <option value="FAC">FACTURAS</option>
                            <option value="NCR">NOTAS DE CREDITO</option>
                            <option value="RET">RETENCIONES</option>
                        </select> 
                    </div>
                    <div class="form-group">
                        <div class="input-group date" id="datedesde" >
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
                    <button type="button" class="btn btn-group" id="bt-busca-fac">
                        <span class="glyphicon glyphicon-search"></span> Buscar
                    </button>
                </form>      
                <hr>
                <div class="table-responsive" id="agrega-registros"></div>
            </center>
        </div>        
    </body>
</html>