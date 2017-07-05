/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    $('#txt-cedula-cliente').focus();
    $("#formulario").submit(function () {
        return false;
    });
    $('#detalleproductos').hide();
    $('#contacto-detalle').hide();
    $('#formasdepago').hide();
    carga_secuencual();
    // $("#txt-cedula-cliente").keypress(function(e) {
    //     //13 es el código de la tecla
    //     // if (e.which == 113) {
    //     //     alert('Has pulsado F2!');
    //     // }
    //     alert("Pulsaste la tecla con código: " + e.which);
    // });
    // $("#txt-cedula-cliente").keypress(function(e) {
    //     e.preventDefault();
    //     $("#respuesta").html(e.which + ": " + String.fromCharCode(e.which));
    // });
    var ctrlPressed = true;
    var teclaCtrl = 113,
            teclaC = 113;
    $(document).keydown(function (e) {
        if (e.keyCode == teclaCtrl) {
            ctrlPressed = true;
        }
        if (ctrlPressed && (e.keyCode == teclaC)) {
            $('#txt-cedula-cliente').val('9999999999');
            $('#txt-cliente').val('CONSUMIDOR FINAL');
            $('#txt-direccion').val('QUITO');
            $('#txt-telefono').val('2811065')
            $('#txt-correo').val('fe@mrbooks.com');
            $('#detalleproductos').show();
            $('#txt-codigo').focus();
        }
    });
});
/* PARA PAC DESDE AQUI */
function agregaritemtmp() {
    var codigo = $('#txt-codigo').val();
    var IDB = $('#IDB').val();
    var UID = $('#UID').val();
    var codtemp = $('#rando').val();
    var documento = $('#txt-ultimo-doc').val();
    var cantidad = 1;
    if (codigo != '') {
        $('#detalleagregado').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
        var url = '../php/controladorContratodeventa.php';
        $.ajax({
            type: 'GET',
            url: url,
            data: 'proceso=agregaritem&IDB=' + IDB + '&UID=' + UID + '&codigo=' + codigo + '&codtemp=' + codtemp + '&documento=' + documento + '&cantidad=' + cantidad + '&ID=1108',
            success: function (datos) {
                $('#detalleagregado').html(datos);
                $('#txt-codigo').val('');
                $('#txt-codigo').focus();
            }
        });
        return false;
    } else {
        alert("Ingrese Parametros de Busqueda");
        return false;
    }
    return false;
}

function buscar_clientes() {
    var cedula = $('#txt-cedula-cliente').val();
    var UID = $('#UID').val();
    if (cedula != '') {
        $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
        var url = '../php/controladorContratodeventa.php';
        $.ajax({
            type: 'GET',
            url: url,
            data: 'proceso=buscar_cliente&IDB=01&cedula=' + cedula + '&ID=1088&UID=' + UID,
            success: function (datos) {
                $('#respuesta').html(datos);
                if (cedula.length == 13) {
                    $('#contacto-detalle').show();
                    $('#detalleproductos').show();
                    $('#txt-contacto-cedula').focus();
                } else {
                    $('#detalleproductos').show();
                    $('#txt-codigo').focus();
                }
            }
        });
        return false;
    } else {
        alert("Ingrese Parametros de Busqueda");
        return false;
    }
    return false;
}

function limpiardatos() {
    $('#txt-cedula-cliente').val('');
    $('#txt-cliente').val('');
    $('#txt-direccion').val('');
    $('#txt-telefono').val('')
    $('#txt-codigo').val('');
    $('#txt-cedula-cliente').focus();
    return false;
}

function abrir(url) {
    open(url, '', 'top=200,left=450,width=600,height=300');
}

function carga_secuencual() {
    //alert("aqui estoy desde funcion");
    var IDB = $('#IDB').val();
    var UID = $('#UID').val();
    //alert("aqui");
    var url = '../php/controladorContratodeventa.php';
    $.ajax({
        type: 'GET',
        url: url,
        data: 'proceso=secuencual&IDB=' + IDB + '&ID=1088&UID=' + UID,
        success: function (datos) {
            $('#ultimodocumento').text(datos);
        }
    });
    return false;
}

function eliminaritem(ocurrencia, cod_tmp, codigo, documento) {
    //alert(cod_tmp);
    var IDB = $('#IDB').val();
    var UID = $('#UID').val();
    $('#detalleagregado').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
    var url = '../php/controladorContratodeventa.php';
    $.ajax({
        type: 'GET',
        url: url,
        data: 'proceso=eliminaritem&IDB=' + IDB + '&ID=1088&UID=' + UID + '&ocurrencia=' + ocurrencia + '&cod_tmp=' + cod_tmp + '&codigo=' + codigo + '&documento=' + documento,
        success: function (datos) {
            $('#detalleagregado').html(datos);
            $('#txt-codigo').val('');
            $('#txt-cantidad').val('1');
            $('#txt-codigo').focus();
        }
    });
    return false;
}

function cambiarcantidad(cantidad, ocurrencia, cod_tmp, documento) {
    //alert(cantidad);
    var IDB = $('#IDB').val();
    var UID = $('#UID').val();
    $('#detalleagregado').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
    var url = '../php/controladorContratodeventa.php';
    $.ajax({
        type: 'GET',
        url: url,
        data: 'proceso=modificaritem&IDB=' + IDB + '&ID=1088&UID=' + UID + '&ocurrencia=' + ocurrencia + '&cod_tmp=' + cod_tmp + '&documento=' + documento + '&cantidad=' + cantidad,
        success: function (datos) {
            $('#detalleagregado').html(datos);
            $('#txt-codigo').val('');
            $('#txt-cantidad').val('1');
            $('#txt-codigo').focus();
        }
    });
    return false;
}

function eliminarultimalinea() {
    //$("#txt-cant").prop('disabled', true);
    $('[id*=txt-cant]').prop('disabled', true);
    $('#detallenuevo').hide();
    $('#formasdepago').show();
    //alert("ocultar div");
}

function agregarlinea() {
    $('[id*=txt-cant]').prop('disabled', false);
    $('#detallenuevo').show();
    $('#txt-codigo').val('');
    $('#txt-codigo').focus();
    $('#formasdepago').hide();
}

function validateMail(correo) {
    //Creamos un objeto 
    object = document.getElementById(correo);
    valueForm = object.value;
    // Patron para el correo
    var patron = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
    if (valueForm.search(patron) == 0) {
        //Mail correcto
        object.style.color = "#000";
        return;
    }
    //Mail incorrecto
    object.style.color = "#f00";
}

function addformadepago() {
    var IDB = $('#IDB').val();
    var UID = $('#UID').val();
    var codtemp = $('#rando').val();
    var documento = $('#txt-ultimo-doc').val();
    var url = '../php/controladorContratodeventa.php';
    $.ajax({
        type: 'GET',
        url: url,
        data: 'proceso=addformadepago&IDB=' + IDB + '&ID=1088&UID=' + UID + '&codtemp=' + codtemp + '&documento=' + documento,
        success: function (datos) {
            $('#detalleformadepago').html(datos);
        }
    });
    return false;
}

function agregarlineafp() {
    var totalfp = $('#txt-total').val();
    var totald = $('#txt-total-productos').val();
    // alert("detalle:" + totald);
    // alert("formas dp:" + totalfp);
    if (totald == totalfp) {
        alert("El pago esta completo");
    } else {
        var IDB = $('#IDB').val();
        var UID = $('#UID').val();
        var codtemp = $('#rando').val();
        var documento = $('#txt-ultimo-doc').val();
        var fp = $('#tipoformadepago').val();
        var valor = $('#txt-total').val();
        var url = '../php/controladorContratodeventa.php';
        $.ajax({
            type: 'GET',
            url: url,
            data: 'proceso=addformadepago2&IDB=' + IDB + '&ID=1088&UID=' + UID + '&codtemp=' + codtemp + '&documento=' + documento + '&fp=' + fp + '&valor=' + valor,
            success: function (datos) {
                $('#detalleformadepago').html(datos);
            }
        });
        return false;
    }
    // if (totald == totalfp) {
    //     alert("El pago esta completo");
    // } else {
    //     var IDB = $('#IDB').val();
    //     var UID = $('#UID').val();
    //     var codtemp = $('#rando').val();
    //     var documento = $('#txt-ultimo-doc').val();
    //     var fp = $('#tipoformadepago').val();
    //     var valor = $('#txt-total').val();
    //     var url = '../php/controladorContratodeventa.php';
    //     $.ajax({
    //         type: 'GET',
    //         url: url,
    //         data: 'proceso=addformadepago2&IDB=' + IDB + '&ID=1088&UID=' + UID + '&codtemp=' + codtemp + '&documento=' + documento + '&fp=' + fp + '&valor=' + valor,
    //         success: function(datos) {
    //             $('#detalleformadepago').html(datos);
    //         }
    //     });
    //     return false;
    // }
    return false;
}

function validamayor() {
    var totalfp = $('#txt-total').val();
    var totald = $('#txt-total-productos').val();
    if (parseInt(totald) < parseInt(totalfp)) {
        alert("No puede Ingresar Valor Mayor a Pagar");
        $('#txt-total').val(totald);
    }
}
function eliminarfp(codtemp, fp) {
    var IDB = $('#IDB').val();
    var UID = $('#UID').val();
    var documento = $('#txt-ultimo-doc').val();
    var url = '../php/controladorContratodeventa.php';
    $.ajax({
        type: 'GET',
        url: url,
        data: 'proceso=eliminafp&IDB=' + IDB + '&ID=1088&UID=' + UID + '&codtemp=' + codtemp + '&fp=' + fp + '&documento=' + documento,
        success: function (datos) {
            $('#detalleformadepago').html(datos);
        }
    });
    return false;
}

function generarfactura() {
    var IDB = $('#IDB').val();
    var UID = $('#UID').val();
    var codtemp = $('#rando').val();
    var documento = $('#txt-ultimo-doc').val();
    var fp = $('#tipoformadepago').val();
    var valor = $('#txt-total').val();
    var vendedor = $('#cmb-vendedores').val();
    var cedula = $('#txt-cedula-cliente').val();
    var totalfp = $('#txt-total').val();
    var totald = $('#txt-total-productos').val();
    var cedulacontacto = $('#txt-contacto-cedula').val();
    var nombrecontacto = $('#txt-contacto-nombre').val();
    var telefonocontacto = $('#txt-contacto-telefono').val();
    var correocontacto = $('#txt-contacto-correo').val();
    if (parseInt(totald) === parseInt(totalfp)) {
        var opciones = 'width=1000,height=650,scrollbars=NO';
        window.open('../php/controladorContratodeventa.php?proceso=generarfactura&IDB=' + IDB + '&UID=' + UID + '&ID=1108&codtemp=' + codtemp + '&cedula=' + cedula + '&vendedor=' + vendedor + '&cedulacontacto=' + cedulacontacto + '&nombrecontacto=' + nombrecontacto + '&telefonocontacto=' + telefonocontacto + '&correocontacto=' + correocontacto + '&fp=' + fp + '&documento=' + documento + '&valor=' + valor, 'factura', opciones);
        location.reload();
    } else {
        alert("Los Valores a facturar no coinsiden");
    }



}

function cargarcontratos() {
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    var IDB = $('#IDB').val();
    var UID = $('#UID').val();
    $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
    var url = '../php/controladorContratodeventa.php';
    $.ajax({
        type: 'GET',
        url: url,
        data: 'proceso=cargarcontratos&IDB=' + IDB + '&ID=1088&UID=' + UID + '&desde=' + desde + '&hasta=' + hasta,
        success: function (datos) {
            $('#agrega-registros').html(datos);
        }
    });
    return false;
}

function abrirasignacion(documento) {
    var IDB = $('#IDB').val();
    var UID = $('#UID').val();
    $('#agrega-registros').html('<h2><div align="center"><img src="../recursos/cargando2.gif" width="100" /><div></h2>');
    var url = '../php/controladorContratodeventa.php';
    $.ajax({
        type: 'GET',
        url: url,
        data: 'proceso=abrirasignacion&IDB=' + IDB + '&ID=1088&UID=' + UID + '&documento=' + documento,
        success: function (datos) {
            $('#agrega-registros').html(datos);
        }
    });
    return false;
}

