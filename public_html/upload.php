<?php
$target_dir = 'upload_image';

if (!file_exists($target_dir)){
    mkdir($target_dir,0777,true);
}
// Getting the received JSON into $json variable.
$json = file_get_contents('php://input');

// decoding the received JSON and store into $obj variable.
$obj = json_decode($json,true);

$target_dir = $target_dir."/".rand().'_'.time().".jpeg";

if(move_uploaded_file($_FILES['image']['tmp_name'],$target_dir)){
    echo json_encode([
        "Message" => "The file has been uploaded.",
        "Status"=>"OK"
    ]);
}else{
    echo json_encode([
       "Message"=>"Sorry, there was an error uploading your file",
        "Status"=>"Error"
    ]);
}

?>