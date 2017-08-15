<?php 

require('controlSesiones.inc');

require('pebi_cn.inc.php');
require('pebi_db.inc.php');

// Create a database connection

$conn = db_connect();

do_queryTodo($conn, 'SELECT IMPORTE FROM VWPAGOS_COLABORADORES');
   
// Execute query and display results
function do_queryTodo($conn, $query)
{
//$xColabora=26; // Ejemplo de un colaborador : JOSE MARIA RODRIGUEZ MILLAN
//$xFASE=$_POST["xFASE"];
$stid = oci_parse($conn, $query);
//oci_bind_by_name($stid, ':xFASE', $xFASE, 4, SQLT_CHR);



$r = oci_execute($stid, OCI_DEFAULT);

	$suma="";
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		foreach ($row as $key =>$field) 
			{
			$field = htmlspecialchars($field, ENT_NOQUOTES);
			$suma=$suma.$field.'|';
			}
	}
echo $suma;
}


?>

