<?php 
require_once('Redmoon_php/controlSesiones.inc.php');
require_once('Redmoon_php/pebi_cn.inc.php');
require_once('Redmoon_php/pebi_db.inc.php');

$conn = db_connect();

$sql = 'select descripcion from tipos_asuntos';
	$stid = oci_parse($conn, $sql);   
	
	$r = oci_execute($stid, OCI_DEFAULT);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>A&ntilde;adir Acto</title>

<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

<style type="text/css">

#DatosCOlabora{
position:absolute;
top:50px;

	width:720px;
	height:100px;
	border:thin;
	margin:15px 15px;
	padding:35px 25px;
	
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

<body >
<?php require('cabecera.php'); ?>

<div id="documento">
<br/>
<br/>
<h4 align="center" class="Estilo1">A&ntilde;adir Acto</h4>
<div id="DatosCOlabora">
<div id="winPop">
<form id="form1" name="form1" method="post" action="Redmoon_php/ORA_aniadirActo.php">
	
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
   <select name="tipo" size="1" id="tipo"  style="position:absolute; left:143px;" >
    <?php 
    
    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    	//$codificada = strtr($row['DESCRIPCION'], $tabla);
		print '<option value="'.$row['DESCRIPCION'].'">'.$row['DESCRIPCION'].'</option>';
	}
	?>
  </select></label>

  </p>


    </label>
     <p align="right">
  
      <input  name="submit" type="image" id="Grabar" value="Grabar" src="Redmoon_img/imgDoc/aceptar.png"/>
      
 </p>
  
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