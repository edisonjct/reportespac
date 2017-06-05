<?php
$Name = 'prueba.xml';
$FileName = "./$Name";
$Header = '';
$Header .= "\r\n";
//Descarga el archivo desde el navegador
/*header('Expires: 0');
header('Cache-control: private');
header ("Content-type: text/xml"); // Archivo xml
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Description: File Transfer');
header('Last-Modified: '.date('D, d M Y H:i:s'));
header('Content-Disposition: attachment; filename="'.$Name.'"');
header("Content-Transfer-Encoding: binary");
*/
$c = mysql_connect("localhost", "root","");
mysql_select_db("mrbooks");

$lista="SELECT * FROM maefac";
$consulta = mysql_query($lista);

header ("Content-type: text/xml");

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo "<autorizacion>";
while ($dato=mysql_fetch_row($consulta)){
 echo "<kit>";
    echo "<linea>$dato[0]</linea>";
    echo "<marca>$dato[1]</marca>";
    echo "<tipo>$dato[2]</tipo>";
    echo "<modelo>$dato[3]</modelo>";
    echo "<fecha>$dato[4]</fecha>";
    echo "<motor>$dato[5]</motor>"; 
 echo "</kit>";  
}

echo"</autorizacion>";

mysql_close();

