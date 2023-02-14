<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

require_once ("mpdf_lib/mpdf.php");

class pdf {
	public function mpdf($html, $filename = null, $dest = 'I', $header = "", $footer = "") {
		
		$mpdf = new mPDF ();
		
		if ($header) {
			$mpdf->SetHTMLHeader ( $header );
		} else {
			$mpdf->SetHeader ( 'Emissão: {DATE j/m/Y}|Pág {PAGENO}/{nb}|Laudo Online v1.1 rvcs' );
		}
		
		if ($footer) {
			$mpdf->SetHTMLHeader ( $footer );
		} else {
			$mpdf->SetFooter ( 'Emissão: {DATE j/m/Y}|Pág {PAGENO}/{nb}|Laudo Online v1.1 rvcs' );
		}
		// Rodapé: Seta a data/hora completa de quando o PDF foi gerado + um
		// texto no lado direito
		
		$mpdf->WriteHTML ( $html );
		
		// define um nome para o arquivo PDF
		if ($filename == null) {
			$filename = date ( "Y-m-d_his" ) . '_impressao.pdf';
		}
		
		return $mpdf->Output ( $filename, $dest );
	}
	
/*
 * End of file pdf.php
 */
/* Location: library/pdf.php */

}