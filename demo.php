<?php
$k = "1

uñou uñ ub eceuhoc axrx yiu bcñ vcekruñ xqisxh x xtisxr x bx pfuñox
bx wcrrx qxpu rxafsxeuhou krfhqc ñckru ub aurrc humrc
bcñ qchqirñcñ su arcmrxexqfch ñch sfnurofscñ";

$d = "la zorra cafe rapidamente brinco sobre el perro negro"; // TODO hacer parametro

$key_words =  preg_split ( '/[\s]+/', $d );

$pattern = array();
foreach( $key_words as $word ){
	$pattern [] = "[a-zñÑ]{" . strlen($word) ."}";
}
$pattern = "/".implode('[\s]+', $pattern)."/i";

preg_match_all ($pattern, $input, $matches);

$possible_keys = array();

var_dump($matches);

foreach ($matches as $match){
	if( $match[0] ){
		$possible_keys [] = $match[0];
	}
}
var_dump($possible_keys);

preg_match_all($p, $k, $m);

var_dump($m);