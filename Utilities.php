<?php
require_once "Constants.php";

function GenerateAbsolutePath($type,$path) {
	if( $type == "Model" ) return "/Model/$path";
	else if( $type=="View" ) return "/View/$path";
	else if( $type=="General" ) return "/$path";
	else if( $type=="Modify" ) return "/Modify/$path";
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
	require_once GenerateIncludePath($type,$path);
}

function SuperRedirect($type,$path) {
	header("location: ".GenerateUrl($type,$path) );
}

//Compare function to pass to usort for sorting an array of object, using the property $key
function BuildSorter($key) {
	return function ($a, $b) use ($key) {
		return strnatcasecmp($a[$key], $b[$key]);
	};
}

function GetExtendedItalianDate($date){
	if ($date==null) return $date;
	$DividedDate=explode("-",$date);
	$ItalianDate=strval(intval($DividedDate[2]))." ";
	
	$month=$DividedDate[1];
	if ($month=='01') $ItalianDate.="gennaio";
	if ($month=='02') $ItalianDate.="febbraio";
	if ($month=='03') $ItalianDate.="marzo";
	if ($month=='04') $ItalianDate.="aprile";
	if ($month=='05') $ItalianDate.="maggio";
	if ($month=='06') $ItalianDate.="giugno";
	if ($month=='07') $ItalianDate.="luglio";
	if ($month=='08') $ItalianDate.="agosto";
	if ($month=='09') $ItalianDate.="settembre";
	if ($month=='10') $ItalianDate.="ottobre";
	if ($month=='11') $ItalianDate.="novembre";
	if ($month=='12') $ItalianDate.="dicembre";
	$ItalianDate.=" ".$DividedDate[0];
	return $ItalianDate;
}

function GetRestrictedItalianDate($date){
	if ($date==null) return $date;
	$DividedDate=explode("-",$date);
	$ItalianDate=$DividedDate[2]."/".$DividedDate[1]."/".$DividedDate[0];
	return $ItalianDate;
}

function GetItalianDate($date){
	return GetExtendedItalianDate($date);
}
