<?php require_once('Redmoon_php/controlSesiones.inc.php');  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Menú Gráficos</title>

<link href="Redmoon_ccs/Solicitantes.css" rel="stylesheet" type="text/css" />
<link href="Redmoon_ccs/cabecera.css" rel="stylesheet" type="text/css" />
<script src="Redmoon_js/cabecera.js" type="text/javascript"></script>

<style type="text/css">
#Grafico{
	position:absolute;
	top:118px;
	left:63px;
	right:100px;
	bottom:300px;
	height: 113px;
	width: 781px;
	border:solid 1px;
	padding: 15px;
}

.Estilo1 {
	color: #3c4963;
	font-weight: bold;
}
.Estilo2 {color: #36679f}
.Estilo4 {color: #36679f; font-weight: bold; }
#buscar{position:absolute;
top:748px;
left:350px;
}
</style></head>
<script type="text/javascript">
	function ValorAnio(){
		var ValorAnio=document.getElementById('ListaAnios').value;
		var Anio="?xAnio="+ValorAnio;
		
		location='graficos/graficos.php?NombreData=SOLICITUDES.php'+Anio;
	}
	function LeeConsulta(Opcion)
	{		
		if(Opcion=='Fecha' )
		{
		   var xFecha1=document.getElementById('FechaDe').value;
		   var xFecha2=document.getElementById('FechaHa').value;
		   var url_parametros='?xFecha1='+xFecha1+'&xFecha2='+xFecha2;
		   location='ListadosExpedientesPorFecha.php'+url_parametros;
		   
		}		
		
			
		if(Opcion=='Fecha2'){
			var xFecha1=document.getElementById('FechaDe2').value;
		   var xFecha2=document.getElementById('FechaHa2').value;
		   var url_parametros='?xFecha1='+xFecha1+'&xFecha2='+xFecha2;
			location='ListadosEntradaSalida.php'+url_parametros;
		}
			
	}
	
	function detectar_tecla(e, opcion){

		if (window.event)
			tecla=e.keyCode;
		else
			tecla=e.which;

		if(tecla==13)
		{
			if (window.event)
			{
				e.returnValue=false;
				window.event.cancelBubble = true;
			}
			else
			{
				e.preventDefault();
				e.stopPropagation();
			}
			//alert('se va a lee consulta');
			LeeConsulta(opcion);
		}
		//alert(tecla);
		}
			
</script>
<body >
	<?php require('cabecera.php'); ?>
		<?php require('cabecera.php'); ?>
		
<div id="documento">
    <p align="center">  <img src="Redmoon_img/imgDoc/menu_graficos.png" border="0" usemap="#Map" />

    <map name="Map" id="Map">
  <area shape="rect" coords="81,151,212,165" href="graficos/graficos.php?Titulo=Solicitudes%20por%20a%C3%B1os&amp;NombreData=gra_expedientes.php" />
  <area shape="rect" coords="80,284,207,298" href="graficos/graficos.php?Titulo=Importe%20de%20los%20expedientes%20por%20a%C3%B1os&amp;NombreData=IMPORTEexpedientes.php" />
  <area shape="rect" coords="80,305,208,317" href="graficos/graficos.php?Titulo=Importe%20de%20los%20expedientes%20por%20a%C3%B1os&amp;NombreData=IMPORTEexpedientes.php" />
  <area shape="rect" coords="81,326,152,340" href="graficos/graficos.php?Titulo=Importe%20de%20los%20expedientes%20a%20empresas&amp;NombreData=IMPORTEempresas.php" />
  <area shape="rect" coords="81,346,177,361" href="graficos/graficos/graficos.php?Titulo=Importe%20de%20los%20expedientes%20por%20a%C3%B1os&amp;NombreData=IMPORTEexpedientes.php" />
  <area shape="rect" coords="79,366,209,382" href="graficos/graficos.php?Titulo=Importe%20de%20los%20expedientes%20a%20Organismos%20P%C3%BAblicos&amp;NombreData=IMPORTEorganismos.php" />
  <area shape="rect" coords="80,387,181,402" href="graficos/graficos.php?Titulo=Importe%20de%20los%20expedientes%20de%20la%20Administraci%C3%B3n&amp;NombreData=IMPORTEempresas.php" />
  <area shape="rect" coords="80,408,163,423" href="graficos/graficos.php?Titulo=Importe%20de%20los%20expedientes%20a%20extranjeros&amp;NombreData=IMPORTEextranjeros.php" />
  <area shape="rect" coords="80,428,218,446" href="graficos/graficos.php?Titulo=Importe%20de%20los%20expedientes%20a%20empresas%20extranjeras&amp;NombreData=IMPORTEempre_extranjeros.php" />
  <area shape="rect" coords="78,508,211,524" href="graficos/graficos.php?Titulo=Importe%20de%20los%20expedientes%20de%20particulares&amp;NombreData=IMPORTEparticulares.php" />
  <area shape="rect" coords="80,527,160,543" href="graficos/graficos.php?Titulo=Importe%20de%20los%20expedientes%20de%20empresas&amp;NombreData=IMPORTEempresas.php" />
  <area shape="rect" coords="79,549,183,566" href="graficos/graficos.php?Titulo=Importe%20de%20los%20expedientes%20por%20a%C3%B1os&amp;NombreData=IMPORTEexpedientes.php" />
  <area shape="rect" coords="80,571,214,586" href="graficos/graficos.php?Titulo=Importe%20de%20los%20expedientes%20a%20Organismos%20P%C3%BAblicos&amp;NombreData=IMPORTEorganismos.php" />
  <area shape="rect" coords="80,591,180,606" href="graficos/graficos.php?Titulo=Importe%20de%20los%20expedientes%20de%20la%20Administraci%C3%B3n&amp;NombreData=IMPORTEempresas.php" />
  <area shape="rect" coords="78,613,161,629" href="graficos/graficos.php?Titulo=Importe%20de%20los%20expedientes%20de%20extranjeros&amp;NombreData=IMPORTEextranjeros.php" />
  <area shape="rect" coords="78,633,217,649" href="graficos/graficos.php?Titulo=Importe%20de%20los%20expedientes%20a%20empresas%20extranjeras&amp;NombreData=IMPORTEempre_extranjeros.php" />
  <area shape="rect" coords="79,825,184,842" href="ListadoRedComercial.php" />
  <area shape="rect" coords="79,847,197,864" href="ListadoGestores.php" />
  <area shape="rect" coords="79,868,200,884" href="ListadoGestoresExternos.php" />
  <area shape="rect" coords="79,890,146,903" href="ListadoNotarios.php" />
</map>
    </p>
    <div id="rastro"><a href="MenuLGS.php">Inicio</a>
        > Listados y Gr&aacute;ficos
    </div>
    <div id="ayuda_btn">
		<!--<img src="Redmoon_img/imgDoc/ayuda.png" alt="Ayuda" title="Ayuda" onclick="AbrirAyuda('Gestoria_documentacion/listados_graficos.html')" />-->
	</div>
<br/>
<br/>
  <h3 align="center" class="Estilo1">Menú Gráficos</h3>
  <p>&nbsp;</p>
        <ul>
       
          <li><span class="Estilo1">Número de expedientes</span>
            <ol class="Estilo2" >
              <li class="Estilo4"><a href="graficos/graficos.php?Titulo=Solicitudes por años&NombreData=gra_expedientes.php" class="Estilo2">Agrupados por años.</a></li>
            </ol>
            <ul>
              <li class="Estilo1">Comparativas:</li>
            </ul>
          </li>
          <ul>
            <ol>
              <li><div id="ListaCuentas">
<form id="form1" name="form1" method="post" action="valores.php">
  <span class="Estilo4">
  Comparativas de Solicitudes por Años:</span>  <br /> 

    <select name="ListaAnios" size="1" id="ListaAnios" onchange="ValorAnio()" >   
    	<OPTION VALUE="<?php echo date("Y");?>"> <?php echo date("Y");  ?> </OPTION> 
  		<OPTION VALUE="<?php echo date("Y")-1;?>"> <?php echo date("Y")-1;  ?></OPTION> 
   		<OPTION VALUE="<?php echo date("Y")-2;?>"> <?php echo date("Y")-2;  ?></OPTION>
    	<OPTION VALUE="<?php echo date("Y")-3;?>"> <?php echo date("Y")-3;  ?></OPTION>	
  </select>
  </form>
</div></li>
            </ol>
          </ul>
        </ul>
<ol>
         
  </ol>
        <ul>
          <li class="Estilo1">Importe de los expedientes </li>
          <ol>
            <li class="Estilo4"><a href="graficos/graficos.php?Titulo=Importe de los expedientes por años&NombreData=IMPORTEexpedientes.php" class="Estilo2">Agrupados por años</a></li>
            <li class="Estilo4"><a href="graficos/graficos.php?Titulo=Importe de los expedientes por años&amp;NombreData=IMPORTEexpedientes.php" class="Estilo4">Clientes Particulares.</a></li>
            <li class="Estilo4"><a href="graficos/graficos.php?Titulo=Importe de los expedientes a empresas&NombreData=IMPORTEempresas.php" class="Estilo4">Empresas.</a></li>
            <li class="Estilo4"><a href="graficos/graficos.php?Titulo=Importe de los expedientes por años&amp;NombreData=IMPORTEexpedientes.php" class="Estilo4">Ayuntamientos.</a></li>
            <li class="Estilo4"><a href="graficos/graficos.php?Titulo=Importe de los expedientes a Organismos Públicos&NombreData=IMPORTEorganismos.php" class="Estilo4">Organismos públicos.</a></li>
            <li class="Estilo4"><a href="graficos/graficos.php?Titulo=Importe de los expedientes de la Administración&NombreData=IMPORTEempresas.php" class="Estilo4">Administración.</a></li>
            <li class="Estilo4"><a href="graficos/graficos.php?Titulo=Importe de los expedientes a extranjeros&NombreData=IMPORTEextranjeros.php" class="Estilo4">Extranjeros.</a></li>
            <li class="Estilo4"><a href="graficos/graficos.php?Titulo=Importe de los expedientes a empresas extranjeras&NombreData=IMPORTEempre_extranjeros.php" class="Estilo4">Empresas extranjeras.</a></li>
          </ol>
          <blockquote>
            <p>&nbsp;</p>
          </blockquote>
          <li class="Estilo1">Cartera de clientes          </li>
  </ul>
<ul>
          <ol>
            <li class="Estilo4"><a href="graficos/graficos.php?Titulo=Importe de los expedientes de particulares&NombreData=IMPORTEparticulares.php" class="Estilo4">Clientes particulares.</a></li>
            <li class="Estilo4"><a href="graficos/graficos.php?Titulo=Importe de los expedientes de empresas&NombreData=IMPORTEempresas.php" class="Estilo4">Empresas.</a></li>
            <li class="Estilo4"><a href="graficos/graficos.php?Titulo=Importe de los expedientes por años&NombreData=IMPORTEexpedientes.php" class="Estilo4">Ayuntamientos.</a></li>
            <li class="Estilo4"><a href="graficos/graficos.php?Titulo=Importe de los expedientes de organismos públicos&NombreData=IMPORTEorganismos.php" class="Estilo4">Organismos públicos.</a></li>
            <li class="Estilo4"><a href="graficos/graficos.php?Titulo=Importe de los expedientes de la Administración&NombreData=IMPORTEempresas.php" class="Estilo4">Administración.</a></li>
            <li class="Estilo4"><a href="graficos/graficos.php?Titulo=Importe de los expedientes de extranjeros&NombreData=IMPORTEextranjeros.php" class="Estilo4">Extranjeros.</a></li>
            <li class="Estilo4"><a href="graficos/graficos.php?Titulo=Importe de los expedientes de empresas extranjeras&NombreData=IMPORTEempre_extranjeros.php" class="Estilo4">Empresas extranjeras.</a></li>
          </ol>
  </ul>
    <h3 align="center" class="Estilo1">Listados</h3>
        <ul>
          <li class="Estilo1">Facturación</li>
          <p><span class="Estilo4">Fecha desde
          </span>
            <input name="FechaDe" type="text" id="FechaDe" size="10" maxlength="10" onkeypress="detectar_tecla(event)" />
            <span class="Estilo4">hasta            </span>
			 <input name="FechaHa" type="text" id="FechaHa" size="10" maxlength="10" onkeypress="detectar_tecla(event,'Fecha')" />
           
				<img src="img/buscar48x48.png" alt="buscar" align="absbottom" longdesc="buscar datos"  onclick="LeeConsulta('Fecha')" /></p> 
      
	    </ul>
         <ul>
          <li class="Estilo1">Red Comercial</li>
          <ol>
          <li class="Estilo4"><a href="ListadoRedComercial.php" class="Estilo4">Red Comercial</a></li>
          <li class="Estilo4"><a href="ListadoGestores.php" class="Estilo4">Gestores Internos</a></li>
           <li class="Estilo4"><a href="ListadoGestoresExternos.php" class="Estilo4">Gestores Externos</a></li>
           <li class="Estilo4"><a href="ListadoNotarios.php" class="Estilo4">Notarios</a></li>
         </ol>
          </ul>
		  
	<h3 align="center" class="Estilo1">Registro entrada/salida de expedientes</h3>
        <ul>
          <li class="Estilo1">Buscar expedientes por fecha de entrada</li>
          <p><span class="Estilo4">Fecha desde
          </span>
            <input name="FechaDe2" type="text" id="FechaDe2" size="10" maxlength="10" onkeypress="detectar_tecla(event)" />
            <span class="Estilo4">hasta            </span>
            <input name="FechaHa2" type="text" id="FechaHa2" size="10" maxlength="10" onkeypress="detectar_tecla(event,'Fecha2')" />
         
				<img src="img/buscar48x48.png" alt="buscar" align="absbottom" longdesc="buscar datos"  onclick="LeeConsulta('Fecha2')" /></p> 
        </ul>
        
  		<p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
</div>
</body>
</html>
