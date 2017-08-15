<?
// control de acceso autorizado para web services
if (isset($_SESSION["usuario"])){
   if ($_SESSION["usuario"]=='WEBSERVICES')
   		$pasar='Ok';
   else exit(-1); // usuario irreconocible
}
else exit(-1000); // no se ha hecho login

if (isset($_SESSION["rol"])){
   if ($_SESSION["rol"]==1521)
   		$pasar='Ok';
   else exit(-2); // rol erroneo
}
else exit(-1000); // no se ha hecho login

if (isset($_SESSION["idRol"])){
   if ($_SESSION["idRol"]==1521)
   		$pasar='Ok';
   else exit(-3); // idRol erroneo
}
else exit(-1000); // no se ha hecho login
?>