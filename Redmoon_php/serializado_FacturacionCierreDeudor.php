<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

// Create a database connection
$conn = db_connect();

do_queryTodo($conn, 'SELECT NE,NIF,APENOMBRE,CUANTIA,IMP_PROVISION,IMPORTE FROM VWCerradoSaldoDeudor');
   
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
		$suma=$suma.number_format($resultado[$j]['CUANTIA'], 0, ',', '.').' &#8364;'.'|';
		$suma=$suma.number_format($resultado[$j]['IMP_PROVISION'], 0, ',', '.').' &#8364;'.'|';
		$suma=$suma.number_format($resultado[$j]['IMPORTE'], 0, ',', '.').' &#8364;'.'|';
	}
	

// descomentar para grabar estadisticas de medici�n de caudal

// A configurar en cada m�dulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;
	
$numero_bytes=strlen($suma);
$url='serializado_FacturacionCierreDeudor.php';
$opcion='Expedientes Cerrados con saldo deudor';

include 'Test_Medicion_Datos.inc';

echo $suma;
oci_close($conn);
}


?>

