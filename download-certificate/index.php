<?php
/*  ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);  */
// ============================================================+
// File name   : example_002.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 002 for TCPDF class
//               Removing Header and Footer
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
 * @abstract TCPDF - Example: Removing Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path)./public_html/members/
require( dirname( __FILE__ ) . '/lib/tcpdf/tcpdf.php' );
require('../wp-load.php' );
$siteurl = get_bloginfo('url');
// define("K_PATH_IMAGES", $siteurl . "/membership-certificate/tcpdf/images/", true);
// create new PDF document

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$user = wp_get_current_user();
$fname = $user->user_firstname;
$lname = $user->user_lastname;
$username = $fname  . ' ' . $lname ;
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($username);
$pdf->SetTitle('Download Membership Certificate');
$pdf->SetSubject($username . ' Membership Certificat');
$pdf->SetKeywords('Global Healthcare Provider Network &amp; Integrative Association - AIHM');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', 'B', 20);

// add a page
$pdf->AddPage('P', 'A4');

/*
 Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false, $alt=false, $altimgs=array()
*/
// set bacground image
$img_file = $siteurl . "/download-certificate/tcpdf/images/bg_certificate.jpg";
$pdf->Image($img_file, 0, 0, 200, 150, '', '', 'C', false, 300, '', false, false, 0);

global $bp;

//$the_user_id = $bp->loggedin_user->userdata->ID;
$user_id = bp_loggedin_user_id();
$credentials = bp_get_profile_field_data('field=credentials&user_id=' . $user_id);
			
$username = '<h3 style="text-transform: uppercase;  color: #0c80a8; font-weight: 600; font-size: 22px;">'. $fname .' ' . $lname .', '. $credentials . '</h3>';
$pdf->writeHTMLCell(165, 10, 12, 68, $username, 0, '',false, true, 'L', true	);
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('pdf-certificate.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+