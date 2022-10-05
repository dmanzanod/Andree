<?php
require_once 'dompdf/lib/html5lib/Parser.php';
require_once 'dompdf/lib/php-font-lib/src/FontLib/Autoloader.php';
require_once 'dompdf/lib/php-svg-lib/src/autoload.php';
require_once 'dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();


$content = '<h1>hello world</h1>';


$dompdf->loadHtml($content);
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portair');
// Render the HTML as PDF
$dompdf->render();
$pdf = $dompdf->output();
// Output the generated PDF to Browser
$dompdf->stream('test.pdf');

?>