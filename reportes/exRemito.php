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
require('Remito.php');

//Establecemos los datos de la empresa
$logo = "logo.jpg";
$ext_logo = "jpg";
$empresa = "Gobierno de la Ciudad de Buenos Aires";
$documento = "Administracion Gubernamental de Ingresos Publicos
Direccion General de planificacion y Control
Subdireccion General de Sistemas";
$direccion = "Soporte Tecnico";
$telefono = "";
$email = "";

//Obtenemos los datos de la cabecera de la venta actual
require_once "../modelos/Venta.php";
$venta= new Venta();
$rsptav = $venta->ventacabecera($_GET["id"]);
//Recorremos todos los valores obtenidos
$regv = $rsptav->fetch_object();

//Establecemos la configuración de la factura
$pdf = new PDF_Remito( 'P', 'mm', 'A4' );
$pdf->AddPage();

//Enviamos los datos de la empresa al método addSociete de la clase Factura
$pdf->addSociete(utf8_decode($empresa),
                  $documento."\n" .
                  utf8_decode("Dirección: ").utf8_decode($direccion)."\n".
                  utf8_decode("  ").$telefono."\n" .
                  " ".$email,$logo,$ext_logo);
$pdf->fact_dev( "$regv->tipo_comprobante ", "$regv->num_comprobante" );
$pdf->temporaire( "" );
$pdf->addDate( $regv->fecha);
//$pdf->addTime( $regv->hora);
//$pdf->addUsuario( $regv->hora);

//Enviamos los datos del cliente al método addClientAdresse de la clase Factura
$pdf->addClientAdresse(utf8_decode($regv->tipo_documento)."  ".utf8_decode($regv->cliente),"A cargo de:  ".utf8_decode($regv->direccion),$regv->email,$regv->telefono,$regv->num_documento);

//Establecemos las columnas que va a tener la sección donde mostramos los detalles de la venta
$cols=array( "CODIGO"=>50,
             "DESCRIPCION"=>118,
             "CANTIDAD"=>22);
$pdf->addCols( $cols);
$cols=array( "CODIGO"=>"L",
             "DESCRIPCION"=>"L",
             "CANTIDAD"=>"C");
$pdf->addLineFormat( $cols);
$pdf->addLineFormat($cols);
//Actualizamos el valor de la coordenada "y", que será la ubicación desde donde empezaremos a mostrar los datos
$y= 89;

//Obtenemos todos los detalles de la venta actual
$rsptad = $venta->ventadetalle($_GET["id"]);

while ($regd = $rsptad->fetch_object()) {
  $line = array( "CODIGO"=> "$regd->codigo",
                "DESCRIPCION"=> utf8_decode("$regd->articulo"),
                "CANTIDAD"=> "$regd->cantidad",
                "P.U."=> "$regd->precio_venta",
                "DSCTO" => "$regd->descuento",
                "SUBTOTAL"=> "$regd->subtotal");
            $size = $pdf->addLine( $y, $line );
            $y   += $size + 2;
}

//Convertimos el total en letras
require_once "Letras.php";
//$V=new EnLetras(); 
//$con_letra=strtoupper($V->ValorEnLetras($regv->total_venta,"NUEVOS SOLES"));
//$pdf->addCadreTVAs("---".$con_letra);

//Mostramos el impuesto
//$pdf->addTVAs( $regv->impuesto, $regv->total_venta,"$ ");
$pdf->addUsuario(" $regv->usuario"," $regv->hora"," $regv->documento");
//$pdf->addRetiro(" $regv->agente"," $regv->hora"," $regv->documento");
$dniangente=(substr($regv->agente, -8));
$long=strlen("$regv->agente");
$largo=$long-10;
$pdf->addRetiro(substr($regv->agente,0,($largo)), " $regv->hora",$dniangente);
//$pdf->addTime( "$regv->hora");
$pdf->Output('Reporte de Venta','I');


}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>