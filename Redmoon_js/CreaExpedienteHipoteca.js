//
// Ver que hay dentro del Radio Tipo de Tercero y pasarlo al formulario en su campo oculto
//
function AddTercero()
{

	var oRadio=document.getElementsByName("xTipoTercero");
	
	if (oRadio[0].checked)
	   document.getElementById("inTipoTercero").value='C';
	if (oRadio[1].checked)
	   document.getElementById("inTipoTercero").value='S';
	if (oRadio[2].checked)
	   document.getElementById("inTipoTercero").value='A';
	   
	DesactivaMenuTitulares();
	GrabaCliente();
}
//
//
//
function DesactivaMenuTitulares()
{
	// averiguar el navegador
	var agent = navigator.userAgent.toLowerCase();
	var isIE = (agent.indexOf('msie') != -1);
	ht = document.getElementById("pagina");
	AreaDiv = document.getElementById("inTipoTercero");

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
	
	ht = document.getElementById("pagina");
	
	AreaDiv = document.getElementById("MenuTerceros");
	AreaDiv.style.visibility='visible';
	
	//La siguiente linea pone a grises la pantalla en funcion del navegador
	if (isIE)
	   ht.style.filter = "progid:DXImageTransform.Microsoft.BasicImage(opacity=.75)";
	else
	   ht.style.opacity='.75';

}

//
// Quita el gif animado grabando
//
function DesctivaInterfazGrabando()
{
	// averiguar el navegador
	var agent = navigator.userAgent.toLowerCase();
	var isIE = (agent.indexOf('msie') != -1);
	ht = document.getElementById("pagina");
	imagen= document.getElementById("Cargando");

	// despues de grabar dejar las cosas como estaban
	imagen.style.visibility='hidden';
	document.getElementById("Cancelar").style.visibility='visible';
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
	ht = document.getElementById("pagina");
	imagen= document.getElementById("Cargando");
	
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

	var ListaCamposIDs='inNif+inNombre+inNacionalidad+inPaisOrigen+inFecha+inPaisDomicilio+inPoblacion+inDireccion+inPortal+inEmail+inTelefono+inMovil+inEstadoCivil+inRegimenEconomico+inProfesion+inCodigoCliente+inEntidad+inOficina+inDc+inCuenta+inLatitud+inLongitud';
	var ListaParametros='xNIF=&xNombre=&xNacionalidad=&xPaisOrigen=&xFecha=&xPaisDomicilio=&xPoblacion=&xDIRECCION=&xPortal=&xemail=&xTelefono=&xmovil=&xEstadoCivil=&xRegimenEconomico=&xProfesion=&xCodigoCliente=&xEntidad=&xOficina=&xDC=&xCuenta=&xLatitud=&xLongitud=';
	var ArrayParametros=ListaParametros.split('&');
	var url_parametros='';
	var xTipoAlta=document.getElementById("inTipoTercero").value;

	document.getElementById("Cancelar").style.visibility='hidden';
	document.getElementById("Grabar").style.visibility='hidden';
	
	// Invocar a grabar
	ActivaInterfazGrabando();
	
	ArrayValores=PutFormInCursor(ListaCamposIDs);

	
	for (x=0; x<=(ArrayValores.length-1); x++)
	{
		url_parametros+=ArrayParametros[x]+ArrayValores[x]+'&';
	}
	//alert(url_parametros);
	
	// Alta o modificación de los datos del cliente
	if(xTipoAlta=='N')
	   PutData('Redmoon_php/ClienteAltaModifica.php', url_parametros);
	   
	// Sujeto de un expediente podrá tener los siguientes valores
	// [T]itular  [C]onyuge  [S]ocio  [A]valista
	// Titular del expediente creando el expediente
	if(xTipoAlta=='T')
	   PutData('Redmoon_php/AltaExpeHipo.php', url_parametros);
	
	if((xTipoAlta=='C') || (xTipoAlta=='S') || (xTipoAlta=='A'))
	  {
		  url_parametros+=xIDExpe+'='+document.getElementById("inIDExpe").value+'&xTipoTercero='+xTipoAlta;
		  PutData('Redmoon_php/AddTerceroExpe.php', url_parametros);
  	  }

	return true;
	
}



//
// Poner los campos del formulario en un string
//
function PutFormInCursor(ListaCampos)
{

var ArrayCampos=ListaCampos.split('+');
var ArrayValores= new Array();


for (x=0; x<=(ArrayCampos.length-1); x++)
	{
	ArrayValores[x]=document.getElementById(ArrayCampos[x]).value;
	}
	
return ArrayValores;
} // function LeerCursor()



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
	
	pageRequest.onreadystatechange=function() {	ProcesaRespuesta(pageRequest);};
	
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
function ProcesaRespuesta(pageRequest){

	
	if (pageRequest.readyState == 4)	
	{
		if (pageRequest.status==200)
		{
			// despues de grabar dejar las cosas como estaban		
			DesctivaInterfazGrabando();
			
			// Activo el Menu de Titulares
			ActivaMenuTitulares();
			
			//alert(pageRequest.responseText);
			if (pageRequest.responseText=='No')
			    //alert(pageRequest.responseText);
				a=1;
			else
			    {
			    //alert(pageRequest.responseText);
			    document.getElementById("xIDExpe").value=pageRequest.responseText;
		    	}
		}
		/*else if (pageRequest.status == 404) 
			object.innerHTML = 'Disculpas, la información no está disponible en estos momentos.';
		else 
			object.innerHTML = 'Ha ocurrido un problema.';*/
	}
	else return;
}
