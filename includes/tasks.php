<?php
require_once __DIR__ . '/db.php';

function getTasks(int $userId): array
{
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error getting tasks: " . $e->getMessage());
    }
}

function createTask(int $userId, string $title): void
{
    global $pdo;
    try {
        $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title) VALUES (?, ?)");
        $stmt->execute([$userId, $title]);
    } catch (PDOException $e) {
        die("Error creating task: " . $e->getMessage());
    }
}

function toggleTask(int $taskId, int $userId): void
{
    global $pdo;
    try {
        $stmt = $pdo->prepare("UPDATE tasks SET completed = NOT completed WHERE id = ? AND user_id = ?");
        $stmt->execute([$taskId, $userId]);
    } catch (PDOException $e) {
        die("Error toggling task: " . $e->getMessage());
    }
}

function deleteTask(int $taskId, int $userId): void
{
    global $pdo;
    try {
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
        $stmt->execute([$taskId, $userId]);
    } catch (PDOException $e) {
        die("Error deleting task: " . $e->getMessage());
    }
}
