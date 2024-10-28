<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

session_start();
include_once "../connection/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Decode data from JSON format into associative array
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if the required data is present
    if (isset($data["user_username"]) && isset($data["user_password"])) {
        $username = $data['user_username'];
        $password = $data['user_password'];

        // Check if the username and the password already exist
        $users_query = "SELECT * FROM users WHERE user_username = '$username'";
        $users_table = mysqli_query($conn, $users_query);
        $users_rows = mysqli_num_rows($users_table);
        $users_data = mysqli_fetch_assoc($users_table);

        // check the Username
        if ($users_rows === 0) {
            echo json_encode(["ERROR" => "Username: ('$username') not found. Please check the Username."]);
        }

        // check the password
        if (password_verify($password, stripslashes($users_data['user_password']))) {
            $_SESSION['username'] = $username;
            echo json_encode(['success' => "loged In"]);
        } else {
            echo json_encode(['ERROR' => 'Invalid username or password']);
        }
    } else {
        echo json_encode(['ERROR' => 'Username and password are required']);
    }
} else {
    echo json_encode(["ERROR" => "Invalid request method"]);
}

mysqli_close($conn);
