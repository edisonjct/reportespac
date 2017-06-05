<?php

include('conexion.php');
$IDB = $_GET['IDB'];
$UID = $_GET['UID'];
$desde = $_GET['desde'];
$hasta = $_GET['hasta'];

$fdesde = date("Y/m/d", strtotime($desde));
$fhasta = date("Y/m/d", strtotime($hasta));

$query_usuario = "SELECT u.nombreusuario as nombre,u.username as user from mrbooks_infosac.usuario as u WHERE u.UID = '$UID' LIMIT 1;";
$result_usuario = mysql_query($query_usuario);
$usuario_a = mysql_fetch_array($result_usuario);
$usuario = $usuario_a['user'];
$contador = 0;
$contador2 = 0;

if ($_FILES['autorizaciones']['size'] > 0) {
    $csv = $_FILES['autorizaciones']['tmp_name'];
    $archivo = fopen($csv, 'r');
    while ($data = fgetcsv($archivo, 10000, ";", "'")) {
        $contador = $contador + 1;
        if ($data[0] == '') {
            echo 'Linea ' . $contador . ': En Blanco' . '<br>';
        } else if ($data[1] > '100') {
            echo 'Linea ' . $contador . ': No se puede dar mas del 100% de descuento' . '<br>';
        } else {
            $query_verificar_codigo = "select codbar01,codprod01 from maepro WHERE codbar01 = '$data[0]' limit 1;";
            $result_verificar_codigo = mysql_query($query_verificar_codigo);
            if (mysql_num_rows($result_verificar_codigo) == 0) {
                echo 'Linea ' . $contador . ': Codigo ' . $data[0] . ' no existe' . '<br>';
            } else {
                $contador2 = $contador2 + 1;
            }
        }
    }
    
    if ($contador != $contador2) {
        echo '<br>
            <div class="container"><div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <a href="#" class="alert-link">No se Inserto ninguna Autorización: Corriga el archivo y vuelva a Subir</a>
          </div></div>';
    } else {
        $archivo = fopen($csv, 'r');
        
        while ($insert = fgetcsv($archivo, 10000, ";", "'")) {
            $query_codigo_maetab = "select max(ad1tab) from maetab WHERE numtab = '87' AND codtab = '0001'";
            $result_codigo_maetab = mysql_query($query_codigo_maetab);
            $ultimocodigo = mysql_fetch_array($result_codigo_maetab);
            $secuencial = $ultimocodigo[0] + 1;
            // Validar Codigo de barras para ingresar codigo interno
            $query_codigo_maepro = "select codbar01,codprod01 from maepro WHERE codbar01 = '$insert[0]' limit 1;";
            $result_codigo_maepro = mysql_query($query_codigo_maepro);
            $interno_a = mysql_fetch_array($result_codigo_maepro);
            $interno = $interno_a['codprod01'];
            //echo '<script>alert('.$interno.');</script>';
            $update_secuencial = mysql_query("UPDATE maetab SET ad1tab='$secuencial' WHERE (numtab='87') AND (codtab='0001') LIMIT 1;");
            //echo '<script>alert('.$secuencial.');</script>';
            $query_insertar = "insert into autorizaciones(tipoauto,codcte,codprod,valmaxauto,usuaauto,fecvenc,fecauto,usuasoli,estaauto,codaut,fechavench,cateaut,histaut,cateautc) values('0001','','$interno','$insert[1]','$UID','$fdesde','$fdesde','99999','A','$secuencial','$fhasta','','$usuario --> REGISTRADO | $usuario -->APROBADA | ','')";
            $result_insertar = mysql_query($query_insertar);
            $query_update = "select ";
            
        }
        echo '<div class="container"><div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <a href="#" class="alert-link">Autorizaciones Ingresadas y Aprobadas Con Exito</a>
          </div></div>';
    }
    
    
} else {
    echo "Archivo no Valido";
}    