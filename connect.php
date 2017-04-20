<?php
	require_once('config.php');
	// SQL server connection information
	$sql_details = array(
		'user' => USERNAME,
		'pass' => PASSWORD,
		'db'   => 'info',
		'host' => HOST
	);

	
	// if(!($conn = mysql_connect(HOST,USERNAME,PASSWORD)))
	// {
	// 	echo mysql_error();
		
	// }

	// if(!mysql_select_db('info'))
	// {
	// 	echo mysql_error();
	// }

	// if(!mysql_query('set names utf8'))
	// {
	// 	echo mysql_error();
	// }
	class DBHelper
	{
		static $HOST=HOST;
		static $USERNAME=USERNAME;
		static $PASSWORD=PASSWORD;

		
		static function  getConnection()
		{
			$conn = mysql_connect(HOST,USERNAME,PASSWORD);
			return $conn;
		}

		static function closeConnection($conn2)
		{
			if(!$conn2)
			{
				mysql_close($conn2);
			}
			
		}

		static function selectDB($dbName)
		{
			mysql_select_db($dbName);
		}

		static function setCharset($charset)
		{
			mysql_query($charset);
		}

		static function query($sql)
		{
			$connection=self::getConnection();
			self::selectDB('info');
			$ret = mysql_query($sql);
			self::closeConnection($connection);
			return $ret;
		}

		static function getResultSet($sql)
		{
			$connection=self::getConnection();
			self::selectDB('info');
			$rows=array();

			if($result=self::query($sql))
			{
				$index=0;
				while($row = mysql_fetch_row($result))
				{
					$rows[$index] = $row;
					$index++;
				}
			}
			self::closeConnection($connection);
			return $rows;
		}

	}

	// DBHelper::getConnection();
	// DBHelper::selectDB('info');
?>