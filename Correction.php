<?php
include 'dbCredentials.php';

$ProblemId = escape_input( $_POST["ProblemId"] );
$ContestantId = escape_input( $_POST["ContestantId"] );
$mark = escape_input( $_POST["mark"] );
$comment = escape_input( $_POST["comment"] );
$UserId = escape_input( $_POST["UserId"] );

mysql_connect('localhost',$dbUser,$dbPass,$dbName) or die(mysql_error());
$query="INSERT INTO Corrections(ProblemId, ContestantId, mark, comment, UserId)
						VALUES($ProblemId,$ContestantId,$mark,$comment,$UserId);";
mysql_query($query) or die(mysql_error());

?>