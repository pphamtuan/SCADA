<?php
// Importing DBConfig.php file.
include 'dbConfig.php';

// Creating connection.
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);


// Getting the received JSON into $json variable.
$dataJson = $_POST['info'];
$dataObj = json_decode($dataJson, true);

$userID = $dataObj['userID'];

//Applying User Login query with email and password match.
//$Sql_Query = "select * from user where ma_nv = '$MaNV' and mat_khau = '$password";
$Sql_Query = "select * from user where ma_nv = '$userID'";

// Executing SQL Query.
$check = mysqli_fetch_array(mysqli_query($con,$Sql_Query));
//echo json_encode(array('type'=>$check['type']));

if(isset($check)){
   $user = array(
       'userName' => $check['ten_nv'],
       'status' => 'OK',
       );
    echo json_encode($user);
}

else{


// Echo the message.
    echo json_encode(array(
        'status' => 'FAIL',
        'message' => 'Mã nhân viên không tồn tại. Vui lòng thử lại hoặc tạo người dùng mới'
    )) ;

}

mysqli_close($con);


?>