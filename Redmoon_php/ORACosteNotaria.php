<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

if(isset($_POST["xIDExpe"]))
{ 


$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'BEGIN AddCosteNotaria(:xIDExpe,:xCostePrevisto,:xNProtocolo,:xNEscrituras,:xfechaprevista); END;';


    $stmt = oci_parse($conn, $sql);
    
    $xIDExpe= (int)$_POST["xIDExpe"];
    $xCostePrevisto=$_POST["coste"];
    $xNProtocolo=$_POST["protocol"];
    $xNEscrituras=$_POST["n_escrituras"];
    $xfechaprevista=$_POST["fecha"];
    
    
    oci_bind_by_name($stmt, ':xIDExpe', $xIDExpe, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':xCostePrevisto', $xCostePrevisto, 14, SQLT_CHR);
    oci_bind_by_name($stmt, ':xNProtocolo', $xNProtocolo, 20, SQLT_CHR);
    oci_bind_by_name($stmt, ':xNEscrituras', $xNEscrituras, 2, SQLT_CHR);
    oci_bind_by_name($stmt, ':xfechaprevista', $xfechaprevista, 8, SQLT_CHR);
    
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
