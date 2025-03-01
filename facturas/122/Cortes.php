 <?php

use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;



class CorteDeCaja {


/*
    Corte de caja
*/


public function CortePrint($data, $printer){
    $doc = new Documentos();

    $connector = new WindowsPrintConnector($printer);
    $printer = new Printer($connector);
    $printer -> initialize();
    
    $printer -> setFont(Printer::FONT_A);
    
    $printer -> setTextSize(1, 1);
    $printer -> setLineSpacing(80);
    
    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    
    $printer -> text("RESUMEN DE CORTE DE CAJA");
    
    /* Stuff around with left margin */
    $printer->feed();
    $printer -> text("______________________________________________");
    $printer->feed();
    /* Items */
    
    
    
    $printer -> setJustification(Printer::JUSTIFY_LEFT);
    $printer -> setEmphasis(true);
    $printer -> text($doc->Item("Cant", 'Producto', 'Precio', 'Total'));
    $printer -> setEmphasis(false);
    
    

    foreach ($data['productos'] as $producto) {
      $printer -> text($doc->Item( $producto['cant'], $producto['producto'], Helpers::Dinero($producto['pv']), Helpers::Dinero($producto['total']))); 
    }
    
    
    
    $printer -> text("______________________________________________");
    $printer->feed();
    
       
    
    $printer -> text($doc->DosCol("VENTA EN EFECTIVO: ", 30, Helpers::Dinero($data['total_efectivo']), 10));
    
    $printer -> text($doc->DosCol("PROPINA EN EFECTIVO: ", 30, Helpers::Dinero($data['propina_efectivo']), 10));
    
    $printer -> text($doc->DosCol("VENTA CON TARJETA: ", 30, Helpers::Dinero($data['total_tarjeta']), 10));
    
    $printer -> text($doc->DosCol("PROPINA CON TARJETA: ", 30, Helpers::Dinero($data['propina_no_efectivo']), 10));
    
    
    
    $printer -> text($doc->DosCol("TOTAL DE VENTA: ", 30, Helpers::Dinero($data['total_venta']), 10));
    
      
    $printer -> text($doc->DosCol("TOTAL DE PROPINA: ", 30, Helpers::Dinero($data['propina_efectivo'] + $producto['propina_no_efectivo']), 10));
    
        
    // $printer -> text($doc->DosCol("TOTAL: ", 40, Helpers::Dinero($data['total_venta'] + $producto['total_venta']), 10));
    
    
      
    $printer -> text("______________________________________________");
    $printer->feed();
    
    
    
    
    // $printer -> text($doc->DosCol("TICKET ELIMINADOS: ", 40, $counte, 10));
    
    
    // $printer -> text("_______________________________________________________");
    // $printer->feed();
    
    
    
    
    
    
    $printer -> text($doc->DosCol("GASTOS REGISTRADOS: ", 30, Helpers::Dinero($data['gastos']), 10));
    
    
    $printer -> text($doc->DosCol("REMESAS: ", 30, Helpers::Dinero($data['remesas']), 10));


    $printer -> text($doc->DosCol("ABONOS: ", 30, Helpers::Dinero($data['abonos']), 10));
    
    
    $printer -> text("_________________________________________");
    $printer->feed();
    
    
    
    
    $printer -> text($doc->DosCol("DINERO EN APERTURA: ", 30, Helpers::Dinero($data['efectivo_inicial']), 10));
    
    $printer -> text($doc->DosCol("EFECTIVO INGRESADO: ", 30, Helpers::Dinero($data['efectivo_final']), 10));

   // $printer -> text($doc->DosCol("EFECTIVO DEBIDO: ", 30, Helpers::Dinero($data['total_efectivo']), 10));

    
    
    $printer -> text($doc->DosCol("DIFERENCIA: ", 30, Helpers::Dinero($data['diferencia']), 10));
    
    $printer -> text("______________________________________________");
    $printer->feed();
    
    
    
    
//     $printer -> text("ORDENES ELIMINADAS: ");
//     $printer->feed();
    
//     $printer -> setJustification(Printer::JUSTIFY_LEFT);
//     $printer -> setEmphasis(true);
//     $printer -> text($doc->Item('Cant', 'Descripcion', 'Total', null));
//     $printer -> setEmphasis(false);
    
    
//     $printer -> text("_______________________________________________________");
//     $printer->feed();
    
    
    
// foreach ($variable as $key => $value) {
//   $printer -> text($doc->Item("(" . $b["mesa"] . ") " . $b["cant"], $b["producto"], NULL ,$b["total"]));
  
// }
    
    
    
    $printer->feed();
    $printer->cut();
    $printer->close();
      

}






public function CorteZ($data, $printer){

}



public function ReporteDiario($data, $printer){

}









}// class