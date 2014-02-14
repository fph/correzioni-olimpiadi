<?php
	require_once "Constants.php";
	
	function GenerateAbsolutePath($type,$path) {
		if( $type == "Model" ) return "/Model/$path";
		else if( $type=="View" ) return "/View/$path";
		else if( $type=="General" ) return "/$path";
	}
	
	function GenerateIncludePath($type,$path){
		return ServerRoot.GenerateAbsolutePath($type,$path);
	}
	
	function GenerateUrl($type,$path) {
		return urlRoot.GenerateAbsolutePath($type,$path);
	}
	
	function SuperInclude($type, $path) {
		include GenerateIncludePath($type,$path);
	}
	
	function SuperRequire($type, $path) {
		require GenerateIncludePath($type,$path);
	}
	
	function SuperInclude_once($type, $path) {
		include_once GenerateIncludePath($type,$path);
	}
	
	function SuperRequire_once($type, $path) {
		//~ echo GenerateCorrectPath($type,$path);
		require_once GenerateIncludePath($type,$path);
	}
	
	function SuperRedirect($type,$path) {
		//~ echo GenerateUrl($type,$path);
		header("location: ".GenerateUrl($type,$path) );
	}
?>
