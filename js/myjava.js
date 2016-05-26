$(document).ready();
$(function () {
    $('#bt-creditosemp').on('click', function () {
        var desde = $('#bd-desde').val();
        var hasta = $('#bd-hasta').val();
        var IDB = $('#IDB').val();
        var condicion = $('#cb-condicion').val();
        $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
        var url = '../php/BuscaFacturas.php';
        $.ajax({
            type: 'GET',
            url: url,
            data: 'desde=' + desde + '&hasta=' + hasta + '&IDB=' + IDB + '&condicion=' + condicion,
            success: function (datos) {
                $('#agrega-registros').html(datos);
            }
        });
        return false;
    });

    $('#bt-campmm').on('click', function () {
        var desde = $('#bd-desde').val();
        var hasta = $('#bd-hasta').val();
        var IDB = $('#IDB').val();
        var ID = $('#ID').val();
        var condicion = $('#cb-condicion').val();
        $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
        var url = '../php/BuscaFacturasCampmm.php';
        $.ajax({
            type: 'GET',
            url: url,
            data: 'desde=' + desde + '&hasta=' + hasta + '&IDB=' + IDB + '&condicion=' + condicion + '&ID=' + ID,
            success: function (datos) {
                $('#agrega-registros').html(datos);
            }
        });
        return false;
    });

    $('#bt-campmmADM').on('click', function () {
        var desde = $('#bd-desde').val();
        var hasta = $('#bd-hasta').val();
        var IDB = $('#IDB').val();
        var condicion = $('#cb-condicion').val();
        $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
        var url = '../php/BuscaFacturasCampmmADM.php';
        $.ajax({
            type: 'GET',
            url: url,
            data: 'desde=' + desde + '&hasta=' + hasta + '&IDB=' + IDB + '&condicion=' + condicion,
            success: function (datos) {
                $('#agrega-registros').html(datos);
            }
        });
        return false;
    });

    $('#bt-RepCatPGS').on('click', function () {
        var IDB = $('#IDB').val();
        var clientes = $('#cb-clientesgs').val();
        $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
        var url = '../php/BuscarProGraSup.php';
        $.ajax({
            type: 'GET',
            url: url,
            data: 'IDB=' + IDB + '&clientes=' + clientes,
            success: function (datos) {
                $('#agrega-registros').html(datos);
            }
        });
        return false;
    });

    $("#cb-clientesgs").change(function () {
        $.ajax({
            url: "../php/procesaclientesgs.php",
            type: "GET",
            data: "idcliente=" + $("#cb-clientesgs").val(),
            success: function (opciones) {
                $("#categoriags").html(opciones);
            }
        })
    });

    $('#submit').on('click', function () {
        var comprobar = $('#csv').val().length;
        var IDB = $('#IDB').val();
        if (comprobar > 0) {
            var formulario = $('#subida');
            var archivos = new FormData();
            var url = '../php/importarCSV.php?IDB='+IDB;
            for (var i = 0; i < (formulario.find('input[type=file]').length); i++) {
                archivos.append((formulario.find('input[type="file"]:eq(' + i + ')').attr("name")), ((formulario.find('input[type="file"]:eq(' + i + ')')[0]).files[0]));
            }
            $.ajax({
                url: url,
                type: 'POST',
                contentType: false,
                data: archivos,
                processData: false,
                beforeSend: function () {
                    $('#respuesta').html('<center><img src="../recursos/cargando2.gif" width="100"></center>');
                },
                success: function (data) {
                    if (data == 'OK') {
                        $('#respuesta').html(data);
                        return false;
                    } else {
                        $('#respuesta').html(data);
                        return false;
                    }
                }
            });

            return false;

        } else {

            alert('Selecciona un archivo CSV para importar');

            return false;

        }
    });



});


function reporteF() {
    var desde = $('#bd-desde').val();
    var hasta = $('#bd-hasta').val();
    var IDB = $('#IDB').val();
    var condicion = $('#cb-condicion').val();
    window.location.href = '../php/ExcelFacturas.php?desde=' + desde + '&hasta=' + hasta + '&IDB=' + IDB + '&condicion=' + condicion;
}

function agregaRegistro() {
    var url = '../php/EditarProGraSup.php';
    $.ajax({
        type: 'GET',
        url: url,
        data: $('#formulario').serialize(),
        success: function (registro) {
            if ($('#pro').val() == 'Registro') {
                $('#formulario')[0].reset();
                $('#mensaje').addClass('bien').html('Registro completado con exito').show(200).delay(2500).hide(200);
                $('#agrega-registros').html(registro);
                return false;
            } else {
                $('#mensaje').addClass('bien').html('Modificacion completada con exito').show(200).delay(2500).hide(200);
                $('#agrega-registros').html(registro);
                return false;
            }
        }
    });
    return false;
}

function eliminarProducto(codpro, codcte) {
    var url = '../php/EliminarProGraSup.php';
    var pregunta = confirm('¿Esta seguro de eliminar este Producto Categorizado?');
    if (pregunta == true) {
        $.ajax({
            type: 'GET',
            url: url,
            data: 'codpro=' + codpro + '&codcte=' + codcte,
            success: function (registro) {
                $('#agrega-registros').html(registro);
                return false;
            }
        });
        return false;
    } else {
        return false;
    }
}

function editarProducto(codprod, codcte) {
    $('#formulario')[0].reset();
    var url = '../php/MostrarProGraSup.php';
    $.ajax({
        type: 'GET',
        url: url,
        data: 'codprod=' + codprod + '&codcte=' + codcte,
        success: function (valores) {
            var datos = eval(valores);
            $('#reg').hide();
            $('#edi').show();
            $('#pro').val('Edicion');
            $('#cod').val(codprod);
            $('#cliente').val(datos[0]);
            $('#codigo').val(datos[1]);
            $('#titulo').val(datos[2]);
            $('#categoria').val(datos[3]);
            $('#categoriags').val(datos[4]);
            $('#autor').val(datos[5]);
            $('#editorial').val(datos[6]);
            $('#provedor').val(datos[7]);
            $('#registra-producto').modal({
                show: true,
                backdrop: 'static'
            });
            return false;
        }
    });
    return false;
}


function confirmation() {
    var imprimir = confirm("ESTA SEGURO DE IMPRIMIR ?")
    if (imprimir) {
        var objeto = document.getElementById('imprimeme');  //obtenemos el objeto a imprimir
        var ventana = window.open('', '_blank');  //abrimos una ventana vacía nueva
        ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
        ventana.document.close();  //cerramos el documento
        ventana.print();  //imprimimos la ventana
        ventana.close();  //cerramos la ventana	 
        window.close();
    } else {
        alert("SE CANCELO LA IMPRESION")
        window.close();
    }
}