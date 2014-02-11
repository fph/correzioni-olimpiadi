<?php
	require_once "Utilities.php";
	SuperRequire_once("General", "sqlUtilities.php");
	
	function AskCategory($category){
		global $TableInformation;
		$db=new mysqli(dbServer, dbUser, dbPass);
		if ($db->connect_errno) die($db->connect_error);
		
		$db->select_db(dbName);
		$query="SELECT * FROM $category";
		$result=$db->query($query) or die($db->error);
		
		while ($row=mysqli_fetch_array($result)) {
			foreach ($TableInformation[$category] as $v) echo $row[$v]." ";
			echo "<br>";
		}
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
		
		$query="SELECT * FROM {$table} WHERE id={$id}";
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
		$query="SELECT * FROM Problems WHERE ContestId={$contestId}";
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
	
	function IsAdmin($UserId) {
		if( is_null( RequestById("Administrators",$UserId) ) ) return 0;
		else return 1;
	}
	
	function VerifyPermission($UserId,$ContestId) {
		$db=new mysqli(dbServer,dbUser,dbPass);
		if ($db->connect_errno) die($db->connect_error);
		
		$query="SELECT id FROM ".dbName.".Permissions WHERE UserId={$UserId} AND ContestId={$ContestId};";
		$result=$db->query($query) or die($db->error);
		if( is_null( mysqli_fetch_array($result) ) ) return 0;
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
		$query="SELECT * FROM Contestants WHERE ContestId={$contestId}";
		$result=$db->query($query) or die($db->error);
		$contestants=array();
		while ($row=mysqli_fetch_array($result)) array_push($contestants,$row);
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
