<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MR BOOKS</title>

        <!-- CSS de Bootstrap -->
        <link href="../../css/bootstrap.min.css" rel="stylesheet" media="screen">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            function mostrargraficoventas() {
                var desde = $('#datedesde').val();
                var hasta = $('#datehasta').val();
                $.ajax({
                    type: 'POST',
                    url: 'controlador/VentasGraficoControlador.php',
                    data: 'desde=' + desde + '&hasta=' + hasta,
                    success: function (data) {

                        var valores = eval(data);
                        var cd = valores[0];
                        var jr = valores[1];
                        var sl = valores[2];
                        var cn = valores[3];
                        var sc = valores[4];
                        var vl = valores[5];
                        var qc = valores[6];
                        var sls = valores[7];
                        var slm = valores[8];
                        var cm = valores[9];
                        var wb = valores[10];
                        var ev = valores[11];
                        var pieDatos = [
                            {
                                value: 30,
                                color: "#F38630",
                                label: 'Sleep',
                                labelColor: 'white',
                                labelFontSize: '16'
                            },
                            {
                                value: 40,
                                color: "#4ACAB4"
                            },
                            {
                                value: 10,
                                color: "#FF8153"
                            },
                            {
                                value: 30,
                                color: "#FFEA88"
                            }
                        ];


                        var contexto = document.getElementById('grafico').getContext('2d');
                        window.Barra = new Chart(contexto).Pie(pieDatos, {responsive: true});
                    }
                });
                return false;
            }
        </script>
        <!-- librerías opcionales que activan el soporte de HTML5 para IE8 -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php include 'menu.php'; ?>
        <h3><div align="center">VENTA NACIONAL DIARIA</div></h3>
        <div class="container">
            <div align="center">
                <form class="form-inline" role="form" method="GET">
                    <div class="form-group">
                        <input type="date" class="form-control" id="datedesde" data-toggle="tooltip" title="Fecha Inicio">
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control" id="datehasta" data-toggle="tooltip" title="Fecha Fin">
                    </div>
                    <div class="form-group">
                        <button type="date" class="btn btn-default" onclick="mostrargraficoventas()" id="btn-buscar-ventanacional" data-toggle="tooltip" title="Buscar Ventas Nacional">
                            <span class="glyphicon glyphicon-search"></span> BUSCAR
                        </button>
                    </div>
                </form>
                <div id="resultado-busqueda"></div><br>
                <div id="grafico-busqueda"><canvas id="grafico"></canvas></div>
            </div>                        
        </div>

        <!-- Librería jQuery requerida por los plugins de JavaScript -->
        <script type="text/javascript" src="../../js/jquery.js"></script>
        <script type="text/javascript" src="../../js/Chart.min.js"></script>

        <script type="text/javascript" src="../../js/funciones.js"></script>
        <!-- Todos los plugins JavaScript de Bootstrap (también puedes
             incluir archivos JavaScript individuales de los únicos
             plugins que utilices) -->
        <script type="text/javascript" src="../../js/bootstrap.min.js"></script>

    </body>
</html>