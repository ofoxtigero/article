<?php
require_once('../connect.php');

if(!(isset($_POST['articleTitle'])&&(!empty($_POST['articleTitle'])))){
	echo "<script>alert('标题不能为空');window.location.href='../addarticle.html'</script>";
}

$title = $_POST['articleTitle'];
$author = $_POST['articleAuthor'];
$description = $_POST['articleDesc'];
$content = $_POST['articleContent'];
$dateline = time();

$insertsql = "insert into article(title,author,description,content,dateline) values('$title','$author','$description','$content',$dateline)";

 if(mysql_query($insertsql)){
	echo "<script>alert('成功发布文章。');window.location.href='../addarticle.html'</script>";
}

?>