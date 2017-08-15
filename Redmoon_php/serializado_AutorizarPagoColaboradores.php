<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

// Create a database connection
//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();

// ID,NOMBRE,NE,DESCRIPCION,IMPORTE PETICIÓN AUTORIZACION GASTO NO PRESUPUESTADO A UNA GESTORIA
do_queryTodo($conn, "select s.id,c.nombre,s.ne,s.descripcion,s.importe 
from seguimiento s,colaboradores c
where s.tipo_regla=12 and s.dh='P' and s.colaborador= c.id");
   
// Execute query and display results
function do_queryTodo($conn, $query)
{

	$time_start = microtime(true);

if (!isset($_POST['xPag']))
	$xPag=1;
else 
	$xPag=$_POST['xPag'];

	$resultado=db_get_page_data($conn, $query, $xPag, 15);
	$suma='';
	for ($j=0; $j <= (count($resultado)-1); $j++)
	{
	
	$suma=$suma.$resultado[$j]['ID'].'|';
	$suma=$suma.$resultado[$j]['NE'].'|';
	$suma=$suma.iconv('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['NOMBRE']).'|';
	$suma=$suma.iconv('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['DESCRIPCION']).'|';
	$suma=$suma.number_format($resultado[$j]['IMPORTE'], 0, ',', '.').'&#8364;'.'|';
	}

// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;
	
$numero_bytes=strlen($suma);
$url='serializado_AutorizarPagoColaboradores.php';
$opcion='PETICIÓN AUTORIZACION GASTO NO PRESUPUESTADO A UNA GESTORIA';

include 'Test_Medicion_Datos.inc';
	
echo $suma;

oci_close($conn);

}


?>

