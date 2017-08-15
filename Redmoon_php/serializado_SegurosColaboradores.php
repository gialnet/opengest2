<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

// Create a database connection
//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();


if (isset($_POST['xNombre']))
	do_queryNombre($conn, "select id, nif, nombre,provincia,fecha_seguro from colaboradores 
	where NOMBRE like UPPER(:xNom) AND (fecha_seguro <= to_date(sysdate) or fecha_seguro is null)");
else {
	
	if(isset($_POST['xProv']))
	do_queryProv($conn, 'select id, nif, nombre,provincia,fecha_seguro from colaboradores 
	where provincia like UPPER(:xProv)  AND (fecha_seguro <= to_date(sysdate) or fecha_seguro is null)');
   else 
	do_queryTodo($conn, 'select id, nif, nombre,provincia,fecha_seguro from colaboradores where fecha_seguro <= to_date(sysdate) or fecha_seguro is null');
 
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
	
	$suma=$suma.$resultado[$j]['ID'].'|';
	$suma=$suma.$resultado[$j]['NIF'].'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['NOMBRE']).'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['PROVINCIA']).'|';
	$suma=$suma.$resultado[$j]['FECHA_SEGURO'].'|';
	}
// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;
	
$numero_bytes=strlen($suma);
$url='serializado_SegurosColaboradores.php';
$opcion='Listado de los colaboradores con fecha de seguro caducada o inexistente';

include 'Test_Medicion_Datos.inc';
	
echo $suma;

oci_close($conn);

}





// Execute query and display results
function do_queryProv($conn, $query)
{
		$time_start = microtime(true);
		
$xProv = '%'.$_POST["xProv"].'%';

$bindargs = array();
array_push($bindargs, array('XPROV',$xProv,25));


if (!isset($_POST['xPag']))
	$xPag=1;
else 
	$xPag=$_POST['xPag'];

	$resultado=db_get_page_data($conn, $query, $xPag, 10, $bindargs);
	$suma='';
	for ($j=0; $j <=(count($resultado)-1); $j++)
	{
	
	$suma=$suma.$resultado[$j]['ID'].'|';
	$suma=$suma.$resultado[$j]['NIF'].'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['NOMBRE']).'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['PROVINCIA']).'|';
	$suma=$suma.$resultado[$j]['FECHA_SEGURO'].'|';
	
	}

if (count($resultado)==0)
	echo 'NoDataFound';
else 
{
	
	// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;

$numero_bytes=strlen($suma);
$url='serializado_SegurosColaboradores.php';
$opcion='Listado de los colaboradores con fecha de seguro caducada o inexistente buscados por provincia';

include 'Test_Medicion_Datos.inc';
	
	echo $suma;
}
	
oci_close($conn);
}



// Execute query and display results
function do_queryNombre($conn, $query)
{
		$time_start = microtime(true);
		
$xNom = '%'.$_POST["xNombre"].'%';

$bindargs = array();
array_push($bindargs, array('XNOM',$xNom,50));


if (!isset($_POST['xPag']))
	$xPag=1;
else 
	$xPag=$_POST['xPag'];

	$resultado=db_get_page_data($conn, $query, $xPag, 10, $bindargs);
	$suma='';
	for ($j=0; $j <=(count($resultado)-1); $j++)
	{
	
	$suma=$suma.$resultado[$j]['ID'].'|';
	$suma=$suma.$resultado[$j]['NIF'].'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['NOMBRE']).'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['PROVINCIA']).'|';
	$suma=$suma.$resultado[$j]['FECHA_SEGURO'].'|';
	
	}

if (count($resultado)==0)
	echo 'NoDataFound';
else 
{
	
	// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;

$numero_bytes=strlen($suma);
$url='serializado_SegurosColaboradores.php';
$opcion='Listado de los colaboradores con fecha de seguro caducada o inexistente buscados por nombre';

include 'Test_Medicion_Datos.inc';
	
	echo $suma;
}
	
oci_close($conn);
}




?>

