<<<<<<< .mine
<?php require('controlSesiones.inc.php');  ?>
<?php
=======
<?php 
>>>>>>> .r60

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

if(isset($_POST["xNIF"]))
{ 
	
	//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
	$conn = db_connect();

	$sql = 'BEGIN pkClientes.HTMLBuscaNIF(:xNIF, :xRespuesta); END;';

	$stmt = oci_parse($conn, $sql);

	$xNIF = $_POST["xNIF"];
	oci_bind_by_name($stmt, ':xNIF', $xNIF, 14, SQLT_CHR);
	oci_bind_by_name($stmt, ':xRespuesta', $xRespuesta, 4000, SQLT_CHR);

	

	oci_execute($stmt);

	echo $xRespuesta;	
}
else
	echo "No Encontrado";


?>
