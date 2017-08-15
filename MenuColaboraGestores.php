<?php 
require_once('Redmoon_php/controlSesiones.inc.php');  
require_once('cabecera.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Menu Principal</title>
<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

<style type="text/css">
#VideoMensajes{
	position:absolute;
	top:9px;
	left:147px;
	height: 225px;
	width: 588px;
	border:thin;
	margin:15px 15px;
	padding:15px 25px;
	border-bottom: solid 2px;
	border-right: solid 2px;
	border-top: solid 1px;
	border-left: solid 1px;
	background-color: #FFFFCC;
	visibility:hidden;
}
.Estilo1 {
	color: #3c4963;
	font-weight: bold;
}
.Estilo2 {
	color: #36679f;
	font-weight: bold;
}
</style>
</head>

<body>
<div id="ayuda_btn">
<img src="Redmoon_img/imgDoc/ayuda.png" onclick="AbrirAyuda('Gestoria_documentacion/menu_colaboradores.html')" />
</div>
<div id="documento">
<br/>
<br/>
<div id="sombra_menu"></div>
 <h4 align="center" class="Estilo1">Men&uacute; Principal</h4>

<p style="position: relative; left:50px;">
</p>

<a href="TareasColaboradores.php" class="Estilo2"><div id="menuColabora1"></div></a>
<a href="ColaboradoresExpedientes.php" class="Estilo2"><div id="menuColabora2"></div></a>
<a href="Colaboradores.php" class="Estilo2"><div id="menuColabora3"></div></a>


</div>
</body>
</html>
