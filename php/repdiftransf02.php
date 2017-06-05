<?php

include('conexion.php');

$desde = $_GET['desde'];
$hasta = $_GET['hasta'];
$IDB = $_GET['IDB'];
$estado = $_GET['estado'];
$bodega = $_GET['bodega'];

if ($estado == 'TD') {    
    $registro = "SELECT
        m.numero_transferencia AS transferencia,
        t.nomtab AS bodega,
        p.nomcte01 AS provedor,
        m.fecha_egreso AS fechae,
        m.fecha_recepcion AS fechar,
        MRB_USUARIOS.nombreusuario as receptor,
        ROUND(Sum(m.cantidad_enviada)) AS cante,
        case when m.estado = 'T' THEN ROUND(Sum(m.cantidad_enviada)) ELSE '0' END AS cantt,
        case when m.estado = 'R' OR m.estado = 'P' THEN ROUND(Sum(m.diferencia_cantidad)+Sum(m.cantidad_enviada)) ELSE '0' END AS cantr,
        case WHEN m.estado = 'R' OR m.estado = 'RR' OR m.estado = 'P' THEN TRUNCATE((((Sum(m.diferencia_cantidad)+Sum(m.cantidad_enviada))*100)/Sum(m.cantidad_enviada)),1) ELSE '0' END AS pormas,
        case when m.estado = 'T' THEN 'Transito' when m.estado = 'R' THEN 'Procesado' when m.estado = 'RR' THEN 'Revisado' when m.estado = 'P' THEN 'Parcial' end  as estado
        FROM
        mrbooks.mercaderia_en_transito AS m
        LEFT JOIN mrbooks.maetab AS t ON m.bodega = t.codtab
        LEFT JOIN mrbooks.maepag AS p ON m.codigo_proveedor = p.codcte01
        LEFT JOIN mrbooks.MRB_USUARIOS ON m.usuario_recepcion = MRB_USUARIOS.UID
        WHERE m.fecha_egreso BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND t.numtab = '97' AND t.codtab <> '' 
        AND m.bodega = '$bodega'
        GROUP BY m.numero_transferencia";    
    $resultado = mysql_query($registro, $conexion);
    
    echo '<table class="table table-striped table-condensed table-hover">
        <tbody>
        <tr>
          <th><div align="center">Transfer</div></th>
          <th><div align="center">Bodega</div></th>
          <th><div align="center">Provedor</div></th>
          <th><div align="center">Fecha.Transfe</div></th>
          <th><div align="center">Fecha.Recepc</div></th>  
          <th><div align="center">Usuario.Recepc</div></th>
          <th><div align="center">Cant.Enviada</div></th>
          <th><div align="center">Cant.Transito</div></th>
          <th><div align="center">Cant.Recivida</div></th>   
          <th><div align="center">Estado</div></th>
          <th><div align="center">Progreso.Transferencia</div></th>          
        </tr>';

    if (mysql_num_rows($resultado) > 0) {
        while ($row = mysql_fetch_array($resultado)) {
            if($row['pormas'] == '100.0' ){
                echo '<tr>';                     
                echo "<td bgcolor='#cef7a7'><div align='center'><a href='../php/repdiftransf03.php?transf=" . $row['transferencia'] . "&IDB=".$IDB."&estado=01  ' target='_blank' onclick=\"window.open(this.href, this.target, ' width=1250, height=700, menubar=no');return false;\">".$row['transferencia']."</a></div></td>";
                echo '<td bgcolor="#cef7a7"><div align="center">' . $row['bodega'] . '</div></td>
                <td bgcolor="#cef7a7"><div align="center">' . $row['provedor'] . '</div></td>
                <td bgcolor="#cef7a7"><div align="center">' . $row['fechae'] . '</div></td>
                <td bgcolor="#cef7a7"><div align="center">' . $row['fechar'] . '</div></td>
                <td bgcolor="#cef7a7"><div align="center">' . $row['receptor'] . '</div></td>
                <td bgcolor="#cef7a7"><div align="center">' . $row['cante'] . '</div></td>
                <td bgcolor="#cef7a7"><div align="center">' . $row['cantt'] . '</div></td>
                <td bgcolor="#cef7a7"><div align="center">' . $row['cantr'] . '</div></td>
                <td bgcolor="#cef7a7"><div align="center">' . $row['estado'] . '</div></td>
                <td bgcolor="#cef7a7">
                <div class="progress">
                <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" style="width:' . number_format($row['pormas'], 0, '.', ',') . '%">
                    ' . number_format($row['pormas'], 0, '.', ',') . '%
                </div>                
                </div>
                </td>
            </tr>';
            } else {
                echo '<tr>';                     
                echo "<td bgcolor='#bd9f9f'><div align='center'><a href='../php/repdiftransf03.php?transf=" . $row['transferencia'] . "&IDB=".$IDB."&estado=01  ' target='_blank' onclick=\"window.open(this.href, this.target, ' width=1250, height=700, menubar=no');return false;\">".$row['transferencia']."</a></div></td>";
                echo '<td bgcolor="#bd9f9f"><div align="center">' . $row['bodega'] . '</div></td>
                <td bgcolor="#bd9f9f"><div align="center">' . $row['provedor'] . '</div></td>
                <td bgcolor="#bd9f9f"><div align="center">' . $row['fechae'] . '</div></td>
                <td bgcolor="#bd9f9f"><div align="center">' . $row['fechar'] . '</div></td>
                <td bgcolor="#bd9f9f"><div align="center">' . $row['receptor'] . '</div></td>
                <td bgcolor="#bd9f9f"><div align="center">' . $row['cante'] . '</div></td>
                <td bgcolor="#bd9f9f"><div align="center">' . $row['cantt'] . '</div></td>
                <td bgcolor="#bd9f9f"><div align="center">' . $row['cantr'] . '</div></td>
                <td bgcolor="#bd9f9f"><div align="center">' . $row['estado'] . '</div></td>
                <td bgcolor="#bd9f9f">
                <div class="progress">
                <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" style="width:' . number_format($row['pormas'], 0, '.', ',') . '%">
                    ' . number_format($row['pormas'], 0, '.', ',') . '%
                </div>                
                </div>
                </td>
            </tr>';
            }
            
        }
    } else {
        echo '<tr>
		<td colspan="11">No se encontraron resultados</td>
	</tr>';
    }
    echo '<tbody></table>';
} else {      
    $registro = "SELECT
        m.numero_transferencia AS transferencia,
        t.nomtab AS bodega,
        p.nomcte01 AS provedor,
        m.fecha_egreso AS fechae,
        m.fecha_recepcion AS fechar,
        MRB_USUARIOS.nombreusuario as receptor,
        ROUND(Sum(m.cantidad_enviada)) AS cante,
        case when m.estado = 'T' THEN ROUND(Sum(m.cantidad_enviada)) ELSE '0' END AS cantt,
        case when m.estado = 'R' OR m.estado = 'P' THEN ROUND(Sum(m.diferencia_cantidad)+Sum(m.cantidad_enviada)) ELSE '0' END AS cantr,
        case WHEN m.estado = 'R' OR m.estado = 'RR' OR m.estado = 'P' THEN TRUNCATE((((Sum(m.diferencia_cantidad)+Sum(m.cantidad_enviada))*100)/Sum(m.cantidad_enviada)),0) ELSE '0' END AS pormas,
        case when m.estado = 'T' THEN 'Transito' when m.estado = 'R' THEN 'Procesado' when m.estado = 'RR' THEN 'Revisado' when m.estado = 'P' THEN 'Parcial' end  as estado
        FROM
        mrbooks.mercaderia_en_transito AS m
        LEFT JOIN mrbooks.maetab AS t ON m.bodega = t.codtab
        LEFT JOIN mrbooks.maepag AS p ON m.codigo_proveedor = p.codcte01
        LEFT JOIN mrbooks.MRB_USUARIOS ON m.usuario_recepcion = MRB_USUARIOS.UID
        WHERE m.fecha_egreso BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND t.numtab = '97' AND t.codtab <> '' 
        AND m.bodega = '$bodega' AND m.estado = '$estado'
        GROUP BY m.numero_transferencia
        ";
    $resultado = mysql_query($registro, $conexion);

    echo '<table class="table table-striped table-condensed table-hover">
        <tr>
          <th>Transfer</th>
          <th>Bodega</th>
          <th>Provedor</th>
          <th>Fecha.Transfe</th>
          <th>Fecha.Recepc</th>  
          <th>Usuario.Recepc</th>
          <th>Cant.Enviada</th>
          <th>Cant.Transito</th>
          <th>Cant.Recivida</th>   
          <th>Estado</th>
          <th>Progreso.Transferencia</th>          
        </tr>';
    
    if (mysql_num_rows($resultado) > 0) {
        while ($row = mysql_fetch_array($resultado)) {
            if($row['pormas'] == '100.0'){
                echo '<tr>';                     
                echo "<td bgcolor='#C4EA95'><div align='center'><a href='../php/repdiftransf03.php?transf=" . $row['transferencia'] . "&IDB=".$IDB."&estado=01  ' target='_blank' onclick=\"window.open(this.href, this.target, ' width=1250, height=700, menubar=no');return false;\">".$row['transferencia']."</a></div></td>";
                echo '<td bgcolor="#C4EA95"><div align="center">' . $row['bodega'] . '</div></td>
                <td bgcolor="#C4EA95"><div align="center">' . $row['provedor'] . '</div></td>
                <td bgcolor="#C4EA95"><div align="center">' . $row['fechae'] . '</div></td>
                <td bgcolor="#C4EA95"><div align="center">' . $row['fechar'] . '</div></td>
                <td bgcolor="#C4EA95"><div align="center">' . $row['receptor'] . '</div></td>
                <td bgcolor="#C4EA95"><div align="center">' . $row['cante'] . '</div></td>
                <td bgcolor="#C4EA95"><div align="center">' . $row['cantt'] . '</div></td>
                <td bgcolor="#C4EA95"><div align="center">' . $row['cantr'] . '</div></td>
                <td bgcolor="#C4EA95"><div align="center">' . $row['estado'] . '</div></td>
                <td bgcolor="#C4EA95">
                <div class="progress">
                <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" style="width:' . number_format($row['pormas'], 0, '.', ',') . '%">
                    ' . number_format($row['pormas'], 0, '.', ',') . '%
                </div>                
                </div>
                </td>
            </tr>';
            } else {
                echo '<tr>';                     
                echo "<td bgcolor='#B297A1'><div align='center'><a href='../php/repdiftransf03.php?transf=" . $row['transferencia'] . "&IDB=".$IDB."&estado=01  ' target='_blank' onclick=\"window.open(this.href, this.target, ' width=1250, height=700, menubar=no');return false;\">".$row['transferencia']."</a></div></td>";
                echo '<td bgcolor="#B297A1"><div align="center">' . $row['bodega'] . '</div></td>
                <td bgcolor="#B297A1"><div align="center">' . $row['provedor'] . '</div></td>
                <td bgcolor="#B297A1"><div align="center">' . $row['fechae'] . '</div></td>
                <td bgcolor="#B297A1"><div align="center">' . $row['fechar'] . '</div></td>
                <td bgcolor="#B297A1"><div align="center">' . $row['receptor'] . '</div></td>
                <td bgcolor="#B297A1"><div align="center">' . $row['cante'] . '</div></td>
                <td bgcolor="#B297A1"><div align="center">' . $row['cantt'] . '</div></td>
                <td bgcolor="#B297A1"><div align="center">' . $row['cantr'] . '</div></td>
                <td bgcolor="#B297A1"><div align="center">' . $row['estado'] . '</div></td>
                <td bgcolor="#B297A1">
                <div class="progress">
                <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" style="width:' . number_format($row['pormas'], 0, '.', ',') . '%">
                    ' . number_format($row['pormas'], 0, '.', ',') . '%
                </div>                
                </div>
                </td>
            </tr>';
            }
            
        }
    } else {
        echo '<tr>
		<td colspan="11">No se encontraron resultados</td>
	</tr>';
    }
    echo '</table>';
    
    
}

        
       