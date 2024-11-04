<?php
// Define the database connection parameters
$databaseHost = 'localhost';
$databaseName = 'poliklinik';
$databaseUsername = 'root';
$databasePassword = '';

// Create a connection
$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

// Check connection
if (!$mysqli) {
    die("Connection failed: " . mysqli_connect_error());   
}