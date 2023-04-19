<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Consultas
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function comprasfecha($fecha_inicio,$fecha_fin)
	{
		$sql="SELECT DATE(i.fecha_hora) as fecha,u.nombre as usuario, p.nombre as proveedor,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado,di.idingreso,di.cantidad,a.nombre,a.descripcion FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario INNER JOIN detalle_ingreso di ON i.idingreso=di.idingreso LEFT JOIN articulo a ON di.idarticulo=a.idarticulo WHERE DATE(i.fecha_hora)>='$fecha_inicio' AND DATE(i.fecha_hora)<='$fecha_fin'";
		return ejecutarConsulta($sql);		
	}

	public function ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente)
	{
		//$sql="SELECT DATE(v.fecha_hora) as fecha,u.nombre as usuario, p.nombre as cliente,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' AND v.idcliente='$idcliente'";
		$sql="SELECT DATE(v.fecha_hora) as fecha,u.nombre as usuario, p.nombre as cliente,p.tipo_documento,p.direccion,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado ,dv.idventa,dv.cantidad,a.nombre,a.descripcion FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario INNER JOIN detalle_venta dv ON v.idventa=dv.idventa LEFT JOIN articulo a ON dv.idarticulo=a.idarticulo WHERE DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' AND v.idcliente='$idcliente'";
		return ejecutarConsulta($sql);		
	}

	public function ventasfechaarticulo($fecha_inicio,$fecha_fin,$idarticulo)
	{
		//$sql="SELECT DATE(v.fecha_hora) as fecha,u.nombre as usuario, p.nombre as cliente,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' AND v.idcliente='$idcliente'";
		$sql="SELECT DATE(v.fecha_hora) as fecha,u.nombre as usuario, p.nombre as cliente,p.tipo_documento,p.direccion,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado ,dv.idventa,dv.cantidad as cantidad,a.idarticulo,a.nombre,a.descripcion FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario INNER JOIN detalle_venta dv ON v.idventa=dv.idventa LEFT JOIN articulo a ON dv.idarticulo=a.idarticulo WHERE v.estado='Aceptado' AND DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin'  AND a.idarticulo='$idarticulo' ";
		return ejecutarConsulta($sql);		
	}

	public function ventasfechaarticulotodos($fecha_inicio,$fecha_fin)
	{
		$sql="SELECT DATE(v.fecha_hora) as fecha,u.nombre as usuario, p.nombre as cliente,p.tipo_documento,p.direccion,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado ,dv.idventa,dv.cantidad as cantidad,a.idarticulo,a.nombre,a.descripcion FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario INNER JOIN detalle_venta dv ON v.idventa=dv.idventa LEFT JOIN articulo a ON dv.idarticulo=a.idarticulo WHERE v.estado='Aceptado' AND DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' ";
		return ejecutarConsulta($sql);		
	}



	public function totalcomprahoy()
	{
		$sql="SELECT IFNULL(SUM(total_compra),0) as total_compra FROM ingreso WHERE DATE(fecha_hora)=curdate()";
		return ejecutarConsulta($sql);
	}

	public function totalventahoy()
	{
		//$sql="SELECT IFNULL(SUM(total_venta),0) as total_venta FROM venta WHERE DATE(fecha_hora)=curdate()";
		$sql="SELECT IFNULL(SUM(dv.cantidad),0) as total_venta FROM venta v INNER JOIN detalle_venta dv ON v.idventa=dv.idventa INNER JOIN articulo a ON a.idarticulo=dv.idarticulo  WHERE a.idcategoria=1 AND DATE(fecha_hora)=curdate()";
		return ejecutarConsulta($sql);
	}

	public function totalventapapelhoy()
	{
		//$sql="SELECT IFNULL(SUM(total_venta),0) as total_venta FROM venta WHERE DATE(fecha_hora)=curdate()";
		$sql="SELECT IFNULL(SUM(dv.cantidad),0) as total_venta FROM venta v INNER JOIN detalle_venta dv ON v.idventa=dv.idventa INNER JOIN articulo a ON a.idarticulo=dv.idarticulo  WHERE a.idcategoria=6 AND DATE(fecha_hora)=curdate()";
		return ejecutarConsulta($sql);
	}

	public function comprasultimos_10dias()
	{
		$sql="SELECT CONCAT(DAY(fecha_hora),'-',MONTH(fecha_hora)) as fecha,SUM(total_compra) as total FROM ingreso GROUP by fecha_hora ORDER BY fecha_hora DESC limit 0,10";
		return ejecutarConsulta($sql);
	}

	public function ventasultimos_12meses()
	{
		$sql="SELECT DATE_FORMAT(fecha_hora,'%M') as fecha,SUM(dv.cantidad) as total FROM venta v  inner join  detalle_venta dv  ON v.idventa=dv.idventa  INNER JOIN articulo a ON a.idarticulo=dv.idarticulo WHERE a.idcategoria=1 GROUP by MONTH(fecha_hora) ORDER BY fecha_hora DESC limit 0,12";
		return ejecutarConsulta($sql);
	}

	public function ventaspapelultimos_12meses()
	{
		$sql="SELECT DATE_FORMAT(fecha_hora,'%M') as fecha,SUM(dv.cantidad) as total FROM venta v  inner join  detalle_venta dv  ON v.idventa=dv.idventa  INNER JOIN articulo a ON a.idarticulo=dv.idarticulo WHERE a.idcategoria=6 GROUP by MONTH(fecha_hora) ORDER BY fecha_hora DESC limit 0,12";
		return ejecutarConsulta($sql);
	}

}

?>