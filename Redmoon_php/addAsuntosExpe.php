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


$sql='BEGIN pkAsuntos.putAsuntosContratados(:xNE,:xOBSERVACIONES,:xVENCIMIENTO,:xNUMERO_CUOTAS, :xINTERES, :xTIPO_INTERES, :xTIPO_REFERENCIA, :xREVISION, :xDIFERENCIAL, :xUser, :xNumFincas); END;';
$stmt = oci_parse($conn, $sql);

$xNE=(int) $_POST["xIDExpe"];
$NumFincas=$_POST["idNuFincas"];
$xVENCIMIENTO=$_POST["Vencimiento"];
$xNUMERO_CUOTAS=(int)$_POST["NumeCuotas"];
$xINTERES=$_POST["Interes"];
$xTIPO_INTERES=$_POST["TipoInteres"];
$xTIPO_REFERENCIA=$_POST["TipoReferencia"];
$xREVISION=$_POST["Revision"];
$xDIFERENCIAL=$_POST["Diferencial"];
$xOBSERVACIONES=$_POST["Observaciones"];

oci_bind_by_name($stmt, ':xNE', $xNE, 38, SQLT_INT);
oci_bind_by_name($stmt, ':xNumFincas', $NumFincas, 10);
oci_bind_by_name($stmt, ':xOBSERVACIONES', $xOBSERVACIONES, 70, SQLT_CHR);
oci_bind_by_name($stmt, ':xVENCIMIENTO', $xVENCIMIENTO, 40, SQLT_CHR);
oci_bind_by_name($stmt, ':xNUMERO_CUOTAS', $xNUMERO_CUOTAS, 38, SQLT_INT);
oci_bind_by_name($stmt, ':xINTERES', $xINTERES, 10);
oci_bind_by_name($stmt, ':xTIPO_INTERES', $xTIPO_INTERES, 10, SQLT_CHR);
oci_bind_by_name($stmt, ':xTIPO_REFERENCIA', $xTIPO_REFERENCIA, 10, SQLT_CHR);
oci_bind_by_name($stmt, ':xREVISION', $xREVISION, 10, SQLT_CHR);
oci_bind_by_name($stmt, ':xDIFERENCIAL', $xDIFERENCIAL, 10);
oci_bind_by_name($stmt, ':xUser', $xUser, 30, SQLT_CHR);


if(oci_execute($stmt))
 echo "Ok";
else{
   echo "Error";
   db_error($stmt, __FILE__, __LINE__);
}

oci_close($conn);
?>