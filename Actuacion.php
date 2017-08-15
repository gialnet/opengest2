<?php require('Redmoon_php/controlSesiones.inc.php');  ?>
<?php
//
// Maria del Mar P�rez Fajardo
// Agosto 2009
//
require('Redmoon_php/pebi_cn.inc.php');
require('Redmoon_php/pebi_db.inc.php'); 

if(isset($_GET["xIDActo"]))
{
	$xIDActo = $_GET["xIDActo"];
	
$conn = db_connect();

$sql='SELECT o.descripcion,o.tarifa,o.tipo_asunto,(select descripcion from tipos_asuntos where id=o.tipo_asunto) as tip FROM actos_asuntos o
WHERE o.id=:xIDActo';

$stid = oci_parse($conn, $sql);

oci_bind_by_name($stid, ':xIDActo', $xIDActo,38, SQLT_INT);


$r = oci_execute($stid, OCI_DEFAULT);


}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Consultar Acto</title>

<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

<style type="text/css">

#DatosCOlabora{
position:absolute;
top:100px;
left:35px;
	width:720px;
	height:100px;
	
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
<script type="text/javascript">
function LeeColaborador()
{
	
	<?php
	$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);	
	?>

	document.getElementById('intar').value="<?php echo $row['TARIFA']; ?>";
	document.getElementById('tipo').value="<?php echo $row['TIP']; ?>";
	document.getElementById('indes').value="<?php echo  iconv('Windows-1252', 'UTF-8//TRANSLIT',$row['DESCRIPCION']); ?>";



}
</script>
</head>

<body onload="LeeColaborador()">
<?php require('cabecera.php'); ?>

<div id="documento">
<br/>
<br/>
<h4 align="center" class="Estilo1">Consultar Acto</h4>
<div id="DatosCOlabora">
<div id="winPop">
<form id="form1" name="form1" method="post" action="Redmoon_php/ORA_ModActo.php">
	
    <p>
 	 <label class="Estilo2">Descripci&oacute;n
    	<input name="indes" type="text" id="indes" size="40" maxlength="40" style="position:absolute; left:143px;"/>
     </label>
   	 <label class="Estilo2" style="position:absolute; left:60%;">Tarifa    	
     	<SELECT NAME="intar"  id="intar" style="position:absolute; left:60px;">
  		 <OPTION VALUE="S">S</OPTION>
   		<OPTION VALUE="N">N</OPTION>  
		</SELECT> 
     </label>
   </p>


  <p>

           <label class="Estilo2" >Tipo
    		<input name="tipo"  type="text" id="tipo" size="40" maxlength="40" style="position:absolute; left:143px;" DISABLED/></label>
			</label>
  </p>


     <p align="right">
   
      <input  name="submit" type="image" id="Grabar" value="Grabar" src="Redmoon_img/imgDoc/aceptar.png"/>
      
 </p>
  <input type="hidden" name="xID" id="xID" value="<?php echo $_GET['xIDActo'];?>" />
</form>
</div>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>


</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
</body>
</html>