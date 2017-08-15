<<<<<<< .mine
<?php require('controlSesiones.inc.php');  ?>
<?php 
=======
<?php 

require('controlSesiones.inc.php');
>>>>>>> .r60

require('pebi_cn.inc.php');
require('pebi_db.inc.php');

//para guardar en disco
$nomfi='C:\Temp\cuaderno'.date("ymd").date("His").'.txt';
$_SESSION["nomfi"]=$nomfi;
//nombre que se le va a dar al cuaderno al subirlo a la nube se le
//a�adir� la fecha y hora para que el nombre sea unico y se pueda 
//localizar desde la bd
$fi_solo_nombre='pruebacuaderno.txt';

$xCuenta=$_POST['xCuenta'];

function PintarCuaderno($nomfi,$xCuenta,$xIDCuaderno){
	$fi=@fopen($nomfi,"w");
	$xCIF=PintarRegCabecera($fi,$xCuenta);
	PintarRegBeneficiarios($fi,$xCIF,$xIDCuaderno);
	fclose($fi);
}

function PonerEspacios($NumEspacios,$fi){
	while ($NumEspacios>0){
		@fputs($fi," ");
		$NumEspacios--;
	}
	
}

function PintarRegCabecera($fi,$xCuenta){

	$conn = db_connect();

	//HABRA QUE PONER EN EL INTERFAZ DESDE QUE CUENTA QUIEREN ENVIAR EL DINERO Y SI QUIEREN A�ADIR
	//OTRA CUENTA O SI QUIEREN BORRARLA
	$sql='SELECT RAZON_SOCIAL,NIF,POBLACION,CP,DIRECCION FROM DatosPer where id in (select IDDATOSPER from usuarios where usuario=user) ';
	$stid2 = oci_parse($conn, $sql);
	$r = oci_execute($stid2, OCI_DEFAULT);

	$row = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS);

	
	//---datos necesarios de la bd----//
	$xCIF=$row['NIF'];
	$xEntidad=substr($xCuenta,0,4);
	$xOficina=substr($xCuenta,4,4);
	$xNCuenta=substr($xCuenta,10,10);
	$xCargo='0';
	$xDControl=substr($xCuenta,8,2);
	$xNombreOrdenante=$row['RAZON_SOCIAL'];
	$xDomicilioOrdenante=$row['DIRECCION'];
	$xPlazaOrdenante=$row['POBLACION'];
	//---------primer registro------//
	//codigo de registro
	@fputs($fi,"03");
	//codigo de operacion
	@fputs($fi,"56");
	PonerEspacios(1,$fi);
	@fputs($fi,$xCIF);
	PonerEspacios(12,$fi);
	@fputs($fi,"001");
	//fecha envio del soporte
	@fputs($fi,date("dmy"));
	//fecha emision de ordenes
	@fputs($fi,date("dmy"));
	@fputs($fi,$xEntidad);
	@fputs($fi,$xOficina);
	@fputs($fi,$xNCuenta);
	@fputs($fi,$xCargo);
	PonerEspacios(3,$fi);
	@fputs($fi,$xDControl);
	//----------segundo registro-------//
	@fputs($fi,"\n");
	//codigo de registro
	@fputs($fi,"03");
	//codigo de operacion
	@fputs($fi,"56");
	PonerEspacios(1,$fi);
	@fputs($fi,$xCIF);
	PonerEspacios(12,$fi);
	@fputs($fi,"002");
	@fputs($fi,$xNombreOrdenante);
	//-----------tercer registro---------//
	@fputs($fi,"\n");
	//codigo de registro
	@fputs($fi,"03");
	//codigo de operacion
	@fputs($fi,"56");
	PonerEspacios(1,$fi);
	@fputs($fi,$xCIF);
	PonerEspacios(12,$fi);
	@fputs($fi,"003");
	@fputs($fi,substr($xDomicilioOrdenante,0,36));
	//-------------cuarto registro-----------//
	@fputs($fi,"\n");
	//codigo de registro
	@fputs($fi,"03");
	//codigo de operacion
	@fputs($fi,"56");
	PonerEspacios(1,$fi);
	@fputs($fi,$xCIF);
	PonerEspacios(12,$fi);
	@fputs($fi,"004");
	@fputs($fi,substr($xPlazaOrdenante,0,36));

	oci_close($conn);
	return $xCIF;
	
}



function PintarRegBeneficiarios($fi,$xCIF,$xIDCuaderno){

	$conn = db_connect();

	
	//HABRA QUE PONER EN EL INTERFAZ DESDE QUE CUENTA QUIEREN ENVIAR EL DINERO Y SI QUIEREN A�ADIR
	//OTRA CUENTA O SI QUIEREN BORRARLA
	$sql="SELECT C.NIF, C.APENOMBRE, C.NUMEROCUENTA,C.DOMICILIO,C.CODPOSTAL,C.POBLACION,E.NE,
		GET_IMPORTE_FACTURACION(E.NE) AS IMPORTE
 	FROM EXPEDIENTES E,CLIENTES_EXPE T, CLIENTES C
 	WHERE E.NE=T.NE  AND T.NIF_CLIENTE=C.NIF AND T.SUJETO='T' AND E.ESTADO='FACT' and e.ID_CUADERNO=:xIDCuaderno ";
	$stid2 = oci_parse($conn, $sql);
	


	
	oci_bind_by_name($stid2, ':xIDCuaderno', $xIDCuaderno, 38, SQLT_INT);
	$r = oci_execute($stid2, OCI_DEFAULT);
	

	
	//contador para el numero de beneficiarios
	$xContBenef=0;
	while($row = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS)){
		$xContNumBenef=$xContNumBenef+1;
		$xNifBeneficiario=$row['NIF'];
		//12 posiciones para el importe, relleneos de 0's por la izquierda y 2 pos para los decimales
		$xImporte=$row['IMPORTE'];
		$xNumCompleto=$row['NUMEROCUENTA'];
		$xEntidadBeneficiario=substr($xNumCompleto,0,4);
		$xOficinaBeneficiario=substr($xNumCompleto,4,4);
		$xNCuentaBeneficiario=substr($xNumCompleto,10,10);
		//Codigo de quien paga la transferencia ordenante(1)/Beneficiario(2)
		$xGastos='1';
		//Concepto de la orden 1=nomina 8=pension 9=otros conceptos
		$xConceptoOrden='9';
		//Signo del importe de la transferencia al ser positivo se deja un espacio o + y si es negativo -
		$xSignoImporte=' ';
		$DControlBeneficiario==substr($xNumCompleto,8,2);
		//Hasta 36 caracteres de longitud
		$xNombreBeneficiario=$row['APENOMBRE'];
		//Hasta 36 caracteres de longitud
		$xDomicilioBeneficiario=$row['DOMICILIO'];
		$xCPBeneficiario=$row['CODPOSTAL'];
		//solo puede tener 31 posiciones
		$xPoblacionBeneficiario=$row['POBLACION'];
		
		//contador para saber la cantidad total del ingreso
		$xSumaTotal=$xSumaTotal+$xImporte;
		
		@fputs($fi,"\n");
		//codigo de registro
		@fputs($fi,"03");
		//codigo de operacion
		@fputs($fi,"56");
		PonerEspacios(1,$fi);
		@fputs($fi,$xCIF);
		@fputs($fi,substr($xNifBeneficiario,0,9));
		PonerEspacios(3,$fi);
		@fputs($fi,"010");
		@fputs($fi,str_pad($xImporte, 12, "0", STR_PAD_LEFT));
		@fputs($fi,$xEntidadBeneficiario);
		@fputs($fi,$xOficinaBeneficiario);
		@fputs($fi,$xNCuentaBeneficiario);
		@fputs($fi,$xGastos);
		@fputs($fi,$xConceptoOrden);
		@fputs($fi,$xSignoImporte);
		PonerEspacios(2,$fi);
		@fputs($fi,$DControlBeneficiario);
		//---011
		@fputs($fi,"\n");
		//codigo de registro
		@fputs($fi,"03");
		//codigo de operacion
		@fputs($fi,"56");
		PonerEspacios(1,$fi);
		@fputs($fi,$xCIF);
		@fputs($fi,substr($xNifBeneficiario,0,9));
		PonerEspacios(3,$fi);
		@fputs($fi,"011");
		@fputs($fi,substr($xNombreBeneficiario,0,36));
		//-----012
		@fputs($fi,"\n");
		//codigo de registro
		@fputs($fi,"03");
		//codigo de operacion
		@fputs($fi,"56");
		PonerEspacios(1,$fi);
		@fputs($fi,$xCIF);
		@fputs($fi,substr($xNifBeneficiario,0,9));
		PonerEspacios(3,$fi);
		@fputs($fi,"012");
		@fputs($fi,substr($xDomicilioBeneficiario,0,36));
		//----014
		@fputs($fi,"\n");
		//codigo de registro
		@fputs($fi,"03");
		//codigo de operacion
		@fputs($fi,"56");
		PonerEspacios(1,$fi);
		@fputs($fi,$xCIF);
		@fputs($fi,substr($xNifBeneficiario,0,9));
		PonerEspacios(3,$fi);
		@fputs($fi,"014");
		@fputs($fi,$xCPBeneficiario);
		@fputs($fi,substr($xPoblacionBeneficiario,0,31));
		     	
		

	}
	
	//---Pintar registro total
	@fputs($fi,"\n");
	//codigo de registro
	@fputs($fi,"03");
	//codigo de operacion
	@fputs($fi,"56");
	PonerEspacios(1,$fi);
	@fputs($fi,$xCIF);
	PonerEspacios(15,$fi);
	@fputs($fi,str_pad($xSumaTotal, 12, "0", STR_PAD_LEFT));
	@fputs($fi,str_pad($xContNumBenef, 8, "0", STR_PAD_LEFT));
	//el numero total de registros sera todos los beneficiarios multiplicado por
	//el numero de registros que tiene cada beneficiario mas la cabecera que son 4 mas el total que es 1
	$xContNumReg=($xContNumBenef*4)+5;
	@fputs($fi,str_pad($xContNumReg, 8, "0", STR_PAD_LEFT));
	

	oci_close($conn);
}









function do_save_oracle($nomfi,&$xIDCuaderno)
{
	
	$xNombreComun=substr($nomfi,-24,25);
	$xFileName ='cuadernos34/'.$xNombreComun;
	$url_oracle = 'http://cg-servicios.s3.amazonaws.com/'.$xFileName;

		$conn = db_connect();
// Nombre de procedimiento a ejecutar y sus parametros
$sql = 'begin AddCuaderno34CL(:url_oracle,:xIDCuaderno); end;';

    $stmt = oci_parse($conn, $sql);
    
    oci_bind_by_name($stmt, ':url_oracle', $url_oracle, 90,SQLT_CHR);

    oci_bind_by_name($stmt, ':xIDCuaderno', $xIDCuaderno, 38,SQLT_INT);
    
    	if(oci_execute($stmt))
		{
			echo "Cuaderno34 generado";
	     	//header("Location:PagosAColaboradores.php");
		}
		else
	   		echo "Error";
	   		
	  oci_close($conn);
	
}










do_save_oracle($nomfi,$xIDCuaderno);
PintarCuaderno($nomfi,$xCuenta,$xIDCuaderno);
//
// Se van a necesitar dos consultas una para los datos de la empresa (registro de cabecera) y otra para 
// los registro de los pagos incluso se podr�a dividir en dos consultas una para los datos del colaborador 
// y otra para los importes.
//
// Una vez generado el soporte tendremos que actualizar la fase de los expedientes afectados y a�adir su
// correspondiente asiento en el seguimiento.
//
// (Opcional) Ser�a tambi�n una buena idea tener la posibilidad de deshacer un cuaderno una vez realizado,
// poder volver a la situaci�n inicial, los humanos cometemos errores y por lo tanto hay que darles oportunidad
// de rectificar. Tambi�n es debido a que el fichero una vez realizado se envia
// a traves de la pagina Web de Caja Granada de banca electronica, es decir en otra aplicaci�n. Podr�a ocurrir
// que al usuario se le olvide hacerlo.
//
// Esto nos obliga a tener controles de quien puede hacer algo y quien puede rectificar.
// Tendremos que dejar rastro en algun fichero de log en BBDD, dejar constancia de que se hizo
// y se rectifico �cuando? en que fecha y �quien? usuario que hace las cosas. (TRAZABILIDAD)
//
// Se necesita en el interfaz de usuario una opci�n donde el usuario nos indique que el archivo ha sido
// enviado a banca electronica y que por lo tanto ya no se puede deshacer, los pago son ciertos.
//
// Todas estas reglas se implementan en la base de datos y se denomina reglas de negocio.
// De tal suerte que podemos iniciar con unos objetivos b�sicos e ir creciendo en funcionalidad, solo 
// con cambiar el PL/SQL sin afectar al interfaz de usuario, que se mantendr� constante en el tiempo
//
// Es importante ser muy ambicioso en los planteamientos iniciales, para ver m�s alla de lo que en realidad
// vamos desarrollar inicialmente. Con esta visi�n estamos sembrado el futuro de posibles mejoras. En caso 
// contrario cualquier mejora que nos propongan en el futuro ser�a inviable o dificil de acometer ya que
// no estaba prevista y en ocasiones es mejor reescribir todo el c�digo, por deficiencias en la planificaci�n
//


//HABRA QUE PONER EN EL INTERFAZ DESDE QUE CUENTA QUIEREN ENVIAR EL DINERO Y SI QUIEREN A�ADIR
//OTRA CUENTA O SI QUIEREN BORRARLA
/*
$xEntidad='2031';
$xOficina='0000';
$xNCuenta='0115414108';
$xCargo='0';
$xDControl='09';
$xNombreOrdenante='LA GENERAL SERVICIOS-LGS, SL';
$xDomicilioOrdenante='CAJA AHORROS DE GRANADA';
$xPlazaOrdenante='GRANADA';


$xNifBeneficiario='12345678a';
//12 posiciones para el importe, relleneos de 0's por la izquierda y 2 pos para los decimales
$xImporte='123456789012';
$xEntidadBeneficiario='1234';
$xOficinaBeneficiario='1234';
$xNCuentaBeneficiario='1234567890';
//Codigo de quien paga la transferencia ordenante(1)/Beneficiario(2)
$xGastos='1';
//Concepto de la orden 1=nomina 8=pension 9=otros conceptos
$xConceptoOrden='9';
//Signo del importe de la transferencia al ser positivo se deja un espacio o + y si es negativo -
$xSignoImporte=' ';
$DControlBeneficiario='12';
//Hasta 36 caracteres de longitud
$xNombreBeneficiario='pepe';
//Hasta 36 caracteres de longitud
$xDomicilioBeneficiario='CALLE FLORES';
$xCPBeneficiario='12345';
//solo puede tener 31 posiciones
$xPoblacionBeneficiario='granada';
//suma total de todos los importes de los beneficiarios 12 posiciones dos digitos son de posiciones decimales
$xSumaTotal='';
//numero de transferencias que se realizan en el soporte  relleno de 0's a la izq.(8 posiciones)
$xNumTransferencias='';
//numero de lineas que contiene el archivo relleno de 0's a la izq. (10 posiciones)
$xNumLineas='';

echo '0356 B18547281(12e)       001'.date("dmy").date("dmy").$xEntidad.$xOficina.$xNCuenta.$xCargo.'   '.$xDControl.'<BR />';
echo '0356 B18547281            002'.$xNombreOrdenante.'<BR />';
echo '0356 B18547281            003'.$xDomicilioOrdenante.'<BR />';
echo '0356 B18547281            004'.$xPlazaOrdenante.'<BR />';

echo '0356 B18547281'.$xNifBeneficiario.'(3e)010'.$xImporte.$xEntidadBeneficiario.
$xOficinaBeneficiario.$xNCuentaBeneficiario.$xGastos.$xConceptoOrden.$xSignoImporte.'(2e)'.$DControlBeneficiario.'<BR />';
echo '0356 B18547281'.$xNifBeneficiario.'(3e)011'.$xNombreBeneficiario.'<BR />';
echo '0356 B18547281'.$xNifBeneficiario.'(3e)012'.$xDomicilioBeneficiario.'<BR />';
echo '0356 B18547281'.$xNifBeneficiario.'(3e)014'.$xCPBeneficiario.$xPoblacionBeneficiario.'<BR />';
echo '0856 B18547281(15e)'.$xSumaTotal;  */             


?>
