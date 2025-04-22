<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../includes/auth.php';

if (!empty($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $res = loginUser($username, $password);
    if ($res['success']) {
        header('Location: dashboard.php');
        exit;
    }
    $error = $res['message'];
}
?>

<?php include_once __DIR__ . '/../includes/header.php'; ?>

<div class="row justify-content-center">
  <div class="col-md-4">
    <?php if ($error): ?>
        <div id="error-notification" class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($error) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="card bg-secondary text-white mb-3">
      <div class="card-body">
        <h4 class="card-title text-center mb-2">Login</h4>

        <form method="POST" novalidate>
          <div class="mb-3">
            <label for="username" class="form-label">User</label>
            <input type="text" id="username" name="username"
                   class="form-control bg-dark text-white" required autofocus>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password"
                   class="form-control bg-dark text-white" required>
          </div>

          <button type="submit" class="btn btn-primary btn-md w-100">Submit</button>
        </form>

        <p class="mt-3 text-center small">
            Don't have an account?
            <a href="register.php" class="link-light">Register</a>
        </p>
      </div>
    </div>
  </div>
</div>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
