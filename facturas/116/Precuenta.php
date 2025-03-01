 <?php

use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;



class Precuenta {


/*
    Precuenta del ciente
*/


public function PrecuentaPrint($data, $printer){
    $doc = new Documentos();
    
  //$img  = "C:/laragon/www/impresiones/facturas/109/img/logo.jpg";
  
  $connector = new WindowsPrintConnector($printer);
  $printer = new Printer($connector);
  $printer -> initialize();
  
  $printer->pulse();

  $printer -> setFont(Printer::FONT_B);
  
  $printer -> setTextSize(1, 2);
  $printer -> setLineSpacing(80);
  
  
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  //$logo = EscposImage::load($img, false);
  //$printer->bitImage($logo);
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
//   $printer->text($data['empresa_nombre']);

  $printer->text("LA RINCONCHITA");
  $printer->feed();
  
$printer->text("Avenida 2 de Abril Norte y 6a calle poniente #14");
$printer->feed();

$printer->text("Chalchuapa");
$printer->feed();

$printer->text("TELEFONO: 7547-8651 o 2408-0653" . $data['empresa_telefono']);
// $printer->text("TELEFONO: " . $data['empresa_telefono']);
  
  $printer->feed();
  $printer->text("ORDEN NUMERO: " . $data['numero_documento']);
  
  
  $printer->feed();
  $printer->text("PRECUENTA");
  
  
  /* Stuff around with left margin */
  $printer->feed();
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  $printer -> text("________________________________________________________");
  $printer -> setJustification(Printer::JUSTIFY_LEFT);
  $printer->feed();
  /* Items */
  
  $printer -> setJustification(Printer::JUSTIFY_LEFT);
  $printer -> setEmphasis(true);
  $printer -> text($doc->Item("Cant", 'Producto', 'Precio', 'Total'));
  $printer -> setEmphasis(false);
  
  

  foreach ($data['productos'] as $producto) {
    $printer -> text($doc->Item($producto['cant'], $producto["producto"], Helpers::Format($producto["pv"]), Helpers::Format($producto["total"]))); 
  }
  
   
  $printer -> text("________________________________________________________");
  $printer->feed();
  
  
  
  $printer -> text($doc->DosCol("Sub Total " . $data['tipo_moneda'] . ":", 40, Helpers::Format($data['total']), 10));
  
  
  
  if ($data['propina_cant']) {
    $printer -> text($doc->DosCol("Propina " . $data['tipo_moneda'] . ":", 40, Helpers::Format($data['propina_cant']), 10));
  }

  $printer -> setEmphasis(true);
  $printer -> text($doc->DosCol("Total " . $data['tipo_moneda'] . ":", 40, Helpers::Format($data['propina_cant'] + $data['total']), 10));
  $printer -> setEmphasis(false);
  
  
  $printer -> text("________________________________________________________");
  $printer->feed();
  
  
  
  $printer -> text($doc->DosCol($data['fecha'], 30, $data['hora'], 20));
  
  
  $printer -> text("Cajero: " . $data['cajero']);
  $printer->feed();
  

  if($data['tipo_servicio'] == 3){
    $printer -> text("Cliente: " . $data['cliente_nombre']);
    $printer->feed();
  }
  if($data['tipo_servicio'] == 3){
    $printer -> text($data['cliente_direccion']);
    $printer->feed();
  }
  if($data['tipo_servicio'] == 3){
    $printer -> text("Telefono: " . $data['cliente_telefono']);
    $printer->feed();
  }
  
  // datos del cliente delivery
  
  
  // nombre de mesa
  if($data['mesa']['nombre_mesa'] != NULL){
    $printer -> text("Mesa: " . $data['mesa']['nombre_mesa']);
    $printer->feed();
  }
  
  
// llevar o comer aqui
if($data['llevar_aqui'] != NULL){
  if ($data['tipo_servicio'] == 3 && $data['llevar_aqui'] == 1) {
    $tipo = "DOMICILIO";
  } 
  else if ($data['llevar_aqui'] == 1) {
    $tipo = "LLEVAR";
  } else {
    $tipo = "COMER AQUI";
  }
  $printer -> text( $tipo);
  $printer->feed();
}


  

  $printer -> text("________________________________________________________");
  $printer->feed();
  
  
  $printer->feed();
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  $printer -> text("GRACIAS POR SU PREFERENCIA...");
  $printer -> setJustification();
  
  
  $printer->feed();
  $printer->cut();
  $printer->close();
  

}















}// class