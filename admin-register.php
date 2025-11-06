<<<<<<< HEAD
<?php
$servername = "localhost";
$username = "Pickapp@2025";
$password = "Pickapp@1234";
$dbname = "Pickapp_db";

// Connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Admin credentials
$admin_user = "admin";
$admin_pass = "Pickapp@2025"; // same as your original password

// Hash password
$hashed_password = password_hash($admin_pass, PASSWORD_DEFAULT);

// Insert admin
$sql = "INSERT INTO admins (username, password) VALUES ('$admin_user', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
  echo "✅ Admin account created successfully!";
} else {
  echo "❌ Error: " . $conn->error;
}

$conn->close();
?>
=======
<?php
$servername = "localhost";
$username = "Pickapp@2025";
$password = "Pickapp@1234";
$dbname = "Pickapp_db";

// Connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Admin credentials
$admin_user = "admin";
$admin_pass = "Pickapp@2025"; // same as your original password

// Hash password
$hashed_password = password_hash($admin_pass, PASSWORD_DEFAULT);

// Insert admin
$sql = "INSERT INTO admins (username, password) VALUES ('$admin_user', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
  echo "✅ Admin account created successfully!";
} else {
  echo "❌ Error: " . $conn->error;
}

$conn->close();
?>
>>>>>>> f9ae7d780d93e2f743ef5a45558b2b9ed2fde174
