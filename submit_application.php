<<<<<<< HEAD
<?php
// Database connection
$conn = new mysqli("localhost", "Pickapp@2025", "Pickapp@1234", "Pickapp_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$message = $_POST['message'];

// Handle resume upload
$resume_path = "";
if(isset($_FILES['resume']) && $_FILES['resume']['error'] == 0){
    $upload_dir = "uploads/";
    if(!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
    $resume_path = $upload_dir . basename($_FILES['resume']['name']);
    move_uploaded_file($_FILES['resume']['tmp_name'], $resume_path);
}

// Insert into database
$stmt = $conn->prepare("INSERT INTO applications (name, phone, email, message, resume) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $phone, $email, $message, $resume_path);
$stmt->execute();
$stmt->close();
$conn->close();

echo "Application submitted successfully!";
?>
=======
<?php
// Database connection
$conn = new mysqli("localhost", "Pickapp@2025", "Pickapp@1234", "Pickapp_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$message = $_POST['message'];

// Handle resume upload
$resume_path = "";
if(isset($_FILES['resume']) && $_FILES['resume']['error'] == 0){
    $upload_dir = "uploads/";
    if(!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
    $resume_path = $upload_dir . basename($_FILES['resume']['name']);
    move_uploaded_file($_FILES['resume']['tmp_name'], $resume_path);
}

// Insert into database
$stmt = $conn->prepare("INSERT INTO applications (name, phone, email, message, resume) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $phone, $email, $message, $resume_path);
$stmt->execute();
$stmt->close();
$conn->close();

echo "Application submitted successfully!";
?>
>>>>>>> f9ae7d780d93e2f743ef5a45558b2b9ed2fde174
