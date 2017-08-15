<?php 

//
// Marial del Mar Pérez Fajardo
// Agosto 2009
//

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');
 
if(isset($_POST["xIDExpe"]))
{ 


$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'BEGIN pkAddSegui.AddDH(:xIDExpe, :xComenta, :xImporte, :xModo); END;';


    $stmt = oci_parse($conn, $sql);
    
    $xIDExpe = (int)$_POST["xIDExpe"];
    $xComent = $_POST["xComent"];
    $xImporte =$_POST["xImporte"];
    
    // apunte al debe del cliente, un gasto adicional no presupuestado
    // realiza el pago el colaborador de su caja personal
    // pagos realizados fuera del circuito 
    $xModo ='D';
    
    oci_bind_by_name($stmt, ':xIDExpe', $xIDExpe, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':xComenta', $xComent, 50, SQLT_CHR);
    
    oci_bind_by_name($stmt, ':xImporte', $xImporte, 14, SQLT_CHR);
    oci_bind_by_name($stmt, ':xModo', $xModo, 1, SQLT_CHR);
    
	if(oci_execute($stmt))
	{
	     echo "Ok";
	}
	else
	   echo "Error AddDH: ".$xIDExpe.' comentario: '.$xComent;
}
else
	echo "No";
	
oci_close($conn);
?>
