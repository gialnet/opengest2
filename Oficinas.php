<?php
//
// Maria del Mar PÈrez Fajardo
// Agosto 2009
//
require_once('Redmoon_php/controlSesiones.inc.php');
require_once('Redmoon_php/pebi_cn.inc.php');
require_once('Redmoon_php/pebi_db.inc.php');

if(isset($_GET["xOficina"]))
{
	$xOficina = $_GET["xOficina"];
	
$conn = db_connect();

$sql='SELECT o.OFICINA,o.NOMBRE,o.EMAIL, o.DIRECCION,o.POBLACION,o.PROVINCIA,o.COD_POSTAL,o.TELEFONO,
o.PERSONA_CONTACTO,o.LAST_GESTOR,(select nombre from colaboradores where id= o.last_gestor) as colaborador FROM OFICINAS o
WHERE o.OFICINA=:xOficina';

$stid = oci_parse($conn, $sql);

oci_bind_by_name($stid, ':xOficina', $xOficina,4, SQLT_CHR);


$r = oci_execute($stid, OCI_DEFAULT);

$sql2='SELECT n.nombre,o.notario_habitual,O.OFICINA FROM OFICINAS o ,notarios n
WHERE o.OFICINA=:xOficina and o.NOTARIO_HABITUAL=cod_notario';

$stid2= oci_parse($conn, $sql2);
oci_bind_by_name($stid2, ':xOficina', $xOficina, 4, SQLT_CHR);
$r2 = oci_execute($stid2, OCI_DEFAULT);
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Oficina</title>

<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>
<style type="text/css">
#VentanaTabla{
	position:absolute;
	top: 420px;
	left: 270px;
	overflow:auto;
	cursor:pointer;
}
#DatosOficina{
	border:thin;
		border:solid 8px;
	border-color:#ebebeb;
	
	margin:15px 15px;
	padding:20px 40px;
	background-color: #FFFFCC;
}
#CambiarNotario{
	position:absolute;
	top: 260px;
	left: 730px;

}
#CambiarGestor{
	position:absolute;
	top: 298px;
	left: 355px;

}
#AddGestor{
	position:absolute;
	top: 298px;
	left: 395px;

}
#VerGestores{
	position:absolute;
	top: 298px;
	left: 435px;
}
#AyudaAddGestor{
	position:absolute;
	top:53px;
	left:145px;
	visibility:hidden;
}

#AyudaGestorHabitual{
	position:absolute;
	top:53px;
	left:105px;
	visibility:hidden;
}
#AyudaVerGestores{

	position:absolute;
	top:53px;
	left:185px;
	visibility:hidden;
}

#TextoAyuda{
	position:absolute;
	top:35px;
	left:20px;
	margin-right:20px;

}
#AyudaCambiarNotario{

	position:absolute;
	top:15px;
	left:478px;
	visibility:hidden;
}
 .Estilo1 {
	color: #3c4963;
	font-weight: bold;
}
.Estilo2 {

	color: #36679f;
	margin: 4px 15px;
	cursor: pointer;
	font-weight: bold;
}
.Estilo5 {color: #36679f; font-weight: bold; }
</style>
<script type="text/javascript">
function LeeColaborador()
{
	
	<?php
	$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);	
	?>
	document.getElementById('inOficina').value="<?php echo $xOficina; ?>";
	document.getElementById('inNombre').value="<?php echo  iconv('Windows-1252', 'UTF-8//TRANSLIT',$row['NOMBRE']); ?>";
	document.getElementById('inPoblacion').value="<?php echo  iconv('Windows-1252', 'UTF-8//TRANSLIT',$row['POBLACION']); ?>";
	document.getElementById('inProvincia').value="<?php echo iconv('Windows-1252', 'UTF-8//TRANSLIT',$row['PROVINCIA']); ?>";
	document.getElementById('inCP').value="<?php echo  $row['COD_POSTAL']; ?>";
	document.getElementById('inTLF').value="<?php echo  $row['TELEFONO']; ?>";
	
	document.getElementById('inContacto').value="<?php echo iconv('UTF-8//TRANSLIT','Windows-1252' ,$row['PERSONA_CONTACTO']);  ?>";
	
	document.getElementById('ineMail').value="<?php echo  $row['EMAIL']; ?>";
	document.getElementById('inDireccion').value="<?php echo iconv('Windows-1252', 'UTF-8//TRANSLIT',$row['DIRECCION']); ?>";
	document.getElementById('inGestor').value="<?php echo iconv('Windows-1252', 'UTF-8//TRANSLIT',$row['COLABORADOR']); ?>";
	document.getElementById('idGestor').value="<?php echo iconv('Windows-1252', 'UTF-8//TRANSLIT',$row['LAST_GESTOR']); ?>";

	<?php
			$row = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS);	
			//$xOficina2=$row['OFICINA'];
	?>
	document.getElementById('inNotario').value="<?php echo iconv('Windows-1252', 'UTF-8//TRANSLIT',$row['NOMBRE']); ?>";
	document.getElementById('xNot').value="<?php echo $row['NOTARIO_HABITUAL']; ?>";

}

//
// Cambiar el notario por defecto
//
function CambiarNotario(){
	
	var Oficina=document.getElementById('inOficina').value;
	
	//alert(Oficina);
	location="CambiarNotario.php?xOficina="+Oficina;
}

//
// Cambiar la gestoria por defecto
//
function CambiarGestor(){
	var Oficina=document.getElementById('inOficina').value;
	
	location="CambiarGestor.php?xOficina="+Oficina+"&xGestor=H";
}

//
//AÒadir otra gestoria 
//

function AddGestor(){
	var Oficina=document.getElementById('inOficina').value;
	
	location="CambiarGestor.php?xOficina="+Oficina+"&xGestor=A";
}

//
//
//
function SobreCambiarGestor(){
	AreaDiv = document.getElementById("AyudaAddGestor");
	AreaDiv.style.visibility='visible';
	
}
//
//
//

function SalirCambiarGestor(){
	AreaDiv = document.getElementById("AyudaAddGestor");
	AreaDiv.style.visibility='hidden';
	
}
//AyudaGestorHabitual
//
//
//
function SobreGestorHabitual(){
	AreaDiv = document.getElementById("AyudaGestorHabitual");
	AreaDiv.style.visibility='visible';
	
}
//
//
//

function SalirGestorHabitual(){
	AreaDiv = document.getElementById("AyudaGestorHabitual");
	AreaDiv.style.visibility='hidden';
	
}
//AyudaCambiarNotario
//
//
//
function SobreAyudaCambiarNotario(){
	AreaDiv = document.getElementById("AyudaCambiarNotario");
	AreaDiv.style.visibility='visible';

}
//
//
//

function SalirAyudaCambiarNotario(){
	AreaDiv = document.getElementById("AyudaCambiarNotario");
	AreaDiv.style.visibility='hidden';
	
}
function SalirVerGestores(){
	AreaDiv = document.getElementById("AyudaVerGestores");
	AreaDiv.style.visibility='hidden';
	
}

function SobreVerGestores(){
	AreaDiv = document.getElementById("AyudaVerGestores");
	AreaDiv.style.visibility='visible';
	
}

//Pantalla donde se visualizan los colaboradores asociados a la oficina
function VerGestoresOficina(){
	var Oficina=document.getElementById('xOficina').value;
	
	location="GestoresOficinas.php?xOficinas="+Oficina+"&xGestor=A";
}
</script>
</head>

<body  onload="LeeColaborador()">

<?php require('cabecera.php'); ?>
<div id="documento">


<br/>
<br/>
<h4 align="center" class="Estilo1">Oficina</h4>

<div id="VerGestores">
<img src="Redmoon_img/ver.png" onclick="VerGestoresOficina()" onmouseover="SobreVerGestores()" onmouseout="SalirVerGestores()"/>
</div>

<div id="CambiarNotario">
<img src="Redmoon_img/cambiar2.png" onclick="CambiarNotario()" onmouseover="SobreAyudaCambiarNotario()" onmouseout="SalirAyudaCambiarNotario()"/>
</div>

<div id="CambiarGestor">
<img src="Redmoon_img/Cambiar2.png" onclick="CambiarGestor()" onmouseover="SobreGestorHabitual()" onmouseout="SalirGestorHabitual()"/>
</div>

<div id="AddGestor">
<img src="Redmoon_img/Add2.png" onclick="AddGestor()" onmouseover="SobreCambiarGestor()" onmouseout="SalirCambiarGestor()"/>
</div>

<div id="DatosOficina">
	<form id="form1" name="form1" method="post" action="Redmoon_php/ORAdatosOficina.php">
	
    	<p>
 	 		<label class="Estilo2">Oficina
    			<input name="inOficina" type="text" id="inOficina" disabled="disabled" size="10" maxlength="50" style="position:absolute; left:140px;"/>
     		</label>
     		<label class="Estilo2" style="position:absolute; left:53%">e-mail
    			<input name="ineMail" type="text" id="ineMail" size="30" maxlength="50" style="position:absolute; left:75px;"  />
     		</label>
   		</p>
   		
   		<p>
   			<label  class="Estilo2">Nombre
  				<input name="inNombre" type="text" id="inNombre" size="30 maxlength="50" style="position:absolute; left:140px;"/>
  			</label>
  			<label class="Estilo2" style="position:absolute; left:53%">Telefono
  				<input name="inTLF" type="text" id="inTLF" size="12" maxlength="12" style="position:absolute; left:75px;" />
 			</label>  	
  		</p>
  		
  		<p>
   			<label class="Estilo2">Direcci√≥n
   		 		<input name="inDireccion" type="text" id="inDireccion" size="30" maxlength="50" style="position:absolute; left:140px;"/>
    		</label>
    		<label class="Estilo2" style="position:absolute; left:53%">Poblaci&oacute;n
    			<input name="inPoblacion" type="text" id="inPoblacion" size="30" maxlength="25" style="position:absolute; left:75px;"/>
    		</label>   
  		</p>
  		
  		<p>
      		<label class="Estilo2" style="position:absolute; left:53%">CP
  				<input name="inCP" type="text" id="inCP" size="5" maxlength="5" style="position:absolute; left:75px;"/>
  			</label> 
   			<label class="Estilo2">Provincia
    			<input type="text" name="inProvincia" id="inProvincia" size="30" maxlength="50" style="position:absolute; left:140px;"/>
    		</label>
 	 	</p>
 	 	
  		<p>
     		<label class="Estilo2">Contacto
    			<input name="inContacto" type="text" id="inContacto" size="30" maxlength="40" style="position:absolute; left:140px;"/>
	 		</label>
    		<label class="Estilo2" style="position:absolute; left:53%">Notario
  				<input name="inNotario" type="text" id="inNotario" size="30" maxlength="100" style="position:absolute; left:75px;"/>
  			</label> 
  		</p>
  		
    	<p>
     		<label class="Estilo2">Gestoria
    			<input name="inGestor" type="text" id="inGestor" size="30" maxlength="40" style="position:absolute; left:140px;"/>
	 		</label>
  		</p>
  		
 		<br/>

    	<p>
   			<label class="Estilo2" style="position:absolute; left:46%">
       			<input  name="submit" type="image" id="Grabar" value="Grabar" src="Redmoon_img/aceptar2.png"/>
      		</label>
  		</p>
 		
 		<br/>
 		
  		<input type="hidden" name="xOficina" id="xOficina" value="<?php echo $xOficina; ?>" />
   		<input type="hidden" name="xNot" id="xNot"  />
    	<input type="hidden" name="idGestor" id="idGestor"  />
	</form>
	<br/>
</div>

<div id="AyudaAddGestor">
<img src="Redmoon_img/fondo_ayuda.png"/>
<div id="TextoAyuda">
<img src="Redmoon_img/Add2.png"/>
<span class="Estilo5">Para agregar otros gestores administrativos a la oficina pulse este icono</span>
</div>
</div>

<div id="AyudaGestorHabitual">
<img src="Redmoon_img/fondo_ayuda.png"/>
<div id="TextoAyuda">
<img src="Redmoon_img/cambiar2.png"/>
<span class="Estilo5">Para cambiar el gestor por defecto de la oficina pulse este icono</span>
</div>
</div>

<div id="AyudaVerGestores">
<img src="Redmoon_img/fondo_ayuda.png"/>
<div id="TextoAyuda">
<img src="Redmoon_img/ver.png"/>
<span class="Estilo5">Para ver todos los gestores asociados a esta oficina pulse este icono</span>
</div>
</div>


<div id="AyudaGestorHabitual">
<img src="Redmoon_img/fondo_ayuda.png"/>
<div id="TextoAyuda">
<img src="Redmoon_img/cambiar2.png"/>
<span class="Estilo5">Para cambiar el gestor por defecto de la oficina pulse este icono</span>
</div>
</div>

<div id="AyudaCambiarNotario">
<img src="Redmoon_img/fondo_ayuda.png"/>
<div id="TextoAyuda">
<img src="Redmoon_img/cambiar2.png"/>
<span class="Estilo5">Para cambiar de Notario pulse este icono</span>
</div>
</div>




<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
</body>
</html>