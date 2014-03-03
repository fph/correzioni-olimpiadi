<?php
	require_once '../Utilities.php';
	SuperRequire_once('General','SessionManager.php');
	SuperRequire_once('General','sqlUtilities.php');
	SuperRequire_once('General','PermissionManager.php');

	function GetContest( $db, $str ) {
		$query=QueryCompletion('Contests',['name'=>$str]);
		$PartialResult=ManyResultQuery($db,$query);
		$result=[];
		for($i=0;$i<count($PartialResult);$i++) {
			$option=$PartialResult[$i];
			$item['value']=$option['id'];
			$item['InputText']=$option['name'];
			$item['OptionText']=$option['name'].' - '.GetItalianDate($option['date']);
			$result[]=$item;
		}
		return $result;
	}
	
	function GetContestant( $db, $str ) {
		$query=QueryCompletion('Contestants',['surname'=>$str]);
		$PartialResult=ManyResultQuery($db,$query);
		$result=[];
		for($i=0;$i<count($PartialResult);$i++) {
			$option=$PartialResult[$i];
			$item['value']=$option['id'];
			$item['InputText']=$option['surname'].' '.$option['name'];
			$item['OptionText']=$option['surname'].' '.$option['name'].' - '.$option['school'];
			$result[]=$item;
		}
		return $result;
	}
	
	function GetUser( $db, $str ) {
		$query=QueryCompletion('Users',['username'=>$str]);
		$PartialResult=ManyResultQuery($db,$query);
		$result=[];
		for($i=0;$i<count($PartialResult);$i++) {
			$option=$PartialResult[$i];
			$item['value']=$option['id'];
			$item['InputText']=$option['username'];
			$item['OptionText']=$option['username'];
			$result[]=$item;
		}
		return $result;
	}

	$db= OpenDbConnection();
	if( IsAdmin( $db, GetUserIdBySession() ) == 0 ) {
		$db -> close();
		echo json_encode( [] );
		die();
	}
	
	$data=json_decode($_POST['data'],1);
	if(is_null($data)) {
		$db -> close();
		echo json_encode( [] );
		die();
	}
	$type=$data['type'];
	$str=$data['str'];
	$id=$data['id'];
	
	//~ if( !is_string($str) ) {
		//~ $db->close();
		//~ echo json_encode( ['id'=>$id, 'list'=> [] ]);
		//~ die();
	//~ }
	
	if( $type == 'contest' ) echo json_encode( ['id'=>$id, 'list'=> GetContest($db, $str)] );
	else if( $type == 'contestant' ) echo json_encode( ['id'=>$id, 'list'=> GetContestant($db, $str)] );
	else if( $type == 'user' ) echo json_encode( ['id'=>$id, 'list'=> GetUser($db, $str)] );
	else echo json_encode( ['id'=>$id, 'list'=> [] ] );
	
	$db -> close();
?>
