
<?php
session_start();

// Destroy all session data (log out the admin)
session_unset();
session_destroy();

// Redirect back to login page
header("Location: quick-links.html");
exit();
?>
