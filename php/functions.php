<?php 

	function confirm($para, $msg){
		if(!$para ){
			die($msg.mysql_error());
		}
	}


	function request_type(){

		if($_SERVER['REQUEST_METHOD'] === "GET"){
			$output = "GET";
		}
		if($_SERVER['REQUEST_METHOD'] === "PUT"){
			$output = "PUT";
		}
		if($_SERVER['REQUEST_METHOD'] === "POST"){
			$output = "POST";
		}
		if($_SERVER['REQUEST_METHOD'] === "DELETE"){
			$output = "DELETE";
		}

		return $output;	

	}

	function confirm_affected_row(){
		if(mysql_affected_rows() == 1){
			echo "success";
		}else{
			echo "failed".mysql_error();
		}
	}

	function get_record_json_by_id($id){

		$query = "SELECT * FROM task WHERE id = {$id}";
		$result = mysql_query($query);
		confirm($result, "problem in query");
		$row = mysql_fetch_array($result);
		$record_array = array("id"=>$row["id"], "title"=>$row["title"], "complete"=>$row["complete"]);
		
		$record_json = json_encode($record_array);
		return $record_json;
	}

	function update_record($json_str){

		$req_object = json_decode($json_str);
		$query = "UPDATE task 
				  SET title = \"{$req_object->title}\",
				   	  complete = {$req_object->complete} 
				  WHERE id = {$req_object->id}";
		$result = mysql_query($query);
		confirm_affected_row();
	}

	function delete_record_by_id($id){
		$query = "DELETE FROM task WHERE id = {$id}";
		mysql_query($query);
		confirm_affected_row();

	}

	function add_record($json_str){
		$req_object = json_decode($json_str);
		$query = "INSERT INTO task (title, complete) VALUES ( \"{$req_object->title}\", {$req_object->complete})";
		mysql_query($query);
		confirm_affected_row();
	}

	function get_all_records(){
		$query = "SELECT * FROM task";
		$result = mysql_query($query);
		$output = array();
		while($row = mysql_fetch_array($result)){
			$record_array = array("id"=>$row["id"], "title"=>$row["title"], "complete"=>$row["complete"]);
			$record_json = $record_array;
			$output[] =$record_json;
		}
		return json_encode($output);

	}
 ?>