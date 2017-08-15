<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');


$xNombre=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inNombre"]);
$xNIF=$_POST["inNIF"];
$xCP=$_POST["inCP"];
$xDIRE=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inDireccion"]);
$xPOBLA=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inPoblacion"]);
$xPROV=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inProvincia"]);
$xEntidad=$_POST["inEntidad"];
$xSucursal=$_POST["inOficina"];
$xDC=$_POST["inDC"];
$xNCuenta=$_POST["inCuenta"];

//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = "insert into notarios (NIF,NOMBRE,DIRECCION,PROVINCIA,POBLACION,
	COD_POSTAL,ENTIDAD,OFICINA,DC,CUENTA) 
	values (:xNIF,:xNombre,:xDIRE,:xPROV,:xPOBLA,
	:xCP,:xEntidad,:xSucursal,:xDC,:xNCuenta)";


    $stmt = oci_parse($conn, $sql);
    
  
    
    
    oci_bind_by_name($stmt, ':xNIF', $xNIF, 12, SQLT_CHR);
    oci_bind_by_name($stmt, ':xNombre', $xNombre, 100, SQLT_CHR);
    oci_bind_by_name($stmt, ':xCP', $xCP,5, SQLT_CHR);
    oci_bind_by_name($stmt, ':xDIRE', $xDIRE,50, SQLT_CHR);
    oci_bind_by_name($stmt, ':xPOBLA', $xPOBLA,50, SQLT_CHR);
    oci_bind_by_name($stmt, ':xPROV', $xPROV,50, SQLT_CHR);
    oci_bind_by_name($stmt, ':xEntidad', $xEntidad,4, SQLT_CHR);
    oci_bind_by_name($stmt, ':xSucursal', $xSucursal,4, SQLT_CHR);
    oci_bind_by_name($stmt, ':xDC', $xDC,2, SQLT_CHR);
    oci_bind_by_name($stmt, ':xNCuenta', $xNCuenta,10, SQLT_CHR);
    
    $url='Location: ../NotariosTabla2.php';
	if(oci_execute($stmt))
	{
	     header($url);
	}
	else{
	  
	   
echo $xNombre.'<br />';
echo $xNIF.'<br />';
echo $xCP.'<br />';
echo $xDIRE.'<br />';
echo $xPOBLA.'<br />';
echo $xPROV.'<br />';
echo $xEntidad.'<br />';
echo $xSucursal.'<br />';
echo $xDC.'<br />';
echo $xNCuenta.'<br />';
	   echo "Error";
}

?>
