//
// Siguiente p�gina de datos
//
function GotoNext(){
	xPag+=14;
	LeeConsulta('Todo');
}

//
// P�gina de datos atras
//
function GotoBack()
{
	xPag-=14;
	if (xPag <=1 )
		xPag=1;
	
	LeeConsulta('Todo');
}