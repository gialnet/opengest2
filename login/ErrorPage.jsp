<%@ taglib uri="/WEB-INF/struts-html.tld" prefix="html"%>
<%@ taglib uri="/WEB-INF/struts-bean.tld" prefix="bean"%>
<%@ page contentType="text/html;charset=windows-1252"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Solicitar Contrase&ntilde;a. GIALNET SL</title>
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
      <div style="width:370px; margin: 0px auto; " > 
        <p>
          <strong>Sus claves de acceso no han
          </strong></p>
          <p>
            <strong>sido validadas por el sistema.</strong>
          </p>
        <div class="botoncillo">
          <html:link page="/login.jsp">
            <bean:message key="link.login"/>
          </html:link>
        </div>
        <p>&nbsp;</p>
      </div>  
    </div>
    <div id=final class="gris">
    <!--  <html:link page="/SolicitaClaves.jsp">
        <bean:message key="link.SolicitaClaves"/>
      </html:link>
    -->
      <a href="http://www.gialnet.com">Gialnet  SL</a> 
    </div>
  </div>
 
</body>
</html>


