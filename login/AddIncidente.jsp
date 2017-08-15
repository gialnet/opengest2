<%@ taglib uri="/WEB-INF/struts-html.tld" prefix="html"%>
<%@ taglib uri="/WEB-INF/struts-bean.tld" prefix="bean"%>
<%@ page import="java.sql.*,javax.sql.*,java.util.Vector,view.VistaTiposIncidentes,
    javax.servlet.http.HttpSession,org.apache.struts.upload.MultipartRequestHandler,
    view.VistaCategoriasIncidentes" 
    contentType="text/html; charset=iso-8859-1"
%>
<%  
  // instancia de la clase VistaTiposIncidentes
  VistaTiposIncidentes registroTipos = new VistaTiposIncidentes();
  // vector que contendrá elementos del tipo registro conteniendo por cada elemento 
  // la información de una tupla de la consulta de los tipos de incidentes
  Vector consultaTipos = (Vector) request.getSession().getAttribute("tiposIncidentes");      
  // instancia de la clase VistaCategoriasIncidentes
  VistaCategoriasIncidentes registroCategorias = new VistaCategoriasIncidentes();
  // vector que contendrá elementos del tipo registro conteniendo por cada elemento
  // la información de una tupla de la consulta de las categorias de incidentes
  Vector consultaCategorias = (Vector) request.getSession().getAttribute("categoriasIncidentes");      
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
<link href="css/base.css" rel="stylesheet" type="text/css" />
<link href="css/login.css" rel="stylesheet" type="text/css" />
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
        <li id="active">
          <a href="#"><bean:message key="link.AddIncidente"/>
          </a>
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

      <div id=titulos></div>
    </div>

    <div id="playlist">
      <div class="espacio1">&nbsp;
  		</div>
      <div style="width:600px; margin: 0px auto"; > 
          
        <html:form action="/AddNewIncidente.do" method="POST" enctype="multipart/form-data">                
          <div class="row">
            <span class="label">Titulo:
            </span>
            <span class="formw">            
              <html:text property="titulo" maxlength="80" size="80" />            
            </span>
          </div>
			
          <div class="row">
            <span class="label">Archivo:
            </span>
            <span class="formw">
              <html:file property="fichero" styleClass="campos_file" size="50" />            
            </span>			
          </div>
			
          <div class="row">
            <span class="label">Explicación:
            </span>
            <span class="formw">
              <html:textarea property="explicacion" cols="80" rows="8" styleClass="campos_texto" 
               onblur="this.value = this.value.slice(0, 2048)" />              
            </span>			
          </div>
          
          <% 
            if (personalGialnet.equalsIgnoreCase("SI"))
            {
          %>
              <div class="row">
                <span class="label">Categoría:
                </span>
                
                <span class="formw">
                  <html:select property="categoria" styleClass="campos_texto">                  
                    <option value="0">Seleccione una categoría para la incidencia
                    </option>
                    <% 
                    for(int i=0; i<consultaCategorias.size(); i++) 
                    {
                      registroCategorias = (VistaCategoriasIncidentes)consultaCategorias.elementAt(i);                                            
                    %>                    
                      <option value="<%=registroCategorias.getId()%>"><%=registroCategorias.getDescripcion()%>
                      </option>
                    <%
                    }
                    %>
                  </html:select>
                </span> 
              </div>

              <div class="row">
                <span class="label">Tipo:
                </span>
                
                <span class="formw">
                  <html:select property="tipo" styleClass="campos_texto">                  
                    <option value="0">Seleccione un tipo de incidencia
                    </option>
                    <% 
                    for(int i=0; i<consultaTipos.size(); i++) 
                    {
                      registroTipos = (VistaTiposIncidentes)consultaTipos.elementAt(i);                                            
                    %>                    
                      <option value="<%=registroTipos.getId()%>"><%=registroTipos.getDescripcion()%>
                      </option>
                    <%
                    }
                    %>
                  </html:select>
                </span> 
              </div>

          <%
            }
            else
            {
              %>
                <html:hidden property="categoria" value="0" />
                <html:hidden property="tipo" value="0" />
              <%
            }
          %>
			
        <div class="row">
          <span class="formw">
            <input type="submit" name="Submit" value="Añadir nuevo tema" class="boton"/>
          </span>
        </div>			
			
		  </html:form>
		</div> 
    
    
    <div class="espacio1"></div>
    </div>
    
    <div id=error>
      <html:errors/>            
    </div>    
    
    <div id=pie_pagina>&copy; Gialnet Servicios SL. Todos los Derechos Reservados
    </div>
    <div id=logo><a href="http://www.gialnet.com"><img src="imagenes/logo_gialnet.gif" alt="Gialnet SL" width="104" height="23" border="0" /></a>
    </div>   
    
    
  </div><!-- FIN content_tabla -->

</body>
</html>

