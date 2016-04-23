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

/*
	Human-readable filesize
*/
function human_filesize($bytes, $decimals = 2) {
  $sz = 'BKMGTP';
  $factor = floor((strlen($bytes) - 1) / 3);
  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}