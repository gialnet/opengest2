<?php require('Redmoon_php/controlSesiones.inc.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Provisi&oacute;n de fondos</title>
<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />
<link href="Redmoon_ccs/cargando.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cargando.js" type="text/javascript"></script>
<script src="Redmoon_js/pagina.js" type="text/javascript"></script>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

<script> 

var StringSerializado="";
var xPag=1;
//variable para guardar la ultima consulta realizada
var xUltimo='';

function HacerBusqueda()
{
	//alert("busqueda");
	<?php 
			if(isset($_GET["xNIF"]))
			{
				$xNIF=$_GET["xNIF"];
				echo 'xNIF="'.$xNIF.'"'.";\n";
				echo 'document.getElementById("NIF").value="'.$xNIF.'"'.";\n";
				echo "LeeConsulta('NIF');"."\n";
			
				
			}
			
			if(isset($_GET["xNombre"]))
			{
				$xNombre=$_GET["xNombre"];
				echo 'xNombre="'.$xNombre.'"'.";\n";
				echo 'document.getElementById("Nombre").value="'.$xNombre.'"'.";\n";
				echo "LeeConsulta('Nombre');"."\n";
				
			}
			
			if(isset($_GET["xIDExpe"]))
			{
				$xIDExpe=$_GET["xIDExpe"];
				echo 'xIDExpe="'.$xIDExpe.'"\n';
				
			}
			
			if(isset($_GET["xFecha"]))
			{
				$xFecha=$_GET["xFecha"];
				echo 'xFecha="'.xFecha.'"\n';
			}
			else{ 
				echo "LeeConsulta('Todo');"."\n";
				
			}
			?>
		var buscar="<?php echo $busqueda; ?>";
		//alert(buscar);
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
// icono aceptar provision de fondos
//
function ConfirmIngreso(xFila)
{
	var idFila="ofila"+xFila;
	var oCelda=document.getElementById(idFila).cells[0];
	var url_parametros="xIDExpe="+oCelda.innerHTML;


	//alert(url_parametros);
	if (confirm('Confirma el Ingreso?'))
	{
		VerGifEspera();
	   PutDataAsuntos('Redmoon_php/ORAProvisionFondos.php', url_parametros);
	   
	}
	
	   
	//alert(oCelda.innerHTML);
	

}


//
// Cuando nos ingresan una provision de fondos distinta a la presupuestada
//
function chgIngreso(xFila)
{
	var idFila="ofila"+xFila;
	var oCelda=document.getElementById(idFila).cells[0];
	var oValor=document.getElementById(idFila).cells[4];
	var campo='<input name="Importe" type="text" id="Importe" size="20" maxlength="10" onkeypress="detectar_tecla(event,\'chg\');" />';
	//alert(campo);
	// guardamos el expediente en un imput oculto
	document.getElementById("inIDExpe").value=oCelda.innerHTML;
	
	oValor.innerHTML=campo;
	document.getElementById("Importe").focus();
	

	
}
//
// llamar a quien graba el importe de otras provisiones cuando se pulsa return
//
function CallOtrasProvisiones()
{

	var xImporte=document.getElementById("Importe").value;
	var url_parametros="xIDExpe="+document.getElementById("inIDExpe").value+"&xImporte="+xImporte;
	
	//alert(url_parametros);
	if (confirm('&iquest;Confirma el Ingreso?'))
	{
		VerGifEspera();
	   PutDataAsuntos('Redmoon_php/ORAProvisionFondos_Otros.php', url_parametros);
	   
	}
	
}

//
// Cambiar de fase el expediente
//
function chgFase(xFila){

	var idFila="ofila"+xFila;
	var oCelda=document.getElementById(idFila).cells[0];
	var url_parametros="xIDExpe="+oCelda.innerHTML;

	if (confirm('Confirma CAMBIAR DE FASE?'))
	{
		VerGifEspera();
	   PutDataAsuntos('Redmoon_php/ORAProvisionFondos_chgFase.php', url_parametros);
	   
	}
}

//
//
//
function sendMail(){
	alert('Se ha enviado un email al director de la sucursal');
}
//
// Ir al formulario consulta del expediente
//
function VerExpe(xFila){
	
	var idFila="ofila"+xFila;
	var oCelda=document.getElementById(idFila).cells[0];
	var url_parametros="xIDExpe="+oCelda.innerHTML;
	
	location="MenuTitulares.php?"+url_parametros;
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
	if(Opcion=='NIF')
	{
		var xNIF=document.getElementById('NIF').value;
	   var url_parametros='xNIF='+xNIF.toUpperCase();
	   xUltimo=url_parametros;
	   url_parametros+='&xPag='+xPag;
	   xFormaBuscar='NIF';
	  
	  
	}
	   
	if(Opcion=='Nombre')
	{
	   var xNombre=document.getElementById('Nombre').value;
	   var url_parametros='xNombre='+xNombre.toUpperCase();
	   xUltimo=url_parametros;
	   url_parametros+='&xPag='+xPag;
	   xFormaBuscar='Nombre';
	}

	if(Opcion=='Expediente')
	{
	   var xExpe=document.getElementById('Expediente').value;
	   var url_parametros='xExpe='+xExpe;
	   xUltimo=url_parametros;
	   url_parametros+='&xPag='+xPag;
	   xFormaBuscar='Expediente';
	}
	
	if(Opcion=='Fecha')
	{
	   var xFecha1=document.getElementById('FechaDe').value;
	   var xFecha2=document.getElementById('FechaHa').value;
	   var url_parametros='xFecha1='+xFecha1+'&xFecha2='+xFecha2;
	   url_parametros+='&xPag='+xPag;
	   xFormaBuscar='Fecha';
	}

	 
	//alert(xUltimo);
	VerGifEspera();
	//alert(url_parametros);
	PutDataAsuntos('Redmoon_php/serializado_ProvisionFondos.php', url_parametros);
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
			// despues de grabar dejar las cosas como estaban		
			OcultarGifEspera();		
			
			//alert(pageRequest.responseText);
			if (pageRequest.responseText=='Ok')
				return;
			
			if (pageRequest.responseText=='Error')
			    alert(pageRequest.responseText);
			else
			{
			    StringSerializado=pageRequest.responseText;
			    if (StringSerializado!='NoDataFound')
			    {
			    	deleteLastRow('oTabla');
				    AddRowTable();				   
			    }
			    else
			    {
			    	alert('No hay datos para esta consulta');
			    }
			 
		    }

			// Refrescar la pantalla slo cuando hay actualizaciones de datos
			
			if (url!='Redmoon_php/serializado_ProvisionFondos.php')
				LeeConsulta('Todo');
			    			

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
	for(x=0; x<=ArrayColumnas.length-2; x+=5)
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
  			cellText.setAttribute('align', 'right');
  			cellText.setAttribute('style', 'color:#3C4963');  			
  			cellText.innerHTML=ArrayColumnas[3+x];

  			// PROVISIONES INGRESADAS
  			cellText =  row.insertCell(4);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('align', 'right');
  			cellText.setAttribute('style', 'color:#3C4963');  			
  			cellText.innerHTML=ArrayColumnas[4+x];

  			// icono herramienta
  			cellText =  row.insertCell(5);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/ok.png" alt="Confirmacion del Ingreso" title="Confirmacion del Ingreso" onclick="ConfirmIngreso('+j+')" id="oSave'+j+'">';

  			cellText =  row.insertCell(6);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/editar.png" alt="Introdicir cantidad Ingresada" title="Introdicir cantidad Ingresada" onclick="chgIngreso('+j+')" id="oChage'+j+'">';
  			
  			cellText =  row.insertCell(7);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/flecha_dch.png" alt="Cambiar de Fase" title="Cambiar de Fase" onclick="chgFase('+j+')" id="oFase'+j+'">';
  			
  			cellText =  row.insertCell(8);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/mail.png" alt="Enviar Mail a la Oficina" title="Enviar Mail a la Oficina" onclick="sendMail('+j+')" id="oFase'+j+'">';

  			cellText =  row.insertCell(9);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.innerHTML='<img src="redmoon_img/imgTablas/ver.png" alt="Consultar Expediente" title="Consultar Expediente" onclick="VerExpe('+j+')" id="oFase'+j+'">';
  			
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
//alert("pasa");
if (window.event)
	tecla=e.keyCode;
else
	tecla=e.which;

// escape
if(tecla==27){
	
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
	// refrescar la pantalla
	LeeConsulta('Todo');
	
}	
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

	// Grabar el importe introducido al pulsar return
	if(opcion=='chg')
	CallOtrasProvisiones();
	else
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

function CrearPDF(){
	var buscar="<?php echo $busqueda;?>";

	//alert(xUltimo);
	location='pdf_provisionfondosadd.php?'+xUltimo;
		
}

function lbusca(opcion){
	
	//alert(opcion);

	apagaPaneles();
	
	if (opcion=='lbnif')
	{
		document.getElementById('BuscaNIF').style.visibility='visible';
		document.getElementById('NIF').focus();
	}
	
	if (opcion=='lbnombre')
	{
		document.getElementById('BuscaNombre').style.visibility='visible';
		document.getElementById('Nombre').focus();
	}
	
	if (opcion=='lbexpediente')
	{
		document.getElementById('BuscaExpe').style.visibility='visible';
		document.getElementById('Expediente').focus();
	}
	
	if (opcion=='lbfecha')
	{
		document.getElementById('BuscaFecha').style.visibility='visible';
		document.getElementById('FechaDe').focus();
	}			
}

function apagaPaneles(){
	document.getElementById('BuscaNIF').style.visibility='hidden';
	document.getElementById('BuscaNombre').style.visibility='hidden';
	document.getElementById('BuscaExpe').style.visibility='hidden';
	document.getElementById('BuscaFecha').style.visibility='hidden';
	}
</script>


<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />

<style type="text/css">
#pagina_adelante{
position: absolute;
top:150px;
left:40px;
cursor:pointer;


}

#pagina_boton{
position: absolute;
top:780px;
left:40px;
cursor:pointer;

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




  #busqueda{
 	position:absolute;
	top:50px;
 	left:20px;
 }

</style>
</head>

<body  onload="LeeConsulta('Todo');">
<?php require('cabecera.php'); ?>

<div id="documento">
    <div id="rastro"><a href="MenuLGS.php">Inicio</a>
        > Expedientes Pendientes de Provisi&oacute;n de Fondos
    </div>
<div id="ayuda_btn">
		<!--<img alt="Ayuda" src="Redmoon_img/imgDoc/ayuda.png" alt="Ayuda" title="Ayuda" onclick="AbrirAyuda('Gestoria_documentacion/expedientes_pendientes_provisiones_fondos.html')" />-->
	</div>
    <div id="pdf"  onclick="CrearPDF()"><img alt="Exportar a PDF" title="Exportar a PDF" src="redmoon_img/imgDoc/PDF.png" /><span class="Estilo1"> </span></div>



<div id="busqueda">
  <span class="Estilo1">Buscar Expedientes por:</span> 
   <label class="Estilo2" id="lbnif" onclick="lbusca(this.id)">NIF</label>
<label class="Estilo2" id="lbnombre" onclick="lbusca(this.id)">Nombre</label>
<label class="Estilo2" id="lbexpediente" onclick="lbusca(this.id)">Número de Expediente</label>
</div>

<div id="btnPaginaB">
<div id="btnNavegaAtras" onclick="GotoBack()" title="Atr�s"><span>Atr�s</span></div>
<div id="btnNavegaSig" onclick="GotoNext()" title="Atr�s"><span>Siguiente</span></div>
</div>


<p>&nbsp;</p>
<div class="example-twitter" id="BuscaNIF">
<form name="form1" method="post" action="">
<p class="Estilo1">NIF
<input style="text-transform:uppercase;" name="NIF" type="text" id="NIF" onkeypress="detectar_tecla(event,'NIF')" size="14" maxlength="14" />
<img src="Redmoon_img/imgDoc/buscar.png" alt="Buscar" align="right" title="Buscar"  onclick="LeeConsulta('NIF');" />
</p>
</form>
</div>
<div class="example-twitter" id="BuscaNombre">
<form name="form2" method="post" action="#">
<p class="Estilo1">Nombre
<input name="Nombre" style="text-transform:uppercase;" type="text" id="Nombre" size="40" maxlength="40" onkeypress="detectar_tecla(event,'Nombre')" />
<img src="Redmoon_img/imgDoc/buscar.png" alt="Buscar" align="right" title="Buscar"  onclick="LeeConsulta('Nombre');" />
</p>
</form>
</div>
<div class="example-twitter" id="BuscaExpe">
<form name="form3" method="post" action="">
<p class="Estilo1">Número de Expediente
<input name="Expediente" type="text" id="Expediente" size="20" maxlength="20" onkeypress="detectar_tecla(event,'Expediente')" />
<img src="Redmoon_img/imgDoc/buscar.png" alt="Buscar" align="right" title="Buscar"  onclick="LeeConsulta('Expediente')" />
</p>
</form>
</div>

<div class="example-twitter" id="BuscaFecha">
<form id="form4" name="form4" method="post" action="">
<p class="Estilo1">Fecha desde
<input name="FechaDe" type="text" id="FechaDe" size="10" maxlength="10" onkeypress="detectar_tecla(event)" />
hasta
<input name="FechaHa" type="text" id="FechaHa" size="10" maxlength="10" onkeypress="detectar_tecla(event,'Fecha')" />
<img src="Redmoon_img/imgDoc/buscar.png" alt="Buscar" align="right" title="Buscar"  onclick="LeeConsulta('Fecha')" />
</p>                
</form>
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
<table width="790" border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oFila0" style="color:#3C4963; cursor:default">
    <td width="10%"><strong>Expediente</strong></td>
    <td width="10%"><strong>NIF</strong></td>
    <td width="50%"><strong>Nombre</strong></td>
    <td width="13%" align="center" ><strong>Provision</strong></td>
    <td width="13%" align="center" ><strong>Ingresado</strong></td>
  </tr>
</table>
<input type="hidden" name="xIDExpe" id="inIDExpe" />
</div>
<?php require('Redmoon_php/cargando.inc'); ?>
</div>

</body>
</html>
