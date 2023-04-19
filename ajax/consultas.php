<?php 
require_once "../modelos/Consultas.php";

$consulta=new Consultas();


switch ($_GET["op"]){
	case 'comprasfecha':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];

		$rspta=$consulta->comprasfecha($fecha_inicio,$fecha_fin);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->fecha,
 				"1"=>$reg->tipo_comprobante.' :'.$reg->serie_comprobante.' -'.$reg->num_comprobante,
 				"2"=>$reg->proveedor,
 				"3"=>$reg->nombre,
 				"4"=>$reg->descripcion,
 				"5"=>$reg->cantidad,
 				"6"=>$reg->usuario,
 				"7"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
 				'<span class="label bg-red">Anulado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case 'ventasfechacliente':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$idcliente=$_REQUEST["idcliente"];

		$rspta=$consulta->ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->fecha,
 				"1"=>$reg->num_comprobante,
 				"2"=>$reg->tipo_documento.' '.$reg->cliente,
 				"3"=>$reg->nombre,
 				"4"=>$reg->descripcion,
 				"5"=>$reg->cantidad,
 				"6"=>$reg->usuario,
 				"7"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
 				'<span class="label bg-red">Anulado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case 'ventasfechaarticulo':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$idarticulo=$_REQUEST["idarticulo"];

		$rspta=$consulta->ventasfechaarticulo($fecha_inicio,$fecha_fin,$idarticulo);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->fecha,
 				"1"=>$reg->num_comprobante,
 				"2"=>$reg->tipo_documento.' '.$reg->cliente,
 				"3"=>$reg->nombre,
 				"4"=>$reg->descripcion,
 				"5"=>$reg->cantidad,
 				"6"=>$reg->usuario,
 				"7"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
 				'<span class="label bg-red">Anulado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'ventasfechaarticulotodos':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];


		$rspta=$consulta->ventasfechaarticulotodos($fecha_inicio,$fecha_fin);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->fecha,
 				"1"=>$reg->num_comprobante,
 				"2"=>$reg->tipo_documento.' '.$reg->cliente,
 				"3"=>$reg->nombre,
 				"4"=>$reg->descripcion,
 				"5"=>$reg->cantidad,
 				"6"=>$reg->usuario,
 				"7"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
 				'<span class="label bg-red">Anulado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
}
?>