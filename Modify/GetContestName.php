<?php
	require_once '../Utilities.php';
	SuperRequire_once('General','SessionManager.php');
	SuperRequire_once('General','sqlUtilities.php');
	SuperRequire_once('General','PermissionManager.php');

	function GetContestNameFromDb( $db, $str ) {
		if( !is_string($str) ) return [];
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
	$str=$data['str'];
	$id=$data['id'];
	
	echo json_encode( ['id'=>$id, 'list'=> GetContestNameFromDb( $db, $str)] );
	$db -> close();
?>
