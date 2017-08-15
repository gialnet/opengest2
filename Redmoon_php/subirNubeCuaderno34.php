<?php 

require('controlSesiones.inc.php');

//
// Subir un fichero a la nube para su almacenamiento en Amazon Web Services Simple Storage S3
// Antonio Pérez Caballero sábado 11 de julio 2009
//

// cargar las clases de tarzan
require_once '../tarzan_2.0.3/tarzan.class.php';
error_reporting(E_ALL);
header('Content-type: text/html; charset=UTF-8');


function SubirFicheroNube($strRutaFile,$strFileName){
	//
	// Subir un fichero
	//
		
		$bucket='cg-servicios';

		//$logFile='log_s3.txt';

		// Upload to AWS
		$s3 = new AmazonS3();
		$fileIn = file_get_contents($strRutaFile);


		$file = $s3->create_object($bucket, array(
        'filename' => $strFileName,
       'body' => $fileIn,
       'contentType' => 'text/plain',
        'acl' => S3_ACL_AUTH_READ
		));

		
			$strFileName ='http://cg-servicios.s3.amazonaws.com/'.$strFileName;
		// Make sure the request was successful.
		if ($file->isOK()){
			if (isset($_GET['xTipo']))
        		header("Location:../RutaFicheroPago.php?xRutaLocal=".$strRutaFile."&xRutaNube=".$strFileName.'&xTipo=clientes');
        	else 
        		header("Location:../RutaFicheroPago.php?xRutaLocal=".$strRutaFile."&xRutaNube=".$strFileName);
        //$logFile->write("************* Uploaded to AWS S3 OK" . PHP_EOL);
		} 
		else {

        		echo '<p>Uploaded to AWS S3 FAILED</p>';
        		//$logFile->write("************* Upload to AWS FAILED" . PHP_EOL);
		}

}




//funcion para guardar el fichero en la nube
function SubirNube(){
	
	// Ruta y nombre de donde se encuentra el fichero tras subirlo a nuestra Web
	$xRutaFile =$_SESSION["nomfi"];
	$xNombreComun=substr($xRutaFile,-16,17);
	$xFileName ='cuadernos34/'.'cuaderno'.$xNombreComun;
	
	//header("Location: ../tarzan/subir_file.php?xRutaFile=".$xRutaFile."&xFileName=".$xFileName."&xCuboName=".$xCuboName);
	
	SubirFicheroNube($xRutaFile,$xFileName);
}

SubirNube();

?>
