<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.5/dist/darkly/bootstrap.min.css" rel="stylesheet">
  <title>To‑Do App</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="/index.php">To‑Do App</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto">
        <?php if (!empty($_SESSION['user_id'])): ?>
          <li class="nav-item"><a class="nav-link" href="/views/dashboard.php">My Tasks</a></li>
          <li class="nav-item"><a class="nav-link" href="/logout.php">Logout(<?=htmlspecialchars($_SESSION['username'])?>)</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="/views/login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="/views/register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<main class="container my-4">
