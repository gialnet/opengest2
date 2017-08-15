<?php 

require('Redmoon_php/controlSesiones.inc.php');
require('Redmoon_php/pebi_cn.inc.php');
require('Redmoon_php/pebi_db.inc.php'); 

$conn = db_connect();

$sql = 'select id, descripcion from actos_asuntos where tipo_asunto=1 order by id';
$stid = oci_parse($conn, $sql);

$r = oci_execute($stid, OCI_DEFAULT);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Simulador</title>
<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>
<script src="Redmoon_js/cargando.js" type="text/javascript"></script>

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
	top:50px;
	left:0px;
	
	height: 500px;
	width: 800px;
	
	border:solid 8px;
	border-color:#ebebeb;
	
	padding:15px 15px;
	background-color: #FFFFCC;
	visibility:hidden;
}

.EtiquetaInput {
	font-family: "Times New Roman", Times, serif;
	font-size: medium;
	font-style: normal;
	color:#36679f;
	background-color: #FFFFCC;
	margin: 5px;
	border:10px;
	padding:5px;
	height: 23px;
	width: 490px;
	position:absolute;
	top:50px;
	left:300px;
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
.Estilo5 {color: #3c4963; font-weight: bold; }
.Estilo1 {color: #36679f; font-weight: bold; }

#oTablaProvi{
position:absolute;
top:100px;
}
</style>

<script type="text/javascript">

num=0;
var StringSerializado="";
// maximo número de elementos insertados, nos permite controlar el borrado y poder reposicionar los objetos div
// en pantalla
maximo=0;
Opciones = new Array();
ValoresOpc = new Array();
//
// Para la opci�n de modificaciones
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

	if (num==0)
	{
		alert('Tiene que especificar asuntos');
		return;
	}
	
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
	//VerGifEspera();
	PutDataAsuntos('Redmoon_php/simu_tarifa.php', ListaIDs);
}
//
//Leer datos de Oracle v�a Ajax y PHP
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
	
	pageRequest.onreadystatechange=function() {	ProcRespAsuntos(pageRequest,url);};
	
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
function ProcRespAsuntos(pageRequest,url){

	
	if (pageRequest.readyState == 4)	
	{
		if (pageRequest.status==200)
		{
			// despues de grabar dejar las cosas como estaban		
			//OcultarGifEspera();	
			document.getElementById('PieDatos').style.visibility='visible';
			//alert(pageRequest.responseText);
			if (pageRequest.responseText=='Error')
				alert('Error');

			if (url=='Redmoon_php/simu_tarifa.php')
				PutDataAsuntos('Redmoon_php/serializado_simu_provision.php','&xUsuario=user');
			
			if (url=='Redmoon_php/serializado_simu_provision.php')
			{
				StringSerializado=pageRequest.responseText;
				deleteLastRow('oTablaProvi');
		    	AddRowTable();
			}
				
			    //alert(pageRequest.responseText);

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
	for(x=0; x<=ArrayColumnas.length-2; x+=7)
	    {
		j++;
				row = tbl.insertRow(tbl.rows.length);
				row.setAttribute('id', 'oFilaProvi'+j);
				//row.setAttribute('onclick', 'GetFilaProvi(this.id);');
				//row.setAttribute('onMouseOver', 'FilaActivaProvi(this.id);');
				//row.setAttribute('onMouseOut', 'FilaDesactivarProvi(this.id);');
				
			// asunto
			cellText =  row.insertCell(0);
			textNode = document.createTextNode(tbl.rows.length - 1);
			cellText.appendChild(textNode);
			cellText.setAttribute('style', 'color:#3C4963');
			cellText.innerHTML=ArrayColumnas[0+x];

			// cuantia
			cellText =  row.insertCell(1);
			textNode = document.createTextNode(tbl.rows.length - 1);
			cellText.appendChild(textNode);
			cellText.setAttribute('style', 'color:#3C4963');
			cellText.innerHTML=ArrayColumnas[1+x];

			// notaria
			cellText =  row.insertCell(2);
			textNode = document.createTextNode(tbl.rows.length - 1);
			cellText.appendChild(textNode);
			cellText.setAttribute('style', 'color:#3C4963');
			cellText.setAttribute('align', 'right');
			cellText.innerHTML=ArrayColumnas[2+x];

			// impuesto
			cellText =  row.insertCell(3);
			textNode = document.createTextNode(tbl.rows.length - 1);
			cellText.appendChild(textNode);
			cellText.setAttribute('style', 'color:#3C4963');
			cellText.setAttribute('align', 'right');
			cellText.innerHTML=ArrayColumnas[3+x];

			// registro
			cellText =  row.insertCell(4);
			textNode = document.createTextNode(tbl.rows.length - 1);
			cellText.appendChild(textNode);
			cellText.setAttribute('style', 'color:#3C4963');
			cellText.setAttribute('align', 'right');
			cellText.innerHTML=ArrayColumnas[4+x];

			// gestoria
			cellText =  row.insertCell(5);
			textNode = document.createTextNode(tbl.rows.length - 1);
			cellText.appendChild(textNode);
			cellText.setAttribute('style', 'color:#3C4963');
			cellText.setAttribute('align', 'right');
			cellText.innerHTML=ArrayColumnas[5+x];

			// total provisi�n
			cellText =  row.insertCell(6);
			textNode = document.createTextNode(tbl.rows.length - 1);
			cellText.appendChild(textNode);
			cellText.setAttribute('style', 'color:#3C4963');
			cellText.setAttribute('align', 'right');
			cellText.innerHTML=ArrayColumnas[6+x];			
			
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

function PDF(){
	location='pdf_simu.php';
}
</script>

</head>
<body>

<?php require('cabecera.php'); ?>
<div id="ayuda_btn">
		<!--<img src="img/ayuda.png" onclick="AbrirAyuda('Gestoria_documentacion/simular_presupuesto_encargo.html')" />
	</div>-->
<div id="documento">
     <div id="rastro"><a href="MenuLGS.php">Inicio</a> >
      Simulador de Provisiones

    </div>
<br/>
<br/>
<form id="form1" name="form1" method="post" >
 <h4 class="Estilo5">Asuntos Disponibles</h4> 
 
    <select name="ListaAsuntos" size="22" id="ListaAsuntos" onchange="Crear(this);">
    <?php 
    $tabla = get_html_translation_table(HTML_ENTITIES);
    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    	$codificada = strtr($row['DESCRIPCION'], $tabla);
		print '<option value="'.$row['ID'].'">'.
		$codificada.'</option>';
	}
	?>
  </select>
</form>  
<br /> 
<p >
<img src="Redmoon_img/imgDoc/SimuladorProvision.png" id="Grabar" value="Grabar" onclick="GrabarAsuntosExpe()"/>
</p>

<span id="PieDatos">
<img src="Redmoon_img/imgDoc/NuevaSimuladorProvision.png" id="Grabar" value="Grabar" onclick="window.location.reload();
"/>
<img src="Redmoon_img/Oficina-PDF-icon.png" id="pdf" value="pdf" onclick="PDF()"/>
   <table width="790" border="0" id="oTablaProvi">
  <tr bgcolor="#C6DFEC" id="oFilaProvi0" style="color:#3C4963; cursor:default">
    <td width="32%"><strong>Concepto</strong></td>
    <td width="11%" align="right" ><strong>Cuant&iacute;a</strong></td>
    <td width="10%" align="right" ><strong>Notar&iacute;a</strong></td>
    <td width="12%" align="right" ><strong>Impuesto</strong></td>
    <td width="10%" align="right" ><strong>Registro</strong></td>
    <td width="9%" align="right" ><strong>Gestor&iacute;a</strong></td>
    <td width="14%" align="right" ><strong>Total provisi&oacute;n</strong></td>
  </tr>
</table>
  </span> 

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>


</div>
</body>
</html>