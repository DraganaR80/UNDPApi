<?php

require("db.php");
require("../model/Response.php");
require("../model/Task.php");

$conn = DB::connectDB();

if (isset($_GET['taskid'])){
$taskid = $_GET['taskid'];

if(!is_numeric($taskid) || $taskid==''){
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage('Task ID cannot be blank or must be numeric');
        $response->send();
        exit;

      }


  if($_SERVER['REQUEST_METHOD']=== "GET"){
        $query = "SELECT * FROM tasks WHERE id=$taskid";
        $result = $conn->query($query);
        $rowCount = $result->num_rows;
          if($rowCount==0){
            $response = new Response();
            $response->setHttpStatusCode(404);
            $response->setSuccess(false);
            $response->addMessage('Task not found');
            $response->send();
            exit;
          }
          while($row=$result->fetch_assoc()){

            $task = new Task($row['id'], $row['title'], $row['description'], $row['deadline'], $row['completed']);
            $taskArray[] = $task->returnTaskArray();
          }
        $returnData = array();
        $returnData['row_returned'] = $rowCount;
        $returndata['tasks'] = $taskArray;
        $response = new Response();
        $response->setHttpStatusCode(200);
        $response->setSuccess(true);
        $response->setData($returnData);
        $response->send();
        exit;
   } elseif($_SERVER['REQUEST_METHOD']==='DELETE') {

    $query="DELETE FROME tasks WHERE id=$taskid";
        $result = $conn->query($query);
    }



else{
        $response = new Response();
        $response->setHttpStatusCode(405);
        $response->setSuccess(false);
        $response->addMessage('Request method not allowed');
        $response->send();
        exit;
    }   



}









?>