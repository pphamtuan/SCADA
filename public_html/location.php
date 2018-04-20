<?php
// Importing DBConfig.php file.
include 'dbConfig.php';

// Creating connection.
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);

// Getting the received JSON into $json variable.
//$json = file_get_contents('php://input');
$json = $_POST['info'];
// decoding the received JSON and store into $obj variable.
$obj = json_decode($json,true);

// Populate User email from JSON $obj array and store into $email.

$name = $obj['name'];
$x = $obj['x'];
$y = $obj['y'];
$diachi = $obj['dia_chi'];
$nguoi_nhap = $obj['nguoi_nhap'];

//$post = $_POST['info'];
//$postJSON = json_decode($post,true);


//echo json_encode(array('respone'=>$name));

//Applying User Login query with email and password match.
$Sql_User = "select * from cong_location where name = '$name'";

// Executing SQL Query.
$check = mysqli_fetch_array(mysqli_query($con,$Sql_User));

$link = 'link';

if(isset($check)){

    $data = array('message'=>'Tên đã  sử dụng! Vui lòng chọn tên khác!');
    $dataJson = json_encode($data);
    echo $dataJson;
    mysqli_close($con);
    die();
}
else{

    $Sql_Query = "insert into cong_location (name,x,y,dia_chi,nguoi_nhap,image) values ('$name','$x','$y','$diachi','$nguoi_nhap )";
    if(mysqli_query($con,$Sql_Query)){
        $data = array('message'=>'Cập nhật thành công', 'status'=>'OK');
        $dataJson = json_encode($data);
        echo $dataJson;
         
    }
    else{
        echo 'Try Again';
        mysqli_close($con);
        die();
 }

}


//upload image
$target_dir = 'upload_image';

if (!file_exists($target_dir)){
    mkdir($target_dir,0777,true);
}

$target_dir = $target_dir."/".rand().'_'.time().".jpeg";

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
mysqli_close($con);
?>