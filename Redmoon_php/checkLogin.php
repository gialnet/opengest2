<?php

require_once('controlSesiones.inc.php');
require_once('pebi_cn.inc.php');
require_once('pebi_db.inc.php');

$conn = db_connect();

if(isset($_POST["posDi1"]))
{ 


// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'BEGIN CheckUSER(:xPOSD1,:xPOSD2,:xDIGIT1,:xDIGIT2,:xUSUARIO,:xPASSWD,:xPERFIL,:xIDRol,:xRol,:xMayorCuantia,:xGApiKey,:xOficina); END;';
    
    $stmt = oci_parse($conn, $sql);
    
    $xPOSD1= (int)$_POST["posDi1"];
    $xPOSD2= (int)$_POST["posDi2"];
    $xDIGIT1= $_POST["Digit1"];
    $xDIGIT2= $_POST["Digit2"];
    $xUSUARIO= $_POST["usuario"];
    $xPASSWD= $_POST["passwd"];
    
   
    oci_bind_by_name($stmt, ':xPOSD1', $xPOSD1, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':xPOSD2', $xPOSD2, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':xDIGIT1', $xDIGIT1, 2, SQLT_CHR);
    oci_bind_by_name($stmt, ':xDIGIT2', $xDIGIT2, 2, SQLT_CHR);
    oci_bind_by_name($stmt, ':xUSUARIO', $xUSUARIO, 30, SQLT_CHR);
    oci_bind_by_name($stmt, ':xPASSWD', $xPASSWD, 20, SQLT_CHR);
    oci_bind_by_name($stmt, ':xPERFIL', $xPERFIL, 50, SQLT_CHR);
    oci_bind_by_name($stmt, ':xIDRol', $xIDRol, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':xRol', $xRol, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':xMayorCuantia', $xMayorCuantia, 50, SQLT_CHR);
    oci_bind_by_name($stmt, ':xGApiKey', $xGApiKey, 100, SQLT_CHR);
    oci_bind_by_name($stmt, ':xOficina', $xOficina, 4, SQLT_CHR);
    
	if(oci_execute($stmt))
	{
	    // echo $xPERFIL;
	    // header("Location: ../".$xPERFIL);
	    if (substr($xPERFIL,0,2)=='NO')
	       header("Location: ../login/login.php");
	    else 
	       $auth=TRUE;
	       
		if ($auth) 
		{
		$_SESSION["usuario"]=$xUSUARIO;
		$_SESSION["oficina"]=$xOficina;
		$_SESSION["perfil"]=$xPERFIL;
		$_SESSION["rol"]=$xRol;
		$_SESSION["idRol"]=$xIDRol;
		$_SESSION["acceso"]=$auth;
		$_SESSION["MayorCuantia"]=$xMayorCuantia;
		$_SESSION["xGApiKey"]=$xGApiKey;

    	if (isset($_GET["url"])) 
			{
      		$url = $_GET["url"];
    		} 
		else 
			{
      		$url = "../".$xPERFIL;
    		}

    	if (!isset($_COOKIE[session_name()])) 
			{
      		if (strstr($url, "?")) 
	  			{
        		header("Location: " . $url . "&" . session_name() . "=" . session_id());
      			} 
	  		else 
	  			{
        		header("Location: " . $url . "?" . session_name() . "=" . session_id());
      			}
    		} 
		else 
			{
      		header("Location: " . $url);
    		}
		} 
	}
	else
	   echo "Error";
}
else
	echo "No";
	
oci_close($conn);	
?>
