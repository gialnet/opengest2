<?php
//
// 
// Agosto 2009
//

require_once('Redmoon_php/controlSesiones.inc.php');
require_once('Redmoon_php/pebi_cn.inc.php');
require_once('Redmoon_php/pebi_db.inc.php');

if(isset($_SESSION["idRol"]) || isset($_GET['xIDColaborador']))
{
$conn = db_connect();
$sql='SELECT * FROM COLABORADORES where id=:xIDColaborador';

$stid = oci_parse($conn, $sql);


//por si entramos desle el login o desde el colaborador para modificar sus datos
if(isset($_SESSION["idRol"]))
$xIDColaborador = $_SESSION["idRol"];
	
else $xIDColaborador=$_GET['xIDColaborador'];


oci_bind_by_name($stid, ':xIDColaborador', $xIDColaborador, 14, SQLT_CHR);

$r = oci_execute($stid, OCI_DEFAULT);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);	
$xTipo=$row['TIPO'];




$sql2='SELECT ID,uso_cc,ENTIDAD,sucursal,dc,ncuenta FROM COLABORADORES_CUENTAS where idcolabora=:xIDColaborador';
$stid2 = oci_parse($conn, $sql2);
oci_bind_by_name($stid2, ':xIDColaborador', $xIDColaborador, 14, SQLT_CHR);


$r2 = oci_execute($stid2, OCI_DEFAULT);




$sql3 = 'select USO from COLABORADORES_USO_CC';
	$stid3 = oci_parse($conn, $sql3);   
	
	$r3 = oci_execute($stid3, OCI_DEFAULT);

	
$sql4 = 'select NOMBRE FROM COLABORADORES_TIPO WHERE ID=:xTipo';
	$stid4 = oci_parse($conn, $sql4);   
	oci_bind_by_name($stid4, ':xTipo', $xTipo, 38, SQLT_INT);
	$r4 = oci_execute($stid4, OCI_DEFAULT);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Colaboradores</title>

<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>
<style type="text/css">
#VentanaTabla{
	position:absolute;
	width:550px;
	top: 500px;
	left: 100px;
	overflow:auto;
	cursor:pointer;
}
#DatosCOlabora{
position:absolute;
top: 50px;
	left:0px;
	width:800px;
	height: 600px;
}
#ImgAdd{
position: absolute;
top:420px;
left:100px;
}
#InputCuentas{
	position:absolute;
	top:100px;

	text-align: center;
	font-weight:900;
	
	border:solid 8px;
	border-color:#ebebeb;
	
	margin:15px 15px;
	padding:20px 40px;
	background-color: #FFFFCC;
	
	width: 80%;
	left: 2%;
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
	top:142px;
	left:139px;
	visibility:hidden;
	z-index:2;
}
#TextoAyuda{
	position:absolute;
	top:35px;
	left:20px;
	margin-right:20px;

}
</style>
<script>
function LeeColaborador()
{
	//alert('<?php echo $xIDColaborador; ?>');
	//document.getElementById('inID').value="<?php echo $row['ID']; ?>";
	document.getElementById('inNIF').value="<?php echo $row['NIF']; ?>";
	document.getElementById('inNombre').value="<?php echo  iconv('Windows-1252', 'UTF-8//TRANSLIT',$row['NOMBRE']); ?>";
	document.getElementById('inDireccion').value="<?php echo iconv('Windows-1252', 'UTF-8//TRANSLIT',$row['DIRECCION']); ?>";
	document.getElementById('inPoblacion').value="<?php echo  iconv('Windows-1252', 'UTF-8//TRANSLIT',$row['POBLACION']); ?>";
	document.getElementById('inProvincia').value="<?php echo iconv('Windows-1252', 'UTF-8//TRANSLIT',$row['PROVINCIA']); ?>";
	document.getElementById('inCP').value="<?php echo  $row['COD_POSTAL']; ?>";
	document.getElementById('infechAlta').value="<?php echo  $row['FECHA_ALTA']; ?>";
	document.getElementById('ineMail').value="<?php echo $row['EMAIL']; ?>";
	document.getElementById('inAseguradora').value="<?php echo $row['ASEGURADORA']; ?>";
	document.getElementById('inPoliza').value="<?php echo $row['NPOLIZA']; ?>";
	document.getElementById('infechSeg').value="<?php echo  $row['FECHA_SEGURO']; ?>";
	document.getElementById('inInterno').value="<?php echo  $row['INTERNO']; ?>";
	document.getElementById('inMovil').value="<?php echo  $row['MOVIL']; ?>";

	

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
	// al objeto pageRequest le asignamos una funci�n para procesar el evento onreadystatechange
	// esta se encarga de enviar la petici�n y leer la respuesta en un objeto javascript en el navegador
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
			
			// Solo descomentar para depuraci�n
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
				//desactiva el recudro de borrar o a�adir cuenta o cargando
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




function AniadirCuenta(){
	//alert("pasa a�adir");
	var Colaborador =<?php	
	echo $xIDColaborador; ?> 
	Colaborador="xColabora="+Colaborador;
	var Entidad=document.getElementById('entidad').value;
	Entidad="xEntidad="+Entidad;
	var Oficina=document.getElementById('entidad').value;
	Oficina="xOficina="+Oficina;
	var DC=document.getElementById('entidad').value;
	DC="xDC="+DC;
	var NumCuenta=document.getElementById('numcuenta').value;
	NumCuenta="xNumCuenta"+NumCuenta;
	var Tipo=document.getElementById('tipo').value;
	Tipo="xTipo"+Tipo;
	var url=Entidad+Oficina+DC+NumCuenta+Colaborador+Tipo;
	var dir='Redmoon_php/ORAAddCuentaColabora.php';
	
	CallRemote(dir,url);
	//location='Redmoon_php/ORACuentaColabora.php'+url;

}

function AyudaGrabar(){

	AreaDiv = document.getElementById("AyudaGrabar");
	AreaDiv.style.visibility='visible';
}
function SalirAyudaGrabar(){
	AreaDiv = document.getElementById("AyudaGrabar");
	AreaDiv.style.visibility='hidden';
}

</script>
</head>

<body  onload="LeeColaborador();">

<?php require('cabecera.php'); ?>

<div id="documento">
    <div id="rastro"><a href="MenuColaboraGestores.php">Inicio</a>
        > Datos Personales
    </div>
		
		<div id="DatosCOlabora">
                    <div id="winPop">
			<form id="form1" name="form1" method="post" action="Redmoon_php/ORAdatosColaborador.php">
				<p>
 	 				<label class="Estilo2">Fecha de Alta
    					<input name="infechAlta" type="text" id="infechAlta" size="10" maxlength="10" style="position:absolute; left:163px;"/>
     				</label>
     				
     				<label class="Estilo2" style="position:absolute; left:57%;">e-mail
    					<input name="ineMail" type="text" id="ineMail" size="25" maxlength="30" style="position:absolute; left:124px; top:0px;"  />
     				</label>
   				</p>
   				<p>
   					<label class="Estilo2" >Nombre
  						<input name="inNombre" type="text" id="inNombre" size="40" maxlength="50" style="position:absolute; left:163px;"/>
  					</label>
  					
  					<label class="Estilo2" style="position:absolute; left:57%;">NIF
  						<input name="inNIF" type="text" id="inNIF" size="14" maxlength="14" style="position:absolute; left:124px; top:0px;" />
 					</label>
  	
  				</p>
  				<p>
    				<label class="Estilo2">Dirección
   						 <input name="inDireccion" type="text" id="inDireccion" size="40" maxlength="50" style="position:absolute; left:163px;"/>
    				</label>
    				
    				<label class="Estilo2" style="position:absolute; left:57%;">Poblaci&oacute;n
    					<input name="inPoblacion" type="text" id="inPoblacion" size="25" maxlength="25" style="position:absolute; left:124px; top:0px;"/>
    				</label>
   
  				</p>
  				<p>
  					<label class="Estilo2">Provincia
    					<input type="text" name="inProvincia" id="inProvincia" style="position:absolute; left:163px;"/>
    				</label>
      				<label class="Estilo2" style="position:absolute; left:57%;">CP
  						<input name="inCP" type="text" id="inCP" size="5" maxlength="5" style="position:absolute; left:124px; top:0px;"/>
  					</label> 
  					
   					

  				</p>

  				<p>
     			<label class="Estilo2">Aseguradora
    				<input name="inAseguradora" type="text" id="inAseguradora" size="40" maxlength="40" style="position:absolute; left:163px;"/>
	 			</label>
   
     			<label class="Estilo2" style="position:absolute; left:57%;">Fecha de la P&oacute;liza
    				<input name="infechSeg" type="text" id="infechSeg" size="10" maxlength="10" />
    			</label>
  				</p>
  				
    			<p>
     
     			<label class="Estilo2">N&deg; de P&oacute;liza
   					<input name="inPoliza" type="text" id="inPoliza" size="20" maxlength="20" style="position:absolute; left:163px;"/>
    			</label>
    			<label class="Estilo2" style="position:absolute; left:57%;">Tipo
    				<select name="tipoCola" size="1" id="tipoCola" style="position:absolute; left:124px; top:0px;">
  	  					<?php while ($row = oci_fetch_array($stid4, OCI_ASSOC+OCI_RETURN_NULLS)) {
						print '<option value="'.$row['NOMBRE'].'">'.$row['NOMBRE'].'</option>';
						}
						?>
  				</select></label>
      			</p>
      			
     			<p>
     			<label class="Estilo2" >Interno
   					<input style="text-transform:uppercase;" name="inInterno" type="text" id="inInterno" size="3" maxlength="2" style="position:absolute; left:163px;"/>
    			</label>
    			
    			<label class="Estilo2" style="position:absolute; left:57%;">M&oacute;vil
   					<input  name="inMovil" type="text" id="inMovil" size="10" maxlength="9" style="position:absolute; left:124px; top:0px;"/>
    			</label>
    			</p>
    			<p>
  					<input type="hidden" name="xIDColaborador" id="xIDColaborador" value="<?php echo $xIDColaborador; ?>" />
 
    			</p>
    			<br />
      			<label class="Estilo2" style="position:absolute; left:45%;">
      				<input  name="submit" type="image" id="Grabar" value="Grabar" src="Redmoon_img/imgDoc/aceptar.png"/>
      			</label>

			</form>
                        <br />
                        <br />
		</div>
</div>



<div id="ImgAdd"><label class="Estilo2"><img src="Redmoon_img/imgDoc/mas.png" align="middle" onclick="ActivarAniadirCuenta()"/>A&ntilde;adir cuenta</label></div>

<div id="VentanaTabla">
<table width="550" border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oFila0" style="color:#3C4963; cursor:default">
  	<td width="15%"><strong>ID</td>
    <td width="15%"><strong>Tipo Cuenta</td>
    <td width="10%"><strong>Entidad</td>
    <td width="10%"><strong>Sucursal</td>
    <td width="5%"><strong>DC</td>
    <td width="15%"><strong>N&uacute;mero Cuenta</td>
 
  
  </tr>
  <?php

  $x=1;
  while ($row = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		echo '<tr bgcolor="#FFFFFF" id="oFila'.$x.'" onclick="GetFila(this.id);" onMouseOver="FilaActiva(this.id);" onMouseOut="FilaDesactivar(this.id);">';
		//echo "<tr>";
		foreach ($row as $key =>$field) 
			{
			//$field = htmlspecialchars($field, ENT_NOQUOTES);
			echo "<td>".iconv ('Windows-1252//TRANSLIT','UTF-8',$field)."</td>\n";
			}
		echo "</tr>\n";
		$x++;
	}
	
	?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>

<div id="InputCuentas">
<p align="left">
<img src="Redmoon_img/imgDoc/cancelar.png" alt="Salir"  onclick="Salir()" />

</p>
<p class="Estilo4">Introduzca el nuevo n&uacute;mero de cuenta:</p>
<p>&nbsp;</p>
<form  name="form2" id="form2" method="post" action="Redmoon_php/ORAAddCuentaColabora.php">
<label class="Estilo2">Entidad
<input id="entidad" name="entidad" type="text" maxlength="4" size="4"  /></label>
<label class="Estilo2">Oficina
<input id="oficina" name="oficina" type="text" maxlength="4" size="4"  /></label>
<label class="Estilo2">DC
<input id="DC" name="DC" type="text" maxlength="2" size="2"  /></label>
<label class="Estilo2">N.Cuenta
<input id="numcuenta" name="numcuenta" type="text" maxlength="10" size="10"  /></label>
       <p>  <label class="Estilo2">Tipo
    		    <select name="tipo" size="1" id="tipo">
    <?php 
    
    while ($row = oci_fetch_array($stid3, OCI_ASSOC+OCI_RETURN_NULLS)) {
		print '<option value="'.$row['USO'].'">'.$row['USO'].'</option>';
	}
	?>
  </select>
 
  
    </label>  </p>

<input  name="submit" type="image"  value="A&ntilde;adir Cuenta" src="Redmoon_img/imgDoc/aceptar.png"/>
<input type="hidden" name="xID" id="xID" value="<?php echo $xIDColaborador;?>" />
</form>

</div>

</div>

</body>
</html>