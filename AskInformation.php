<?php
	require_once "Utilities.php";
	SuperRequire_once("General", "sqlUtilities.php");
	
	function OpenDbConnection() {
		$db=new mysqli(dbServer, dbUser, dbPass);
		if ($db->connect_errno) die($db->connect_error);
		
		$db->select_db(dbName);
		return $db;
	}
	
	function QuerySelect($tableName, $constraints=NULL, $data=NULL) {
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
	
?>
