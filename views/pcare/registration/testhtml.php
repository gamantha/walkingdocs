<?php

//use app\models\Adjustment;

require __DIR__ . '/../../../reno/tcpdf/tcpdf.php';;

//============================================================+
// File name   : example_048.php
// Begin       : 2009-03-20
// Last Update : 2013-05-14
//
// Description : Example 048 for TCPDF class
//               HTML tables and table headers
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
 * @abstract TCPDF - Example: HTML tables and table headers
 * @author Nicola Asuni
 * @since 2009-03-20
 */
// Dummy Variable Data Diri


ob_end_clean();

//require_once('tcpdf_include.php');

class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = 'http://walkingdocs.gamantha.com/img/logo-bpjs.png';
        // $img_file = K_PATH_IMAGES.'ppa_bg.png';
//        $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
//        $pdf->Rect($x, $y, $w, $h, 'F', array(), array(128,255,128));

        $x = 15;
        $y = 35;
        $w = 30;
        $h = 30;

        $fitbox = 'L';
        $this->Image($img_file, $x, $y, $w, $h, 'JPG', '', '', false, 300, '', false, false, 0, $fitbox, false, false);
        // restore auto-page-break status
        $this->Cell(0, 15, '<< TCPDF Example 003sa >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 027');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$img_file = 'http://walkingdocs.gamantha.com/img/logo-bpjs.png';
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 027sfsfsfs', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//
//// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//
//// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//
//// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//
//// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// ---------------------------------------------------------

// set a barcode on the page footer
//$pdf->setBarcode(date('Y-m-d H:i:s'));

// set font
//$pdf->SetFont('helvetica', '', 11);

// add a page
$pdf->AddPage();


// print a message
$txt = "You can also export 1D barcodes in other formats (PNG, SVG, HTML). Check the examples inside the barcodes directory.\n";
$pdf->MultiCell(70, 50, $txt, 0, 'J', false, 1, 125, 30, true, 0, false, true, 0, 'T', false);
//$pdf->SetY(30);
$pdf->Image('logo-bpjs.png', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

// -----------------------------------------------------------------------------

//$pdf->SetFont('helvetica', '', 10);

// define barcode style
//$style = array(
//    'position' => '',
//    'align' => 'C',
//    'stretch' => false,
//    'fitwidth' => true,
//    'cellfitalign' => '',
//    'border' => true,
//    'hpadding' => 'auto',
//    'vpadding' => 'auto',
//    'fgcolor' => array(0,0,0),
//    'bgcolor' => false, //array(255,255,255),
//    'text' => true,
//    'font' => 'helvetica',
//    'fontsize' => 8,
//    'stretchtext' => 4
//);


// ---------------------------------------------------------


$html2 = '
<html>
<head>

<style type="text/css">

body { font-family: Arial; font-size: 19.3px }
.pos { position: absolute; z-index: 0; left: 0px; top: 0px }

</style>
</head>
<body>
<nobr><nowrap>

<div class="pos" id="_648:100" style="top:100;left:648">
<span id="_13.6" style="font-weight:bold; font-family:Arial; font-size:13.6px; color:#000000">
Kedeputian Wilayah</span>
</div>

<div class="pos" id="_0:0" style="top:1656">
<img name="_828:1170" src="page_003.jpg" height="828" width="1170" border="0" usemap="#Map"></div>
</nowrap></nobr>
</body>
</html>

';

//$pdf->writeHTML($html2, true, false, false, false, '');

//Close and output PDF document
$pdf->Output('example_021.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+