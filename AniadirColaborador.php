<?php

require_once('Redmoon_php/controlSesiones.inc.php');
require_once('Redmoon_php/pebi_cn.inc.php');
require_once('Redmoon_php/pebi_db.inc.php');

$conn = db_connect();

$sql = 'select nombre from COLABORADORES_TIPO';
	$stid = oci_parse($conn, $sql);   
	
	$r = oci_execute($stid, OCI_DEFAULT);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>A&ntilde;adir Colaborador</title>

<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

<style type="text/css">

#DatosCOlabora{
position:absolute;
top:100px;

	width:720px;
	height:250px;
	left:40px;
	
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
<h4 align="center" class="Estilo1">A&ntilde;adir Colaborador</h4>
<div id="DatosCOlabora">
<div id="winPop">
<form id="form1" name="form1" method="post" action="Redmoon_php/ORA_AniadirColaborador.php">
	
    <p>
 	 <label class="Estilo2">Fecha de Alta
    	<input name="infechAlta" type="text" id="infechAlta" size="10" maxlength="10" style="position:absolute; left:143px;"/>
     </label>
     <label style="position:absolute; left:57%" class="Estilo2">e-mail
    	<input name="ineMail" type="text" id="ineMail" size=25" maxlength="30" style="position:absolute; left:87px; top:0px;"  />
     </label>
   </p>
   <p>
   	<label  class="Estilo2">Nombre
  		<input name="inNombre" type="text" id="inNombre" size="40" maxlength="50" style="position:absolute; left:143px;"/>
  	</label>
  	<label class="Estilo2" style="position:absolute; left:57%">NIF
  		<input name="inNIF" type="text" id="inNIF" size="14" maxlength="14" style="position:absolute; left:87px; top:0px;" />
 	</label>
  	
  </p>
  <p>
    <label class="Estilo2">Dirección
   		 <input name="inDireccion" type="text" id="inDireccion" size="40" maxlength="50" style="position:absolute; left:143px;"/>
    </label>
    <label class="Estilo2" style="position:absolute; left:57%">Poblaci&oacute;n
    	<input name="inPoblacion" type="text" id="inPoblacion" size="25" maxlength="25" style="position:absolute; left:87px; top:0px;"/>
    </label>
   
  </p>
  <p>
      <label class="Estilo2" style="position:absolute; left:57%">CP
  		<input name="inCP" type="text" id="inCP" size="5" maxlength="5" style="position:absolute; left:87px; top:0px;"/>
  	</label> 
   <label class="Estilo2">Provincia
    	<input type="text" name="inProvincia" id="inProvincia" style="position:absolute; left:143px;"/>
    </label>

  </p>

  <p>
     <label class="Estilo2">Aseguradora
    		<input name="inAseguradora" type="text" id="inAseguradora" size="40" maxlength="40" style="position:absolute; left:143px;"/>
	 </label>
   
     <label class="Estilo2" style="position:absolute; left:57%">Fecha P&oacute;liza
    		<input name="infechSeg" type="text" id="infechSeg" size="10" maxlength="10" />
    </label>
  </p>
    <p>
     
     <label class="Estilo2">N&deg; de P&oacute;liza
   		<input name="inPoliza" type="text" id="inPoliza" size="20" maxlength="20" style="position:absolute; left:143px;"/>
    </label>
         <label class="Estilo2" style="position:absolute; left:57%">Tipo
    		    <select name="tipo" size="1" id="tipo"  style="position:absolute; left:87px; top:0px;" >
    <?php 
    
    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    	//$codificada = strtr($row['DESCRIPCION'], $tabla);
		print '<option value="'.$row['NOMBRE'].'">'.$row['NOMBRE'].'</option>';
	}
	?>
  </select>

 
  
    </label>  </p>
    
    
    <p><label class="Estilo2" >Interno
   	<input style="text-transform:uppercase;" name="inInterno" type="text" id="inInterno" size="3" maxlength="2" style="position:absolute; left:143px;"/>
    </label></p>
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