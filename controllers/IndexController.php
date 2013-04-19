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
		$decrypt 	   = new Decrypt();
		$array_input   = array();
		$possible_keys = array();
		$error  = "";
		$output = "";
		$input  = "";
		
			#Form submit
			if( count($_POST) ){
				$input = trim($_POST["txtInput"]) != "" ? $_POST["txtInput"] : "";

					#Input no empty
					if( $input ){
						$array_input = explode("\n", $input);

						#The input has a valid format
						if( $decrypt->isValidInput($array_input) ){
							
							#Search the key
							$possible_keys = $decrypt->searchKey( $input );
								if(count($possible_keys) > 0){
									
									#Search in the possible keys the first with the key's pattern
									if( $decrypt->decryptKey($possible_keys) ){
										#Translate the input with the key
										$output = $decrypt->translateInput($array_input);
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
						$error = "Empty input is not valid!";
					}
			}
		
		include_once('views/index.phtml');
	}
	
}
?>