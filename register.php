<?php


require('dbconn.php');


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['username'], $_POST['password'], $_POST['email'])){
        $formData = array();

        $formData['username'] = mysqli_real_escape_string($conn, $_POST['username']);
        $formData['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $formData['email'] = mysqli_real_escape_string($conn, $_POST['email']);


        $sql = "INSERT INTO users (username, password,email) VALUES (?,?,?)";

        $stmt=mysqli_prepare($conn,$sql);

        mysqli_stmt_bind_param($stmt, "sss", $formData['username'], $formData['password'], $formData['email']);

        $response = mysqli_stmt_execute( $stmt );

        if($response){
            http_response_code(200);
            echo json_encode($response);
        }
        else{
            http_response_code(406);
        }
    }
}else{
    http_response_code(400);
}

mysqli_close( $conn );  // Closing Connection with Server