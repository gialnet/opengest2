<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

// Create a database connection
//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();

if(isset($_POST["xNIF"]))
  do_queryNIF($conn, 'SELECT NE,NIF,APENOMBRE,PROVISION,PROINGRE FROM VWPENDIENTES_PROVISION WHERE NIF like :xNIF order by nif,ne');
  
if(isset($_POST["xNombre"]))
  do_queryNombre($conn, 'SELECT NE,NIF,APENOMBRE,PROVISION,PROINGRE FROM VWPENDIENTES_PROVISION  WHERE APENOMBRE like :xNombre order by APENOMBRE,ne');

if(isset($_POST["xExpe"]))
  do_queryExpe($conn, 'SELECT NE,NIF,APENOMBRE,PROVISION,PROINGRE FROM VWPENDIENTES_PROVISION  WHERE NE=:xExpe');
  
else 
 do_queryTodo($conn, 'SELECT NE,NIF,APENOMBRE,PROVISION,PROINGRE FROM VWPENDIENTES_PROVISION');
   
// Execute query and display results
function do_queryTodo($conn, $query)
{
	$time_start = microtime(true);
	

if (!isset($_POST['xPag']))
	$xPag=1;
else 
	$xPag=$_POST['xPag'];

	$resultado=db_get_page_data($conn, $query, $xPag, 10);

	$suma="";
for ($j=0; $j <=(count($resultado)-1); $j++)
	{
	
	$suma=$suma.$resultado[$j]['NE'].'|';
	$suma=$suma.$resultado[$j]['NIF'].'|';
	$suma=$suma.iconv('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['APENOMBRE']).'|';
	$suma=$suma.number_format($resultado[$j]['PROVISION'], 0, ',', '.').' &#8364;'.'|';
	$suma=$suma.number_format($resultado[$j]['PROINGRE'], 0, ',', '.').' &#8364;'.'|';
	
	
	}

// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;

$numero_bytes=strlen($suma);
$url='serializado_ProvisionFondos.php';
$opcion='Lista de Expedientes Pendientes de Provision de Fondos';

include 'Test_Medicion_Datos.inc';

echo $suma;

oci_close($conn);
}
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

	$resultado=db_get_page_data($conn, $query, $xPag, 10, $bindargs);
	$suma='';
	for ($j=0; $j <=(count($resultado)-1); $j++)
	{
	
	$suma=$suma.$resultado[$j]['NE'].'|';
	$suma=$suma.$resultado[$j]['NIF'].'|';
	$suma=$suma.iconv('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['APENOMBRE']).'|';
	$suma=$suma.number_format($resultado[$j]['PROVISION'], 0, ',', '.').' &#8364;'.'|';
	$suma=$suma.number_format($resultado[$j]['PROINGRE'], 0, ',', '.').' &#8364;'.'|';
	}
	
if (count($resultado)==0)
	echo 'NoDataFound';
else {
	
	// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;

$numero_bytes=strlen($suma);
$url='serializado_FacturacionClientes.php';
$opcion='Busqueda de expedientes finalizados ordenado por NIF,NE';

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

	$resultado=db_get_page_data($conn, $query, $xPag, 10, $bindargs);
	$suma='';
	for ($j=0; $j <=(count($resultado)-1); $j++)
	{
	
	$suma=$suma.$resultado[$j]['NE'].'|';
	$suma=$suma.$resultado[$j]['NIF'].'|';
	$suma=$suma.iconv('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['APENOMBRE']).'|';
	$suma=$suma.number_format($resultado[$j]['PROVISION'], 0, ',', '.').' &#8364;'.'|';
	$suma=$suma.number_format($resultado[$j]['PROINGRE'], 0, ',', '.').' &#8364;'.'|';
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
$url='serializado_FacturacionClientes.php';
$opcion='Busqueda de expedientes finalizados ordenado por Nombre';

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

	$resultado=db_get_page_data($conn, $query, $xPag, 10, $bindargs);
	$suma='';
	for ($j=0; $j <=(count($resultado)-1); $j++)
	{
	
	$suma=$suma.$resultado[$j]['NE'].'|';
	$suma=$suma.$resultado[$j]['NIF'].'|';
	$suma=$suma.iconv('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['APENOMBRE']).'|';
	$suma=$suma.number_format($resultado[$j]['PROVISION'], 0, ',', '.').' &#8364;'.'|';
	$suma=$suma.number_format($resultado[$j]['PROINGRE'], 0, ',', '.').' &#8364;'.'|';
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
$url='serializado_FacturacionClientes.php';
$opcion='Busqueda de expedientes finalizados por ne';

include 'Test_Medicion_Datos.inc';
	
	echo $suma;
}

oci_close($conn);
}



?>

