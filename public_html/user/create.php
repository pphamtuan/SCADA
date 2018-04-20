<?php
// Importing DBConfig.php file.
include 'dbConfig.php';

// Creating connection.
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
//user avatar

$target_dir = 'avatar';

if (!file_exists($target_dir)){
    mkdir($target_dir,0777,true);
}

$target_dir = $target_dir."/".$userID.time().".jpeg";

if(move_uploaded_file($_FILES['image']['tmp_name'],$target_dir)){
    echo json_encode([
        "message" => "Đã upload thành công",
        "status"=>"OK"
    ]);
}else{
    echo json_encode([
        "message"=>"upload thất bại. Vui lòng thử lại",
        "status"=>"Error"
    ]);
}
//data
$dataJson = $_POST['info'];
$dataObj = json_decode($dataJson, true);
//Get User Info
$userID = $dataObj['userID'];
$userName = $dataObj['userName'];
$userPassword = $dataObj['userPassword'];
$userBirthYear = $dataObj['userBirthYear'];
$userHomeTown = $dataObj['userHomeTown'];
$userAddress = $dataObj['userAddress'];
$userPhoneNumber = $dataObj['userPhoneNumber'];
$userType = $dataObj['userType'];
$userGroup = $dataObj['userGroup'];
$userImage = $target_dir;


//Checking groupID is already exist or not using SQL query.
$CheckSQL = "SELECT * FROM user WHERE ma_nv ='$userID'";
// Executing SQL Query.
$check = mysqli_fetch_array(mysqli_query($con,$CheckSQL));

if(isset($check)){
// Echo the message.
    echo json_encode(array(
        'message' => 'Mã người dùng đã được đăng ký. Vui lòng chọn tên người dùng khác',
        'status' => 'FAIL',
    )) ;

} else {

//Applying User Login query with email and password match.
    $sql_update = "INSERT INTO user (userID, userPassWord, userName, userBirthYear, userHomeTown, 
                    userAddress, userType, userGroup, userImage, userPhoneNumber ) VALUES 
                  ('$userID', '$userPassword','$userName', '$userBirthYear','$userHomeTown', '$userAddress',
                   '$userType', '$userGroup', '$userImage',  '$userPhoneNumber') ";

    // Executing SQL Query.
    if (mysqli_query($con, $sql_update)) {
    echo json_encode(array(
        "message" => "Đã cập nhật thông tin thành công",
        "status"=>"OK",
        "id" => $userID,
    ));
    } else {
    echo json_encode(array(
        "message" => "Cập nhật thông tin thất bại",
        "status"=>"ERROR",
        "id" => $userID,
        //"error" => mysqli_error($con),
    ));
    }
}

mysqli_close($con);

?>