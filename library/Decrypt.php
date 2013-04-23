<?php
/**
 * Class with all the functions about the Crypt Kicker algorithm.
 * @author MBonell
 */
class Decrypt{
	
	public $key;
	public $crypted_key;
	public $characters_decrypted = array();
	
	public function __construct( $key = "la zorra cafe rapidamente brinco sobre el perro negro" ){
		$this->key = preg_split ( '/[\s]+/', trim($key) );
		$this->key = implode ( ' ', $this->key );
	}
	
	/**
	 * Check if the input is valid: 80 characters per line, 100 lines maximum and the
	 * first line is a number and the second blank line.
	 * @param array $input
	 */
	function isValidInput($input){
		$valid = true;
		 
		if(!is_numeric(trim($input[0])) || trim($input[1]) != ""){
			$valid = false;
		}
		
		if(count($input) > 100){
			$valid = false;
		}
			
		foreach ($input as $line){
			if(strlen($line) > 80){
				$valid = false;
				break;
			}
		}
		
		
		return $valid;
	}
	
	/**
	 * Search the lines the pattern that below to the key
	 * @param array $input
	 */
	function searchKey( $input ){

		$key_words =  preg_split ( '/[\s]+/', $this->key );
		$pattern = array();
		
		foreach( $key_words as $word ){
			$pattern [] = "[a-zñÑ]{" . mb_strlen($word) ."}";
		}
		
		$pattern = "/[\s]*".implode('[\s]+', $pattern)."[\s]*/iu";
		preg_match_all ($pattern, $input, $matches);

		$possible_keys = array();

		foreach ($matches as $match){
			if( isset($match[0]) && $match[0] ){
				$possible_keys [] = trim($match[0]); 
			}
		}

		return $possible_keys;
		
	}
	
	/**
	 * Check in the lines and found the first line with the pattern
	 * of the key.
	 * @param aray $possible_keys
	 */
	function decryptKey($possible_keys){
		$all_found = false;
		
		foreach ($possible_keys as $line_key){
			
			$line_key = preg_split ( '/[\s]+/', $line_key );
			$line_key = implode ( ' ', $line_key );
			
			if($all_found){
				return true;
			}else{	
				$this->characters_decrypted = array();
			}
			
			$len = mb_strlen($line_key);			
			
			for($i=0; $i<$len; $i++){
				if( ($this->key[$i] != " " && mb_substr ( $line_key , $i, 1 ) != " ") 
							|| ($this->key[$i] == " " && mb_substr ( $line_key , $i, 1 ) == " ") ){
					$this->characters_decrypted[ mb_substr ( $line_key , $i, 1 ) ] = $this->key[ $i ];
					$all_found = true;
				}else{
					$all_found = false;
					break;
				}
				
			}
			
			$this->crypted_key = $line_key;
		}
		return $all_found;
	}
	
	/**
	 * Translate the input with de characters decrypted based on the key.
	 * @param array $input
	 */
	function translateInput($input){
		$translated = "";
			foreach ($input as $line){
				$len = mb_strlen($line);
				$translated.="<br>";			
				for($i=0; $i<$len; $i++){
					if(isset($this->characters_decrypted[ mb_substr($line, $i, 1) ])){
						$translated .= $this->characters_decrypted[ mb_substr($line, $i, 1) ];
					}
				}
			}
		return $translated;
	}
	
	 
}
?>
