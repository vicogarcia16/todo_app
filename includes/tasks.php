<?php
require_once __DIR__ . '/db.php';
use RedBeanPHP\R;

function getTasks(int $userId): array
{
    try {
        $tasks = R::findAll('tasks', 'user_id = ? ORDER BY created_at DESC', [$userId]);
        return array_map(function ($task) {
            return [
                'id'        => $task->id,
                'title'     => $task->title,
                'completed' => (bool)$task->completed,
                'created_at'=> $task->created_at
            ];
        }, $tasks);
    } catch (Exception $e) {
        die("Error getting tasks: " . $e->getMessage());
    }
}

function createTask(int $userId, string $title): void
{
    try {
        $task = R::dispense('tasks');
        $task->user_id = $userId;
        $task->title = $title;
        $task->completed = false;
        $task->created_at = date('Y-m-d H:i:s');
        R::store($task);
    } catch (Exception $e) {
        die("Error creating task: " . $e->getMessage());
    }
}

function toggleTask(int $taskId, int $userId): void
{
    try {
        $task = R::load('tasks', $taskId);
        if ($task->user_id == $userId) {
            $task->completed = !$task->completed;
            R::store($task);
        }
    } catch (Exception $e) {
        die("Error toggling task: " . $e->getMessage());
    }
}

function deleteTask(int $taskId, int $userId): void
{
    try {
        $task = R::load('tasks', $taskId);
        if ($task->user_id == $userId) {
            R::trash($task);
        }
    } catch (Exception $e) {
        die("Error deleting task: " . $e->getMessage());
    }
}
