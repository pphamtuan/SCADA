<?php
// Importing DBConfig.php file.
include 'dbConfig.php';

// Creating connection.
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);


$actionJson = $_POST['action'];
$actionObj = json_decode($actionJson, true);
$action = $actionObj['type'];
$id = $actionObj['id'];

if ($action === 'delete') {
//Update user information
    $sql = "DELETE FROM user WHERE userID = '$id'";

    if (mysqli_query($con, $sql)) {
        echo json_encode([
            "message" => "Đã xóa người dùng thành công",
            "status"=>'OK',
            "id" => $id,
        ]);
    } else {
        echo json_encode([
            "message" => "Xóa người dùng thất bại. Vui lòng thử lại",
            "status"=>'FAIL',
            "id" => $id,
        ]);
    }
}

mysqli_close($con);

?>