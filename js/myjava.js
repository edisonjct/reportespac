$(document).ready();
$(function () {
    $('#bs-prod').focus();
    setInterval(function () {
        $('#bs-prod').focus();
    }, 9000);
    $("#select-provedor-internacional").hide();
    $("#select-provedor-nacional").hide();
    $("#select-ordenes").hide();
    $("#radio-tipo").hide();
    $("#procesa-ordenes").hide();
    $("#excelordenesconsolidado").hide();
    $("#excelordenesdetallado").hide();
    $("#btn-procesa-script").hide();
    $('#bt-buscadiftranf').on('click', function () {
        var ID = $('#ID').val();
        var IDB = $('#IDB').val();
        var estado = $('#cb-estado').val();
        var bodega = $('#cb-bodega').val();
        var desde = $('#desde').val();
        var hasta = $('#hasta').val();
        if (estado != '' && desde != '' && hasta != '') {
            $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
            var url = '../php/repdiftransf02.php';
            $.ajax({
                type: 'GET',
                url: url,
                data: 'ID=' + ID + '&IDB=' + IDB + '&estado=' + estado + '&desde=' + desde + '&hasta=' + hasta + '&bodega=' + bodega,
                success: function (datos) {
                    $('#agrega-registros').html(datos);
                }
            });
            return false;
        } else {
            alert("Ingrese Parametros de Busqueda");
            return false;
        }
    });
    $('#bt-busca-doc-consignado').on('click', function () {
        var IDB = $('#IDB').val();
        var provedor = $('#txt-provedor-consignado-codigo').val();
        if (provedor != '') {
            $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
            var url = '../php/repdoccon02.php';
            $.ajax({
                type: 'GET',
                url: url,
                data: 'proceso=buscardocumentos&IDB=' + IDB + '&provedor=' + provedor,
                success: function (datos) {
                    $('#agrega-registros').html(datos);
                }
            });
            return false;
        } else {
            alert("Ingrese Parametros de Busqueda");
            return false;
        }
    });
    $('#bt-buscatipodoc').on('click', function () {
        var ID = $('#ID').val();
        var IDB = $('#IDB').val();
        var tipo = $('#cb-tipo').val();
        var desde = $('#desde').val();
        var hasta = $('#hasta').val();
        var admin = $('#admin').val();
        if (tipo != '' && desde != '' && hasta != '') {
            if (admin == 'S') {
                $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
                var url = '../php/impresiondoc99.php';
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: 'ID=' + ID + '&IDB=' + IDB + '&tipo=' + tipo + '&desde=' + desde + '&hasta=' + hasta,
                    success: function (datos) {
                        $('#agrega-registros').html(datos);
                    }
                });
                return false;
            } else {
                $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
                var url = '../php/impresiondoc02.php';
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: 'ID=' + ID + '&IDB=' + IDB + '&tipo=' + tipo + '&desde=' + desde + '&hasta=' + hasta,
                    success: function (datos) {
                        $('#agrega-registros').html(datos);
                    }
                });
                return false;
            }
        } else {
            alert("Ingrese Parametros de Busqueda");
            return false;
        }
    });
    $('#bt-buscatipodocf').on('click', function () {
        var ID = $('#ID').val();
        var IDB = $('#IDB').val();
        var tipo = $('#cb-tipo').val();
        var desde = $('#desde').val();
        var hasta = $('#hasta').val();
        var admin = $('#admin').val();
        if (tipo != '' && desde != '' && hasta != '') {
            if (admin == 'S') {
                $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
                var url = '../php/impresiondoc99f.php';
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: 'ID=' + ID + '&IDB=' + IDB + '&tipo=' + tipo + '&desde=' + desde + '&hasta=' + hasta,
                    success: function (datos) {
                        $('#agrega-registros').html(datos);
                    }
                });
                return false;
            } else if (admin == 'imagen') {
                $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
                var url = '../php/impresiondoc99.php';
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: 'ID=' + ID + '&IDB=' + IDB + '&tipo=' + tipo + '&desde=' + desde + '&hasta=' + hasta,
                    success: function (datos) {
                        $('#agrega-registros').html(datos);
                    }
                });
                return false;
            } else {
                $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
                var url = '../php/impresiondoc02f.php';
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: 'ID=' + ID + '&IDB=' + IDB + '&tipo=' + tipo + '&desde=' + desde + '&hasta=' + hasta,
                    success: function (datos) {
                        $('#agrega-registros').html(datos);
                    }
                });
                return false;
            }
        } else {
            alert("Ingrese Parametros de Busqueda");
            return false;
        }
    });
    $('#bt-buscasaldoproved').on('click', function () {
        var ID = $('#ID').val();
        var IDB = $('#IDB').val();
        var desde = $('#desde').val();
        var hasta = $('#hasta').val();
        var provedor = $('#cb-provedor').val();
        if (provedor != null) {
            $('#agrega-registros').html('<h2><div align="center"><img src="../../recursos/cargando2.gif" width="100" /><div></h2>');
            var url = '../../php/contabilidad/repsaldosproved02.php';
            $.ajax({
                type: 'POST',
                url: url,
                data: 'provedor=' + provedor + '&desde=' + desde + '&hasta=' + hasta + '&ID=' + ID + '&IDB=' + IDB,
                success: function (datos) {
                    $('#agrega-registros').html(datos);
                }
            });
            return false;
        } else {
            alert("Seleccione uno o varios provedores");
            return false;
        }
    });
    $('#bt-busca-fac').on('click', function () {
        var tipo = $('#cmb-tipo').val();
        var bodega = $('#cmb-bodegas').val();
        var desde = $('#desde').val();
        var hasta = $('#hasta').val();
        var url = '../../vistas/facturacionelectronica/controlador/FacturasElectronicasControlador.php';
        if (tipo != '') {
            $('#agrega-registros').html('<h2><div align="center"><img src="../../recursos/cargando2.gif" width="100" /><div></h2>');
            $.ajax({
                type: 'GET',
                url: url,
                data: 'tipo=' + tipo + '&bodega=' + bodega + '&desde=' + desde + '&hasta=' + hasta,
                success: function (datos) {
                    $('#agrega-registros').html(datos);
                }
            });
            return false;
        } else {
            alert("SELECCIONE OPCIONES DE BUSQUEDA");
            return false;
        }
    });
    $('#bt-buscaactivosf').on('click', function () {
        var ID = $('#ID').val();
        var IDB = $('#IDB').val();
        var ubicacion = $('#cb-ubicacion').val();
        var desde = $('#desde').val();
        var hasta = $('#hasta').val();
        var grupo = $('#cb-grupo').val();
        if (ubicacion != '' && desde != '' && hasta != '') {
            $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
            var url = '../php/repactf02.php';
            $.ajax({
                type: 'GET',
                url: url,
                data: 'ID=' + ID + '&IDB=' + IDB + '&ubicacion=' + ubicacion + '&desde=' + desde + '&hasta=' + hasta + '&grupo=' + grupo,
                success: function (datos) {
                    $('#agrega-registros').html(datos);
                }
            });
            return false;
        } else {
            alert("Ingrese Parametros de Busqueda");
            return false;
        }
    });
    $('#procesafpagos').on('click', function () {
        var desde = $('#desde').val();
        var hasta = $('#hasta').val();
        var IDB = $('#IDB').val();
        $('#agrega-registros3').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
        var url = '../php/repformpag02.php';
        $.ajax({
            type: 'GET',
            url: url,
            data: 'IDB=' + IDB + '&desde=' + desde + '&hasta=' + hasta,
            success: function (datos) {
                $('#agrega-registros3').html(datos);
            }
        });
        return false;
    });
    $('#procesafpagosadm').on('click', function () {
        var desde = $('#desde').val();
        var IDB = $('#IDB').val();
        $('#agrega-registros4').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
        var url = '../php/repformpagadm02.php';
        $.ajax({
            type: 'GET',
            url: url,
            data: 'IDB=' + IDB + '&desde=' + desde,
            success: function (datos) {
                $('#agrega-registros4').html(datos);
            }
        });
        return false;
    });
    $('#gt_trancito').on('click', function () {
        var result = confirm('Esta Seguro De Guardar los Cambios');
        if (result == false) {
            return false;
        } else {
            var IDB = $('#IDB').val();
            var transf = $('#transf').val();
            $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
            var url = '../php/repdiftransf03.php';
            $.ajax({
                type: 'GET',
                url: url,
                data: 'IDB=' + IDB + '&transf=' + transf + '&estado=02',
                success: function (datos) {
                    $('#agrega-registros').html(datos);
                }
            });
            return false;
        }
    });
    $('#bt-periodofiscal').on('click', function () {
        var ID = $('#ID').val();
        var IDB = $('#IDB').val();
        var periodo = $('#periodo').val();
        if (periodo != '') {
            var result = confirm('Esta Seguro De Guardar los Cambios');
            if (result == false) {
                return false;
            } else {
                $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
                var url = '../php/Acperodof02.php';
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: 'ID=' + ID + '&IDB=' + IDB + '&periodo=' + periodo,
                    success: function (datos) {
                        $('#agrega-registros').html(datos);
                    }
                });
                return false;
            }
        } else {
            alert("Ingrese Fecha Del Periodo Fiscal");
            $('#calendario').click();
            return false;
        }
    });
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
        var desde = $('#desde').val();
        var hasta = $('#hasta').val();
        var IDB = $('#IDB').val();
        var ID = $('#ID').val();
        var condicion = $('#cb-condicion').val();
        if (condicion != null) {
            $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
            var url = '../php/buscafacturascampmm.php';
            $.ajax({
                type: 'GET',
                url: url,
                data: 'desde=' + desde + '&hasta=' + hasta + '&IDB=' + IDB + '&condicion=' + condicion + '&ID=' + ID,
                success: function (datos) {
                    $('#agrega-registros').html(datos);
                }
            });
            return false;
        } else {
            alert('Selecione una Condicion de Pago');
            return false;
        }
    });
    $('#bt-campana_mama').on('click', function () {
        var desde = $('#desde').val();
        var hasta = $('#hasta').val();
        var IDB = $('#IDB').val();
        var ID = $('#ID').val();
        $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
        var url = '../php/controladorCampanas.php';
        $.ajax({
            type: 'GET',
            url: url,
            data: 'proceso=diamadre2017&desde=' + desde + '&hasta=' + hasta + '&IDB=' + IDB + '&ID=' + ID,
            success: function (datos) {
                $('#agrega-registros').html(datos);
            }
        });
        return false;
    });
    $('#crearvista').on('click', function () {
        var locales = $('#locales').val();
        var operador = $('#operador').val();
        var IDB = $('#IDB').val();
        var cantidad = $('#cantidad').val();
        if (locales != null) {
            $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
            var url = '../php/excelespeciales.php?proceso=vista';
            $.ajax({
                type: 'GET',
                url: url,
                data: 'locales=' + locales + '&operador=' + operador + '&IDB=' + IDB + '&cantidad=' + cantidad,
                success: function (datos) {
                    $('#agrega-registros').html(datos);
                }
            });
            return false;
        } else {
            alert("Seleccione las bodegas a general");
        }
    });
    $('#bt-buscaproductosinv').on('click', function () {
        var ID = $('#ID').val();
        var IDB = $('#IDB').val();
        var codigo = $('#bs-prod').val();
        if (codigo != '') {
            $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
            var url = '../php/BuscaProductos.php';
            $.ajax({
                type: 'GET',
                url: url,
                data: 'ID=' + ID + '&IDB=' + IDB + '&codigo=' + codigo,
                success: function (datos) {
                    $('#agrega-registros').html(datos);
                    $('#bs-prod').focus();
                    $('#bs-prod').val('');
                }
            });
            return false;
        } else {
            alert("Ingrese Parametros de Busqueda");
            $('#bs-prod').focus();
            $('#bs-prod').val('');
            $('#bs-titulo').val('');
            return false;
        }
    });
    $('#bt-recargar').on('click', function () {
        location.reload();
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
            var url = '../php/importarCSV.php?IDB=' + IDB;
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
    $('#crearubicaciones').on('click', function () {
        var comprobar = $('#ubicaciones').val().length;
        var IDB = $('#IDB').val();
        if (comprobar > 0) {
            var formulario = $('#subida');
            var archivos = new FormData();
            var url = '../php/importarubicaciones.php?IDB=' + IDB;
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
    $('#subirautorizaciones').on('click', function () {
        var comprobar = $('#autorizaciones').val().length;
        var IDB = $('#IDB').val();
        var UID = $('#UID').val();
        var desde = $('#desde').val();
        var hasta = $('#hasta').val();
        if (comprobar > 0) {
            var formulario = $('#subida');
            var archivos = new FormData();
            var url = '../php/autorizaciones.php?IDB=' + IDB + '&UID=' + UID + '&desde=' + desde + '&hasta=' + hasta;
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
    $('#subirconteo').on('click', function () {
        var comprobar = $('#fl-conteo').val().length;
        var bodega = $('#cb-bodega').val();
        if (comprobar > 0) {
            var formulario = $('#subida');
            var archivos = new FormData();
            var url = '../controlador/ConteoControlador.php?bodega=' + bodega;
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
                    $('#respuesta').html('<center><img src="../../../recursos/cargando2.gif" width="100"></center>');
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
    $('#nuevo-proforma').on('click', function () {
        $('#formulario')[0].reset();
        $('#pro').val('Registro');
        $('#cedula').val();
        $('#reg').show();
        $('#registra-proformas').modal({
            show: true,
            backdrop: 'static'
        });
    });
    $('#buscar_proformas').on('click', function () {
        var cedula = $('#cedula-cli').val();
        var proforma = $('#proforma-cli').val();
        var IDB = $('#IDB').val();
        $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
        var url = '../php/buscar_proformas.php';
        $.ajax({
            type: 'GET',
            url: url,
            data: 'cedula=' + cedula + '&proforma=' + proforma + '&IDB=' + IDB,
            success: function (datos) {
                $('#agrega-registros').html(datos);
            }
        });
        return false;
    });
    $("#btnExport").click(function (e) {
        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#printableArea').html()));
        e.preventDefault();
    });
    $('#codigo-proforma').focus();
    $('#agregar-codigo-proforma').on('click', function () {
        var IDB = $('#IDB').val();
        var proforma = $('#proforma').val();
        var idpro = $('#idpro').val();
        var cantidad = $('#cantiad-proforma').val();
        var codigo = $('#codigo-proforma').val();
        var descuento = '0';
        var proceso = '0';
        if (codigo == '') {
            alert("Ingrese Un Codigo");
            $('#codigo-proforma').focus();
            return false;
        } else {
            if (cantidad != 1) {
                var pregunta = confirm('¿Esta seguro de ingresar Cantidad ' + cantidad + '?');
                if (pregunta == true) {
                    $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
                    var url = '../php/agrega_proforma_detalle01.php';
                    $.ajax({
                        type: 'GET',
                        url: url,
                        data: 'IDB=' + IDB + '&codigo=' + codigo + '&descuento=' + descuento + '&cantidad=' + cantidad + '&idpro=' + idpro + '&proforma=' + proforma + '&proceso=' + proceso,
                        success: function (datos) {
                            $('#agrega-detalle-proformas').html(datos);
                            $('#codigo-proforma').focus();
                            $('#codigo-proforma').val('');
                            $('#cantiad-proforma').val('1');
                            $('#descuento-proforma').val('0');
                        }
                    });
                    return false;
                } else {
                    $('#codigo-proforma').focus();
                    $('#cantiad-proforma').val('1');
                    $('#descuento-proforma').val('0');
                    return false;
                }
            } else {
                $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
                var url = '../php/agrega_proforma_detalle01.php';
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: 'IDB=' + IDB + '&codigo=' + codigo + '&descuento=' + descuento + '&cantidad=' + cantidad + '&idpro=' + idpro + '&proforma=' + proforma + '&proceso=' + proceso,
                    success: function (datos) {
                        $('#agrega-detalle-proformas').html(datos);
                        $('#codigo-proforma').focus();
                        $('#codigo-proforma').val('');
                        $('#cantiad-proforma').val('1');
                        $('#descuento-proforma').val('0');
                    }
                });
                return false;
            }
        }
        return false;
    });
    $("#cb-tipo-provedor").change(function () {
        var tipo = $("#cb-tipo-provedor").val();
        if (tipo == '0001') {
            $("#select-provedor-internacional").show();
            $("#select-provedor-nacional").hide();
            $("#select-ordenes").hide();
            $("#radio-tipo").hide();
            $("#procesa-ordenes").hide();
            return false;
        } else {
            $("#select-provedor-nacional").show();
            $("#select-provedor-internacional").hide();
            $("#txt-provedor-nacional").val('');
            $("#txt-provedor-nacional").focus();
            $("#select-ordenes").hide();
            $("#radio-tipo").hide();
            $("#procesa-ordenes").hide();
            return false;
        }
        return false;
    });
    $("#txt-provedor-nacional").keyup(function () {
        var IDB = $('#IDB').val();
        var tipo = $('#cb-tipo-provedor').val();
        var key = $('#txt-provedor-nacional').val();
        $.ajax({
            type: "GET",
            url: "../php/buscarprovedor.php",
            data: 'keyword=' + key + '&IDB=' + IDB + '&tipo=' + tipo,
            beforeSend: function () {
                $("#txt-provedor-nacional").css("background", "#FFF url(../recursos/LoaderIcon.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#resultado-provedor").show();
                $("#resultado-provedor").html(data);
                $("#txt-provedor-nacional").css("background", "#FFF");
                $("#radio-tipo").hide();
                $("#procesa-ordenes").hide();
            }
        });
    });
    $("#txt-provedor-consignado").keyup(function () {
        var IDB = $('#IDB').val();
        var provedor = $('#txt-provedor-consignado').val();
        $.ajax({
            type: "GET",
            url: "../php/repdoccon02.php?proceso=buscarprovedor",
            data: 'provedor=' + provedor + '&IDB=' + IDB,
            beforeSend: function () {
                $("#txt-provedor-consignado").css("background", "#FFF url(../recursos/LoaderIcon.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#resultado-provedor-consignado").show();
                $("#resultado-provedor-consignado").html(data);
                $("#txt-provedor-consignado").css("background", "#FFF");
                $("#radio-tipo").hide();
                $("#procesa-ordenes").hide();
            }
        });
    });
    $('#select-ordenes-general').on('click', function () {
        $("#radio-tipo").show();
        $("#procesa-ordenes").show();
        $("#excelordenesconsolidado").hide();
        $("#excelordenesdetallado").hide();
    });
    $('#procesar-ordenes-compras').on('click', function () {
        var IDB = $('#IDB').val();
        var ordenes = $('#select-ordenes').val();
        var tipo = $('#cb-tipo-provedor').val();
        var op = $('#procesar-ordenes-compras').val();
        $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
        $.ajax({
            url: '../php/procesaordenes_1.php?op=1',
            type: 'GET',
            data: 'IDB=' + IDB + '&ordenes=' + ordenes + '&tipo=' + tipo + '&opcion=' + op,
            success: function (datos) {
                $('#agrega-registros').html(datos);
                $("#excelordenesconsolidado").show();
                $("#excelordenesdetallado").hide();
            }
        });
    });
    $('#procesar-compras-detallado').on('click', function () {
        var IDB = $('#IDB').val();
        var ordenes = $('#select-ordenes').val();
        var tipo = $('#cb-tipo-provedor').val();
        $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
        $.ajax({
            url: '../php/procesaordenes_1.php?op=2',
            type: 'GET',
            data: 'IDB=' + IDB + '&ordenes=' + ordenes + '&tipo=' + tipo,
            success: function (datos) {
                $('#agrega-registros').html(datos);
                $("#excelordenesconsolidado").hide();
                $("#excelordenesdetallado").show();
            }
        });
    });
    $("#btnExport-proformas").click(function (e) {
        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#printableArea').html()));
        e.preventDefault();
    });
    $('#datedesde').datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: new Date()
    });
    $('#datehasta').datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: new Date()
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
                $('#mensaje').addClass('bien').html('Edicion completada con exito').show(200).delay(2500).hide(200);
                $('#agrega-registros').html(registro);
                return false;
            }
        }
    });
    return false;
}

function agregaProformas() {
    var url = '../php/agregar_proformas.php';
    $.ajax({
        type: 'GET',
        url: url,
        data: $('#formulario').serialize(),
        success: function (registro) {
            $('#formulario')[0].reset();
            $('#mensaje').addClass('bien').html('Proforma Ingresada con exito').show(200).delay(2500).hide(200);
            $('#agrega-registros').html(registro);
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

function eliminarProforma(pro, cedu) {
    var IDB = $('#IDB').val();
    var url = '../php/eliminaproforma.php';
    var pregunta = confirm('¿Esta seguro de eliminar esta Proforma?');
    if (pregunta == true) {
        $.ajax({
            type: 'GET',
            url: url,
            data: 'cedula=' + cedu + '&proforma=' + pro + '&IDB=' + IDB + '&proceso=cabecera',
            success: function (datos) {
                $('#agrega-registros').html(datos);
            }
        });
        return false;
    } else {
        return false;
    }
    return false;
}

function eliminarProductoProforma(pro, codigo) {
    var IDB = $('#IDB').val();
    var url = '../php/eliminaproforma.php';
    var pregunta = confirm('¿Esta seguro de eliminar este Producto de la Proforma?');
    if (pregunta == true) {
        $.ajax({
            type: 'GET',
            url: url,
            data: 'codigo=' + codigo + '&proforma=' + pro + '&IDB=' + IDB + '&proceso=detalle',
            success: function (datos) {
                $('#agrega-detalle-proformas').html(datos);
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

function editarProductoinv(codigo, IDB, ID) {
    $('#formulario')[0].reset();
    var url = '../php/MostrarProInv.php';
    $.ajax({
        type: 'GET',
        url: url,
        data: 'codigo=' + codigo + '&IDB=' + IDB + '&ID=' + ID,
        success: function (valores) {
            var datos = eval(valores);
            $('#reg').hide();
            $('#edi').show();
            $('#pro').val('Edicion');
            $('#cod').val(codigo);
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
        var objeto = document.getElementById('imprimeme'); //obtenemos el objeto a imprimir
        var ventana = window.open('', '_blank'); //abrimos una ventana vacía nueva
        ventana.document.write(objeto.innerHTML); //imprimimos el HTML del objeto en la nueva ventana
        ventana.document.close(); //cerramos el documento
        ventana.print(); //imprimimos la ventana
        ventana.close(); //cerramos la ventana   
        window.close();
    } else {
        alert("SE CANCELO LA IMPRESION")
        window.close();
    }
}

function cargaproformas() {
    var IDB = $('#IDB').val();
    var proforma = $('#proforma').val();
    var idpro = $('#idpro').val();
    var cantidad = $('#cantiad-proforma').val();
    var codigo = $('#codigo-proforma').val();
    var descuento = $('#descuento-proforma').val();
    var proceso = '1';
    $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
    var url = '../php/agrega_proforma_detalle01.php';
    $.ajax({
        type: 'GET',
        url: url,
        data: 'IDB=' + IDB + '&codigo=' + codigo + '&descuento=' + descuento + '&cantidad=' + cantidad + '&idpro=' + idpro + '&proforma=' + proforma + '&proceso=' + proceso,
        success: function (datos) {
            $('#agrega-detalle-proformas').html(datos);
            $('#codigo-proforma').focus();
            $('#codigo-proforma').val('');
            $('#cantiad-proforma').val('1');
            $('#descuento-proforma').val('0');
        }
    });
    return false;
}

function cargaventadiaria() {
    var ID = $('#ID').val();
    var IDB = $('#IDB').val();
    var tipo = $('#cb-tipo').val();
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    var admin = $('#admin').val();
    if (tipo != '' && desde != '' && hasta != '') {
        if (admin == 'S') {
            $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
            var url = '../php/impresiondoc99.php';
            $.ajax({
                type: 'GET',
                url: url,
                data: 'ID=' + ID + '&IDB=' + IDB + '&tipo=' + tipo + '&desde=' + desde + '&hasta=' + hasta,
                success: function (datos) {
                    $('#agrega-registros').html(datos);
                }
            });
            return false;
        } else {
            $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
            var url = '../php/impresiondoc02.php';
            $.ajax({
                type: 'GET',
                url: url,
                data: 'ID=' + ID + '&IDB=' + IDB + '&tipo=' + tipo + '&desde=' + desde + '&hasta=' + hasta,
                success: function (datos) {
                    $('#agrega-registros').html(datos);
                }
            });
            return false;
        }
    } else {
        alert("Ingrese Parametros de Busqueda");
        return false;
    }
}

function cargaventadiariaf() {
    var ID = $('#ID').val();
    var IDB = $('#IDB').val();
    var tipo = $('#cb-tipo').val();
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    var admin = $('#admin').val();
    if (tipo != '' && desde != '' && hasta != '') {
        if (admin == 'S') {
            $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
            var url = '../php/impresiondoc99f.php';
            $.ajax({
                type: 'GET',
                url: url,
                data: 'ID=' + ID + '&IDB=' + IDB + '&tipo=' + tipo + '&desde=' + desde + '&hasta=' + hasta,
                success: function (datos) {
                    $('#agrega-registros').html(datos);
                }
            });
            return false;
        } else if (admin == 'imagen') {
            $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
            var url = '../php/impresiondoc99.php';
            $.ajax({
                type: 'GET',
                url: url,
                data: 'ID=' + ID + '&IDB=' + IDB + '&tipo=' + tipo + '&desde=' + desde + '&hasta=' + hasta,
                success: function (datos) {
                    $('#agrega-registros').html(datos);
                }
            });
            return false;
        } else {
            $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
            var url = '../php/impresiondoc02f.php';
            $.ajax({
                type: 'GET',
                url: url,
                data: 'ID=' + ID + '&IDB=' + IDB + '&tipo=' + tipo + '&desde=' + desde + '&hasta=' + hasta,
                success: function (datos) {
                    $('#agrega-registros').html(datos);
                }
            });
            return false;
        }
    } else {
        alert("Ingrese Parametros de Busqueda");
        return false;
    }
}

function excelactf() {
    var ID = $('#ID').val();
    var IDB = $('#IDB').val();
    var ubicacion = $('#cb-ubicacion').val();
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    var grupo = $('#cb-grupo').val();
    window.location.href = '../php/repactf03.php?ID=' + ID + '&IDB=' + IDB + '&ubicacion=' + ubicacion + '&desde=' + desde + '&hasta=' + hasta + '&grupo=' + grupo;
}

function excelordenesconsolidado() {
    var IDB = $('#IDB').val();
    var ordenes = $('#select-ordenes').val();
    var tipo = $('#cb-tipo-provedor').val();
    window.location.href = '../php/procesaordenesexls.php?op=1&IDB=' + IDB + '&ordenes=' + ordenes + '&tipo=' + tipo;
}

function excelordenesdetallado() {
    var IDB = $('#IDB').val();
    var ordenes = $('#select-ordenes').val();
    var tipo = $('#cb-tipo-provedor').val();
    window.location.href = '../php/procesaordenesexls.php?op=2&IDB=' + IDB + '&ordenes=' + ordenes + '&tipo=' + tipo;
}

function printDiv(divName) {
    $('#botones-proforma').hide();
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    $('#botones-proforma').show();
}

function selectprovedor(nombre, codigo) {
    $("#txt-provedor-nacional").val(nombre);
    $("#txt-provedor-nacional-codigo").val(codigo);
    $("#resultado-provedor").hide();
    $("#select-ordenes").show();
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    var IDB = $('#IDB').val();
    var imp = $("#cb-importacion").val();
    $.ajax({
        url: "../php/procesaordenes.php?idpro=1",
        type: "GET",
        data: "provedor=" + $("#txt-provedor-nacional-codigo").val() + '&IDB=' + IDB + '&imp=' + imp + '&desde=' + desde + '&hasta=' + hasta,
        success: function (opciones) {
            $("#select-ordenes").html(opciones);
        }
    });
}

function selectprovedorconsignado(nombre, codigo) {
    $("#txt-provedor-consignado").val(nombre);
    $("#txt-provedor-consignado-codigo").val(codigo);
    $("#resultado-provedor-consignado").hide();
}

function selectimportacion() {
    var IDB = $('#IDB').val();
    var imp = $("#cb-importacion").val();
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    $("#select-ordenes").show();
    $.ajax({
        url: "../php/procesaordenes.php?idpro=2",
        type: "GET",
        data: "provedor=" + $("#txt-provedor-nacional-codigo").val() + '&IDB=' + IDB + '&imp=' + imp + '&desde=' + desde + '&hasta=' + hasta,
        success: function (opciones) {
            $("#select-ordenes").html(opciones);
        }
    });
}

function selectinternacional() {
    var IDB = $('#IDB').val();
    var imp = $("#cb-importacion").val();
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    $("#select-ordenes").show();
    $.ajax({
        url: "../php/procesaordenes.php?idpro=3",
        type: "GET",
        data: "provedor=" + $("#txt-provedor-nacional-codigo").val() + '&IDB=' + IDB + '&imp=' + imp + '&desde=' + desde + '&hasta=' + hasta,
        success: function (opciones) {
            $("#cb-importacion").html(opciones);
        }
    });
}

function cargar_documentos_electronicos() {
    var IDB = $('#IDB').val();
    var tipo = $('#cb-doc-electronicos').val();
    $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
    $.ajax({
        url: '../php/procesa_docelectronicos.php?proceso=02',
        type: 'GET',
        data: 'IDB=' + IDB + '&tipo=' + tipo,
        success: function (datos) {
            $('#agrega-registros').html(datos);
        }
    });
    return false;
}

function updatedocelectronicos() {
    var IDB = $('#IDB').val();
    var tipo = $('#cb-doc-electronicos').val();
    if (tipo != '') {
        $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
        $.ajax({
            url: '../php/procesa_docelectronicos.php?proceso=01',
            type: 'GET',
            data: 'IDB=' + IDB + '&tipo=' + tipo,
            success: function (datos) {
                $('#agrega-registros').html(datos);
                $("#btn-procesa-script").show();
            }
        });
        return false;
    } else {
        alert("Selecione el Tipo de Documento Electronico");
        return false;
    }
}

function llamascriptactualizaautorizacion() {
    var IDB = $('#IDB').val();
    var tipo = $('#cb-doc-electronicos').val();
    if (tipo != '') {
        $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
        $.ajax({
            url: '../../../FTP/php/download_ajax.php',
            type: 'GET',
            data: 'IDB=' + IDB + '&ID=1088&manual=1',
            success: function (datos) {
                $('#agrega-registros').html(datos);
            }
        });
        return false;
    } else {
        alert("Selecione el Tipo de Documento Electronico");
        return false;
    }
}

function bt_carga_documentos_electronicos() {
    var IDB = $('#IDB').val();
    var tipo = $('#cb-doc-electronicos').val();
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    if (tipo != '') {
        $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
        $.ajax({
            url: '../php/repdocfacelec01.php',
            type: 'GET',
            data: 'IDB=' + IDB + '&tipo=' + tipo + '&desde=' + desde + '&hasta=' + hasta,
            success: function (datos) {
                $('#agrega-registros').html(datos);
            }
        });
        return false;
    } else {
        alert('Seleccione el tipo de documento');
    }
}

function imprimircupon(factura, cupon, IDB) {
    var opciones = 'width=320,height=250,scrollbars=NO';
    window.open('../php/imprimir.php?factura=' + factura + '&cupon=' + cupon + '&IDB=' + IDB, 'cupon', opciones);
}

function recargarcampana() {
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    var IDB = $('#IDB').val();
    var ID = $('#ID').val();
    //$('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
    var url = '../php/controladorCampanas.php';
    $.ajax({
        type: 'GET',
        url: url,
        data: 'proceso=diamadre2017&desde=' + desde + '&hasta=' + hasta + '&IDB=' + IDB + '&ID=' + ID,
        success: function (datos) {
            $('#agrega-registros').html(datos);
        }
    });
    return false;
}

function refresh() {
    location.reload(true);
}

function eliminarfp(codtmp, fp) {
    alert(fp);
}

function eliminarfp2() {
    alert("2");
}