<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION["nombre"]))
{
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
}
else
{
if ($_SESSION['ventas']==1)
{
//Incluímos el archivo Factura.php
//require('Factura.php');
	include 'Remito.php';
	//require 'conexion.php';
	//Obtenemos los datos de la cabecera de la venta actual
	require_once "../modelos/Venta.php";
	$venta= new Venta();
	$rsptav = $venta->ventacabecera($_GET["id"]);
	//Recorremos todos los valores obtenidos
	$regv = $rsptav->fetch_object();
	
	
	$pdf = new PDF_Remito();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(50,6,'Codigo',1,0,'C',1);
	$pdf->Cell(25,6,'Cantidad',1,0,'C',1);
	$pdf->Cell(105,6,'Descripcion',1,1,'C',1);
	
	$pdf->SetFont('Arial','',10);
	
	
	$pdf->Output();
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>