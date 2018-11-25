<?php
	$servername = "localhost";
	$username = "gokil";
	$password = "gokil";
	$dbname = "sehat_doc";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
?>