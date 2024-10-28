<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

session_start();
include_once "../connection/config.php";

// Bring all users except the current user
if ($_SERVER['REQUEST_METHOD'] == "GET") {

    $all_users_query = "SELECT * FROM users";
    $all_users_data = mysqli_query($conn, $all_users_query);

    $users = array();
    while ($row = mysqli_fetch_assoc($all_users_data)) {
        $users[] = $row;
    }

    echo json_encode($users);
} else {
    echo json_encode(["ERROR" => "Invalid request method"]);
}

mysqli_close($conn);
