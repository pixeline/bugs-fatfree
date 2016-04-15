<?php

function pr($var, $exit = true){
	echo '<pre>';
	if(is_array($var)){
		print_r($var);
		exit;
	} else{
		var_dump($var);
	}
	echo '</pre>';
	if($exit){
		exit;
	}
}

function truncate($str, $max_words = 20, $ellipsis =' ...'){
	$str = explode(' ', $str);
	
	if( count($str) > $max_words){
		$str = array_slice($str , 0, $max_words);
		$str = implode(' ', $str) . $ellipsis;
	} else{
		$str = implode(' ', $str);
	}
	
	return $str;
}