<?php

require_once('controlSesiones.inc.php');
require_once('pebi_cn.inc.php');
require_once('pebi_db.inc.php');

$conn = db_connect();
  
// Borrar la tabla temporal
$sql='delete from TMP_ASUNTOS where USUARIO=:xUser';
$stmt = oci_parse($conn, $sql);

$xUser=$_SESSION["usuario"];
oci_bind_by_name($stmt, ':xUser', $xUser, 30, SQLT_CHR);

if(!oci_execute($stmt))
   echo "Error";
   
// añadir a la tabla temporal los asuntos elegidos por el usuario	   		
foreach ($_POST as $key =>$val)
{
	//echo $key.'-'.$val.'<br />';
	if(substr($key,0,3)=="ID-")
	{
		// insertar en la tabla temporal de asuntos del expediente
		$trozos=explode('-', $key);
		
		
		$sql='Insert into TMP_ASUNTOS (USUARIO, ID, OPR_IMPORTE) values (:xUser,:xIDActo, :xOPR_IMPORTE)';
		$stmt = oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':xIDActo', $xIDActo, 38, SQLT_INT);
		oci_bind_by_name($stmt, ':xOPR_IMPORTE', $xOPR_IMPORTE, 10);
		oci_bind_by_name($stmt, ':xUser', $xUser, 30, SQLT_CHR);

		// contiene el ID de la tabla	 
		$xIDActo=(int)$trozos[1];
		// contiene el importe del asunto
		$xOPR_IMPORTE=$val;
		
		if(!oci_execute($stmt))
	   		echo "Error";
		
	}
}


$sql='BEGIN pkAsuntos.putDacionAsuntosContratados(:xNE,:xOBSERVACIONES,:xUser); END;';
$stmt = oci_parse($conn, $sql);

$xNE=(int) $_POST["xIDExpe"];
$xOBSERVACIONES=$_POST["Observaciones"];

oci_bind_by_name($stmt, ':xNE', $xNE, 38, SQLT_INT);
oci_bind_by_name($stmt, ':xOBSERVACIONES', $xOBSERVACIONES, 70, SQLT_CHR);
oci_bind_by_name($stmt, ':xUser', $xUser, 30, SQLT_CHR);

if(oci_execute($stmt))
 echo "Ok";
else
   echo "Error";

oci_close($conn);
?>