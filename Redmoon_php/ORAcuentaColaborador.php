<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');


if(isset($_POST["xID"]))
{ 

$xID=(int)$_POST["xID"];
$xinUsoCC=$_POST["inUsoCC"];
$xinEntidad=$_POST["inEntidad"];
$xinSucursal=$_POST["inSucursal"];
$xinDC=$_POST["inDC"];
$xinNcuenta=$_POST["inNcuenta"];

$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'UPDATE COLABORADORES_CUENTAS 
	SET ENTIDAD=:xinEntidad,SUCURSAL=:xinSucursal,DC=:xinDC,NCUENTA=:xinNcuenta 
	WHERE ID=:xID';


    $stmt = oci_parse($conn, $sql);
    
  
    
    oci_bind_by_name($stmt, ':xID', $xID, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':xinUsoCC', $xinUsoCC, 3, SQLT_CHR);
    oci_bind_by_name($stmt, ':xinEntidad', $xinEntidad,4, SQLT_CHR);
    oci_bind_by_name($stmt, ':xinSucursal', $xinSucursal,4, SQLT_CHR);
    oci_bind_by_name($stmt, ':xinDC', $xinDC, 2, SQLT_CHR);
    oci_bind_by_name($stmt, ':xinNcuenta', $xinNcuenta,10, SQLT_CHR);
    
    $url='Location: ../Colaboradores.php?xIDColaborador='.$_POST["xIDColaborador"];
    
	if(oci_execute($stmt))
	{
	     header($url);
	}
	else
	   echo "Error";
}
else
	echo "No";	
?>
