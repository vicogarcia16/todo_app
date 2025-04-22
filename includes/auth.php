<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db.php';
use RedBeanPHP\R;

function registerUser(string $username, string $password): array
{
    $existing = R::findOne('users', 'username = ?', [$username]);
    if ($existing) {
        return ['success' => false, 'message' => 'Username already exists.'];
    }

    $user = R::dispense('users');
    $user->username = $username;
    $user->password = password_hash($password, PASSWORD_DEFAULT);

    try {
        R::store($user);
        return ['success' => true, 'message' => 'User registered.'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Error registering user.'];
    }
}

function loginUser(string $username, string $password): array
{
    $user = R::findOne('users', 'username = ?', [$username]);

    if (!$user) {
        return ['success' => false, 'message' => 'User not found.'];
    }

    if (!password_verify($password, $user->password)) {
        return ['success' => false, 'message' => 'Wrong password.'];
    }

    $_SESSION['user_id']  = $user->id;
    $_SESSION['username'] = $user->username;

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
