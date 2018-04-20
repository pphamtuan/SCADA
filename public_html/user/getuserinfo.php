<?php
// Importing DBConfig.php file.
include 'dbConfig.php';

// Creating connection.
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);

// Getting the received JSON into $json variable.
$json = file_get_contents('php://input');

// decoding the received JSON and store into $obj variable.
$obj = json_decode($json,true);


$staffID = $obj['staffID'];

//Applying User Login query with email and password match.
//$Sql_Query = "select * from user where ma_nv = '$MaNV' and mat_khau = '$password";
$Sql_Query = "select * from user where userID = '$staffID'";

// Executing SQL Query.
$check = mysqli_fetch_array(mysqli_query($con,$Sql_Query));
//echo json_encode(array('type'=>$check['type']));

if(isset($check)){
   $user = array( 
       'userID' => $check['userID'],
       'userName' => $check['userName'],
       'userImage' =>$check['userImage'],
       'userType' =>$check['userType'],
       'userGroup' =>$check['userGroup'],
       'userBirthYear' =>$check['userBirthYear'],
       'userHomeTown' =>$check['userHomeTown'],
       'userAddress' =>$check['userAddress'],
       'userPhoneNumber' => $check['userPhoneNumber'],
       );
    echo json_encode($user);
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