<?php
	require_once "Utilities.php";
	SuperRequire_once("General", "sqlUtilities.php");
	
	function OpenDbConnection() {
		$db=new mysqli(dbServer, dbUser, dbPass);
		if ($db->connect_errno) die($db->connect_error);
		
		$db->select_db(dbName);
		return $db;
	}
	
	function QuerySelect($tableName, $data=NULL, $info=NULL) {
		$query="SELECT ";
		if( !is_null($info) ) {
			$first=0;
			foreach ( $info as $x ) {
				if( $first==0 ){
					$query .=$x.' '; 
					$first=1;
				}
				else $query .=', '.$x.' ';
			}
		}
		else $query.='* ';
		$query.=' FROM '.$tableName.' ';
		
		if( !is_null( $data ) ) {
			$query .='WHERE ';
			$first=0;
			foreach ( $data as $field => $value ) {
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
		$n=0;
		while($arr[$n]=mysqli_fetch_array($result))$n++;
		return $arr;
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
