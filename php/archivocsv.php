<?php 

  error_reporting(0);
  if(isset($_POST['submit'])){
  
        $fname = $_FILES['sel_file']['name'];
        echo 'Cargando nombre del archivo: '.$fname.' ';
        $chk_ext = explode(".",$fname);

        if(strtolower(end($chk_ext)) == "csv")
        { 
             //Establecemos la conexion con nuestro servidor de mysql local
             $cone = mysql_connect('localhost', 'root', '');
             if(!$cone)//en caso de no lograr establecer la conexion se quiebra el proceso...
                die('Conexion no establecida');
             
             //Verificamos si nuestra base de datos existe.   
             if (!mysql_select_db("mrbooks"))//en caso de no existir quiebra el proceso...
                die("base de datos no existe");
                
            //si es correcto, entonces damos permisos de lectura para subir
             $filename = $_FILES['sel_file']['tmp_name'];
             $handle = fopen($filename, "r"); 
			 $truncate = "TRUNCATE cliente;";
			 mysql_query($truncate);
              while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
             {
                  if(strtoupper($data[0]) != "NOMBRES"){
                      //Insertamos los datos con los valores...                     
                    $sql = "insert into cliente (Nombres,Apellidos,Direccion,Telefono,Movil,Cedula,TipoDocumento)";
                    $sql .= " values('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]')";					
                    mysql_query($sql) or die(mysql_error());
                    
                  }
             }
             //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
             fclose($handle);
             echo "Importacion exitosa!";
        }else{
            echo '<br> Formato de archivo incorrecto';    
        }
  }
  
?>
<!DOCTYPE html>
  <body> 
  <h1>Importando archivo CSV</h1>
  <form action='<?php echo $_SERVER["PHP_SELF"];?>' method='post' enctype="multipart/form-data">
   Importar Archivo : <input type='file' name='sel_file' size='20'>
   <input type='submit' name='submit' value='submit'>
  </form>
 </body>
</html>