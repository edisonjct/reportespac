<?php
$cd = 2;
?>
<html>
    <head>
        
        <script type="text/javascript">
            function carga() {
                google.charts.load('current', {'packages': ['corechart']});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['cd', 'Ventas'],
                        ['Jardin', <?php echo $cd;?>],
                        ['Sol', 2],
                        ['Condado', 2],
                        ['Scala', 2],
                        ['Vilage', 7],
                    ]);

                    var options = {
                        title: 'Ventas'
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                    chart.draw(data, options);
                }
            }

        </script>
    </head>
    <body>
        <button onclick="carga()">GRAFICAR</button>
        <div id="piechart" style="width: 900px; height: 500px;"></div>
    </body>
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</html>