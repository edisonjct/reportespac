<!DOCTYPE html>
<?php
$bodega  = $_GET['IDB'];
$usuario = '1088';

$conexion = mysql_connect('100.100.20.100', 'root', '');
mysql_select_db('mrbooks', $conexion);
$registro  = "select codtab,nomtab from maetab WHERE numtab = 97 AND codtab = '$bodega'";
$resultado = mysql_query($registro, $conexion);

$conexion2 = mysql_connect('100.100.20.100', 'root', '');
mysql_select_db('mrbooks_infosac', $conexion2);
$registro2 = "SELECT DISTINCT
mrbooks_infosac.usuario.UID as uid,
mrbooks_infosac.usuario.username as usuario,
mrbooks_infosac.usuario.nombreusuario as nombre,
mrbooks_infosac.empresausuario.perfil as perfil,
mrbooks_infosac.usuario.permisos as costo,
mrbooks.maetab.nomtab as impresora,
DATE_FORMAT(CURDATE(),'%d') as dia,
DATE_FORMAT(CURDATE(),'%M') as mes,
DATE_FORMAT(CURDATE(),'%Y') as anio
FROM
mrbooks_infosac.usuario
INNER JOIN mrbooks_infosac.empresausuario ON mrbooks_infosac.usuario.UID = mrbooks_infosac.empresausuario.idusu
INNER JOIN mrbooks.maetab ON mrbooks_infosac.usuario.impresora = mrbooks.maetab.codtab
WHERE
mrbooks.maetab.numtab = 98 AND mrbooks_infosac.usuario.UID = '$usuario'";
$resultado2 = mysql_query($registro2, $conexion2);
?>
<html>
    <head>
        <style>
            #header {
                background-image: url("../recursos/topimagecenter.jpg");
                background-color:#e8e8e8;
                color:#000;
                text-align:center;
                font-size: medium;
                font-weight: bold;
                font-family: small-caps;
                padding:5px;
            }

            #nav {
                line-height:30px;
                background-color:#eeeeee;
                height:300px;
                width:100px;
                float:left;
                padding:5px;
            }
            #section {
                width:350px;
                float:left;
                padding:10px;
            }
            #footer {
                background-color:black;
                color:white;
                clear:both;
                text-align:center;
                padding:5px;
            }
            #header2 {
                text-align:center;
            }
            #label {
                color:white;
                font-size: x-small;
            }
            #text {
                color:#002a80;
                font-size: x-small;
            }
            button.css3button {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 10px;
                color: #050505;
                padding: 0px 80px;
                -moz-border-radius: 1px;
                -webkit-border-radius: 1px;
                border-radius: 1px;
                -moz-box-shadow: 0px 1px 3px rgba(000,000,000,1),
                            inset 0px 0px 1px rgba(255,255,255,0.7);
                -webkit-box-shadow: 0px 1px 3px rgba(000,000,000,1),
                            inset 0px 0px 1px rgba(255,255,255,0.7);
                box-shadow: 0px 1px 3px rgba(000,000,000,1),
                            inset 0px 0px 1px rgba(255,255,255,0.7);
                text-shadow: 0px -1px 0px rgba(000,000,000,0),
                            0px 1px 0px rgba(255,255,255,0);
                background-color: #E8ECE6;
                background-position: left top;
                border-top-width: 2px;
                border-right-width: 2px;
                border-bottom-width: 2px;
                border-left-width: 2px;
                border-top-style: solid;
                border-right-style: solid;
                border-bottom-style: solid;
                border-left-style: solid;
                border-top-color: #4489CE;
                border-right-color: #4489CE;
                border-bottom-color: #4489CE;
                border-left-color: #4489CE;

            }

            button.buttonfooter {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 11px;
                color: #050505;
                padding: 0px 120px;
                -moz-border-radius: 1px;
                -webkit-border-radius: 1px;
                border-radius: 1px;
                -moz-box-shadow: 0px 1px 3px rgba(000,000,000,1),
                            inset 0px 0px 1px rgba(255,255,255,0.7);
                -webkit-box-shadow: 0px 1px 3px rgba(000,000,000,1),
                            inset 0px 0px 1px rgba(255,255,255,0.7);
                box-shadow: 0px 1px 3px rgba(000,000,000,1),
                            inset 0px 0px 1px rgba(255,255,255,0.7);
                text-shadow: 0px -1px 0px rgba(000,000,000,0),
                            0px 1px 0px rgba(255,255,255,0);
                background-color: #E8ECE6;
                background-position: left top;
                border-top-width: 2px;
                border-right-width: 2px;
                border-bottom-width: 2px;
                border-left-width: 2px;
                border-top-style: solid;
                border-right-style: solid;
                border-bottom-style: solid;
                border-left-style: solid;
                border-top-color: #4489CE;
                border-right-color: #4489CE;
                border-bottom-color: #4489CE;
                border-left-color: #4489CE;

            }



        </style>

    </head>
    <body>

        <div id="header">
            <?php
while ($row = mysql_fetch_array($resultado)) {
    echo 'MISTERBOOKS S.A. -- ' . $row['nomtab'];
}
?>
            <div>
                <button type="button" name="" value="" class="css3button">EMPRESA</button>
                <button type="button" name="" value="" class="css3button">BODEGA</button>
                <button type="button" name="" value="" class="css3button">USUARIO</button>
                <button type="button" name="" value="" class="css3button" onclick="window.close();">SALIR SESION</button>
            </div>
        </div>
        <div id="header2">
            <?php
while ($row2 = mysql_fetch_array($resultado2)) {
    echo '<span id="label"> Usuario: </span><span id="text">Usuario</span><span id="label">  Fecha: </span><span id="text">' . $row2['dia'] . ' de ' . $row2['mes'] . ' del ' . $row2['anio'] . '</span><span id="label">  Perfil: Perfil</span><span id="label">    Costo: </span><span id="text">Costo</span><span id="label"> Impresora: </span><span id="text">Impresora</span>';
    //echo '<span id="label"> Usuario: </span><span id="text">' . $row2['usuario'] . ' ' . $row2['nombre'] . '</span><span id="label">  Fecha: </span><span id="text">' .$row2['dia'].' de '.$row2['mes'].' del '.$row2['anio'].'</span><span id="label">  Perfil: '.$row2['perfil'].'</span><span id="label">    Costo: </span><span id="text">'.$row2['costo'].'</span><span id="label"> Impresora: </span><span id="text">'.$row2['impresora'].'</span>';
}
?>
        </div>
    </body>
</html>