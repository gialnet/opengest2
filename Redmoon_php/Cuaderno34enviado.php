<<<<<<< .mine
<?php require('controlSesiones.inc.php');  ?>
=======
<?php 

require('controlSesiones.inc.php');
>>>>>>> .r60

require('pebi_cn.inc.php');
require('pebi_db.inc.php');  


//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();

// Nombre de procedimiento a ejecutar y sus parametros


$sql='begin ConfirmCdoPagoColabora(:xIdCuaderno); end;';

    $stmt = oci_parse($conn, $sql);
   
   
$xIdCuaderno=(int)$_POST['xIDCuaderno'];
    
    oci_bind_by_name($stmt, ':xIdCuaderno', $xIdCuaderno, 38, SQLT_INT);
    
    
	if(oci_execute($stmt)){
	    echo "ok";
	}
	else{
	   echo "Error";
	}

?>
