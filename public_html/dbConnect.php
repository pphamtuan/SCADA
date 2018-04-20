<?php

// Importing DBConfig.php file.
include 'dbConfig.php';

// Creating connection.
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);

// Getting the received JSON into $json variable.
$json = file_get_contents('php://input');

// decoding the received JSON and store into $obj variable.
$obj = json_decode($json,true);

// Populate User email from JSON $obj array and store into $email.
$email = $obj['email'];

// Populate Password from JSON $obj array and store into $password.
$password = $obj['password'];

//Applying User Login query with email and password match.
$Sql_Query = "select * from user where email = '$email' and password = '$password' ";

// Executing SQL Query.
$check = mysqli_fetch_array(mysqli_query($con,$Sql_Query));


if(isset($check)){

    //$type = $check['type'];
    $SuccessLoginMsg = 'Data Matched';
    $data = array('message'=>'Data Matched','type' => $check['type']);
    $dataJson = json_encode($data);

    //$obj->message = 'Data Matched';
    //$obj->type = $type;
    // Converting the message into JSON format.
    $SuccessLoginJson = json_encode($SuccessLoginMsg);
    //$typeJson = json_encode($type);
    //$myJson = json_encode($obj);

// Echo the message.
    //echo $SuccessLoginJson ;
    echo $dataJson;
    //echo $typeJson;
    //echo $myJson;

}

else{

    // If the record inserted successfully then show the message.
    $InvalidMSG = 'Tài khoản hoặc mất khẩu sai. Vui lòng nhập lại' ;

// Converting the message into JSON format.
    $InvalidMSGJSon = json_encode($InvalidMSG);

// Echo the message.
    echo $InvalidMSGJSon ;

}

mysqli_close($con);
?>