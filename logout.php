<?php

require_once __DIR__ . '/includes/auth.php';

logoutUser();
header('Location: /views/login.php');
exit;
?>
