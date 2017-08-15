// http://code.google.com/apis/maps/
//ABQIAAAA9eoH_keOm184h3MQDj6AahRzei4dLapBp6NX5DKg7kfnfy8UpRQMQdpyQjD_LgELQCunvTnEgthasA	
// Inicialización de variables.
var map      = null;
var geocoder = null;
var lati     = null;
var long     = null;

function load() 
{
      if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("mapaGoogle"));        
        map.setCenter(new GLatLng(37.173518, -3.599608), 15);        
        map.addControl(new GSmallMapControl());
	    map.addControl(new GMapTypeControl());
	   	       
        geocoder = new GClientGeocoder();
    
		// Redimensionado en funcion de la resolucion de pantalla.
		var navegador = navigator.appName 
		if (navegador == "Microsoft Internet Explorer") 
   			{
			var thisnav = document.getElementById("mapaGoogle"); 
			thisnav.style.display = "block";
			thisnav.style.width= 420;  //screen.width*0.92;
			thisnav.style.height= 220; //screen.height*0.6;
   			}
 
      } 
} // load()
 


// Calcula la latitud en grados, minutos y segundos.
function conv_grados(radianes, coord)
{
	grados      = Math.abs(Math.floor(radianes));
	minutos_d = (radianes-Math.floor(radianes))*60;
	minutos    = Math.floor((radianes-Math.floor(radianes))*60);
	segundos  = Math.floor((minutos_d - Math.floor(minutos_d))*60);
	valor_g     = grados+"&#176 "+minutos+"' "+segundos+'"';

	if (coord=="latitud")
		{
  		if (radianes<0)
  			{letra =" S";}
  		else
  			{letra =" N";}
		}
	else
	//if (coord="longitud"){
		{
  		if (radianes<0)
  			{letra =" W";}
  		else
  			{letra =" E";}
		}

	valor_g = valor_g+letra;
	
	return (valor_g);
} // conv_grados()


   

function showAddress(zoom) 
{
	var direccion=document.getElementById("inDireccion").value+','+document.getElementById("inPoblacion").value;
	
	//alert(direccion);
	
   	if (geocoder) {
        	geocoder.getLatLng(direccion,
          		function(point) {
            		if (!point) {
            			alert(direccion + " no encontrada");
            		} else {
          			map.clearOverlays();   
            		
            			map.setCenter(point, zoom);
            			
            			var marker = new GMarker(point);
            	          
            			map.addOverlay(marker);
            			
            			var latitud_g = conv_grados(point.y, "latitud");
						var longitud_g = conv_grados(point.x, "longitud");
            			
					//lati = Math.round(point.y * 1000000)/1000000;
					//long = Math.round(point.x * 1000000)/1000000;
					lati = point.y;
					long = point.x;
					document.getElementById("inLatitud").value=lati;
					document.getElementById("inLongitud").value=long;
					
					//document.foFormMapa.xLatitud.value=lati;
					//document.foFormMapa.xLongitud.value=long;
					//marker.openInfoWindowHtml("<b><font face='Verdana' size='2'><br>"+address+"<br><br>Coordenadas (lat lon): </b><br><br>Decimales: <br><font color='#FF0000'>"+lati+"&nbsp;&nbsp;&nbsp;"+long+"</font><br><br> Sexagesimales: <br><font color='#339933'>"+latitud_g+"&nbsp;&nbsp;&nbsp;&nbsp;"+longitud_g+"<a href=http://www.gialnet.com><br><br>Gialnet</a></font>");
 					
     				//document.getElementById("coord_decim").innerHTML ='<font face="Arial" size="2" >Coord. decimales (latitud, longitud) : </font><font face="Arial" size="2" color="#FF0000">'+ point.y+',   '+point.x+'</font>';
     				//document.getElementById("coord_sexag").innerHTML ='<font face="Arial" size="2" >Coord. sexagesimales (latitud, longitud) : </font><font face="Arial" size="2" color="#339933">'+ latitud_g+',    '+longitud_g+'</font>';

               		}
               	}
        	);
        	
      	}
} // showAddress()