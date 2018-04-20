<?php
/*
$targetDir = "upload/image";
if (!file_exists($targetDir)){

    mkdir($targetDir,0777, true);
    $data = array('message'=>'create new');
    echo json_encode(data);
}
// Getting the received JSON into $json variable.
$json = file_get_contents('php://input');
// decoding the received JSON and store into $obj variable.
$obj = json_decode($json,true);
*/
// Getting the received JSON into $json variable.
$json = file_get_contents('php://input');

// decoding the received JSON and store into $obj variable.
$obj = json_decode($json,true);

if ($obj['info']==='Hello'){
    $data = array('message'=>'true');
    $dataJson = json_encode($data);
    echo $dataJson;
}

?>