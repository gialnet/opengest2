<?php 
require_once('Redmoon_php/controlSesiones.inc.php');  
require_once('cabecera.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Menu Principal</title>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>
</head>

<script type="text/javascript">
    function  enInicio(){
        document.getElementById('enlaceInicio').style.visibility="visible";
        document.getElementById('enlaceGestor').style.visibility="hidden";
        document.getElementById('enlaceProvi').style.visibility="hidden";
        document.getElementById('enlaceFactura').style.visibility="hidden";
        document.getElementById('enlaceConfig').style.visibility="hidden";
       // document.getElementById('menuInicio').style.background="url('../Redmoon_img/menu/menuprincipalON.png')";
    }

     function  enGestor(){
        document.getElementById('enlaceInicio').style.visibility="hidden";
        document.getElementById('enlaceGestor').style.visibility="visible";
        document.getElementById('enlaceProvi').style.visibility="hidden";
        document.getElementById('enlaceFactura').style.visibility="hidden";
        document.getElementById('enlaceConfig').style.visibility="hidden";
    }
     function  enProvi(){
        document.getElementById('enlaceInicio').style.visibility="hidden";
        document.getElementById('enlaceGestor').style.visibility="hidden";
        document.getElementById('enlaceProvi').style.visibility="visible";
        document.getElementById('enlaceFactura').style.visibility="hidden";
        document.getElementById('enlaceConfig').style.visibility="hidden";
    }

     function  enFactura(){
        document.getElementById('enlaceInicio').style.visibility="hidden";
        document.getElementById('enlaceGestor').style.visibility="hidden";
        document.getElementById('enlaceProvi').style.visibility="hidden";
        document.getElementById('enlaceFactura').style.visibility="visible";
        document.getElementById('enlaceConfig').style.visibility="hidden";
    }
     function  enConfig(){
        document.getElementById('enlaceInicio').style.visibility="hidden";
        document.getElementById('enlaceGestor').style.visibility="hidden";
        document.getElementById('enlaceProvi').style.visibility="hidden";
        document.getElementById('enlaceFactura').style.visibility="hidden";
        document.getElementById('enlaceConfig').style.visibility="visible";
    }
    function ruta(url){
        location=url;
    }
</script>
    
<body>
<div id="barraMenu">
    <div onclick="enInicio()" id="menuInicio"></div>
    <div onclick="enGestor()" id="menuGestor"></div>
    <div onclick="enProvi()" id="menuProvi"></div>
    <div onclick="enFactura()" id="menuFactura"></div>
    <div onclick="enConfig()" id="menuConfig"></div>  
</div>

<div id="ayuda_btn">
<!--<img src="Redmoon_img/imgDoc/ayuda.png" alt="Ayuda" title="Ayuda" onclick="AbrirAyuda('Gestoria_documentacion/menu_principal_gestoria.html')" />-->
</div>

<div id="documento">
<div id="enlaceInicio">
        <div id="menuInicio1" onclick="ruta('SeguimientoSolicitudes.php')"></div>
<!--        <div id="menuInicio2" onclick="ruta('menuGraficos.php')"></div> -->
		<div id="menuInicio2" onclick="alert('No hay datos DISPONIBLES, para esta opcion')">
</div>

<div id="enlaceGestor">
          <div  id="menuGestor1" onclick="ruta('MayorCuantia.php')"></div>
        <div id="menuGestor2" onclick="ruta('ErrorCalculoProvision.php')"></div>
         <div id="menuGestor3" onclick="ruta('FacturacionCierreDeudor.php')"></div>
</div>

<div id="enlaceProvi">
          <div  id="menuProvi1" onclick="ruta('ProvisionFondosAdd.php')"></div>
        <div id="menuProvi2" onclick="ruta('IngresosHoy.php')"></div>
         <div id="menuProvi3" onclick="ruta('PagosAColaboradores.php')"></div>
          <div id="menuProvi4" onclick="ruta('AutorizarPagosColaboradores.php')"></div>
</div>

<div id="enlaceFactura">
        <div id="menuFactura1" onclick="ruta('FacturacionAClientes.php')"></div>
        <div id="menuFactura2" onclick="ruta('PagosAClientes.php')"></div>
</div>

<div id="enlaceConfig">
        <div  id="menuConfig1" onclick="ruta('ClientesPreferentesLista.php')"></div>
        <div id="menuConfig2" onclick="ruta('SegurosColaboradores.php')"></div>
<!--        <div id="menuConfig3" onclick="ruta('NotasSimples/TablaNotasSimples.php')"></div> -->
        <div id="menuConfig3" onclick="alert('Sin conexion con el servidor')"></div>
<!--        <div id="menuConfig4" onclick="ruta('Simulador_Provisiones.php')"></div> -->
        <div id="menuConfig4" onclick="alert('Faltan los datos de configuracion de tarifas')"></div>
</div>

</div>
</body>
</html>
