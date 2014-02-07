<?php
include 'dbCredentials.php';

$ProblemId = escape_input( $_POST["ProblemId"] );
$ContestantId = escape_input( $_POST["ContestantId"] );
$mark = escape_input( $_POST["mark"] );
$comment = escape_input( $_POST["comment"] );
$UserId = escape_input( $_POST["UserId"] );

$db=new mysqli ($dbServer, $dbUser, $dbPass);
if($db->connect_errno) die ($db->connect_error);

$query="INSERT INTO Corrections(ProblemId, ContestantId, mark, comment, UserId)
						VALUES($ProblemId,$ContestantId,$mark,$comment,$UserId);";
$db->query($query) or die($db->error);
$db->close();
?>