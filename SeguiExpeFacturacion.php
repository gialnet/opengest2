<?php require('Redmoon_php/controlSesiones.inc.php');  ?>
<?php

require('Redmoon_php/pebi_cn.inc');
require('Redmoon_php/pebi_db.inc'); 

// Create a database connection
//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();

$sql='SELECT e.oficina,c.nombre,e.tipo_asunto from expedientes e, colaboradores c where e.colaborador=c.id and e.NE=:xIDExpe';
$stid2 = oci_parse($conn, $sql);
$xIDExpe = $_GET["xIDExpe"];
oci_bind_by_name($stid2, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);

$r = oci_execute($stid2, OCI_DEFAULT);

$row = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS);
$oficina=$row['OFICINA'];
$gestor=iconv('Windows-1252', 'UTF-8//TRANSLIT', $row['NOMBRE']);

if ($row['TIPO_ASUNTO']==1 or $row['TIPO_ASUNTO']==null)
	$tipo_asunto='Hipotecario';
else 
	$tipo_asunto='Dacion';

// RESULTADO DE LA FACTURACION
$sql="SELECT GET_IMPORTE_FACTURACION(:xIDExpe) AS RESULTADO,
(SELECT sum(importe) FROM seguimiento where ne=:xIDExpe and dh='H') as PROVISIONES,
(SELECT sum(importe) FROM seguimiento where ne=:xIDExpe and dh='D') as PAGOS,
(SELECT SUM(IMP_GESTORIA) FROM asuntos_expediente WHERE ne=:xIDExpe) AS GESTORIA
from dual";

$stid2 = oci_parse($conn, $sql);
$xIDExpe = $_GET["xIDExpe"];
oci_bind_by_name($stid2, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);

$r = oci_execute($stid2, OCI_DEFAULT);

$row = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS);
$resultado=$row['RESULTADO'];
$provisiones=$row['PROVISIONES'];
$pagos=$row['PAGOS'];
$gestoria=$row['GESTORIA'];


// vista VWSEGUI_ASUNTOHIPOTECA
$sql="SELECT ID,NE,ESTADOS_EXPE,DESCRIPCION,FECHA_MOVIMIENTO,IMPORTE,DH,TIPO_REGLA,DOCUMENTO FROM VWSEGUI_ASUNTOHIPOTECA where NE=:xIDExpe and DH='D'";
$stid = oci_parse($conn, $sql);
$xIDExpe = $_GET["xIDExpe"];
oci_bind_by_name($stid, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);


$r = oci_execute($stid, OCI_DEFAULT);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FACTURACION</title>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>
<style type="text/css">
#AddMovSeguimiento{
	position:absolute;
	top:50px;
	left:80px;
	height: 300px;
	width: 588px;

	margin:15px 15px;
	padding:15px 25px;

	border:solid 8px;
	border-color:#ebebeb;
	
	background-color: #FFFFCC;
	visibility:hidden;

}
#ComentAdjMultimedia{
	position:absolute;
	top:50px;
	left:80px;
	height: 250px;
	width: 588px;
	
	margin:15px 15px;
	padding:15px 25px;
	
	border:solid 8px;
	border-color:#ebebeb;
	background-color: #FFFFCC;
	visibility:hidden;
}
#ProvisionAdd
{
	position:absolute;
	top:50px;
	left:80px;
	height: 280px;
	width: 588px;
	
	border:solid 8px;
	border-color:#ebebeb;
	margin:15px 15px;
	padding:15px 25px;

	background-color: #FFFFCC;
	visibility:hidden;
}
#ServicioAdd
{
	position:absolute;
	top:50px;
	left:80px;
	height: 280px;
	width: 588px;

	margin:15px 15px;
	padding:15px 25px;
	border:solid 8px;
	border-color:#ebebeb;
	background-color: #FFFFCC;
	visibility:hidden;
}



</style>
<script type="text/javascript">
function AddCargo()
{
	var comentario = document.getElementById("Servicio").value;
	var importe = 	document.getElementById("ImporteServicio").value;
	var url_parametros='xIDExpe='+<?php echo $xIDExpe; ?>+'&xComent='+comentario+'&xImporte='+importe;

	
	//alert(url_parametros);
	PutDataAsuntos('Redmoon_php/ORASeguiExpeAddCargo.php', url_parametros);
}


function PutMenu()
{
	AreaDiv = document.getElementById("AddMovSeguimiento");
	AreaDiv.style.visibility='visible';
	AreaDiv.style.top='50px';

}

function PutMultimedia()
{
	AreaDiv = document.getElementById("ComentAdjMultimedia");
	AreaDiv.style.visibility='visible';
	AreaDiv.style.top='50px';

}

//
// Procedimiento que a�ade un comentario
//
function AddComent(){

	var xComent=document.getElementById("Comentario").value;
	var dataToSend='xIDExpe='+<?php echo $xIDExpe;?>+"&xComent="+xComent;
	
	QuitMultimedia();

	//alert(dataToSend);
	
	// grabar los datos en oracle via ajax
	CallRemote('Redmoon_php/ORASeguiExpeAddComent.php',dataToSend);
}


function QuitMenu()
{
	AreaDiv = document.getElementById("AddMovSeguimiento");
	AreaDiv.style.visibility='hidden';

}

function QuitMultimedia()
{
	AreaDiv = document.getElementById("ComentAdjMultimedia");
	AreaDiv.style.visibility='hidden';

}
function QuitProvision()
{
	AreaDiv = document.getElementById("ProvisionAdd");
	AreaDiv.style.visibility='hidden';

}
function QuitGasto()
{
	AreaDiv = document.getElementById("ServicioAdd");
	AreaDiv.style.visibility='hidden';

}

//
// Llamar a las opciones del menu
//
function MenuAcciones(Opcion)
{
	if (Opcion=='multimedia')
	{
		QuitMenu();
		PutMultimedia();
		
	}
	
	if (Opcion=='provision')
	{
		QuitMenu();
		PutProvision();
		
	}
	if (Opcion=='gasto')
	{
		QuitMenu();
		PutGasto();
		
	}
	
}


</script>

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
	var oDoc=document.getElementById(xID).cells[6];
	//var fila=document.getElementById(xID).rowIndex;

	//alert(oDoc.innerHTML);
	
	if (oDoc.innerHTML=='S') 
	   location="SeguiExpeDocs.php?xIDExpe="+oCelda.innerHTML;
	   
	//location="Notarios.php?xIDNotario="+oCelda.innerHTML;
	//alert(oCelda.innerHTML);
	

}

//
//
//
function FilaDesactivar(xID)
{
document.getElementById(xID).style.backgroundColor ="#FFFFFF";
}
//
// Cambiar el colaborador asociado al expediente
//
function chgColabora()
{
	alert('cambio colaborador');
}

function FinalizarExpe(){

	var ImagenLogo=document.getElementById('imagen_logo');
	ImagenLogo.innerHTML='<img  src="redmoon_img/redmoon_img/lock.png" >';
	
	
	location="Redmoon_php/ORAFacturaraCliente.php?xIDExpe="+<?php echo $_GET["xIDExpe"]; ?>;
}


//
// Volver a la vista anterior
//
function GotoHome()
{
	
	location="FacturacionAClientes.php";
}


</script>

<style type="text/css">
#imagen_logo{
position: absolute;
top:20px;
left:5px;
visibility:visible;
}


#imagen_home{
position: absolute;
top:2px;
left:790px;
}

#VentanaTabla{ position:absolute;
	top:240px;
	left:20px;
	width:700px;
	height:850px;
	overflow:auto;
	cursor:pointer;
}
TD.Numeros{
	text-align:right;
}

#Resultados{
position: absolute;
top:90px;
left:130px;
font-family: Verdana, Arial, Helvetica, sans-serif;
font-size: 12px;
	border:solid 5px;
	border-color:#ebebeb;
	
	
	padding:20px 10px;
	background-color: #FFFFCC;

}
#BotonFacturar{
position:absolute;
	top:70px;
	left:740px;
}
#oficina{
position:absolute;
top:160px;
left:30px;
}
#colaborador{
position:absolute;
top:160px;
left:210px;
}
</style>

</head>

<body>
<?php require('cabecera.php'); ?>
<div id="documento">

<br />
<h4 align="center" class="Estilo1" >Expediente <?php echo $tipo_asunto;  echo ': '.$xIDExpe; ?></h4>



<h4 id="laColabora" align="center">
<div id="oficina">
<img src="<?php echo IMAGENES;?>/tlf_oficina.png" alt="salir"  align="middle" onclick="alert('Llamada a la Oficina, Sistema de Telefonia desconectado')" ><span class="Estilo5"> OFICINA<?php echo ': '.$oficina; ?></span>
<!--
<img src="<?php echo IMAGENES;?>/tlf_oficina.png" alt="salir"  align="middle" onmouseover="AyudaTlf()" onmouseout="SalirAyudaTlf()" onclick="alert('Llamada a la Oficina, Sistema de Telefonia desconectado')"> OFICINA<?php echo ': '.$oficina; ?>
-->
</div>

<div id="colaborador">
<img src="<?php echo IMAGENES;?>/tlf_colabora.png" alt="salir"  align="middle" onclick="alert('Llamada al Colaborador, Sistema de Telefonia desconectado')"><span class="Estilo5"> COLABORADOR<?php echo ': '.$gestor; ?></span>
</div>
</h4>
<div id="imagen_logo">
<img src="redmoon_img/document.png" onclick="PutMenu()">
</div>

<div id="BotonFacturar">
<img src="Redmoon_img/facturar.png" alt="facturar"  align="texttop" onclick="FinalizarExpe()">
<span class="Estilo5">Facturar</span> 
</div>


<div id="Resultados">
<span class="Estilo5">
<?php
	if ($resultado < 0)
		$xTexto=' Cliente Saldo DEUDOR: ';
	else 
		$xTexto=' Importe a favor del cliente: '; 
	echo 'Provisiones: '.number_format($provisiones, 0, ',', '.').' &#8364;'.
	' Gestoria: '.number_format($gestoria, 0, ',', '.').' &#8364;'.
	' Pagos: '.number_format($pagos, 0, ',', '.').' &#8364;'.
	$xTexto.number_format($resultado, 0, ',', '.').' &#8364;'; 
?>
</span>
</div>


<div id="VentanaTabla">
<table width="700" border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oFila0" style="color:#3C4963; cursor:default">
    <td width="10%">ID</td>
    <td width="25%">ESTADO</td>
    <td width="25%">DESCRIPCION</td>
    <td width="15%">FECHA</td>
    <td width="15%">IMPORTE</td>
    <td width="5%">TIPO</td>
    <td width="5%">DOC</td>    
  </tr>
  <?php

  $x=1;
  while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		echo '<tr bgcolor="#FFFFFF" id="oFila'.$x.'" onclick="GetFila(this.id);" onMouseOver="FilaActiva(this.id);" onMouseOut="FilaDesactivar(this.id);">';
		//echo "<tr>";
		echo "<td>".$row['ID']."</td>\n";		
		$field =iconv('Windows-1252', 'UTF-8//TRANSLIT', $row['ESTADOS_EXPE']);
		echo "<td>".$field."</td>\n";
		// valor por defecto si no pasa por los if
		
		$field = iconv('Windows-1252', 'UTF-8//TRANSLIT', $row['DESCRIPCION']);
		

		echo "<td>".$field."</td>\n";
		echo "<td>".$row['FECHA_MOVIMIENTO']."</td>\n";
		
		
			echo '<td align="right">'.number_format($row['IMPORTE'], 0, ',', '.').' &#8364;'."</td>\n";
		
		
		
		if ($row['DH']=='I'){
			echo "<td>".'<img src="redmoon_img/Comment.png" >'."</td>\n";
		}
		else {
		//number_format($row['IMPORTE'], 2, ',', '.')
		echo "<td>".$row['DH']."</td>\n";	
		}
		
		echo "<td>".$row['DOCUMENTO']."</td>\n";		
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
<p>&nbsp;</p>
<p>&nbsp;</p>




<div id="AddMovSeguimiento">
    <p><img src="<?php echo IMAGENES;?>/borrar1.png" alt="salir"  align="texttop" longdesc="salir" onclick="QuitMenu();" /> 
    <div align="center" id="Titulo" class="Estilo5">Menú Actualizar Seguimiento Expediente</div>
    <ul>
      <li>
        <label class="Estilo1"><img src="<?php echo IMAGENES;?>/dialogo.png" alt="salir"  align="middle" longdesc="salir" onclick="MenuAcciones('multimedia')" />Comentario adjunto multimedia: conversación teléfonica </label>
, vídeo, pdf, etc. </li>
      <li><img src="<?php echo IMAGENES;?>/Add2.png" alt="Fondos Adicional"  align="middle" longdesc="salir" onclick="MenuAcciones('provision')" /><span class="Estilo1"> Provisión de fondos adicional</span></li>
      <li><img src="<?php echo IMAGENES;?>/aceptar2.png" alt="salir"  align="middle" longdesc="salir" onclick="MenuAcciones('gasto')" /><span class="Estilo1">Servicio adicional, no incluido en el presupuesto inicial</span></li>
    </ul>
    <label></label>
    <p>
</div>


<div id="ComentAdjMultimedia">
  <p><img src="<?php echo IMAGENES;?>/borrar1.png" alt="salir"  align="texttop" longdesc="salir" onclick="QuitMultimedia()" />
  <div align="center" class="Estilo5">Anotaci&oacute;n (y/o) Adjuntar Archivo Multimedia</div>
    </p>
    <p class="Estilo1">
      Descripción
        <input name="Comentario" type="text" id="Comentario" size="50" maxlength="50" />
        <br />
         <br />
      Fichero adjunto
    <input type="file" name="FicheroAdjunto" id="FicheroAdjunto" />
    <br />
    <input type="image" onclick="AddComent()" name="EnviarComet" id="EnviarComet" value="Enviar" src="<?php echo IMAGENES;?>/aceptar2.png"/>
  </p>
  <p>&nbsp;</p>
</div>



<div id="ProvisionAdd">
  <p><img src="<?php echo IMAGENES;?>/borrar1.png" alt="salir"  align="texttop" longdesc="salir" onclick="QuitProvision()" />
  <div align="center" class="Estilo5">
    Provisión de fondos adicional</div>
    <p class="Estilo1">
<form action="" method="post" enctype="multipart/form-data" name="form2" id="form2">
      Descripción
        <input name="Texto" type="text" id="Texto" size="50" maxlength="50" />
        <br />
         <br />
      Importe
      <input name="ImporteProvision" type="text" id="ImporteProvision" size="10" maxlength="10" />
       <br />
        <br />
       Número Cuenta 
       <input name="ncuenta" type="text" id="ncuenta" size="20" maxlength="20" />
       <br />
      <input type="image" align="middle" name="Enviar" onclick="" id="Enviar" value="Enviar" src="<?php echo IMAGENES;?>/aceptar2.png"/>
  </form>
    </p>
</div>
<div id="ServicioAdd">
  <p><img src="<?php echo IMAGENES;?>/borrar1.png" alt="salir"  align="texttop" longdesc="salir" onclick="QuitGasto()" />
  <div align="center" class="Estilo5">Servicio adicional, no incluido en el presupuesto inicial</div>
    </p>
    <p class="Estilo1">
      Descripción
        <input name="Servicio" type="text" id="Servicio" size="50" maxlength="50" />
        <br />
         <br />
      Importe
      <input name="ImporteServicio" type="text" id="ImporteServicio" size="10" maxlength="10" />
       <br />
      <input type="image" name="Enviar" id="Enviar" value="Grabar" onclick="AddCargo()" src="<?php echo IMAGENES;?>/aceptar2.png"/>
      
    </p>
</div>

</div>
</body>
</html>
