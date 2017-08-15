<?php

require_once('Redmoon_php/controlSesiones.inc.php');
require_once('Redmoon_php/pebi_cn.inc.php');
require_once('Redmoon_php/pebi_db.inc.php');

// Create a database connection

$conn = db_connect();

$sql="SELECT NOMBRE_DOC,RUTA,FECHA_ESCANEO,substr(nombre_doc,instr(nombre_doc,'.')+1,length(nombre_doc)) as TIPO,HISTORICO FROM SEGUIMIENTO_DOC where ID_SEGUI=:xIDExpe";
$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);
$xIDExpe = $_GET["xIDExpe"];

$r = oci_execute($stid, OCI_DEFAULT);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documentos del Expediente</title>
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
	var oTipo=document.getElementById(xID).cells[0];
	var oNombre=document.getElementById(xID).cells[1];
	var oRuta=document.getElementById(xID).cells[2];
	var oHisto=document.getElementById(xID).cells[4];

	var vRutaFile=(oHisto.value=='S')? '<?php echo RUTA;?>' : '';
	
	//alert("TIF.php?xFile=<?php echo RUTA;?>"+oRuta.innerHTML);

	if (oTipo.innerHTML=='mp3' || oTipo.innerHTML=='MP3')
	{ 
		  //location="PlayMP3.php?xFile="+oRuta.innerHTML+oNombre.innerHTML;
	  	url_file="PlayMP3.php?xFile="+oRuta.innerHTML+oNombre.innerHTML;
	  
		if (window.showModalDialog) 
			MiWin=window.showModalDialog(url_file,'SubirFile','dialogWidth:550px;dialogHeight:234px');
		else 
			MiWin=window.open(url_file,'SubirFile','height=550,width=150,toolbar=no,directories=no,status=no,continued from previous linemenubar=no,scrollbars=no,resizable=no ,modal=yes');
		
	return;
	}

	// media player
	if (oTipo.innerHTML=='wma' || oTipo.innerHTML=='WMA' || oTipo.innerHTML=='WAV' || oTipo.innerHTML=='wav')
	{ 
	  	url_file="PlayWinMedia.php?xFile="+oRuta.innerHTML+oNombre.innerHTML+"&xExt="+oTipo.innerHTML;
	  
		if (window.showModalDialog) 
			MiWin=window.showModalDialog(url_file,'SubirFile','dialogWidth:550px;dialogHeight:234px');
		else 
			MiWin=window.open(url_file,'SubirFile','height=550,width=200,toolbar=no,directories=no,status=no,continued from previous linemenubar=no,scrollbars=no,resizable=no ,modal=yes');
		
	return;
	}
	
	if (oTipo.innerHTML=='tif' || oTipo.innerHTML=='TIF') 
		url_file="TIF.php?xFile="+vRutaFile+oRuta.innerHTML+oNombre.innerHTML;

	if (oTipo.innerHTML=='PDF' || oTipo.innerHTML=='pdf') 
		url_file="PDF.php?xFile="+vRutaFile+oRuta.innerHTML+oNombre.innerHTML;
	  
	if (oTipo.innerHTML=='JPG' || oTipo.innerHTML=='jpg') 
		url_file="JPG.php?xFile="+vRutaFile+oRuta.innerHTML+oNombre.innerHTML;

	location=url_file;

}

//
//
//
function FilaDesactivar(xID)
{
document.getElementById(xID).style.backgroundColor ="#FFFFFF";
}
</script>

<style type="text/css">
#imagen_logo{
position: absolute;
top:250px;
left:590px;
}
#VentanaTabla{ position:absolute;
	top:135px;
	left:50px;
	width:700;
	height:350px;
	overflow:auto;
	cursor:pointer;
}
TD.Numeros{
	text-align:right;
}
</style>

</head>

<body >
<?php require('cabecera.php'); ?>
<div id="documento">
<br />
<br />
<h4 align="center" class="Estilo1">Datos del Documento<?php echo ': '.$xIDExpe; ?></h4>
<div id="imagen_logo">
<!--<img src="redmoon_img/documents.png">-->
</div>

<div id="VentanaTabla">
<table width="750" border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oFila0" style="color:#3C4963; cursor:default">
    <td width="10%"><strong>Tipo</strong></td>  
    <td width="25%"><strong>Nombre</strong></td>
    <td width="50%"><strong>Ruta</strong></td>
    <td width="15%"><strong>Fecha</strong></td>
  </tr>
  <?php

  $x=1;
  while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		echo '<tr bgcolor="#FFFFFF" id="oFila'.$x.'" onclick="GetFila(this.id);" onMouseOver="FilaActiva(this.id);" onMouseOut="FilaDesactivar(this.id);">';
		//echo "<tr>";
		echo "<td>".$row['TIPO']."</td>\n";
		echo "<td>".$row['NOMBRE_DOC']."</td>\n";
		echo "<td>".$row['RUTA']."</td>\n";
		echo "<td>".$row['FECHA_ESCANEO']."</td>\n";
		echo "<td style='visibility:hidden;'>".$row['HISTORICO']."</td>\n";
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
</div>

</body>
</html>
