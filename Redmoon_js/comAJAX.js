//
// Leer datos de Oracle via Ajax y PHP
//
// Hacer una llamada http post asincrona
//
// ejemplo: url_parametros='xIDExpe=94175';
// ejemplo: CallRemote('Redmoon_php/serializado_SeguiSolicitudes.php', url_parametros)
//
function CallRemote(url,dataToSend){
	
	var pageRequest = false;

	// Crear el objeto en funcion de si es Internet Explorer y resto de navegadores	
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
	
	//
	// al objeto pageRequest le asignamos una función para procesar el evento onreadystatechange
	// esta se encarga de enviar la petición y leer la respuesta en un objeto javascript en el navegador
	//
	//alert('CallRemote');
	pageRequest.onreadystatechange=function() {	ProcRespuesta(pageRequest,url);};
	
	// enviamos la peticion
	
	if (dataToSend) {		
		pageRequest.open('POST',url,true);
 		pageRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		pageRequest.send(dataToSend);
		//alert('CallRemote dataToSend');
	}
	else {
		pageRequest.open('GET',url,true);
		pageRequest.send(null);
	}
}


//
//Recibe la respuesta del servidor
//
function ProcRespuesta(pageRequest,url){

	
	if (pageRequest.readyState == 4)	
	{
		if (pageRequest.status==200)
		{
			// Solo descomentar para depuración
			//alert(pageRequest.responseText);
			if (pageRequest.responseText=='Error')
			    alert(pageRequest.responseText);
			else
			{
				// cadena que contiene el resultado del servidor
				// el servidor envia mediante el comando echo su contenido a la variable pageRequest.responseText
				// ejemplo: echo 'Ok';
				//alert(pageRequest.responseText);
				// hace lo que se quiera con esa cadena
				// aqui seguiria el codigo ...
				if(url=='Redmoon_php/ORASeguiExpeAddComent.php')
					HacerBusqueda();
					
					
		    }
		    	

		}
	}
	else return;
}
