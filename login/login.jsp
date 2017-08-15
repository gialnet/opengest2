<%@ taglib uri="/WEB-INF/struts-bean.tld" prefix="bean"%>
<%@ taglib uri="/WEB-INF/struts-html.tld" prefix="html"%>
<%@ page import="java.util.*" contentType="text/html;charset=iso-8859-1"%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema de Atenci&oacute;n al Cliente. GIALNET SL</title>
<link href="css/login.css" rel="stylesheet" media="screen"/>
<style type="text/css">
<!--

#top
{
	background-image:url(imagenes/top_login_03.gif);
	background-repeat:no-repeat;
	height: 54px;
	width: 391px;
}

#centro 
{
	background-image:url(imagenes/fondo_login_06.jpg);
	background-repeat:no-repeat;
	margin-top: 3px;
	width:391px;
	height:197px
	}
	
.marcadocero 
{
	FONT-WEIGHT: normal; FONT-SIZE: 10px; COLOR:#006699; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; BACKGROUND-COLOR: #ffffff; TEXT-ALIGN: center
}

.marcadouno 
{
	FONT-WEIGHT: normal; FONT-SIZE: 10px; COLOR: #ffffff; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; BACKGROUND-COLOR:#FFCC00; TEXT-ALIGN: center
}

.espacio 
{
	background-color:#4D9BC1;
}

.tablaborder 
{
	BORDER:0px none;
}

div.row span.label 
{
  float: left;
  width: 70px;
  text-align: right;
}

div.row span.formw 
{
	float: right;
	width: 300px;
	text-align: left;	
} 
  
-->
</style>
</head>
<body> 

  <div id="entrada">
    <div id=top>
    </div>
    <div id=centro> 
	 		<div class="espacio1">
  			&nbsp;
  		</div>
      <div style="width:385px; margin: 0px auto;" >  
        <html:form action="Login">
          <div class="row">
            <span class="label"></span>
            <span class="formw">
              <table width="80%" border=0 cellPadding=0 cellSpacing=3 class="tablaborder">
              <TBODY>
                <tr class="marcadocero">
                <% 
                //mostrar 16 celdas, con 2 parejas coloreadas
                //Genero dos números del 0 al 3 para indicar el bloque
                Random generadorInt = new Random();
                int xBloque1,xBloque2,xCelda1,xCelda2,xCeldaBloque1,xCeldaBloque2;      
      
                xBloque1=generadorInt.nextInt(4);
                xBloque2=generadorInt.nextInt(4);
      
                // Los dos números deben ser distintos. Si son el mismo, modifico uno de ellos.
                while (xBloque1==xBloque2)
                {
                  xBloque2=generadorInt.nextInt(4);
                }
  	
                //Genero dos números del 0 al 2 para las dos casillas activas de cada bloque
                xCeldaBloque1=generadorInt.nextInt(3);
                xCeldaBloque2=generadorInt.nextInt(3);      
                xCelda1=(xBloque1*4)+xCeldaBloque1;
                xCelda2=(xBloque2*4)+xCeldaBloque2;
                if (xCelda1>xCelda2) //xCelda1 siempre será menor que xCelda2
                { 
                  int xTemp=xCelda1;
                  xCelda1=xCelda2;
                  xCelda2=xTemp;
                }
  	
                for (int i=0;i<16;i++)
                {
                  if ((i==xCelda1) || (i==xCelda1+1) || (i==xCelda2) || (i==xCelda2+1))   
                  {
                    out.println("<td width=\"10\" class=\"marcadouno\">*</td>");
                  }
                  else                    
                  {
                    out.println("<td width=\"10\">*</td>");
                  } 
                            if (((i % 4)==3) && (i<15))
                  {
                    out.println("<td width=\"10\" class=\"espacio\">&nbsp;</td>");
                  }
                } 
                %>
                </tr>                
              </TBODY>
              </table>
            </span>
          </div>      
          <html:hidden property="posDigitos1" value="<%=xCelda1+1%>" />
          <html:hidden property="posDigitos2" value="<%=xCelda2+1%>" /> 
          <div class="row">
            <span class="label">Dígitos:</span>
            <span class="formw">    
              <html:password property="digitos1" maxlength="2" size="4" />
              <html:password property="digitos2" maxlength="2" size="4" />    
            </span>
          </div>
          <div class="row">
            <span class="label">Usuario:</span>
            <span class="formw">
              <html:text property="login" size="20" maxlength="20"/>
            </span>
          </div>
          <div class="row">
            <span class="label">Clave:</span>
            <span class="formw">
              <html:password property="clave" size="20" maxlength="15"/>
            </span>
          </div>
          <div class="row">
            <span class="formw">
              <input type="submit" name="Submit" value="Entrar" class="boton"/>
            </span>
          </div>			      
        </html:form>
      </div>  
    </div>
    <div id=final class="gris">
<!--      <html:link page="/SolicitaClaves.jsp">
        <bean:message key="link.SolicitaClaves"/>
      </html:link>
-->
      <a href="http://www.gialnet.com">Gialnet  SL</a> 
    </div>
    
    <div id=error>
      <html:errors />
    </div>
  
  </div>  

    
</body>
</html>