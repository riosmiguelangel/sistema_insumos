<?php 
if (strlen(session_id()) < 1) 
  session_start();

require "../config/Conexion.php";
require_once "../modelos/Venta.php";

$venta=new Venta();

$idventa=isset($_POST["idventa"])? limpiarCadena($_POST["idventa"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$idusuario=$_SESSION["idusuario"];
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
$total_venta=isset($_POST["total_venta"])? limpiarCadena($_POST["total_venta"]):"";
$idagente=isset($_POST["idagente"])? limpiarCadena($_POST["idagente"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idventa)){
			$rspta=$venta->insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$_POST["idagente"],$_POST["idarticulo"],$_POST["cantidad"]);

			//echo $rspta ? "Venta registrada" : "No se pudieron registrar todos los datos de la venta";
		}
		else {
		}
	break;

	case 'anular':
		$rspta=$venta->anular($idventa);
 		echo $rspta ? "Venta anulada" : "Venta no se puede anular";
	break;

	case 'mostrar':
		$rspta=$venta->mostrar($idventa);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $venta->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th WIDTH="30">Remito</th>
                                    <th  WIDTH="30">Categoria</th>
                                    <th  WIDTH="80">Artículo</th>
                                    <th  WIDTH="80">Descripción</th>
                                    <th  WIDTH="20">Cantidad</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					//echo '<tr class="filas"><td  WIDTH="80">'.$reg->num_documento.'</td><td  WIDTH="50">'.$reg->categoria.'</td><td  WIDTH="50">'.$reg->nombre.'</td><td  WIDTH="50">'.$reg->descripcion.'</td><td  WIDTH="50">'.$reg->cantidad.'</td></tr>';
					echo '<tr class="filas"><td  WIDTH="80">'.$reg->num_comprobante.'</td><td  WIDTH="50">'.$reg->categoria.'</td><td  WIDTH="50">'.$reg->nombre.'</td><td  WIDTH="50">'.$reg->descripcion.'</td><td  WIDTH="50">'.$reg->cantidad.'</td></tr>';
					$total=$reg->cantidad;
				}
		echo '<tfoot>

              </tfoot>';
	break;

	case 'listar':
		$rspta=$venta->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			if($reg->estado=='Aceptado'){
 				$url='../reportes/exRemito.php?id=';
 			}
 			else{
 				$url='../reportes/exRemitoAnulado.php?id=';
 			}

 			if (($_SESSION["cargo"])=="ADMIN"){
 				$data[]=array(
	 				"0"=>(($reg->estado=='Aceptado')?'<button class="btn btn-warning" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-eye"></i></button>'.
	 					' <button class="btn btn-danger" onclick="anular('.$reg->idventa.')"><i class="fa fa-close"></i></button>':
	 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-eye"></i></button>').
						'<a  href="'.$url.$reg->idventa.'" target="_blank" onclick="window.open(this.href); return false;"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>',
	 				"1"=>$reg->fecha,
	 				"2"=>$reg->tipo_documento.' - '.$reg->cliente,
	 				"3"=>$reg->idagente,
	 				//"4"=>$reg->tipo_comprobante,
	 				"4"=>$reg->serie_comprobante.'-'.$reg->num_comprobante,
	 				"5"=>$reg->usuario,
	 				"6"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
	 				'<span class="label bg-red">Anulado</span>'
	 				);
 			}else{
 				 $data[]=array(
	 				"0"=>(($reg->estado=='Aceptado')?'<button class="btn btn-warning" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-eye"></i></button>':
	 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-eye"></i></button>').
	 					'<a  href="'.$url.$reg->idventa.'" target="_blank" onclick="window.open(this.href); return false;"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>',
	 				"1"=>$reg->fecha,
	 				"2"=>$reg->tipo_documento.' - '.$reg->cliente,
	 				"3"=>$reg->idagente,
	 				//"4"=>$reg->tipo_comprobante,
	 				"4"=>$reg->serie_comprobante.'-'.$reg->num_comprobante,
	 				"5"=>$reg->usuario,
	 				"6"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
	 				'<span class="label bg-red">Anulado</span>'
	 				);
 			}



 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'selectCliente':
		require_once "../modelos/Persona.php";
		$persona = new Persona();

		$rspta = $persona->listarC();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->idpersona . '>' .ucwords($reg->tipo_documento) .' - '. $reg->nombre .' - '. $reg->direccion . '</option>';
				}
	break;

		case 'selectAgente':
		require_once "../modelos/Persona.php";
		$persona = new Persona();

		$rspta = $persona->listarA();

		while ($reg = $rspta->fetch_object())
				{
				echo "<option value='$reg->nombre - $reg->num_documento'>DNI/Ficha: $reg->num_documento  -Nombre: $reg->nombre</option>";
				}

	break;

	case 'selectArticulo':
		require_once "../modelos/Articulo.php";
		$articulo = new Articulo();

		$rspta = $articulo->listarAr();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->idarticulo . '>' .ucwords($reg->nombre) . '</option>';
				}
	break;

	case 'listarArticulosVenta':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivosVenta();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			if ($reg->stock>0) {
 				$data[]=array(
 				"0"=>'<button class="btn btn-success" id="agregarDetalle'.$reg->idarticulo.'" onclick="agregarDetalle('.$reg->idarticulo.',\''.$reg->nombre.'\',\''.$reg->idcategoria.'\',\''.$reg->categoria.'\',\''.$reg->stock.'\')"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->categoria,
 				"3"=>$reg->codigo,
 				"4"=>$reg->stock,
 				"5"=>$reg->precio_venta,
 				"6"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
 				);
 			}else{
 				$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="alertaStock()"><span class="fa fa-exclamation-circle"></span></button>',
 				"1"=>$reg->idarticulo.'-'.$reg->nombre,
 				"2"=>$reg->categoria,
 				"3"=>$reg->codigo,
 				"4"=>$reg->stock,
 				"5"=>$reg->precio_venta,
 				"6"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
 				);
 			}


 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;

	case 'numRemito':
		$rspta=$venta->numeroRemito();

		$reg=$rspta->fetch_row();
 		echo json_encode($reg);
	break;	
}

?>