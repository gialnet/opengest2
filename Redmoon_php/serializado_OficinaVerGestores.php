<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

// Create a database connection
//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();

do_queryTodo($conn, 'select g.id, c.nif, c.nombre,c.direccion,c.poblacion ,g.posicion
from colaboradores c,oficinas_gestores g 
where c.id=g.gestor and g.oficina=:xOficina and c.tipo=0');
   
// Execute query and display results
function do_queryTodo($conn, $query)
{
		$time_start = microtime(true);
		
$xOficina=$_POST['xOficina'];

$bindargs = array();
array_push($bindargs, array('XOFICINA',$xOficina,4));
if (!isset($_POST['xPag']))
	$xPag=1;
else 
	$xPag=$_POST['xPag'];
	
	$resultado=db_get_page_data($conn, $query, $xPag, 10,$bindargs);
	$suma='';
	for ($j=0; $j <=(count($resultado)-1); $j++)
	{
	
	$suma=$suma.$resultado[$j]['ID'].'|';
	$suma=$suma.$resultado[$j]['NIF'].'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['NOMBRE']).'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['DIRECCION']).'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['POBLACION']).'|';
	$suma=$suma.$resultado[$j]['POSICION'].'|';
	
	
	}

// descomentar para grabar estadisticas de medici�n de caudal

// A configurar en cada m�dulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;

$numero_bytes=strlen($suma);
$url='serializado_OficinaVerGestores.php';
$opcion='Listado de Gestorias de una Oficina';

include 'Test_Medicion_Datos.inc';

echo $suma;

oci_close($conn);

}


?>

