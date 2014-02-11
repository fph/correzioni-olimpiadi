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
		$query.=" FROM ".dbName.".".$tableName.' ';
		
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
	
	function AskWholeTable($table){
		global $TableInformation;
		$db=new mysqli(dbServer, dbUser, dbPass);
		if ($db->connect_errno) die($db->connect_error);
		
		$db->select_db(dbName);
		$query='SELECT * FROM '.$table;
		$result=$db->query($query) or die($db->error);
		
		$resultArray=[];
		$n=0;
		while ($resultArray[$n]=mysqli_fetch_array($result)) $n++;
		return ['len'=>$n, 'list'=>$resultArray];
	}
	
	function VerifyCredentials($postUser, $postPsw){
		$user=escape_input($postUser);
		$psw=escape_input(passwordHash($postPsw));
		
		$db=new mysqli(dbServer, dbUser, dbPass);
		if ($db->connect_errno) die($db->connect_error);
		
		$db->select_db(dbName);
		$query="SELECT id FROM Users WHERE user=$user AND passHash=$psw";
		$result=$db->query($query) or die($db->error);
		
		if ($UserId=mysqli_fetch_array($result)['id']) return $UserId;
		return -1;
	}
	
	function RequestById($table,$id){ //Richiede la info corrispondenti a quell'id, returns null if there isn't any corresponding id 
		$db=new mysqli(dbServer, dbUser, dbPass);
		if ($db->connect_errno) die($db->connect_error);
		$db->select_db(dbName);
		
		$query="SELECT * FROM {$table} WHERE id=".escape_input($id);
		echo $query." ";
		$result=$db->query($query) or die($db->error);
		return mysqli_fetch_array($result);
	}
	
	function ContestByParticipation($participationId){
		$res=RequestById("Participations",$participationId);
		return $res["ContestId"];
	}
	
	function ContestantByParticipation($participationId){
		$res=RequestById('Participations',$participationId);
		return $res["ContestantId"];
	}
	
	function AskParticipation($contestId,$contestantId){
		
		$db=new mysqli(dbServer, dbUser, dbPass);
		if ($db->connect_errno) die($db->connect_error);
		$db->select_db(dbName);
		
		//Mette nell'array problems le informazioni sui problemi della gara selezionata
		$query="SELECT * FROM Problems WHERE ContestId=".escape_input($contestId);
		$result=$db->query($query) or die($db->error);
		$problems=array();
		while ($row=mysqli_fetch_array($result)) array_push($problems,$row);
		
		$corrections=array();
		foreach ($problems as $prob) {
			$query="SELECT * FROM Corrections WHERE ContestantId={$contestantId} AND ProblemId={$prob['id']}";
			$result=$db->query($query) or die($db->error);
			$nn=mysqli_fetch_array($result);
			if ( is_null($nn) ) {
				$nn["done"]=false;
			}
			else {
				$nn["done"]=true;
				$nn["User"]=RequestById("Users",$nn["UserId"])["user"];
			}
			$nn["Problem"]=RequestById("Problems",$prob["id"])["name"];
			array_push($corrections, $nn);
		}
		return $corrections;
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
	
	function ProblemsByContest($contestId){
		$db=new mysqli(dbServer, dbUser, dbPass);
		if ($db->connect_errno) die($db->connect_error);
		$db->select_db(dbName);
		
		//Mette nell'array problems le informazioni sui problemi della gara selezionata
		$query="SELECT * FROM Problems WHERE ContestId={$contestId}";
		$result=$db->query($query) or die($db->error);
		$problems=array();
		while ($row=mysqli_fetch_array($result)) array_push($problems,$row);
		return $problems;
	}
	
	function ContestantsByContest($contestId){
		$db=new mysqli(dbServer, dbUser, dbPass);
		if ($db->connect_errno) die($db->connect_error);
		$db->select_db(dbName);
		
		//Mette nell'array problems le informazioni sui problemi della gara selezionata
		$query="SELECT * FROM Participations WHERE ContestId={$contestId}";
		$result=$db->query($query) or die($db->error);
		$contestants=array();
		while ($row=mysqli_fetch_array($result)) {
			$nn=RequestById("Contestants",$row["ContestantId"]);
			array_push($contestants,$nn);
		}
		return $contestants;
	}
	
	function AskProblem($problemId) {
		$db=new mysqli(dbServer, dbUser, dbPass);
		if ($db->connect_errno) die($db->connect_error);
		$db->select_db(dbName);
		
		$corrections=array();
		$query="SELECT * FROM Corrections WHERE ProblemId={$problemId}";
		$result=$db->query($query) or die($db->error);
		while ($nn=mysqli_fetch_array($result)) {
			if ( is_null($nn) ) {
				$nn["done"]=false;
			}
			else {
				$nn["done"]=true;
				$nn["User"]=RequestById("Users",$nn["UserId"])["user"];
				$nn["Contestant"]=RequestById("Contestants",$nn["ContestantId"]);
			}
			array_push($corrections, $nn);
		}
		
		return $corrections;
	}
	
?>
