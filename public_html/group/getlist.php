<?php
// Importing DBConfig.php file.
include 'dbConfig.php';

// Creating connection.
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);

//Applying User Login query with email and password match.
$Sql_Query = "select * from groupList";
// Executing SQL Query.
$check = mysqli_fetch_array(mysqli_query($con,$Sql_Query));
$result = mysqli_query($con,$Sql_Query);

$data = array();
if(isset($check)){

    while ($check = mysqli_fetch_array($result)) {
        $group = array(
            'value' => $check['groupID'],
            //'leaderID' => $row['ma_nv'],
            //'area' => $row['khu_vuc'],
           // 'leaderName' => $row['to_truong'],
        );
        array_push($data, $group);
    }
    $dataJson = json_encode($data);
    echo $dataJson;
}else{
    echo json_encode(array('message'=>'Server error'));
}

//echo json_encode($data).PHP_EOL;


mysqli_close($con);
?>