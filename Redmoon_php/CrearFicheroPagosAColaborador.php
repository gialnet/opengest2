<<<<<<< .mine
<?php require('controlSesiones.inc.php');  ?>
<?php 
=======
<?php 

require('controlSesiones.inc.php');
>>>>>>> .r60

require('pebi_cn.inc.php');
require('pebi_db.inc.php');

// Create a database connection

$conn = db_connect();

do_queryTodo($conn, 'SELECT NE,NIF,APENOMBRE,FASE,IMPORTE FROM VWPAGOS_COLABORADORES');
   
// Execute query and display results
function do_queryTodo($conn, $query)
{
	
$stid = oci_parse($conn, $query);



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

