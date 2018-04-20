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
$userID = $obj['userID'];

// Populate Password from JSON $obj array and store into $password.
$userPassword = $obj['userPassword'];

//Applying User Login query with email and password match.
//$Sql_Query = "select * from user where ma_nv = '$MaNV' and mat_khau = '$password";
$Sql_Query = "select * from user where userID = '$userID' and userPassword = '$userPassword'";


// Executing SQL Query.
$check = mysqli_fetch_array(mysqli_query($con,$Sql_Query));

if(isset($check)){

    $data = array(
        'message'=>'Data Matched',
        'userID'=>$check['userID'],
        'userType' => $check['userType'],
        'userName' => $check['userName'],
        'userGroup'=>$check['userGroup'],
        'userImage' =>$check['userImage'],
    );
    $dataJson = json_encode($data);

    echo $dataJson;
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