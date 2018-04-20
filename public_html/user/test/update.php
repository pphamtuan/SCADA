<?php
// Importing DBConfig.php file.
include 'dbConfig.php';

// Creating connection.
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);


$actionJson = $_POST['action'];
$actionObj = json_decode($actionJson, true);
$action = $actionObj['type'];
$id = $actionObj['id'];

/*
$target_dir = 'avatar';

if (!file_exists($target_dir)){
    mkdir($target_dir,0777,true);
}

$target_dir = dirname($_SERVER['PHP_SELF']).'/'.'avatar';
*/



if ($action === 'update') {
    $userJson = $_POST['info'];
    $userObj = json_decode($userJson, true);

    $userID = $userObj['userID'];
    $userName = $userObj['userName'];
    $userBirthYear = (int)$userObj['userBirthYear'];
    $userHomeTown = $userObj['userHomeTown'];
    $userAddress = $userObj['userAddress'];
    $userPhoneNumber = $userObj['userPhoneNumber'];
    $userType = $userObj['userType'];
    $userGroup = $userObj['userGroup'];

//Update user information
    $sql_update = "UPDATE user 
              SET userID = '$userID', userName = '$userName', userBirthYear = '$userBirthYear',
                  userHomeTown = '$userHomeTown', userAddress = '$userAddress', 
                  userPhoneNumber = '$userPhoneNumber', userGroup = '$userGroup'                              
              WHERE userID = '$id'";


// Executing SQL Query.
    if (mysqli_query($con, $sql_update)) {

        $target_dir = 'avatar';
        if (!file_exists($target_dir)){
            mkdir($target_dir,0777,true);
        }
        $target_dir = $target_dir."/".$userID.time().".jpeg";
        $path = dirname($_SERVER['PHP_SELF']).$target_dir;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_dir)) {
            $sql_update = "UPDATE user SET userImage = '$path' WHERE userID = '$id'";
            mysqli_query($sql_update,$con);
        } else {
            // Move failed. Possible duplicate?
        }

        echo json_encode([
            "message" => "Đã cập nhật thông tin thành công",
            "status"=>"OK",
            "id" => $id,
            "userID" => $userID,
            'userPhoneNumber' => $userPhoneNumber,
            'userImage' => $path,
        ]);



    } else {
        echo json_encode([
            "message" => "Cập nhật thông tin thất bại",
            "status"=>"EROR",
            "userID" => $userID,
            "id" => $id,
            //"error" => mysqli_error($con),
        ]);
    }
}
elseif ($action === 'delete') {
    echo json_encode([
        "message" => "Thao tác xóa",
        "status"=>"EROR",
        "id" => $id,
        //"error" => mysqli_error($con),
    ]);
}else {
    echo json_encode([
        "message" => "Thao tác tạo mới",
        "status"=>"EROR",
        "id" => $id,
        //"error" => mysqli_error($con),
    ]);
}

mysqli_close($con);

?>