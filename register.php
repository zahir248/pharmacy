<?php

include 'db_connect.php'; // Assuming you have a file for database connection

// Retrieve data from POST request
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Hash the password for security
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Set the role to 'customer'
$role = 'customer';

// Check if the username already exists
$checkUsernameQuery = "SELECT * FROM user WHERE username = '$username'";
$result = $conn->query($checkUsernameQuery);

if ($result->num_rows > 0) {
    // Username already exists, provide an error message
    echo "Error: Username already exists. Please choose a different username.";
} else {
    // Username is unique, proceed with registration
    $sql = "INSERT INTO user (username, email, password, role) VALUES ('$username', '$email', '$hashedPassword', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
