<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket Booking</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Welcome to Ticket Booking</h1>
    <a href="logout.php">Logout</a>
    <form id="booking-form">
        <select id="transport-type">
            <option value="bus">Bus</option>
            <option value="train">Train</option>
            <option value="airplane">Airplane</option>
        </select>
        <input type="text" id="from" placeholder="From" required>
        <input type="text" id="to" placeholder="To" required>
        <input type="date" id="date" required>
        <button type="button" id="search-btn">Search Tickets</button>
    </form>
    <div id="results"></div>
    <script src="script.js"></script>
</body>
</html>
