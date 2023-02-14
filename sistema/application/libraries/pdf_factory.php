<?php
// https://pranavom.wordpress.com/2011/03/15/modify-pdf-using-fpdffpdi-library/

if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

require_once('fpdf/fpdf.php');
require_once('fpdi/src/autoload.php');

class pdf_factory {
	public static $FPDI = 0;
	public function create($idx){
		switch($idx){
			case 0:
				return new FPDI();
			
		}
		return null;
	}
}

	