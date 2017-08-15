<?php
//
// 
// Agosto 2009
//

require_once('Redmoon_php/controlSesiones.inc.php');
require_once('Redmoon_php/pebi_cn.inc.php');
require_once('Redmoon_php/pebi_db.inc.php');


$conn = db_connect();
$sql='SELECT * FROM datosper';

$stid = oci_parse($conn, $sql);

$r = oci_execute($stid, OCI_DEFAULT);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Datos del Cliente</title>

<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>
<style type="text/css">

#DatosCOlabora{
position:absolute;
top:40px;
	
	width:750px;
	height:190px;
	padding:35px 35px;
	border:thin;
	
		left:0px;
}
#ImgAdd{
position: absolute;
top:470px;
left:100px;
}
#InputCuentas{
	position:absolute;
	top:200px;
	width:300px;
	text-align: center;
	font-weight:900;
	margin:15px 15px;
	border-bottom: solid 2px;
	border-right: solid 2px;
	border-top: solid 1px;
	border-left: solid 1px;
	padding:25px 25px;
	background-color: #FFFFCC;
	width: 70%;
	left:120px;
	visibility:hidden;

}
.Estilo1 {
	color: #3c4963;
	font-weight: bold;
}
.Estilo2 {

	color: #36679f;
	font-weight: bold;
}
.Estilo5 {

	color: #36679f;
	font-weight: bold;
}

#AyudaGrabar{
position:absolute;
	top:40px;
	left:139px;
	visibility:hidden;
	z-index:3;
}
#TextoAyuda{
	position:absolute;
	top:35px;
	left:20px;
	margin-right:20px;

}
</style>
<script type="text/javascript">
function AyudaGrabar(){

	AreaDiv = document.getElementById("AyudaGrabar");
	AreaDiv.style.visibility='visible';
}
function SalirAyudaGrabar(){
	AreaDiv = document.getElementById("AyudaGrabar");
	AreaDiv.style.visibility='hidden';
}

function LeeColaborador()
{
	<?php $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);	?>
	document.getElementById('inNIF').value="<?php echo $row['NIF']; ?>";
	document.getElementById('inNombre').value="<?php echo  iconv('Windows-1252', 'UTF-8//TRANSLIT',$row['RAZON_SOCIAL']); ?>";
	document.getElementById('inDireccion').value="<?php echo iconv('Windows-1252', 'UTF-8//TRANSLIT',$row['DIRECCION']); ?>";
	document.getElementById('inPoblacion').value="<?php echo  iconv('Windows-1252', 'UTF-8//TRANSLIT',$row['POBLACION']); ?>";
	document.getElementById('inCP').value="<?php echo  $row['CP']; ?>";
	document.getElementById('infechAlta').value="<?php echo  $row['UMBRAL_PROVISION']; ?>";
	document.getElementById('ineMail').value="<?php echo $row['MAX_CALCULO_PROVISION']; ?>";
	
	document.getElementById('ID').value="<?php echo $row['ID']; ?>";
	

}


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
	//var fila=document.getElementById(xID).rowIndex;

	location="CuentasColaboradores.php?xID="+oCelda.innerHTML+
		"&xIDColaborador="+document.getElementById("xIDColaborador").value;
	//alert(oCelda.innerHTML);
	

}

//
//
//
function FilaDesactivar(xID)
{
document.getElementById(xID).style.backgroundColor ="#FFFFFF";
}
function ActivarAniadirCuenta(){
	document.getElementById('InputCuentas').style.visibility='visible';
}
function Salir(){
	document.getElementById('InputCuentas').style.visibility='hidden';

}
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
	
	pageRequest.onreadystatechange=function() {	ProcRespuesta(pageRequest);};
	
	// enviamos la peticion
	if (dataToSend) {
		//alert(dataToSend);	
		//alert("post");	
		pageRequest.open('POST',url,true);
	pageRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		pageRequest.send(dataToSend);
	}
	else {
		
		
		pageRequest.open('GET',url,true);
		pageRequest.send(null);
	}
	
	
	
}


//
//Recibe la respuesta del servidor
//
function ProcRespuesta(pageRequest){

	
	if (pageRequest.readyState == 4)	
	{
		alert(pageRequest.status);
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
				cadena = pageRequest.responseText;
				alert(cadena);
				//en cadena guarda el echo del php que se acaba de ejecutar
				//if(cadena=='Cuaderno34 generado'){
					//no se sube a la nube hasta que no se haya terminado de generar el cuaderno
					//location='Redmoon_php/subirNubeCuaderno34.php';
				//}
				//desactiva el recudro de borrar o añadir cuenta o cargando
				Salir();
				
				// hace lo que se quiera con esa cadena
				// aqui seguiria el codigo ...
		    }
		    	

		}
		else if (pageRequest.status == 404) 
			//object.innerHTML = 'Disculpas, la informacion no esta disponible en estos momentos.';
			alert('error 404');
		else 
			object.innerHTML = 'Ha ocurrido un problema.';
	}
	else return;
}






</script>
</head>

<body  onload="LeeColaborador()">

<?php require('cabecera.php'); ?>
<div id="documento">
		<div id="rastro"><a href="MenuAdmin.php">Inicio</a> >
            Datos del Cliente
</div>
		<div id="DatosCOlabora">
		<div id="winPop">
			<form id="form1" name="form1" method="post" action="Redmoon_php/ORAdatosCliente.php">
						<p>
   					<label class="Estilo2" >Raz&oacute;n Social
  						<input name="inNombre" type="text" id="inNombre" size="40" maxlength="30" style="position:absolute; left:163px;"/>
  					</label>
  					
  					<label class="Estilo2" style="position:absolute; left:57%;">NIF
  						<input name="inNIF" type="text" id="inNIF" size="11" maxlength="10" style="position:absolute; left:124px; top:0px;" />
 					</label>
  	
  				</p>
				
				<p>
 	 				<label class="Estilo2">Umbral
    					<input name="infechAlta" type="text" id="infechAlta" size="6" maxlength="6" style="position:absolute; left:163px;"/>
     				</label>
     				
     				<label class="Estilo2" style="position:absolute; left:57%;">M&aacute;ximo Provisi&oacute;n
    					<input name="ineMail" type="text" id="ineMail" size="12" maxlength="12" style="position:absolute; left:124px; top:0px;"  />
     				</label>
   				</p>
   		
  				<p>
    				<label class="Estilo2">DirecciÃ³n
   						 <input name="inDireccion" type="text" id="inDireccion" size="40" maxlength="50" style="position:absolute; left:163px;"/>
    				</label>
    				
    				<label class="Estilo2" style="position:absolute; left:57%;">Poblaci&oacute;n
    					<input name="inPoblacion" type="text" id="inPoblacion" size="23" maxlength="25" style="position:absolute; left:124px; top:0px;"/>
    				</label>
   
  				</p>
  				<p>
  					
      				<label class="Estilo2" style="position:absolute; left:57%;">CP
  						<input name="inCP" type="text" id="inCP" size="5" maxlength="5" style="position:absolute; left:124px; top:0px;"/>
  					</label> 
  					
   					<label class="Estilo2">Ruta Temporal
    				<input name="inRuta" type="text" id="inRuta" size="40" maxlength="150" style="position:absolute; left:163px;"/>
	 			</label>

  				</p>

  				
  				
    	
      			
      			
     		
 
    		
      			<p align="right">
      				<input  name="submit" type="image" id="Grabar" value="Grabar"  src="Redmoon_img/imgDoc/aceptar.png"/>
      			</p>
      			  <input type="hidden" name="ID" id="ID"/>

			</form>
		</div>
</div>
<div id="AyudaGrabar">
	<img src="Redmoon_img/fondo_ayuda.png"/>
	<div id="TextoAyuda">
	<img src="Redmoon_img/aceptar2.png"/>
	<span class="Estilo5">Si desea modificar los datos personales realice los cambios y luego pulse sobre este icono.</span>
	</div>
</div>

<p>&nbsp;</p>


</div>
<p>&nbsp;</p>
<p>&nbsp;</p>

<p>&nbsp;</p>
</body>
</html>