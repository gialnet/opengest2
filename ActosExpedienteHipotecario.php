<?php

require_once('Redmoon_php/controlSesiones.inc.php');
require_once('Redmoon_php/pebi_cn.inc.php');
require_once('Redmoon_php/pebi_db.inc.php');

$conn = db_connect();

if(isset($_GET["Mod"]))
{

	// datos almacenados
	$sql3 = 'Select VENCIMIENTO,NUMERO_CUOTAS,INTERES,TIPO_INTERES,TIPO_REFERENCIA,REVISION,DIFERENCIAL,Observaciones,NUM_FINCAS,FECHA_PROVISION from Expedientes where NE=:xIDExpe';
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
	
	$sql = 'select id, descripcion from actos_asuntos where tipo_asunto=1 and id not in (select CODIGO_ASUNTO from asuntos_expediente where ne=:xIDExpe) order by id';
	$stid = oci_parse($conn, $sql);   
	oci_bind_by_name($stid, ':xIDExpe', $xIDExpe, 38, SQLT_INT);
	$xIDExpe= (int)$_GET["xIDExpe"];
	
// rellenar una variable con la lista de valores separados por una @
		
	$ListaValores="";
	$suma='"';
	
    $row = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS);
     
    $codificada = $row['DESCRIPCION'];
    
    $ListaValores=$row['CODIGO_ASUNTO'].'@'.$row['OPR_IMPORTE'].'@'.$codificada.'@';
    
    $suma=$suma.$ListaValores;

    

// rellenar una variable con los valores del expediente
 

	$DatosExpe="";
	$suma2='"';
	
    $row = oci_fetch_array($stid3, OCI_ASSOC+OCI_RETURN_NULLS);
    
    	$codificada = $row['OBSERVACIONES'];
    	
    	$DatosExpe=$row['NUM_FINCAS'].'@'.$row['VENCIMIENTO'].'@'.$row['NUMERO_CUOTAS'].'@'.
    	$row['INTERES'].'@'.$row['TIPO_INTERES'].'@'.$row['TIPO_REFERENCIA'].'@'.
    	$row['REVISION'].'@'.$row['DIFERENCIAL'].'@'.$codificada.'@';
    	$suma2=$suma2.$DatosExpe;
    
    
// ver si el espediente ya est� provisionado para controlar sus modificaciones    	
    if ($row['FECHA_PROVISION']!=null)
       $Provisionado=1;
    else 
       $Provisionado=0;
	
}
else
{
  	$sql = 'select id, descripcion from actos_asuntos where tipo_asunto=1 order by id';
	$stid = oci_parse($conn, $sql);
	
	$suma='"alta';
	$suma2='"';
	$Provisionado=0;
}

$r = oci_execute($stid, OCI_DEFAULT);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lista de Asuntos</title>
<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />
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
	top:480px;
	left:50px;
	right:100px;
	bottom:300px;
	

}

.EtiquetaInput {
	font-family: "Times New Roman", Times, serif;
	font-size: medium;
	font-style: normal;
	color:#36679f;
	 background-color: #eee;
        border-color: #eee;
        border-style:solid;
	/* css3 */
	-moz-border-radius:10px;
	-webkit-border-radius:10px;
	border-radius:10px;

	margin: 5px;
	
	padding:5px;
	height: 23px;
	width: 480px;
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
</style>
<script type="text/javascript">

num=0;
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
	var TuDeQuienEres='<?php echo $Rol_controlSesiones; ?>';
	var Provisionado='<?php echo $Provisionado; ?>';

	var url_parametros='idNuFincas='+document.getElementById('idNuFincas').value+
	'&Vencimiento='+document.getElementById('Vencimiento').value+
	'&NumeCuotas='+document.getElementById('NumeCuotas').value+
	'&Interes='+document.getElementById('Interes').value+
	'&TipoInteres='+document.getElementById('TipoInteres').value+
	'&TipoReferencia='+document.getElementById('TipoReferencia').value+
	'&Revision='+document.getElementById('Revision').value+
	'&Diferencial='+document.getElementById('Diferencial').value+
	'&Observaciones='+document.getElementById('Observaciones').value+
	'&xIDExpe='+document.getElementById('inIDExpe').value;
	
	//alert(CamposFijos);

	if (Provisionado=='1')
	{
		alert('No se pueden realizar cambios en esta fase');
		return;
	}
	
	if (TuDeQuienEres==0 || TuDeQuienEres==1 || TuDeQuienEres==2 || TuDeQuienEres==7)
		autorizado=true;
	else
	{
		alert('No puedes realizar cambios');
		return;
	}

	if ((parseInt(document.getElementById('idNuFincas').value) < 1) || 
			(isNaN(parseInt(document.getElementById('idNuFincas').value))) )
	{
		alert('Tiene que indicar el numero de fincas afectadas');
		return;
	}

	// control del numero de asuntos
	if (num==0)
	{
		alert('Tiene que seleccionar al menos un asunto ');
		return;
	}

	
	// Lista de campos seleccionados por el usuario
	for(j=1; j<=num; j++)
	{
	CampoInput='input'+j;
	if(document.getElementById(CampoInput))
	  {
		if (isNaN( parseInt(document.getElementById(CampoInput).value)) ||
				parseInt(document.getElementById(CampoInput).value) <=0 )
		{
			alert('Valor no numerico en los asuntos o valor menor o igual a 0');
			return;
		}
		else
			ListaIDs+='ID-'+ValoresOpc[j]+'='+document.getElementById(CampoInput).value+'&';
	  }
	}
	
	//alert(ListaIDs);
	url_parametros+=ListaIDs;
	
	//alert(url_parametros);
	PutDataAsuntos('Redmoon_php/addAsuntosExpe.php', url_parametros);
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
				a=1;
			    //alert(pageRequest.responseText);

	    	// llamar a  header("Location: ../SeguiExpeConsulta.php?xIDExpe=".$_POST["xIDExpe"].'"');
			location="MenuTitulares.php?xIDExpe=<?php echo $_GET["xIDExpe"]; ?>";

	    	
			// Activo el Menu de Titulares
			//ActivaMenuTitulares();

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
	<?php  	print 'var ListaValores='.$suma.'";'; ?>
	// Datos del Expediente
	<?php print 'var DatosExpe='.$suma2.'";'; ?>

	document.getElementById("inIDExpe").value='<?php echo $_GET["xIDExpe"]; ?>';
		
	if (ListaValores=='alta')
		return;
	
	ArrayValores=ListaValores.split('@');
	if(ArrayValores.length>=3)
		for(x=0; x<=ArrayValores.length-1; x+=3)
		{
			if(ArrayValores[2+x])
			  CrearModifica(ArrayValores[0+x], ArrayValores[1+x], ArrayValores[2+x]);
			
		}

	
	ArrayDatosExpe=DatosExpe.split('@');
	
	// siempre hay valor de mas nulo
	if (ArrayDatosExpe[0]!=null)
		document.getElementById("idNuFincas").value=ArrayDatosExpe[0];
	
	if (ArrayDatosExpe[1]!=null)
		document.getElementById("Vencimiento").value=ArrayDatosExpe[1];
	
	if (ArrayDatosExpe[2]!=null)
		document.getElementById("NumeCuotas").value=ArrayDatosExpe[2];

	if (ArrayDatosExpe[3]!=null)
		document.getElementById("Interes").value=ArrayDatosExpe[2];

	if (ArrayDatosExpe[4]!=null)
		document.getElementById("TipoInteres").value=ArrayDatosExpe[4];

	if (ArrayDatosExpe[5]!=null)
		document.getElementById("TipoReferencia").value=ArrayDatosExpe[5];

	if (ArrayDatosExpe[6]!=null)
		document.getElementById("Revision").value=ArrayDatosExpe[6];

	if (ArrayDatosExpe[7]!=null)
		document.getElementById("Diferencial").value=ArrayDatosExpe[7];

	if (ArrayDatosExpe[8]!=null)
		document.getElementById("Observaciones").value=ArrayDatosExpe[8];
	
	//alert(ArrayValores.length);
	
}
</script>

</head>
<body onload="LeeExpediente()">

<?php require('cabecera.php'); ?>
<div id="ayuda_btn">
		<!--<img src="img/ayuda.png" onclick="AbrirAyuda('Gestoria_documentacion/Asuntos.html')" />-->
	</div>
<div id="documento">
    <div id="rastro"><a href="MenuLGS.php">Inicio</a> >
           <a href="SeguimientoSolicitudes.php"> B&uacute;squeda de un Expediente</a> >
             <a href="MenuTitulares.php?xIDExpe=<?php echo $xIDExpe; ?>"> Datos del Expediente</a>
             > Gesti&oacute;n de Asuntos
</div>
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
 
<span id="PieDatos">
    <div id="winPop">
 <h4 class="Estilo5" align="center">Datos de la operaci&oacute;n</h4>
  <p>
    <label style="color:#36679f">Fincas afectas a la operaci&oacute;n
    <input name="N� de Fincas" type="text" id="idNuFincas" size="10" maxlength="10" />
    </label>
    <label style="color:#36679f">Vencimiento (DD/MM/AA)
    <input name="Vencimiento" type="text" id="Vencimiento" size="10" maxlength="10" />
    </label>
  </p>
  <p>
    <label style="color:#36679f">Cuotas
    <input name="NumeCuotas" type="text" id="NumeCuotas" size="10" maxlength="10" />
    </label>
    <label style="color:#36679f">Tipo de interes
    <input name="Interes" type="text" id="Interes" size="5" maxlength="5" />
    </label>
    <select name="TipoInteres" id="TipoInteres">
    <option value="variable">Variable</option>
    <option value="fijo">Fijo</option>
    <option value="mixto">Mixto</option>
     </select>
    <label style="color:#36679f">Tipo de Referencia
    <select name="TipoReferencia" id="TipoReferencia">
    <option value="euribor">Euribor</option>
    <option value="ceca">CECA</option>
    <option value="mibor">Mibor</option>
    <option value="irph">IRPH</option>
    </select>
    </label>
  </p>
  <p>
    <label style="color:#36679f">Revision
    <select name="Revision" id="Revision">
    <option value="anual">Anual</option>
    <option value="semestral">Semestral</option>
    <option value="trimestral">Trimestral</option>
    <option value="mensual">Mensual</option>
    </select>
    </label>
    <label style="color:#36679f">Diferencial
    <input name="Diferencial" type="text" id="Diferencial" size="5" maxlength="5" />
    </label>
    <label style="color:#36679f">Observaciones
    <input name="Observaciones" type="text" id="Observaciones" size="40" maxlength="40" />
    </label>
  </p>
<br/>
  <input type="hidden" name="xIDExpe" id="inIDExpe" />
 
     <label class="Estilo2" style="position:absolute; left:40%">
      
       
      <img src="Redmoon_img/imgDoc/aceptar.png" id="Grabar" value="Grabar" onclick="GrabarAsuntosExpe()"/>
      </label>
  <br />
  <br />
  </div>
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
