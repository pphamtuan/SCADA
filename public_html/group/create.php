<?php
// Importing DBConfig.php file.
include 'dbConfig.php';

// Creating connection.
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
//data
$dataJson = $_POST['info'];
$dataObj = json_decode($dataJson, true);


$groupID = $dataObj['groupID'];
$groupLeaderName = $dataObj['groupLeaderName'];
$groupArea = $dataObj['groupArea'];
$groupName = $dataObj['groupName'];
$groupCreationUserID = $dataObj['groupCreationUserID'];
$groupLeaderID = $dataObj['groupLeader'];

/*
echo json_encode(array(
   'message' => $groupID,
));
*/
/*
echo json_encode(array(
    'groupID' => $groupID,
    'groupLeaderName' => $groupLeaderName,
    'groupArea' => $groupArea,
    'groupName' => $groupName,
    'groupCreationUserID' => $groupCreationUserID,
    'groupLeaderID' => $groupLeaderID,
));
*/
//Checking groupID is already exist or not using SQL query.
$CheckSQL = "SELECT * FROM groupList WHERE groupID ='$groupID'";
// Executing SQL Query.
$check = mysqli_fetch_array(mysqli_query($con,$CheckSQL));

if(isset($check)){

    $GroupIDExistMSG = 'Tên nhóm đã được đăng ký. Vui lòng chọn tên nhóm kh';

    // Converting the message into JSON format.

// Echo the message.
    echo json_encode(array(
        'message' => 'Tên nhóm đã được đăng ký. Vui lòng chọn tên nhóm khác',
    )) ;

} else {

//Applying User Login query with email and password match.
    $sql_update = "INSERT INTO groupList (groupID, groupLeaderName, groupArea, groupName, 
                      groupCreationUserID, groupLeaderID) VALUES 
                  ('$groupID', '$groupLeaderName', '$groupArea',
                  '$groupName', '$groupCreationUserID','$groupLeaderID') ";

    // Executing SQL Query.
    if (mysqli_query($con, $sql_update)) {
    echo json_encode(array(
        "message" => "Đã cập nhật thông tin thành công",
        "status"=>"OK",
        "id" => $groupID,
    ));
    } else {
    echo json_encode(array(
        "message" => "Cập nhật thông tin thất bại",
        "status"=>"EROR",
        "id" => $groupID,
        //"error" => mysqli_error($con),
    ));
    }
}

mysqli_close($con);

?>