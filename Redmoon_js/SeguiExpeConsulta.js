//
//Leer datos de Oracle via Ajax y PHP
//
function PutDataAsuntos(url,dataToSend){
	
	var pageRequest = false;
	
	if (window.XMLHttpRequest) {
		pageRequest = new XMLHttpRequest();
	}
	else if (window.ActiveXObject){ 
		try {
			pageRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} 
		catch (e) {
			try{
				pageRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e){}
		}
	}
	else return false;
	
	pageRequest.onreadystatechange=function() {	ProcRespAsuntos(pageRequest);};
	
	if (dataToSend) {		
		pageRequest.open('POST',url,true);
	pageRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		pageRequest.send(dataToSend);
	}
	else {
		pageRequest.open('GET',url,true);
		pageRequest.send(null);
	}
}


//
//Recibe la respuesta del servidor
//
function ProcRespAsuntos(pageRequest){

	
	if (pageRequest.readyState == 4)	
	{
		if (pageRequest.status==200)
		{
			// despues de grabar dejar las cosas como estaban		
			//DesctivaInterfazGrabando();		
			
			//alert(pageRequest.responseText);
			if (pageRequest.responseText=='Error')
			    alert(pageRequest.responseText);
			else
			{
			    StringSerializado=pageRequest.responseText;
			    //alert(StringSerializado);
			    
			    deleteLastRow('oTabla');
			    AddRowTable();
			    
		    }
		    	

		}
		else if (pageRequest.status == 404) 
			alert('error 404');
		else 
			alert('Ha ocurrido un problema.');
	}
	else return;
}
//
//
//
function AddRowTable()
{
	var ArrayColumnas=StringSerializado.split('|');
	var tbl = document.getElementById('oTabla');
	//var row = tbl.insertRow(tbl.rows.length);

	//alert(StringSerializado);
	//alert(ArrayColumnas.length);
	j=1;
	for(x=0; x<=ArrayColumnas.length-2; x+=8)
	    {
				row = tbl.insertRow(tbl.rows.length);
				row.setAttribute('id', 'ofila'+j);
				row.setAttribute('onclick', 'GetFila(this.id);');
				row.setAttribute('onMouseOver', 'FilaActiva(this.id);');
				row.setAttribute('onMouseOut', 'FilaDesactivar(this.id);');
				j++;
	
			// ID 
			cellText =  row.insertCell(0);
			textNode = document.createTextNode(tbl.rows.length - 1);
			cellText.appendChild(textNode);
			cellText.innerHTML=ArrayColumnas[0+x];
			
			//
			// CASO EXPECIAL SALTAMOS EL SEGUNDO CAMPO NE Y NO LO MOSTRAMOS
			//
			
			
			// FASE-TIPO DE MOVIMIENTO
			cellText =  row.insertCell(1);
			textNode = document.createTextNode(tbl.rows.length - 1);
			cellText.appendChild(textNode);
			cellText.innerHTML=ArrayColumnas[2+x];
			
			// DESCRIPCION
			cellText =  row.insertCell(2);
			textNode = document.createTextNode(tbl.rows.length - 1);
			cellText.appendChild(textNode);
			cellText.innerHTML=ArrayColumnas[3+x];
			
			// FECHA DE MOVIMIENTO
			cellText =  row.insertCell(3);
			textNode = document.createTextNode(tbl.rows.length - 1);
			cellText.appendChild(textNode);
			cellText.innerHTML=ArrayColumnas[4+x];
			
			// IMPORTE
			cellText =  row.insertCell(4);
			textNode = document.createTextNode(tbl.rows.length - 1);
			cellText.appendChild(textNode);
			cellText.setAttribute('align', 'right');
			cellText.innerHTML=ArrayColumnas[5+x];
			
			// DH
			cellText =  row.insertCell(5);
			textNode = document.createTextNode(tbl.rows.length - 1);
			cellText.appendChild(textNode);
			if (ArrayColumnas[6+x]=='I')
				cellText.innerHTML='<img title="Nota Informativa" alt="Nota Informativa" src="Redmoon_img/imgSegui/info.png">';
			else if (ArrayColumnas[6+x]=='P')
				cellText.innerHTML='<img title="Comentario" src="Redmoon_img/imgSegui/coment.png">';
			else if (ArrayColumnas[6+x]=='T')
				cellText.innerHTML='<img src="Redmoon_img/imgSegui/ir.png">';
                        else if (ArrayColumnas[6+x]=='H')
				cellText.innerHTML='<img title="Apunte Haber" src="Redmoon_img/imgSegui/h.png">';
                        else if (ArrayColumnas[6+x]=='D')
                            cellText.innerHTML='<img title="Apunte Debe" src="Redmoon_img/imgSegui/d.png">';
			else
				cellText.innerHTML=ArrayColumnas[6+x];
			
			// DOC
			cellText =  row.insertCell(6);
			textNode = document.createTextNode(tbl.rows.length - 1);
			cellText.appendChild(textNode);
			if (ArrayColumnas[7+x]=='S')
				cellText.innerHTML='<img title="Ver Documento Adjunto" alt="Ver Documento Adjunto" src="Redmoon_img/imgSegui/pdf.png" WIDTH="25" HEIGHT="25">';
			else
				cellText.innerHTML='';
			
		}

}
//
//tblName
//
function deleteLastRow(tblName)
{
var tbl = document.getElementById(tblName);
//if (tbl.rows.length > 1) tbl.deleteRow(tbl.rows.length - 1);
for(x=(tbl.rows.length-1); x>0; x--)
    tbl.deleteRow(x);
}
//
//pulsación de las teclas
//
function detectar_tecla(e, opcion){

if (window.event)
	tecla=e.keyCode;
else
	tecla=e.which;

if(tecla==13)
{
	if (window.event)
	{
		e.returnValue=false;
		window.event.cancelBubble = true;
	}
	else
	{
		e.preventDefault();
		e.stopPropagation();
	}
		
	//LeeConsulta(opcion);
}
//alert(tecla);

}
