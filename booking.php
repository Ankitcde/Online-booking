<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'search') {
    $conn = new mysqli('localhost', 'root', '', 'ticket_booking');
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
    $type = $_GET['type'];
    $from = $_GET['from'];
    $to = $_GET['to'];
    $date = $_GET['date'];
    $stmt = $conn->prepare("SELECT * FROM tickets WHERE type = ? AND from_location = ? AND to_location = ? AND date = ?");
    $stmt->bind_param("ssss", $type, $from, $to, $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $tickets = [];
    while ($row = $result->fetch_assoc()) {
        $tickets[] = $row;
    }
    echo json_encode($tickets);
    $conn->close();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'book') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Not logged in']);
        exit;
    }
    $ticket_id = $_POST['ticket_id'];
    $user_id = $_SESSION['user_id'];
    $conn = new mysqli('localhost', 'root', '', 'ticket_booking');
    $stmt = $conn->prepare("SELECT available_seats FROM tickets WHERE id = ?");
    $stmt->bind_param("i", $ticket_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($row['available_seats'] > 0) {
            $stmt2 = $conn->prepare("INSERT INTO bookings (user_id, ticket_id) VALUES (?, ?)");
            $stmt2->bind_param("ii", $user_id, $ticket_id);
            if ($stmt2->execute()) {
                $conn->query("UPDATE tickets SET available_seats = available_seats - 1 WHERE id = $ticket_id");
                echo json_encode(['success' => true, 'message' => 'Booking confirmed']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Booking failed']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'No seats available']);
        }
    }
    $conn->close();
    exit;
}
?>
