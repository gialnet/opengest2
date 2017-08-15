<?php
require('Redmoon_php/controlSesiones.inc');

// reproductor de Windows Media Player

$usuario=$_SESSION['usuario'];
$rutaFile=$_GET['xFile'];
$rutaExt=$_GET['xExt'];
$rutaPlay='dewplayer/sonido/'.$usuario.'.'.$rutaExt;
copy($rutaFile,$rutaPlay);
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Reproductor WMA</title>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
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
Reproductor Windows Media Player
</div>
<br />
<br />
<object id="MediaPlayer" 
type="application/x-oleobject" height="42" standby="Instalando Windows Media Player ..." width="250" align="absMiddle" classid="CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95">
<param name="FileName" value="<?php echo $rutaPlay;?>">
</param><param name="AutoStart" value="true">
</param><param name="volume" value="3">
</param><param name="EnableContextMenu" value="1">
</param><param name="TransparentAtStart" value="false">
</param><param name="AnimationatStart" value="false">
</param><param name="ShowControls" value="true">
</param><param name="ShowDisplay" value="false">
</param><param name="ShowStatusBar" value="false">
</param><param name="autoSize" value="false">
</param><param name="displaySize" value="true">
</param></object>
<br />
<div id="Estilo5">
<h3 align="center">Cierre esta ventana para volver al expediente</h3>
</div>
</body>
</html>