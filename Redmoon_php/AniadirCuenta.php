<<<<<<< .mine
<?php require('controlSesiones.inc.php');  ?>
<?php 
=======
<?php 

require('controlSesiones.inc.php');
>>>>>>> .r60

require('pebi_cn.inc.php');
require('pebi_db.inc.php');


$xNumCompleto=$_POST['xNumCompleto'];
$xEntidad=substr($xNumCompleto,0,4);
$xOficina=substr($xNumCompleto,4,4);
$xNumCuenta=substr($xNumCompleto,10,10);
$xDG=substr($xNumCompleto,8,2);
$xUser=$_SESSION["usuario"];

$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'begin AddCuentaProvision(:xEntidad,:xOficina,:xDG,:xNumCuenta,:xNumCompleto,:xUser); end;';

    $stmt = oci_parse($conn, $sql);
    
    oci_bind_by_name($stmt, ':xNumCompleto', $xNumCompleto, 20,SQLT_CHR);
    oci_bind_by_name($stmt, ':xEntidad', $xEntidad, 4,SQLT_CHR);
    oci_bind_by_name($stmt, ':xOficina', $xOficina, 4,SQLT_CHR);
    oci_bind_by_name($stmt, ':xNumCuenta', $xNumCuenta, 10,SQLT_CHR);
    oci_bind_by_name($stmt, ':xDG', $xDG, 2,SQLT_CHR);
    oci_bind_by_name($stmt, ':xUser', $xUser, 30, SQLT_CHR);
    
    	if(oci_execute($stmt))
		{
			echo "ok";
	     	//header("Location:PagosAColaboradores.php");
		}
		else
	   		echo "Error";
?>
