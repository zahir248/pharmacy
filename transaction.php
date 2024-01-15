<?php

// Include your database connection file
include 'db_connect.php';

// Get the username from the GET request
$username = $_GET['username'];

// Query to retrieve transactions with status equal to "In-receive"
$query = "SELECT t.transaction_id, t.address, t.status, t.quantity,
                 t.medicine_id, t.user_id, m.name, m.image, m.price, m.quantity as medicine_quantity
          FROM transaction t
          INNER JOIN medicine m ON t.medicine_id = m.medicine_id
          INNER JOIN user u ON t.user_id = u.user_id
          WHERE u.username = '$username' AND t.status = 'In-receive'";

$result = mysqli_query($conn, $query);

if ($result) {
    $transactions = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $row['image'] = base64_encode($row['image']); // Convert image to base64
        $transactions[] = $row;
    }

    echo json_encode($transactions);
} else {
    // Handle database query error
    echo json_encode(array('error' => 'Failed to retrieve transactions'));
}

// Close the database connection
mysqli_close($conn);

?>
