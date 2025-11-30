<?php
    $host = "mysql";
	$user = "root";
	$pass = "password";
	$db = "rhys_firearms";
	
	$conn = mysqli_connect($host, $user, $pass, $db);
	
	
	//cek koneksi bila gagal
	if (!$conn){
		die("Koneksi gagal: " . mysqli_connect_error());
	}
?>