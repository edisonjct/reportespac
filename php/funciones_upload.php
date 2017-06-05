<?php
//Recibimos el Array y lo decodificamos desde json, para poder utilizarlo como objeto
$DATA 	= json_decode($_POST['data']);
//print_r($DATA); die();
//por cada uo de estos arrays vamos a crear una query para poder hacer un update en la base de datos. y para eso necesitamos recorrer el array por cada uno de sus posicione
include('conexionC.php');

for ($i=0; $i < count($DATA); $i++) {
	$q[$i] = 'UPDATE mercaderia_en_transito SET estado="RR", observacion= "'.$DATA[$i]->desc.'" WHERE numero_transferencia="'.$DATA[$i]->trans.'" AND codigo_barras="'.$DATA[$i]->id.'";';	
        mysql_query($q[$i]);   
}
echo '<script>alert("GUARDADO CON EXITO");this.close();</script>';