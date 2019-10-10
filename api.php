<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/html; charset=utf-8');
include_once 'connection.php';
include_once 'functions.php';
$utility = new Utility();
$functions = new processFunctions($utility);
set_time_limit(0);

switch($_POST['type']){

case 'login':
      $response = $functions->login($_POST['logindata']);
      echo json_encode($response);
      break;

case 'get_profile':
      $response  = $functions->get_profile($_POST['get_profiledata']);
      echo json_encode($response);
      break;

case 'assign_vendor':
      $response  = $functions->assign_vendor($_POST['assign_vendordata']);
      echo json_encode($response);
      break;

case 'add_address':
      $response=$functions->add_address($_POST['add_addressdata']);
      echo json_encode($response);
      break; 

case 'get_address':
      $response  = $functions->get_address($_POST['get_addressdata']);
      echo json_encode($response);
      break;

case 'status_pending':
      $response = $functions->status_pending($_POST['status_pendingdata']);
      echo json_encode($response);
      break;
      
case 'get_history':
      $response = $functions->get_history($_POST['get_historydata']);
      echo json_encode($response);
      break;

case 'get_request_information':
      $response  = $functions->get_request_information($_POST['get_request_informationdata']);
      echo json_encode($response);
      break;

case 'make_request':
      $response=$functions->make_request($_POST['make_requestdata']);
      echo json_encode($response);
      break;

default :
      echo "error";

}
   /*if($_POST['type'] == 'login'){
      $response  =$functions->login($_POST['logindata']);
      echo json_encode($response);
   }  
   elseif($_POST['type'] =='signup'){
      unset($_POST['type']);
      $response  = $functions->signup($_POST['data']);
      echo json_encode($response);*/
   
   
