<?php
class MY_Loader extends CI_Loader {
	private $layout_enabled = true;


	public function __construct() {
		parent::__construct ();
	}

	/**
	 * Load View
	 *
	 * This function is used to load a "view" file.  It has three parameters:
	 *
	 * USAGE:
	 * $this->load($this->_dataView); //load the controller/action file view
	 * $this->load("custom/view", $this->_dataView); // Load custom view
	 * $this->load($this->_dataView, true); // return view rendered string, not render
	 * $this->load($this->_dataView, true, false); // render only view, not render layout
	 * 
	 *
	 * @access	public
	 * @param	mixed string name of the "view" file or an associative array of data to be extracted for use in the view
	 * @param	mixed bool true or false - whether to return the data or load it. Or an associative array of data
	 * @param	bool true or false - Enable or disable the load of the layout file
	 * @param	bool optional parameter
	 * @return	void
	 */
	public function view($vars = array(), $return = FALSE, $layout_enable = TRUE, $opt = TRUE){
		$loadedData = array ();
		if(is_array($vars)){
			$CI =& get_instance();
			$view = "{$CI->router->class}/{$CI->router->method}" ;
		}else{
			$view = $vars;
			$vars = $return;
			$return = $layout_enable;
			$layout_enable = $opt;
		}
		if($this->layout_enabled && $layout_enable){
			$loadedData ['content'] = parent::view ( $view, $vars, true );
			return parent::view("layouts/layout", $loadedData, $return);
		}else{
			return parent::view($view, $vars, $return);
		}
	}

	public function disableLayout(){
		$this->layout_enabled = false;
	}

	public function enableLayout(){
		$this->layout_enabled = true;
	}
}

?>