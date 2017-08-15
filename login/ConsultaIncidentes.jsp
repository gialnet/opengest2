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
  
  session.setAttribute("callerPage","ConsultaIncidentes");
%>
  <bean:define id="personalGialnet" name="LoginForm" property="personalGialnet" type="String">
  </bean:define>
  <bean:define id="supervisor" name="LoginForm" property="supervisor" type="String">
  </bean:define>
  <bean:define id="idClienteConsulta" name="LoginForm" property="idClienteConsulta" type="String">
  </bean:define>
  <bean:define id="ver_Pendientes" name="LoginForm" property="verPendientes" type="String">
  </bean:define>
  <bean:define id="ver_Leidos" name="LoginForm" property="verLeidos" type="String">
  </bean:define>
  <bean:define id="ver_Contestados" name="LoginForm" property="verContestados" type="String">
  </bean:define>
  <bean:define id="ver_Realizados" name="LoginForm" property="verRealizados" type="String">
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

.boton2 {font-size:9px;
color:#006699;
border:1px solid #7F9DB9;
background-color:#FFFFFF;
width:80px;
margin-right:40px;
height:20px;
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

function preparaConsulta(){
  if (document.getElementById('verPend').checked) {
    document.getElementById('verPendientes').value="SI";
  }
  else{
    document.getElementById('verPendientes').value="NO";
  }
  
  if (document.getElementById('verLeido').checked) {
    document.getElementById('verLeidos').value="SI";
  }
  else{
    document.getElementById('verLeidos').value="NO";
  }
  
  if (document.getElementById('verContest').checked) {
    document.getElementById('verContestados').value="SI";
  }
  else{
    document.getElementById('verContestados').value="NO";
  }

  if (document.getElementById('verRealiz').checked) {
    document.getElementById('verRealizados').value="SI";
  }
  else{
    document.getElementById('verRealizados').value="NO";
  }
}
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
    <html:link page="/RefreshIncidentes.do">
      <bean:message key="link.Refresh"/>
    </html:link>  
  </div>
  
  <% 
  if (personalGialnet.equalsIgnoreCase("SI"))
  {
  %>  
    <div id="Layer1" style="position:absolute; left:447px; top:150px; width:400px; height:31px; z-index:11">
      <table width="100%"  border="0" cellspacing="5" cellpadding="0">
      <html:form action="RefreshIncidentes.do">
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
          <td><div align="right">Estados:</div></td>
          <td>
          <% if (ver_Pendientes.equalsIgnoreCase("SI")) { %>
            <input type="checkbox" id="verPend" checked="true">Pend.</input>
          <% }else{ %>
            <input type="checkbox" id="verPend">Pendiente</input>
          <%} %>

          <% if (ver_Leidos.equalsIgnoreCase("SI")) { %>
            <input type="checkbox" id="verLeido" checked="true">Leido</input>
          <% }else{ %>
            <input type="checkbox" id="verLeido">Leido</input>
          <%} %>
          
          <% if (ver_Contestados.equalsIgnoreCase("SI")) { %>
            <input type="checkbox" id="verContest" checked="true">Contest.</input>
          <% }else{ %>
            <input type="checkbox" id="verContest" >Contest.</input>
          <%} %>
          
          <% if (ver_Realizados.equalsIgnoreCase("SI")) { %>
            <input type="checkbox" id="verRealiz" checked="true">Realiz.</input>
          <% }else{ %>
            <input type="checkbox" id="verRealiz">Realiz.</input>
          <%} %>
           
          </td>
        </tr>
        <html:hidden property="verPendientes" value=""/>
        <html:hidden property="verLeidos" value=""/>
        <html:hidden property="verContestados" value=""/>
        <html:hidden property="verRealizados" value=""/>
        
        <tr>
          <td colspan="2">
            <div align="right">
              <html:button property="boton" styleClass="boton2" value="Ver Incidentes" onclick="preparaConsulta();submit();"/>          
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
    <img src="imagenes/cabecera_01.jpg" width="262" height="192"/><img src="imagenes/cabecera_03.gif" width="466" height="192" alt="Nuevo número de atención telefónica a partir del 21 de Marzo" />
  </div>
  <div id="content_tabla">
    <div id="navcontainer">
      <ul id="navlist">
        <li id="active">
          <a href="#"><bean:message key="link.Temas"/>
          </a>
        </li>
        <!-- para poner un boton como activado asignarle el id=&quot;active&quot; -->
        <li>
          <html:link  page="/AddIncidente.jsp">
            <bean:message key="link.AddIncidente"/>
          </html:link> 
        </li>
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
              <td width="11%">Estado:</td>
              <td width="4%">ver:</td>
            <%
            } 
            else
            {
            %>
              <td width="10%" class="iniciotabla">Fecha:</td>
              <td width="10%">N&uacute;mero:</td>              
              <td width="65%">Asunto:</td>
              <td width="10%">Estado:</td>
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
            <%  
              if (registro.getEstado().equalsIgnoreCase("Pendiente"))
              {
              %>
                <td class="pendiente"><%=registro.getEstado()%></td>
                <% 
                  if (personalGialnet.equalsIgnoreCase("NO"))
                  { 
                %> 
                    <td>  
                      <html:form action="RefreshSeguimiento.do">                        
                        <html:hidden property="idIncidente" value="<%=registro.getNumero()%>" />                        
                        <html:image styleClass="flecha" src="imagenes/flecha_nav.gif" border="0" onclick="javascript:submit()"/>                                              
                      </html:form>  
                    </td>
                <%
                  }
                  else
                  {
                %>
                    <td>
                      <html:form action="RefreshSeguimiento.do">
                        <html:hidden property="idIncidente" value="<%=registro.getNumero()%>" />                        
                        <html:image styleClass="flecha" src="imagenes/flecha_intermitente.gif" border="0" onclick="javascript:submit()"/>                        
                      </html:form>
                    </td>
                <%
                }                
              }
              else if (registro.getEstado().equalsIgnoreCase("Leído"))
              {
              %>
                <td class="leido"><%=registro.getEstado()%></td>
                <% 
                  if (personalGialnet.equalsIgnoreCase("NO"))
                  {
                %>
                    <td>
                      <html:form action="RefreshSeguimiento.do">
                        <html:hidden property="idIncidente" value="<%=registro.getNumero()%>" />                        
                        <html:image styleClass="flecha" src="imagenes/flecha_nav.gif" border="0" onclick="javascript:submit()"/>                        
                      </html:form>
                    </td>
                <%
                  }
                  else
                  {
                %>
                    <td>
                      <html:form action="RefreshSeguimiento.do">
                        <html:hidden property="idIncidente" value="<%=registro.getNumero()%>" />                        
                        <html:image styleClass="flecha" src="imagenes/flecha_intermitente.gif" border="0" onclick="javascript:submit()"/>                        
                      </html:form>
                    </td>
                <%
                }                
              }
              else if (registro.getEstado().equalsIgnoreCase("Contestado"))
              {
              %>
                <td class="contestado"><%=registro.getEstado()%></td>
                <% 
                  if (personalGialnet.equalsIgnoreCase("SI"))
                  {
                %>
                    <td>
                      <html:form action="RefreshSeguimiento.do">
                        <html:hidden property="idIncidente" value="<%=registro.getNumero()%>" />                        
                        <html:image styleClass="flecha" src="imagenes/flecha_nav.gif" border="0" onclick="javascript:submit()"/>                        
                      </html:form>
                    </td>
                <%
                  }
                  else
                  {
                %>
                    <td>
                      <html:form action="RefreshSeguimiento.do">
                        <html:hidden property="idIncidente" value="<%=registro.getNumero()%>" />                        
                        <html:image styleClass="flecha" src="imagenes/flecha_intermitente.gif" border="0" onclick="javascript:submit()"/>                        
                      </html:form>
                    </td>
                <%
                }                
              }
              else if (registro.getEstado().equalsIgnoreCase("Realizado"))
              {
              %>
                <td class="finalizado"><%=registro.getEstado()%></td>
                <% 
                  if (personalGialnet.equalsIgnoreCase("SI"))
                  {
                %>
                    <td>
                      <html:form action="RefreshSeguimiento.do">
                        <html:hidden property="idIncidente" value="<%=registro.getNumero()%>" />                        
                        <html:image styleClass="flecha" src="imagenes/flecha_nav.gif" border="0" onclick="javascript:submit()"/>                        
                      </html:form>
                    </td>
                <%
                  }
                  else
                  {
                %>
                    <td>
                      <html:form action="RefreshSeguimiento.do">
                        <html:hidden property="idIncidente" value="<%=registro.getNumero()%>" />                        
                        <html:image styleClass="flecha" src="imagenes/flecha_intermitente.gif" border="0" onclick="javascript:submit()"/>                        
                      </html:form>
                    </td>
                <%
                }                
              }
            %>          
            
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