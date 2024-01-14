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

    // Query to get the count of medicines in the cart for the user
    $cartQuery = "SELECT COUNT(*) AS cart_count FROM transaction WHERE user_id = $user_id";
    $cartResult = mysqli_query($conn, $cartQuery);

    if ($cartResult) {
        // Fetch the result
        $cartRow = mysqli_fetch_assoc($cartResult);

        // Store the count in the response array as an integer
        $response['cart_count'] = (int)$cartRow['cart_count'];

        // Send the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Error handling for cart query
        $response['error'] = true;
        $response['message'] = 'Error executing cart query: ' . mysqli_error($conn);

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
