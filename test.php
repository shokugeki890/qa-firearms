<?php
// test.php
echo "<h1>PHP Test Page</h1>";

// Test 1: Basic PHP info
echo "<h2>PHP Information:</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Loaded Extensions:<br>";
$extensions = get_loaded_extensions();
sort($extensions);
echo implode(", ", $extensions);

// Test 2: MySQL Connection
echo "<h2>MySQL Connection Test:</h2>";

$host = "mysql";
$user = "appuser";
$pass = "password";
$db = "rhys_firearms";

// Method 1: mysqli
echo "Method 1 - mysqli:<br>";
$conn1 = @new mysqli($host, $user, $pass, $db);
if ($conn1->connect_error) {
    echo "Failed: " . $conn1->connect_error . "<br>";
} else {
    echo "Success! MySQL Version: ";
    $result = $conn1->query("SELECT VERSION() as version");
    $row = $result->fetch_assoc();
    echo $row['version'] . "<br>";
    $conn1->close();
}

// Method 2: PDO
echo "<br>Method 2 - PDO:<br>";
try {
    $conn2 = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Success!<br>";
    $conn2 = null;
} catch(PDOException $e) {
    echo "Failed: " . $e->getMessage() . "<br>";
}

// Test 3: Check if files are accessible
echo "<h2>File System Test:</h2>";
$files = ['index.php', 'connection.php', 'test.php'];
foreach ($files as $file) {
    if (file_exists($file)) {
        echo "✓ $file exists<br>";
    } else {
        echo "✗ $file NOT found<br>";
    }
}

// Test 4: Check Docker networking
echo "<h2>Network Test:</h2>";
echo "Trying to resolve 'mysql': ";
$ip = gethostbyname('mysql');
echo $ip . " (mysql resolves to: $ip)<br>";

// Test 5: Test if we can reach MySQL via socket or TCP
echo "<br>Testing MySQL connectivity:<br>";
echo "Using host: $host<br>";

// Show all MySQL related environment variables
echo "<h2>Environment Variables:</h2>";
$env_vars = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD'];
foreach ($env_vars as $var) {
    $value = getenv($var);
    echo "$var: " . ($value ? $value : '(not set)') . "<br>";
}
?>