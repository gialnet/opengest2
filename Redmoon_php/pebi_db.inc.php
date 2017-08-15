<?php 

function db_connect()
{
// use constants defined in anyco_cn.inc
$conn = oci_connect(ORA_CON_UN, ORA_CON_PW, ORA_CON_DB, 'AL32UTF8');
if (!$conn) {
db_error(null, __FILE__, __LINE__); 
}
return($conn);
}

//
//
//
function db_do_query($conn, $statement, $resulttype, $bindvars = array())
{
$stid = oci_parse($conn, $statement);
if (!$stid) {
	db_error($conn, __FILE__, __LINE__);
	}

// Bind the PHP values to query bind parameters
foreach ($bindvars as $b) {

// create local variable with caller specified bind value
$$b[0] = $b[1];

// oci_bind_by_name(resource, bv_name, php_variable, length)
$r = oci_bind_by_name($stid, ":$b[0]", $$b[0], $b[2]);

if (!$r) {
	db_error($stid, __FILE__, __LINE__);
	}
}

$r = oci_execute($stid, OCI_DEFAULT);
if (!$r) {
	db_error($stid, __FILE__, __LINE__);
	}

$r = oci_fetch_all($stid, $results, null, null, $resulttype);
return($results);
}


// $r is the resource containing the error.
// Pass no argument or false for connection errors
function db_error($r = false, $file, $line)
{
$err = $r ? oci_error($r) : oci_error();
if (isset($err['message'])) {
$m = htmlentities($err['message']);
}
else {
$m = 'Eror desconocido en DB';
}
echo '<p><b>Error</b>: en la linea '.$line.' of '.$file.'</p>';
echo '<pre>'.$m.'</pre>';
exit;
}


// Return subset of records
function db_get_page_data($conn, $q1, $current = 1,$rowsperpage = 1, $bindvars = array())
{

// This query wraps the supplied query, and is used
// to retrieve a subset of rows from $q1
$query = 'SELECT *
FROM (SELECT A.*, ROWNUM AS RNUM
FROM ('.$q1.') A
WHERE ROWNUM <= :LAST)
WHERE :FIRST <= RNUM';

// Set up bind variables.
array_push($bindvars, array('FIRST', $current, -1));
array_push($bindvars,array('LAST', $current+$rowsperpage-1, -1));
$r = db_do_query($conn, $query, OCI_FETCHSTATEMENT_BY_ROW, $bindvars);
return($r);
}

//
// Ejecutar un comando SQL
//
function db_execute_statement($conn, $statement, $bindvars = array())
{

$stid = oci_parse($conn, $statement);

if (!$stid) { db_error($conn, __FILE__, __LINE__); }

// Bind parameters
foreach ($bindvars as $b) {

	// create local variable with caller specified bind value
	$$b[0] = $b[1];

	$r = oci_bind_by_name($stid, ":$b[0]", $$b[0], $b[2]);

	if (!$r) {db_error($stid, __FILE__, __LINE__); }
}

$r = oci_execute($stid);
if (!$r) {
db_error($stid, __FILE__, __LINE__);
}
return($r);
}

?>
