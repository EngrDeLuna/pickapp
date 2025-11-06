<<<<<<< HEAD
<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin-login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard | PICKAPP</title>
<style>
 /* General Layout */
body {
  margin: 0;
  font-family: "Poppins", sans-serif;
  background-color: #f4f4f4;
  display: flex;
  height: 100vh;
  overflow: hidden;
}
  /* Sidebar */
.sidebar {
  width: 220px;
  background: #111;
  color: #fff;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 20px;
}

.sidebar .logo {
  width: 70px;
  margin-bottom: 10px;
}

.sidebar h2 {
  font-size: 16px;
  color: #ff9900;
  margin-bottom: 20px;
}

.menu {
  width: 80%;
  list-style: none;
  padding: 10px;
  margin: 10px;
 
}

.menu li {
  padding: 15px 20px;
  text-align: left;
  cursor: pointer;
  border-bottom: 2px solid #ddd;
  transition: 0.3s;
   border-radius: 20px;
}

.menu li:hover, .menu li.active {
  background: #ff9900;
  color: #333333;
}

/* Topbar */
.topbar {
  position: fixed;
  top: 0;
  left: 220px;
  right: 0;
  height: 80px;
  background: #ff7a00;
  border-bottom: 1px solid #ddd;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 25px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.2);
  z-index: 10;
}

.topbar h1 {
  margin: 0;
  font-size: 20px;
  color: #333;
}

.logout-btn {
  background-color: #FFFFFF;
  color: #333333;
  padding: 8px 16px;
  border-radius: 20px;
  text-decoration: none;
  font-weight: bold;
  transition: background 0.3s ease;
}

.logout-btn:hover {
  background-color: #ff9900;
  box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* smooth for the whole card */
}

/* Content Area */
.content {
  flex: 1;
  padding: 150px 150px 150px 150px;
  overflow-y: auto;
  margin-left: 60px;
}

.card {
  background: #fff;
  border-radius: 8px;
  padding: 20px;
  margin-bottom: 25px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
  background: #fff;
}

th, td {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: left;
}

th {
  background: #ffa500;
  color: #000;
}

tr:nth-child(even) {
  background: #f9f9f9;
}

tr:hover {
  background: #fffae6;
}

</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <img src="images/logo.png" alt="PICKAPP Logo" class="logo">
  <h2>PICKAPP ADMIN</h2>
  <ul class="menu">
    <li class="active" onclick="showSection('applications')">Applicants</li>
    <li onclick="showSection('inquiries')">Inquiries</li>
  </ul>
</div>

<!-- Top Bar -->
<div class="topbar">
  <h1>ADMIN DASHBOARD</h1>
  <a href="logout.php" class="logout-btn">Logout</a>
</div>

<!-- Main Content -->
<div class="content">

  <!-- Applications Section -->
  <div id="applications" class="section">
    <div class="card">
      <h2>Applicants List</h2>
      <table>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Message</th>
          <th>Resume</th>
          <th>Date Sent</th>
        </tr>

        <?php
        $conn = new mysqli("localhost", "Pickapp@2025", "Pickapp@1234", "Pickapp_db");
        if ($conn->connect_error) {
          die("<tr><td colspan='7'>Connection failed: " . $conn->connect_error . "</td></tr>");
        }

        $sql = "SELECT id, name, email, phone, message, resume, date_sent FROM applications ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['message']}</td>
                    <td><a href='uploads/{$row['resume']}' target='_blank'>View</a></td>
                    <td>{$row['date_sent']}</td>
                  </tr>";
          }
        } else {
          echo "<tr><td colspan='7'>No applications found.</td></tr>";
        }
        $conn->close();
        ?>
      </table>
    </div>
  </div>

  <!-- Inquiries Section -->
  <div id="inquiries" class="section" style="display:none;">
    <div class="card">
      <h2>Customer Inquiries</h2>
      <table>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Message</th>
          <th>Date Submitted</th>
        </tr>

        <?php
        $conn2 = new mysqli("localhost", "Pickapp@2025", "Pickapp@1234", "Pickapp_db");
        if ($conn2->connect_error) {
          echo "<tr><td colspan='5'>DB connection error</td></tr>";
        } else {
          $res = $conn2->query("SELECT id, name, email, message, submitted_at FROM inquiries ORDER BY submitted_at DESC");
          if ($res && $res->num_rows > 0) {
            while ($r = $res->fetch_assoc()) {
              echo "<tr>
                      <td>".htmlspecialchars($r['id'])."</td>
                      <td>".htmlspecialchars($r['name'])."</td>
                      <td>".htmlspecialchars($r['email'])."</td>
                      <td>".nl2br(htmlspecialchars($r['message']))."</td>
                      <td>".htmlspecialchars($r['submitted_at'])."</td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='5'>No inquiries yet.</td></tr>";
          }
          $conn2->close();
        }
        ?>
      </table>
    </div>
  </div>
</div>

<!-- Script -->
<script>
function showSection(sectionId) {
  document.querySelectorAll('.section').forEach(sec => sec.style.display = 'none');
  document.getElementById(sectionId).style.display = 'block';
  document.querySelectorAll('.menu li').forEach(li => li.classList.remove('active'));
  event.target.classList.add('active');
}
</script>

</body>
</html>
=======
<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin-login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard | PICKAPP</title>
<style>
 /* General Layout */
body {
  margin: 0;
  font-family: "Poppins", sans-serif;
  background-color: #f4f4f4;
  display: flex;
  height: 100vh;
  overflow: hidden;
}
  /* Sidebar */
.sidebar {
  width: 220px;
  background: #111;
  color: #fff;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 20px;
}

.sidebar .logo {
  width: 70px;
  margin-bottom: 10px;
}

.sidebar h2 {
  font-size: 16px;
  color: #ff9900;
  margin-bottom: 20px;
}

.menu {
  width: 80%;
  list-style: none;
  padding: 10px;
  margin: 10px;
 
}

.menu li {
  padding: 15px 20px;
  text-align: left;
  cursor: pointer;
  border-bottom: 2px solid #ddd;
  transition: 0.3s;
   border-radius: 20px;
}

.menu li:hover, .menu li.active {
  background: #ff9900;
  color: #333333;
}

/* Topbar */
.topbar {
  position: fixed;
  top: 0;
  left: 220px;
  right: 0;
  height: 80px;
  background: #ff7a00;
  border-bottom: 1px solid #ddd;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 25px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.2);
  z-index: 10;
}

.topbar h1 {
  margin: 0;
  font-size: 20px;
  color: #333;
}

.logout-btn {
  background-color: #FFFFFF;
  color: #333333;
  padding: 8px 16px;
  border-radius: 20px;
  text-decoration: none;
  font-weight: bold;
  transition: background 0.3s ease;
}

.logout-btn:hover {
  background-color: #ff9900;
  box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* smooth for the whole card */
}

/* Content Area */
.content {
  flex: 1;
  padding: 150px 150px 150px 150px;
  overflow-y: auto;
  margin-left: 60px;
}

.card {
  background: #fff;
  border-radius: 8px;
  padding: 20px;
  margin-bottom: 25px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
  background: #fff;
}

th, td {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: left;
}

th {
  background: #ffa500;
  color: #000;
}

tr:nth-child(even) {
  background: #f9f9f9;
}

tr:hover {
  background: #fffae6;
}

</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <img src="images/logo.png" alt="PICKAPP Logo" class="logo">
  <h2>PICKAPP ADMIN</h2>
  <ul class="menu">
    <li class="active" onclick="showSection('applications')">Applicants</li>
    <li onclick="showSection('inquiries')">Inquiries</li>
  </ul>
</div>

<!-- Top Bar -->
<div class="topbar">
  <h1>ADMIN DASHBOARD</h1>
  <a href="logout.php" class="logout-btn">Logout</a>
</div>

<!-- Main Content -->
<div class="content">

  <!-- Applications Section -->
  <div id="applications" class="section">
    <div class="card">
      <h2>Applicants List</h2>
      <table>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Message</th>
          <th>Resume</th>
          <th>Date Sent</th>
        </tr>

        <?php
        $conn = new mysqli("localhost", "Pickapp@2025", "Pickapp@1234", "Pickapp_db");
        if ($conn->connect_error) {
          die("<tr><td colspan='7'>Connection failed: " . $conn->connect_error . "</td></tr>");
        }

        $sql = "SELECT id, name, email, phone, message, resume, date_sent FROM applications ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['message']}</td>
                    <td><a href='uploads/{$row['resume']}' target='_blank'>View</a></td>
                    <td>{$row['date_sent']}</td>
                  </tr>";
          }
        } else {
          echo "<tr><td colspan='7'>No applications found.</td></tr>";
        }
        $conn->close();
        ?>
      </table>
    </div>
  </div>

  <!-- Inquiries Section -->
  <div id="inquiries" class="section" style="display:none;">
    <div class="card">
      <h2>Customer Inquiries</h2>
      <table>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Message</th>
          <th>Date Submitted</th>
        </tr>

        <?php
        $conn2 = new mysqli("localhost", "Pickapp@2025", "Pickapp@1234", "Pickapp_db");
        if ($conn2->connect_error) {
          echo "<tr><td colspan='5'>DB connection error</td></tr>";
        } else {
          $res = $conn2->query("SELECT id, name, email, message, submitted_at FROM inquiries ORDER BY submitted_at DESC");
          if ($res && $res->num_rows > 0) {
            while ($r = $res->fetch_assoc()) {
              echo "<tr>
                      <td>".htmlspecialchars($r['id'])."</td>
                      <td>".htmlspecialchars($r['name'])."</td>
                      <td>".htmlspecialchars($r['email'])."</td>
                      <td>".nl2br(htmlspecialchars($r['message']))."</td>
                      <td>".htmlspecialchars($r['submitted_at'])."</td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='5'>No inquiries yet.</td></tr>";
          }
          $conn2->close();
        }
        ?>
      </table>
    </div>
  </div>
</div>

<!-- Script -->
<script>
function showSection(sectionId) {
  document.querySelectorAll('.section').forEach(sec => sec.style.display = 'none');
  document.getElementById(sectionId).style.display = 'block';
  document.querySelectorAll('.menu li').forEach(li => li.classList.remove('active'));
  event.target.classList.add('active');
}
</script>

</body>
</html>
>>>>>>> f9ae7d780d93e2f743ef5a45558b2b9ed2fde174
