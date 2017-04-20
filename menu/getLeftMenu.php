<?php
    require_once('../connect.php');
  
    $sql = "select * from leftmenu";
    $table = DBHelper::getResultSet($sql);
    echo json_encode($table);

?>