<?php 

require('controlSesiones.inc.php');

$rpta = "";
if ($_POST["action"] == "upload") {
	$tmpfile = $_FILES['archivo']['tmp_name'];
	$tmpname = $_FILES['archivo']['name'];
	
	$ftpuser = "usuario";
	$ftppass = "password";
	$ftppath = "ftp.dominio.com/path/";
	$ftpurl = "ftp://".$ftpuser.":".$ftppass."@".$ftppath;
	
	if ($tmpname != "") {
		$fp = fopen($tmpfile, 'r');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $ftpurl.$tmpname);
		curl_setopt($ch, CURLOPT_UPLOAD, 1);
		curl_setopt($ch, CURLOPT_INFILE, $fp);
		curl_setopt($ch, CURLOPT_INFILESIZE, filesize($tmpfile));
		curl_exec($ch);
		$error = curl_errno($ch);
		curl_close ($ch);
		if ($error == 0) {
			$rpta = 'Archido subido correctamente.';
		} else {
			$rpta = 'Error al subir el archivo.';
		}
	} else {
		$rpta = 'Seleccionar un archivo.';
	}
}
?>
<html>
<head>
<title>FTP Upload con PHP</title>
<style type="text/css">
<!--
body {
	font-family: "Trebuchet MS", Tahoma, Verdana;
	font-size: 12px;
	color: #666666;
	text-decoration: none;
}
-->
</style>
</head>
<body>
<h4>FTP Upload con PHP</h4>
<form action="ftpupload.php" method="post" enctype="multipart/form-data">
Seleccionar archivo:<br> 
<input type="file" name="archivo"  /><br>
<input type="submit" name="enviar" value="Upload" /><br>
<input type="hidden" name="action" value="upload" />
<strong><?php echo $rpta; ?></strong>
</form>
</body>
</html>
