<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

if(isset($_POST["xIDExpe"]))
{ 


$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'BEGIN AddCosteImpuestos(:xIDExpe,:xImporte); END;';


    $stmt = oci_parse($conn, $sql);
    
    $xIDExpe= (int)$_POST["xIDExpe"];
    $xImporte=$_POST["importe"];
    
   
   // echo $xIDExpe.'<BR />';
    //echo $xImporteHipo.'<BR />';
    //echo $xImporteSubro.'<BR />';
    
    oci_bind_by_name($stmt, ':xIDExpe', $xIDExpe, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':xImporte', $xImporte, 14, SQLT_CHR);
    

	if(oci_execute($stmt))
	{
	     header("Location: ../TareasColaboradores.php");
	}
	else
	   echo "Error";
}
else
	echo "No";	
?>
