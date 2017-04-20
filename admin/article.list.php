<?php
	require_once('../connect.php');
	// echo "<script>alert('testffff');</script>";
 	$conn= DBHelper::getConnection();

	$sql="select * from article";
	if($result=mysql_query($sql))
	{
		$resultset = mysql_fetch_assoc($result);
		echo json_encode($resultset);
	}

    DBHelper::closeConnection($conn);

?>