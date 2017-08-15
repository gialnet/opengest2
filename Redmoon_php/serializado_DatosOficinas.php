<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

// Create a database connection
//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();




if (isset($_POST['xNOMBRE']))
	do_queryNombre($conn, "select oficina,nombre,poblacion,EMAIL from oficinas  where nombre like UPPER(:xNombre) order by oficina");
else 
	do_queryTodo($conn, 'select oficina,nombre,poblacion,EMAIL from oficinas order by oficina');

// Execute query and display results
function do_queryTodo($conn, $query)
{
	$time_start = microtime(true);
	
if (!isset($_POST['xPag']))
	$xPag=1;
else 
	$xPag=$_POST['xPag'];

	$resultado=db_get_page_data($conn, $query, $xPag, 10);
	$suma='';
	for ($j=0; $j <=(count($resultado)-1); $j++)
	{
	
	$suma=$suma.$resultado[$j]['OFICINA'].'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['NOMBRE']).'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['POBLACION']).'|';
	$suma=$suma.$resultado[$j]['EMAIL'].'|';
	
	}


// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;
	
$numero_bytes=strlen($suma);
$url='serializado_DatosOficinas.php';
$opcion='Lista de Oficinas';

include 'Test_Medicion_Datos.inc';

echo $suma;

oci_close($conn);

}


function do_queryNombre($conn, $query)
{
$time_start = microtime(true);

	// SE PONE LA PAGINA A UNO PUES VAN A SALIR POCAS TUPLAS
	$xPag=1;
	
	$bindargs = array();
	$xNombre='%'.$_POST['xNOMBRE'].'%';
	array_push($bindargs, array('XNOMBRE',$xNombre,200));

	$resultado=db_get_page_data($conn, $query, $xPag, 10, $bindargs);
	$suma='';
	for ($j=0; $j <=(count($resultado)-1); $j++)
	{
	$suma=$suma.$resultado[$j]['OFICINA'].'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['NOMBRE']).'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['POBLACION']).'|';
	$suma=$suma.$resultado[$j]['EMAIL'].'|';
	}
// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;
	
$numero_bytes=strlen($suma);
$url='serializado_DatosOficinas.php';
$opcion='Listado de Oficinas';

include 'Test_Medicion_Datos.inc';
	
echo $suma;

oci_close($conn);

}

?>

