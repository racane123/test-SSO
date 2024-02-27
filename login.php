<?php

require('dbconn.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Fetch user from the database based on the provided email
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $hashedPassword = $user["password"]; // Fetch hashed password from the database

        // Verify the hashed password
        if (password_verify($password, $hashedPassword)) {
            // Password verification successful, generate and store the access token
            $token = generateToken();
            $userId = $user["id"];
            $expirationDate = date("Y-m-d H:i:s", strtotime("+1 day"));

            $query = "INSERT INTO access_tokens (token, user_id, expiration_date) VALUES ('$token', '$userId', '$expirationDate')";
            mysqli_query($conn, $query);

            echo json_encode(array("success" => true, "token" => $token));
        } else {
            // Password verification failed
            echo json_encode(array("success" => false, "message" => "Invalid email or password."));
        }
    } else {
        // No user found with the provided email
        echo json_encode(array("success" => false, "message" => "Invalid email or password."));
    }
}

function generateToken() {
    return uniqid();
}
?>
