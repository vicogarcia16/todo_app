<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db.php';

function registerUser(string $username, string $password): array
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        return ['success' => false, 'message' => 'Username already exists.'];
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $ok = $stmt->execute([$username, $hash]);

    return $ok
        ? ['success' => true, 'message' => 'User registered.']
        : ['success' => false, 'message' => 'Error registering user.'];
}


function loginUser(string $username, string $password): array
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return ['success' => false, 'message' => 'User not found.'];
    }

    if (!password_verify($password, $user['password'])) {
        return ['success' => false, 'message' => 'Wrong password.'];
    }

    $_SESSION['user_id']  = $user['id'];
    $_SESSION['username'] = $username;

    return ['success' => true, 'message' => 'Login successful.'];
}

function logoutUser(): void
{
    session_unset();
    session_destroy();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
}

function requireAuth(): void
{
    if (empty($_SESSION['user_id'])) {
        header('Location: ../views/login.php');
        exit;
    }
}
