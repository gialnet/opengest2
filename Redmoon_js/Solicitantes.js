// JavaScript Document
//
// Antonio Pérez Caballero
// 4 Diciembre 2008
//
// Leer de un array de caracteres para pasar los valores a campos de formulario HTML
// El primer argumento es un Array que contiene los objetos html input text
// el segundo un String con los valores separados por el signo +
//
function PutCursorInForm(ArrayCampos, vCursor)
{

var ArrayValores=vCursor.split('+');

for (x=0; x<=(ArrayValores.length-1); x++)
	{
		if (ArrayCampos[x].name=='idEmpleado')
		{
			if (ArrayValores[x]=='S')
				ArrayCampos[x].checked=1;
		}
		else
			ArrayCampos[x].value=ArrayValores[x];
	
	//alert(ArrayCampos[x].name+'<>'+ArrayValores[x]);	
	//alert(ArrayCampos[x].name);
	//alert(ArrayValores[x]);
	}
	

} // function LeerCursor()


//
// Leer los valores de la tabla de clientes y pasarlos a su formulario HTML
//
function LeerCliente(ListaIDs, vCursor)
{

	var ArrayIDs=ListaIDs.split('+');
	var ArrayCampos= new Array(ArrayIDs.length);
	var x=0;
	

for (x=0; x<=(ArrayIDs.length-1); x++)
	{
		ArrayCampos[x]=document.getElementById(ArrayIDs[x]);	
			
	}


PutCursorInForm(ArrayCampos, vCursor);

}

//
// Poner los campos del formulario en un string
//
function PutFormInCursor(ListaCampos)
{

var ArrayCampos=ListaCampos.split('+');
var ArrayValores= new Array();

//alert(ArrayCampos);
for (x=0; x<=(ArrayCampos.length-1); x++)
	{
		if (ArrayCampos[x]=='idEmpleado')
		{
			if (document.getElementById(ArrayCampos[x]).checked)
				ArrayValores[x]='S';	
			else
				ArrayValores[x]='N';
		}
		else		
			ArrayValores[x]=document.getElementById(ArrayCampos[x]).value;
	}
	
//alert(ArrayValores);
return ArrayValores;
} 

//
// Comprobar si existe el NIF en nuestra base de datos en caso afirmativo traer los datos y rellenar el formulario
// en caso contrario evaluar el formato del NIF y actuar según las normas de hacienda
//
function chekNIFSolicitantes()
{
var xNIF=document.getElementById('inNif').value;
var Fletra;
var xNACI= document.getElementById('inNacionalidad');
var xNombre= document.getElementById('laNOMBRE');
var xLugar= document.getElementById('laLUGAR');
var xPais= document.getElementById('inPaisOrigen');

if ((xNIF.length) > 0)
   Fletra= xNIF.charAt(0);
else
   return true;
   
Fletra=Fletra.toUpperCase();
xNIF=xNIF.toUpperCase();


if ((('ABCDEFGHJPQRSUVNW').indexOf(Fletra) > -1))
				{
				window.status='Persona jur&iacute;dica';
				xNombre.innerHTML='Raz&oacute;n social';
				xLugar.innerHTML='Lugar y fecha de Creaci&oacute;n.';
				document.getElementById('inEstadoCivil').disabled="disabled";
			    document.getElementById('inRegimenEconomico').disabled="disabled";
			    document.getElementById('inProfesion').disabled="disabled";
				
				if ((Fletra=='N') || (Fletra=='W')) // Sociedades extranjeras
				    {
					xNACI.value='';
					xPais.value='';
					}
				else
				    xNACI.value='ESPAÑOLA';
					xPais.value='ESPAÑA';
					
				if ((Fletra=='P') || (Fletra=='Q') || (Fletra=='R') || (Fletra=='S'))
				   {
				   document.getElementById('inPaisOrigen').disabled="disabled";
				   document.getElementById('inFecha').disabled="disabled";
				   document.getElementById('inEstadoCivil').disabled="disabled";
				   }
				else
				   {
				   document.getElementById('inPaisOrigen').disabled="";
				   document.getElementById('inFecha').disabled="";
				   //document.getElementById('inEstadoCivil').disabled="";				   
				   }
				return true;
				}
else
				{
				window.status='Persona fisica';
				xNombre.innerHTML='Apellidos y Nombre';
				xLugar.innerHTML='Lugar y fecha de Nacimiento.';
				document.getElementById('inPaisOrigen').disabled="";
				document.getElementById('inFecha').disabled="";
			    document.getElementById('inRegimenEconomico').disabled="";
			    document.getElementById('inProfesion').disabled="";
			    document.getElementById('inEstadoCivil').disabled="";
				
				if ((Fletra=='X') || (Fletra=='M') || (Fletra=='L') || (Fletra=='Y'))
				   {
				   xNACI.value='';
				   xPais.value='';
				   }
				else
				   {
				   xNACI.value='ESPAÑOLA';
				   xPais.value='ESPAÑA';
				   }
				return true;
				}

}



//
// Leer datos de Oracle vía Ajax y PHP
//
function fetchData(url,dataToSend,ListaCamposIDs){
	
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
	
	pageRequest.onreadystatechange=function() {	filterData(pageRequest,ListaCamposIDs);};
	
	if (dataToSend) {		
		var sendData = 'xNIF=' + dataToSend;
		pageRequest.open('POST',url,true);
    	pageRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
   		pageRequest.send(sendData);
	}
	else {
		pageRequest.open('GET',url,true);
		pageRequest.send(null);
	}
}


//
// Recibe la respuesta del servidor
//
function filterData(pageRequest, ListaCamposIDs){
	
	
	if (pageRequest.readyState == 4)	
	{
		if (pageRequest.status==200)
		{
			//alert(pageRequest.responseText);
			if (pageRequest.responseText=='No Encontrado')
			{
			    chekNIFSolicitantes();
			    LimpiaSolicitante();
		    }
			else
			   LeerCliente(ListaCamposIDs, pageRequest.responseText);
		}
	}
	else return;
}
//
// Limpiar los campos del formulario Solicitantes
//
function LimpiaSolicitante()
{
	
	document.getElementById('inNombre').value="";
	document.getElementById('inFecha').value="";
	document.getElementById('inPoblacion').value="";
	document.getElementById('inDireccion').value="";
	document.getElementById('inPortal').value="";
	document.getElementById('inEmail').value="";
	document.getElementById('inTelefono').value="";
	document.getElementById('inMovil').value="";
	document.getElementById('inEstadoCivil').value="";
	
	document.getElementById('inRegimenEconomico').value="bienes gananciales";
	
	document.getElementById('inProfesion').value="";
	document.getElementById('inCodigoCliente').value="";
	document.getElementById('idEmpleado').checked=false;
	document.getElementById('inEntidad').value="2031";
	document.getElementById('inOficina').value="";
	document.getElementById('inDc').value="";
	document.getElementById('inCuenta').value="";
	document.getElementById('inLatitud').value="";
	document.getElementById('inLongitud').value="";
}
//
//
//
// Ejecuta la función makeRequest que conecta con el servidor enviando una url
//
//
//
function BuscaNIF()
{

	var ListaCamposIDs='inNombre+inNacionalidad+inPaisOrigen+inFecha+inPaisDomicilio+inPoblacion+inDireccion+inPortal+inEmail+inTelefono+inMovil+inEstadoCivil+inRegimenEconomico+inProfesion+inCodigoCliente+idEmpleado+inEntidad+inOficina+inDc+inCuenta+inLatitud+inLongitud';
	var xNIF=document.getElementById('inNif').value;
	
	xNIF=xNIF.toUpperCase();
	document.getElementById('inNif').value=xNIF;
 
  	fetchData('Redmoon_php/dataPage.php', xNIF, ListaCamposIDs);

  //alert(vCursor);
  //LeerCliente(ListaCamposIDs, vCursor);
  
}

//
// PAsar al Formulario de los datos del Prestamo
//
function AddAsuntos()
{
	document.location="ActosExpedienteHipotecario.php?xIDExpe="+document.getElementById("inIDExpe").value;
}
//
// Ver que hay dentro del Radio Tipo de Tercero y pasarlo al formulario en su campo oculto
//
function AddTercero()
{

	var oRadio=document.getElementsByName("raTipoTercero");
	
	if (oRadio[0].checked)
	   document.getElementById("inTipoTercero").value='C';
	if (oRadio[1].checked)
	   document.getElementById("inTipoTercero").value='S';
	if (oRadio[2].checked)
	   document.getElementById("inTipoTercero").value='A';
	   
	DesactivaMenuTitulares();
	LimpiaSolicitante();
	document.getElementById("inNif").value="";
	document.getElementById("inNif").focus();
	//GrabaCliente();
}
//
//
//
function DesactivaMenuTitulares()
{
	// averiguar el navegador
	var agent = navigator.userAgent.toLowerCase();
	var isIE = (agent.indexOf('msie') != -1);
	ht = document.getElementById("documento");
	AreaDiv = document.getElementById("MenuTerceros");

	// despues de grabar dejar las cosas como estaban
	AreaDiv.style.visibility='hidden';

	if (isIE)
		ht.style.filter = "";
	else
		ht.style.opacity="";
		
	

}

//
//
//
function ActivaMenuTitulares()
{
	// averiguar el navegador
	var agent = navigator.userAgent.toLowerCase();
	var isIE = (agent.indexOf('msie') != -1);
	
	ht = document.getElementById("documento");
	
	AreaDiv = document.getElementById("MenuTerceros");
	AreaDiv.style.visibility='visible';
	
	//La siguiente linea pone a grises la pantalla en funcion del navegador
	if (isIE)
	{
	   ht.style.filter = "progid:DXImageTransform.Microsoft.BasicImage(opacity=.75)";
	   AreaDiv.style.filter ="";
	}
	else
	{
	   ht.style.opacity='.75';
	   AreaDiv.style.filter ="";
	}
	   
	document.getElementById("xTipoTercero_0").focus();
	//alert('ActivaMenuTitulares');
}

//
// Quita el gif animado grabando
//
function DesctivaInterfazGrabando()
{
	// averiguar el navegador
	var agent = navigator.userAgent.toLowerCase();
	var isIE = (agent.indexOf('msie') != -1);
	ht = document.getElementById("documento");
	imagen= document.getElementById("Cargando");

	// despues de grabar dejar las cosas como estaban
	imagen.style.visibility='hidden';
	document.getElementById("Grabar").style.visibility='visible';

	if (isIE)
		ht.style.filter = "";
	else
		ht.style.opacity="";
	
}
//
// Pone el gif animado grabando
//
function ActivaInterfazGrabando()
{
		// averiguar el navegado
	var agent = navigator.userAgent.toLowerCase();
	var isIE = (agent.indexOf('msie') != -1);
	var ht = document.getElementById("documento");
	var imagen= document.getElementById("Cargando");
	
	document.getElementById("Grabar").style.visibility='hidden';
	// encender el gif de datos guardandose
	imagen.style.visibility='visible';

	//La siguiente linea pone a grises la pantalla en funcion del navegador
	if (isIE)
	   ht.style.filter = "progid:DXImageTransform.Microsoft.BasicImage(opacity=.75)";
	else
	   ht.style.opacity='.75';

}

//
// Grabar los datos de forma asincrona
//
// nombre de campo+'='+valor del campo+'&'
// ArrayCampos[x].name+'='+ArrayValores[x]+'&'
//
function GrabaCliente(){

	var ListaCamposIDs='inNif+inNombre+inNacionalidad+inPaisOrigen+inFecha+inPaisDomicilio+inPoblacion+inDireccion+inPortal+inEmail+inTelefono+inMovil+inEstadoCivil+inRegimenEconomico+inProfesion+inCodigoCliente+idEmpleado+inEntidad+inOficina+inDc+inCuenta+inLatitud+inLongitud';
	var ListaParametros='xNIF=&xNombre=&xNacionalidad=&xPaisOrigen=&xFecha=&xPaisDomicilio=&xPoblacion=&xDIRECCION=&xPortal=&xemail=&xTelefono=&xmovil=&xEstadoCivil=&xRegimenEconomico=&xProfesion=&xCodigoCliente=&xEmpleado=&xEntidad=&xOficina=&xDC=&xCuenta=&xLatitud=&xLongitud=';
	var ArrayParametros=ListaParametros.split('&');
	var url_parametros='';
	var xTipoAlta=document.getElementById("inTipoTercero").value;
      //  alert(xTipoAlta);
	
	// Invocar a grabar
	ActivaInterfazGrabando();
	
	ArrayValores=PutFormInCursor(ListaCamposIDs);

	
	for (x=0; x<=(ArrayValores.length-1); x++)
	{
		url_parametros+=ArrayParametros[x]+ArrayValores[x]+'&';
	}
	
	//alert(url_parametros);
	
	// Alta o modificación de los datos del cliente
	if(xTipoAlta=='N'){
		//alert("N");
	   PutData('Redmoon_php/ClienteAltaModifica.php', url_parametros);
	}
	// Sujeto de un expediente podrá tener los siguientes valores
	// [T]itular  [C]onyuge  [S]ocio  [A]valista
	// Titular del expediente creando el expediente
	if(xTipoAlta=='T')
	{
		//alert("T");
		//alert('Redmoon_php/AltaExpeHipo.php'+url_parametros);
	   PutData('Redmoon_php/AltaExpeHipo.php', url_parametros);
   }
	
	if((xTipoAlta=='C') || (xTipoAlta=='S') || (xTipoAlta=='A'))
	  {
		//alert("Otro");
		  url_parametros+='xIDExpe='+document.getElementById("inIDExpe").value+'&xTipoTercero='+xTipoAlta;
		  //alert(url_parametros);
		  PutData('Redmoon_php/AddTerceroExpe.php', url_parametros);
  	  }

	return true;
	
}

//
// Leer datos de Oracle vía Ajax y PHP
//
function PutData(url,dataToSend){
	
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
	
	pageRequest.onreadystatechange=function() {	ProcesaRespuesta(pageRequest, url);};
	
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
// Recibe la respuesta del servidor
//
function ProcesaRespuesta(pageRequest, url){

	if (pageRequest.readyState == 4)	
	{
		if (pageRequest.status==200)
		{
			// despues de grabar dejar las cosas como estaban		
			DesctivaInterfazGrabando();	
			//alert(pageRequest.responseText);
			if (pageRequest.responseText!='No'){
				
				 if (url=='Redmoon_php/AltaExpeHipo.php'){
				    	document.getElementById("inIDExpe").value=pageRequest.responseText;
			    	}
			}			
		    	
			// Activo el Menu de Titulares
			ActivaMenuTitulares();

		}
		
	}
	else return;
}
