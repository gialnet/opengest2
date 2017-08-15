
<?php 

require_once('Redmoon_php/controlSesiones.inc.php');
require_once('Redmoon_php/pebi_cn.inc.php');
require_once('Redmoon_php/pebi_db.inc.php');

$conn = db_connect();

$sql='SELECT REFCAJAGRANADA,NUM_PRESTAMO,ESTADO,cod_notario FROM EXPEDIENTES  WHERE NE=:xIDExpe';

$stid = oci_parse($conn, $sql);

$xIDExpe = $_GET["xIDExpe"];

oci_bind_by_name($stid, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);

$r = oci_execute($stid, OCI_DEFAULT);

$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
$xCodNotario=$row['COD_NOTARIO'];

$xPrestamo=$row['NUM_PRESTAMO'];
$xRef=$row['REFCAJAGRANADA'];
$xpres=$row['NUM_PRESTAMO'];

if($xCodNotario==NULL){
	//SI NO TIENE UN NOTARIO ASIGNADO SACA EL HABITUAL DE LA OFICINA
	$sql2='SELECT N.DIRECCION, N.NOMBRE,N.POBLACION, n.cod_notario 
	FROM OFICINAS O,NOTARIOS N ,EXPEDIENTES E
	WHERE O.notario_habitual= n.cod_notario AND E.NE=:xIDExpe AND
	e.oficina= o.oficina';
	$stid2 = oci_parse($conn, $sql2);
	oci_bind_by_name($stid2, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);

	$r = oci_execute($stid2, OCI_DEFAULT);
	if (!$r) {
    	$e = oci_error($stid2);
    	echo htmlentities($e['message']);
    	exit;
  	}
	 $row2 = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS);
}
else{
	//SI TIENE UN NOTARIO ASIGNADO SACA EL QUE TIENE ASIGNADO
	$sql2='SELECT N.DIRECCION, N.NOMBRE,N.POBLACION,n.cod_notario
	FROM NOTARIOS N ,EXPEDIENTES E
	WHERE  E.NE=:xIDExpe AND E.COD_NOTARIO=N.COD_NOTARIO';
	$stid2 = oci_parse($conn, $sql2);
	oci_bind_by_name($stid2, ':xIDExpe', $xIDExpe, 14, SQLT_CHR);

	$r = oci_execute($stid2, OCI_DEFAULT);
	if (!$r) {
    	$e = oci_error($stid2);
    	echo htmlentities($e['message']);
    	exit;
  	}
	 $row2 = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Aprobar la operación</title>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#PrimeraColumna{
	position:absolute;
	top:145px;
	left:63px;
	right:100px;
	
	height: 200px;
	width: 770px;

	
}
#SegundaColumna{
	position:absolute;
	top:200px;
	left:63px;
	right:100px;
	width: 770px;
	height: 113px;
	
	
	
}
#imagen_logo{
	position: absolute;
	top:25px;
	left:640px;
}

#CambiarNotario{
	position: absolute;
	top:70px;
	left:80px;
        cursor:pointer;
}
.Estilo1 {
	color: #3c4963;
	font-weight: bold;
}
.Estilo2 {
	color: #36679f;
	font-weight: bold;
}
</style>

<script>
function SetHValues()
{
	//alert("pasa");
	//ESTADO
	document.getElementById("xIDExpe").value="<?php echo $_GET['xIDExpe']; ?>";

	document.getElementById("xRefCaja").value="<?php echo $xRef; ?>";
	document.getElementById("xNumExpe").value="<?php echo $_GET['xIDExpe']; ?>";
	document.getElementById("xprestamo").value="<?php echo $xpres; ?>";
	

	document.getElementById("inNotaria").value="<?php echo iconv('Windows-1252', 'UTF-8//TRANSLIT',$row2['NOMBRE']); ?>";
	document.getElementById("inDire").value="<?php echo iconv('Windows-1252', 'UTF-8//TRANSLIT',$row2['DIRECCION']); ?>";
	document.getElementById("inPobla").value="<?php echo iconv('Windows-1252', 'UTF-8//TRANSLIT',$row2['POBLACION']); ?>";
	document.getElementById("xCodNot").value="<?php echo $row2['COD_NOTARIO']; ?>";

}

function ChangeNotario(){
	var Expediente="<?php echo $_GET['xIDExpe']; ?>";
	//alert(Expediente);
	location="CambiarNotarioExpediente.php?xExpe="+Expediente;
}
</script>
</head>
<body  onload="SetHValues();">
<?php require('cabecera.php'); ?>

<div id="documento">

      <div id="rastro"><a href="MenuLGS.php">Inicio</a> >
           <a href="SeguimientoSolicitudes.php"> B&uacute;squeda de un Expediente</a> >
             <a href="MenuTitulares.php?xIDExpe=<?php echo $xIDExpe; ?>"> Datos del Expediente</a>
             > Aprobaci&oacute;n del Pr&eacute;stamo
</div>
<div id="imagen_logo">
<?php
if ($row['ESTADO']=='APRO' or $row['ESTADO']=='PROV') 
	echo '<img src="redmoon_img/checked.png">';
else 
	echo '<img src="redmoon_img/percent.png">';
?>
</div>

<div id="CambiarNotario">
    <img src="Redmoon_img/imgDoc/CambiarNotario.png" align="middle" onclick="ChangeNotario()" />
</div>
		
        <form id="form1" name="form1" method="post" action="Redmoon_php/AprobadaHipoteca.php">
        <div id="PrimeraColumna">
        <br/>
        <label class="Estilo2">
          Referencia
          <input type="text" name="xRefCaja" id="xRefCaja" style="position:absolute; left:85px;"/>
          </label>
          
          <label class="Estilo2" style="position:absolute; left:42%;">Número de Pr&eacute;stamo
          <input type="text" name="xprestamo" id="xprestamo" />          
          </label>
        <input type="hidden" name="xIDExpe" id="xIDExpe" />
        </div>
        <div id="SegundaColumna">
        <label class="Estilo2"> Notar&#237;a
        <input name="inNotaria" size="86" id="inNotaria" style="position:absolute; left:85px;"/>
   			
 		
 		 </label>
            <p>
 		 <label class="Estilo2">Direcci&oacute;n
      	 <input name="inDire" size="86" id="inDire" style="position:absolute; left:85px;" />
 		 </label>
 		 </p>
 		 <p>
 		 <label class="Estilo2" >Poblaci&#243;n
      	 <input name="inPobla" size="30" id="inPobla" style="position:absolute; left:85px;" />
 		 </label>
 		</p>
          
            <p align="center">
            <input  name="submit" type="image" id="Grabar" value="Grabar" src="Redmoon_img/imgDoc/aceptar.png"/>
            </p>
  	</div>
        <br />
         <input type="hidden" name="xNumExpe" id="xNumExpe" />
        <input type="hidden" name="xCodNot" id="xCodNot"  />
        </form>
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
