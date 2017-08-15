<?php

require_once('Redmoon_php/controlSesiones.inc.php');
require_once('Redmoon_php/pebi_cn.inc.php');
require_once('Redmoon_php/pebi_db.inc.php');
// Create a database connection

$conn = db_connect();

$sql='SELECT e.oficina,c.nombre,e.tipo_asunto,e.estado from expedientes e, colaboradores c where e.colaborador=c.id and e.NE=:xIDExpe';
$stid2 = oci_parse($conn, $sql);
$xIDExpe = $_GET["xIDExpe"];
oci_bind_by_name($stid2, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);

$r = oci_execute($stid2, OCI_DEFAULT);

$row = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS);

$oficina=$row['OFICINA'];
$gestor=$row['NOMBRE'];
$estado=$row['ESTADO'];

if ($row['TIPO_ASUNTO']==1 or $row['TIPO_ASUNTO']==null)
	$tipo_asunto='Hipotecario';
else 
	$tipo_asunto='Dacion';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Historia del Expediente</title>
<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/SeguiExpeConsulta.js" type="text/javascript"></script>
<script src="Redmoon_js/comAJAX.js" type="text/javascript"></script>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

<script type="text/javascript">

var StringSerializado="";

function HacerBusqueda()
{
	LeeConsulta('Todo');
}
function addNotaVoz(){

	
window.open('notaVoz/Microfono.php?IDExpe=<?php echo $xIDExpe; ?>',
			'Nota de Voz','left=250, height=300,width=592,toolbar=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,modal=yes');
	
}
//
//Llamar a la consulta adecuada
//
function LeeConsulta()
{
	
	var url_parametros='xIDExpe='+<?php echo $xIDExpe; ?>;

	
	//alert(url_parametros);
	PutDataAsuntos('Redmoon_php/serializado_SeguiExpeConsulta.php', url_parametros);
}

//
// A�adir un cargo no presupuestado inicialmente y pagado por nuestro colaborador de su bolsillo.
//
function AddCargo()
{
	var comentario = document.getElementById("Servicio").value;
	var importe = 	document.getElementById("ImporteServicio").value;
	var url_parametros='xIDExpe='+<?php echo $xIDExpe; ?>+'&xComent='+comentario+'&xImporte='+importe;

	
	//alert(url_parametros);
	PutDataAsuntos('Redmoon_php/ORASeguiExpeAddCargo.php', url_parametros);
}


function PutMenu()
{
	AreaDiv = document.getElementById("AddMovSeguimiento");
	AreaDiv.style.visibility='visible';
	AreaDiv.style.top='50px';

}

function PutMultimedia()
{
	AreaDiv = document.getElementById("ComentAdjMultimedia");
	AreaDiv.style.visibility='visible';
	AreaDiv.style.top='50px';

}

//
// Procedimiento que a�ade un comentario
//
function AddComent(){

	var xComent=document.getElementById("Comentario").value;
	var dataToSend='xIDExpe='+<?php echo $_GET["xIDExpe"];?>+"&xComent="+xComent;
	
	QuitMultimedia();

	//alert(dataToSend);
	
	// grabar los datos en oracle via ajax
	CallRemote('Redmoon_php/ORASeguiExpeAddComent.php',dataToSend);
}

//
//
//
function PutProvision()
{
	AreaDiv = document.getElementById("ProvisionAdd");
	AreaDiv.style.visibility='visible';
	AreaDiv.style.top='50px';

}

function PutGasto()
{
	AreaDiv = document.getElementById("ServicioAdd");
	AreaDiv.style.visibility='visible';
	AreaDiv.style.top='50px';

}


function QuitMenu()
{
	AreaDiv = document.getElementById("AddMovSeguimiento");
	AreaDiv.style.visibility='hidden';

}

function QuitMultimedia()
{
	AreaDiv = document.getElementById("ComentAdjMultimedia");
	AreaDiv.style.visibility='hidden';

}
function QuitProvision()
{
	AreaDiv = document.getElementById("ProvisionAdd");
	AreaDiv.style.visibility='hidden';

}
function QuitGasto()
{
	AreaDiv = document.getElementById("ServicioAdd");
	AreaDiv.style.visibility='hidden';

}
function QuitCola()
{
	AreaDiv = document.getElementById("VentanaColabora");
	AreaDiv.style.visibility='hidden';

}

// abir una ventana modal
function modalWin() {
	
/*	if (window.showModalDialog) {
		MiWin=window.showModalDialog('SeguiExpeConsultaMultimedia.php','SubirFile','dialogWidth:510px;dialogHeight:250px');
	} else {
		MiWin=window.open('SeguiExpeConsultaMultimedia.php','SubirFile','height=510,width=250,toolbar=no,directories=no,status=no,continued from previous linemenubar=no,scrollbars=no,resizable=no ,modal=yes');
	}*/

	MiWin=window.open('SeguiExpeConsultaMultimedia.php?xIDExpe=<?php echo $xIDExpe; ?>',
			'SubirFile','left=250, height=250,width=550,toolbar=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,modal=yes');
	
}
//
// Llamar a las opciones del menu
//
function MenuAcciones(Opcion)
{
	if (Opcion=='multimedia')
	{
		QuitMenu();
		//frames.open('http://www.gialnet.com','prueba');
		modalWin(); 
		//PutMultimedia();
		
	}
	
	if (Opcion=='provision')
	{
		QuitMenu();
		PutProvision();
		
	}
	if (Opcion=='gasto')
	{
		QuitMenu();
		PutGasto();
		
	}
	
}


// para ventana de colaboradores
function FilaActivaCola(xID)
{
	document.getElementById(xID).style.backgroundColor ="#ECF3F5";
}
function FilaDesactivarCola(xID)
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
	var oCelda=document.getElementById(xID).cells[0];
	var oDoc=document.getElementById(xID).cells[6];
	//var fila=document.getElementById(xID).rowIndex;

	//alert(oDoc.innerHTML);
	
	if (oDoc.innerHTML!='') 
	   location="SeguiExpeDocs.php?xIDExpe="+oCelda.innerHTML;
	   
	//location="Notarios.php?xIDNotario="+oCelda.innerHTML;
	//alert(oCelda.innerHTML);
	

}
function GetFilaCola(xID)
{
	var oCelda=document.getElementById(xID).cells[0];
	//var oDoc=document.getElementById(xID).cells[6];
	//var fila=document.getElementById(xID).rowIndex;

	//alert(oDoc.innerHTML);
	var IdExpe='&xIDExpe='+"<?php echo $_GET["xIDExpe"];?>";
	
	location="Redmoon_php/ORAModColaboradorExpediente.php?xIDColabora="+oCelda.innerHTML+IdExpe;
	   
	//location="Notarios.php?xIDNotario="+oCelda.innerHTML;
	//alert(oCelda.innerHTML);
	

}

//
//
//
function FilaDesactivar(xID)
{
	document.getElementById(xID).style.backgroundColor ="#FFFFFF";
}
//
// Cambiar el colaborador asociado al expediente
//
function chgColabora()
{
	var AreaDiv = document.getElementById("VentanaColabora").style.visibility='visible';
	
}
//
// Volver a la vista anterior
//
function GotoHome()
{
	location="MenuTitulares.php?xIDExpe="+<?php echo $_GET["xIDExpe"]; ?>;
}

/* *********************************************************
	Las ayudas desactivadas por el momento
//
//
//
function AyudaTlf(event){

	AreaDiv = document.getElementById("AyudaTlf");

	AreaDiv.style.visibility='visible';
}
function SalirAyudaTlf(){
	AreaDiv = document.getElementById("AyudaTlf");
	AreaDiv.style.visibility='hidden';
}

function AyudaCola(event){

	AreaDiv = document.getElementById("AyudaCola");

	AreaDiv.style.visibility='visible';
}
function SalirAyudaCola(){
	AreaDiv = document.getElementById("AyudaCola");
	AreaDiv.style.visibility='hidden';
}

//
//
//
function AyudaCambiar(event){

	AreaDiv = document.getElementById("AyudaCambiar");

	AreaDiv.style.visibility='visible';
}
function SalirAyudaCambiar(){
	AreaDiv = document.getElementById("AyudaCambiar");
	AreaDiv.style.visibility='hidden';
}

********************************************* */

function CrearPDF(){
	var xID=<?php echo  $_GET["xIDExpe"]; ?>;
	//alert(xID);
	//location='seguimiento.php?xIDExpe='+xID;
	var url='seguimiento.php?xIDExpe='+xID;
	window.open(url);
}


</script>

<style type="text/css">
#AddMovSeguimiento{
	position:absolute;
	top:50px;
	left:120px;
	
	visibility:hidden;

}
#ComentAdjMultimedia{
	position:absolute;
	top:50px;
	left:80px;
	height: 250px;
	width: 588px;
	
	margin:15px 15px;
	padding:15px 25px;
	
	border:solid 8px;
	border-color:#ebebeb;
	background-color: #FFFFCC;
	visibility:hidden;
}
#ProvisionAdd
{
	position:absolute;
	top:50px;
	left:150px;
	width:550px;
	visibility:hidden;
}
#ServicioAdd
{
	position:absolute;
	top:50px;
	left:140px;
	width:500px;
	visibility:hidden;
}

#Titulo{
text-align:center;
font-size:16px;
color:#36679f;
font-weight: bold;
}

#VentanaColabora{
	position:absolute;
	top:25px;
	left: 170px;
	
        z-index:10;
	visibility: hidden;
}


#imagen_logo{
position: absolute;
top:15px;
left:1px;
}



#VentanaTabla{ 
	position:absolute;
	top:200px;
	left:20px;
	width:780px;
	height:1000px;
	overflow:auto;
	cursor:pointer;
}
TD.Numeros{
	text-align:right;
}
.Estilo1 {
	color: #3c4963;
	font-weight: bold;
        cursor: pointer;
}
.Estilo2 {
	color: #36679f;
	font-weight: bold;
}
#oficina{
position:absolute;
top:140px;
left:30px;
}
#colaborador{
position:absolute;
top:140px;
left:210px;
}
#AyudaCola{
position:absolute;
	top:130px;
	left:320px;
	visibility:hidden;
	z-index:1;
	visibility:hidden;
}
#AyudaTlf{

	position:absolute;
	top:130px;
	left:140px;
	visibility:hidden;
	z-index:1;
	visibility:hidden;
}
#AyudaCambiar{
position:absolute;
	top:130px;
	left:340px;
	visibility:hidden;
	z-index:1;
	visibility:hidden;
}
#TextoAyuda{
	position:absolute;
	top:90px;
	left:20px;
	margin-right:20px;

}


#btnNotaVoz{
position:absolute;
top:20px;
left:670px;
}
#datos{
    position:absolute;
    top:60px;
    left:140px;
}
</style>

</head>

<body  onload="HacerBusqueda()">

<?php require('cabecera.php'); ?>


<div id="documento">
    <div id="ayuda_btn">
		<!--<img src="Redmoon_img/imgDoc/ayuda.png" alt="Ayuda" title="Ayuda" onclick="AbrirAyuda('Gestoria_documentacion/Seguimiento.html')" />-->
</div>
    <div id="rastro"><a href="MenuLGS.php">Inicio</a> >
           <a href="SeguimientoSolicitudes.php"> B&uacute;squeda de un Expediente</a> >
             <a href="MenuTitulares.php?xIDExpe=<?php echo $xIDExpe; ?>"> Datos del Expediente</a>
            > Seguimiento del Expediente
</div>
<br />

<div id="pdf" onclick="CrearPDF()"><img title="Exportar a PDF" alt="Exportar a PDF" src="Redmoon_img/imgDoc/PDF.png" /><span class="Estilo1"> </span></div>

<div id="btnNotaVoz" >
<img onclick="addNotaVoz()" title="Nueva Nota de Voz" alt="Nueva Nota de Voz" src="Redmoon_img/imgDoc/coment.png" />
</div>

<!--

<div id="AyudaTlf">
<img src="Redmoon_img/fondo_ayuda2.png"/>
<div id="TextoAyuda">
<img src="<?php echo IMAGENES;?>/tlf_oficina.png"/>
<span class="Estilo5">Para llamar a la oficina pulse este icono.</span>
</div>
</div>

<div id="AyudaCola">
<img src="Redmoon_img/fondo_ayuda2.png"/>
<div id="TextoAyuda">
<img src="<?php echo IMAGENES;?>/tlf_colabora.png"/>
<span class="Estilo5">Para llamar a el colaborador pulse este icono.</span>
</div>
</div>

<div id="AyudaCambiar">
<img src="Redmoon_img/fondo_ayuda3.png"/>
<div id="TextoAyuda">
<img src="<?php echo IMAGENES;?>/cambiar2.png"/>
<span class="Estilo5">Para cambiar de colaborador pulse este icono.</span>
</div>
</div>
-->




<h4 align="center" class="Estilo1">Seguimiento del Expediente<?php echo ' '.$tipo_asunto.': '.$xIDExpe; ?></h4>

<h5 class="Estilo2" id="laColabora" align="center" ></h5>

<div id="datos" class="recuadroProvision">
    Oficina<b><?php echo ': '.$oficina; ?></b>
        <br />
        Colaborador<b><?php echo ': '.$gestor; ?></b>
</div>
<div id="oficina" >
<!--
<img src="<?php echo IMAGENES;?>/tlf_oficina.png" alt="salir"  align="middle" onmouseover="AyudaTlf()" onmouseout="SalirAyudaTlf()" onclick="alert('Llamada a la Oficina, Sistema de Telefonia desconectado')"> OFICINA<?php echo ': '.$oficina; ?>
-->
<img src="Redmoon_img/imgDoc/llamarOficina.png" title="Llamar a la oficina" alt="Llamar a la Oficina"  align="middle" onclick="alert('Llamada a la Oficina, Sistema de Telefonia desconectado')" /> 
<img alt="Llamar al Colaborador" title="Llamar al Colaborador" src="Redmoon_img/imgDoc/llamarColaborador.png"  align="middle" onclick="alert('Llamada al Colaborador, Sistema de Telefonia desconectado')"/> 
<img src="Redmoon_img/imgDoc/cambiar.png" alt="Cambiar de Colaborador" title="Cambiar Colaborador"  align="middle" onmouseover="AyudaCambiar()" onmouseout="SalirAyudaCambiar()" onclick="chgColabora()" />

</div>
<div id="colaborador">
<!--
<img src="<?php echo IMAGENES;?>/tlf_colabora.png" alt="salir"  align="middle" onmouseover="AyudaCola()" onmouseout="SalirAyudaCola()" onclick="alert('Llamada al Colaborador, Sistema de Telefonia desconectado')"> COLABORADOR<?php echo ': '.$gestor; ?>
-->
<!--
<img src="<?php echo IMAGENES;?>/cambiar2.png" alt="cambiar"  align="middle" onmouseover="AyudaCambiar()" onmouseout="SalirAyudaCambiar()" onclick="chgColabora()" >
-->
</div>


<div id="imagen_logo">

<?php 

echo '<div id="imagen_estado">';
if($estado=='ANUL')
	echo '<img src="'.IMAGENES.'/trash.png">';	

if($estado=='CLOS')
	echo '<img src="'.IMAGENES.'/lock.png">';

if($estado=='DEBE')
	echo '<img src="'.IMAGENES.'/Warning.png" onclick="PutMenu()">';
	
if($estado=='OPEN' || $row['ESTADO']=='APRO' || $row['ESTADO']=='PROV' || $row['ESTADO']=='PFAC')
	echo '<img src="'.IMAGENES.'/percent.png" onclick="PutMenu()">';
	

echo '</div>';

?>

</div>

<div id="VentanaTabla">
<table width="750" border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oFila0" style="color:#3C4963; cursor:default">
    <td width="8%"><strong>ID</strong></td>
    <td width="25%"><strong>Estado</strong></td>
    <td width="39%"><strong>Descripci&oacute;n</strong></td>
    <td width="8%"><strong>Fecha</strong></td>
    <td width="10%"><strong>Importe</strong></td>
    <td width="5%"><strong>Tipo</strong></td>
    <td width="5%"><strong>DOC</strong></td>
  </tr>
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



<div id="AddMovSeguimiento">
    <div id="winPop" >
    <p><img src="<?php echo IMAGENES;?>/imgDoc/cancelar.png" alt="salir"  align="texttop" longdesc="salir" onclick="QuitMenu();" />
    </p>
        <div align="center" id="Titulo">Menú Actualizar Seguimiento Expediente</div>
    <ul>
      <li>
      <span onclick="MenuAcciones('multimedia')" class="Estilo1">Comentario adjunto multimedia: conversación teléfonica
, vídeo, pdf, etc. </span></li>
        <br />
      <li><span onclick="MenuAcciones('provision')"  class="Estilo1"> Provisión de fondos adicional</span></li>
        <br />
      <li><span onclick="MenuAcciones('gasto')"  class="Estilo1">Servicio adicional, no incluido en el presupuesto inicial</span></li>
    </ul>
    <label></label>
</div>
</div>


<div id="ComentAdjMultimedia">
  <p><img src="<?php echo IMAGENES;?>/imgDoc/cancelar.png" alt="salir"  align="texttop" longdesc="salir" onclick="QuitMultimedia()" />
  <div align="center" id="Titulo">Anotaci&oacute;n (y/o) Adjuntar Archivo Multimedia</div>
    </p>
    <p class="Estilo1">
      Descripción
        <input name="Comentario" type="text" id="Comentario" size="50" maxlength="50" />
        <br />
         <br />
      Fichero adjunto
    <input type="file" name="FicheroAdjunto" id="FicheroAdjunto" />
    <br />
    <input type="image" onclick="AddComent()" name="EnviarComet" id="EnviarComet" value="Enviar" src="<?php echo IMAGENES;?>/imgDoc/aceptar.png"/>
  </p>
  <p>&nbsp;</p>
</div>



<div id="ProvisionAdd">
    <div id="winPop" >
  <p><img src="<?php echo IMAGENES;?>/imgDoc/cancelar.png" alt="salir"  align="texttop" longdesc="salir" onclick="QuitProvision()" />
  </p>
      <div align="center" id="Titulo">
    Provisión de fondos adicional</div>
    <p class="Estilo1">
<form action="" method="post" enctype="multipart/form-data" name="form2" id="form2">
      Descripción
        <input style="position:absolute; left:120px" name="Texto" type="text" id="Texto" size="50" maxlength="50" />
        <br />
         <br />
      Importe
      <input style="position:absolute; left:120px" name="ImporteProvision" type="text" id="ImporteProvision" size="10" maxlength="10" />
       <br />
        <br />
       Número Cuenta 
       <input style="position:absolute; left:120px" name="ncuenta" type="text" id="ncuenta" size="20" maxlength="20" />
       <br />
       <p align="right">
      <input type="image" align="middle" name="Enviar" onclick="" id="Enviar" value="Enviar" src="<?php echo IMAGENES;?>/imgDoc/aceptar.png"/>
  </p>
      </form>
    </p>
    </div>
</div>
<div id="ServicioAdd">
    <div id="winPop">
  <p><img src="<?php echo IMAGENES;?>/imgDoc/cancelar.png" alt="salir"  align="texttop" longdesc="salir" onclick="QuitGasto()" />
  <div align="center" id="Titulo">Servicio adicional, no incluido en el presupuesto inicial</div>
    </p>
    <p class="Estilo1">
      Descripción
        <input style="position:absolute; left:120px" name="Servicio" type="text" id="Servicio" size="50" maxlength="50" />
        <br />
         <br />
      Importe
      <input style="position:absolute; left:120px" name="ImporteServicio" type="text" id="ImporteServicio" size="10" maxlength="10" />
       <br />
       <br /><p align="right">
      <input type="image" name="Enviar" id="Enviar" value="Grabar" onclick="AddCargo()" src="<?php echo IMAGENES;?>/imgDoc/aceptar.png"/>
      </p>
    </p>
        </div>
</div>

<div id="VentanaColabora" >
     <div id="winPop">
  <p><img src="<?php echo IMAGENES;?>/imgDoc/cancelar.png" alt="salir" title="Salir"  align="texttop" longdesc="salir" onclick="QuitCola()" />
  <div align="center" id="Titulo">Nuevo Colaborador</div>
    </p>
    <p>
<table width="390" border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oTFila0" style="color:#3C4963; cursor:default">
    <td width="10%"><strong>ID</strong></td>
    <td width="90%"><strong>Nombre</strong></td>
  </tr>
  <?php

    // ******************************************************************************************
    // esta consulta est� mal
	$sql = "select G.gestor,C.NOMBRE from oficinas_gestores G, colaboradores C where g.oficina=:xOficina AND g.gestor=c.ID";
	
	$stid7 = oci_parse($conn, $sql);
	
	oci_bind_by_name($stid7, ':xOficina', $oficina, 4, SQLT_CHR);
	
	$r = oci_execute($stid7, OCI_DEFAULT);
	  
  $x=1;
  while ($row = oci_fetch_array($stid7, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		echo '<tr bgcolor="#FFFFFF" id="oFila'.$x.'" onclick="GetFilaCola(this.id);" onMouseOver="FilaActivaCola(this.id);" onMouseOut="FilaDesactivarCola(this.id);">';
		//echo '<tr bgcolor="#FFFFFF" id="oTFila'.$x.'" onMouseOver="FilaActivaCola(this.id);" onMouseOut="FilaDesactivarCola(this.id);">';
		foreach ($row as $key =>$field) 
			{
			echo "<td>".$field."</td>\n";
			}
		echo "</tr>\n";
		$x++;
	}
	
	?>
</table>
</p>
   </div>
</div>
</div>
</body>
</html>
