// JavaScript Document

function CallNuevoExpe(){
    location="AltaFincaVenta.html";
}

//
// parametro de entrada url del documento html ejemplo: anuncios/anuncios.html
//
function cambiaTexto(menu){
	
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
	
	pageRequest.onreadystatechange=function() {	filterData(pageRequest);};
	
	pageRequest.open('GET',menu,true);
	pageRequest.send(null);

}


//
// Recibe la respuesta del servidor
//
function filterData(pageRequest){
	
var capa = window.document.getElementById("CuerpoCentral");

	if (pageRequest.readyState == 4)	
	{
		if (pageRequest.status==200)
		{			
			//alert(pageRequest.responseText);
			capa.innerHTML = pageRequest.responseText;

		}
		/*else if (pageRequest.status == 404) 
			object.innerHTML = 'Disculpas, la información no está disponible en estos momentos.';
		else 
			object.innerHTML = 'Ha ocurrido un problema.';*/
	}
	else return;
}