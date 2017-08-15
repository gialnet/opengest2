<?php 

require('controlSesiones.inc.php');  
//
// Marial del Mar Pérez Fajardo
// Agosto 2009
//
require('pebi_cn.inc.php');
require('pebi_db.inc.php');  




$xDes=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["indes"]);
$xTar=$_POST["intar"];
$xTipo=$_POST["tipo"];
$xIDActo='';

//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = "begin AddActo(
:xDes,
:xTipo,
:xTar,
:xIDActo); end; ";


    $stmt = oci_parse($conn, $sql);
    
    
    oci_bind_by_name($stmt, ':xIDActo', $xIDActo, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':xDes', $xDes, 40, SQLT_CHR);
    oci_bind_by_name($stmt, ':xTipo', $xTipo, 40, SQLT_CHR);
    oci_bind_by_name($stmt, ':xTar', $xTar,1, SQLT_CHR);
    
    
  
    $url='Location: ../Actuacion.php?xIDActo='.$xIDActo;
    
	if(oci_execute($stmt))
	{
	     header($url);
	     echo 'cola:'.$xIDActo.'<br />';
	    echo 'DES:'.$xDes.'<br />';
echo 'TIPO CRED O EJECUCION:'.$xTipo.'<br />';
echo 'TARIFA:'.$xTar.'<br />';

	}
	else{
	  
  echo 'ID:'.$xIDActo.'<br />';	   
   echo 'DESCRP:'.$xDes.'<br />';
    echo 'TARIFA:'.$xTar.'<br />';
     echo 'TIPO:'.$xTipo.'<br />';	  



	   echo "Error";
	}
	
?>
