<?php 

//
// Marial del Mar Pérez Fajardo
// Agosto 2009
//

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

$conn = db_connect();

			$xIDExpe =(int) $_GET["xIDExpe"];
			
			$sql="BEGIN FacturaCliente(:xIDExpe); END;";
			
			
			$stid = oci_parse($conn, $sql);
			
			oci_bind_by_name($stid, ':xIDExpe', $xIDExpe, 38, SQLT_INT);

	if(oci_execute($stid))
	{
		oci_close($conn);
	    header("Location: ../FacturacionAClientes.php");
	     
	}
	else
	   echo "Error";

oci_close($conn);
?>