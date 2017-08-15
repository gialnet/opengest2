<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema de Gestión de Expedientes</title>
<link href="css/login.css" rel="stylesheet" media="screen"/>
<style type="text/css">
<!--


#centro 
{
	position:relative;
	top:150px;
	background-image:url(imagenes/login.png);
	background-repeat:no-repeat;
	margin-top: 3px;
	width:474px;
	height:322px
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
  

#logo {
	position:absolute;
	float: right;
	margin-top:20px;
	top:20px;
	width: 130px;
	height: 156px;
	background: url(../img/mercury.png) no-repeat right top;
}
#header{
	position:absolute;
	top:0px;
	left:10%;
	width: 862px;
	height: 156px;
	margin: 0px auto;
	background: url(imagenes/bannerLGS.png) no-repeat left top;
}
body {
	margin: 0px;
	padding: 0px;
	background: #FFFFFF url(imagenes/filoAyS.png) repeat-x left top;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #888888;
}
-->
</style>
</head>
<body> 
	<div id="header">
	<div id="logo"></div>
		
	
</div>

  <div id="entrada">
    
    <div id="centro"> 
	 		<div class="espacio1">
  			
  		</div>
      <div style="width:385px; margin: 100px auto;" >
        <form method="post" action="../Redmoon_php/checkLogin.php">
          <div class="row">
            <span class="label"></span>
            <span class="formw">
              <table width="80%" border=0 cellPadding=0 cellSpacing=3 class="tablaborder">
              <TBODY>
                <tr class="marcadocero">
                <? 
                //mostrar 16 celdas, con 2 parejas coloreadas
                //Genero dos números del 0 al 3 para indicar el bloque
				srand(time());
				$xBloque1= (rand()%4);
				$xBloque2= (rand()%4);
				
				// Los dos números deben ser distintos. Si son el mismo, modifico uno de ellos.
				while ($xBloque1==$xBloque2)
                {
                  $xBloque2= (rand()%4);
                }
				
				//Genero dos números del 0 al 2 para las dos casillas activas de cada bloque
                $xCeldaBloque1=(rand()%3);
                $xCeldaBloque2=(rand()%3);
                $xCelda1=($xBloque1*4)+$xCeldaBloque1;
                $xCelda2=($xBloque2*4)+$xCeldaBloque2;
                if ($xCelda1>$xCelda2) //xCelda1 siempre será menor que xCelda2
                { 
                  $xTemp=$xCelda1;
                  $xCelda1=$xCelda2;
                  $xCelda2=$xTemp;
                }
				for ($i=0; $i<16; $i++)
                {
                  if (($i==$xCelda1) || ($i==$xCelda1+1) || ($i==$xCelda2) || ($i==$xCelda2+1))   
                  {
                    print("<td width=\"10\" class=\"marcadouno\">*</td>");
                  }
                  else                    
                  {
                    print("<td width=\"10\">*</td>");
                  } 
                            if ((($i % 4)==3) && ($i<15))
                  {
                    print("<td width=\"10\" class=\"espacio\">&nbsp;</td>");
                  }
                }
                ?>
                </tr>                
              </TBODY>
              </table>
            </span>
          </div>      
          <input type="hidden" name="posDi1" id="posDi1" property="posDigitos1" value="<?php echo $xCelda1+1; ?>" />
          <input type="hidden" name="posDi2" id="posDi2" property="posDigitos2" value="<?php echo $xCelda2+1; ?>" /> 
          <div class="row">
            <span class="label">Dígitos:</span>
            <span class="formw">    
              <input type="text" name="Digit1" id="Digit1" property="digitos1" maxlength="2" size="4" />
              <input type="text" name="Digit2" id="Digit2" property="digitos2" maxlength="2" size="4" />    
            </span>
          </div>
          <div class="row">
            <span class="label">Usuario:</span>
            <span class="formw">
              <input type="text" name="usuario" id="usuario" property="login" size="20" maxlength="20"/>
            </span>
          </div>
          <div class="row">
            <span class="label">Clave:</span>
            <span class="formw">
              <input type="password" name="passwd" id="passwd" property="clave" size="20" maxlength="15"/>
            </span>
          </div>
          <div class="row">
            <span class="formw">
              <input type="submit" name="Submit" value="Entrar" class="boton"/>
            </span>
          </div>			      
        </form>
      </div>  
    </div>
    <div id="final" class="gris">
      <a href="http://www.redmoon.es">Redmoon Consultores SL</a>
    </div>   
  
  </div>  

    
</body>
</html>