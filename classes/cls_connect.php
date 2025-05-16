<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Ajuste o caminho conforme sua estrutura

use Dotenv\Dotenv;

// Carrega as variáveis do .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../'); // Caminho até o .env
$dotenv->load();

// Recupera as variáveis de ambiente
$host = $_ENV['DB_HOST'];
$db   = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];

// Conecta ao banco de dados
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>
