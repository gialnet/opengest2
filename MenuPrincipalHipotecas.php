<?php require_once('Redmoon_php/controlSesiones.inc.php');  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Menu Principal</title>
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

<style type="text/css">
<!--
.Estilo2 {color: #3c4963; font-weight: bold; }
.Estilo3 {color: #3c4963;}
.Estilo5 {color: #36679f; font-weight: bold; }
.Estilo9 {
	color: #36679f#3c4963;
	font-weight: bold;
}
.Estilo10 {color: #36679f;}
.Estilo11 {color: #36679#36679f;}
.Estilo12 {font-weight: bold;}
.Estilo13 {font-weight: bold;}
.Estilo14 {font-weight: bold;}
.Estilo15 {font-weight: bold;}
.Estilo16 {color: #808080;}
-->
</style>
</head>

<body>

	<?php require('cabecera.php'); ?>

<div id="documento">
<br/>
<br/>
  <h3 class="Estilo2">Personal</h3>
  <ul>
  <li class="Estilo5">Gestión de grupos de usuario.</li>
  <li class="Estilo5">Calendario de Video Conferencias.</li>
  <li class="Estilo5">Sala de Reuniones Virtual.</li>
  <li class="Estilo5">Video Noticias.</li>
  <li class="Estilo5"><a href="http://www.caja-granada.es" target="blank" class="Estilo5">Pagina Principal CajaGranada.</a></li>
 </ul>

  <h3 class="Estilo2">Tareas de las Oficinas</h3>
 <ul>
<li class="Estilo5"><a href="Solicitantes.php" class="Estilo5">(1)Nuevas Solicitudes de préstamos con garantía hipotecaria</a></li>
<li class="Estilo5"><a href="SeguimientoSolicitudes.php" class="Estilo5">(2)Buscar Solicitudes/Expedientes</a></li>
</ul>
  <h3 class="Estilo2">Tareas del Departamento de Riesgos</h3>
<ul>
  <li class="Estilo5"><a href="SeguimientoSolicitudes.php" class="Estilo5">(3)Gestión de Expedientes</a></li>
  <li class="Estilo5"><a href="menuGraficos.php" class="Estilo5">(4)Panel de Control Gráfico y Estadístico.</a></li>
</ul>
  <h3 class="Estilo2">Tareas de la Gestoria</h3>
  <ul>
<li class="Estilo10"><span class="Estilo12"><a href="ClientesPreferentesLista.php" class="Estilo5">(5)Clientes Preferentes</a></span></li>
<li class="Estilo5"><a href="SeguimientoSolicitudes.php" class="Estilo5">(6)Buscar Expedientes</a></li>
<li class="Estilo5"><a href="menuGraficos.php" class="Estilo5">(7)Panel de Control Gráfico y Estadístico</a></li>
<li class="Estilo5"><a href="MayorCuantia.php" class="Estilo5">(8)Vista Expedientes MAYOR CUANTIA, revisar Gestoras</a></li>
<li class="Estilo5"><a href="ErrorCalculoProvision.php" class="Estilo5">(9)Vista Expedientes Coste Real de Gestión Superior a la Provisión</a></li>
<li class="Estilo5"><a href="FacturacionCierreDeudor.php" class="Estilo5">(10)Vista Expedientes Terminados, con saldo DEUDOR</a></li>
<li class="Estilo5"><a href="provisionfondosadd.php" class="Estilo5">(11)Vista Expedientes Pendientes de Provisiones de Fondos</a></li>
<li class="Estilo5"><a href="IngresosHoy.php" class="Estilo5">(12)Vista Ingresos de Hoy</a></li>
<li class="Estilo5"><a href="PagosAColaboradores.php" class="Estilo5">(13)Vista de cuadernos de pagos Gestiones</a></li>
<li class="Estilo5"><a href="FacturacionAClientes.php" class="Estilo5">(14)Vista de facturación a clientes, cerrar el expediente</a></li>
<li class="Estilo5"><a href="PagosAClientes.php" class="Estilo5">(15)Vista de cuadernos de pagos Clientes</a></li>
<li class="Estilo5"><a href="SegurosColaboradores.php" class="Estilo5">(16)Seguros de los Colaboradores</a></li>
<li class="Estilo5"><a href="AutorizarPagosColaboradores.php" class="Estilo5">Autorizaciones de pago a los Colaboradores, pendientes</a></li>
<li class="Estilo5"><a href="ListadosExpedientesPorFecha.php?xFecha1=01/08/09&xFecha2=01/10/09" class="Estilo5">Listado de expedientes entre fechas</a></li>
<li class="Estilo5"><a href="NotasSimples/TablaNotasSimples.php" class="Estilo5">Notas Simples</a></li>
</ul>
  <h3 class="Estilo3">Tareas de los Colaboradores</h3>
<ul>
  <li class="Estilo10"><span class="Estilo13"><a href="TareasColaboradores.php" class="Estilo5">(17)Tareas de los colaboradores.</a></span></li>
  <li class="Estilo5"><a href="ColaboradoresExpedientes.php" class="Estilo5">(18)Expedientes del colaborador.</a></li>
  <li class="Estilo5"><a href="MenuColaboraGestores.php" class="Estilo5">(19)Menu Colaboradores Gestorias.</a></li>
  <!--<li><a href="PeticionesColaboradores.php">Peticiones de Servicios Adicionales.</a></li>-->
</ul>
  <h3 class="Estilo3">Gestión de Expedientes de Ejecuciones</h3>
<ul>
  <li><span class="Estilo10"><span class="Estilo13"><a href="ClientesDacionesLista.php" class="Estilo5">(20)Daciones en pago</a></span></li>
</ul>
  <h3 class="Estilo3">Tareas del Departamento Jurídico</h3>
<ul>
<li class="Estilo5"><a href="SeguimientoSolicitudes.php" class="Estilo5">(21)Seguimiento de Expedientes Hipotecarios.</a></li>
<li class="Estilo5"><a href="menuGraficos.php" class="Estilo5">(22)Panel de Control Gráfico y Estadístico</a></li>
</ul>
  <h3 class="Estilo3">Portal Web Inmobiliario</h3>
<ul>
  <li class="Estilo5">(23)Portal Web Inmobiliario.</li>
  <li class="Estilo5"><a href="SuscripcionProfesionales.php" class="Estilo5">(24)Gestor de Consultas para Profesionales. (pago por uso vía telefono móvil)</a></li>
  <li class="Estilo5"><a href="SuscripcionClientes.php" class="Estilo5">(25)Gestión de Alertas de Oportunidades mediante supcripción.(pago por uso vía telefono móvil)</a></li>
</ul>
  <h3 class="Estilo3">Tareas de Configuración</h3>
<ul>
  <li class="Estilo10"><span class="Estilo15"><a href="tarifas/Tarifas.php" class="Estilo5">(26)Tabla de Precios de Servicios</a></span></li>
  <li class="Estilo5"><a href="ZonasGestion.php" class="Estilo5">(27)Zonas de Gestión</a></li>
  <li class="Estilo5"><a href="TablaActuaciones.php" class="Estilo5">(28)Tabla de Actuaciones</a></li>
  <li class="Estilo5"><a href="TablaOficinas.php" class="Estilo5">(29)Red Comercial</a></li>
  <li class="Estilo5"><a href="TablaOficinasGestores.php" class="Estilo5">(30)Gestores de las Oficinas</a></li>
  <li class="Estilo5"><a href="NotariosTabla2.php" class="Estilo5">(31)Notarios</a></li>
  <li class="Estilo5"><a href="TablaColaboradores.php" class="Estilo5">(32)Colaboradores</a></li>
  <li class="Estilo5"><a href="TablaGestores.php" class="Estilo5">(33)Gestores</a></li>
  <li class="Estilo5"><a href="TablaTiposColaboradores.php" class="Estilo5">(34)Tipos de Colaboradores</a></li>
  <li class="Estilo5"><a href="TablaTiposExpedientes.php" class="Estilo5">(35)Tipos de Expedientes</a></li>
  <li class="Estilo5"><a href="DatosCliente.php" class="Estilo5">(36)Datos del Cliente</a></li>
  <li class="Estilo5"><a href="TablaClientesPreferentes.php" class="Estilo5">(37)Clientes Preferentes</a></li>
    <li class="Estilo5"><a href="SeleccionarClientePreferente.php" class="Estilo5">(38)B&uacute;squeda de Clientes</a></li>
</ul>
  <h3 class="Estilo2">Tareas de Gestión de Usuarios</h3>
  <ul>
  <li class="Estilo5">Gestión de Cuentas de Usuarios</li>
  <li class="Estilo5">Tipos de Usuarios</li>
  <li class="Estilo5">Grupos de Usuarios</li>  
  <li class="Estilo5">Permisos</li>
  <li class="Estilo5">Alarmas</li>
  <li class="Estilo5">Certificados Digitales</li>
  <li class="Estilo5">Cuentas de la Centralita SIP</li>
</ul>
  <h3 class="Estilo3">Tareas de Administración</h3>
<ul>
  <li class="Estilo5"><strong>Salud del sistema</strong></li>
  <li class="Estilo5"><strong>Copias de Seguridad</strong></li>
  <li class="Estilo5"><strong>Test de Comunicaciones</strong></li>
  <li class="Estilo5"><strong>Test de Servidores</strong></li>
  </ul>
   
   

</div>
</body>
</html>
