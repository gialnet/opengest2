<?php 

require('controlSesiones.inc.php');  
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

$conn = db_connect();


    $xNIF = $_POST["inNif"];    			
    $xNombre= $_POST["inNombre"];
    $xNacionalidad= $_POST["inNacionalidad"];
    $xPaisOrigen= $_POST["inPaisOrigen"];
    $xFecha= $_POST["inFecha"];
    $xPaisDomicilio= $_POST["inPaisDomicilio"];
    $xPoblacion= $_POST["inPoblacion"];
    $xDIRECCION= $_POST["inDireccion"];
    $xPortal= $_POST["inPortal"];
    $xemail= $_POST["inEmail"];
    $xTelefono= $_POST["inTelefono"];
    $xmovil= $_POST["inMovil"];
    $xEstadoCivil= $_POST["inEstadoCivil"];
    $xRegimenEconomico= $_POST["inRegimenEconomico"];
    $xProfesion= $_POST["inProfesion"];
    $xCodigoCliente= $_POST["inCodigoCliente"];

    $xCuenta= $_POST["incuenta"];
    
    
// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'INSERT INTO clientes_preferentes (APENOMBRE,NIF,MOVIL,EMAIL,
TELEFONO,NACIONALIDAD,PAISORIGEN,PAISDOMICILIO,FNACIMIENTO,POBLACION,DOMICILIO,PORTAL,
ESTADOCIVIL,REGIMENECONOMICO,PROFESION,CODIGOCLIENTE,NUMEROCUENTA) 
VALUES (:xNombre,:xNIF, :xmovil,:xemail,:xTelefono,:xNacionalidad,:xPaisOrigen,
:xPaisDomicilio,:xFecha,:xPoblacion,:xDIRECCION,:xPortal,:xEstadoCivil,:xRegimenEconomico,
:xProfesion,:xCodigoCliente,:xCuenta)';
    
    $stmt = oci_parse($conn, $sql);
    

   
 
    
    oci_bind_by_name($stmt, ':xNombre', $xNombre,40, SQLT_CHR);
    oci_bind_by_name($stmt, ':xNIF', $xNIF,12, SQLT_CHR);
    oci_bind_by_name($stmt, ':xmovil', $xmovil,10, SQLT_CHR);
    oci_bind_by_name($stmt, ':xemail', $xemail,40, SQLT_CHR);
    oci_bind_by_name($stmt, ':xTelefono', $xTelefono,10, SQLT_CHR);
    oci_bind_by_name($stmt, ':xNacionalidad', $xNacionalidad,25, SQLT_CHR);
    oci_bind_by_name($stmt, ':xPaisOrigen', $xPaisOrigen,25, SQLT_CHR);
    oci_bind_by_name($stmt, ':xPaisDomicilio', $xPaisDomicilio,25, SQLT_CHR);
    oci_bind_by_name($stmt, ':xFecha', $xFecha,10, SQLT_CHR);
    oci_bind_by_name($stmt, ':xPoblacion', $xPoblacion,25, SQLT_CHR);
    oci_bind_by_name($stmt, ':xDIRECCION', $xDIRECCION,40, SQLT_CHR);
    oci_bind_by_name($stmt, ':xPortal', $xPortal,25, SQLT_CHR);
    oci_bind_by_name($stmt, ':xEstadoCivil', $xEstadoCivil,25, SQLT_CHR);
    oci_bind_by_name($stmt, ':xRegimenEconomico', $xRegimenEconomico,25, SQLT_CHR);
    oci_bind_by_name($stmt, ':xProfesion', $xProfesion,25, SQLT_CHR);
    oci_bind_by_name($stmt, ':xCodigoCliente', $xCodigoCliente,25, SQLT_CHR);
    oci_bind_by_name($stmt, ':xCuenta', $xCuenta,20, SQLT_CHR);

   

	if(oci_execute($stmt))
	{
	   //echo "Ok"; 
	   header("Location: ../TablaClientesPreferentes.php");
	}
	else
	   echo "Error";


oci_close($conn);
?>
