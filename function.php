<?php

function loadScript($script){
	$file = __DIR__.'/script/'.$script.'.php';
	if(file_exists($file)){
		$script = file_get_contents($file);
		return $script;
	}
}
