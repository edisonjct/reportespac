<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of repsaldosproved
 *
 * @author EChulde
 */

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $nombreb; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/bootstrap-select.css">        
        <link rel="stylesheet" type="text/css" href="../../css/estilo.css">
        <link href="../../css/bootstrap-datetimepicker.css" rel="stylesheet">  
        <script type="text/javascript" src="../../js/jquery-1.12.4.min.js"></script>        
        <script type="text/javascript" src="../../js/jquery.js"></script>     
        <script type="text/javascript" src="../../js/myjava.js"></script>
        <script type="text/javascript" src="../../js/bootstrap-select.js"></script>
        <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../../js/moment.js"></script>        
        <script src="../../js/bootstrap-datetimepicker.min.js"></script>  
    </head>

    <body>
        <div>
            <?php include_once '../../vistas/Header.php'; ?>
        </div>
        <div class="container">
            <?php 
            include_once '../../php/conexion.php';
            $IDB = $_GET['IDB'];
            $desde = $_GET['desde'];
            $hasta = $_GET['hasta'];
            $provedor = $_GET['provedor'];

            $debito1 = 0;
            $credito1 = 0;
            $saldo2 = 0;
            $documento = '';
            $tipo = '';
            
            $debitocont = 0;
            $creditocont = 0;
            
            $query = "SELECT
            m.tipodoc43 as tipo,
            concat(m.tipodoc43,'-',t.nomtab) as doc,
            p.nomcte01 as provedor,
            m.numdoc43 as documento,
            m.fecdoc43,
            DATE_FORMAT(m.fecdoc43,'%d/%b/%Y') as fecha,
            CASE WHEN m.tipodoc43 IN (51,52,53,53.1,54,55,56,57,57.1,58,58.1,58.2,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,99.1) THEN m.valorabono43 ELSE '' END AS 'DEBITO',
            CASE WHEN m.tipodoc43 IN (01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50) THEN m.totdoc43 ELSE '' END AS 'CREDITO',
            m.saldocte43 as saldo
            FROM
            movpag AS m
            INNER JOIN maetab AS t ON m.tipodoc43 = t.codtab
            INNER JOIN maepag AS p ON m.codcte43 = p.codcte01
            WHERE m.codcte43 = '$provedor' AND m.fecdoc43 BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND t.numtab = '61' AND t.codtab != '' ORDER BY m.fecdoc43 ASC";
            $result = mysql_query($query);

            
            ?>
            <?php if (mysql_num_rows($result) > 0) { ?>
                <table class="table table-striped table-hover table-bordered table-condensed">
                    <tr>
                        <th>DOCUEMENTO</th>
                        <th>PROVEDOR</th>
                        <th>NUM.DOC</th>
                        <th>FECHA</th>
                        <th>DEBITO</th>
                        <th>CREDITO</th>
                        <th>SALDO</th>
                        <th colspan="5">ACIENTO CONTABLE</th>
                    </tr>
                    <?php while ($row = mysql_fetch_assoc($result)) { 
                        $debito1 = $debito1 + $row['DEBITO'];
                        $credito1 = $credito1 + $row['CREDITO'];
                        $documento = $row['documento'];
                        $tipo = $row['doc'];
                        
                        switch ($tipo) {
                            case 01:
                                $doccontable = 'FC';
                                break;
                            case 51:
                                $doccontable = 'P';
                                break;                            
                            case 49:
                                $doccontable = 'SALDOS';
                                break;
                            default :
                                $doccontable = '';
                                break;
                        }                        
                                $movcont = "SELECT
                                t.nomtab as nombre,
                                concat(m.ctahiscon,' - ',c.nomcta) as cuenta,
                                CASE WHEN m.db1cr2his = 1 THEN m.valorhis ELSE '' END as DEBITO,
                                CASE WHEN m.db1cr2his = 2 THEN m.valorhis ELSE '' END as CREDITO,
                                m.dethis as detalle
                                FROM
                                movcon m
                                INNER JOIN maecon as c ON m.ctahiscon = c.ctamaecon
                                INNER JOIN maetab as t ON m.tipocomptehis = t.codtab
                                WHERE m.tipocomptehis = '$doccontable' AND m.numcomptehis = '$documento' AND t.numtab = '03' AND t.codtab != '';";
                                $result3 = mysql_query($movcont);                                
                        ?>                    
                            <tr>
                                <td><?php echo $row['doc'] ?></td>
                                <td><?php echo $row['provedor'] ?></td>
                                <td><?php echo $row['documento'] ?></td>
                                <td><?php echo $row['fecha'] ?></td>
                                <td><?php if($row['DEBITO'] == '') { echo ''; } else { echo number_format($row['DEBITO'], 2, '.', ','); }  ?></td>
                                <td><?php if($row['CREDITO'] == '') { echo ''; } else { echo number_format($row['CREDITO'], 2, '.', ','); } ?></td>
                                <td><?php echo number_format($row['saldo'], 2, '.', ',');?></td>
                                <td>                                    
                                    <?php if (mysql_num_rows($result3) > 0) { ?>
                                    <table class="table table-bordered table-condensed">
                                        <tr>
                                            <th>DOCUMENTO</th>
                                            <th>CUENTA</th>
                                            <th>DEBITO</th>
                                            <th>CREDITO</th>
                                            <th>DETALLE</th>
                                        </tr>
                                        <?php while ($row3 = mysql_fetch_assoc($result3)) { ?>
                                        <?php $debitocont = $debitocont + $row3['DEBITO'];
                                              $creditocont = $creditocont + $row3['CREDITO']; ?>
                                                <tr>
                                                    <td><?php echo $row3['nombre'];?></td>
                                                    <td><?php echo $row3['cuenta'];?></td>
                                                    <td><?php echo $row3['DEBITO'];?></td>
                                                    <td><?php echo $row3['CREDITO'];?></td>
                                                    <td><?php echo $row3['detalle'];?></td>
                                                </tr>
                                            <?php } ?>
                                        <tr>
                                            <th colspan="2"></th>                                            
                                            <th><?php echo $debitocont;?></th>
                                            <th><?php echo $creditocont;?></th>
                                            <th></th>
                                        </tr>
                                    </table>
                                    <?php $debitocont = 0;
                                            $creditocont = 0;
                                            
                                        } else { ?>
                                        <p>SIN CUENTA CONTABLE</p>
                                    <?php } ?>                                                                            
                                </td>                                
                            </tr>                    
                    <?php } ?>
                        <tr>
                            <th colspan="4">TOTALES</th>
                            <th><?php echo number_format($debito1, 2, '.', ',');?></th>
                            <th><?php echo number_format($credito1, 2, '.', ',');?></th>
                            <th><?php echo number_format($credito1 - $debito1, 2, '.', ',');?></th>
                        </tr>
                </table>
            <?php } else { ?>
                <?php echo "NO SE ENCONTRARON REGISTROS PARA MOSTRAR";
            }
            ?>
            <hr width=90% align="center">
            <?php $query2 = "SELECT
            concat(m.tipodoc43,'-',t.nomtab) as doc,
            p.nomcte01 as provedor,
            m.numdoc43 as documento,
            m.fecdoc43,
            DATE_FORMAT(m.fecdoc43,'%d/%b/%Y') as fecha,
            CASE WHEN m.tipodoc43 IN (51,52,53,53.1,54,55,56,57,57.1,58,58.1,58.2,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,99.1) THEN m.valorabono43 ELSE '' END AS saldo
            FROM
            movpag2 AS m
            INNER JOIN maetab AS t ON m.tipodoc43 = t.codtab
            INNER JOIN maepag AS p ON m.codcte43 = p.codcte01
            WHERE m.codcte43 = '$provedor' AND m.fecdoc43 BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND t.numtab = '61' AND t.codtab != ''";
            $result2 = mysql_query($query2); ?>
            <?php if (mysql_num_rows($result2) > 0) { ?>
                <table class="table table-striped table-hover table-bordered table-condensed">
                    <tr>
                        <th colspan="7">ANTICIPOS Y POSFECHADOS</th>
                    </tr>
                    <tr>
                        <th>DOCUEMENTO</th>
                        <th>PROVEDOR</th>
                        <th>NUM.DOC</th>
                        <th>FECHA</th>
                        <th>SALDO</th>
                    </tr>
                    <?php while ($row2 = mysql_fetch_assoc($result2)) { 
                        $saldo2 = $saldo2 + $row2['saldo']; ?>
                        <tr>                
                            <td><?php echo $row2['doc'] ?></td>
                            <td><?php echo $row2['provedor'] ?></td>
                            <td><?php echo $row2['documento'] ?></td>
                            <td><?php echo $row2['fecha'] ?></td>
                            <td><?php echo number_format($row2['saldo'] * -1, 2, '.', ','); ?></td>                  
                        </tr>
                    <?php } ?>
                        <tr>
                            <th colspan="4">TOTALES</th>
                            <th><?php echo number_format($saldo2 * -1, 2, '.', ',');?></th>
                        </tr>
                </table>
            <?php }  ?>                
        </div>



    </body>
    <footer>

    </footer>
</html>