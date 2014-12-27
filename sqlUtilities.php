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

function EscapeInput($value) {
	if (is_null($value)) return 'NULL';
	if ( !is_string($value) and !is_int($value) ) die("The value passed to EscapeInput is not a string nor an integer.");
	if (get_magic_quotes_gpc()) $value = stripslashes($value);
	if ( is_string($value) ) {
		$mysqli=new mysqli(dbServer, dbUser, dbPass);
		$value = "'" . $mysqli->real_escape_string($value) . "'";
	}
	return $value;
}

function PasswordHash($pass) {
	$salt="trecentoquarantaseidue";
	return crypt($pass,$salt);
}

function OpenDbConnection() {
	$db=new mysqli(dbServer, dbUser, dbPass);
	if ($db->connect_errno) die($db->connect_error);
	
	$db->select_db(dbName);
	return $db;
}

function QuerySelect($TableName, $constraints=null, $data=null, $order=null) {
	$query='SELECT ';
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
	$query.=' FROM '.$TableName.' ';
	
	if( !is_null( $constraints ) ) {
		$query .='WHERE ';
		$first=0;
		foreach ( $constraints as $field => $value ) {
			if( $first==0 ) {
				$query .= $field.'='.EscapeInput($value).' ';
				$first=1;
			}
			else $query .= 'AND '.$field.'='.EscapeInput($value).' ';
		}
	} 
	
	if( !is_null( $order ) ) {
		$query .= 'ORDER BY '.$order.' ';
	}
	
	return $query;
}

function QueryUpdate($TableName, $constraints, $data) {
	$query="UPDATE ".$TableName." SET ";
	if( !is_null($data) ) {
		$first=0;
		foreach ( $data as $field => $value ) {
			if( $first==0 ){
				$query .= $field.' = '.EscapeInput($value).' '; 
				$first=1;
			}
			else $query .=', '.$field.' = '.EscapeInput($value).' ';
		}
	}
	else die( "EMPTY UPDATE" );
	
	if( !is_null( $constraints ) ) {
		$query .='WHERE ';
		$first=0;
		foreach ( $constraints as $field => $value ) {
			if( $first==0 ) {
				$query .= $field.'='.EscapeInput($value).' ';
				$first=1;
			}
			else $query .= 'AND '.$field.'='.EscapeInput($value).' ';
		}
	}
	
	return $query;
}

function QueryInsert($TableName, $data) {
	if( is_null($data) ) die( "EMPTY INSERT" );
	$query='INSERT INTO '.$TableName.' ';
	$QueryField='(';
	$QueryValue='VALUES(';
	$first=0;
	foreach ($data as $field => $value) {
		if($first==1){
			$QueryField .= ',';
			$QueryValue .= ',';
		}
		$first=1;
		$QueryField .= $field;
		$QueryValue .= EscapeInput( $value );
	}
	$QueryField .= ')';
	$QueryValue .=')';
	
	return $query.' '.$QueryField.' '.$QueryValue;
}

function QueryDelete($TableName, $constraints) {
	$query='DELETE FROM '.$TableName.' ';
	if( !is_null( $constraints ) ){
		$query .= 'WHERE ';
		$first=0;
		foreach ( $constraints as $field => $value ) {
			if( $first==1 ) $query .= 'AND ';
			$first=1;
			$query .= $field.'='.EscapeInput($value).' ';
		}
	}
	return $query;
}

function QueryCompletion($TableName, $ConstraintsLike=null, $ConstraintsEqual=null, $data=null, $RowsNumber=null) {
	$query='SELECT ';
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
	$query.=' FROM '.$TableName.' ';
	
	$first=0;
	if( !is_null( $ConstraintsEqual ) ) {
		foreach ( $ConstraintsEqual as $field => $value ) {
			if( $first==0 ) {
				$query .= 'WHERE '.$field.'='.EscapeInput($value).' ';
				$first=1;
			}
			else $query .= 'AND '.$field.'='.EscapeInput($value).' ';
		}
	}
	if( !is_null( $ConstraintsLike ) ) {
		foreach ( $ConstraintsLike as $field => $value ) {
			if( $first==0 ) {
				$query .= 'WHERE '.$field.' LIKE '.EscapeInput($value.'%').' ';
				$first=1;
			}
			else $query .= 'AND '.$field.' LIKE '.EscapeInput($value.'%').' ';
		}
	}
	
	$query .= 'LIMIT 0,';
	if( !is_null( $RowsNumber ) and is_int($RowsNumber) and $RowsNumber>0 ) $query .= strval($RowsNumber);
	else $query .= '10';
	return $query;
}

function OneResultQuery($db, $query) { //TODO... si potrebbe in qualche modo ottimizzare la query per avere un unico risultato...
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
