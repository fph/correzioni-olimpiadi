<?php
	
	function GenerateCorrectPath($type,$path){
		$ServerRoot="/afs/uz.sns.it/nobackup/dario2994/public_html/correzioni-olimpiadi";
		if( $type == "Model" ) return "$ServerRoot/Model/$path";
		else if( $type=="View" ) return "$ServerRoot/View/$path";
		else if( $type=="General" ) return "$ServerRoot/$path";
	}
	
	function SuperInclude($type, $path) {
		include GenerateCorrectPath($type,$path);
	}
	
	function SuperRequire($type, $path) {
		require GenerateCorrectPath($type,$path);
	}
	
	function SuperInclude_once($type, $path) {
		include_once GenerateCorrectPath($type,$path);
	}
	
	function SuperRequire_once($type, $path) {
		//~ echo GenerateCorrectPath($type,$path);
		require_once GenerateCorrectPath($type,$path);
	}
	
	function SuperRedirect($type,$path) {
		header("location: ".GenerateCorrectPath($type,$path) );
	}
?>
