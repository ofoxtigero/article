<?php
	require_once('../connect.php');
	 function show($sql_details)
    {
		$table = 'leftmenu';

		$primaryKey = 'id';

		$columns = array(
			array( 'db' => 'id','dt' => 'id' ),
			array( 'db' => 'name','dt' => 'name' ),
			array( 'db' => 'url','dt' => 'url' ),
			array( 'db' => 'parentId','dt' => 'parentId'));

		require('../ssp.class.php');

		echo json_encode(
		SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
		);
		
    }


	function add()
	{

		$menuName=$_POST['menuName'];
		$menuUrl=$_POST['menuUrl'];
		$menuParentId = $_POST['menuParentId'];
		$insertsql = "insert into leftmenu(name,url,parentId) values('$menuName','$menuUrl','$menuParentId')";
		$ret = DBHelper::query($insertsql);
		echo $ret;
	}
    function delete()
    {
    	$menuId = $_GET['menuId'];
   		 $deletesql = "delete from leftmenu where id=".$menuId;
    	$ret = DBHelper::query($deletesql);

		echo $ret;
    }
    function edit()
    {
    	$menuId=$_POST['menuId'];
    	$menuName=$_POST['menuName'];
		$menuUrl=$_POST['menuUrl'];
		$menuParentId = $_POST['menuParentId'];
		$insertsql = "update leftmenu set name='$menuName',url='$menuUrl',parentId='$menuParentId' where id=".$menuId;
		$ret = DBHelper::query($insertsql);
		echo $ret;
    }
   $conn = DBHelper::getConnection();
	$opType = $_GET['opType'];
	// $menuName = $_POST['menuName'];
	// $menuUrl = $_POST['menuUrl'];
	// $menuParentId = $_POST['menuParentId'];

	switch ($opType) {
		case 'show':
			show($sql_details);
			break;
		case 'add':
			add();
			break;
		case 'edit':
			edit();
			break;
		case 'delete':
			delete();
			break;
		
		default:
			# code...
			break;
	}

	DBHelper::closeConnection($conn);
?>


