<?php 

require_once('Redmoon_php/controlSesiones.inc.php');
require_once('Redmoon_php/pebi_cn.inc.php');
require_once('Redmoon_php/pebi_db.inc.php');

$conn = db_connect();

$sql = 'select idcuentas, NCUENTACOMPLETO from cuentas';
	$stid = oci_parse($conn, $sql);   
	
	$r = oci_execute($stid, OCI_DEFAULT);
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cuaderno de pago</title>

<link href="Redmoon_ccs/cargando.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cargando.js" type="text/javascript"></script>
<script src="Redmoon_js/pagina.js" type="text/javascript"></script>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>


<style type="text/css">
#Cargando {
	position:absolute;
	top:300px;
	text-align: center;
	font-weight:900;
	margin:15px 15px;
	border-bottom: solid 2px;
	border-right: solid 2px;
	border-top: solid 1px;
	border-left: solid 1px;
	padding:15px 25px;
	background-color: #FFFFCC;
	width: 20%;
	left: 300px;
	visibility:hidden;
}
</style>
<script> 

var StringSerializado="";
var xPag=1;
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
// Cojer el valor de la fila
///----------------------------------------->>Cambiar seg�n en que fase est� se ir� a una pantalla
function GetFila(xID)
{
	var oCelda=document.getElementById(xID).cells[0];
	var url_parametros="?xIDExpe="+oCelda.innerHTML;
	
	var oFASE=document.getElementById(xID).cells[4];
	var vFASE=oFASE.innerHTML;
	//alert(vFASE);
	
/*	if (vFASE=='PENDIENTE PAGO NOTARIA')
	{
		document.location='IntroduccionCosteNotaria.php'+url_parametros; 
	}
	
	if(vFASE=='PENDIENTE PAGO IMPUESTOS'){//42
		//document.location='ConfirmarPagoRetiradaEscrituras.php'+url_parametros;
		PutDataAsuntos('Redmoon_php/prueba_importe.php');
	}   

	if(vFASE=='INFORME COSTE IMPUESTOS'){//50
		document.location='IntroduccionCosteImpuesto.php'+url_parametros;
	} 

	if(vFASE=='PAGO IMPUESTOS'){//52
		document.location='EnvioJustificanteDePago.php'+url_parametros;
	}


	if(vFASE=='PRESENTACION ESCRITURAS'){// 60
		document.location='PresentacionRegistroEscritura.php'+url_parametros;
	}
	
	if(vFASE=='INFORME COSTE REGISTRO'){//61
		document.location='IntroduccionCosteRegistro.php'+url_parametros;
	}

	if(vFASE=='PAGO REGISTRO'){//63
		document.location='EnvioEscrituraOriginal.php'+url_parametros;
	}*/
	//alert(oCelda.innerHTML);
	

}


function LeeConsulta()
{

	var url_parametros='xPag='+xPag;
	VerGifEspera();
	//alert(url_parametros);
	PutDataAsuntos('Redmoon_php/serializado_PagosAColaborador.php',url_parametros);
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
	
	pageRequest.onreadystatechange=function() {	ProcRespAsuntos(pageRequest);};
	
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
function ProcRespAsuntos(pageRequest){

	
	if (pageRequest.readyState == 4)	
	{
		if (pageRequest.status==200)
		{

			OcultarGifEspera();
			//alert(pageRequest.responseText);
			if (pageRequest.responseText=='Ok')
				return;
			
			if (pageRequest.responseText=='Error')
			    alert(pageRequest.responseText);
			else
			{
			    StringSerializado=pageRequest.responseText;
			    deleteLastRow('oTabla');
			    AddRowTable();
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
  	j=1;
	for(x=0; x<=ArrayColumnas.length-2; x+=4)
	    {
				row = tbl.insertRow(tbl.rows.length);
				row.setAttribute('id', 'ofila'+j);
				row.setAttribute('onclick', 'GetFila(this.id);');
				row.setAttribute('onMouseOver', 'FilaActiva(this.id);');
				row.setAttribute('onMouseOut', 'FilaDesactivar(this.id);');
				j++;
				
			cellText =  row.insertCell(0);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.innerHTML=ArrayColumnas[0+x];
  			
  			cellText =  row.insertCell(1);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.innerHTML=ArrayColumnas[1+x];
  			
  			cellText =  row.insertCell(2);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.innerHTML=ArrayColumnas[2+x];
  			
  			cellText =  row.insertCell(3);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('align', 'right');
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.innerHTML=ArrayColumnas[3+x];

  
  						
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
// pulsaci�n de las teclas
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
		
}

//alert(tecla);
}





//
//Leer datos de Oracle via Ajax y PHP
//
//Hacer una llamada http post asincrona
//
//ejemplo: url_parametros='xIDExpe=94175';
//ejemplo: CallRemote('Redmoon_php/serializado_SeguiSolicitudes.php')
//
function CallRemote(url,dataToSend){
	
	var pageRequest = false;

	// Crear el objeto en funcion de si es Internet Explorer y resto de navegadores	
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
	
	//
	// al objeto pageRequest le asignamos una funci�n para procesar el evento onreadystatechange
	// esta se encarga de enviar la petici�n y leer la respuesta en un objeto javascript en el navegador
	//
	
	pageRequest.onreadystatechange=function() {	ProcRespuesta(pageRequest);};
	
	// enviamos la peticion
	if (dataToSend) {
		//alert(dataToSend);	
		//alert("post");	
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
function ProcRespuesta(pageRequest){

	
	if (pageRequest.readyState == 4)	
	{
		//alert(pageRequest.status);
		if (pageRequest.status==200)
		{
			
			// Solo descomentar para depuraci�n
			//alert(pageRequest.responseText);
			if (pageRequest.responseText=='Error')
			    alert(pageRequest.responseText);
			else
			{
				// cadena que contiene el resultado del servidor
				// el servidor envia mediante el comando echo su contenido a la variable pageRequest.responseText
				// ejemplo: echo 'Ok';
				cadena = pageRequest.responseText;
				//alert(cadena);
				//en cadena guarda el echo del php que se acaba de ejecutar
				if(cadena=='Cuaderno34 generado'){
					//no se sube a la nube hasta que no se haya terminado de generar el cuaderno
					location='Redmoon_php/subirNubeCuaderno34.php';
				}
				//desactiva el recudro de borrar o a�adir cuenta o cargando
				Salir();
				
				// hace lo que se quiera con esa cadena
				// aqui seguiria el codigo ...
		    }
		    	

		}
		else if (pageRequest.status == 404) 
			//object.innerHTML = 'Disculpas, la informacion no esta disponible en estos momentos.';
			alert('error 404');
		else 
			object.innerHTML = 'Ha ocurrido un problema.';
	}
	else return;
}






//
// Generar ecuaderno de pagos
//
function LlamarPago(){

	var Cuenta=document.getElementById('ListaAsuntos').value;

	Cuenta='xCuenta='+Cuenta;
	document.getElementById('Cargando').style.visibility='visible';
	
	
	url='Redmoon_php/CUADERNO34.php';
	CallRemote(url,Cuenta);

	//location="Redmoon_php/CUADERNO34.php?"+Cuenta;
	
}

//funcion para a�adir una cuenta de pago
function ActivarAniadirCuenta(){
	document.getElementById('InputCuentas').style.visibility='visible';
}

function ActivarBorrarCuenta(){
	document.getElementById('BorrarCuentas').style.visibility='visible';
}

//desactiva los recuadros de cargando borrar una cuenta o a�adir una cuenta
function Salir(){
	document.getElementById('InputCuentas').style.visibility='hidden';
	document.getElementById('BorrarCuentas').style.visibility='hidden';
	document.getElementById('Cargando').style.visibility='hidden';
}

//funcion para llamar asincronamente a un procedimiento
//para guardar un numero de cuenta nuevo de pago a colaboradores
function AniadirCuenta(){
	//alert("pasa a�adir");
	var CuentaCompleta=document.getElementById('numcuenta').value;
	CuentaCompleta="xNumCompleto="+CuentaCompleta;
	url='Redmoon_php/AniadirCuenta.php';
	CallRemote(url,CuentaCompleta);
	//location='Redmoon_php/AniadirCuenta.php?xNumCompleto='+CuentaCompleta;

}
//para rellenar la confirmacion de la cuenta que se ha seleccionado para borrar
function ValorCuenta(){

	var ValorCuenta=document.getElementById('ListaAsuntos').value;
	document.getElementById('bcuenta').value=ValorCuenta;
	
}
//funcion que llama al procedimiemto para borrar la cuenta
function BorrarCuenta(){
	var Cuenta=document.getElementById('ListaAsuntos').value;
	Cuenta="xCuenta="+Cuenta;
	url='Redmoon_php/borrarCuenta.php';
	CallRemote(url,Cuenta);
}

//Te lleva a una pagina donde se muestra una lista con los cuadernos 
//pendientes de envio a banca electronica
function CuadernosPendientes(){
	location='CuadernosPendientesConfirmarGE.php';
}

function Home(){
	location="MenuPrincipalHipotecas.html"
}

function GotoNext(){
	xPag+=9;
	LeeConsulta('Todo');
}

function GotoBack()
{
	xPag-=9;
	if (xPag <=1 )
		xPag=1;
	
	LeeConsulta('Todo');
}

function AyudaCuaderno(){

	AreaDiv = document.getElementById("AyudaCuaderno");
	AreaDiv.style.visibility='visible';
}
function SalirAyudaCuaderno(){
	AreaDiv = document.getElementById("AyudaCuaderno");
	AreaDiv.style.visibility='hidden';
}
function AyudaCuenta(){

	AreaDiv = document.getElementById("AyudaCuenta");
	AreaDiv.style.visibility='visible';
}
function SalirAyudaCuenta(){
	AreaDiv = document.getElementById("AyudaCuenta");
	AreaDiv.style.visibility='hidden';
}
function AyudaBorrar(){

	AreaDiv = document.getElementById("AyudaBorrar");
	AreaDiv.style.visibility='visible';
}
function SalirAyudaBorrar(){
	AreaDiv = document.getElementById("AyudaBorrar");
	AreaDiv.style.visibility='hidden';
}
function AyudaPendiente(){

	AreaDiv = document.getElementById("AyudaPendiente");
	AreaDiv.style.visibility='visible';
}
function SalirAyudaPendiente(){
	AreaDiv = document.getElementById("AyudaPendiente");
	AreaDiv.style.visibility='hidden';
}
</script>


<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />

<style type="text/css">

#imagen_logo{
position: absolute;
top:2px;
left:790px;
}
#textoCuaderno{
position: absolute;
top:130px;
left:50px;
font-size:8pt
}
#imagenCuaderno{
position: absolute;
top:90px;
left:514px;
}

#ListaCuentas{
position:absolute;
top:20px;
left:390px;
}
#AniadirCuentas{
position:absolute;
top:30px;
left:670px;
font-size:8pt;
width: 24px;
height: 24px;
}
#TextoA�adir{
position:absolute;
top:97px;
left:399px;
font-size:8pt
}
#TextoBanca{
position:absolute;
top:97px;
left:600px;
font-size:8pt
}
#TextoBorrar{
position:absolute;
top:97px;
left:500px;
font-size:8pt
}

#BotonBorrarCuentas{
position:absolute;
top:30px;
left:700px;
width: 24px;
height: 24px;
}

#BotonCuadernosPend{
position:absolute;
top:90px;
left:660px;
}
#InputCuentas{
	position:absolute;
	top:100px;
	text-align: center;
	font-weight:900;
	border:solid 8px;
	border-color:#ebebeb;
	
	margin:15px 15px;
	padding:20px 40px;
	background-color: #FFFFCC;
	width: 40%;
	left: 180px;
	visibility:hidden;

}
#BorrarCuentas{
	position:absolute;
	top:100px;
	text-align: center;
	font-weight:900;
	border:solid 8px;
	border-color:#ebebeb;
	
	margin:15px 15px;
	padding:20px 40px;
	background-color: #FFFFCC;
	width: 40%;
	left: 180px;
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

#TextoAyuda{
	position:absolute;
	top:80px;
	left:20px;
	margin-right:20px;

}
</style>
</head>

<body  onload="HacerBusqueda();">
	<?php require('cabecera.php'); ?>

<div id="documento">
   
     <div id="rastro"><a href="MenuLGS.php">Inicio</a>
        > Pagos a Colaboradores
    </div>
    <div id="ayuda_btn">
		<!--<img src="Redmoon_img/imgDoc/ayuda.png" alt="Ayuda" title="Ayuda" onclick="AbrirAyuda('Gestoria_documentacion/gestion_cuaderno_pago_colaboradores.html')" />-->
	</div>

<div id="btnPaginaB">
<div id="btnNavegaAtras" onclick="GotoBack()" title="Atr�s"><span>Atr�s</span></div>
<div id="btnNavegaSig" onclick="GotoNext()" title="Atr�s"><span>Siguiente</span></div>
</div>


<div id="imagenCuaderno">
 <img src="Redmoon_img/imgDoc/pagoOFF.png" alt="Generar cuaderno de Pago" title="Generar Cuaderno de Pago" onclick="LlamarPago()" /></div>
 
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

<div id="ListaCuentas">
<form id="form1" name="form1" method="post" action="valores.php">
<p class="Estilo1">Cuenta de Pago
 
    <select name="ListaAsuntos" size="1" id="ListaAsuntos" onchange="ValorCuenta()" >
    <?php 
    
    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    	//$codificada = strtr($row['DESCRIPCION'], $tabla);
		print '<option value="'.$row['NCUENTACOMPLETO'].'">'.$row['NCUENTACOMPLETO'].'</option>';
	}
	?>
  </select></p>
  </form>
</div>

<div id="AniadirCuentas">
    <img src="Redmoon_img/imgDoc/mas.png" alt="A&ntilde;adir Cuenta de Pago" title="A&ntilde;adir Cuenta de Pago" onclick="ActivarAniadirCuenta()"  />
</div>


<div id="BotonBorrarCuentas">
<img src="Redmoon_img/imgDoc/menos.png" alt="Eliminar Cuenta de Pago" title="Eliminar Cuenta de Pago"  onclick="ActivarBorrarCuenta()"  />
</div>


<div id="BotonCuadernosPend">
<img src="Redmoon_img/imgDoc/pendientesOFF.png" alt="Cuadernos de Pago Pendientes de Envio" title="Cuadernos de Pago Pendientes de Envio"  onclick="CuadernosPendientes()"  />
</div>



<div id="VentanaTablaB">
<table width="750" border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oFila0" style="color:#3C4963; cursor:default">
    <td width="10%"><strong>Expediente</strong></td>
    <td width="12%"><strong>NIF</strong></td>
    <td width="58%"><strong>Nombre</strong></td>
    <td width="20%"><strong>Importe</strong></td>
    
  </tr>
</table>
</div>


<div id="Cargando">
<img src="Redmoon_img/Cargando.gif" alt="Guardando" width="25" height="25" longdesc="Guardando datos" /> 
<p>Guardando datos...</p>
</div>

<div id="InputCuentas">
<p align="left">
<img src="Redmoon_img/borrar1.png" alt="Salir"  onclick="Salir()" />

</p>
<p class="Estilo1">Introduzca el nuevo n&uacute;mero de cuenta:</p>
<input id="numcuenta" name="numcuenta" type="text" maxlength="20" size="20"  />

<img src="Redmoon_img/aceptar2.png" alt="aceptar" align="middle"  onclick="AniadirCuenta()" />
</div>

<div id="BorrarCuentas">
<p align="left">
<img src="Redmoon_img/borrar1.png" alt="Salir"  onclick="Salir()" />

</p>
<p class="Estilo1">La cuenta que desea borrar es:</p>
<input id="bcuenta" name="bcuenta" type="text" maxlength="20" size="20"  />

<img src="Redmoon_img/aceptar2.png" alt="aceptar" align="middle"  onclick="BorrarCuenta()" />
</div>
</div> 
</body>
</html>
