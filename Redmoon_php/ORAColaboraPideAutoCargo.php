<?php 

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');
 
if(isset($_POST["xIDExpe"]))
{ 


$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'BEGIN pkAddSegui.AddAutorizaGasto(:xIDExpe, :xComenta, :xImporte, :xColabora, :xModo); END;';


    $stmt = oci_parse($conn, $sql);
    
    $xIDExpe = (int)$_POST["xIDExpe"];
    $xComent = $_POST["xComent"];
    $xImporte =$_POST["xImporte"];
    $xColabora= (int)$_POST["xColabora"];
    
    // apunte al debe del cliente, un gasto adicional no presupuestado
    $xModo ='P';
    
    oci_bind_by_name($stmt, ':xIDExpe', $xIDExpe, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':xComenta', $xComent, 50, SQLT_CHR);
    
    oci_bind_by_name($stmt, ':xImporte', $xImporte, 14, SQLT_CHR);
    oci_bind_by_name($stmt, ':xModo', $xModo, 1, SQLT_CHR);
    oci_bind_by_name($stmt, ':xColabora', $xColabora, 38, SQLT_INT);
    
	if(oci_execute($stmt))
	{
	     echo "Ok";
	}
	else
	   echo "Error AddAutorizaGasto: ".$xIDExpe.' comentario: '.$xComent;
}
else
	echo "No";
	
oci_close($conn);
?>
