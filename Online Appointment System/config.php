<?php 
	$host="localhost";
	$user="root";
	$password="";
	
$conn = new mysqli($host, $user, $password,"TEST1");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>