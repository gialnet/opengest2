<<<<<<< .mine
<?php require('controlSesiones.inc.php');  ?>
<?php 
=======
<?php 

require('controlSesiones.inc.php');
>>>>>>> .r60

require('pebi_cn.inc.php');
require('pebi_db.inc.php');


$xNumCompleto=$_POST['xCuenta'];


$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'delete from cuentas where NCUENTACOMPLETO=:xNumCompleto';

    $stmt = oci_parse($conn, $sql);

        

    
    oci_bind_by_name($stmt, ':xNumCompleto', $xNumCompleto, 20,SQLT_CHR);


    
    	if(oci_execute($stmt))
	 {
		echo "ok";
	    	//header("Location:PagosAColaboradores.php");
	 }
	else
	   echo "Error";
?>
