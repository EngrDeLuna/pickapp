<<<<<<< HEAD
<?php
session_start();

// Destroy all session data (log out the admin)
session_unset();
session_destroy();

// Redirect back to login page
header("Location: quick-links.html");
exit();
?>
=======
<?php
session_start();

// Destroy all session data (log out the admin)
session_unset();
session_destroy();

// Redirect back to login page
header("Location: quick-links.html");
exit();
?>
>>>>>>> f9ae7d780d93e2f743ef5a45558b2b9ed2fde174
