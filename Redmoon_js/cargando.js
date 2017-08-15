

//
// Ocultar el gif animado grabando
//
function OcultarGifEspera()
{
	// averiguar el navegador
	var agent = navigator.userAgent.toLowerCase();
	var isIE = (agent.indexOf('msie') != -1);

	imagen= document.getElementById("Cargando");

	// despues de grabar dejar las cosas como estaban
	imagen.style.visibility='hidden';

	
}
//
// Mostrar el gif animado grabando
//
function VerGifEspera()
{
		// averiguar el navegado
	var agent = navigator.userAgent.toLowerCase();
	var isIE = (agent.indexOf('msie') != -1);
	var imagen= document.getElementById("Cargando");
	
	// encender el gif de datos guardandose
	imagen.style.visibility='visible';

}


