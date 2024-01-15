<?php

// Include your database connection code
include 'db_connect.php';

// Get username from the request
$username = $_GET['username'];

// Initialize response array
$response = array();

// Query to get the user_id based on the username
$userQuery = "SELECT user_id FROM user WHERE username = '$username'";
$userResult = mysqli_query($conn, $userQuery);

if ($userResult) {
    $userRow = mysqli_fetch_assoc($userResult);

    // Get the user_id
    $user_id = $userRow['user_id'];

    // Query to get the count of medicines in the cart for the user with status In-cart
    $shipQuery = "SELECT COUNT(*) AS ship_count FROM transaction WHERE user_id = $user_id AND status = 'In-receive'";
    $shipResult = mysqli_query($conn, $shipQuery);

    if ($shipResult) {  // Fix: Change $cartResult to $shipResult
        // Fetch the result
        $shipRow = mysqli_fetch_assoc($shipResult);

        // Store the ship in the response array as an integer
        $response['ship_count'] = (int)$shipRow['ship_count'];

        // Send the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Error handling for ship query
        $response['error'] = true;
        $response['message'] = 'Error executing ship query: ' . mysqli_error($conn);

        // Send the error response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    // Error handling for user query
    $response['error'] = true;
    $response['message'] = 'Error executing user query: ' . mysqli_error($conn);

    // Send the error response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Close the database connection
mysqli_close($conn);

?>
