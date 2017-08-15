<?php

require_once('Redmoon_php/controlSesiones.inc.php');
require_once('Redmoon_php/pebi_cn.inc.php');
require_once('Redmoon_php/pebi_db.inc.php');


$conn = db_connect();
if(isset($_GET["Mod"]))
{

	// datos almacenados
	$sql3 = 'Select Observaciones from Expedientes where NE=:xIDExpe';
	$stid3 = oci_parse($conn, $sql3);   
	oci_bind_by_name($stid3, ':xIDExpe', $xIDExpe, 38, SQLT_INT);
	$xIDExpe= (int)$_GET["xIDExpe"];
	$r = oci_execute($stid3, OCI_DEFAULT);
	
	// datos almacenados
	$sql2 = 'select a.CODIGO_ASUNTO, a.OPR_IMPORTE, b.DESCRIPCION from asuntos_expediente a, Actos_Asuntos b where  a.codigo_asunto= b.id and ne=:xIDExpe and b.id in (select codigo_asunto from asuntos_expediente where ne=:xIDExpe)';
	$stid2 = oci_parse($conn, $sql2);   
	oci_bind_by_name($stid2, ':xIDExpe', $xIDExpe, 38, SQLT_INT);
	$xIDExpe= (int)$_GET["xIDExpe"];
	$r = oci_execute($stid2, OCI_DEFAULT);
	
	$sql = 'select id, descripcion from actos_asuntos where tipo_asunto=2 and id not in (select CODIGO_ASUNTO from asuntos_expediente where ne=:xIDExpe)';
	$stid = oci_parse($conn, $sql);   
	oci_bind_by_name($stid, ':xIDExpe', $xIDExpe, 38, SQLT_INT);
	$xIDExpe= (int)$_GET["xIDExpe"];
   
}
else
{
  	$sql = 'select id, descripcion from actos_asuntos where tipo_asunto=2';
	$stid = oci_parse($conn, $sql);
}

$r = oci_execute($stid, OCI_DEFAULT);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Asuntos Dacion</title>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>
<style type="text/css">

#PrimeraColumna{
	position:absolute;
	top:118px;
	left:63px;
	right:100px;
	bottom:300px;
	height: 280px;
	width: 304px;
	border:solid 1px;
	padding: 15px;
	text-align:right;
}

#SegundaColumna{
	position:absolute;
	top:120px;
	left:412px;
	right:100px;
	bottom:300px;
	height: 278px;
	width: 310px;
	border:solid 1px;
	padding: 15px;
	text-align:right;
}

#PieDatos{
	position:absolute;
	top:500px;
	left:10px;
	right:100px;
	bottom:300px;
	height: 100px;
	width: 664px;
	background-color: #FFFFCC;
	padding: 15px 15px;

}

.EtiquetaInput {
	font-family: "Times New Roman", Times, serif;
	font-size: medium;
	font-style: normal;
	background-color: #FFFF99;
	margin: 10px;
	border:10px;
	padding:10px;
	height: 23px;
	width: 500px;
	position:absolute;
	top:50px;
	left:340px;
	text-align: right;
}
#AreaVisible{
	position: absolute;
	overflow:auto;
	left: 20%;
	width: 150px;
	height: 150px;
	border:solid 1px;
}

</style>
<script type="text/javascript">

num=0;
// maximo nÃºmero de elementos insertados, nos permite controlar el borrado y poder reposicionar los objetos div
// en pantalla
maximo=0;
Opciones = new Array();
ValoresOpc = new Array();
//
// Para la opción de modificaciones
//
function CrearModifica(xID, xValue, xTexto) {

	  num++;
	  if(num>maximo)
	    maximo=num;

	  Etiqueta=xID;
	  ValorEtiqueta=xTexto;
	  
	  // quitar la opcion seleccionada
	  //alert(oSelect.selectedIndex);
	  ValoresOpc[num]=xID;
	  Opciones[num]=new Option( xTexto, xID);
		
	  fi = document.getElementById('form1'); // 1
	  contenedor = document.createElement('div'); // 2
	  contenedor.id ='div-'+num; // 'EtiquetaInput'; // 3

	  contenedor.className='EtiquetaInput';

	  // 25 punto de inicio en pantalla
	  contenedor.style.top=(25+(num*33))+'px';
	  fi.appendChild(contenedor); // 4

	  ele = document.createElement('label'); // 5
	  ele.name = 'label'+num;
	  ele.innerHTML = xID+'-'+xTexto; // 6
	  contenedor.appendChild(ele); // 7

	  ele = document.createElement('input'); // 5
	  ele.type = 'text'; // 6
	  ele.name = 'fil'+num; // 6
	  ele.value = xValue;
	  ele.size=10;
	  ele.id = 'input'+num;
	  ele.style.textAlign='right';
	  contenedor.appendChild(ele); // 7
	  
	  ele = document.createElement('input'); // 5
	  ele.type = 'button'; // 6
	  ele.value = 'Borrar'; // 8
	  ele.name = 'div-'+num; // 8
	  ele.onclick = function () {borrar(this.name)} // 9
	  contenedor.appendChild(ele); // 7
	}

//
//
//
function Crear(obj) {

  num++;
  if(num>maximo)
    maximo=num;

  oSelect=document.getElementById('ListaAsuntos');
  Etiqueta=oSelect.value; //options[selectedIndex]
  ValorEtiqueta=oSelect.options[oSelect.selectedIndex].innerHTML;
  
  // quitar la opcion seleccionada
  //alert(oSelect.selectedIndex);
  ValoresOpc[num]=Etiqueta;
  Opciones[num]=oSelect.options[oSelect.selectedIndex];
  oSelect.remove(oSelect.selectedIndex);
	
  fi = document.getElementById('form1'); // 1
  contenedor = document.createElement('div'); // 2
  contenedor.id ='div-'+num; // 'EtiquetaInput'; // 3

  contenedor.className='EtiquetaInput';

  // 25 punto de inicio en pantalla
  contenedor.style.top=(25+(num*33))+'px';
  fi.appendChild(contenedor); // 4

  ele = document.createElement('label'); // 5
  ele.name = 'label'+num;
  ele.innerHTML = Etiqueta+'-'+ValorEtiqueta; // 6
  contenedor.appendChild(ele); // 7

  ele = document.createElement('input'); // 5
  ele.type = 'text'; // 6
  ele.name = 'fil'+num; // 6
  ele.size=10;
  ele.id = 'input'+num;
  ele.style.textAlign='right';
  contenedor.appendChild(ele); // 7
  
  ele = document.createElement('input'); // 5
  ele.type = 'button'; // 6
  ele.value = 'Borrar'; // 8
  ele.name = 'div-'+num; // 8
  ele.onclick = function () {borrar(this.name)} // 9
  contenedor.appendChild(ele); // 7
}
//
//
//
function borrar(obj) {
	
  var ArrayValores=obj.split('-');
  var indice=parseInt(ArrayValores[1]);

    //alert(indice);
  // restablece los valores de ListaAsuntos
  oSelect=document.getElementById('ListaAsuntos');
  oSelect.options.add(Opciones[indice]);
  oSelect.value=ValoresOpc[indice];
  
  // elimina un elemento del array a partir de indice
  Opciones.splice(indice,1);
  ValoresOpc.splice(indice,1);
  
  fi = document.getElementById('form1'); // 1 
  fi.removeChild(document.getElementById(obj)); // 10
  num--;  
  Reposicionar();
  

}
//
// Tras borrar reposicionar los div en pantalla
//
function Reposicionar()
{
var xTop=1;

// buscar todos los div del formulario
for(x=1; x<=maximo; x++)
    {
	 if (document.getElementById('div-'+x))
	     {
	     // 25 posicion en pantalla 
		 document.getElementById('div-'+x).style.top=(25+(xTop*33))+'px';
		 xTop++;		 
		 //alert(document.getElementById('div'+x).style.top);
		 }
	}
// cambiar sus posiciones top
}
//
//
//
function GrabarAsuntosExpe()
{
	var ListaIDs='&';

	var xExpe="xIDExpe=<?php echo $_GET["xIDExpe"]; ?>";
	var url_parametros=xExpe+'&Observaciones='+document.getElementById('Observaciones').value;
	//alert(CamposFijos);
	
	// Lista de campos seleccionados por el usuario
	for(j=1; j<=num; j++)
	{
	CampoInput='input'+j;
	if(document.getElementById(CampoInput))
	  {
		ListaIDs+='ID-'+ValoresOpc[j]+'='+document.getElementById(CampoInput).value+'&';
	  }
	}
	//alert(ListaIDs);
	url_parametros+=ListaIDs;
	//alert(url_parametros);
	PutDataAsuntos('Redmoon_php/addAsuntosExpeDacion.php', url_parametros);
}
//
//Leer datos de Oracle vía Ajax y PHP
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
		pageRequest.open('GET',url,true)
		pageRequest.send(null)	
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
			if (pageRequest.responseText=='Error')
				alert(pageRequest.responseText);

	    	if (pageRequest.responseText=='Ok')
				location="MenuTitulares.php?xIDExpe="+<?php echo $_GET["xIDExpe"]; ?>;

	    	
		}
	}
	else return;
}
//
// Asignar el numero de expediente y poner en pantalla los datos en caso de modificacion
//
function LeeExpediente()
{

	// Asuntos del Expediente
	<?php 
	$ListaValores="";
	$suma='"';
    while ($row = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS)) {
    	$codificada = iconv('Windows-1252', 'UTF-8//TRANSLIT',$row['DESCRIPCION']);
    	$ListaValores=$row['CODIGO_ASUNTO'].'@'.$row['OPR_IMPORTE'].'@'.$codificada.'@';
    	$suma=$suma.$ListaValores;
    	}
    	print 'var ListaValores='.$suma.'";';
	?>
	
	ArrayValores=ListaValores.split('@');
	if(ArrayValores.length>=3)
		for(x=0; x<=ArrayValores.length-1; x+=3)
		{
			if(ArrayValores[2+x])
			  CrearModifica(ArrayValores[0+x], ArrayValores[1+x], ArrayValores[2+x]);
			
		}

	// Datos del Expediente
	<?php 
	$DatosExpe="";
	$suma='"';
    while ($row = oci_fetch_array($stid3, OCI_ASSOC+OCI_RETURN_NULLS)) {
    	$codificada = iconv ('Windows-1252', 'UTF-8//TRANSLIT',$row['OBSERVACIONES']);
    	$DatosExpe=$codificada.'@';
    	$suma=$suma.$DatosExpe;
    	}
    	print 'var DatosExpe='.$suma.'";';
	?>
	ArrayDatosExpe=DatosExpe.split('@');
	
	// siempre hay valor de mas nulo
	if (ArrayDatosExpe[0]!=null)
		document.getElementById("Observaciones").value=ArrayDatosExpe[0];
	
	//alert(ArrayValores.length);
	if(location.search)
	{
		ArrayParametros=location.search.split('=');
		ArraValor=ArrayParametros[1].split('&');
		//alert(ArraValor[0]);
		document.getElementById("inIDExpe").value=ArraValor[0];
		
		/*
		if(ArrayParametros[2]=='M')
			alert('Modificando el expediente');
			*/
		//alert(ArrayParametros[1]);
	}
}
</script>
<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />
</head>

<body  onload="LeeExpediente();">
<?php require('cabecera.php'); ?>
<div id="documento">
<form id="form1" name="form1" method="post" action="valores.php">
 <br /> 
  <br /> 
  <h4 class="Estilo5"> Asuntos Disponibles</h4>

    <select name="ListaAsuntos" size="22" id="ListaAsuntos" onchange="Crear(this)">
    <?php 
      while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    	$codificada = iconv('Windows-1252', 'UTF-8//TRANSLIT',$row['DESCRIPCION']);
		print '<option value="'.$row['ID'].'">'.
		$codificada.'</option>';
	}
	?>
  </select>
  
<span id="PieDatos">
<h4  class="Estilo5">Datos de la operaci&oacute;n</h4>
    <label class="Estilo1">Observaciones
    <input name="Observaciones" type="text" id="Observaciones" size="40" maxlength="70" />
    </label>
  <input type="hidden" name="xIDExpe" id="inIDExpe" />

   <label class="Estilo2" style="position:absolute; left:53%; top:45%;">
      <input  name="Grabar" type="image" id="Grabar" onclick="GrabarAsuntosExpe();" value="Grabar" src="Redmoon_img/aceptar2.png"/>
      </label>
  </span> 

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

</form>

</div>
</body>
</html>