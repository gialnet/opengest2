<?php

require_once('Redmoon_php/controlSesiones.inc.php');
require_once('Redmoon_php/pebi_cn.inc.php');
require_once('Redmoon_php/pebi_db.inc.php');

$conn = db_connect();

// Titulares y avalistas de la operaci�n

$sql='SELECT NE, NIF, APENOMBRE, MOVIL, TELEFONO FROM VWCLIENTESHIPOTODOS WHERE NE=:xIDExpe';
$stid = oci_parse($conn, $sql);
$xIDExpe = $_GET["xIDExpe"];
oci_bind_by_name($stid, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);

// Datos de las fincas

$sql2='select ID,CALLE,MUNICIPIO,REGISTRO from FINCAS where NE=:xIDExpe';
$stid2 = oci_parse($conn, $sql2);
oci_bind_by_name($stid2, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);
$xIDExpe = $_GET["xIDExpe"];

// Importe de la provisi�n de fondos

$sql3='select sum(IMP_NOTARIA+IMP_IMPUESTO+IMP_REGISTRO+IMP_GESTORIA+IMP_PLUSVALIA) AS IMP_PROVISION from asuntos_expediente where NE=:xIDExpe';
$stid3 = oci_parse($conn, $sql3);
$xIDExpe = $_GET["xIDExpe"];
oci_bind_by_name($stid3, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);


// Estados del expediente

$sql4='select e.ESTADO,e.TIPO_ASUNTO,e.CUANTIA,e.REVISADO_GESTORAS,e.ENVIO_COLABORADOR,
e.ENTRA_GESTORIA,e.SALE_GESTORIA,e.NUM_FINCAS,e.FECHA_PROVISION, o.email, w.apenombre 
from expedientes e, oficinas o, VWCLIENTESEXPE W 
where e.NE=:xIDExpe and o.oficina=e.oficina AND E.NE=w.ne';

$stid4 = oci_parse($conn, $sql4);
oci_bind_by_name($stid4, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);
$xIDExpe = $_GET["xIDExpe"];

// lanzar las consultas SQL

$r = oci_execute($stid, OCI_DEFAULT);
$r2 = oci_execute($stid2, OCI_DEFAULT);
$r3 = oci_execute($stid3, OCI_DEFAULT);
$r4 = oci_execute($stid4, OCI_DEFAULT);

// leer el Importe de la provisi�n de fondos

$row = oci_fetch_array($stid3, OCI_ASSOC+OCI_RETURN_NULLS);
$ImporteProvision=number_format($row['IMP_PROVISION'], 0, ',', '.').' &#8364;';

// leer las variables del expediente

$row = oci_fetch_array($stid4, OCI_ASSOC+OCI_RETURN_NULLS);

$RevisadoGestoras=$row['REVISADO_GESTORAS'];
$EstadoExpe=$row['ESTADO'];
$Cuantia=$row['CUANTIA'];
$NumFincas=$row['NUM_FINCAS'];
$FechaProvision=$row['FECHA_PROVISION'];
$eMail=$row['EMAIL'];
$xNombre=$row['APENOMBRE'];
// Etiqueta tipo de asunto

if ($row['TIPO_ASUNTO']==1)
	$tipo_asunto='Hipotecaria';
else 
	$tipo_asunto='Dacion';
	
// valor del campo tipo de asunto
$tipo_asunto_VALUE=$row['TIPO_ASUNTO'];

$donde='';

// a partir de que tenga fecha de provisi�n de fondos tiene sentido lo de la ubicaci�n del expediente pues
// es el momento donde nace el encargo del trabajo

if ($FechaProvision!=null)
{

	if ($row['ENVIO_COLABORADOR']!=null)
		$donde="LO ENVIO EL COLABORADOR"; 
			
	if ($row['ENTRA_GESTORIA']!=null)
		$donde="En NUESTRO PODER";
	
	if ($row['SALE_GESTORIA']!=null)
		$donde="En la SUCURSAL";
		
	if ($donde=='')
		$donde="Lo tiene el COLABORADOR";

	$donde='UBICACI&Oacute;N: '.$donde;
}	

// Reglas de negocio

// En caso de que el expediente sea superior a 300.000 euros de cuant�a tiene que ser revisado por las gestoras
// no se podr� imprimir el documento de encargo de trabajo 
if (($Cuantia >= $_SESSION['MayorCuantia']) && ($RevisadoGestoras=='N'))
{
	$ImporteProvision="Pendiente Calculo";
	$MayorCuantia='S';
}
else 
	$MayorCuantia='N';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Titulares de un Expediente</title>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>
<script src="Redmoon_js/cargando.js" type="text/javascript"></script>
<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" /> 

<style type="text/css">

#imagen_estado{
position: absolute;
top:50px;
left:20px;
}
#imagen_alert{
position: absolute;
top:60px;
left:745px;
}
#imagen_home{
position: absolute;
top:37px;
left:870px;
}
#Botones_superior{
position: absolute;
top:40px;
left:160px;
}
#NumeroExpe{
position: absolute;
top:45px;
left:180px;

}

#VentanaProvisiones{
	position:absolute;
	top:90px;
	left:1px;
	height: 300px;
	width: 780px;
	

	
	visibility:hidden;

}

.EtiquetaInput {
	font-family: "Times New Roman", Times, serif;
	font-size: medium;
	font-style: normal;
	background-color: #FFFF99;
	border:solid 3px;
	border-color:#ebebeb;
	
	margin: 10px;

	padding:10px;
	height: 23px;
	color: #3c4963;
	font-weight: bold;
}

#VentanaTabla{ position:absolute;
	top:190px;
	left:20px;
	width:750px;
	height:150px;
	overflow:auto;
	cursor:pointer;
}

#VentanaTablaFincas{ position:absolute;
	top:350px;
	left:20px;
	width:750px;
	height:150px;
	overflow:auto;
	cursor:pointer;
}

#ubicacion{
 	position:absolute;
 	top:35px;
 	left:240px;
 
}

#busqueda{
 position:absolute;
 left:100px;
 top:20px;
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

</style>
<script type="text/javascript">


var StringSerializado="";

//
//Cambiar de fase el expediente
//
function ExpedienteRevisado(){

	var url_parametros="xIDExpe=<?php echo $xIDExpe; ?>";

	//alert("<?php echo $xNombre; ?>");
	
	if (confirm('Confirma Expediente Revisado y Aprobado?'))
	{
		VerGifEspera();
	    PutDataAsuntos('Redmoon_php/ORAProvisionFondos_RevisionOK.php', url_parametros);

	    // enviar un email a la oficina avisando
	    // alert('Se ha enviado un email a la oficina');

	    MiWin=window.open('correoPHP/email_ExpeRevisadoGestoras.php?xMail=<?php echo $xMail; ?>'+'&xNombre=<?php echo $xNombre; ?>',
		'SenMail','left=250, height=250,width=550,toolbar=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,modal=yes');
	   
	}
}

//
// Asuntos contratados
//
function CallAsuntos()
{
	var TipoAsunto=document.getElementById('inTAsunto').value;

	if (TipoAsunto==1 || !TipoAsunto)
		location="ActosExpedienteHipotecario.php?xIDExpe=<?php echo $_GET[xIDExpe];?>"+"&Mod=M";
	
	if (TipoAsunto==2)
		location="ActosExpedienteDacion.php?xIDExpe=<?php echo $_GET[xIDExpe];?>"+"&Mod=M";
}

//
// A�adir fincas al expediente.
//
function CallFincas()
{
	location="DatosNotaSimple.php?xIDExpe=<?php echo $_GET[xIDExpe];?>";
}

//
// Imprimir el PDF del documento de encargo de trabajo
//
function CallPrintProvision()
{
	var RevisadoGestoras='<? echo $RevisadoGestoras; ?>';
	var MayorCuantia='<? echo $MayorCuantia; ?>';
	var TuDeQuienEres='<? echo $Rol_controlSesiones; ?>';
	
	// comprobar si es un expediente de mayor cuant�a y si ah sido revisado
	if(MayorCuantia=='S' && RevisadoGestoras=='N' && TuDeQuienEres!='2')
	{
		alert('Pendiente de Revisi&oacute;n Gestoras');
		return;
	}
	location="solicitudProvisionyTramitacion.php?xIDExpe=<?php echo $_GET[xIDExpe];?>";
}

//
// Ver el seguimiento del expediente
//
function CallSegui()
{
	location="SeguiExpeConsulta.php?xIDExpe=<?php echo $_GET[xIDExpe];?>";
}

//
//
//
function CallAprueba()
{
	location="AprobacionOperacion.php?xIDExpe=<?php echo $_GET[xIDExpe];?>";
}
//
//
//
function FilaActivaFincas(xID)
{
	document.getElementById(xID).style.backgroundColor ="#ECF3F5";
}
//
// Cojer el valor de la fila
//
function GetFilaFincas(xID)
{
	var oCelda=document.getElementById(xID).cells[0];
	//var fila=document.getElementById(xID).rowIndex;

	//alert(oCelda.innerHTML);
	location="Finca_ModiDatos.php?xIDFinca="+oCelda.innerHTML+"&xIDExpe=<?php echo $_GET["xIDExpe"]; ?>";

}
//
//
//
function FilaDesactivarFincas(xID)
{
document.getElementById(xID).style.backgroundColor ="#FFFFFF";
}

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
	location="Clientes.php?xNIF="+oCelda.innerHTML;

}

//
//
//
function FilaDesactivar(xID)
{
document.getElementById(xID).style.backgroundColor ="#FFFFFF";
}

//
// Provision de fondos
//
function VerProvisiones()
{
	var RevisadoGestoras='<? echo $RevisadoGestoras; ?>';
	var MayorCuantia='<? echo $MayorCuantia; ?>';
	var TuDeQuienEres='<? echo $Rol_controlSesiones; ?>';

	if(MayorCuantia=='S' && RevisadoGestoras=='N' && TuDeQuienEres!='2')
	{
		alert('Pendiente de revision Gestoras');
		return;
	}
	
	document.getElementById('VentanaProvisiones').style.visibility='visible';
	LeeConsultaProvi('Todo');
}

function QuitProvision(){
	
	document.getElementById('VentanaProvisiones').style.visibility='hidden';
}

//
//
//
function FilaActivaProvi(xID)
{
	document.getElementById(xID).style.backgroundColor ="#ECF3F5";
}

//
// CAMBIAR LOS IMPORTES DE LAS PROVISIONES DE FONDOS
// Solamente estan autorizados a realizar estos cambios los perfiles de Root,Gerencia y Gestoras
//
function chgProvision(xFila,xIDObjeto)
{
	var idFila="oFilaProvi"+xFila;
	var oCelda=document.getElementById(idFila).cells[0];
	var oValor;
	var campo;
	var TuDeQuienEres='<?php echo $Rol_controlSesiones; ?>';

	if (TuDeQuienEres > 2)
	{
		alert('No puedes cambiar estos datos');
		return;
	}


	//alert(xIDObjeto.substring(0,5));
	if (xIDObjeto.substring(0,5)=='oChgN')
	{
	oValor=document.getElementById(idFila).cells[3];
	campo='<input name="Notaria" type="text" id="Notaria" size="10" maxlength="10" onkeypress="detectar_tecla(event, this.id)" />';
	oValor.innerHTML=campo;
	document.getElementById('Notaria').focus();
	}

	if (xIDObjeto.substring(0,5)=='oChgI')
	{
	oValor=document.getElementById(idFila).cells[4];
	campo='<input name="Impuesto" type="text" id="Impuesto" size="10" maxlength="10" onkeypress="detectar_tecla(event, this.id)" />';
	oValor.innerHTML=campo;
	document.getElementById('Impuesto').focus();
	}
	
	if (xIDObjeto.substring(0,5)=='oChgR')
	{
	oValor=document.getElementById(idFila).cells[5];
	campo='<input name="Registro" type="text" id="Registro" size="10" maxlength="10" onkeypress="detectar_tecla(event, this.id)" />';
	oValor.innerHTML=campo;
	document.getElementById('Registro').focus();
	}
	
	if (xIDObjeto.substring(0,5)=='oChgG')
	{
	oValor=document.getElementById(idFila).cells[6];
	campo='<input name="Gestoria" type="text" id="Gestoria" size="10" maxlength="10" onkeypress="detectar_tecla(event, this.id)" />';
	oValor.innerHTML=campo;
	document.getElementById('Gestoria').focus();
	}
	
	// guardamos ID Asuntos del Expediente en un imput oculto
	document.getElementById("inID").value=oCelda.innerHTML;
	
	
	
}

//
// llamar a quien graba el importe de otras provisiones cuando se pulsa return
//
function CallChgProvision(xIDObjeto)
{

	var xImporte=document.getElementById(xIDObjeto).value;
	var url_parametros="xIDAsunto="+document.getElementById("inID").value+
	"&xImporte="+xImporte+
	"&xConcepto="+xIDObjeto;
	
	//alert(url_parametros);
   	PutDataAsuntos('Redmoon_php/ORACambioManual.php', url_parametros);
	
}

//
//
//
function FilaDesactivarProvi(xID)
{
document.getElementById(xID).style.backgroundColor ="#FFFFCC";
}

//
//Llamar a la consulta adecuada
//
function LeeConsultaProvi(Opcion)
{
	
	var url_parametros='xIDExpe=<?php echo $_GET["xIDExpe"];?>';

	
	//alert(url_parametros);
	PutDataAsuntos('Redmoon_php/serializado_TitularesProvisionFondos.php', url_parametros);
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
// Recibe la respuesta del servidor
//
function ProcRespAsuntos(pageRequest, url){

	
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
			    //alert(StringSerializado);
			    if (url=='Redmoon_php/serializado_TitularesProvisionFondos.php')
			    {
			    	deleteLastRow('oTablaProvi');
			    	AddRowTable();
			    }
		    }

			// Refrescar la pantalla s�lo cuando hay actualizaciones de datos

			
			if (url!='Redmoon_php/serializado_TitularesProvisionFondos.php')
				LeeConsultaProvi('Todo');
			    			

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
	var tbl = document.getElementById('oTablaProvi');
	//var row = tbl.insertRow(tbl.rows.length);

	//alert(StringSerializado);
	//alert(ArrayColumnas.length);
	j=0;
	for(x=0; x<=ArrayColumnas.length-2; x+=8)
	    {
		j++;
				row = tbl.insertRow(tbl.rows.length);
				row.setAttribute('id', 'oFilaProvi'+j);
				//row.setAttribute('onclick', 'GetFilaProvi(this.id);');
				row.setAttribute('onMouseOver', 'FilaActivaProvi(this.id);');
				row.setAttribute('onMouseOut', 'FilaDesactivarProvi(this.id);');
				
			// id
			cellText =  row.insertCell(0);
			textNode = document.createTextNode(tbl.rows.length - 1);
			cellText.appendChild(textNode);
			cellText.setAttribute('style', 'color:#3C4963');
			cellText.innerHTML=ArrayColumnas[0+x];

			// descripcion
			cellText =  row.insertCell(1);
			textNode = document.createTextNode(tbl.rows.length - 1);
			cellText.appendChild(textNode);
			cellText.setAttribute('style', 'color:#3C4963');
			cellText.innerHTML=ArrayColumnas[1+x];
			
			cellText =  row.insertCell(2);
			textNode = document.createTextNode(tbl.rows.length - 1);
			cellText.appendChild(textNode);
			cellText.setAttribute('style', 'color:#3C4963');
			cellText.setAttribute('align', 'right');
			cellText.innerHTML=ArrayColumnas[2+x];
			
			cellText =  row.insertCell(3);
			textNode = document.createTextNode(tbl.rows.length - 1);
			cellText.appendChild(textNode);
			cellText.setAttribute('style', 'color:#3C4963');
			cellText.setAttribute('align', 'right');
			cellText.innerHTML=ArrayColumnas[3+x]+
			'<img src="<?php echo IMAGENES;?>/lapiz3.png" onclick="chgProvision('+j+',this.id)" id="oChgNotaria'+j+'">';
			
			cellText =  row.insertCell(4);
			textNode = document.createTextNode(tbl.rows.length - 1);
			cellText.appendChild(textNode);
			cellText.setAttribute('style', 'color:#3C4963');
			cellText.setAttribute('align', 'right');
			cellText.innerHTML=ArrayColumnas[4+x]+
			'<img src="<?php echo IMAGENES;?>/lapiz3.png" onclick="chgProvision('+j+',this.id)" id="oChgImpuesto'+j+'">';


			cellText =  row.insertCell(5);
			textNode = document.createTextNode(tbl.rows.length - 1);
			cellText.appendChild(textNode);
			cellText.setAttribute('style', 'color:#3C4963');
			cellText.setAttribute('align', 'right');
			cellText.innerHTML=ArrayColumnas[5+x]+
			'<img src="<?php echo IMAGENES;?>/lapiz3.png"  onclick="chgProvision('+j+',this.id)" id="oChgRegistro'+j+'">';

			cellText =  row.insertCell(6);
			textNode = document.createTextNode(tbl.rows.length - 1);
			cellText.appendChild(textNode);
			cellText.setAttribute('style', 'color:#3C4963');
			cellText.setAttribute('align', 'right');
			cellText.innerHTML=ArrayColumnas[6+x]+
			'<img src="<?php echo IMAGENES;?>/lapiz3.png" onclick="chgProvision('+j+',this.id)" id="oChgGestoria'+j+'">';

			cellText =  row.insertCell(7);
			textNode = document.createTextNode(tbl.rows.length - 1);
			cellText.appendChild(textNode);
			cellText.setAttribute('style', 'color:#3C4963');
			cellText.setAttribute('align', 'right');
			cellText.innerHTML=ArrayColumnas[7+x];
			
			
		}

}
//
//tblName
//
function deleteLastRow(tblName)
{
var tbl = document.getElementById(tblName);
//if (tbl.rows.length > 1) tbl.deleteRow(tbl.rows.length - 1);
for(x=(tbl.rows.length-1); x>0; x--)
   tbl.deleteRow(x);
}


//
//
//pulsaci�n de las teclas, cuando se pulsa return se graba el valor
//
function detectar_tecla(e, opcion){

if (window.event)
	tecla=e.keyCode;
else
	tecla=e.which;

//escape
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
	QuitProvision();
	
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
	CallChgProvision(opcion);
	
		
}

//alert(tecla);
}


// ***************************** final de provisiones de fondos

function Home(){
	location="SeguimientoSolicitudes.php";
}
</script>

</head>

<body >
<?php require('cabecera.php'); ?>

<div id="documento">
      <div id="rastro"><a href="MenuLGS.php">Inicio</a> >
           <a href="SeguimientoSolicitudes.php"> B&uacute;squeda de un Expediente</a>
            > Datos del Expediente
</div>
    <div id="ayuda_btn">
		<!--<img src="Redmoon_img/imgDoc/ayuda.png" alt="Ayuda" title="Ayuda" onclick="AbrirAyuda('Gestoria_documentacion/Vista Expediente.html')" />-->
	</div>
<?php 


if($EstadoExpe=='ANUL'){
	echo '<div id="imagen_estado">';
	echo '<img src="'.IMAGENES.'/trash.png" alt="Anulado" title="Anulado">';
	echo '</div>';
}
if($EstadoExpe=='CLOS'){
	echo '<div id="imagen_estado">';
	echo '<img src="'.IMAGENES.'/lock.png" alt="Cerrado" title="Cerrado">';
	echo '</div>';
}
if($EstadoExpe=='DEBE' || $MayorCuantia=='S'){
	echo '<div id="imagen_alert">';
	echo '<img src="'.IMAGENES.'/Warning.png">';
	echo '</div>';
}
if($EstadoExpe=='OPEN' || $row['ESTADO']=='APRO' || $row['ESTADO']=='PROV' || $row['ESTADO']=='PFAC'){
	echo '<div id="imagen_estado">';
	echo '<img src="'.IMAGENES.'/percent.png">';
	echo '</div>';
}


?>
<input type="hidden" name="xTAsunto" id="inTAsunto" value="<?php echo $tipo_asunto_VALUE; ?>"/>

<div id="busqueda"> 
<label class="Estilo2" id="lbnif" onclick="CallSegui(this.id);">Seguimiento</label>
<label class="Estilo2" id="lbnif" onclick="CallAsuntos();">Gesti&oacute;n de Asuntos</label>
<label class="Estilo2" id="lbnif" onclick="CallFincas();">Crear Finca</label>
<label class="Estilo2" id="lbnif" onclick="CallAprueba();">Aprobaci&oacute;n del Pr&eacute;stamo</label>
</div>

<div id="NumeroExpe" class="recuadroProvision" >
    <p><?php echo $donde; ?></p>
    <p >
        <label >N&uacute;mero de expediente:</label><strong> <?php echo $_GET["xIDExpe"];?> </strong>
    </p>
    <p style="cursor:url;">
    
        <label class=" Estilo4" >Importe Provision Fondos:</label> <strong><?php echo $ImporteProvision; ?></strong>
    </p>
</div>

<div id="pdf">
<img src="Redmoon_img/imgDoc/PDF.png"  alt="Imprimir" title="Imprimir Solicitud" align="middle" longdesc="Imprimir solicitud" onclick="CallPrintProvision();"  />
</div>
<div id="VentanaTablaFincas">
<label class="Estilo2">Fincas Objeto de la Operaci&oacute;n<?php echo ' '.$tipo_asunto.' '.$NumFincas; ?></label>
<table width="750" border="0" id="oTablaFincas">
  <tr bgcolor="#C6DFEC" id="oTablaFincas0" style="color:#3C4963; cursor:default">
  <td width="10%"><strong>ID</strong></td>
    <td width="50%"><strong>Calle</strong></td>
    <td width="25%"><strong>Municipio</strong></td>
    <td width="25%"><strong>Registro</strong></td>
  </tr>
  <?php
  
  $x=1;
  while ($row = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		echo '<tr bgcolor="#FFFFFF" id="oFilaFincas'.$x.'" onclick="GetFilaFincas(this.id);" onMouseOver="FilaActivaFincas(this.id);" onMouseOut="FilaDesactivarFincas(this.id);">';
		foreach ($row as $key =>$field) 
			{
			$field = htmlspecialchars($field, ENT_NOQUOTES);
			echo "<td>".$field."</td>\n";
			}
		echo "</tr>\n";
		$x++;
	}
	
	?>
</table>
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
<div id="VentanaTabla">
<h4 class="Estilo2">Titulares y avalistas</h4>
<table width="750" border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oFila0" style="color:#3C4963; cursor:default">
    <td width="10%"><strong>NE</strong></td>
    <td width="10%"><strong>NIF</strong></td>
    <td width="50%"><strong>Nombre</strong></td>
    <td width="10%"><strong>M&oacute;vil</strong></td>
    <td width="10%"><strong>Tel&eacute;fono</strong></td>
  </tr>
  <?php
  
  $x=1;
  while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		echo '<tr bgcolor="#FFFFFF" id="oFila'.$x.'" onclick="GetFila(this.id);" onMouseOver="FilaActiva(this.id);" onMouseOut="FilaDesactivar(this.id);">';
		foreach ($row as $key =>$field) 
			{
			//$field = iconv('Windows-1252', 'UTF-8//TRANSLIT', $field);			  
			echo "<td>".$field."</td>\n";
			}
		echo "</tr>\n";
		$x++;
	}
	
	?>
</table>
</div>



<div id="VentanaProvisiones">
	<div id="winPop">
    <p><img src="<?php echo IMAGENES;?>/imgDoc/cancelar.png" alt="salir"  longdesc="salir" onclick="QuitProvision()" />
    <label>Provisiones de fondos</label>
    </p>
    <table width="750" border="0" id="oTablaProvi">
  <tr bgcolor="#C6DFEC" id="oFilaProvi0" style="color:#3C4963; cursor:default">
  <td width="7%"><strong>ID</strong></td>
    <td width="32%"><strong>Concepto</strong></td>
    <td width="11%" align="center" ><strong>Cuant&iacute;a</strong></td>
    <td width="10%" align="center" ><strong>Notar&iacute;a</strong></td>
    <td width="12%" align="center" ><strong>Impuesto</strong></td>
    <td width="10%" align="center" ><strong>Registro</strong></td>
    <td width="9%" align="center" ><strong>Gestor&iacute;a</strong></td>
    <td width="14%" align="right" ><strong>Total provisi&oacute;n</strong></td>
  </tr>
</table>
<?php
if ($Rol_controlSesiones==2)
{ 
echo '<p>';
echo '<img src="'.IMAGENES.'/aceptar2.png" alt="revisar"  longdesc="se da por revisado el expediente" onclick="ExpedienteRevisado()" style="position:absolute;top:35px;left:305px;" />';
echo '<label style="position:absolute;top:48px;left:350px;">';
echo 'Dar por revisado el expediente';
echo '</label>';
echo '</p>';
}
?>
<input type="hidden" name="xID" id="inID" />  
</div>  
</div>
<?php require('Redmoon_php/cargando.inc'); ?>
</div>
</body>
</html>