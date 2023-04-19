<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Venta
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$idagente,$idarticulo,$cantidad)
	{
		global $conexion;
		$sql="call usp_venta_insertar('$idcliente','$idusuario','$tipo_comprobante','$fecha_hora','Aceptado', '$idagente',@_idventa,@p_mierror_cod,@p_mierror_msg)";

   		$r= "select @_idventa,@p_mierror_cod,@p_mierror_msg";
   		$result =mysqli_query($conexion,$sql);
   		$result_id=mysqli_query($conexion,$r);
   		$row= mysqli_fetch_assoc($result_id);
   		echo $row['@p_mierror_msg'];
		
		/*$sql="INSERT INTO venta (idcliente,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_venta,estado,idagente)
		VALUES ('$idcliente','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_venta','Aceptado','$idagente')";*/

		//$idventanew=ejecutarConsulta_retornarID($sql);
		$idventanew=$row['@_idventa'];

		//echo "<script>alert('idventanew: '+$idventanew)</script>";

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idarticulo))
		{
			$sql_detalle = "INSERT INTO detalle_venta(idventa, idarticulo,cantidad) VALUES ('$idventanew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}

	
	//Implementamos un método para anular la venta
	public function anular($idventa)
	{
		$sql="UPDATE venta SET estado='Anulado' WHERE idventa='$idventa'";
		return ejecutarConsulta($sql);

	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idventa)
	{
		$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idventa)
	{
		$sql="SELECT dv.idventa,dv.idarticulo,a.nombre,a.descripcion,dv.cantidad,dv.precio_venta,dv.descuento,c.nombre as categoria,(dv.cantidad*dv.precio_venta-dv.descuento) as subtotal,v.num_comprobante FROM detalle_venta dv inner join articulo a on dv.idarticulo=a.idarticulo inner join categoria c on a.idcategoria=c.idcategoria inner join venta v on v.idventa=dv.idventa where dv.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idusuario,p.tipo_documento,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado,v.idagente FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario ORDER by v.idventa desc";
		return ejecutarConsulta($sql);		
	}

	public function ventacabecera($idventa){
		$sql="SELECT v.idventa,v.idcliente,v.idagente as agente,p.nombre as cliente,p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,v.idusuario,u.nombre as usuario,u.num_documento as documento,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,date(v.fecha_hora) as fecha,time(v.fecha_hora) as hora,v.impuesto,v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	public function ventadetalle($idventa){
		$sql="SELECT a.nombre as articulo,a.codigo,d.cantidad,d.precio_venta,d.descuento,(d.cantidad*d.precio_venta-d.descuento) as subtotal FROM detalle_venta d INNER JOIN articulo a ON d.idarticulo=a.idarticulo WHERE d.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	public function numeroRemito(){
		$sql="SELECT lpad((LAST_INSERT_ID(num_comprobante)+1),6,0) FROM venta ORDER BY num_comprobante DESC LIMIT 1";
		//$sql="SELECT num_comprobante FROM venta ORDER BY num_comprobante DESC LIMIT 1";
		return ejecutarConsulta($sql);
	}
	
}
?>