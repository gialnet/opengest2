
<?php 
require('../Redmoon_php/pebi_cn.inc.php');
require('../Redmoon_php/pebi_db.inc.php'); 

$conn = db_connect();
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_GET["Titulo"];?></title>

<link href="../Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="../Redmoon_js/cabecera.js" type="text/javascript"></script>
<style type="text/css">
#Grafico{
	position:absolute;
	top:118px;
	left:5px;
	right:100px;
	bottom:300px;
	height: 300px;
	align:center;
	width: 781px;
	padding: 15px;
}
.Estilo1 {
	color: #3c4963;
	font-weight: bold;
}
</style>
<script type="text/javascript" src="js/swfobject.js"></script>
<script type="text/javascript">
swfobject.embedSWF(
  "open-flash-chart.swf", "expedientes",
  "400", "300", "9.0.0", "expressInstall.swf",
  {"data-file":"<? echo $_GET["NombreData"];?>"} );
</script>
</head>

<body >
<?php require('cabecera.php'); ?>
<div id="documento">
<br/>
<br/>
  <h4 align="center" class="Estilo1">Comparativa de Solicitudes por Años</h4>
  

  <p>&nbsp;</p>
        <p>&nbsp;</p>
        <div id="Grafico" align="center">
        <div id="expedientes">
        </div>
        </div>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
</div>

    </body>
</html>
