<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

session_start();
include_once "../connection/config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the data from the PUT request body
    $data = json_decode(file_get_contents("php://input"), true);


    // Check if the required fields are set
    if (isset($data['user_id']) && isset($data['user_username']) && isset($data['user_email']) && isset($data['user_password']) && isset($data['user_gender'])) {
        $id = $data['user_id'];
        $username = $data['user_username'];
        $email = $data['user_email'];
        $password = $data['user_password'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $gender = $data['user_gender'];

        // Prepare the SQL update statement
        $update_users_query = "UPDATE users SET user_username = '$username', user_email = '$email', user_password = '$hashedPassword', user_gender = '$gender' WHERE user_id = '$id'";

        // Execute the query
        if (mysqli_query($conn, $update_users_query)) {
            echo json_encode(["success" => true, "message" => "User updated successfully."]);
        } else {
            echo json_encode(["ERROR" => "Error executing update query."]);
        }
    } else {
        echo json_encode(["ERROR" => "All fields are required."]);
    }
} else {
    echo json_encode(["ERROR" => "Invalid request method."]);
}

mysqli_close($conn);
