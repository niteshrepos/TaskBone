<?php 

$cnn= mysql_connect("127.0.0.1", "root", "");
if (!$cnn) {
    die("databses connection failed". mysql_errno());
}
 
//step-2 use database
 
$db_select= mysql_select_db("tasks", $cnn);
if (!$db_select) {
    die("databses selection failed". mysql_errno());
}

?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$request_body = file_get_contents('php://input');
	$req_object =  json_decode($request_body);
	
	$title = $req_object->title; 
	$complete = $req_object->complete; 

	$result  = mysql_query("INSERT INTO task (title, complete) VALUES (\"{$title}\", {$complete})");
	if(mysql_affected_rows() == 1){
		echo "success";
	}else{
		echo("failed");
		die(mysql_error());
	}
	echo $title;
	echo $complete;
	
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

	$id = $_GET["task"];
	mysql_query("DELETE FROM task WHERE id = {$id}");
	if(mysql_affected_rows() == 1){
		echo "success";
	}else{
		echo("failed");
		die(mysql_error());
	}

}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
	$request_body = file_get_contents('php://input');
	$req_object =  json_decode($request_body);
	$id = $req_object->id; 
	$title = $req_object->title; 
	$complete = $req_object->complete; 

	mysql_query("UPDATE task SET title=\"{$title}\" WHERE id={$id}", $cnn);
	if(mysql_affected_rows() == 1){
		echo "success";
	}else{
		echo("failed");
		die(mysql_error());
	}
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$task_Id = $_GET["task"];

//step3 perform database query
 
	$result= mysql_query("SELECT * from task WHERE id = {$task_Id}", $cnn);
	if (!$result) {
	    die("databses query failed". mysql_errno());
	}
	 
	//step4 use returned data
	while ($row= mysql_fetch_array($result)) {
	    // echo  "{id:".$task_Id.",title".$row["title"].",done:".$row["complete"]+"}" ;//.
		echo("{\"id\":\"{$row["id"]}\",
			\"title\":\"{$row["title"]}\",
			\"complete\":\"{$row["complete"]}\"}"
			);

	}

}




//step 5 - close connection ]
mysql_close($cnn);
 

?>