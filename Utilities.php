<?php
	
	function GenerateAbsolutePath($type,$path) {
		if( $type == "Model" ) return "/Model/$path";
		else if( $type=="View" ) return "/View/$path";
		else if( $type=="General" ) return "/$path";
	}
	
	function GenerateIncludePath($type,$path){
		$ServerRoot="/afs/uz.sns.it/nobackup/dario2994/public_html/correzioni-olimpiadi";
		return $ServerRoot.GenerateAbsolutePath($type,$path);
	}
	
	function GenerateUrl($type,$path) {
		return "/~dario2994/correzioni-olimpiadi".GenerateAbsolutePath($type,$path);
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
		header("location: ".GenerateUrl($type,$path) );
	}
?>
