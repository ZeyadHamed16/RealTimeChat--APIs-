<?php
$host = "localhost";
$username = "root";
$password = "";
$db_name = "real_time_chat";

try {
    $conn = mysqli_connect($host, $username, $password, $db_name);
} catch (Exception $e) {
    echo $e->getMessage();
}
