<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Suscripciones Profesionales</title>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

<style type="text/css">
<!--
.Estilo1 {
	font-family: "Times New Roman", Times, serif;
	font-size: small;
	font-weight: bold;
}
#Formulario{
	
	margin:15px;
	padding:15px;
	height:150px;
	background-color:#FFFFCC;
}
.Estilo2 {color: #3c4963}
.Estilo3 {color: #36679f}
.Estilo5 {color: #36679f; font-weight: bold; }
-->
</style>
</head>

<body >
<?php require('cabecera.php'); ?>
<div id="documento">
<br/>
<br/>
<h3 align="center" class="Estilo5">Suscripción para Profesionales de Oferta Inmobiliaria</h3>
<p align="justify" class="Estilo1">Mediante este servicio usted, el subscriptor, recibirá notificaciones de los inmuebles que se van incorporando a nuestra base de datos provinientes de las daciones en pago a los bancos de sus créditos de garantía hipotecaria así como de las subastas o ventas directas de los embargos de las administraciones públicas, juzgados y otros entes.</p>
<p align="justify" class="Estilo1">Estas notificaciones le llegarán a su teléfono móvil vía SMS siempre y cuando estos inmuebles se asemejen a los datos aportados por usted en tipo de inmueble y precio.</p>
<p align="justify" class="Estilo1">Usted como profesional del sector recibirá ofertas tempranas, es decir desde el momento en que se inicia el expediente de ejecución y antes de su finalización para la puesta a la venta, usted tiene una ventaja en tiempo, pues conocerá lo que va a entrar con varios meses de antelación al mercado.</p>
<h3 align="center" class="Estilo5">Metodo de Identificación</h3>
<p class="Estilo1">Usted debe enviar un mensaje SMS al número XXXX con la palabra alta.</p>
<p align="justify" class="Estilo1">Una vez recibido este mensaje el sistema le devuelve una clave a su dirección de correo electrónico que tendrá que introducir en el formulario de alta, quedando así registrado en nuestro sistema para ser notificado de los inmuebles ofertados por nuestro Portal Inmobiliario que se ajustan a sus necesidades. El coste del mensaje es de 1,2 euros más impuestos y es la forma de financiación de nuestro portal, existimos grácias a vosotros y os ayudamos a conseguir una vivienda a precios muy ajustados con respecto a los precios de mercado.</p>
<div id="Formulario">
<form id="form1" name="form1" method="post" action="">
  <label><span class="Estilo5">Móvil</span>
  <input name="inMovil" type="text" id="inMovil" size="10" maxlength="10" />
  </label>
  <label><span class="Estilo5">E-mail
  </span>
  <input name="inEmail" type="text" id="inEmail" size="25" maxlength="25" />
  <span class="Estilo5">Clave de Acceso</span>
  <input name="inClave" type="text" id="inClave" size="10" maxlength="10" />
  </label>
  <a href="#">Solicitar clave</a>
  <p>
    <label><span class="Estilo5">Precio aproximado oferta</span>
    <input name="inPrecio" type="text" id="inPrecio" size="15" maxlength="15" />
    </label>
    <label><span class="Estilo5">Tipo de inmueble</span>
    <select name="inInmueble" id="inInmueble">
      <option value="1">Piso</option>
      <option value="2">Apartamento</option>
      <option value="3">Chalet</option>
      <option value="4">Oficina</option>
      <option value="5">Finca Urbana</option>
      <option value="6">Finca Rústica</option>
      <option value="7">Adosado</option>
      <option value="8">Pareado</option>
    </select>
    </label>
    <label><span class="Estilo5">Superficie</span>
    <input name="inSuperficie" type="text" id="inSuperficie" size="10" maxlength="10" />
    </label>
  </p>
  <p>
    <label><span class="Estilo5">Municipio</span>
    <input name="inMunicipio" type="text" id="inMunicipio" size="25" maxlength="25" />
    </label>
    <label><span class="Estilo5">Provincia</span>
    <input type="text" name="inProvincia" id="inProvincia" />
    </label>
    <label></label>
  </p>
  <p>
  <label class="Estilo2" style="position:absolute; left:45%;">
      <input  name="submit" type="image" id="Grabar" value="Grabar"  src="Redmoon_img/aceptar2.png"/>
  </label>
    
  </p>
</form>
</div>
<p align="justify" class="Estilo1">Como se puede comprobar en nuestro formulario no recolectamos datos de carácter personal y protegemos su anonimato. En el caso de que usted esté interesado en más servicios que presta nuestra compañía o en darse de baja del servicio podrá ponerse en contacto con nuestras oficinas a través de nuestro correo electronico clientes@gialnet.com o simplemente enviando un SMS al XXXX con la palabra baja.</p>
</div>
<div align="center">&copy 2008 Redmoon Consultores</div>
</body>
</html>
