<?php
session_start();

if(!isset($_SESSION["acceso"]))
	 header("Location: login/login.php");

// variable del rol del usuario 
$Rol_controlSesiones=$_SESSION["rol"];
?>