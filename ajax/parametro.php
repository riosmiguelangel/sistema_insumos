<?php
session_start(); 
require_once "../modelos/Parametro.php";

$parametro=new Parametro();

$idparametro=isset($_POST["idparametro"])? limpiarCadena($_POST["idparametro"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':

		if (empty($idparametro)){
			$rspta=$parametro->insertar(ucwords($nombre),$serie_comprobante,$num_comprobante);
			echo $rspta ? "Parametro registrado" : "No se pudieron registrar todos los datos del parametro";
		}
		else {
			$rspta=$parametro->editar($idparametro,ucwords($nombre),$serie_comprobante,$num_comprobante);
			echo $rspta ? "Parametro actualizado" : "Parametro no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$parametro->desactivar($idparametro);
 		echo $rspta ? "Parametro Desactivado" : "Parametro no se puede desactivar";
	break;

	case 'activar':
		$rspta=$parametro->activar($idparametro);
 		echo $rspta ? "Parametro activado" : "Parametro no se puede activar";
	break;

	case 'mostrar':
		$rspta=$parametro->mostrar($idparametro);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'mostraradmin':
		$rspta=$usuario->mostraradmin();
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$parametro->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-primary" onclick="mostrar('.$reg->idparametro.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idparametro.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idparametro.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idparametro.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->serie_comprobante,
 				"3"=>$reg->num_comprobante,
 				"4"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'selectParametro':
		require_once "../modelos/Parametro.php";
		$parametro = new Parametro();

		$rspta = $parametro->listar();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->idparametro . '>' .ucwords($reg->nombre) .'</option>';
				}
	break;	

	case 'salir':
		//Limpiamos las variables de sesión   
        session_unset();
        //Destruìmos la sesión
        session_destroy();
        //Redireccionamos al login
        header("Location: ../index.php");

	break;
}
?>