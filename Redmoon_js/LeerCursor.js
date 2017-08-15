//
// Antonio Pérez Caballero
// 4 Diciembre 2008
//
// Leer de un array de caracteres para pasar los valores a campos de formulario HTML
// El primer argumento es un Array que contiene los objetos html input text
// el segundo un String con los valores separados por el signo +
//
function PutCursorInForm(ArrayCampos, vCursor)
{

var ArrayValores=vCursor.split('+');

//alert(ArrayValores[0]);

for (x=0; x<=(ArrayValores.length-1); x++)
	{
	ArrayCampos[x].value=ArrayValores[x];	
	}
	

} // function LeerCursor()


//
// Leer los valores de la tabla de clientes y pasarlos a su formulario HTML
//
function LeerCliente(ListaIDs, vCursor)
{

	var ArrayIDs=ListaIDs.split('+');
	var ArrayCampos= new Array(ArrayIDs.length);
	var x=0;
	

for (x=0; x<=(ArrayIDs.length-1); x++)
	{
	ArrayCampos[x]=document.getElementById(ArrayIDs[x]);
	}


PutCursorInForm(ArrayCampos, vCursor);

}

//
// Rellenar una lista de campos de formulario por su ID
//
function PutFormClientes()
{
	
	var ListaCamposIDs='Nombre+Nacionalidad+PaisOrigen+Fecha+PaisDomicilio+Poblacion+DIRECCION+Portal+email+Telefono+movil+EstadoCivil+RegimenEconomico+Profesion+CodigoCliente+Entidad+Oficina+DC+Cuenta+Latitud+Longitud';
	var vCursor='PEREZ CABALLERO ANTONIO+ESPAÑOLA';
	
LeerCliente(ListaCamposIDs, vCursor);
}

