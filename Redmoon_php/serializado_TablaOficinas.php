<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');


$conn = db_connect();

if(isset($_POST["xPOBLACION"]))
  do_queryPOBLACION($conn, 'SELECT NOMBRE,cod_postal,DIRECCION,POBLACION,provincia,PERSONA_CONTACTO FROM Oficinas WHERE POBLACION like :xPOBLACION');
  
if(isset($_POST["xNombre"]))
  do_queryNombre($conn, 'SELECT NE , NIF, APENOMBRE, MOVIL, TELEFONO, EMAIL FROM VWCLIENTESHIPO WHERE APENOMBRE like :xNombre');

if(isset($_POST["xExpe"]))
  do_queryExpe($conn, 'SELECT NE , NIF, APENOMBRE, MOVIL, TELEFONO, EMAIL FROM VWCLIENTESHIPO WHERE NE=:xExpe');
  
// Execute query and display results
function do_queryPOBLACION($conn, $query)
{
	$time_start = microtime(true);
	
$xPOBLA = $_POST["xPOBLACION"].'%';
$stid = oci_parse($conn, $query);
oci_bind_by_name($stid, ':xPOBLACION', $xPOBLA, 25, SQLT_CHR);


$r = oci_execute($stid, OCI_DEFAULT);

	$suma="";
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		foreach ($row as $key =>$field) 
			{
			$field = iconv ('Windows-1252', 'UTF-8//TRANSLIT',$field);
			$suma=$suma.$field.'|';
			}
	}
// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;
	
$numero_bytes=strlen($suma);
$url='serializado_MayorCuantia.php';
$opcion='Listado de expedientes de mayor cuantia pendientes de aprobar';

include 'Test_Medicion_Datos.inc';
	
echo $suma;
}

// Execute query and display results
function do_queryNombre($conn, $query)
{
	$time_start = microtime(true);
	
$xNombre = '%'.$_POST["xNombre"].'%';
$stid = oci_parse($conn, $query);
oci_bind_by_name($stid, ':xNombre', $xNombre, 40, SQLT_CHR);


$r = oci_execute($stid, OCI_DEFAULT);

	$suma="";
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		foreach ($row as $key =>$field) 
			{
			$field = iconv ('Windows-1252', 'UTF-8//TRANSLIT',$field);
			$suma=$suma.$field.'|';
			}
	}
// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;
	
$numero_bytes=strlen($suma);
$url='serializado_MayorCuantia.php';
$opcion='Listado de expedientes de mayor cuantia pendientes de aprobar';

include 'Test_Medicion_Datos.inc';
	
echo $suma;
oci_close($conn);
}


function do_queryExpe($conn, $query)
{
	$time_start = microtime(true);
	
$xExpe = $_POST["xExpe"];
$stid = oci_parse($conn, $query);
oci_bind_by_name($stid, ':xExpe', $xExpe, 38, SQLT_INT);


$r = oci_execute($stid, OCI_DEFAULT);

	$suma="";
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		foreach ($row as $key =>$field) 
			{
			$field = iconv ('Windows-1252', 'UTF-8//TRANSLIT',$field);
			$suma=$suma.$field.'|';
			}
	}
// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;
	
$numero_bytes=strlen($suma);
$url='serializado_MayorCuantia.php';
$opcion='Listado de expedientes de mayor cuantia pendientes de aprobar';

include 'Test_Medicion_Datos.inc';
	
echo $suma;
oci_close($conn);
}


?>

