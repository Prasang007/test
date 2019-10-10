<?php 
include_once 'config.php';
date_default_timezone_set('Asia/Calcutta');
class Utility
{
  private $con;
  function __construct()
  {
    

    $this->con = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    if ($this->con->connect_error) {
      echo $this->con->connect_error;
      exit();
    } else {
      return $this->con; 
    } 
  }

  function __destruct()
  {
    $this->con->close();
  }

  public function login($data){
    $stmt = $this->con->prepare("SELECT UserID from users where UserID=?");
    $stmt->bind_param('s',$data['UserID']);
    $stmt->execute();
    if($stmt->fetch() ){return  true;}
    else{return false;}
    $stmt->close();
  }

  public function get_profile($data){
    $response=array();
    $stmt = $this->con->prepare("SELECT UserID,name,Company,Password,Mobile_Number FROM users WHERE UserID=?");
    $stmt->bind_param('s',$data['UserID']);
    $stmt->execute();
    $stmt->bind_result($UserID,$name,$Company,$Password,$Mobile_Number);
    while ($stmt->fetch()) {
      $response[]=array('id'=>$UserID,'name'=>$name,'company'=>$Company,'mobile'=>$Mobile_Number,'password'=>$Password);
     }
    $stmt->close();
    return  $response;
  }

  public function assign_vendor($data){
    $response=array();
    $stmt = $this->con->prepare("SELECT Number, Name, Photo,vendorID FROM vendors WHERE vendorID=?");
    $stmt->bind_param('s',$data['vendorID']);
    $stmt->execute();
    $stmt->bind_result($Number,$Name,$Photo,$ID);
    while ($stmt->fetch()) {
      $response[]=array('name'=>$Name,'mobileNo'=>$Number,'photo'=>$Photo,'vendorID'=>$ID);}
    $stmt->close();
    return  $response;
  }
                                                                                              
  public function status_pending($data){  
    $response=array();
    $stmt = $this->con->prepare("SELECT requests.amount,requests.date,requests.time,vendors.Photo,vendors.Name,requests.address,vendors.Number from requests INNER JOIN vendors ON requests.vendorID = vendors.vendorID where requests.userID=? && requests.status='pending'");
    $stmt->bind_param('s',$data['UserID']);
    $stmt->execute();
    $stmt->bind_result( $Amount,$date,$time,$photo,$name,$Address,$Call);
    while ($stmt->fetch()) {
      $response[]=array('amount'=>$Amount,'date'=>$date,'time'=>$time, 'photo'=>$photo,'name'=> $name,'address'=>$Address,'number'=>$Call);}
    return  $response;
    $stmt->close();
  }

  public function make_request($data){
    // print_r($data['amount']);
    //mysql_query('SET foreign_key_checks = 1');
    $response=false;
    $stmt = $this->con->prepare("INSERT INTO requests (vendorID,UserID, transactionID, amount, date, time, status, Address) VALUES (?, ?, ?, ?, ?, ?, ?,?)");
    $stmt->bind_param('ssssssss',$data['vendorID'],$data['UserID'], $data['transactionID'], $data['amount'], $data['date'], $data['time'], $data['status'], $data['address']);
    $stmt->execute();
    // print_r($stmt);
    if($stmt->affected_rows){
      $response = true;
    }
    $stmt->close();
    return $response;
   }

  public function add_address($data){
    
      $stmt = $this->con->prepare("INSERT INTO address (prefix, personName, companyName,officeNo,streetSociety,landmarkCity,nickname,userID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param('ssssssss',$data['prefix'], $data['personName'], $data['companyName'], $data['officeNo'], $data['streetSociety'], 
             $data['landmarkCity'], $data['nickname'],$data['userID']);
      $stmt->execute();
      if($stmt->affected_rows){
        $response = true;
      }
      $stmt->close();
      return $response;}

  public function get_address($data){
        $response=array();
        $stmt = $this->con->prepare("SELECT prefix, personName, companyName, officeNo, streetSociety, landmarkCity,nickName FROM address WHERE userID=? ");
        $stmt->bind_param('s',$data['UserID']);
        $stmt->execute();
        $stmt->bind_result( $prefix, $personName, $companyName, $officeNo, $streetSociety, $landmarkCity, $nickName);
        while ($stmt->fetch()) {
          $response[]=array('prefix'=>$prefix,'personName'=>$personName,'companyName'=> $companyName,'officeNo'=>$officeNo,'streetSociety'=>$streetSociety, 'landmarkCity'=>$landmarkCity,'nickname'=>$nickName);}
        return  $response;  
        $stmt->close();
      }
   
  public function get_history($data){
    $response=array();
    $stmt = $this->con->prepare("SELECT r.amount, r.transactionID,	r.date,	r.time,	v.Photo	,r.status, v.name FROM requests AS r LEFT OUTER JOIN vendors AS v ON r.vendorID=v.vendorID WHERE  r.UserId=? AND (r.status='Completed' OR r.status='Cancelled')");
    $stmt->bind_param('s',$data['UserID']);
    $stmt->execute();
    $stmt->bind_result($amount, $transactionID, $date, $time, $Photo, $status,$name);
    while ($stmt->fetch()) {
      $response[]=array('amount'=>$amount,'transactionID'=>$transactionID, 'date'=>$date, 'time'=>$time , 'photo'=>$Photo ,'status'=>$status,'name'=>$name);
    } 
      $stmt->close();
    return $response;
  }

  public function get_request_information($data){
    $response=array();
    $stmt = $this->con->prepare("SELECT v.Number, r.amount,r.address,	r.date,	r.time,	v.Photo	,r.status, v.name FROM requests AS r LEFT OUTER JOIN vendors AS v ON r.vendorID=v.vendorID WHERE  r.transactionID=? ");
    $stmt->bind_param('s',$data['transactionID']);
    $stmt->execute();
    $stmt->bind_result($number,$amount, $address, $date, $time, $Photo, $status,$name);
    while ($stmt->fetch()) {
      $response[]=array('number'=>$number,'amount'=>$amount,'address'=>$address, 'date'=>$date, 'time'=>$time , 'photo'=>$Photo ,'status'=>$status,'name'=>$name);
    } 
      $stmt->close();
    return $response;
  }
}
