<?php

$TableInformation=array(
	'Administrators' => array('UserId'),
	'Contestants' => array('id','name','surname'),
	'Contests' => array('id','name','date'),
	'Corrections' => array('id','ProblemId','ContestantId','mark','comment','UserId'),
	'Participations' => array('id','ContestId','ContestantId'),
	'Permissions' => array('id','UserId','ContestId'),
	'Problems' => array('id','ContestId','name'),
	'Users' => array('id','username','passHash'),
);

function escape_input($value)
{
	if (is_null($value)) $value="";
	if (get_magic_quotes_gpc()) $value = stripslashes($value);
	if (!is_numeric($value)) {
		$mysqli=new mysqli(dbServer, dbUser, dbPass);
		$value = "'" . $mysqli->real_escape_string($value) . "'";
	}
	return $value;
}

function passwordHash($pass) {
	$salt="trecentoquarantaseidue";
	return crypt($pass,$salt);
}

function OpenDbConnection() {
	$db=new mysqli(dbServer, dbUser, dbPass);
	if ($db->connect_errno) die($db->connect_error);
	
	$db->select_db(dbName);
	return $db;
}

function QuerySelect($tableName, $constraints=NULL, $data=NULL, $order=NULL) {
	$query="SELECT ";
	if( !is_null($data) ) {
		$first=0;
		foreach ( $data as $x ) {
			if( $first==0 ){
				$query .=$x.' '; 
				$first=1;
			}
			else $query .=', '.$x.' ';
		}
	}
	else $query.='* ';
	$query.=' FROM '.$tableName.' ';
	
	if( !is_null( $constraints ) ) {
		$query .='WHERE ';
		$first=0;
		foreach ( $constraints as $field => $value ) {
			if( $first==0 ) {
				$query .= $field.'='.escape_input($value).' ';
				$first=1;
			}
			else $query .= 'AND '.$field.'='.escape_input($value).' ';
		}
	} 
	
	if( !is_null( $order ) ) {
		$query .= 'ORDER BY '.$order.' ';
	}
	
	return $query;
}

function QueryUpdate($tableName, $constraints, $data) {
	$query="UPDATE ".$tableName." SET ";
	if( !is_null($data) ) {
		$first=0;
		foreach ( $data as $field => $value ) {
			if( $first==0 ){
				$query .= $field.' = '.escape_input($value).' '; 
				$first=1;
			}
			else $query .=', '.$field.' = '.escape_input($value).' ';
		}
	}
	else die( "EMPTY UPDATE" );
	
	if( !is_null( $constraints ) ) {
		$query .='WHERE ';
		$first=0;
		foreach ( $constraints as $field => $value ) {
			if( $first==0 ) {
				$query .= $field.'='.escape_input($value).' ';
				$first=1;
			}
			else $query .= 'AND '.$field.'='.escape_input($value).' ';
		}
	}
	
	return $query;
}

function QueryInsert($tableName, $data) {
	if( is_null($data) ) die( "EMPTY INSERT" );
	$query='INSERT INTO '.$tableName.' ';
	$queryField='(';
	$queryValue='VALUES(';
	$first=0;
	foreach ($data as $field => $value) {
		if($first==1){
			$queryField .= ',';
			$queryValue .= ',';
		}
		$first=1;
		$queryField .= $field;
		$queryValue .= escape_input( $value );
	}
	$queryField .= ')';
	$queryValue .=')';
	
	return $query.' '.$queryField.' '.$queryValue;
}

function OneResultQuery($db, $query) {
	$result=$db->query($query) or die($db->error);
	return mysqli_fetch_array($result);
}

function ManyResultQuery($db, $query) {
	$result=$db->query($query) or die($db->error);
	$arr=[];
	while($x=mysqli_fetch_array($result)) $arr[]=$x;
	return $arr;
}

function Query($db, $query) {
	$db->query($query) or die($db->error);
}

function IsAdmin($db, $UserId) {
	$result=OneResultQuery( $db, QuerySelect('Administrators',['UserId'=>$UserId]) );
	if( is_null( $result ) ) return 0;
	else return 1;
}

function VerifyPermission($db, $UserId,$ContestId) {
	$result=OneResultQuery( $db, QuerySelect('Permissions',['UserId'=>$UserId, 'ContestId'=>$ContestId],['id']) );
	if( is_null( $result ) ) return 0;
	else return 1;
}

function build_sorter($key) {
	return function ($a, $b) use ($key) {
		return strcmp($a[$key], $b[$key]);
	};
}

?>
