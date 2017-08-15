<?php

//require('controlSesiones.inc');
require('../Redmoon_php/pebi_cn.inc');
require('../Redmoon_php/pebi_db.inc');
require('Subir_Fichero.php');

/*
This is an upload script for SWFUpload that attempts to properly handle uploaded files
in a secure way.

Notes:
	
	SWFUpload doesn't send a MIME-TYPE. In my opinion this is ok since MIME-TYPE is no better than
	 file extension and is probably worse because it can vary from OS to OS and browser to browser (for the same file).
	 The best thing to do is content sniff the file but this can be resource intensive, is difficult, and can still be fooled or inaccurate.
	 Accepting uploads can never be 100% secure.
	 
	You can't guarantee that SWFUpload is really the source of the upload.  A malicious user
	 will probably be uploading from a tool that sends invalid or false metadata about the file.
	 The script should properly handle this.
	 
	The script should not over-write existing files.
	
	The script should strip away invalid characters from the file name or reject the file.
	
	The script should not allow files to be saved that could then be executed on the webserver (such as .php files).
	 To keep things simple we will use an extension whitelist for allowed file extensions.  Which files should be allowed
	 depends on your server configuration. The extension white-list is _not_ tied your SWFUpload file_types setting
	
	For better security uploaded files should be stored outside the webserver's document root.  Downloaded files
	 should be accessed via a download script that proxies from the file system to the webserver.  This prevents
	 users from executing malicious uploaded files.  It also gives the developer control over the outgoing mime-type,
	 access restrictions, etc.  This, however, is outside the scope of this script.
	
	SWFUpload sends each file as a separate POST rather than several files in a single post. This is a better
	 method in my opinions since it better handles file size limits, e.g., if post_max_size is 100 MB and I post two 60 MB files then
	 the post would fail (2x60MB = 120MB). In SWFupload each 60 MB is posted as separate post and we stay within the limits. This
	 also simplifies the upload script since we only have to handle a single file.
	
	The script should properly handle situations where the post was too large or the posted file is larger than
	 our defined max.  These values are not tied to your SWFUpload file_size_limit setting.
	
*/

// Code for Session Cookie workaround
	if (isset($_POST["PHPSESSID"])) {
		session_id($_POST["PHPSESSID"]);
	} else if (isset($_GET["PHPSESSID"])) {
		session_id($_GET["PHPSESSID"]);
	}

	session_start();

// Check post_max_size (http://us3.php.net/manual/en/features.file-upload.php#73762)
	$POST_MAX_SIZE = ini_get('post_max_size');
	$unit = strtoupper(substr($POST_MAX_SIZE, -1));
	$multiplier = ($unit == 'M' ? 1048576 : ($unit == 'K' ? 1024 : ($unit == 'G' ? 1073741824 : 1)));

	if ((int)$_SERVER['CONTENT_LENGTH'] > $multiplier*(int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
		header("HTTP/1.1 500 Internal Server Error"); // This will trigger an uploadError event in SWFUpload
		echo "POST se pasa del tamaño máximo permitido.<BR />";
		exit(0);
	}

	
// Ajustes
// cambiaremos al path que necesitemos según configuración
	//$save_path = getcwd() . "/uploads/";				
	$save_path = GetPathUpload().'/';
	
	$upload_name = "FicheroAdjunto";
	$max_file_size_in_bytes = 2147483647;				// 2GB in bytes
	$extension_whitelist = array("jpg", "gif", "png", "pdf", "mp3", "wma", "wav");	// Allowed file extensions
	$valid_chars_regex = '.A-Z0-9_ !@#$%^&()+={}\[\]\',~`-';				// Characters allowed in the file name (in a Regular Expression format)
	
// Otras variables	
	$MAX_FILENAME_LENGTH = 260;
	$file_name = "";
	$file_extension = "";
	$uploadErrors = array(
        0=>"Correcto, el archivo se ha subido",
        1=>"El tamaño del archivo excede de la directiva de tamaño máximo del php.ini",
        2=>"El tamaño del archivo excede de la directiva especificada en MAX_FILE_SIZE del formulario HTML",
        3=>"Se ha subido parcialmente",
        4=>"No se ha subido el archivo",
        6=>"No encuentro la carpeta temporal"
	);


// Validate the upload
	if (!isset($_FILES[$upload_name])) {
		HandleError("No se ha encontrado el archivo en \$_FILES para " . $upload_name);
		exit(0);
	} else if (isset($_FILES[$upload_name]["error"]) && $_FILES[$upload_name]["error"] != 0) {
		HandleError($uploadErrors[$_FILES[$upload_name]["error"]]);
		exit(0);
	} else if (!isset($_FILES[$upload_name]["tmp_name"]) || !@is_uploaded_file($_FILES[$upload_name]["tmp_name"])) {
		HandleError("Upload failed is_uploaded_file test.");
		exit(0);
	} else if (!isset($_FILES[$upload_name]['name'])) {
		HandleError("El fichero no tiene nombre.");
		exit(0);
	}
	
// Validate the file size (Warning: the largest files supported by this code is 2GB)
	$file_size = @filesize($_FILES[$upload_name]["tmp_name"]);
	if (!$file_size || $file_size > $max_file_size_in_bytes) {
		HandleError("El fichero excede del tamaño máximo permitido");
		exit(0);
	}
	
	if ($file_size <= 0) {
		HandleError("El tamaño del archivo demasiado grande para poco ancho de banda disponible");
		exit(0);
	}


// Validate file name (for our purposes we'll just remove invalid characters)
	$file_name = preg_replace('/[^'.$valid_chars_regex.']|\.+$/i', "", basename($_FILES[$upload_name]['name']));
	if (strlen($file_name) == 0 || strlen($file_name) > $MAX_FILENAME_LENGTH) {
		HandleError("Nombre de fichero no permitido");
		exit(0);
	}


// Validate that we won't over-write an existing file
	if (file_exists($save_path . $file_name)) {
		echo '<h1>Subir archivos</h1><BR />';
		echo $save_path . $file_name.'<BR />';
		HandleError("El fichero existe");
		exit(0);
	}

// Validate file extension
	$path_info = pathinfo($_FILES[$upload_name]['name']);
	$file_extension = $path_info["extension"];
	$is_valid_extension = false;
	foreach ($extension_whitelist as $extension) {
		if (strcasecmp($file_extension, $extension) == 0) {
			$is_valid_extension = true;
			break;
		}
	}
	if (!$is_valid_extension) {
		HandleError("Extensión no permitida");
		exit(0);
	}

// Validate file contents (extension and mime-type can't be trusted)
	/*
		Validating the file contents is OS and web server configuration dependant.  Also, it may not be reliable.
		See the comments on this page: http://us2.php.net/fileinfo
		
		Also see http://72.14.253.104/search?q=cache:3YGZfcnKDrYJ:www.scanit.be/uploads/php-file-upload.pdf+php+file+command&hl=en&ct=clnk&cd=8&gl=us&client=firefox-a
		 which describes how a PHP script can be embedded within a GIF image file.
		
		Therefore, no sample code will be provided here.  Research the issue, decide how much security is
		 needed, and implement a solution that meets the needs.
	*/


// Process the file
	/*
		At this point we are ready to process the valid file. This sample code shows how to save the file. Other tasks
		 could be done such as creating an entry in a database or generating a thumbnail.
		 
		Depending on your server OS and needs you may need to set the Security Permissions on the file after it has
		been saved.
	*/
	if (!@move_uploaded_file($_FILES[$upload_name]["tmp_name"], $save_path.$file_name)) {
		echo $save_path.$file_name;
		HandleError("El fichero no puede ser guardado.");
		exit(0);
	}

	echo '<h1>Subir archivos</h1><BR />';
	echo 'Se ha guardado el archivo: '.$save_path.$file_name;
	echo '<BR />'.'Con un tamaño de: '.$file_size.' bytes';
	echo '<h3>Puede cerrar esta ventana para continuar</h3><BR />';
	GrabaBaseDatos($file_name,$save_path);
	exit(0);


/* Handles the error output. This error message will be sent to the uploadSuccess event handler.  The event handler
will have to check for any error messages and react as needed. */
function HandleError($message) {
	echo $message.'<BR />';
	echo '<h3>Puede cerrar esta ventana para continuar</h3><BR />';
}

//
// Grabar la ruta en la base de datos
//
function GrabaBaseDatos($xNombreFichero,$xCamino)
{
$conn = db_connect();

// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'BEGIN pkAddSegui.AddComentSegui(:xIDExpe, :xComenta, :xNombreFichero, :xRuta); END;';


    $stmt = oci_parse($conn, $sql);
    if (!$stmt)
        echo "<BR />error del paquete";
    
    $xIDExpe = $_POST["xIDExpe"];
    $xComent = $_POST["xComentario"]; 
    
    if (!oci_bind_by_name($stmt, ':xIDExpe', $xIDExpe, 38, SQLT_INT))
        echo "No puede vincular el xIDExpe";
        
    if (!oci_bind_by_name($stmt, ':xComenta', $xComent, 50, SQLT_CHR))
       echo "No puede vincular el xComenta";
    
    if (!oci_bind_by_name($stmt, ':xNombreFichero', $xNombreFichero, 90, SQLT_CHR))
       echo 'No puede vincular nombre del fichero';
       
    if (!oci_bind_by_name($stmt, ':xRuta', $xCamino, 256, SQLT_CHR))
    	echo 'No puede vincular la ruta del archivo';
    
	if(oci_execute($stmt))
	{
	     echo "<BR />Ok";
	}
	else
	{
	   echo "<BR />Error AddComentSegui: ".$xIDExpe.' comentario: '.$xComent;
	   echo "<BR /> Nombre archivo:".$xNombreFichero.'<BR /> Ruta: '.$xCamino;
	}

	oci_close($conn);
}

?>