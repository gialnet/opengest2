<?php
require_once('Redmoon_php/controlSesiones.inc.php');

// reproductor de MP3
/*
 * <param name="movie" value="dewplayer/dewplayer-mini.swf?mp3=<?php $_GET['xFile']?>&amp;autostart=1&amp;showtime=1" />
 * 
 */
$usuario=$_SESSION['usuario'];
$rutaFile=$_GET['xFile'];
$rutaPlay='dewplayer/sonido/'.$usuario.'.mp3';
copy($rutaFile,$rutaPlay);
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reproductor MP3</title>
<style type="text/css">
#campos{
	position:absolute;
	left:20px;
}
#Titulo{
text-align:center;
font-size:16px;
color:#36679f;
font-weight: bold;
}
#color{
background-color: #FFFFCC;
border:solid 8px;
	border-color:#ebebeb;
	

	padding:20px 40px;
}
#Estilo2 {

	color: #36679f;
	margin: 4px 15px;
	cursor: pointer;
	font-weight: bold;
}
#Estilo5 {color:  #3c4963; font-weight: bold; }
</style>
<script type="text/javascript">

</script>
</head>

<body id="color">
<br />
<div align="center" id="Titulo">
Reproductor MP3
</div>
<br />
<br />
<object type="application/x-shockwave-flash" data="dewplayer/dewplayer-mini.swf" width="160" height="20" id="dewplayer" name="dewplayer">
<param name="wmode" value="transparent" />
<param name="movie" value="dewplayer/dewplayer-mini.swf?mp3=<?php echo $rutaPlay;?>&amp;autostart=1&amp;showtime=1" />
</object>
<br />
<div id="Estilo5">
<h3 align="center">Cierre esta ventana para volver al expediente</h3>
</div>
</body>
</html>