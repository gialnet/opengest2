<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

if(isset($_POST["xID"]))
{ 

$xID=(int)$_POST["xID"];
$xinUsoCC=$_POST["tipo"];
$xinEntidad=$_POST["entidad"];
$xinSucursal=$_POST["oficina"];
$xinDC=$_POST["DC"];
$xinNcuenta=$_POST["numcuenta"];
//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'insert into colaboradores_cuentas (IDCOLABORA,USO_CC,ENTIDAD,SUCURSAL,DC,NCUENTA) 
values (:xID,:xinUsoCC,:xinEntidad,:xinSucursal,:xinDC,:xinNcuenta)';



    $stmt = oci_parse($conn, $sql);
    
  
    
    oci_bind_by_name($stmt, ':xID', $xID, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':xinUsoCC', $xinUsoCC, 3, SQLT_CHR);
    oci_bind_by_name($stmt, ':xinEntidad', $xinEntidad,4, SQLT_CHR);
    oci_bind_by_name($stmt, ':xinSucursal', $xinSucursal,4, SQLT_CHR);
    oci_bind_by_name($stmt, ':xinDC', $xinDC, 2, SQLT_CHR);
    oci_bind_by_name($stmt, ':xinNcuenta', $xinNcuenta,10, SQLT_CHR);
    
    $url='Location: ../Colaboradores.php?xIDColaborador='.$_POST["xID"];
    
	if(oci_execute($stmt))
	{
	     header($url);
	}
	else{
	   echo "Error";
	   echo $xID.'</br>';
	   echo $xinUsoCC.'</br>';
	   echo $xinEntidad.'</br>';
	   echo $xinSucursal.'</br>';
	   echo $xinDC.'</br>';
	   echo $xinNcuenta.'</br>';
	}
	   

}
else
	echo "No";	
?>
