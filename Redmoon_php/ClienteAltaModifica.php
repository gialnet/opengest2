<<<<<<< .mine
<?php require('controlSesiones.inc.php');  ?>
=======
﻿<?php 

require('controlSesiones.inc.php');
>>>>>>> .r60

require('pebi_cn.inc.php');
require('pebi_db.inc.php');

if(isset($_POST["xNIF"]))
{ 


$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'BEGIN pkClientes.HTMLModCliente(:xNIF,:xNombre,:xNacionalidad,:xPaisOrigen,:xFecha,:xPaisDomicilio,:xPoblacion,:xDIRECCION,:xPortal,:xemail,:xTelefono,:xmovil,:xEstadoCivil,:xRegimenEconomico,:xProfesion,:xCodigoCliente,:xEmpleado,:xEntidad,:xOficina,:xDC,:xCuenta,:xLatitud,:xLongitud); END;';

    
    
    $stmt = oci_parse($conn, $sql);
    
    $xNIF = $_POST["xNIF"];    			
    $xNombre= $_POST["xNombre"];
    $xNacionalidad= $_POST["xNacionalidad"];
    $xPaisOrigen= $_POST["xPaisOrigen"];
    $xFecha= $_POST["xFecha"];
    $xPaisDomicilio= $_POST["xPaisDomicilio"];
    $xPoblacion= $_POST["xPoblacion"];
    $xDIRECCION= $_POST["xDIRECCION"];
    $xPortal= $_POST["xPortal"];
    $xemail= $_POST["xemail"];
    $xTelefono= $_POST["xTelefono"];
    $xmovil= $_POST["xmovil"];
    $xEstadoCivil= $_POST["xEstadoCivil"];
    $xRegimenEconomico= $_POST["xRegimenEconomico"];
    $xProfesion= $_POST["xProfesion"];
    $xCodigoCliente= $_POST["xCodigoCliente"];
    $xEmpleado= $_POST["xEmpleado"];
    $xEntidad= $_POST["xEntidad"];
    $xOficina= $_POST["xOficina"];
    $xDC= $_POST["xDC"];
    $xCuenta= $_POST["xCuenta"];
    $xLatitud= $_POST["xLatitud"];
    $xLongitud= $_POST["xLongitud"];
    
    
    oci_bind_by_name($stmt, ':xNIF', $xNIF, 12, SQLT_CHR);
    
    oci_bind_by_name($stmt, ':xNombre', $xNombre, 40, SQLT_CHR);
    oci_bind_by_name($stmt, ':xNacionalidad', $xNacionalidad, 25, SQLT_CHR);
    oci_bind_by_name($stmt, ':xPaisOrigen', $xPaisOrigen, 25, SQLT_CHR);
    oci_bind_by_name($stmt, ':xFecha', $xFecha, 10, SQLT_CHR);
    oci_bind_by_name($stmt, ':xPaisDomicilio', $xPaisDomicilio, 25, SQLT_CHR);
    oci_bind_by_name($stmt, ':xPoblacion', $xPoblacion, 25, SQLT_CHR);
    
    oci_bind_by_name($stmt, ':xDIRECCION', $xDIRECCION, 40, SQLT_CHR);
    oci_bind_by_name($stmt, ':xPortal', $xPortal, 25, SQLT_CHR);
    oci_bind_by_name($stmt, ':xemail', $xemail, 40, SQLT_CHR);
    oci_bind_by_name($stmt, ':xTelefono', $xTelefono, 10, SQLT_CHR);
    oci_bind_by_name($stmt, ':xmovil', $xmovil, 10, SQLT_CHR);
    oci_bind_by_name($stmt, ':xEstadoCivil', $xEstadoCivil, 25, SQLT_CHR);
    oci_bind_by_name($stmt, ':xRegimenEconomico', $xRegimenEconomico, 25, SQLT_CHR);
    oci_bind_by_name($stmt, ':xProfesion', $xProfesion, 25, SQLT_CHR);
    
    oci_bind_by_name($stmt, ':xCodigoCliente', $xCodigoCliente, 25, SQLT_CHR);
    oci_bind_by_name($stmt, ':xEmpleado', $xEmpleado, 1, SQLT_CHR);
    oci_bind_by_name($stmt, ':xEntidad', $xEntidad, 4, SQLT_CHR);
    oci_bind_by_name($stmt, ':xOficina', $xOficina, 4, SQLT_CHR);
    oci_bind_by_name($stmt, ':xDC', $xDC, 2, SQLT_CHR);
    oci_bind_by_name($stmt, ':xCuenta', $xCuenta, 10, SQLT_CHR);
    oci_bind_by_name($stmt, ':xLatitud', $xLatitud, 10, SQLT_CHR);
    oci_bind_by_name($stmt, ':xLongitud', $xLongitud, 10, SQLT_CHR);
    
    
    
	oci_execute($stmt);
	echo "Ok";
}
else
	echo "No";
	
oci_close($conn);
?>
