
<html lang="en">

    <head>
        <title>DIFERENCIAS EN TRASNFERENCIAS</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/estilo.css">     
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../js/myjava.js"></script>
    </head>
    <div>
        <?php include_once '../vistas/Header.php'; ?>
    </div>
    <body>  
        <?php
        include('conexion.php');
        $IDB = $_GET['IDB'];
        $transf = $_GET['transf'];
        $estado = $_GET['estado'];

        $queryc = "SELECT
                    m.numero_transferencia AS transferencia,
                    m.fecha_egreso AS fechae,
                    m.fecha_recepcion AS fechar,
                    case when m.estado = 'T' THEN 'TRANSITO' when m.estado = 'R' THEN 'PROCESADO' when m.estado = 'RR' THEN 'REVISADO' when m.estado = 'P' THEN 'PARCIAL' end  as estado
                    FROM
                    mrbooks.mercaderia_en_transito AS m
                    WHERE m.numero_transferencia = '$transf'
                    GROUP BY m.numero_transferencia";
        $querytegreso = "SELECT movpro.NOCOMP03 FROM movpro WHERE numero_transferencia_egreso = '$transf' AND TIPOTRA03 = '11'";
        $resulttegreso = mysql_query($querytegreso);
        $rowte = mysql_fetch_array($resulttegreso);
        $resultc = mysql_query($queryc);
        $rowc = mysql_fetch_array($resultc);
        echo '<table id="listaF">
            <tbody>            
                <th colspan="13"><div align="center">REPORTE DE DIFERENCIAS</div></th>
                <tr>
                  <th colspan="3">NUMERO TRANSFERENCIA</th>
                  <td colspan="3">' . $rowc['transferencia'] . '</td>
                  <th colspan="3">FECHA TRANSFERENCIA</th>
                  <td colspan="4">' . $rowc['fechae'] . '</td>               
                </tr>';
        if (mysql_num_rows($resulttegreso) > 0) {
            echo '<tr>
                  <th class="danger" colspan="3">NUMERO TRANSFERENCIA DE EGRESO</th>
                  <td class="danger" colspan="10">' . $rowte['NOCOMP03'] . '</td>                           
                </tr>';
        }
        echo '<tr>
                  <th colspan="3">ESTADO</th>
                  <td colspan="3">' . $rowc['estado'] . '</td>
                  <th colspan="3">FECHA RECEPCION</th>
                  <td colspan="4">' . $rowc['fechar'] . '</td>               
                </tr>
                <tr>
                  <th colspan="3">OBSERVACION GENERAL</th>
                  <td colspan="9"><input type="text" id="observacion_general" name="observacion_general" class="form-control"></td>
                  <p ng-bind="name"></p>
                  <td colspan="1"><button type="button" class="btn btn-default">Copiar</button></td>
                </tr>
                <tr>
                  <th><div align="center">#</div></th>          
                  <th><div align="center">CODIGO</div></th>
                  <th><div align="center">TITULO</div></th>
                  <th><div align="center">CATEGORIA</div></th>
                  <th><div align="center">EDITORIAL</div></th>
                  <th><div align="center">PROVEEDOR</div></th>
                  <th><div align="center">FORMATO</div></th>
                  <th><div align="center">IDIOMA</div></th>
                  <th><div align="center">COSTO</div></th>
                  <th><div align="center">ENVIADO</div></th>
                  <th><div align="center">SALDO</div></th>
                  <th><div align="center">DIFERENCIA</div></th>
                  <th><div align="center">OBSERVACION</div></th>  
                </tr>';
        $queryd = "SELECT
                m.codigo_barras AS codigo,
                m.nombre_producto AS titulo,
                c.desccate AS categoria,
                editoriales.razon AS editorial,
                maepag.nomcte01 AS provedor,
                MRB_FORMATOS.nombre AS formato,
                MRB_IDIOMAS.nombre AS idioma,
                m.valor_transferencia AS costo,
                m.cantidad_enviada as enviado,
                m.saldo_cantidad as saldo,
                m.diferencia_cantidad as diferencia,
                m.observacion as observacion
                FROM
                mrbooks.mercaderia_en_transito AS m
                LEFT JOIN mrbooks.maepro ON m.codigo_barras = maepro.codbar01
                LEFT JOIN mrbooks.categorias AS c ON maepro.catprod01 = c.codcate
                LEFT JOIN mrbooks.editoriales ON maepro.infor02 = editoriales.codigo
                LEFT JOIN mrbooks.maepag ON maepro.proved101 = maepag.codcte01
                LEFT JOIN mrbooks.MRB_FORMATOS ON maepro.infor06 = MRB_FORMATOS.codigo
                LEFT JOIN mrbooks.MRB_IDIOMAS ON maepro.infor03 = MRB_IDIOMAS.codigo
                WHERE
                m.numero_transferencia = '$transf' AND c.tipocate = '02'
                ";
        $resultd = mysql_query($queryd);
        $contador = 0;
        $costo = 0;
        $enviado = 0;
        $saldo = 0;
        $diferencia = 0;
        if (mysql_num_rows($resultd) > 0) {
            while ($rowd = mysql_fetch_array($resultd)) {
                $contador = $contador + 1;
                $costo = $costo + $rowd['costo'];
                $enviado = $enviado + $rowd['enviado'];
                $saldo = $saldo + $rowd['saldo'];
                $diferencia = $diferencia + $rowd['diferencia'];
                if ($rowd['diferencia'] == '0') {
                    echo '<tr>
                            <td id="td_id2" style="display:none;">' . $transf . '</td>
                            <td bgcolor="#cef7a7"><div align="center">' . $contador . '</div></td>
                            <td id="td_id" bgcolor="#cef7a7"><div align="center">' . $rowd['codigo'] . '</div></td>
                            <td bgcolor="#cef7a7"><div align="center">' . $rowd['titulo'] . '</div></td>
                            <td bgcolor="#cef7a7"><div align="center">' . $rowd['categoria'] . '</div></td>
                            <td bgcolor="#cef7a7"><div align="center">' . $rowd['editorial'] . '</div></td>
                            <td bgcolor="#cef7a7"><div align="center">' . $rowd['provedor'] . '</div></td>
                            <td bgcolor="#cef7a7"><div align="center">' . $rowd['formato'] . '</div></td>
                            <td bgcolor="#cef7a7"><div align="center">' . $rowd['idioma'] . '</div></td>
                            <td bgcolor="#cef7a7"><div align="center">' . $rowd['costo'] . '</div></td>
                            <td bgcolor="#cef7a7"><div align="center">' . number_format($rowd['enviado'], 0, '.', ',') . '</div></td>
                            <td bgcolor="#cef7a7"><div align="center">' . number_format($rowd['saldo'], 0, '.', ',') . '</div></td>
                            <td bgcolor="#cef7a7"><div align="center">' . $rowd['diferencia'] . '</div></td>
                            <td id="descr" bgcolor="#cef7a7"><input type="text" value="' . $rowd['observacion'] . '" id="obser" name="observacion"></td>';
                    //echo '<script>alert(' . $contador . ');</script>';
                } else {
                    echo '<tr>
                            <td id="td_id2" style="display:none;">' . $transf . '</td>
                            <td bgcolor="#bd9f9f"><div align="center">' . $contador . '</div></td>
                            <td id="td_id" bgcolor="#bd9f9f"><div align="center">' . $rowd['codigo'] . '</div></td>
                            <td bgcolor="#bd9f9f"><div align="center">' . $rowd['titulo'] . '</div></td>
                            <td bgcolor="#bd9f9f"><div align="center">' . $rowd['categoria'] . '</div></td>
                            <td bgcolor="#bd9f9f"><div align="center">' . $rowd['editorial'] . '</div></td>
                            <td bgcolor="#bd9f9f"><div align="center">' . $rowd['provedor'] . '</div></td>
                            <td bgcolor="#bd9f9f"><div align="center">' . $rowd['formato'] . '</div></td>
                            <td bgcolor="#bd9f9f"><div align="center">' . $rowd['idioma'] . '</div></td>
                            <td bgcolor="#bd9f9f"><div align="center">' . $rowd['costo'] . '</div></td>
                            <td bgcolor="#bd9f9f"><div align="center">' . number_format($rowd['enviado'], 0, '.', ',') . '</div></td>
                            <td bgcolor="#bd9f9f"><div align="center">' . number_format($rowd['saldo'], 0, '.', ',') . '</div></td>
                            <td bgcolor="#bd9f9f"><div align="center">' . $rowd['diferencia'] . '</div></td>
                            <td id="descr" bgcolor="#B297A1"><input type="text" value="' . $rowd['observacion'] . '" id="obser" name="observacion" ></td>';
                    //echo '<script>alert(' . $contador . ');</script>';
                }
            }
            echo '<tr>
                            <th colspan="8"><div align="center">TOTALES</div></th>
                            <th><div align="center">' . number_format($costo, 2, '.', ',') . '</div></th>
                            <th><div align="center">' . number_format($enviado, 0, '.', ',') . '</div></th>
                            <th><div align="center">' . number_format($saldo, 0, '.', ',') . '</div></th> 
                            <th><div align="center">' . number_format($diferencia, 0, '.', ',') . '</div></th>
                            <th></th>
                            </tr>
                </tbody>
        </table>';
        }
        echo '</div>';
        ?>
        <div>
            <div align="center">  
                <button type="submit" name="" value="" onclick="grabaTodoTabla('listaF');" class="buttonfooter">GUARDAR</button>
                <button type="button" name="" value="" onclick="cancelar();" class="buttonfooter">CANCELAR</button>
                <button type="button" name="" value="" onclick="recargar();"class="buttonfooter">RECARGAR</button>
                <button type="button" name="" value="" onclick="window.close();" class="buttonfooter">SALIR</button>
            </div>
        </div>

        <div id="respuesta"></div>
    </body>
    <script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>  
    <script type="text/javascript">
// Actualiza de manera masiva todos los archivos cargados en la tercera pestaña.

                    function observacion() {
                        $('input[id=obser]').each(function () {
                            var DESC = $("#obser").val(DESC);
                            $("#obser").val(DESC);
                        });
                    }
                    function cancelar() {
                        var result = confirm('Esta Seguro De Cancelar');
                        if (result == false) {
                            return false;
                        } else {
                            window.location.reload(true);
                            this.close();
                        }
                    }
                    function recargar() {
                        window.location.reload(true);

                    }
                    function grabaTodoTabla(TABLAID) {
                        //tenemos 2 variables, la primera será el Array principal donde estarán nuestros datos y la segunda es el objeto tabla
                        var result = confirm('Esta Seguro De Guardar los Cambios');
                        if (result == false) {
                            return false;
                        } else {                            
                            var DATA = [],
                                    TABLA = $("#" + TABLAID + " tbody > tr");

                            //una vez que tenemos la tabla recorremos esta misma recorriendo cada TR y por cada uno de estos se ejecuta el siguiente codigo
                            TABLA.each(function () {                                
                                //por cada fila o TR que encuentra rescatamos 3 datos, el ID de cada fila, la Descripción que tiene asociada en el input text, y el valor seleccionado en un select
                                var ID = $(this).find("td[id='td_id']").text(),
                                        TRAN = $(this).find("td[id='td_id2']").text(),
                                        DESC = $(this).find("input[id='obser']").val();
                                 
                                

                                //entonces declaramos un array para guardar estos datos, lo declaramos dentro del each para así reemplazarlo y cada vez
                                item = {};
                                //si miramos el HTML vamos a ver un par de TR vacios y otros con el titulo de la tabla, por lo que le decimos a la función que solo se ejecute y guarde estos datos cuando exista la variable ID, si no la tiene entonces que no anexe esos datos.
                                if (ID !== '') {
                                    item ["id"] = ID;
                                    item ["desc"] = DESC;
                                    item ["trans"] = TRAN;
                                    //una vez agregados los datos al array "item" declarado anteriormente hacemos un .push() para agregarlos a nuestro array principal "DATA".
                                    DATA.push(item);
                                }
                            });
                            console.log(DATA);
                            
                            //eventualmente se lo vamos a enviar por PHP por ajax de una forma bastante simple y además convertiremos el array en json para evitar cualquier incidente con compativilidades.
                            INFO = new FormData();
                            aInfo = JSON.stringify(DATA);

                            INFO.append('data', aInfo);

                            $.ajax({
                                data: INFO,
                                type: 'POST',
                                url: '../php/funciones_upload.php',
                                processData: false,
                                contentType: false,
                                success: function (r) {
                                    alert("aqui estoy");
                                    //Una vez que se haya ejecutado de forma exitosa hacer el código para que muestre esto mismo.
                                    $("#respuesta").html("");
                                    $("#respuesta").html(r);
                                }
                            });
                        }
                    }
    </script>
</html>