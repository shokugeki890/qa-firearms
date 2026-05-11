<?php
// test_mysql.php
echo "Testing MySQL Connection...<br>";

// Simple connection test
$link = mysqli_connect('mysql', 'appuser', 'password', 'rhys_firearms');

if (!$link) {
    echo "Error: " . mysqli_connect_error() . "<br>";
    
    // Try with SSL disabled using older method
    $link = mysqli_init();
    mysqli_options($link, MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, false);
    
    if (mysqli_real_connect($link, 'mysql', 'appuser', 'password', 'rhys_firearms')) {
        echo "Connected successfully with SSL disabled!<br>";
        
        $result = mysqli_query($link, "SELECT VERSION() as version");
        $row = mysqli_fetch_assoc($result);
        echo "MySQL Version: " . $row['version'] . "<br>";
        
        mysqli_close($link);
    } else {
        echo "Failed to connect even with SSL disabled: " . mysqli_connect_error() . "<br>";
    }
} else {
    echo "Connected successfully!<br>";
    
    $result = mysqli_query($link, "SELECT VERSION() as version");
    $row = mysqli_fetch_assoc($result);
    echo "MySQL Version: " . $row['version'] . "<br>";
    
    mysqli_close($link);
}

echo "<br>PHP Extensions loaded:<br>";
echo "mysqli: " . (extension_loaded('mysqli') ? 'Yes' : 'No') . "<br>";
echo "pdo_mysql: " . (extension_loaded('pdo_mysql') ? 'Yes' : 'No') . "<br>";
?>