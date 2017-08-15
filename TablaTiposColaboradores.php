<?php require('Redmoon_php/controlSesiones.inc.php');  ?>
<?php

require('Redmoon_php/pebi_cn.inc');
require('Redmoon_php/pebi_db.inc'); 


// Create a database connection
//$conn = oci_connect('lgs','a1','//cajalgs.no-ip.org/lgs');
$conn = db_connect();
//, (ENTIDAD||OFICINA||DC||CUENTA) AS NCUENTA
$sql='SELECT * from COLABORADORES_TIPO';
$stid = oci_parse($conn, $sql);


$r = oci_execute($stid, OCI_DEFAULT);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tipos de Colaboradores</title>
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
	//var fila=document.getElementById(xID).rowIndex;

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
function GotoHome()
{
	location="MenuPrincipalHipotecas.html";
}
function AddTipo(){
	document.getElementById('InputTipo').style.visibility='visible';
}
function Salir(){
	document.getElementById('InputTipo').style.visibility='hidden';
}
</script>

<style type="text/css">
#VentanaTabla{ 
	position:absolute;
	top:150px;
	left:100px;
	width:50%;
	height:380px;
	overflow:auto;
	cursor:pointer;
}
#imagen_logo{
	position: absolute;
	top:25px;
	left:790px;
}
#AniadirTipo{
	position: absolute;
	top:155px;
	left:535px;
}
#InputTipo{
	position:absolute;
	top:140px;
	text-align: center;

	width: 400px;
	left:50%;
	margin-left:-200px;
	visibility:hidden;

}
.EstiloFila{ color:#3C4963; }
</style>

</head>

<body >
<?php require('cabecera.php'); ?>
<div id="documento">
    <div id="rastro"><a href="MenuAdmin.php">Inicio</a> >
            Tipos de Colaboradores
</div>


<div id="AniadirTipo">
<img src="redmoon_img/imgDoc/AadirNuevoTipo.png" onclick="AddTipo()"/>
</div>
<div id="VentanaTabla">
<table width="400"  border="0" id="oTabla">
  <tr bgcolor="#C6DFEC" id="oFila0" style="color:#3C4963; cursor:default">
    <td width="10%"><strong>ID</strong></td>
    <td width="90%"><strong>Tipo de Colaborador</strong></td>

   
  </tr>
  <?php

  $x=1;
  while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		echo '<tr bgcolor="#FFFFFF" id="oFila'.$x.'" onclick="GetFila(this.id);" onMouseOver="FilaActiva(this.id);" onMouseOut="FilaDesactivar(this.id);">';
		//echo "<tr>";
		foreach ($row as $key =>$field) 
			{
			$field = iconv('Windows-1252', 'UTF-8//TRANSLIT',$field);
			echo '<td><span class="EstiloFila">'.$field.'</span></td>';
			}
		echo "</tr>\n";
		$x++;
	}
	
	?>
</table>
</div>
<div id="InputTipo">
<div id="winPop">
<p align="left">
<img src="Redmoon_img/imgDoc/cancelar.png" alt="Salir"  onclick="Salir()" />

</p>
<p class="Estilo1">Introduzca el nuevo tipo de colaborador:</p>
<form  name="form2" id="form2" method="post" action="Redmoon_php/ORAAddTipoCola.php">
<label class="Estilo5">Tipo:
<input id="tipo" name="tipo" type="text" maxlength="15" size="15"  /></label>
 
     <input  name="submit" type="image" id="Grabar" value="Grabar"  src="Redmoon_img/imgDoc/aceptar.png"/>
     

</form>
</p>
</div>
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
