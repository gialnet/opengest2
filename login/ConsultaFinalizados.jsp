<%@ taglib uri="/WEB-INF/struts-html.tld" prefix="html"%>
<%@ taglib uri="/WEB-INF/struts-bean.tld" prefix="bean"%>
<%@ page import="java.sql.*,javax.sql.*,java.util.Vector,view.VistaIncidentes,
    javax.servlet.http.HttpSession,view.VistaClientes" 
    contentType="text/html;charset=windows-1252"%>
<%  
  //Vector con elementos del tipo VistaClientes. Contendrá información de todos 
  //los clientes actuales de la empresa
  Vector VClientes=(Vector)session.getAttribute("CLIENTES");
  VistaClientes registroCliente = new VistaClientes();       

  // instancia de la clase VistaIncidentes
  VistaIncidentes registro = new VistaIncidentes();
  // vector que contendrá elementos del tipo registro conteniendo por cada
  // elemento la información de una tupla de la consulta de incidentes
  Vector consulta = new Vector();
  consulta = (Vector) request.getAttribute("INCIDENTES");
  session.setAttribute("callerPage","ConsultaFinalizados");
%>
  <bean:define id="personalGialnet" name="LoginForm" property="personalGialnet" type="String">
  </bean:define>
  <bean:define id="supervisor" name="LoginForm" property="supervisor" type="String">
  </bean:define>
  <bean:define id="idClienteConsulta" name="LoginForm" property="idClienteConsulta" type="String">
  </bean:define>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Atenci&oacute;n al Cliente | Gialnet SL.</title>
<link href="css/login.css" rel="stylesheet" media="screen">
<link href="css/base.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="js/tableruler.js"></script>
<style type="text/css">
	
tr.ruled{
background-color:#CAEAFA;		
				} 
		
#playlist tr.ruled {
	background:#CAEAFA;
	color:#FFFFFF;
	background-image:url(imagenes/color_celda.gif); /* para colorear el rollover de las celdas*/
		}   

#playlist tr.ruled a {
width:100%;
}	

#playlist tr.ruled a:link {
color:#666666;
display:block;
}

#playlist tr.ruled a:visited {
color:#FFFFFF;
display:block;
}

#playlist tr.ruled a:hover 
{
display:block;
color:#666666;
background-color:#FAE25F;
} 

#playlist tr.ruled a:active 
{
display:block;
color:#666666;
background-color:transparent; 
} 

.ruler a:link, a:visited, a:hover{
text-decoration:none;
color:#666666;
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
<body onload="stripe('playlist', '#fff', '#edf3fe');tableruler();">

  <div id="usuario">
    <img src="imagenes/usuario.gif" width="12" height="14"/>
    <span class="usuario">Cliente: </span>
    <span class="nombre_usuario">
      <bean:write name="LoginForm" property="login"/>
    </span>
  </div> 
  
  <!-- refrescar la información recogida de la base de datos -->
  <div id=refresca>
    <html:link page="/RefreshFinalizados.do">
      <bean:message key="link.Refresh"/>
    </html:link>  
  </div>
  
  <% 
  if (personalGialnet.equalsIgnoreCase("SI"))
  {
  %>  
    <div id="Layer1" style="position:absolute; left:447px; top:150px; width:400px; height:31px; z-index:11">
      <table width="100%"  border="0" cellspacing="5" cellpadding="0">
      <html:form action="RefreshFinalizados.do">
        <tr>
          <td><div align="right">Ver por clientes:</div></td>
          <td>          
            <html:select property="idClienteConsulta" styleClass="campos_texto">          
            <% 
              for(int i=0; i<VClientes.size(); i++) 
              {
                registroCliente = (VistaClientes) VClientes.elementAt(i);
                if (registroCliente.getId()==Integer.parseInt(idClienteConsulta))
                {
            %>              
                  <option value="<%=registroCliente.getId()%>" selected="selected"><%=registroCliente.getNombre()%></option>
            <%
                }
                else
                {
            %> 
                  <option value="<%=registroCliente.getId()%>"><%=registroCliente.getNombre()%></option>
            <%
                }
              }
            %>
            </html:select>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <div align="right">
              <html:button property="boton" styleClass="boton2" value="Ver Finalizados" onclick="submit();"/>          
            </div>
          </td>
        </tr>
      </html:form>
      </table>  
    </div>
  <%
  }
  %>


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
        <!-- para poner un boton como activado asignarle el id=&quot;active&quot; -->
        <li>
          <html:link page="/AddIncidente.jsp">
            <bean:message key="link.AddIncidente"/>
          </html:link> 
        </li>
        <li id="active">
          <a href="#"><bean:message key="link.Finalizados"/>
          </a>
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
    </div>
    <div id="playlist">
      <table class="ruler" width="100%" border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <!-- sólo mostrar el cliente  y el nombre del contacto
                 si se conecta personal de Gialnet -->
            <%  if (personalGialnet.equalsIgnoreCase("SI"))
            { 
            %>
              <td width="11%" class="iniciotabla">Fecha:</td>
              <td width="12%">N&uacute;mero:</td>
              <td width="12%" >Cliente:</td>
              <td width="16%">Nombre:</td>
              <td width="46%">Asunto:</td>              
              <td width="4%">ver:</td>
            <%
            } 
            else
            {
            %>
              <td width="10%" class="iniciotabla">Fecha:</td>
              <td width="10%">N&uacute;mero:</td>              
              <td width="75%">Asunto:</td>              
              <td width="5%">ver:</td>
            <%
            }
            %>       
          </tr>
        </thead>
        <tbody>
          <!-- montamos la tabla utilizando los datos recibidos del LoginAction
             tras consultar la base de datos -->
          <% 
          for(int i=0; i<consulta.size(); i++) 
          {
            registro = (VistaIncidentes)consulta.elementAt(i);
        %>
          <tr>
            <td>
              <%= registro.getFecha()%>
            </td>
            <td>
              <%= registro.getNumero()%>
            </td>
            <%  
              if (personalGialnet.equalsIgnoreCase("SI"))
              {                
            %>
                <td>
                  <%= registro.getCliente()%>
                </td>
                <td>
                  <%= registro.getNombre()%>
                </td>
            <% 
              }
            %>            
            <td>
              <%= registro.getAsunto()%>
            </td>
            <td>              
              <html:form action="RefreshSeguimiento.do">
                <html:hidden property="idIncidente" value="<%=registro.getNumero()%>" />                
                <html:image styleClass="flecha" src="imagenes/flecha_nav.gif" border="0" onclick="javascript:submit()"/>                        
              </html:form>              
            </td>                
            
          </tr>
        <%
          }
        %>

        </tbody>
      </table>
    </div>
    
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
