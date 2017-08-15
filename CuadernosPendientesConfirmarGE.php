<?php

require_once('Redmoon_php/controlSesiones.inc.php');
require_once('Redmoon_php/pebi_cn.inc.php');
require_once('Redmoon_php/pebi_db.inc.php');

// Create a database connection
$conn = db_connect();

$xPendientes='P';
$sql="SELECT id,fecha,ruta  FROM CUADERNO34 WHERE ENVIADO_BE=:xPendientes and tipo='GE'";
$stid = oci_parse($conn, $sql);

 oci_bind_by_name($stid, ':xPendientes', $xPendientes, 1,SQLT_CHR);



$r = oci_execute($stid, OCI_DEFAULT);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cuadernos Pendientes de Envio</title>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

<script> 
//
//
//
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
	var dataToSend="xIDCuaderno="+oCelda.innerHTML;
	//var fila=document.getElementById(xID).rowIndex;

	if (confirm('Ha sido enviado el cuaderno?'))
	{
		url='Redmoon_php/Cuaderno34enviado.php';
		
		CallRemote(url,dataToSend)
		
		//cambiar que el refresco no sea con el location
		//location="CuadernosPendientesConfirmar.php";
	}

	
	//alert(oCelda.innerHTML);
	

}

//
//
//
function FilaDesactivar(xID)
{
document.getElementById(xID).style.backgroundColor ="#FFFFFF";
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
		
		//alert("GET");
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
		//alert(pageRequest.status);
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
				//alert(cadena);
				//en cadena guarda el echo del php que se acaba de ejecutar

				//CAMBIAR: 
				location="CuadernosPendientesConfirmarGE.php";
				
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


function Home(){
	location="MenuPrincipalHipotecas.html"
}

</script>

<style type="text/css">


</style>

</head>

<body >
<?php require('cabecera.php'); ?>
<div id="documento">
     <div id="rastro"><a href="MenuLGS.php">Inicio</a> >
       <a href="PagosAColaboradores.php">Pagos a Colaboradores</a> >
       Cuadernos Pendientes de Env&iacute;o
    </div>
<br/>
<br/>
<h4 align="center" class="Estilo1"> Cuadernos Pendientes de Envio</h4>
<div id="VentanaTabla">
<table width="750" border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oFila0" style="color:#3C4963; cursor:default">
  	<td width="10%"><strong>ID</strong></td>
    <td width="10%"><strong>Fecha</strong></td>
    <td width="70%"><strong>Ruta</strong></td>
    
  </tr>
  <?php

  $x=1;
  while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		echo '<tr bgcolor="#FFFFFF" id="oFila'.$x.'" onclick="GetFila(this.id);" onMouseOver="FilaActiva(this.id);" onMouseOut="FilaDesactivar(this.id);">';
		//echo "<tr>";
		foreach ($row as $key =>$field) 
			{
			$field = htmlspecialchars($field, ENT_NOQUOTES);
			echo "<td>".$field."</td>\n";
			}
		echo "</tr>\n";
		$x++;
	}
	
	?>
</table>
</div>


<p>&nbsp;</p>
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