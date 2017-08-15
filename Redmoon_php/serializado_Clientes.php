<?php 


require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

// Create a database connection
//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();

if(isset($_POST["xNIF"]))
  do_queryNIF($conn, 'SELECT ID,NIF,APENOMBRE,DOMICILIO,NUMEROCUENTA FROM CLIENTES WHERE NIF like :xNIF order by nif');
  
if(isset($_POST["xNombre"]))
  do_queryNombre($conn, 'SELECT ID,NIF,APENOMBRE,DOMICILIO,NUMEROCUENTA FROM CLIENTES WHERE APENOMBRE like :xNombre order by APENOMBRE');
  

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
	
	$suma=$suma.$resultado[$j]['ID'].'|';
	$suma=$suma.$resultado[$j]['NIF'].'|';
	$suma=$suma.iconv('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['APENOMBRE']).'|';
	$suma=$suma.iconv('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['DOMICILIO']).'|';
	$suma=$suma.$resultado[$j]['NUMEROCUENTA'].'|';

	
	}
	
if (count($resultado)==0)
	echo 'NoDataFound';
else {
	
	// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;

$numero_bytes=strlen($suma);
$url='serializado_Clientes.php';
$opcion='Busca Clientes de un NIF ordenado por NIF';

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
	
	
	$suma=$suma.$resultado[$j]['ID'].'|';
	$suma=$suma.$resultado[$j]['NIF'].'|';
	$suma=$suma.iconv('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['APENOMBRE']).'|';
	$suma=$suma.iconv('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['DOMICILIO']).'|';
	$suma=$suma.$resultado[$j]['NUMEROCUENTA'].'|';
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
$url='serializado_Clientes.php';
$opcion='Busca Clientes ordenado por nombre';

include 'Test_Medicion_Datos.inc';
	
	echo $suma;
}
	
oci_close($conn);
}


?>
