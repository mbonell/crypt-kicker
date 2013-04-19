<?php
/**
 * Main controller.
 * @author MBonell
 */
class IndexController{
	
	/**
	 * Entry point function.
	 */
	function index(){
		$array_input   = array();
		$possible_keys = array();
		$error  = "";
		$output = "";
		$input  = "";
		$key    = "";
		$crypted_key = "";
		
			#Form submit
			if( count($_POST) ){
				$input = trim($_POST["txtInput"]) != "" ? $_POST["txtInput"] : "";
				$key   = trim($_POST["txtKey"]) != "" ? $_POST["txtKey"] : "";
				
					#Input and key no empty
					if( $input && $key){
						
						$array_input = explode("\n", $input);
						$decrypt = new Decrypt($key);
						
						#The input has a valid format
						if( $decrypt->isValidInput($array_input) ){
							
							#Search the key
							$possible_keys = $decrypt->searchKey( $input );
								if(count($possible_keys) > 0){
									
									#Search in the possible keys the first with the key's pattern
									if( $decrypt->decryptKey($possible_keys) ){
										#Translate the input with the key
										$output = $decrypt->translateInput($array_input);
										$crypted_key = $decrypt->cryppted_key;
									}else{
										$output = "NO SE ENCONTR&Oacute; SOLUCI&Oacute;N";	
									}
									
								}else{
									$output = "NO SE ENCONTR&Oacute; SOLUCI&Oacute;N";	
								}
								
						}else{
							$error = "80 characters per line, 100 lines maximum and the first line is a number and the second blank line.";	
						}
					}else{
						$error = "Empty input/key is not valid!";
					}
			}
		
		include_once('views/index.phtml');
	}
	
}
?>