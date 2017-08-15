<?php 
<<<<<<< .mine

require('../Redmoon_php/controlSesiones.inc.php'); 
require('../Redmoon_php/pebi_cn.inc.php');
require('../Redmoon_php/pebi_db.inc.php'); 

=======
require_once('../Redmoon_php/controlSesiones.inc.php');
require_once('../Redmoon_php/pebi_cn.inc.php');
require_once('../Redmoon_php/pebi_db.inc.php');

>>>>>>> .r60
$conn = db_connect();

$sql = 'select idcuentas, NCUENTACOMPLETO from cuentas';
	$stid = oci_parse($conn, $sql);   
	
	$r = oci_execute($stid, OCI_DEFAULT);
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Notas Simples</title>
<link href="../Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="../Redmoon_js/cabecera.js" type="text/javascript"></script>

<script> 

var StringSerializado="";
var xPag=1;

function HacerBusqueda()
{
	//LeeConsulta('Todo');
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
	var url_parametros="xIDColaborador="+oCelda.innerHTML;
	
	location="Colaboradores.php?"+url_parametros;
}


//la nota simple se maraca como recibida
function Recibida(xFila){
	
	var idFila="ofila"+xFila;
	var oCelda=document.getElementById(idFila).cells[0];
	var url_parametros="xID="+oCelda.innerHTML;

	   PutDataAsuntos('../Redmoon_php/ORA_NSrecibida.php', url_parametros);
}

//la nota simple ya se ha recibido y se ha enviaso al cliente y hemos acabado el trabajo
function RecibidaAceptada(xFila){
	
	var idFila="ofila"+xFila;
	var oCelda=document.getElementById(idFila).cells[0];
	var url_parametros="xID="+oCelda.innerHTML;

	   PutDataAsuntos('../Redmoon_php/ORA_NSaceptada.php', url_parametros);
}
//la nota simple se marca como denegada
function nsDenegada(xFila){
	
	var idFila="ofila"+xFila;
	var oCelda=document.getElementById(idFila).cells[0];
	var url_parametros="xID="+oCelda.innerHTML;
	alert(url_parametros);
	   PutDataAsuntos('../Redmoon_php/ORA_NSdenegada.php', url_parametros);
}

//Cuando marcamos en la pantalla de pendientes las notas simples enviadas
// Nota Simple enviada
//
function ExpedienteRevisado(xFila){

	var idFila="ofila"+xFila;
	var oCelda=document.getElementById(idFila).cells[0];
	var url_parametros="xID="+oCelda.innerHTML;

	   PutDataAsuntos('../Redmoon_php/ORA_NSenviada.php', url_parametros);
	   

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
	
	var url_parametros='xPag='+xPag+'&xPENDIENTES=PENDIENTES';

	
	//alert(url_parametros);
	PutDataAsuntos('../Redmoon_php/serializado_NotasSimples.php', url_parametros);
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
			// despues de grabar dejar las cosas como estaban		
			//DesctivaInterfazGrabando();		
			
			//alert(pageRequest.responseText);
			if (pageRequest.responseText=='Error mysql')
				alert(pageRequest.responseText);
			if (pageRequest.responseText=='Ok')
				return;
			if (pageRequest.responseText=='enviada' || pageRequest.responseText=='ok'){
				var url_parametros="xENVIADOS="+"ENVIADOS";				
				PutDataAsuntos('../Redmoon_php/serializado_NotasSimples.php', url_parametros);
			}
			if (pageRequest.responseText=='ok'){
				var url_parametros="xPENDIENTES=1";				
				PutDataAsuntos('../Redmoon_php/serializado_NotasSimples.php', url_parametros);
			}
			if (pageRequest.responseText=='Error')
			    alert(pageRequest.responseText);
		    if(pageRequest.responseText=='error1')
		    	alert(pageRequest.responseText);
			else
			{
				//alert(pageRequest.responseText);
			    StringSerializado=pageRequest.responseText;
			    deleteLastRow('oTabla');
			    AddRowTable();
		    }
		    	
			// Activo el Menu de Titulares
			//ActivaMenuTitulares();

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
	for(x=0; x<=ArrayColumnas.length-2; x+=10)
	    {
		j++;
				row = tbl.insertRow(tbl.rows.length);
				row.setAttribute('id', 'ofila'+j);
				//row.setAttribute('onclick', 'GetFila(this.id);');
				row.setAttribute('onMouseOver', 'FilaActiva(this.id);');
				row.setAttribute('onMouseOut', 'FilaDesactivar(this.id);');
				
				
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
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.setAttribute('align', 'center');
  			cellText.innerHTML=ArrayColumnas[3+x];

  			cellText =  row.insertCell(4);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.setAttribute('align', 'center');
  			cellText.innerHTML=ArrayColumnas[4+x];

  			
  			cellText =  row.insertCell(5);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.setAttribute('align', 'center');
  			cellText.innerHTML=ArrayColumnas[5+x];

  			cellText =  row.insertCell(6);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.setAttribute('align', 'center');
  			cellText.innerHTML=ArrayColumnas[6+x];

  			cellText =  row.insertCell(7);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.setAttribute('align', 'center');
  			cellText.innerHTML=ArrayColumnas[7+x];

  			cellText =  row.insertCell(8);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.setAttribute('align', 'center');
  			cellText.innerHTML=ArrayColumnas[8+x];

  			cellText =  row.insertCell(9);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.setAttribute('align', 'center');
  			cellText.innerHTML=ArrayColumnas[9+x];


  		
  			//pantalla de peticiones
  			if(document.getElementById('pantalla').value=="pe"){
  				// NOTA SIMPLE ENVIADA
  				cellText =  row.insertCell(10);
  				textNode = document.createTextNode(tbl.rows.length - 1);
  				cellText.appendChild(textNode);
  				cellText.innerHTML='<img src="../redmoon_img/ns_enviada.png"  onclick="ExpedienteRevisado('+j+')"  id="oFase'+j+'">';  			
  			}
  			//pantalla de notas simples enviadas
  			if(document.getElementById('pantalla').value=="en"){
  				// NOTA SIMPLE RECIBIDA
  				cellText =  row.insertCell(10);
  				textNode = document.createTextNode(tbl.rows.length - 1);
  				cellText.appendChild(textNode);
  				cellText.innerHTML='<img src="../redmoon_img/aceptar2.png" onclick="Recibida('+j+')"  id="oFase'+j+'">';

  				//NOTA SIMPLE DENEGADA
  	  			cellText =  row.insertCell(11);
  	  			textNode = document.createTextNode(tbl.rows.length - 1);
  	  			cellText.appendChild(textNode);
  	  			cellText.innerHTML='<img src="../redmoon_img/denegada.png" onclick="nsDenegada('+j+')"  id="oFase'+j+'">';
  			}
  			//pantalla de notas simples recibidas
  			//para que no aparezca mas en la pantalla
  			if(document.getElementById('pantalla').value=="re"){
  				// NOTA SIM
  				cellText =  row.insertCell(10);
  				textNode = document.createTextNode(tbl.rows.length - 1);
  				cellText.appendChild(textNode);
  				cellText.innerHTML='<img src="../redmoon_img/aceptar2.png" onclick="RecibidaAceptada('+j+')"  id="oFase'+j+'">';

  			}
  			
  						
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
// pulsaci�n de las teclas, cuando se pulsa return se graba el valor
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
	
	LeeConsulta(opcion);
		
}

//alert(tecla);
}

//
//Volver a la vista anterior
//
function GotoHome()
{
	location="MenuPrincipalHipotecas.html";
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

function AniadirColaborador(){
	location="AniadirColaborador.php";
}

///Menus de ayuda para los botones de las tabla
//
//ayuda para llamar al colaborador
function AyudaPDF(){

	AreaDiv = document.getElementById("ayudaPDF");
	AreaDiv.style.visibility='visible';
}
function SalirAyudaPDF(){
	AreaDiv = document.getElementById("ayudaPDF");
	AreaDiv.style.visibility='hidden';
}

function AyudaCuaderno(){

	AreaDiv = document.getElementById("ayudaCuaderno");
	AreaDiv.style.visibility='visible';
}
function SalirAyudaCuaderno(){
	AreaDiv = document.getElementById("ayudaCuaderno");
	AreaDiv.style.visibility='hidden';
}
function AyudaTlf(){

	AreaDiv = document.getElementById("AyudaTlf");
	AreaDiv.style.visibility='visible';
}
function SalirAyudaTlf(){
	AreaDiv = document.getElementById("AyudaTlf");
	AreaDiv.style.visibility='hidden';
}

function AyudaVer(){

	AreaDiv = document.getElementById("ayudaVer");
	AreaDiv.style.visibility='visible';
}
function SalirAyudaVer(){
	AreaDiv = document.getElementById("ayudaVer");
	AreaDiv.style.visibility='hidden';
}
function AyudaMail(){

	AreaDiv = document.getElementById("ayudaMail");
	AreaDiv.style.visibility='visible';
}
function SalirAyudaMail(){
	AreaDiv = document.getElementById("ayudaMail");
	AreaDiv.style.visibility='hidden';
}


function lbusca(opcion){
	
	//alert(opcion);

	
	
	if (opcion=='lbpendientes')
	{
		document.getElementById('pantalla').value="pe";
		//activa el boton generar el pdf con todas las notas simples pendientes de envio
		document.getElementById('listado').style.visibility='visible';
		document.getElementById('cuaderno').style.visibility='hidden';
		var url_parametros='xPENDIENTES='+'PENDIENTES'+'&xPag='+xPag;
		document.getElementById('ListaCuentas').style.visibility='hidden';
		document.getElementById('AniadirCuentas').style.visibility='hidden';
		document.getElementById('BotonBorrarCuentas').style.visibility='hidden';
		document.getElementById('pendientes').style.visibility='hidden';
		document.getElementById('refrescar').style.visibility='visible';
		
		
		//alert(url_parametros);
		  
		   
		
	}
	
	if (opcion=='lbenviadas')
	{
		document.getElementById('pantalla').value="en";
		var url_parametros="xENVIADOS="+"ENVIADOS";
		
		document.getElementById('listado').style.visibility='hidden';
		document.getElementById('cuaderno').style.visibility='hidden';
		document.getElementById('ListaCuentas').style.visibility='hidden';
		document.getElementById('AniadirCuentas').style.visibility='hidden';
		document.getElementById('BotonBorrarCuentas').style.visibility='hidden';
		document.getElementById('pendientes').style.visibility='hidden';
		document.getElementById('refrescar').style.visibility='hidden';
	}
	
	if (opcion=='lbrecibidas')
	{
		document.getElementById('pantalla').value="re";
		var url_parametros="xRECIBIDOS="+"RECIBIDOS";
		document.getElementById('listado').style.visibility='hidden';
		document.getElementById('cuaderno').style.visibility='hidden';
		document.getElementById('ListaCuentas').style.visibility='hidden';
		document.getElementById('AniadirCuentas').style.visibility='hidden';
		document.getElementById('BotonBorrarCuentas').style.visibility='hidden';
		document.getElementById('pendientes').style.visibility='hidden';
		document.getElementById('refrescar').style.visibility='hidden';
		   
	}
	
	if (opcion=='lbdenegadas')
	{
		
		document.getElementById('pantalla').value="de";
		//activa el boton para crear el cuaderno de pago
		document.getElementById('cuaderno').style.visibility='visible';
		document.getElementById('listado').style.visibility='hidden';
		document.getElementById('ListaCuentas').style.visibility='visible';
		document.getElementById('AniadirCuentas').style.visibility='visible';
		document.getElementById('BotonBorrarCuentas').style.visibility='visible';
		var url_parametros="xDENEGADOS="+"DENEGADOS";
		document.getElementById('pendientes').style.visibility='visible';
		document.getElementById('refrescar').style.visibility='hidden';
		//alert(url_parametros);
		   
		   
	}	
	 PutDataAsuntos('../Redmoon_php/serializado_NotasSimples.php', url_parametros);		
	// alert("fin");
}

function apagaPaneles(){
	document.getElementById('BuscaNIF').style.visibility='hidden';
	document.getElementById('BuscaNombre').style.visibility='hidden';
	document.getElementById('BuscaExpe').style.visibility='hidden';
	document.getElementById('BuscaFecha').style.visibility='hidden';
	}

function CrearPDF(){
	AreaDiv = document.getElementById("ayudaPDF");
	AreaDiv.style.visibility='hidden';
	location="ListadosNSPendientes.php";
}


function Refrescar(){
	//alert('lee mysql');
	//location="../Redmoon_php/lee_notasSimplesMYSQL.php";
	PutDataAsuntos('../Redmoon_php/lee_notasSimplesMYSQL.php');
}


function GenerarCuaderno(){

	var Cuenta=document.getElementById('ListaAsuntos').value;

	Cuenta='xCuenta='+Cuenta;
	//document.getElementById('Cargando').style.visibility='visible';
	alert(Cuenta);
	PutDataAsuntos('../Redmoon_php/CUADERNOnotasSimples.php', Cuenta);
	//location="../Redmoon_php/CUADERNOnotasSimples.php?xCuenta="+Cuenta;
}
function PendientesEnvio(){
	location="TablaCuadernos.php";
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
//para guardar un numero de cuenta nuevo
function AniadirCuenta(){
	//alert("pasa a�adir");
	var CuentaCompleta=document.getElementById('numcuenta').value;
	CuentaCompleta="xNumCompleto="+CuentaCompleta;
	//url='../Redmoon_php/AniadirCuenta.php';
	
	PutDataAsuntos('../Redmoon_php/AniadirCuenta.php', CuentaCompleta);
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
	PutDataAsuntos('../Redmoon_php/borrarCuenta.php', Cuenta);
}
function Salir(){
	document.getElementById('InputCuentas').style.visibility='hidden';
	document.getElementById('BorrarCuentas').style.visibility='hidden';
	//document.getElementById('Cargando').style.visibility='hidden';
}
</script>


<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />

<style type="text/css">
#ayudaPDF{
position:absolute;
	top:130px;
	left:420px;
	visibility:hidden;
	z-index:1;
}
#ayudaCuaderno{
position:absolute;
	top:130px;
	left:420px;
	visibility:hidden;
	z-index:1;
}
#ayudaVer{
position:absolute;
	top:1px;
	left:418px;
	visibility:hidden;
	z-index:1;
}
#AyudaTlf{

	position:absolute;
	top:1px;
	left:367px;
	visibility:hidden;
	z-index:1;
}
#ayudaMail{
position:absolute;
	top:1px;
	left:468px;
	visibility:hidden;
	z-index:1;
}
#TextoAyuda{
	position:absolute;
	top:35px;
	left:20px;
	margin-right:20px;

}
#TextoAyuda2{
	position:absolute;
	top:100px;
	left:20px;
	margin-right:20px;

}

#listado{
position: absolute;
top:20px;
left:710px;
visibility:hidden;
}
#refrescar{
position: absolute;
top:20px;
left:670px;
visibility:hidden;
}
#cuaderno{
position: absolute;
top:20px;
left:710px;
visibility:hidden;
}
#pendientes{
position: absolute;
top:20px;
left:670px;
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

#buscar{
position: absolute;
top:40px;
left:10px;
}
 #busqueda{
 	position:absolute;
	top:60px;
 	left:20px;
 }
 
 #ListaCuentas{
position:absolute;
top:100px;
left:200px;
visibility:hidden;
}
#AniadirCuentas{
position:absolute;
top:110px;
left:480px;
font-size:8pt;
visibility:hidden;
}

#BotonBorrarCuentas{
position:absolute;
top:110px;
left:510px;
visibility:hidden;
}

#InputCuentas{
	position:absolute;
	top:100px;
	text-align: center;
	font-weight:900;
		margin:15px 15px;
	padding:15px 25px;	
	border-bottom: solid 2px;
	border-right: solid 2px;
	border-top: solid 1px;
	border-left: solid 1px;
	border-color:#ebebeb;
	background-color: #FFFFCC;
	width: 40%;
	left: 180px;
	visibility:hidden;
	z-index:2;

}
#BorrarCuentas{
	position:absolute;
	top:200px;
	text-align: center;
	font-weight:900;
	margin:15px 15px;
	border-bottom: solid 2px;
	border-right: solid 2px;
	border-top: solid 1px;
	border-left: solid 1px;
	padding:15px 25px;
	background-color: #FFFFCC;
	width: 40%;
	left: 250px;
	visibility:hidden;

}

</style>
</head>

<body >
<?php require('cabecera.php'); ?>

<div id="documento">
      <div id="rastro"><a href="../MenuLGS.php">Inicio</a> >
          Gesti&oacute;n de Notas Simples

    </div>
<div id="ayuda_btn">
		<img src="../Redmoon_img/imgDoc/ayuda.png" alt="Ayuda" title="Ayuda" onclick="AbrirAyuda('../Gestoria_documentacion/gestion_notas_simples.html')" />
	</div>
<div id="ListaCuentas">
<form id="form1" name="form1" method="post" action="valores.php">
    
   <p class="Estilo1">Cuenta de Pago <select name="ListaAsuntos" size="1" id="ListaAsuntos" onchange="ValorCuenta()" >
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
    <img src="../Redmoon_img/imgDoc/mas.png" alt="A&ntilde;adir Cuenta de Pago" title="A&ntilde;adir Cuenta de Pago"  onclick="ActivarAniadirCuenta()" />
</div>

<div id="pendientes">
    <img src="../Redmoon_img/imgDoc/cuadernoPendienteEnvio.png" alt="Cuadernos de Pago Pendientes de Env&iacute;o" title="Cuadernos de Pago Pendientes de Env&iacute;o"  onclick="PendientesEnvio()" />
</div>


<div id="BotonBorrarCuentas">
<img src="../Redmoon_img/imgDoc/menos.png" alt="Eliminar Cuenta de Pago" title="Eliminar Cuenta de Pago"  onclick="ActivarBorrarCuenta()" />
</div>


<div id="InputCuentas">
<p align="left">
<img src="../Redmoon_img/borrar1.png" alt="Salir" onclick="Salir()"/>
</p>
<p class="Estilo1">Introduzca el nuevo n&uacute;mero de cuenta:</p>
<input id="numcuenta" name="numcuenta" type="text" maxlength="20" size="20"  />

<input  name="button" type="image" id="Grabar" value="Grabar" onclick="AniadirCuenta()"  src="../Redmoon_img/aceptar2.png"/>
</div>

<div id="BorrarCuentas">
<p align="left">
<img src="Redmoon_img/borrar1.png" alt="Salir"  onclick="Salir()" />

</p>
<p>La cuenta que desea borrar es:</p>
<input id="bcuenta" name="bcuenta" type="text" maxlength="20" size="20"  />

<input  name="button" type="image" id="Grabar" value="Grabar" onclick="BorrarCuenta()"  src="../Redmoon_img/aceptar2.png"/>

</div>


<div id="busqueda">
  <span class="Estilo1">Notas Simples:</span> 
   <label class="Estilo2" id="lbpendientes" onclick="lbusca(this.id)">Pendientes</label>
<label class="Estilo2" id="lbenviadas" onclick="lbusca(this.id)">Enviadas</label>
<label class="Estilo2" id="lbrecibidas" onclick="lbusca(this.id)">Recibidas</label>
<label class="Estilo2" id="lbdenegadas" onclick="lbusca(this.id)">Denegadas</label>
</div>



<div id="refrescar">
<img src="../redmoon_img/imgDoc/refrescar.png" alt="Recargar" title="Recargar" align="middle" onclick="Refrescar()"></img>
</div>

<div id="listado">
<img img alt="Exportar a PDF" title="Exportar a PDF" src="../redmoon_img/imgDoc/PDF.png"  onclick="CrearPDF()"></img>
</div>

<div id="cuaderno">
<img src="../redmoon_img/imgDoc/cuaderno.png" alt="Generar Cuaderno de Pago" title="Generar Cuaderno de Pago" onclick="GenerarCuaderno()" onmouseover="AyudaCuaderno()" onmouseout="SalirAyudaCuaderno()"></img>
</div>


<div id="btnPaginaB">
<div id="btnNavegaAtras" onclick="GotoBack()" title="Atr�s"><span>Atr�s</span></div>
<div id="btnNavegaSig" onclick="GotoNext()" title="Atr�s"><span>Siguiente</span></div>
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
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div id="VentanaTablaB">
<table width="750" border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oFila0" style="color:#3C4963; cursor:default">
    <td width="5%"><strong>ID</strong></td>
    <td width="5%"><strong>Entrada</strong></td>
    <td width="5%"><strong>Envio</strong></td>
    <td width="5%"><strong>Recepci&oacute;n</strong></td>
    <td width="20%"><strong>Direcc.</strong></td>
    <td width="5%"><strong>Escalera</strong></td>
    <td width="20%"><strong>Titular</strong></td>
    <td width="10%"  ><strong>Registro</strong></td>
     <td width="10%"  ><strong>ID Finca</strong></td>
    <td width="10%" ><strong>Estado</strong></td>
   
  </tr>
</table>
<input type="hidden" name="pantalla" id="pantalla" />
<input type="hidden" name="xPag" id="xPag" value="1" />
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
</body>
</html>