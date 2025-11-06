
<?php
session_start();

$servername = "localhost";
$username = "Pickapp@2025";
$password = "Pickapp@1234";
$dbname = "Pickapp_db";

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $input_user = $_POST['username'];
  $input_pass = $_POST['password'];

  $sql = "SELECT * FROM admins WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $input_user);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($input_pass, $row['password'])) {
      $_SESSION['admin_logged_in'] = true;
      $_SESSION['admin_user'] = $row['username'];
      header("Location: admin-dashboard.php");
      exit();
    } else {
      $error = "Invalid password.";
    }
  } else {
    $error = "Email not found.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Sign In | PICKAPP</title>
<style>
  body {
    font-family: "Poppins", sans-serif;
    background-color: #000;
    color: #fff;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    text-align: center;
    margin: 0;
  }

  .login-container {
    background: #111;
    padding: 40px;
    border-radius: 12px;
    width: 350px;
    box-shadow: 0 0 25px rgba(255, 165, 0, 0.3);
  }

  h2 {
    margin-bottom: 15px;
    font-size: 1.8rem;
    color: #FF8C00;
  }

  p.desc {
    font-size: 0.9rem;
    margin-bottom: 30px;
    color: #ccc;
  }

  form {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 6px;
    border: none;
    background: #222;
    color: #fff;
  }

  input::placeholder {
    color: #888;
  }

  button {
    width: 100%;
    background: #FF8C00;
    color: #000;
    font-weight: 600;
    border: none;
    padding: 12px;
    margin-top: 15px;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
  }

  button:hover {
    background: #FF8C00;
  }

  .links {
    margin-top: 15px;
    font-size: 0.85rem;
    color: #aaa;
  }

  .links a {
    color: #ffa500;
    text-decoration: none;
    margin: 0 4px;
  }

  .links a:hover {
    text-decoration: underline;
  }

  footer {
    margin-top: 40px;
    font-size: 0.8rem;
    color: #666;
  }

  footer p:last-child {
    margin-top: 5px;
    color: #888;
  }


  /* ----------------------------- */
/* RESPONSIVE: Mobile Friendly   */
/* ----------------------------- */
@media (max-width: 600px) {
  .login-container {
    width: 70%;               /* shrink container width */
    padding: 25px;            /* smaller padding */
     box-shadow: 0 4px 20px rgba(255, 69, 0, 0.7);
  }

  h2 {
    font-size: 1.4rem;        /* smaller title */
  }

  p.desc {
    font-size: 0.85rem;
    margin-bottom: 20px;
  }

  input {
    padding: 10px;
    font-size: 0.9rem;
  }

  button {
    padding: 10px;
    font-size: 0.9rem;
  }

  .links {
    font-size: 0.8rem;
  }

  footer {
    font-size: 0.7rem;
    margin-top: 30px;
  }
}



</style>
</head>
<body>

<div class="login-container">
  <h2>Account Sign In</h2>
  <p class="desc">Sign in to your account to access your profile, history, and any private pages you've been granted access to.</p>

  <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

  <form method="POST">
    <input type="text" name="username" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit">Sign In</button>
  </form>

  <div class="links">
    <a href="#">Reset password</a><br>
    Not a member? <a href="#">Create account</a>
  </div>
</div>

<footer>
  <p>Ayala Technohub, Dillman Quezon City, Philippines</p>
  <p>© PICKAPP 2024</p>
</footer>

</body>
</html>
