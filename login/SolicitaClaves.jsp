<%@ taglib uri="/WEB-INF/struts-html.tld" prefix="html"%><%@ page contentType="text/html;charset=windows-1252"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema de Atenci&oacute;n al Cliente. GIALNET SL</title>
<link href="css/login.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--

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
      <div style="width:370px; margin: 0px auto;" > 
        <html:form action="Claves" method="post">        
	      	<div class="row">
            <span class="label">Su nombre:
            </span>
            <span class="formw">
              <html:text property="nombre" size="20" maxlength="30"/>
            </span>
          </div>
          <div class="row">
            <span class="label">Su email:
            </span>
            <span class="formw">
              <html:text property="email" size="20" maxlength="50"/>
            </span>
          </div>
          <div class="row">
            <span class="formw">
              <input type="submit" name="Submit" value="Solicitar claves" class="boton"/>
            </span>
          </div>			
        </html:form>
      </div>  
    </div>
    <div id=final class="gris">
      <a href="http://www.gialnet.com">Gialnet  SL</a> 
    </div>
    <div id=error>
      <html:errors/>
    </div>
  </div>
</body>
</html>

