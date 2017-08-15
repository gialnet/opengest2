<?
//control de acceso autorizado para el interfaz web
if (isset($_SESSION["acceso"])){
   if ($_SESSION["acceso"]==true)
   		$pasar='Ok';
   else exit(-4); // no autorizado
}
else exit(-1000); // no se ha hecho login

?>