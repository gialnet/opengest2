<?php require('controlSesiones.inc');  ?>
<?php
	session_start();
	//header('Content-Type: text/xml; charset=ISO-8859-1'); 
	$host="lldd382.servidoresdns.net";
	$usuario="qee820";
	$password="Redmoon2010";
	$auth = false;
	$conectar=mysql_connect($host,$usuario,$password);
	$enlace=mysql_select_db("qee820",$conectar);
	
	mysql_query ("SET NAMES 'utf8'");
	
	$value=$_POST["inMovil"];
	$pass=$_POST["inPass"];
	
		
	$consulta=mysql_query("select * from colaboradores where movil='$value' ",$conectar);
		if (mysql_num_rows($consulta)>0)
		{
			$row = mysql_fetch_assoc($consulta);
			
			// Aún no ha introducido la contraseña
			if($row['passwd']==NULL)
			{
				$tiene_pass="no";
				// comprobamos el modelo del movil, en vez de la conseña que aún no tiene
				if($row['modelo']==$pass)
				{
					$auth = true;
				}
				else // no coincide con el modelo almacenado
				{
					header("Location: ../colaboradores/access_colabora.php");
				}
			}
			else // El usuario SI tiene una contraseña asignada
			{
				if ($row['passwd']!=$pass)
				{
					// goto forAcceso.html
					//echo "clave erronea";
					header("Location: ../colaboradores/access_colabora.php");
				}
				else // pass Ok, contraseña correcta
				{
				// goto MenuClientes
				//header("Location: colaboradores/palen_colabora.html");
				$tiene_pass="si";
				$auth = true;
				}
			}
		}
		else // el número de móvil no existe, no se ha dado de alta
		{		
			// goto 
			header("Location: ../colaboradores/access_colabora.php");
		}

	if ($auth) 
	{
		$_SESSION["colabora_movil"]=$_POST["inMovil"];
		$_SESSION["tiene_pass"]=$tiene_pass;
		$_SESSION["colabora_id"]=$row["id"];
		$_SESSION["apodo"]=$row["apodo"];
    	if (isset($_GET["url"])) 
			{
      		$url = $_GET["url"];
    		} 
		else 
			{
      		$url = "../colaboradores/panel_colaborador.php";
    		}

    	if (!isset($_COOKIE[session_name()])) 
			{
      		if (strstr($url, "?")) 
	  			{
        		header("Location: " . $url . "&" . session_name() . "=" . session_id());
      			} 
	  		else 
	  			{
        		header("Location: " . $url . "?" . session_name() . "=" . session_id());
      			}
    		} 
		else 
			{
      		header("Location: " . $url);
    		}
	}
?>

