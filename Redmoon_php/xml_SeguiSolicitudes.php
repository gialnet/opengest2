<?php 

require('controlSesiones.inc.php');

require('pebi_cn.inc.php');
require('pebi_db.inc.php'); 

//header('Content-type: application/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>';


// Create a database connection

$conn = db_connect();
do_query($conn, 'SELECT NIF, APENOMBRE, MOVIL, TELEFONO, EMAIL, NE FROM VWCLIENTESHIPO WHERE Trim(NIF)=:xNIF');


// Execute query and display results
function do_query($conn, $query)
{
$stid = oci_parse($conn, $query);
oci_bind_by_name($stid, ':xNIF', $xNIF, 14, SQLT_CHR);
$xNIF = $_POST["xNIF"];

$r = oci_execute($stid, OCI_DEFAULT);

	echo "<records>\n";

	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		echo "<record>\n";
		foreach ($row as $key =>$field) 
			{
			$field = htmlspecialchars($field, ENT_NOQUOTES);
			echo "<$key>$field</$key>\n";
			}
		echo "</record>\n";
	}
	echo "</records>\n";
}

?>

