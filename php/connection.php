<?php require_once("functions.php") ?>

<?php 
	$cnn = mysql_connect("127.0.0.1", "root", "");
	confirm($cnn, "connection failed");

	$db = mysql_select_db("task_anmol", $cnn);
	confirm($db, "db can not be selected");

 ?>