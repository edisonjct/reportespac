/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    // nombres de tooltips 
    $('[data-toggle="tooltip"]').tooltip();

    //----------------------------------
    //focus en id


    //----------------------------------
    //eventos click

    //----------------------------------
    //eventos change

    // retorna las ventas diarias del controlador ventas diarias
    $('#btn-buscar-ventanacional').on('click', function () {
        var desde = $('#datedesde').val();
        var hasta = $('#datehasta').val();
        if (desde != '' && hasta != '') {
            $('#resultado-busqueda').html('<img src="../gerencia/img/cargar.gif" />');
            var url = '../gerencia/controlador/VentasControlador.php';
            $.ajax({
                type: 'POST',
                url: url,
                data: 'desde=' + desde + '&hasta=' + hasta,
                success: function (datos) {
                    $('#resultado-busqueda').html(datos);
                }
            });
            return false;
        } else {
            alert("Ingrese Parametros de Busqueda");
            return false;
        }
    });
    
    $('#btn-buscar-fac').on('click', function () {
        var desde = $('#datedesde').val();
        var hasta = $('#datehasta').val();
        if (desde != '' && hasta != '') {
            $('#resultado-busqueda').html('<img src="../gerencia/img/cargar.gif" />');
            var url = '../gerencia/controlador/VentasControlador.php';
            $.ajax({
                type: 'POST',
                url: url,
                data: 'desde=' + desde + '&hasta=' + hasta,
                success: function (datos) {
                    $('#resultado-busqueda').html(datos);
                }
            });
            return false;
        } else {
            alert("Ingrese Parametros de Busqueda");
            return false;
        }
    });

    //----------------------------------
    //eventos move

    //----------------------------------

});



function mostrargraficoventasBarras() {
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

            var Datos = {
                labels: ['CD', 'JARDIN', 'SOL', 'CONDADO', 'SCALA', 'VILLAGE', 'QUCENTRO', 'SAN.LUIS', 'SAN.MARINO', 'CUMBAYA', 'WEB', 'EVENTOS'],
                datasets: [
                    {
                        fillColor: 'rgba(91,228,146,0.6)', //COLOR DE LAS BARRAS
                        strokeColor: 'rgba(57,194,112,0.7)', //COLOR DEL BORDE DE LAS BARRAS
                        highlightFill: 'rgba(73,206,180,0.6)', //COLOR "HOVER" DE LAS BARRAS
                        highlightStroke: 'rgba(66,196,157,0.7)', //COLOR "HOVER" DEL BORDE DE LAS BARRAS
                        data: [cd, jr, sl, cn, sc, vl, qc, sls, slm, cm, wb, ev]
                    }
                ]
            };
            var contexto = document.getElementById('grafico').getContext('2d');
            window.Barra = new Chart(contexto).Bar(Datos, {responsive: true});
        }
    });
    return false;
}

