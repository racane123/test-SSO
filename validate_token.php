<?php
require_once('dbconn.php');
$accessToken = $_SERVER['HTTP_ACCESS_TOKEN'];

// Validate the access token format
if (!preg_match('/^[A-Za-z0-9-_]+$/', $accessToken)) {
    // Handle invalid token format
    exit('Invalid access token format');
}

// Use prepared statement to prevent SQL injection
$query = "SELECT user_id FROM access_tokens WHERE token = ? AND expiration_date > NOW()";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, 's', $accessToken);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

// Perform a strict expiration check
if (mysqli_stmt_num_rows($stmt) > 0) {
    // Access token is valid
    mysqli_stmt_bind_result($stmt, $userId);
    mysqli_stmt_fetch($stmt);

    // Perform further actions or allow access to the protected resource
    // ...

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Access token is invalid or expired
    // Handle unauthorized access
    // ...

    // Close the statement
    mysqli_stmt_close($stmt);

    // Possibly log unauthorized access attempt
    exit('Unauthorized access');
}
?>
