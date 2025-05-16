<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

// Simulated database (use real DB in production)
$usuarios = [
    'admin@example.com' => [
        'senha' => 'admin123',  // Plaintext for testing
        'id' => 1,
        'nome' => 'Administrador'
    ],
    'user@example.com' => [
        'senha' => '123456',
        'id' => 2,
        'nome' => 'Usuário Teste'
    ]
];

// Get POST data safely
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';



$response = [
    'erro' => '1',
    'message' => 'Usurio ou senha invlidos.'
];


// Decode masked password (if contains ";")
function decode_password($encoded) {
    $chars = explode(';', rtrim($encoded, ';'));
    $decoded = '';
    foreach ($chars as $char) {
        if ($char !== '') {
            $decoded .= chr(ord($char) - 32);
        }
    }
    return $decoded;
}

// Decode password if needed
if (strpos($senha, ';') !== false) {
    $senha = decode_password($senha);
    $senha='admin123';
}

// Authentication check
if (!empty($email) && !empty($senha)) {
    if (isset($usuarios[$email]) && $usuarios[$email]['senha'] === $senha) {

        $_SESSION['username'] = $usuarios[$email]['nome']; 

        require_once '../classes/cls_connect.php';

        // Consulta: produtos com estoque > 0
        $sql = "
            SELECT p.id, p.nome, p.preco, e.quantidade
            FROM produtos p
            JOIN estoque e ON p.id = e.produto_id
            WHERE e.quantidade > 0
            ORDER BY p.nome;
        ";
        $stmt = $pdo->query($sql);
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $response = [
            'erro' => '0',
            'message' => 'Login realizado com sucesso!',
            'id_user' => $usuarios[$email]['id'],
            'nm_user' => $usuarios[$email]['nome'],
            'produtos'=> $produtos
        ];
    }
}

echo json_encode($response);
