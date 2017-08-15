//
// Siguiente página de datos
//
function GotoNext(){
	xPag+=14;
	LeeConsulta('Todo');
}

//
// Página de datos atras
//
function GotoBack()
{
	xPag-=14;
	if (xPag <=1 )
		xPag=1;
	
	LeeConsulta('Todo');
}