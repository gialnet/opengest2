<?php
require_once('Redmoon_php/controlSesiones.inc.php');
require_once('Redmoon_php/pebi_cn.inc.php');
require_once('Redmoon_php/pebi_db.inc.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Clientes Preferentes</title>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
	// General options
	mode : "textareas",
	theme : "advanced",
	plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",
	// Theme options
	theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : false,
	 

	// Example content CSS (should be your site CSS)
	content_css : "css/example.css",

	// Drop lists for link/image/media/template dialogs
	template_external_list_url : "js/template_list.js",
	external_link_list_url : "js/link_list.js",
	external_image_list_url : "js/image_list.js",
	media_external_list_url : "js/media_list.js",
	 
	// Replace values for the template plugin
	template_replace_values : {
	username : "Some User",
	staffid : "991234"
	}
	});
</script>

<script> 

var StringSerializado="";
var xPag=1;
var nFila=0;

function HacerBusqueda()
{
	LeeConsulta('Todo');
}

//
//
//
function FilaActiva(xID)
{
	var elemento=document.getElementById(xID);
	
		elemento.style.backgroundColor="#ECF3F5";
}

//
//Ir al formulario consulta del expediente
//
function VerExpe(xFila){
	
	var idFila="ofila"+xFila;
	var oCelda=document.getElementById(idFila).cells[0];
	var url_parametros="xIDExpe="+oCelda.innerHTML;
	
	//location="MenuTitulares.php?"+url_parametros;
}

//
// Aadir un expediente a un cliente preferencial
//
function ExpedientePrefe(xFila){

	var idFila="ofila"+xFila;
	var oCelda=document.getElementById(idFila).cells[0];
	var url_parametros="xNIF="+oCelda.innerHTML;

	if (confirm('Confirma crear un nuevo Expediente?'))
	{
	   PutDataAsuntos('Redmoon_php/AltaExpeHipoPreferencial.php', url_parametros);
	}
}

//
// Mostrar el panel de Enviar un mensaje de correo
//
function sendMail(xFila){
	
	// cells[2] es la direcciï¿½n de email
	var idFila="ofila"+xFila;
	var oCelda=document.getElementById(idFila).cells[2];
	var mEmail=oCelda.innerHTML;
	var xDestino=document.getElementById('IDestinatario');
	
	// poner el NIF de la tupla seleccionada para su envio en form
	document.getElementById('xMail').value=mEmail;
	
	xDestino.innerHTML="Redactar correo para: "+mEmail;
	// nFila es una variable global
	nFila=xFila;
	
	document.getElementById('enviarMensaje').style.visibility='visible';
	
}

//
// Enviar el correo electrï¿½nico, no se estï¿½ utilizando por ahora.!!!!!!!!!!!!!!!
//
function FEnviarMensaje()
{
	var mAsunto=document.getElementById('IDAsunto').value;
	var mMensaje=document.getElementById('content').value;

	// nFila es una variable global
	// cells[2] es la direcciï¿½n de email
	var idFila="ofila"+nFila;
	var oCelda=document.getElementById(idFila).cells[2];
	var mEmail=oCelda.innerHTML;
	
	location="correoPHP/email_AltaExpeClientesPreferentes.php"+
	"?xAsunto="+mAsunto+"&xMensaje="+mMensaje+"&xMail="+mEmail;
}
//
//
//
function FilaDesactivar(xID)
{
	var elemento=document.getElementById(xID);
	
		elemento.style.backgroundColor ="#FFFFFF";
}

//
// Llamar a la consulta adecuada
//
function LeeConsulta(Opcion)
{
	
	var url_parametros='xPag='+xPag;

	
	//alert(url_parametros);
	PutDataAsuntos('Redmoon_php/serializado_ClientesPreferentes.php', url_parametros);
}
//
//Leer datos de Oracle via Ajax y PHP
//
function PutDataAsuntos(url,dataToSend){
	
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
	
	pageRequest.onreadystatechange=function() {	ProcRespAsuntos(pageRequest, url);};
	
	if (dataToSend) {		
		pageRequest.open('POST',url,true);
 	pageRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		pageRequest.send(dataToSend);
	}
	else {
		pageRequest.open('GET',url,true);
		pageRequest.send(null);
	}
}


//
//Recibe la respuesta del servidor
//
function ProcRespAsuntos(pageRequest, url){

	
	if (pageRequest.readyState == 4)	
	{
		if (pageRequest.status==200)
		{
			
			//alert(pageRequest.responseText);
			if (pageRequest.responseText=='Ok')
				return;
			
			if (pageRequest.responseText=='Error')
			    alert(pageRequest.responseText);
			else
			{
				// mostar la lista de clientes preferenciales
				if (url=='Redmoon_php/serializado_ClientesPreferentes.php')
				{
			    	StringSerializado=pageRequest.responseText;
			    	deleteLastRow('oTabla');
			    	AddRowTable();
				}

				// aadir expediente
				if (url=='Redmoon_php/AltaExpeHipoPreferencial.php')
				{
					location='ActosExpedienteHipotecario.php?xIDExpe='+pageRequest.responseText;
				}
			
				
		    }
		    	

		}
	}
	else return;
}
//
//
//
function AddRowTable()
{
	var ArrayColumnas=StringSerializado.split('|');
	var tbl = document.getElementById('oTabla');
  	//var row = tbl.insertRow(tbl.rows.length);
  
  	//alert(StringSerializado);
  	//alert(ArrayColumnas.length);
  	j=0;
	for(x=0; x<=ArrayColumnas.length-2; x+=4)
	    {
		j++;
				row = tbl.insertRow(tbl.rows.length);
				row.setAttribute('id', 'ofila'+j);
				//row.setAttribute('onclick', 'GetFila(this.id);');
				row.setAttribute('onMouseOver', 'FilaActiva(this.id);');
				row.setAttribute('onMouseOut', 'FilaDesactivar(this.id);');
				
			// nif	
			cellText =  row.insertCell(0);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.innerHTML=ArrayColumnas[0+x];
  			
  			// razon social
  			cellText =  row.insertCell(1);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.innerHTML=ArrayColumnas[1+x];

  			// email
  			cellText =  row.insertCell(2);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.innerHTML=ArrayColumnas[2+x];

  			// telefono
  			cellText =  row.insertCell(3);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.innerHTML=ArrayColumnas[3+x];
 			
  			// Crear un nuevo expediente para cliente preferencial
  			cellText =  row.insertCell(4);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/ok.png" alt="Crear un nuevo Expediente" title="Crear un nuevo Expediente" onclick="ExpedientePrefe('+j+')" id="oFase'+j+'">';

  			// Por ahora no hace nada
  			cellText =  row.insertCell(5);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/telefono.png" alt="Realizar una llamada" title="Realizar una llamada" onclick="VerExpe('+j+')" id="oFase'+j+'">';

  			// ENVIAR CORREO
  			cellText =  row.insertCell(6);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/mail.png" alt="Enviar un eMail" title="Enviar un eMail" onclick="sendMail('+j+')" id="oFase'+j+'">';
  						
		}

}
//
// tblName
//
function deleteLastRow(tblName)
{
  var tbl = document.getElementById(tblName);
  //if (tbl.rows.length > 1) tbl.deleteRow(tbl.rows.length - 1);
  for(x=(tbl.rows.length-1); x>0; x--)
      tbl.deleteRow(x);
}
//
// pulsacin de las teclas, cuando se pulsa return se graba el valor
//
function detectar_tecla(e, opcion){

if (window.event)
	tecla=e.keyCode;
else
	tecla=e.which;

if(tecla==13)
{
	if (window.event)
	{
		e.returnValue=false;
		window.event.cancelBubble = true;
	}
	else
	{
		e.preventDefault();
		e.stopPropagation();
	}
	
	CallOtrasProvisiones();
	LeeConsulta(opcion);
		
}

//alert(tecla);
}

function GotoNext(){
	xPag+=14;
	LeeConsulta('Todo');
}

function GotoBack()
{
	xPag-=14;
	if (xPag <=1 )
		xPag=1;
	
	LeeConsulta('Todo');
}


//
//Volver a la vista anterior
//
function GotoHome()
{
	location="MenuPrincipalHipotecas.html";
}


//funcion para cerrar la ventana de envio de mensajes
function SalirMensaje(){
	document.getElementById('enviarMensaje').style.visibility='hidden';	
}

function AyudaTlf(){

	AreaDiv = document.getElementById("AyudaTlf");
	AreaDiv.style.visibility='visible';
}
function SalirAyudaTlf(){
	AreaDiv = document.getElementById("AyudaTlf");
	AreaDiv.style.visibility='hidden';
}

function AyudaAceptar(){

	AreaDiv = document.getElementById("ayudaAceptar");
	AreaDiv.style.visibility='visible';
}
function SalirAyudaAceptar(){
	AreaDiv = document.getElementById("ayudaAceptar");
	AreaDiv.style.visibility='hidden';
}
function AyudaMail(j){
	AreaDiv = document.getElementById("ayudaMail");
	AreaDiv.style.visibility='visible';
	if(j==1)
		posicion=1;
	else{
	var posicion=j*17;
	
	}
	document.getElementById("ayudaMail").style.top=posicion;
	
	
}
function SalirAyudaMail(){
	AreaDiv = document.getElementById("ayudaMail");
	AreaDiv.style.visibility='hidden';
}
function position(event){
	var x = event.clientX;
	var y = event.clientY;
	AreaDiv = document.getElementById("ayudaMail");
	AreaDiv.style.top=y;
	AreaDiv.style.left=x;
}

</script>


<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />

<style type="text/css">

#ayudaAceptar{
position:absolute;
	top:0px;
	left:400px;
	visibility:hidden;
	z-index:1;
}
#AyudaTlf{

	position:absolute;
	top:0px;
	left:450px;
	visibility:hidden;
	z-index:1;
}
#ayudaMail{
position:absolute;
	top:0px;
	left:500px;
	visibility:hidden;
	z-index:1;
}
#TextoAyuda{
	position:absolute;
	top:35px;
	left:20px;
	margin-right:20px;

}
#enviarMensaje{
position: absolute;
top:15px;
left:1px;
width:700px;
height:450px;
	border:solid 8px;
	border-color:#ebebeb;
	
	margin:15px 15px;
	padding:20px 40px;
background-color: #FFFFCC;
visibility:hidden;
}
#imagen_logo{
position: absolute;
top:25px;
left:790px;
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
</head>
	
<body  onload="HacerBusqueda();">

<?php require('cabecera.php'); ?>

<div id="documento">
     <div id="rastro"><a href="MenuLGS.php">Inicio</a> >
      Clientes Preferentes

    </div>
    <div id="ayuda_btn">
		<img src="Redmoon_img/imgDoc/ayuda.png" alt="Ayuda" title="Ayuda" onclick="AbrirAyuda('Gestoria_documentacion/expedientes_clientes_preferentes.html')" />
	</div>




<div id="btnPagina">
    <div id="btnNavegaAtras" onclick="GotoBack()" title="P&aacute;gina Atr&aacute;s"><span>Atrás</span></div>
<div id="btnNavegaSig" onclick="GotoNext()" title="P&aacute;gina Siguiente"><span>Siguiente</span></div>
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
<div id="VentanaTabla">
<table width="780" border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oFila0" style="color:#3C4963; cursor:default">
    <td width="10%"><strong>NIF</strong></td>
    <td width="40%"><strong>Razon Social</strong></td>
    <td width="40%"><strong>e-mail</strong></td>
    <td width="10%"><strong>Telefono</strong></td>
  </tr>
</table>
<input type="hidden" name="xIDExpe" id="inIDExpe" />
</div>

<div id="enviarMensaje">

<img src="<?php echo IMAGENES;?>/borrar1.png" alt="Salir" align="middle"  onclick="SalirMensaje();"  />
<label id="IDestinatario">Redactar correo</label> 
<form method="post" action="correoPHP/email_AltaExpeClientesPreferentes.php">
<label class="Estilo5">Asunto<input type="text" size="45" name="IDAsunto" id="IDAsunto" /></label>
<br />
<textarea name="content" style="width:100%" rows="20" id="content">
</textarea>
<input type="hidden" name="xMail" id="xMail" />
<!-- 
<button type="submit">Enviar</button>
<img src="<?php echo IMAGENES;?>/aceptar2.png" alt="Enviar"  style="position:absolute; left:45%; top:400px;"  onclick="FEnviarMensaje();"  />
-->
</form>

</div>

</div>
</body>
</html>