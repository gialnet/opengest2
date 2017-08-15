<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

// Create a database connection
//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();

do_queryTodo($conn, 'SELECT ID,DESCRIPCION,REGLA,VALOR_INICIAL,INTERVALO,IMPORTE_TRAMO FROM VWTARIFAS_CONCEPTO WHERE ZONA=:xZona AND TIPO_ACTO=:xTipoActo ORDER BY TIPO_ASUNTO,ACTOS_ASUNTOS');
   
// Execute query and display results
function do_queryTodo($conn, $query)
{
$time_start = microtime(true);

$stid = oci_parse($conn, $query);

$xTipoActo=$_POST["xTipoActo"];
$xZona=$_POST["xZona"];

oci_bind_by_name($stid, ':xTipoActo', $xTipoActo, 10, SQLT_CHR);
oci_bind_by_name($stid, ':xZona', $xZona, 2, SQLT_CHR);


$r = oci_execute($stid, OCI_DEFAULT);

	$suma="";
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		foreach ($row as $key =>$field) 
			{
			$field = iconv('Windows-1252', 'UTF-8//TRANSLIT', $field);
			if ($key!='DESCRIPCION' and $key!='REGLA')
				$field=number_format($field, 0, ',', '.').' &#8364;';
				
			$suma=$suma.$field.'|';
			}
	}
// descomentar para grabar estadisticas de medici�n de caudal

// A configurar en cada m�dulo =======================
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

