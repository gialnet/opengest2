<%@ taglib uri="/WEB-INF/struts-html.tld" prefix="html"%>
<%@ taglib uri="/WEB-INF/struts-bean.tld" prefix="bean"%>
<%@ page import="java.sql.*,javax.sql.*,java.util.Vector,view.VistaSeguimiento,
    javax.servlet.http.HttpSession,view.VistaIncidentes" 
    contentType="text/html;charset=windows-1252"%>
    
<%  
  // instancia de la clase VistaSeguimiento
  VistaSeguimiento registro = new VistaSeguimiento();
  // vector que contendrá elementos del tipo registro conteniendo por cada
  // elemento la información de una tupla de la consulta del seguimiento
  Vector consulta = new Vector();
  consulta = (Vector) request.getAttribute("SEGUIMIENTO");  
  VistaIncidentes incidenteActual = (VistaIncidentes) session.getAttribute("incidenteActual");
  String asuntoIncidente=incidenteActual.getAsunto();  
  String idIncidente=incidenteActual.getNumero();
%>

  <bean:define id="personalGialnet" name="LoginForm" property="personalGialnet" type="String">
  </bean:define>
  <bean:define id="supervisor" name="LoginForm" property="supervisor" type="String">
  </bean:define>
    
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Atenci&oacute;n al Cliente | Gialnet SL.</title>
<link href="css/base.css" rel="stylesheet" media="screen">

<style type="text/css">
	
#playlist{
background-color:#EDF3FE;
}


div.row span.label {
  float: left;
  width: 100px;
  text-align: right;
    }

div.row span.formw {
	float: right;
	width: 490px;
	text-align: left;	
  } 
  
 .espacio1{
padding-top:3px;
 }

</style>


<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
</head>

<body>
  <div id="usuario">
    <img src="imagenes/usuario.gif" width="12" height="14"/>
    <span class="usuario">Cliente: </span>
    <span class="nombre_usuario">
      <bean:write name="LoginForm" property="login"/>
    </span>
  </div>    
  
  <div id="cabecera">
    <img src="imagenes/cabecera_01.jpg" width="262" height="192"/><img src="imagenes/cabecera_02.gif" width="466" height="192"/>
  </div>
  
  <div id="content_tabla">  
  
    <div id="navcontainer">
      <ul id="navlist">
        <li>
          <html:link page="/RefreshIncidentes.do">
            <bean:message key="link.Temas"/>
          </html:link>
        </li>         
        <% // Si el tema está finalizado, no muestra la pestaña de Responder
          if (!incidenteActual.getEstado().equalsIgnoreCase("FI"))
          {
        %>
          <li>
            <html:link page="/AddSeguimiento.jsp">                                    
              <bean:message key="link.AddSeguimiento" />                     
            </html:link>              
          </li>
        <% 
          }
        %>
        <li>
          <html:link page="/RefreshFinalizados.do">
            <bean:message key="link.Finalizados"/>
          </html:link>  
        </li>
        <!-- si es supervisor, poder consultar las incidencias del resto
             del personal -->
        <% 
          if (supervisor.equalsIgnoreCase("S"))
          {
          %>
            <li>
              <html:link page="/RefreshSubordinados.do">
                <bean:message key="link.Supervision"/> 
              </html:link>
            </li>
          <%
          }
          %>
      </ul>
      <div class="bullet_titulos" id=titulos> <%=idIncidente%>-<%=asuntoIncidente%>
      </div>
    </div><!-- FIN navcontainer --> 
    

    <div id="playlist">
      <div class="espacio1">	&nbsp;
      </div>
            
      <% 
      for(int i=0; i<consulta.size(); i++) 
      {
        registro = (VistaSeguimiento)consulta.elementAt(i);   
      
        //Se comprueba si el apunte viene de Gialnet o de un Cliente
        if (registro.getRespuestaGialnet().equalsIgnoreCase("SI"))
        {
        %>        
          <div class="gialnet"><!-- Comentario Gialnet -->
    
            <div class="cliente_gialnet"><%=registro.getNombre()%> (Gialnet):
            </div>
      
            <div class="divisor_fecha"><%=registro.getFecha()%>
            <%
              if (registro.getLongitud()>0)
              {
            %>         
              <html:form action="DownloadFile.do">
                <html:hidden property="id" value="<%=registro.getId()%>" />
                <html:hidden property="fuente" value="Seguimiento" />
                <html:img src="imagenes/b_file.gif" alt="Fichero adjunto" width="12" height="12" border="0" onclick="javascript:submit()" />
              </html:form>              
            <%
              }
            %>
            </div>

            <div class="cuerpo"><%=registro.getExplicacion()%>
            </div>
            
            <%
            if ((personalGialnet.equalsIgnoreCase("SI"))&&
                (registro.getInterno()!=null)
               )
            {
              %>
              <div class="divisor_normal">      
              </div>            
              <div class="cuerpo"><%=registro.getInterno()%>
              </div>  
              <%
            }
            %>
            
          </div>
          
          <div class="divisor_normal">      
          </div>            
            
        <%
        }
        else
        {
        %>
          <div class="cliente"><!-- Comentario Cliente -->
    
            <div class="cliente_nombre"><%=registro.getNombre()%>
            </div>
      
            <div class="divisor_fecha"><%=registro.getFecha()%>
            <%
              if (registro.getLongitud()>0)
              {
            %>
              <html:form action="DownloadFile.do">
                <html:hidden property="id" value="<%=registro.getId()%>" />
                <html:hidden property="fuente" value="Seguimiento" />
                <html:img src="imagenes/b_file.gif" alt="Fichero adjunto" width="12" height="12" border="0" onclick="javascript:submit()" />
              </html:form>  
            <%
              }
            %>
            </div>

            <div class="cuerpo"><%=registro.getExplicacion()%>
            </div> 
      
          </div>
    
          <div class="divisor_normal">
          </div>          

        <%
        }
        
      }  
      %> 
      
      <% 
      if ((incidenteActual.getDescCategoria()!=null) && 
          (personalGialnet.equalsIgnoreCase("SI"))
        )
      {
      %>        
        <div id=subtitulos>Categoría: <%=incidenteActual.getDescCategoria()%></div>
      <%
      }
      %>
      
      <% 
      if ((incidenteActual.getDescTipo()!=null) && 
          (personalGialnet.equalsIgnoreCase("SI"))
        )
      {
      %>        
        <div id=subtitulos>Tipo: <%=incidenteActual.getDescTipo()%></div>
      <%
      }
      %>
    
      
      
    </div><!-- Fin playlist -->

    <div id=pie_pagina>&copy; Gialnet Servicios SL. Todos los Derechos Reservados
    </div>
    <div id=logo>
      <a href="http://www.gialnet.com">
        <img src="imagenes/logo_gialnet.gif" alt="Gialnet SL" width="104" height="23" border="0" />
      </a>
    </div>
    
  </div><!-- FIN content_tabla -->

</body>
</html>
