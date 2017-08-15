<?php 

require('controlSesiones.inc.php');  

//
// Marial del Mar Pérez Fajardo
// Agosto 2009
//
require('pebi_cn.inc.php');
require('pebi_db.inc.php');  




$xNombre=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inNombre"]);
$xNif=$_POST["inNIF"];
$xCP=$_POST["inCP"];
$xDire=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inDireccion"]);
$xPobla=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inPoblacion"]);
$xProvincia=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inProvincia"]);
$xFechAlta=$_POST["infechAlta"];
$xMail=$_POST["ineMail"];
$xAseguradora=iconv('UTF-8','Windows-1252//TRANSLIT',$_POST["inAseguradora"]);
$xNpoliza=$_POST["inPoliza"];
$xFechSeguro=$_POST["infechSeg"];
$xTipo=$_POST['tipo'];
$xInterno=$_POST['inInterno'];
$xIDColabora='';

//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros

/*
xNif in varchar2,
xAseguradora in varchar2,
xCP in varchar2,
xDire in varchar2,
xMail in varchar2,
xFechAlta in varchar2,
xNombre in varchar2,
xProvincia in varchar2,
xPobla in varchar2, 
xTipo in varchar2,
xFechSeguro in varchar2,
xNPoliza in varchar2,
xInterno in varchar2,
xIDColabora out integer )
*/
$sql = "begin AddColabora(
:xNif,
:xAseguradora,
:xCP,
:xDire,
:xMail,
:xFechAlta,
:xNombre,
:xProvincia,
:xPobla, 
:xTipo,
:xFechSeguro,
:xNPoliza,
:xInterno,
:xIDColabora); end; ";


    $stmt = oci_parse($conn, $sql);
    
    
    if(!oci_bind_by_name($stmt, ':xIDColabora', $xIDColabora, 38, SQLT_INT))
    	echo 'Error bind xIDColabora';
    if(!oci_bind_by_name($stmt, ':xNif', $xNif, 12, SQLT_CHR))
    	echo 'Error bind xNif';
    if(!oci_bind_by_name($stmt, ':xInterno', $xInterno, 2, SQLT_CHR))
    	echo 'Error bind xInterno';
    if(!oci_bind_by_name($stmt, ':xNombre', $xNombre, 50, SQLT_CHR))
    	echo 'Error bind xNombre';
    if(!oci_bind_by_name($stmt, ':xCP', $xCP,5, SQLT_CHR))
    	echo 'Error bind xCP';
    if(!oci_bind_by_name($stmt, ':xDire', $xDire,50, SQLT_CHR))
    	echo 'Error bind xDire';
    if(!oci_bind_by_name($stmt, ':xPobla', $xPobla, 25, SQLT_CHR))
    	echo 'Error bind xPobla';
    if(!oci_bind_by_name($stmt, ':xProvincia', $xProvincia,25, SQLT_CHR))
    	echo 'Error bind xProvincia';
    if(!oci_bind_by_name($stmt, ':xFechAlta', $xFechAlta,10, SQLT_CHR))
    	echo 'Error bind xFechAlta';
    if(!oci_bind_by_name($stmt, ':xMail', $xMail,30, SQLT_CHR))
    	echo 'Error bind xMail';
    if(!oci_bind_by_name($stmt, ':xAseguradora', $xAseguradora,50, SQLT_CHR))
    	echo 'Error bind xAseguradora';
    if(!oci_bind_by_name($stmt, ':xNpoliza', $xNpoliza,20, SQLT_CHR))
    	echo 'Error bind xNpoliza';
    if(!oci_bind_by_name($stmt, ':xFechSeguro', $xFechSeguro,10, SQLT_CHR))
    	echo 'Error bind xNpoliza';
    if(!oci_bind_by_name($stmt, ':xTipo', $xTipo,15, SQLT_CHR))
    	echo 'Error bind xTipo';
    
    $url='Location: ../Colaboradores.php?xIDColaborador=';
    
	if(oci_execute($stmt))
	{
	     header($url.$xIDColabora);
	 /*    echo 'cola:'.$xIDColabora.'<br />';
	    echo 'cp:'.$xCP.'<br />';
echo $xDIRE.'<br />';
echo $xPOBLA.'<br />';
echo $xPROV.'<br />';

echo $xMail.'<br />';*/
		
	}
	else{
	  
echo 'cola:'.$xIDColabora.'<br />';	   
echo $xNombre.'<br />';
echo $xCP.'<br />';
echo $xPobla.'<br />';
echo $xDire.'<br />';
echo $xProvincia.'<br />';
echo $xMail.'<br />';
	db_error($stmt, __FILE__, __LINE__);
	   echo "Error";
	}
	
?>
