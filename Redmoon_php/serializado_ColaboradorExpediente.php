<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

// Create a database connection
//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();

$query="select e.ne,ce.nif_cliente,c.apenombre, NOMBRE_FASE(e.fase) AS estado ".
	"from expedientes e, clientes_expe ce, clientes c ".
	"where e.ne in (select ne from seguimiento where colaborador=:xColaborador group by ne) ".
	"and ce.ne=e.ne	and c.nif=ce.nif_cliente and ce.sujeto='T' and rownum <=30 ".
  	"order by e.ne desc";

$query2="select e.ne,ce.nif_cliente,c.apenombre, NOMBRE_FASE(e.fase) AS estado ".
	"from expedientes e, clientes_expe ce, clientes c ".
	"where e.ne in (select ne from seguimiento where colaborador IS NOT NULL group by ne) ".
	"and ce.ne=e.ne	and c.nif=ce.nif_cliente and ce.sujeto='T' and rownum <=30 ".
  	"order by e.ne desc";

if(isset($_POST["xColabora"]) and $_POST["xColabora"]!=null)
 do_queryColabora($conn, $query);
else 
 do_queryTodo($conn, $query2);

// Execute query and display results
function do_queryTodo($conn, $query)
{
	
$time_start = microtime(true);

if (!isset($_POST['xPag']))
	$xPag=1;
else 
	$xPag=$_POST['xPag'];

	$resultado=db_get_page_data($conn, $query, $xPag, 15);
	$suma='';
	for ($j=0; $j <=(count($resultado)-1); $j++)
	{
	
	$suma=$suma.$resultado[$j]['NE'].'|';
	$suma=$suma.$resultado[$j]['NIF_CLIENTE'].'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['APENOMBRE']).'|';
	$suma=$suma.$resultado[$j]['ESTADO'].'|';
	}


// descomentar para grabar estadisticas de medición de caudal

// A configurar en cada módulo =======================

$time_end = microtime(true);
$time = $time_end - $time_start;

$numero_bytes=strlen($suma);
$url='serializado_ColaboradorExpediente.php';
$opcion='Todos los expedientes abiertos de todos los Colaboradores';

include 'Test_Medicion_Datos.inc';

echo $suma;

oci_close($conn);
}

function do_queryColabora($conn, $query)
{
	$time_start = microtime(true);
	
$xColabora=$_POST["xColabora"]; // Ejemplo de un colaborador : JOSE MARIA RODRIGUEZ MILLAN
$bindargs = array();
array_push($bindargs, array('XCOLABORADOR',$xColabora,38));

if (!isset($_POST['xPag']))
	$xPag=1;
else 
	$xPag=$_POST['xPag'];

	$resultado=db_get_page_data($conn, $query, $xPag, 15, $bindargs);
	$suma='';
	for ($j=0; $j <=(count($resultado)-1); $j++)
	{
	
	$suma=$suma.$resultado[$j]['NE'].'|';
	$suma=$suma.$resultado[$j]['NIF_CLIENTE'].'|';
	$suma=$suma.iconv ('Windows-1252', 'UTF-8//TRANSLIT', $resultado[$j]['APENOMBRE']).'|';
	$suma=$suma.$resultado[$j]['ESTADO'].'|';
	}

// A configurar en cada módulo =======================
$time_end = microtime(true);
$time = $time_end - $time_start;
	
$numero_bytes=strlen($suma);
$url='serializado_ColaboradorExpediente.php';
$opcion='Todos los expedientes abiertos de un Colaborador';

include 'Test_Medicion_Datos.inc';

	
echo $suma;

oci_close($conn);
}


?>

