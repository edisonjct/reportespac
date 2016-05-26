<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery-latest.js"></script>
<script type="text/javascript" src="../js/jquery.tablesorter.js"></script>
<script type="text/javascript">
$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);
</script>
 

<table id="myTable" class="tablesorter"> 
<thead> 
<tr> 
    <th>Last Name</th> 
    <th>First Name</th> 
    <th>Email</th> 
    <th>Due</th> 
    <th>Web Site</th> 
</tr> 
</thead> 
<tbody> 
<tr> 
    <td>Smith</td> 
    <td>John</td> 
    <td>jsmith@gmail.com</td> 
    <td>$50.00</td> 
    <td>http://www.jsmith.com</td> 
</tr> 
<tr> 
    <td>Bach</td> 
    <td>Frank</td> 
    <td>fbach@yahoo.com</td> 
    <td>$50.00</td> 
    <td>http://www.frank.com</td> 
</tr> 
<tr> 
    <td>Doe</td> 
    <td>Jason</td> 
    <td>jdoe@hotmail.com</td> 
    <td>$100.00</td> 
    <td>http://www.jdoe.com</td> 
</tr> 
<tr> 
    <td>Conway</td> 
    <td>Tim</td> 
    <td>tconway@earthlink.net</td> 
    <td>$50.00</td> 
    <td>http://www.timconway.com</td> 
</tr> 
</tbody> 
</table> 

echo '<table id="myTable" class="tablesorter">
        <thead><tr>
            <th>#</th>
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Categoria</th> 
            <th>CategoriaGS</th>
            <th>Autor</th>
            <th>Editorial</th>
            <th>Provedor</th>
            <th>Opcio</th>
        </tr></thead>';
    if (mysql_num_rows($resultado) > 0) {
        while ($row = mysql_fetch_array($resultado)) {
            $contador = $contador + 1;         
           echo '<tbody><tr>
            <td>' . $contador . '</td>
            <td>' . $row["codprod"] . '</td>
            <td>' . $row["titulo"] . '</td>
            <td>' . $row["cate"] . '</td>
            <td>' . $row["catgs"] . '</td>
            <td>' . $row["autor"] . '</td>
            <td>' . $row["editorial"] . '</td> 
            <td>' . $row["provedor"] . '</td>
            <td>
                <a href="javascript:editarProducto('.$row['codprod'].','.$row['codcte'].');" class="glyphicon glyphicon-edit"></a>
                <a href="javascript:eliminarProducto('.$row['codprod'].','.$row['codcte'].');" class="glyphicon glyphicon-remove-circle"></a>
            </td>
          </tr>';
        }        
    } else {
        echo '<tr>
		<td colspan="9">No se encontraron resultados</td>
	</tr></tbody>';
    }
    echo '</table>';