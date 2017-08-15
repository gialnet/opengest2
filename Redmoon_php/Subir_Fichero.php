<?php

$configuracion='c:/LGS/Archivos/';

$ruta=$configuracion.date('o');

// el año
if (ExisteYear($ruta))
	echo "Existe el año".$ruta.'<BR />';
else die();
	
// el mes
$ruta=$configuracion.date('o').'/'.date('m');
if (ExisteMes($ruta))
	echo  "Existe el mes".$ruta.'<BR />';

// la semana
$ruta=$configuracion.date('o').'/'.date('m').'/'.date('W');
if (ExisteWeek($ruta))
	echo "Existe la semana".$ruta.'<BR />';
	
	
	
	
/*
 * Funciones de comprobación y creación de carpetas
 */
	
//
//
//
function GetPathUpload()
{

$configuracion='c:/LGS/Archivos/';

$ruta=$configuracion.date('o');

// el año
if (!ExisteYear($ruta))
	die();
	
// el mes
$ruta=$configuracion.date('o').'/'.date('m');
if (!ExisteMes($ruta))
	die();

// la semana
$ruta=$configuracion.date('o').'/'.date('m').'/'.date('W');
if (!ExisteWeek($ruta))
	die();

	return $ruta;
}
//
// Comprobar si existe la carpeta del año o crearla
//
function ExisteYear($num_year){

	$existe_ruta=false;
	$intentos=0;

	// mientras no se cree la ruta o lo intentemos tres veces

	while ((!$existe_ruta) && ($intentos < 3))
	{
	$intentos++;
	
	if (ExisteDir($num_year))
		{
		// Existe la carpeta
		$existe_ruta=true;
		return true;
		}
	else
		{
			if (!CrearDir($num_year,'0777')){
				echo "No se ha podido crear la carpeta";
				return false;
			}
			// volver a comprobar si se ha creado
		}
	}
	
}
//
// Comprobar si existe la carpeta del mes
//
function ExisteMes($num_mes){

	$existe_ruta=false;
	$intentos=0;

	// mientras no se cree la ruta o lo intentemos tres veces

	while (!$existe_ruta && $intentos < 3)
	{
	$intentos++;
	
	if (ExisteDir($num_mes))
		{
		// Existe la carpeta
		$existe_ruta=true;
		return true;
		}
	else
		{
			if (!CrearDir($num_mes,'0777')){
			// volver a comprobar si se ha creado
			echo "No se ha podido crear la carpeta";
				return false;
			}
		}
	}
	
}
//
// Comprobar si existe la carpeta de la semana
//
function ExisteWeek($num_week){

	$existe_ruta=false;
	$intentos=0;

	// mientras no se cree la ruta o lo intentemos tres veces

	while (!$existe_ruta && $intentos < 3)
	{
	$intentos++;
	
	if (ExisteDir($num_week))
		{
		// Existe la carpeta
		$existe_ruta=true;
		return true;
		}
	else
		{
			if (!CrearDir($num_week)){
			// volver a comprobar si se ha creado
			echo "No se ha podido crear la carpeta";
				return false;
			}
		}
	}
	
}

//
// Crear un directorio
//
function CrearDir($ruta){
	
	return mkdir($ruta,'0777');
	
}

//
// Existe un directorio
//
function ExisteDir($ruta){
	
	if (file_exists($ruta))
	    return true;
	else 
	  return false;
}


?>