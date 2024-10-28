<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

session_start();
include_once "../connection/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data["message_sender"]) && isset($data["message_receiver"])) {
        $sender = $data["message_sender"];
        $receiver = $data["message_receiver"];

        $query = "SELECT * FROM messages WHERE (message_sender = '$sender' AND message_receiver = '$receiver')  OR  (message_sender = '$sender' AND message_receiver = '$receiver')  ORDER BY created_at ASC";
        $query_data = mysqli_query($conn, $query);

        $messages = [];
        while ($row = mysqli_fetch_assoc($query_data)) {
            $messages[] = $row;
        }

        echo json_encode($messages);
    } else {
        echo json_encode(['ERROR' => 'Sender or receiver not set']);
        exit;
    }
} else {
    echo json_encode(['ERROR' => 'Invalid request method']);
}

mysqli_close($conn);
