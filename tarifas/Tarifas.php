<?php 

require('../Redmoon_php/controlSesiones.inc.php');
require('../Redmoon_php/pebi_cn.inc.php');
require('../Redmoon_php/pebi_db.inc.php'); 

$conn = db_connect();

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tarifas</title>
<script src="js/cambiatexto.js" language="javascript"></script>
<link href="ccs/main.css" rel="stylesheet" type="text/css" />
<link href="ccs/nivel_2.css" rel="stylesheet" type="text/css" />
<link href="../Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="js/cabecera.js" type="text/javascript"></script>

<style type="text/css">
#Cargando {
	position:absolute;
	top:70px;
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
	left: 400px;
	visibility:hidden;
}
#AddMovSeguimiento{
	position:absolute;
	top:130px;
	left:320px;
	height: 200px;
	width: 45%;
	
	
	visibility:hidden;
}


#TarifasZonasServicio{
	position:absolute;
	top:20px;
	left: 280px;
	height: 1400px;
	width: 58%;
	
	visibility:hidden;
}

</style>


<script> 

var StringSerializado="";
var gServicio="";

//
//Quita el gif animado grabando
//
function DesctivaInterfazGrabando()
{
	// averiguar el navegador
	var agent = navigator.userAgent.toLowerCase();
	var isIE = (agent.indexOf('msie') != -1);
	ht = document.getElementById("TarifasZonasServicio");
	imagen= document.getElementById("Cargando");

	// despues de grabar dejar las cosas como estaban
	imagen.style.visibility='hidden';

	if (isIE)
		ht.style.filter = "";
	else
		ht.style.opacity="";
	
}
//
//Pone el gif animado grabando
//
function ActivaInterfazGrabando()
{
		// averiguar el navegado
	var agent = navigator.userAgent.toLowerCase();
	var isIE = (agent.indexOf('msie') != -1);
	var ht = document.getElementById("TarifasZonasServicio");
	var imagen= document.getElementById("Cargando");
	
	// encender el gif de datos guardandose
	imagen.style.visibility='visible';

	//La siguiente linea pone a grises la pantalla en funcion del navegador
	if (isIE)
	   ht.style.filter = "progid:DXImageTransform.Microsoft.BasicImage(opacity=.95)";
	else
	   ht.style.opacity='.95';

}



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
//
function GetFila(xID)
{
	var oCelda=document.getElementById(xID).cells[0];
	var url_parametros="xIDExpe="+oCelda.innerHTML;
/*
	if (confirm('�Confirma el Ingreso?'))
	{
	   PutDataAsuntos('Redmoon_php/ORAProvisionFondos.php', url_parametros);
	   LeeConsulta('Todo');
	}
*/   
	//alert(oCelda.innerHTML);
	

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
function LeeConsulta(Opcion, Zona)
{
	
	var url_parametros='xTipoActo='+Opcion+'&xZona='+Zona;

	ActivaInterfazGrabando();
	PutDataAsuntos('../Redmoon_php/serializado_Tarifas.php', url_parametros);
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
	//alert(dataToSend);
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
			
			
			if (pageRequest.responseText=='Error')
			    alert(pageRequest.responseText);
			else
			{
				
				if(url=='../Redmoon_php/serializado_Tarifas.php')
				{
					DesctivaInterfazGrabando();
			    	StringSerializado=pageRequest.responseText;
			    	//alert(StringSerializado);
			    	deleteLastRow('oTabla');
			    	AddRowTable();
				}
				
				if (url=='../Redmoon_php/ORACambioTarifa.php')
				{
					// Para que refresque la pantalla
			    	AbrirServicio(gServicio);
				}
				
				
		    }
		    	

		}
		else if (pageRequest.status == 404) 
			alert('Disculpas, la informacion no esta disponible en estos momentos.');
		else 
			alert('Ha ocurrido un problema.');
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
	for(x=0; x<=ArrayColumnas.length-2; x+=6)
	    {
		j++;
				row = tbl.insertRow(tbl.rows.length);
				row.setAttribute('id', 'ofilaVal'+j);
				row.setAttribute('onclick', 'GetFila(this.id);');
				row.setAttribute('onMouseOver', 'FilaActiva(this.id);');
				row.setAttribute('onMouseOut', 'FilaDesactivar(this.id);');
				

			// el id oculto	
			cellText =  row.insertCell(0);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.innerHTML=ArrayColumnas[0+x];
  			cellText.style.display='none';

  			// descripci�n
			cellText =  row.insertCell(1);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.innerHTML=ArrayColumnas[1+x];
  			
  			cellText =  row.insertCell(2);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.innerHTML=ArrayColumnas[2+x]+
			'<img src="../redmoon_img/lapiz3.png" onclick="chgValor('+j+',this.id)" id="oChgTramo'+j+'">';
  			
  			cellText =  row.insertCell(3);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.setAttribute('align', 'right');
  			cellText.innerHTML=ArrayColumnas[3+x]+
			'<img src="../redmoon_img/lapiz3.png" onclick="chgValor('+j+',this.id)" id="oChgValorInicial'+j+'">';
  			
  			cellText =  row.insertCell(4);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.setAttribute('align', 'right');
  			cellText.innerHTML=ArrayColumnas[4+x]+
			'<img src="../redmoon_img/lapiz3.png" onclick="chgValor('+j+',this.id)" id="oChgIntervalo'+j+'">';

  		  	cellText =  row.insertCell(5);
  			textNode = document.createTextNode(tbl.rows.length - 1);
  			cellText.appendChild(textNode);
  			cellText.setAttribute('style', 'color:#3C4963');
  			cellText.setAttribute('align', 'right');
  			cellText.innerHTML=ArrayColumnas[5+x]+
			'<img src="../redmoon_img/lapiz3.png"  onclick="chgValor('+j+',this.id)" id="oChgAdicional'+j+'">';
  						
		}

}
//
//
//
function chgValor(xFila,xIDObjeto)
{
	var idFila="ofilaVal"+xFila;
	var oCelda=document.getElementById(idFila).cells[0];
	var oValor;
	var campo;


	//alert(xIDObjeto.substring(0,5));
	if (xIDObjeto.substring(0,5)=='oChgT')
	{
	oValor=document.getElementById(idFila).cells[2];
	campo='<input name="REGLA" type="text" id="REGLA" size="10" maxlength="10" onkeypress="detectar_tecla(event, this.id)" />';
	oValor.innerHTML=campo;
	document.getElementById('REGLA').focus();
	}

	if (xIDObjeto.substring(0,5)=='oChgV')
	{
	oValor=document.getElementById(idFila).cells[3];
	campo='<input name="VALOR_INICIAL" type="text" id="VALOR_INICIAL" size="10" maxlength="10" onkeypress="detectar_tecla(event, this.id)" />';
	oValor.innerHTML=campo;
	document.getElementById('VALOR_INICIAL').focus();
	}
	
	if (xIDObjeto.substring(0,5)=='oChgI')
	{
	oValor=document.getElementById(idFila).cells[4];
	campo='<input name="INTERVALO" type="text" id="INTERVALO" size="10" maxlength="10" onkeypress="detectar_tecla(event, this.id)" />';
	oValor.innerHTML=campo;
	document.getElementById('INTERVALO').focus();
	}
	
	if (xIDObjeto.substring(0,5)=='oChgA')
	{
	oValor=document.getElementById(idFila).cells[5];
	campo='<input name="IMPORTE_TRAMO" type="text" id="IMPORTE_TRAMO" size="10" maxlength="10" onkeypress="detectar_tecla(event, this.id)" />';
	oValor.innerHTML=campo;
	document.getElementById('IMPORTE_TRAMO').focus();
	}
	
	// guardamos ID Asuntos del Expediente en un imput oculto
	document.getElementById("inID").value=oCelda.innerHTML;
	
	
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
	
	//Grabar el importe introducido al pulsar return
	CallChgValor(opcion);
		
}


}

//
//llamar a quien graba el importe de otras provisiones cuando se pulsa return
//
function CallChgValor(xIDObjeto)
{

	var xImporte=document.getElementById(xIDObjeto).value;
	var url_parametros="xID="+document.getElementById("inID").value+
	"&xValor="+xImporte+
	"&xConcepto="+xIDObjeto;
	
	//alert(url_parametros);
	PutDataAsuntos('../Redmoon_php/ORACambioTarifa.php', url_parametros);
	
}


</script>





<script type="text/javascript">
//
//
//
function FilaActiva(xID)
{
	document.getElementById(xID).style.backgroundColor ="#ECF3F5";
}
//
// Cojer el valor de la fila
//
function GetFila(xID)
{
	var oCelda=document.getElementById(xID).cells[1];
	//var fila=document.getElementById(xID).rowIndex;

	//alert(oCelda.innerHTML);
	//location="Clientes.php?xNIF="+oCelda.innerHTML;

}

//
//
//
function FilaDesactivar(xID)
{
document.getElementById(xID).style.backgroundColor ="#FFFFCC";
}

function VerPanel(zona)
{
	document.getElementById('ZonaGestion').innerHTML=zona;
	document.getElementById('AddMovSeguimiento').style.visibility='visible';
}

function QuitPanel(){
	document.getElementById('AddMovSeguimiento').style.visibility='hidden';
}

// Para los distintos servicios
function AbrirServicio(servicio){
	var zona = document.getElementById('ZonaGestion').innerHTML;
	// Quitar el panel de selecci�n de servicio
	QuitPanel();
	// titulo a�n no puesto
	document.getElementById('TituloZona').innerHTML='<H3 class="Estilo1">'+servicio+':<H3>'+document.getElementById('ZonaGestion').innerHTML;
	document.getElementById('TarifasZonasServicio').style.visibility='visible';

	// variable global para saber quien invoco la �ltima llamada
	gServicio=servicio;
	
	// LLamar a la consulta asincrona
	//alert(zona.substr(0,2));
	LeeConsulta(servicio, zona.substr(0,2));
	/*
	if (zona.substr(0,2)=='Granada')
		LeeConsulta(servicio, '01');
	
	if (zona.substr(0,2)=='Sevilla')
		LeeConsulta(servicio, '02');
	
	if (zona.substr(0,2)=='Madrid')
		LeeConsulta(servicio, '03');
	
	if (zona.substr(0,2)=='Barcelona')
		LeeConsulta(servicio, '04');*/
}
//Para Gestoria
function QuitGestoria(){
	// Quitar el panel de selecci�n de servicio
	QuitPanel();
	document.getElementById('TarifasZonasServicio').style.visibility='hidden';
}

</script>

</head>

<body>
<?php require('cabecera.php'); ?>
<div id="documento">
    <div id="rastro"><a href="../MenuAdmin.php">Inicio</a> >
            Precios de Servicios
</div>
<div id="menuSuper">
</div>

<?php
 
 	$sql='SELECT ZONA,NOMBRE FROM ZONAS';
	$stid = oci_parse($conn, $sql);
	
	$r = oci_execute($stid, OCI_DEFAULT);

echo '<div id="menu">';
	

  while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		echo '<p class="Estilo1">';
		echo '<label class="opcmenu" onclick="VerPanel('."'".$row['ZONA'].'-'.$row['NOMBRE']."'".')" >';
		echo $row['ZONA'].'.'.$row['NOMBRE'];//Granada,Jaen,Cadiz,Cordoba,Huelva
		echo '</label>';
		echo '</p>';
	}

echo '</div>';
?>

<div id="CuerpoCentral">
  <p align="center" class="Estilo1"><strong>Los precios y sus tarifas</strong>.</p>
  <p align="justify" class="Estilo5">Los precios estan determinados por las zonas de gestión, conjunto que aparece en esta página a nuestra izquierda. Tendremos  tantas zonas como sea necesario en cada momento.</p>
  <p align="justify" class="Estilo5">Cada tipo de servicio, menu superior, tiene una tarifa asociada a cada zona. Es decir para la zona de Granada, nuestro coste de gestoría puede ser distinto que para la zona Madrid.</p>
  <p align="justify" class="Estilo5">Los calculos que realiza la aplicación para la estimación de la provisión de fondos, estan basados en las siguientes premisas:</p>
  <p class="Estilo5">Reglas, Tramos y la suma de Reglas y Tramos. Por ejemplo la regla más simple podría ser <strong>EXENTO</strong>, que quiere decir que su coste es cero.</p>
  <p align="justify" class="Estilo5">La segunda regla es un porcentaje, metodo progresivo ampliamente utilizado en tributos, sobre importe de la base y se enuncia de la siguiente manera: <strong>numero%</strong>, donde número es cualquier importe ejemplo 0,015%.</p>
  <p align="justify" class="Estilo5">La siguiente es <strong>TRAMO</strong>, que nos indica que el calculo será por tramos, en función del importe base del acto. Lo siguiente a tener en cuenta será <strong>valor inicial</strong> es decir el coste mínimo de servicio, el <strong>intervalo</strong> es decir cada cuanto se incrementa el coste y por último el <strong>coste del intervalo</strong>, la cantidad que aumenta a cada intervalo.</p>
  <p align="justify" class="Estilo3"></p>
  <h3 align="center">&nbsp;</h3>
</div>
<p align="left">&nbsp;</p>
<p align="left">&nbsp;</p>
<p align="center">&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<div id="AddMovSeguimiento">
    <div id="winPop">
    <p align="right"><img src="../Redmoon_img/imgDoc/cancelar.png" alt="salir"  align="texttop" longdesc="salir" onclick="QuitPanel()" />
    </p>
    <h3>
    <label id="ZonaGestion" class="Estilo1">Zona de Gesti�n</label>
    </h3>
    <h4 class="Estilo5">Seleccione tipo de servicio</h4>
    <p>
	<label class="opcmenuSuper" onclick="AbrirServicio('GESTORIA')">Gestoria</label>
	<label class="opcmenuSuper" onclick="AbrirServicio('NOTARIA')">Notaria</label>
	<label class="opcmenuSuper" onclick="AbrirServicio('IMPUESTO')">Impuesto</label>
	<label class="opcmenuSuper" onclick="AbrirServicio('REGISTRO')">Registro</label>
	</p>
    </div>
</div>


<div id="TarifasZonasServicio">
    <div id="winPop">
    <p align="right"><img src="../Redmoon_img/imgDoc/cancelar.png" alt="salir"  align="texttop" longdesc="salir" onclick="QuitGestoria()" />
    </p>
    <label id="TituloZona">Zona de Gestion</label>
    <table width="450" border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oFila0" style="color:#3C4963; cursor:default">
    <td width="45%" align="center"><strong>Concepto</strong></td>
    <td width="15%" align="center"><strong>Regla</strong></td>
    <td width="15%" align="center"><strong>Importe inicial</strong></td>
    <td width="15%" align="center"><strong>Intervalo</strong></td>
    <td width="10%" align="center"><strong>Coste adicional</strong></td>
  </tr>  
</table>
<input type="hidden" name="xID" id="inID" />
</div>
</div>
<div id="Cargando">
<img src="../Redmoon_img/Cargando.gif" alt="Guardando" width="25" height="25" longdesc="Guardando datos" /> 
<p>procesando datos...</p>
</div>

</div>
</body>
</html>
