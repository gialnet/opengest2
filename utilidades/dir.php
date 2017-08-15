<?php
/*Inserta en la primera linea de un archivo el contenido 
 *de $fileIn en el directorio puesto en dir
 *manual sobre las funciones utilizadas
 *en http://www.php.net/manual/en/function.file-put-contents.php
 */
$d = dir("mod");
echo "Handle: " . $d->handle . "\n";
echo "Path: " . $d->path . "\n";
while (false !== ($entry = $d->read())) {
	echo $d->path."\\".$entry."<br />";
	$fileIn = file_get_contents($d->path."\\".$entry);
	$fileIn = "<?php require('Redmoon_php/controlSesiones.inc');  ?>\n".$fileIn;
	file_put_contents($d->path."\\".$entry, $fileIn);

}
$d->close();
?>

