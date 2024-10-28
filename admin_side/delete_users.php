<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

session_start();
include_once "../connection/config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data["user_id"])) {
        $user_id = $data["user_id"];
        $delete_user_query = "DELETE FROM users WHERE user_id = '$user_id'";
        if (mysqli_query($conn, $delete_user_query)) {
            echo json_encode(['message' => 'User deleted successfully']);
        } else {
            echo json_encode(['message' => 'Error: ' . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['error' => 'Missing required fields']);
    }
} else {
    echo json_encode(["ERROR" => "Invalid request method"]);
}

mysqli_close($conn);
