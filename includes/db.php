<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/Config.php';

use App\Config;
use Dotenv\Dotenv;
use RedBeanPHP\R;

if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
}

try {
    $host = Config::get('DB_HOST');
    $dbname = Config::get('DB_NAME');
    $user = Config::get('DB_USER');
    $pass = Config::get('DB_PASS');
    $driver = Config::get('DB_DRIVER', 'pgsql');
    $port = Config::get('DB_PORT', '5432');

    $dsn = "$driver:host=$host;port=$port;dbname=$dbname";
    R::setup($dsn, $user, $pass);

    R::freeze(true);
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>