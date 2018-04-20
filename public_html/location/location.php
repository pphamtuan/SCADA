<?php
// Importing DBConfig.php file.
include 'dbConfig.php';

// Creating connection.
$con = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);

// Getting the received JSON into $json variable.
//$json = file_get_contents('php://input');
$json = $_POST['info'];
// decoding the received JSON and store into $obj variable.
$obj = json_decode($json, true);

// Populate User email from JSON $obj array and store into $email.

$stationName = $obj['stationName'];
$x = (float)$obj['latitude'];
$y = (float)$obj['longitude'];
$diachi = $obj['address'];
$nguoi_nhap = $obj['userID'];

//Applying User Login query with email and password match.
$Sql_User = "select * from tram where stationName = '$stationName'";

// Executing SQL Query.
$check = mysqli_fetch_array(mysqli_query($con, $Sql_User));


if (isset($check)) {

    $data = array('message' => 'Tên đã  sử dụng! Vui lòng chọn tên khác!');
    $dataJson = json_encode($data);
    echo $dataJson;
    mysqli_close($con);
    die();
} else {

    $Sql_Query = "INSERT INTO tram (stationName, x,y,dia_chi,nguoi_nhap) 
                  VALUES ('$stationName','$x','$y','$diachi','$nguoi_nhap') ";



    if (mysqli_query($con, $Sql_Query)) {

        $target_dir = 'upload_image';
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_dir = $target_dir . "/" . $stationName . time() . ".jpeg";
        $path = dirname($_SERVER['PHP_SELF']) . '/' . $target_dir;


        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_dir)) {
            $sql_update = "UPDATE tram SET image = '$path' WHERE stationName = '$stationName' ";
            if (mysqli_query($con, $sql_update)) {
                echo json_encode(array(
                    "message" => "Đã cập nhật thông tin trạm thành công",
                    "status" => "OK",
                    "id" => $stationName,
                ));
            } else {
                echo json_encode(array(
                    "message" => "Cập nhật thông tin trạm thất bại",
                    "status" => "ERROR",
                    'error' => 101,
                    "id" => $stationName,
                    //"error" => mysqli_error($con),
                ));
            }
        } else {
            // Move failed. Possible duplicate?
            echo json_encode(array(
                "message" => "Cập nhật thông trạm tin thất bại",
                "status" => "ERROR",
                'error' => 102,
                "id" => $stationName,
                //"error" => mysqli_error($con),
            ));
        }
    } else {
        echo json_encode(array(
            "message" => "Cập nhật thông trạm tin thất bại",
            "status" => "ERROR",
            'error' => 103,
            "id" => $stationName,
            //"error" => mysqli_error($con),
        ));
        mysqli_close($con);
        die();
    }

}

mysqli_close($con);

?>