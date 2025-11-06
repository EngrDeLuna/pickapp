
<?php
// contact-process.php
// DB credentials
$servername = "localhost";
$dbuser = "Pickapp@2025";
$dbpass = "Pickapp@1234";
$dbname = "Pickapp_db";

// Create connection
$conn = new mysqli($servername, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Basic validation & sanitize
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if ($name === '' || $email === '' || $message === '') {
    echo "<script>alert('Please fill in all fields.'); window.location.href='contact-us.html';</script>";
    exit;
}

// Optional: validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Please enter a valid email address.'); window.location.href='contact-us.html';</script>";
    exit;
}

// Insert safely using prepared statement
$sql = "INSERT INTO inquiries (name, email, message) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    // debug
    echo "<script>alert('Prepare failed: " . addslashes($conn->error) . "'); window.location.href='contact-us.html';</script>";
    exit;
}
$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
    echo "<script>alert('Your message has been sent. Thank you!'); window.location.href='contact-us.html';</script>";
} else {
    echo "<script>alert('Error sending message. Please try again.'); window.location.href='contact-us.html';</script>";
}

$stmt->close();
$conn->close();
?>
