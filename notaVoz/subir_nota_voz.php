
<?php 
//
// Antonio Perez Caballero
// Septiembre 2010
// adjutar notade voz en el seguimiento y luego guardarla en opciones:
// - disco duro
// - nube
// - disco duro+nube
require('../Redmoon_php/controlSesiones.inc');
require_once '../cloudfusion/cloudfusion.class.php';
error_reporting(E_ALL);


require('../Redmoon_php/pebi_cn.inc');
require('../Redmoon_php/pebi_db.inc'); 


$xIDexpe=$_SESSION["IDExpe"];

//echo 'idExpe:'.$xIDexpe.'<br />';

	if(ALMACENAMIENTO=='localhost'){
		//la nota se escribe en el disco duro del servidor http C:\lgs\notas_de_voz\\
		$xURL=RUTA.'\\notas_de_voz\\'.$_SESSION["usuario"].'_nota_de_voz_'.date("YmdHms").'.wav';
		
	// PONER BIEN LA RUTA
		//$xURL=$_SESSION["usuario"].'_nota_de_voz_'.date("YmdHms").'.wav';
		echo 'almacenamiento<br />';
	}
	elseif (ALMACENAMIENTO=='amazon_S3'){
		$cubo='lgs';
		$xURL='/notas_de_voz/'.$_SESSION["usuario"].'_nota_de_voz_'.date("YmdHms").'.wav';
		
	}
	elseif (ALMACENAMIENTO=='localhost + amazon_S3'){
		 //la nota se escribe en el disco duro del servidor http
		 $xURL=RUTA.'/notas_de_voz/'.$_SESSION["usuario"].'_nota_de_voz_'.date("YmdHms").'.wav';
		//ruta nube hace falta otro campo para guardar esta ruta tambien
		//$cubo='lgs';
		//$xURL='/notas_de_voz/'.$_SESSION["usuario"].'_nota_de_voz_'.date("YmdHms").'.wav';
		 
	}
	else{
		echo 'No se ha configurado la ruta de almacenamiento de las notas de voz<br />';
		//$xURL='C:\\\LGS\\\Archivos'.'/notas_de_voz/'.$_SESSION["usuario"].'_nota_de_voz_'.date("YmdHms").'.wav';
		//echo 'url:'.$xURL;
		die();
		
	}

$conn = db_connect();

$xComent='Nota de Voz';
$xFileName=$_SESSION["usuario"].'_nota_de_voz_'.date("YmdHms").'.wav';

//echo '$xFileName:'.$xFileName;
//-- añadir el comentario y el fichero multimedia adjunto
$sql='begin pkAddSegui.AddComentSegui(:xIDexpe,
		:xComent,
 		:xFileName,
  		:xURL); end;';

$stid = oci_parse($conn, $sql);

oci_bind_by_name($stid, ':xIDexpe', $xIDexpe,38, SQLT_INT);
oci_bind_by_name($stid, ':xComent', $xComent,70, SQLT_CHR);
oci_bind_by_name($stid, ':xFileName', $xFileName,90, SQLT_CHR);
oci_bind_by_name($stid, ':xURL', $xURL,256, SQLT_CHR);


if(!oci_execute($stid)){
	echo 'error pkAddSegui.AddComentSegui';
	db_error($stid, __FILE__, __LINE__);
	oci_close($conn);
	die();
}



	$contenido_fichero=file_get_contents("php://input"); 
	

	if(ALMACENAMIENTO=='localhost'){
		//la nota se escribe en el disco duro del servidor http
	//	$xURL='C:\lgs\notas_de_voz\\'.$_SESSION["usuario"].'_nota_de_voz_'.date("YmdHms").'.wav';
		 if(!file_put_contents($xURL,$contenido_fichero)){
		 	echo 'No se puede guardar la nota de voz en disco entra almacenamiento';
		 }
	}
	elseif (ALMACENAMIENTO=='amazon_S3'){
		$cubo='lgs';
		$xURL='/notas_de_voz/'.$_SESSION["usuario"].'_nota_de_voz_'.date("YmdHms").'.wav';
		saveCubo($xURL,$contenido_fichero);
	}
	elseif (ALMACENAMIENTO=='localhost + amazon_S3'){
		 //la nota se escribe en el disco duro del servidor http
		 $xURL=RUTA.'/notas_de_voz/'.$_SESSION["usuario"].'_nota_de_voz_'.date("YmdHms").'.wav';
		 if(!file_put_contents($xURL,$contenido_fichero)){
		 	echo 'No se puede guardar la nota de voz en disco';
		 }
		//guardamos la nota en la nube
		$cubo='lgs';
		$xURL='/notas_de_voz/'.$_SESSION["usuario"].'_nota_de_voz_'.date("YmdHms").'.wav';
		saveCubo($xURL,$contenido_fichero); 
	}
	else{
		echo 'No se ha configurado la ruta de almacenamiento de las notas de voz 2<br />';
		die();
	}
	
	
//echo strlen($contenido_fichero);



oci_close($conn);
	
function saveCubo($xURL_NUBE,$contenido_fichero){
		$bucket='lgs';

		//$logFile='log_s3.txt';

		// Upload to AWS
		$s3 = new AmazonS3();
		


		$file = $s3->create_object($bucket, array(
        'filename' => $xURL_NUBE,
       'body' => $contenido_fichero,
       'contentType' => 'audio/vnd.wave',
        'acl' => S3_ACL_AUTH_READ
		));

		
			
		// Make sure the request was successful.
		if ($file->isOK()){
			echo '<p>Se ha subido a AWS S3, resultado OK</p>';
			//echo 'waw:'.$contenido_fichero;
		} 
		else {

        		echo '<p>Subida a AWS S3 Fallida</p>';
        		//$logFile->write("************* Upload to AWS FAILED" . PHP_EOL);
		}
	}

?>