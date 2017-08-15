<?php require('Redmoon_php/controlSesiones.inc');  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ruta de almacenamiento del Cuaderno</title>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>
<style type="text/css">
#centrocuadrado{
	position:absolute;
	top:120px;
	text-align: center;
	font-weight:900;
	margin:15px 15px;
	 border:solid 1px;
	 border-color:#ebebeb;
	padding:15px 25px;
	background-color: #FFFFCC;
	width: 70%;
	left: 100px;

}

</style>
<script type="text/javascript">
//
// Tendrá que salir en función de quien le ha llamado Pago a Colaboradores o Pagos a Clientes
//
function Salir(){

	<?php 
	if (isset($_GET['xTipo']))
		echo 'location="PagosAClientes.php"';
	else 
		echo 'location="PagosAColaboradores.php"';
	?>
	
}
</script>
</head>

<body >
<?php require('cabecera.php'); ?>

<div id="documento">
<br />
<br />
<h4><p align="center" class="Estilo1">Ruta de Almacenamiento de Cuaderno</p></h4>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<div id="centrocuadrado">
<p align="left">
<img src="Redmoon_img/borrar1.png" alt="Salir"  onclick="Salir()" />

</p>
<p class="Estilo5">
Ruta local
</p>
<p>
<?php 
echo $_GET["xRutaLocal"];
?>
</p>
<p class="Estilo5">
Ruta en la nube
</p>
<p>
<?php 
echo $_GET["xRutaNube"];
?>
</p>
</div>

</div>

</body>
</html>