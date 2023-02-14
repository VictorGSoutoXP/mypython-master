<?php
class MY_Controller extends CI_Controller {
	protected $_dataView = array();
	
	function __construct() {
		parent::__construct ();
// 		$this->output->enable_profiler(TRUE);
		$this->_dataView['error'] = $this->session->flashdata('error');
		$this->_dataView['info'] = $this->session->flashdata('info');
	}
}
