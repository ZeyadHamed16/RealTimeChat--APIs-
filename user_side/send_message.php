<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

session_start();
include_once "../connection/config.php";

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data["message_sender"]) && isset($data["message_receiver"]) && isset($data["message"])) {
        $sender = $data["message_sender"];
        $receiver = $data["message_receiver"];
        $message = $data["message"];

        // // Prepare the SQL statement
        $send_message_query = "INSERT INTO messages (message_sender, message_receiver, message) VALUES ('$sender', '$receiver', '$message')";

        if (mysqli_query($conn, $send_message_query)) {
            echo json_encode(['SUCCESS' => true, 'message' => 'Message sent']);
        } else {
            echo json_encode(['ERROR' => 'Failed to send message']);
        }
    } else {
        echo json_encode(['error' => 'Missing required fields']);
    }
} else {
    echo json_encode(["ERROR" => "Invalid request method"]);
}

mysqli_close($conn);
