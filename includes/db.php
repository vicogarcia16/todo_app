<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/Config.php';

use App\Config;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try {
    $host = Config::get('DB_HOST');
    $dbname = Config::get('DB_NAME');
    $user = Config::get('DB_USER');
    $pass = Config::get('DB_PASS');
    $driver = Config::get('DB_DRIVER', 'pgsql');
    $port = Config::get('DB_PORT', '5432');

    $pdo = new PDO("$driver:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>