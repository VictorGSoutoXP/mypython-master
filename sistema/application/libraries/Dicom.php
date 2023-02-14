<?php

require 'nanodicom.php';

class Dicom {
	
	private $CI;
	
	function __construct() {
		$this->CI = & get_instance();
	}
	
	function getInstance($filename){
		return Nanodicom::factory($filename); //, 'simple');
	}
	
}