<<<<<<< .mine
<?php require('controlSesiones.inc.php');  ?>
<?php
session_start();
require('pebi_cn.inc');
require('pebi_db.inc');
=======
<?php 

require('controlSesiones.inc.php');
>>>>>>> .r60

require('pebi_cn.inc.php');
require('pebi_db.inc.php');

// Create a database connection

$conn = db_connect();



	//include ("conectaMySQL.php");
	$host="lldd382.servidoresdns.net";
	$usuario="qee820";
	$password="Redmoon2010";
	$conectar=mysql_connect($host,$usuario,$password);
	


	$enlace=mysql_select_db("qee820",$conectar);
	//insert
	//
	$consulta="update lgs_notas_simples set marca=1 where marca=0";
   
	// devuelve true o false
	$stmt=mysql_query($consulta,$conectar);
        
	if (!$stmt) {
    $message  = 'Consulta invalidad: ' . mysql_error() . "\n";
   
    die($message);
}
	$consulta2="select * from lgs_notas_simples where marca=1";
   
	// devuelve true o false
	$stmt2=mysql_query($consulta2,$conectar);
        
	if (!$stmt2) {
    $message  = 'Consulta invalidad: ' . mysql_error() . "\n";
   
    die($message);
}

	while ($row = mysql_fetch_assoc($stmt2)) {
		
	
		
		$sqlORACLE="INSERT INTO lgs_notas_simples (ID_QEE820,NIF,APENOMBRE, DOMICILIO, MAIL, TLF, MVL, ENTIDAD, OFICINA, DC, CUENTA, RFC, FUP, Escalera, NOMBRE_T, REGISTRO, ID_FINCA,FECHAHORA) 
		VALUES (:xID,:xNIF, :xAPENOMBRE,:xDOMICILIO,:xMAIL,:xTLF,:xMVL,:xENTIDAD, :xOFICINA, :xDC, :xCUENTA,:xRCF,:xFUP,:xEscalera,:xNOMBRE_T,:xREGISTRO,:xN_REG,to_date(:xFechaHora))";
		
		
		$stmtORACLE = oci_parse($conn, $sqlORACLE);
	$xID=$row['ID'];
	$xFechaHora=$row['FECHAHORA'];
	$xNIF=$row["NIF"]; 
	$xAPENOMBRE=$row["APENOMBRE"]; 
	$xDOMICILIO= $row["DOMICILIO"];
	$xMAIL= $row["MAIL"];
	$xTLF= $row["TLF"];
	$xMVL= $row["MVL"];
	$xENTIDAD= $row["ENTIDAD"];
	$xOFICINA= $row["OFICINA"];
	$xDC= $row["DC"];
	$xCUENTA= $row["CUENTA"];
	
	$xRCF=$row["RCF"];
	$xFUP=$row["FUP"];
	$xEscalera=$row["Escalera"];
	$xNOMBRE_T=$row["NOMBRE_T"]; 
	$xREGISTRO= $row["REGISTRO"];
	$xN_REG= $row["ID_FINCA"];
	
	
		//el campo FECHAHORA  hay que repasarlo
		
		oci_bind_by_name($stmtORACLE, ':xID', $xID, 38, SQLT_INT);
		oci_bind_by_name($stmtORACLE, ':xFechaHora', $xFechaHora,24,SQL_CHAR);
		oci_bind_by_name($stmtORACLE, ':xNIF', $xNIF,14, SQLT_CHR);
		oci_bind_by_name($stmtORACLE, ':xAPENOMBRE', $xAPENOMBRE,100, SQLT_CHR);
		oci_bind_by_name($stmtORACLE, ':xDOMICILIO', $xDOMICILIO,100, SQLT_CHR);
		oci_bind_by_name($stmtORACLE, ':xMAIL', $xMAIL,40, SQLT_CHR);
		oci_bind_by_name($stmtORACLE, ':xTLF', $xTLF,15, SQLT_CHR);
		oci_bind_by_name($stmtORACLE, ':xMVL', $xMVL,15, SQLT_CHR);
		oci_bind_by_name($stmtORACLE, ':xENTIDAD', $xENTIDAD,4, SQLT_CHR);
		oci_bind_by_name($stmtORACLE, ':xOFICINA', $xOFICINA,4, SQLT_CHR);
		oci_bind_by_name($stmtORACLE, ':xDC', $xDC,2, SQLT_CHR);
		oci_bind_by_name($stmtORACLE, ':xCUENTA', $xCUENTA,10, SQLT_CHR);
		oci_bind_by_name($stmtORACLE, ':xRCF', $xRCF,20, SQLT_CHR);
		oci_bind_by_name($stmtORACLE, ':xFUP', $xFUP,90, SQLT_CHR);
		oci_bind_by_name($stmtORACLE, ':xEscalera', $xEscalera,40, SQLT_CHR);
		oci_bind_by_name($stmtORACLE, ':xNOMBRE_T', $xNOMBRE_T,40, SQLT_CHR);
		oci_bind_by_name($stmtORACLE, ':xREGISTRO', $xREGISTRO,40, SQLT_CHR);
		oci_bind_by_name($stmtORACLE, ':xN_REG', $xN_REG,40, SQLT_CHR); 
		
	
		
		if(!oci_execute($stmtORACLE))
	   		echo "Error ORACLE";
	   	else echo "ok";
		
		
		
	}
	
	
		$consulta3="delete from lgs_notas_simples where marca=1";
   
	// devuelve true o false
	$stmt3=mysql_query($consulta3,$conectar);
        
	if (!$stmt3) {
    $message  = 'Consulta invalidad: ' . mysql_error() . "\n";
   
    die($message);
}
	
	oci_close($conn);
?>
