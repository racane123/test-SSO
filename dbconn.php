<?php

$localhost = 'localhost';
$user = 'root';
$password = '';
$database = 'testdb';


$conn = mysqli_connect( $localhost, $user, $password, $database);


if (!$conn){
    die("Connection Error". mysqli_error($conn));
}