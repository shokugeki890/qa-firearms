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
<<<<<<< HEAD

	
=======
>>>>>>> 0fcfeea15a1bc5220164b9645aab8abd91e0f5d6
?>