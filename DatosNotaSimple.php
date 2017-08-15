<?php require_once('Redmoon_php/controlSesiones.inc.php');
$xIDExpe= (int)$_REQUEST["xIDExpe"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Datos de la Finca</title>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAA9eoH_keOm184h3MQDj6AahQPvp99z-WpUhdvARRstH-9JZhRMBQdpEgN1Lb0y7d0LBM1BmOq8rlU3w"  type="text/javascript" charset="utf-8"></script>

<script src="Redmoon_js/GoogleMap.js" type="text/javascript"></script>
<script src="Redmoon_js/Solicitantes.js" type="text/javascript"></script>
<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>
<script type="text/javascript">
//
//
//
function GrabarDatosFinca()
{

	if (document.getElementById('PedirNota').checked)
		mPedir='S';
	else
		mPedir='N';

	
	if (document.getElementById('idPLUSVALIA').checked)
		mPlusva='S';
	else
		mPlusva='N';
	
	if (document.getElementById('idCATASTRO').checked)
		mCatastro='S';
	else
		mCatastro='N';
	
	var url_parametros='xRegistro='+document.getElementById('RegistroFinca').value+
	'&xNumRegistro='+document.getElementById('NumeroFinca').value+
	'&xNombre='+document.getElementById('TitularFinca').value+	
	'&xMunicipio='+document.getElementById('inPoblacion').value+
	'&xCalle='+document.getElementById('inDireccion').value+
	'&xPortal='+document.getElementById('Piso').value+
	'&xTomo='+document.getElementById('Tomo').value+
	'&xLibro='+document.getElementById('Libro').value+
	'&xSeccion='+document.getElementById('Seccion').value+
	'&xFolio='+document.getElementById('Folio').value+
	'&xLatitud='+document.getElementById('inLatitud').value+
	'&xLongitud='+document.getElementById('inLongitud').value+
	'&xPedirNota='+mPedir+
	'&xPlusva='+mPlusva+
	'&xCatastro='+mCatastro+ 
	'&xIDExpe='+document.getElementById('inIDExpe').value;

	
	//document.getElementById('PedirNota').value+	
	//
	ActivaInterfazGrabando();
	
	//alert(url_parametros);
	PutDataFincas('Redmoon_php/AddFinca.php', url_parametros);
}
//
//Leer datos de Oracle v�a Ajax y PHP
//
function PutDataFincas(url,dataToSend){
	
	var pageRequest = false;
	
	if (window.XMLHttpRequest) {
		pageRequest = new XMLHttpRequest();
	}
	else if (window.ActiveXObject){ 
		try {
			pageRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} 
		catch (e) {
			try{
				pageRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e){}
		}
	}
	else return false;
	
	pageRequest.onreadystatechange=function() {	ProcRespFincas(pageRequest);};
	
	if (dataToSend) {		
		pageRequest.open('POST',url,true);
 	pageRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		pageRequest.send(dataToSend);
	}
	else {
		pageRequest.open('GET',url,true)
		pageRequest.send(null)	
	}
}


//
//Recibe la respuesta del servidor
//
function ProcRespFincas(pageRequest){

	
	if (pageRequest.readyState == 4)	
	{
		if (pageRequest.status==200)
		{
			// despues de grabar dejar las cosas como estaban		
			DesctivaInterfazGrabando();		
			
			//alert(pageRequest.responseText);
			if (pageRequest.responseText=='Error')
			    alert(pageRequest.responseText);
		
			location='MenuTitulares.php?xIDExpe='+document.getElementById('inIDExpe').value;

		}
	}
	else return;
}
//
// Asignar el numero de expediente y poner en pantalla los datos en caso de modificacion
//
function LeeExpediente()
{

	//alert(ArrayValores.length);
	if(location.search)
	{
		ArrayParametros=location.search.split('=');
		ArraValor=ArrayParametros[1].split('&');
		//alert(ArraValor[0]);
		document.getElementById("inIDExpe").value=ArraValor[0];
		
	}
}


</script>
<style type="text/css">
#PrimeraColumna{
	position:absolute;
	top:102px;
	left:0px;
	right:100px;
	bottom:300px;
	height: 264px;
	width: 413px;
	
	padding: 15px;
	text-align:right;
        color:#333;

        border-color: #eee;
        border-style:solid;
	/* css3 */
	-moz-border-radius:10px;
	-webkit-border-radius:10px;
	border-radius:10px;
     
}

#PieDatos{
	position:absolute;
	top:445px;
	
	bottom:300px;
	height: 80px;
	width:750px;
	
	padding: 15px;
	
padding: 15px;
	text-align:center;
        color:#333;

        border-color: #eee;
        border-style:solid;
	/* css3 */
	-moz-border-radius:10px;
	-webkit-border-radius:10px;
	border-radius:10px;
}

</style>
</head>

<body  onload="load(); LeeExpediente();" onunload="GUnload()">
<!--  <body id="cuerpo"> -->
<?php require('cabecera.php'); ?>
<div id="documento">
      <div id="rastro"><a href="MenuLGS.php">Inicio</a> >
           <a href="SeguimientoSolicitudes.php"> B&uacute;squeda de un Expediente</a> >
             <a href="MenuTitulares.php?xIDExpe=<?php echo $xIDExpe; ?>"> Datos del Expediente</a>
             > Crear Finca
</div>
  <img src="Redmoon_img/imgDoc/DatosIdentificativosFinca.png" alt="datos finca" width="225" height="17" longdesc="datos de la finca"  style="position:absolute; top:75px; left:0px;"/>
  <form id="form1" name="form1" method="post" action="">
<div  id="PrimeraColumna">
       <br />
          <label class="Estilo5">Referencia Catastral</label>
            <input name="RegistroFinca" type="text" id="RegistroFinca" size="22" maxlength="20" />          
          <br />
          <br />
          <label class="Estilo5">Registro Finca*</label>
          <input name="NumeroFinca" type="text" id="NumeroFinca" size="25" maxlength="50" />
          
          <p>
            <label class="Estilo5">Titular de la Finca*
            <input name="TitularFinca" type="text" id="TitularFinca" size="40" maxlength="40" />
            </label>
          </p>
          <p>
            <label class="Estilo5">Municipio*
            <input name="Municipio" type="text" id="inPoblacion" size="25" maxlength="50" />
            </label>
          </p>          
          <p>
            <label class="Estilo5">Calle y N&uacute;mero*
            <input name="CalleFinca" type="text" id="inDireccion" onblur="showAddress(17);" size="40" maxlength="40" />
            </label>
          </p>
          <p>
            <label></label>
            <label class="Estilo5">Portal, Escalera, Planta, Puerta
            <input name="Piso" type="text" id="Piso" size="25" maxlength="25" />
            </label>
          </p>
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
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <img src="Redmoon_img/imgDoc/DatosRegistrales.png" alt="datos registro" width="284" height="17"  longdesc="datos de la inscripcion registral"  style="position:absolute; top:417px; left:0px;"/>
   
<div id="PieDatos">
			<br /><label class="Estilo5">
			<input type="checkbox" id="PedirNota" />
			Pedir Nota Simple Electr&oacute;nica?</label>
			<label class="Estilo5">
			<input type="checkbox" id="idPLUSVALIA" />
			Plusvalia?</label>
			<label class="Estilo5">
			<input type="checkbox" id="idCATASTRO" />
			Cambio de titularidad Catastro?</label>
            <br />
            <br />
            <label class="Estilo5">Secci&oacute;n</label>
            <input name="Tomo" type="text" id="Tomo" size="10" maxlength="10" />            
      <label class="Estilo5">N&deg; Finca*
            <input name="Libro" type="text" id="Libro" size="10" maxlength="10" />
      </label>
            <label class="Estilo5">Subfinca
            <input name="Seccion" type="text" id="Seccion" size="10" maxlength="10" />
            </label>
            <label class="Estilo5">Duplicado
            <input name="Folio" type="text" id="Folio" size="10" maxlength="10" />
            </label>
             <img src="Redmoon_img/imgDoc/aceptar.png" id="Grabar" value="Grabar" onclick="GrabarDatosFinca();" style="position:absolute; top:140px; left:48%;"/>
            
          
            <input type="hidden" name="xLatitud" id="inLatitud"/>
			<input type="hidden" name="xLongitud" id="inLongitud"/>
			<input type="hidden" name="xIDExpe" id="inIDExpe" />

</div>
          </form>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <div id="mapaGoogle" style="position:absolute; top:104px; left:456px; border:solid 1px; width:320px; height: 295px;"></div>
        <div id="Cargando">
		<img src="Redmoon_img/Cargando.gif" alt="Guardando" width="25" height="25" longdesc="Guardando datos" /> 
		<p>Guardando datos...</p>
		</div>
</div>

</body>
</html>
