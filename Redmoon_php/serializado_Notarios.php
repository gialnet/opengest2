<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

// Create a database connection
$conn = db_connect();


   

if (isset($_POST['xNOMBRE']))
	do_queryNombre($conn, "SELECT COD_NOTARIO, NIF, NOMBRE, DIRECCION, POBLACION FROM Notarios where nombre like UPPER(:xNombre)");
else {
	if (isset($_POST['xPOBLA']))
	do_queryPobla($conn, "SELECT COD_NOTARIO, NIF, NOMBRE, DIRECCION, POBLACION FROM Notarios where POBLACION like UPPER(:xPobla)");
	else
	do_queryTodo($conn, 'SELECT COD_NOTARIO, NIF, NOMBRE, DIRECCION, POBLACION FROM Notarios');
}

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
	
	$suma=$suma.$resultado[$j]['COD_NOTARIO'].'|';
	$suma=$suma.$resultado[$j]['NIF'].'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['NOMBRE']).'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['DIRECCION']).'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['POBLACION']).'|';
	
	}


// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;

$numero_bytes=strlen($suma);
$url='serializado_Notarios.php';
$opcion='Listado de Notarios';

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
	array_push($bindargs, array('XNOMBRE',$xNombre,100));

	$resultado=db_get_page_data($conn, $query, $xPag, 10, $bindargs);
	$suma='';
	for ($j=0; $j <=(count($resultado)-1); $j++)
	{
	
	$suma=$suma.$resultado[$j]['COD_NOTARIO'].'|';
	$suma=$suma.$resultado[$j]['NIF'].'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['NOMBRE']).'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['DIRECCION']).'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['POBLACION']).'|';
	}
// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;
	
$numero_bytes=strlen($suma);
$url='serializado_Notarios.php';
$opcion='Listado de Notarios busqueda por nombre';

include 'Test_Medicion_Datos.inc';
	
echo $suma;

oci_close($conn);

}



function do_queryPobla($conn, $query)
{
$time_start = microtime(true);

	// SE PONE LA PAGINA A UNO PUES VAN A SALIR POCAS TUPLAS
	$xPag=1;
	
	$bindargs = array();
	$xPobla='%'.$_POST['xPOBLA'].'%';
	array_push($bindargs, array('xPOBLA',$xPobla,100));

	$resultado=db_get_page_data($conn, $query, $xPag, 10, $bindargs);
	$suma='';
	for ($j=0; $j <=(count($resultado)-1); $j++)
	{
	
	$suma=$suma.$resultado[$j]['COD_NOTARIO'].'|';
	$suma=$suma.$resultado[$j]['NIF'].'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['NOMBRE']).'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['DIRECCION']).'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['POBLACION']).'|';
	}
// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;
	
$numero_bytes=strlen($suma);
$url='serializado_Notarios.php';
$opcion='Listado de Notarios busqueda por poblacion';

include 'Test_Medicion_Datos.inc';
	
echo $suma;

oci_close($conn);

}

?>
