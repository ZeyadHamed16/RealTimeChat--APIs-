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
    if (isset($data["user_username"]) && isset($data["user_email"]) && isset($data["user_password"]) && isset($data["user_gender"])) {
        $username = $data['user_username'];
        $email = $data['user_email'];
        $password = $data['user_password'];
        $gender = $data['user_gender'];

        // Check if the username
        $users_query = "SELECT * FROM users WHERE user_username = '$username' OR user_email = '$email'";
        $users_table = mysqli_query($conn, $users_query);
        $users_rows = mysqli_num_rows($users_table);
        $users_data = mysqli_fetch_assoc($users_table);

        // check the Username
        if ($users_rows > 0) {
            echo json_encode(["ERROR" => "Username OR Password already exists."]);
            exit();
        } else {
            // insert username and the password into database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insert_user_query = "INSERT INTO users (user_username, user_email, user_password, user_gender) values ('$username', '$email', '$hashedPassword', '$gender')";

            if (mysqli_query($conn, $insert_user_query)) {
                $_SESSION['username'] = $username;
                echo json_encode(['success' => 'Added new user']);
            } else {
                echo json_encode(['ERROR' => 'Registration failed']);
            }
        }
    } else {
        echo json_encode(['ERROR' => 'All data are required']);
    }
} else {
    echo json_encode(["ERROR" => "Invalid request method"]);
}

mysqli_close($conn);
