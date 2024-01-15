<?php
// Include your database connection file
include 'db_connect.php';

// Check if the required parameters are set
if (isset($_POST['quantity']) && isset($_POST['username']) && isset($_POST['medicineId']) && isset($_POST['address'])) {
    // Sanitize and store the received data
    $quantity = $_POST['quantity'];
    $username = $_POST['username'];
    $medicineId = $_POST['medicineId'];
    $address = $_POST['address'];

    // Retrieve user_id based on the username
    $userQuery = "SELECT user_id FROM user WHERE username = '$username'";
    $userResult = mysqli_query($conn, $userQuery);

    if ($userResult && mysqli_num_rows($userResult) > 0) {
        $userData = mysqli_fetch_assoc($userResult);
        $user_id = $userData['user_id'];

        // Insert data into the orders table with the address
        $sql = "INSERT INTO transaction (quantity, user_id, medicine_id, address, status) 
                VALUES ('$quantity', '$user_id', '$medicineId', '$address', 'In-receive')";

        if (mysqli_query($conn, $sql)) {
            // Success
            echo "Order placed successfully";
        } else {
            // Error
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        // User not found
        echo "Error: User not found";
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Parameters not set
    echo "Invalid parameters";
}
?>
