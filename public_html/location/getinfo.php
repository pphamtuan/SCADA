<?php
// Importing DBConfig.php file.
include 'dbConfig.php';

// Creating connection.
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);


// Getting the received JSON into $json variable.
$dataJson = $_POST['info'];
$dataObj = json_decode($dataJson, true);

$groupID = $dataObj['groupID'];


//Applying User Login query with email and password match.
$sql = "select * from tram where groupID = '$groupID'";
// Executing SQL Query.
$check = mysqli_fetch_array(mysqli_query($con, $sql));


if (isset($check)) {
    $result = mysqli_query($con,$sql);
    $data = array();


    while ($check = mysqli_fetch_array($result)) {
        $stationInfo = array(
            'stationName' => $check['stationName'],
            'x' => $check['x'],
            'y' => $check['y'],
            'image' => $check['image'],
            'dia_chi' => $check['dia_chi'],
            'nguoi_nhap' => $check['nguoi_nhap'],
            'lastTime' => $check['lastTime'],
            'groupID' => $check['groupID'],
        );
        array_push($data,$stationInfo);
    }
    //$message = 'Lấy thông tin trạm thất bại!';
    //$status = 'OK';
    echo json_encode($data);

}else{
    $message = 'Nhóm không tồn tại';
    $status = 'FAIL';
}

mysqli_close($con);



?>