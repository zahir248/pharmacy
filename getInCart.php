<?php

include 'db_connect.php';

// Retrieve username from the request
$username = $_GET['username'];

// Prepare and execute the SQL query with a join
$sql = "SELECT m.image, m.name, m.price, t.quantity, t.transaction_id
        FROM `transaction` t
        INNER JOIN `medicine` m ON t.medicine_id = m.medicine_id
        WHERE t.`user_id` IN (SELECT `user_id` FROM `user` WHERE `username` = '$username') 
        AND t.`status` = 'In-cart'";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    $medicines = array();

    // Fetch data and push to the array
    while ($row = $result->fetch_assoc()) {
        $row['image'] = base64_encode($row['image']); // Convert image to base64
        $medicines[] = $row;
    }

    // Output JSON representation of the medicines
    header('Content-Type: application/json');
    echo json_encode($medicines);
} else {
    // No medicines found
    echo "No medicines found";
}

$conn->close();

?>
