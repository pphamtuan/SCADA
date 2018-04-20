<?php
include 'dbConfig.php';

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

?>