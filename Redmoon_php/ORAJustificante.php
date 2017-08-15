<?php 

//
// Marial del Mar Pérez Fajardo
// Agosto 2009
//

require('controlSesiones.inc.php');
require('pebi_cn.inc.php');
require('pebi_db.inc.php');

$conn = db_connect();
// probar file
$sql='select RUTA_TEMPORAL from datosper where id = (select iddatosper from usuarios where usuario=user)';

	$stid2 = oci_parse($conn, $sql);
	$r = oci_execute($stid2, OCI_DEFAULT);
	$row= oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS);
	
	$rutaTemp=$row['RUTA_TEMPORAL'];
	
echo $_FILES['DocAdjunto']['name'].'<BR />';
echo $_FILES['DocAdjunto']['tmp_name'].'<BR />';
echo $_FILES['DocAdjunto']['size'].'<BR />';

list($nombre_file, $extension_file) = split('[.]', $_FILES['DocAdjunto']['name']);

echo $extension_file.'<BR />';

// Ruta y nombre de donde se encuentra el fichero tras subirlo a nuestra Web
$xRutaFile = $_FILES['DocAdjunto']['tmp_name'];
move_uploaded_file($xRutaFile,'temp_file/'.$_FILES['DocAdjunto']['name']);
$xRutaFile=$rutaTemp.$_FILES['DocAdjunto']['name'];

// nombre que va a tener el fichero en la nube
$xFileName = '';

// http://cg-servicios.s3.amazonaws.com/edificioColon.jpg

// variable para el proyecto LGS, en cada cliente tendrá su valor
$xCuboName = 'cg-servicios';

// si quien envia la llamada es Justificante de la notaria
if ($_POST["action"] == "notaria") {

	$xFileName ='notaria-ne-'.$_POST["xIDExpe"].'.'.$extension_file;
	$url_oracle = 'http://cg-servicios.s3.amazonaws.com/'.$xFileName;
	$xFase='50';
	header("Location: ../tarzan/subir_file.php?xRutaFile=".$xRutaFile."&xFileName=".$xFileName."&xCuboName=".$xCuboName);
	
	do_save_oracle($url_oracle,$xFase,4);
	
}

// si quien envia la llamada es Justificante impuesto
if ($_POST["action"] == "impuesto") {
	$xFileName ='impuesto-ne-'.$_POST["xIDExpe"].'.'.$extension_file;
	$url_oracle = 'http://cg-servicios.s3.amazonaws.com/'.$xFileName;
	$xFase='60';
	header("Location: ../tarzan/subir_file.php?xRutaFile=".$xRutaFile."&xFileName=".$xFileName."&xCuboName=".$xCuboName);
	
	do_save_oracle($url_oracle,$xFase,5);
	
}

if ($_POST["action"] == "registro") {
	$xFileName ='registro-ne-'.$_POST["xIDExpe"].'.'.$extension_file;
	$url_oracle = 'http://cg-servicios.s3.amazonaws.com/'.$xFileName;
	$xFase='65';
	header("Location: ../tarzan/subir_file.php?xRutaFile=".$xRutaFile."&xFileName=".$xFileName."&xCuboName=".$xCuboName);
	
	do_save_oracle($url_oracle,$xFase,6);
	
}

//
//
//
function do_save_oracle($url_oracle,$xFase,$xTipoRegla)
{

	
	if(isset($_POST["xIDExpe"]))
	{
		$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'BEGIN AddJustificante(:xIDExpe,:xFechaRecogida,:url_oracle,:xFase,:xTipoRegla); END;';

    $stmt = oci_parse($conn, $sql);
    
    $xIDExpe= (int)$_POST["xIDExpe"];
    $xTipoRegla= (int)$xTipoRegla;
    if($_POST["action"] == "notaria"){
    	$xFechaRecogida=$_POST["fecha_recogida"];
    }
    else 
    	$xFechaRecogida=NULL;

    echo $xIDExpe.'<BR />';
    echo $url_oracle.'<BR />';
    echo $xFechaRecogida.'<BR />';
    echo $xFase.'<BR />';
    echo $xTipoRegla.'<BR />';
   
    
    oci_bind_by_name($stmt, ':xIDExpe', $xIDExpe, 38, SQLT_INT);
    oci_bind_by_name($stmt, ':xFechaRecogida', $xFechaRecogida, 8, SQLT_CHR);
    oci_bind_by_name($stmt, ':url_oracle', $url_oracle, 90, SQLT_CHR);
	oci_bind_by_name($stmt, ':xFase', $xFase,2, SQLT_CHR);
	oci_bind_by_name($stmt, ':xTipoRegla', $xTipoRegla, 38, SQLT_INT);
    
    
    	if(oci_execute($stmt))
		{
	     	//header("Location: ../TareasColaboradores.php");
	     	echo "Ok";
		}
		else
	   	echo "Error";
	}
	else
		echo "No";
}

echo $_POST["action"];
?>
