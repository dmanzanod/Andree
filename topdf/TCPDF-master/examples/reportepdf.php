<?php
session_start();

$con = mysqli_connect('ec2-3-87-203-241.compute-1.amazonaws.com','zazudb2','zazu2023','bd_andree');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"bd_andree");
$sql="SELECT tbl_asegurado.nomre_asegurado as nombre, tbl_asegurado.apellido_asegurado as apellido, nro_folio, total_reembolso, fecha FROM frm_historic, tbl_asegurado where frm_historic.rut_asegurado_h = tbl_asegurado.rut_asegurado AND nro_folio = '".$_GET["id"]."'";
$result = mysqli_query($con,$sql);

while($row = mysqli_fetch_array($result)) {
    $total = number_format($row['total_reembolso']);
    $fecha = $row['fecha'];
    $numero = $row['nro_folio'];
    $nombre = $row['nombre'];
    $apellido = $row['apellido'];
}
mysqli_close($con);


//============================================================+
// File name   : example_006.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 006 for TCPDF class
//               WriteHTML and RTL support
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML and RTL support
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
//require_once('tcpdf_include.php');
require_once('tcpdf_include.php');


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('David Manzano');
$pdf->SetTitle('Comprobante BIENESTAR ANDRÉE SEGURO COMPLEMENTARIO DE SALUD');
$pdf->SetSubject('Comprobante Reembolso');
$pdf->SetKeywords('PDF');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
///$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/es.php')) {
	require_once(dirname(__FILE__).'/lang/es.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
$html = '<table style="width: 408px;" border="0" cellspacing="1" cellpadding="1">
<tbody>
<tr>
<td style="width: 150px;" rowspan="12"><img src="LOGOTIPO_COLOR.jpg" alt="Avatar" style="width:300px"></td>
<td style="width: 234px;">Nombre del Asegurado:</td>
<td style="width: 212px;" colspan="2"><strong><span style="text-align: left; ">'.$nombre.' '.$apellido.'</span></strong></td>
</tr>
<tr>
<td style="width: 234px;">Recib&iacute; conforme Banco BBVA N&ordm;:</td>
<td style="width: 212px;" colspan="2"><strong><span style=""></span></strong></td>
</tr>
<tr>
<td style="width: 234px;">De Fecha: <strong>'.$fecha.'</strong></td>
<td style="width: 47px; text-align: right;">por:</td>
<td style="width: 165px;"><strong><span style="">$ '.$total.'</span></strong></td>
</tr>
<tr>
<td  colspan="3">Correspondiente a reembolso (s) de Seguro Complementario de Salud</td>
</tr>
<tr>
<td colspan="3">Nro: <strong><span style="">'.$numero.'</span></strong></td>
</tr>
<tr>
<td  colspan="3">&nbsp;</td>
</tr>
<tr>
<td  colspan="3">&nbsp;</td>
</tr>
<tr>
<td  colspan="3">&nbsp;</td>
</tr>
<tr>
<td style="width: 200px; text-align: center;">______________________________</td>
<td style="width: 80px;">&nbsp;</td>
<td style="text-align: center;">__________________________</td>
</tr>
<tr>
<td style="text-align: center;">Firma y timbre BIENESTAR ANDR&Eacute;E SEGURO COMPLEMENTARIO DE SALUD</td>
<td >&nbsp;</td>
<td style="text-align: center;">Firma del Asegurado</td>
</tr>
<tr>
<td  colspan="3">&nbsp;</td>
</tr>
</tbody>
</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->lastPage();

//Close and output PDF document
$pdf->Output('comprobante.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
