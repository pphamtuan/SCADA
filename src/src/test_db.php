<?php
include 'DBConfig.php';

function connectDatabase($HostName,$HostUser,$HostPass,$DatabaseName)
{
// Create connection
    $db = new mysqli($HostName,$HostUser,$HostPass,$DatabaseName);

// Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
        exit;
    }
    echo "Connected successfully" . PHP_EOL;
    return $db;
}

$db = connectDatabase($HostName,$HostUser,$HostPass,$DatabaseName);
$email = 'vansang@gmail.com';
$CheckSQL = "SELECT * FROM user WHERE email='$email'";

// Executing SQL Query.
$check = mysqli_fetch_array(mysqli_query($db,$CheckSQL));

if ((isset($check))){
    echo 'Correct'.PHP_EOL;
    echo $check['type'].PHP_EOL;
}

?>