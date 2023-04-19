<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Parametro
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$serie_comprobante,$num_comprobante)
	{
		$sql="INSERT INTO parametro (nombre,serie_comprobante,num_comprobante)
		VALUES ('$nombre','$serie_comprobante','$num_comprobante')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idparametro,$nombre,$serie_comprobante,$num_comprobante)
	{
		$sql="UPDATE parametro SET nombre='$nombre',serie_comprobante='$serie_comprobante',num_comprobante='$num_comprobante' WHERE idparametro='$idparametro'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar categorías
	public function eliminar($idparametro)
	{
		$sql="DELETE FROM parametro WHERE idparametro='$idparametro'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM parametro";
		return ejecutarConsulta($sql);		
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idparametro)
	{
		$sql="UPDATE parametro SET condicion='0' WHERE idparametro='$idparametro'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idparametro)
	{
		$sql="UPDATE parametro SET condicion='1' WHERE idparametro='$idparametro'";
		return ejecutarConsulta($sql);
	}
	

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idparametro)
	{
		$sql="SELECT * FROM parametro WHERE idparametro='$idparametro'";
		return ejecutarConsultaSimpleFila($sql);
	}

}

?>