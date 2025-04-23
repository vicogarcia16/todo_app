<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/tasks.php';
require_once __DIR__ . '/../includes/flash.php';
requireAuth();

$userId  = $_SESSION['user_id'];
$error   = getFlash('error');
$success = getFlash('success');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['new_task'] ?? '');
  if ($title === '') {
    setFlash('error', 'Please enter a task.');
  } else {
    createTask($userId, $title);
    setFlash('success', 'Created new task.');
  }
}

if (isset($_GET['toggle'])) {
  toggleTask((int)$_GET['toggle'], $userId);
  header('Location: dashboard.php');
  exit;
}
if (isset($_GET['delete'])) {
  deleteTask((int)$_GET['delete'], $userId);
  header('Location: dashboard.php');
  exit;
}

$tasks = getTasks($userId);

include_once __DIR__ . '/../includes/header.php';
?>

<div class="row justify-content-center">
  <div class="col-md-6 col-lg-5">
    <?php if ($error): ?>
      <div id="error-notification" class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($error) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php elseif ($success): ?>
      <div id="success-notification" class="alert alert-success alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($success) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <h3 class="text-center mb-3">📝 My Tasks</h3>

    <form method="POST" class="d-flex gap-2 mb-3">
      <input type="text" name="new_task"
        class="form-control form-control-sm fs-6"
        placeholder="New task…" autofocus required>
      <button class="btn btn-success btn-sm" type="submit">Create</button>
    </form>

    <ul class="list-group">
      <?php if (empty($tasks)): ?>
        <li class="list-group-item text-center">You have no tasks.</li>
      <?php else: ?>
        <?php foreach ($tasks as $t): ?>
          <li class="list-group-item d-flex justify-content-between align-items-center
          <?= $t['completed'] ? 'list-group-item-dark' : '' ?>">
            <span class="fs-6 <?= $t['completed'] ? 'text-decoration-line-through' : '' ?>">
              <?= htmlspecialchars($t['title']) ?>
            </span>
            <div>
              <a href="?toggle=<?= $t['id'] ?>" class="btn btn-sm btn-outline-primary me-1">
                <?= $t['completed'] ? '↺' : '✔' ?>
              </a>
              <a href="?delete=<?= $t['id'] ?>" class="btn btn-sm btn-outline-danger">✖</a>
            </div>
          </li>
        <?php endforeach; ?>
      <?php endif; ?>
    </ul>
  </div>
</div>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>