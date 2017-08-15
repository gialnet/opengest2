<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

if(isset($_POST["xIDExpe"]))
{ 


$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'BEGIN AddCosteRegistro(:xIDExpe,:xImporte,:xFecha); END;';


    $stmt = oci_parse($conn, $sql);
    
    $xIDExpe= (int)$_POST["xIDExpe"];
    $xImporte=$_POST["importe"];
    $xFecha=$_POST["fecha_reco_escritura"];
        
	echo  $xIDExpe.'<BR />';
	echo  $xImpHipo.'<BR />';
	echo  $xImpCance.'<BR />';
	echo  $xFecha.'<BR />';
    
    oci_bind_by_name($stmt, ':xIDExpe', $xIDExpe, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':xImporte', $xImporte, 14, SQLT_CHR);
    oci_bind_by_name($stmt, ':xFecha', $xFecha, 8, SQLT_CHR);
    
    
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
