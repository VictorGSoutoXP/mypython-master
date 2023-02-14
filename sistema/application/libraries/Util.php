<?php 
	class Util {
		public static function PDF2PNG($name, $pagina = 1){
			if (!$name) return false;
			
			$name = (substr(php_uname(), 0, 7) == "Windows") ? str_replace('/', '\\', $name) : $name;
			$name = realpath($name);
			$path = realpath(config_item('upload_folder'));
			$sep = DIRECTORY_SEPARATOR;
			$app_name  = $path . $sep . "pdf2png.jar" ;
			
			$cmd = "java -jar " . $app_name . " \"" . $name . "\"" . " " . $pagina;
			
			$ret = array();
			exec($cmd, $ret); // . " > /dev/null &");
			log_message("debug", "======================= PDF2PNG ==========================");
			log_message("debug", $cmd);
			log_message("debug", "----------------------------------------------------------");
			foreach($ret as $r){
				log_message("debug", $r);
				if ($r == "SUCESSO") {
					return true;
				}
			}
			log_message("debug", "==========================================================");
			return false;
			
		}
	}
	
?>
