<?php


session_start();
session_unset();     // Clears all session variables
session_destroy();   // Ends the session
header('Location: ../index.html');
exit();



?>