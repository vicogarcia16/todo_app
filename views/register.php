<?php
require_once __DIR__ . '/../includes/auth.php';

// Si ya está logueado, redirige al dashboard
if (!empty($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm']  ?? '';

    if ($username === '' || $password === '' || $confirm === '') {
        $error = 'Please fill in all fields.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        $res = registerUser($username, $password);
        if ($res['success']) {
            header('Location: login.php');
            exit;
        }
        $error = $res['message'];
    }
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
      <div class="card-body p-3">
        <h4 class="card-title text-center mb-2">Register</h4>

        <form method="POST" novalidate>
          <div class="mb-2">
            <label for="username" class="form-label form-label-md">User</label>
            <input type="text" id="username" name="username"
                   class="form-control form-control-md bg-dark text-white" required>
          </div>
          <div class="mb-2">
            <label for="password" class="form-label form-label-md">Password</label>
            <input type="password" id="password" name="password"
                   class="form-control form-control-md bg-dark text-white" required>
          </div>
          <div class="mb-3">
            <label for="confirm" class="form-label form-label-md">Confirm Password</label>
            <input type="password" id="confirm" name="confirm"
                   class="form-control form-control-md bg-dark text-white" required>
          </div>
          <button type="submit" class="btn btn-primary btn-md w-100">Submit</button>
        </form>

        <p class="mt-3 text-center small">
          Do you have an account?
          <a href="login.php" class="link-light">Login</a>
        </p>
      </div>
    </div>
  </div>
</div>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
