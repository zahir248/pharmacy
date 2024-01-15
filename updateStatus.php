<?php

include 'db_connect.php'; // Assuming you have a file for database connection

// Handling the POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve transaction_id, address, and status from the request
    $transactionId = $_POST["transaction_id"];
    $address = $_POST["address"];

    // Update the address and status in the database for the given transaction_id
    $sql = "UPDATE transaction SET address = '$address', status = 'In-receive' WHERE transaction_id = '$transactionId'";

    if ($conn->query($sql) === TRUE) {
        echo "Order placed successfully for transaction id: $transactionId";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
