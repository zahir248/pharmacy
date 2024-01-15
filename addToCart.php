<?php
// Include your database connection file
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve parameters from the POST request
    $medicineId = $_POST['medicine_id'];
    $quantity = $_POST['quantity'];
    $username = $_POST['username'];

    // Fetch user_id based on the username
    $userQuery = "SELECT user_id FROM user WHERE username = '$username'";
    $userResult = mysqli_query($conn, $userQuery);

    if ($userResult) {
        $userData = mysqli_fetch_assoc($userResult);
        $userId = $userData['user_id'];

        // Perform the database insertion into the transaction table
        $sql = "INSERT INTO transaction (user_id, medicine_id, address, status, quantity) 
                VALUES ('$userId', '$medicineId', null, 'In-cart', '$quantity')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Transaction added successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add transaction']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to fetch user data']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
