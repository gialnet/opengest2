<?php 

require_once('controlSesiones.inc.php');
require_once('pebi_cn.inc.php');
require_once('pebi_db.inc.php');

// Create a database connection
//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();

// controlar que las oficinas sólo acceden a sus expedientes
if ($Rol_controlSesiones==7)
{
	$xOficina=$_SESSION["oficina"];
	
	$sqlNIF="SELECT NE,FECHA_APERTURA,TIPO,NIF,APENOMBRE,CUANTIA FROM VWExpeClientesTodos WHERE NIF like :xNIF and Oficina=$xOficina order by nif,ne";
	$sqlNombre="SELECT NE,FECHA_APERTURA,TIPO,NIF,APENOMBRE,CUANTIA FROM VWExpeClientesTodos WHERE APENOMBRE like :xNombre and Oficina=$xOficina order by APENOMBRE,ne";
	$sqlExpe="SELECT NE,FECHA_APERTURA,TIPO,NIF,APENOMBRE,CUANTIA FROM VWExpeClientesTodos WHERE NE=:xExpe and Oficina=$xOficina";
	$sqlFechas="SELECT NE,FECHA_APERTURA,TIPO,NIF,APENOMBRE,CUANTIA FROM VWExpeClientesTodos WHERE FECHA_APERTURA between to_date(:xFecha1) and to_date(:xFecha2) and Oficina=$xOficina order by FECHA_APERTURA"; 
}
else 
{
	$sqlNIF='SELECT NE,FECHA_APERTURA,TIPO,NIF,APENOMBRE,CUANTIA FROM VWExpeClientesTodos WHERE NIF like :xNIF order by nif,ne';
	$sqlNombre='SELECT NE,FECHA_APERTURA,TIPO,NIF,APENOMBRE,CUANTIA FROM VWExpeClientesTodos WHERE APENOMBRE like :xNombre order by APENOMBRE,ne';
	$sqlExpe='SELECT NE,FECHA_APERTURA,TIPO,NIF,APENOMBRE,CUANTIA FROM VWExpeClientesTodos WHERE NE=:xExpe';
	$sqlFechas='SELECT NE,FECHA_APERTURA,TIPO,NIF,APENOMBRE,CUANTIA FROM VWExpeClientesTodos WHERE FECHA_APERTURA between to_date(:xFecha1) and to_date(:xFecha2) order by FECHA_APERTURA';
}

if(isset($_POST["xNIF"]))
  do_queryNIF($conn, $sqlNIF);
  
if(isset($_POST["xNombre"]))
  do_queryNombre($conn, $sqlNombre);

if(isset($_POST["xExpe"]))
  do_queryExpe($conn, $sqlExpe);
  
if(isset($_POST["xFecha1"]))
  do_queryFecha($conn, $sqlFechas);
    
// Execute query and display results
function do_queryNIF($conn, $query)
{

	$time_start = microtime(true);
	
$xNIF = $_POST["xNIF"].'%';

$bindargs = array();
array_push($bindargs, array('XNIF',$xNIF,14));


if (!isset($_POST['xPag']))
	$xPag=1;
else 
	$xPag=$_POST['xPag'];

	$resultado=db_get_page_data($conn, $query, $xPag, 15, $bindargs);
	$suma='';
	for ($j=0; $j <=(count($resultado)-1); $j++)
	{
	
	$suma=$suma.$resultado[$j]['NE'].'|';
	$suma=$suma.$resultado[$j]['FECHA_APERTURA'].'|';
	$suma=$suma.$resultado[$j]['TIPO'].'|';
	$field=number_format($resultado[$j]['CUANTIA'], 0, ',', '.').' &#8364;';
	$suma=$suma.$field.'|';
	$suma=$suma.$resultado[$j]['NIF'].'|';
	//$suma=$suma.$resultado[$j]['APENOMBRE'].'|';
	$suma=$suma.iconv('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['APENOMBRE']).'|';
	
	}
	
if (count($resultado)==0)
	echo 'NoDataFound';
else {
	
	// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;

$numero_bytes=strlen($suma);
$url='serializado_SeguiSolicitudes.php';
$opcion='Busca Expedientes de un NIF ordenado por NIF,NE';

include 'Test_Medicion_Datos.inc';
	
	echo $suma;
}
	
	
oci_close($conn);
}

// Execute query and display results
function do_queryNombre($conn, $query)
{
		$time_start = microtime(true);
		
$xNombre = '%'.$_POST["xNombre"].'%';

$bindargs = array();
array_push($bindargs, array('XNOMBRE',$xNombre,40));


if (!isset($_POST['xPag']))
	$xPag=1;
else 
	$xPag=$_POST['xPag'];

	$resultado=db_get_page_data($conn, $query, $xPag, 15, $bindargs);
	$suma='';
	for ($j=0; $j <=(count($resultado)-1); $j++)
	{
	
	$suma=$suma.$resultado[$j]['NE'].'|';
	$suma=$suma.$resultado[$j]['FECHA_APERTURA'].'|';
	$suma=$suma.$resultado[$j]['TIPO'].'|';
	$field=number_format($resultado[$j]['CUANTIA'], 0, ',', '.').' &#8364;';
	$suma=$suma.$field.'|';
	$suma=$suma.$resultado[$j]['NIF'].'|';
	//$suma=$suma.$resultado[$j]['APENOMBRE'].'|';
	$suma=$suma.iconv('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['APENOMBRE']).'|';
	
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
$url='serializado_SeguiSolicitudes.php';
$opcion='Busca Expedientes Por Nombre ordenado por Nombre';

include 'Test_Medicion_Datos.inc';
	
	echo $suma;
}
	
oci_close($conn);
}


function do_queryExpe($conn, $query)
{
		$time_start = microtime(true);

	$xExpe = $_POST["xExpe"];

$bindargs = array();
array_push($bindargs, array('XEXPE',$xExpe,38));


if (!isset($_POST['xPag']))
	$xPag=1;
else 
	$xPag=$_POST['xPag'];

	$resultado=db_get_page_data($conn, $query, $xPag, 15, $bindargs);
	$suma='';
	for ($j=0; $j <=(count($resultado)-1); $j++)
	{
	
	$suma=$suma.$resultado[$j]['NE'].'|';
	$suma=$suma.$resultado[$j]['FECHA_APERTURA'].'|';
	$suma=$suma.$resultado[$j]['TIPO'].'|';
	$field=number_format($resultado[$j]['CUANTIA'], 0, ',', '.').' &#8364;';
	$suma=$suma.$field.'|';
	$suma=$suma.$resultado[$j]['NIF'].'|';
	$suma=$suma.iconv('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['APENOMBRE']).'|';
	//$suma=$suma.$resultado[$j]['APENOMBRE'].'|';
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
$url='serializado_SeguiSolicitudes.php';
$opcion='Busca Expedientes por numero de Expediente';

include 'Test_Medicion_Datos.inc';
	
	echo $suma;
}

oci_close($conn);
}

function do_queryFecha($conn, $query)
{
		$time_start = microtime(true);

	$xFecha1 = $_POST["xFecha1"];
	$xFecha2 = $_POST["xFecha2"];

$bindargs = array();
array_push($bindargs, array('XFECHA1',$xFecha1,10));
array_push($bindargs, array('XFECHA2',$xFecha2,10));


if (!isset($_POST['xPag']))
	$xPag=1;
else 
	$xPag=$_POST['xPag'];

	$resultado=db_get_page_data($conn, $query, $xPag, 15, $bindargs);
	$suma='';
	for ($j=0; $j <=(count($resultado)-1); $j++)
	{
	
	$suma=$suma.$resultado[$j]['NE'].'|';
	$suma=$suma.$resultado[$j]['FECHA_APERTURA'].'|';
	$suma=$suma.$resultado[$j]['TIPO'].'|';
	$field=number_format($resultado[$j]['CUANTIA'], 0, ',', '.').' &#8364;';
	$suma=$suma.$field.'|';
	$suma=$suma.$resultado[$j]['NIF'].'|';
	$suma=$suma.iconv('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['APENOMBRE']).'|';
	//$suma=$suma.$resultado[$j]['APENOMBRE'].'|';
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
$url='serializado_SeguiSolicitudes.php';
$opcion='Busca Expedientes en un intervalo de fechas';

include 'Test_Medicion_Datos.inc';
	
	echo $suma;
}

oci_close($conn);
}

?>
