<?php   

//
// Añadir una anotación informativa
//

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');


if(isset($_POST["xIDExpe"]))
{ 


$conn = db_connect();

// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'BEGIN pkAddSegui.AddComentSegui(:xIDExpe, :xComenta); END;';


    $stmt = oci_parse($conn, $sql);
    
    $xIDExpe = (int)$_POST["xIDExpe"];
    $xComent = $_POST["xComent"]; 
    
    oci_bind_by_name($stmt, ':xIDExpe', $xIDExpe, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':xComenta', $xComent, 50, SQLT_CHR);
    
	if(oci_execute($stmt))
	{
	     echo "Ok";
	}
	else
	   echo "Error AddComentSegui: ".$xIDExpe.' comentario: '.$xComent;
}
else
	echo "No";	
?>