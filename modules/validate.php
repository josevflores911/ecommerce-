<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

require_once '../classes/cls_mainpage.php';

// Obtener datos POST con seguridad
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';

// Respuesta por defecto
$response = [
    'erro' => '1',
    'message' => 'Usuário ou senha inválidos.'
];

// Función para decodificar la contraseña enviada con ";"
function decode_password($encoded) {
    $chars = explode(';', rtrim($encoded, ';'));
    $decoded = '';

    foreach ($chars as $char) {
        if ($char !== '') {
            $codepoint = ord($char);
            $original = $codepoint - 32;
            $decoded .= chr($original);
        }
    }

    return $decoded;
}

// Decodificar si es necesario
if (strpos($senha, ';') !== false) {
    $senha = decode_password($senha);
}

// Validar formato de email (opcional, pero recomendado)
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode($response);
    exit;
}

// Autenticación con base de datos
if (!empty($email) && !empty($senha)) {
    $obj = new cls_mainpage();

    // Aquí idealmente getUsuarioByEmailSenha debe validar usando password_verify()
    $auth = $obj->getUsuarioByEmailSenha($email, $senha);

    if ($auth['erro'] === '0') {
        $usuario = $auth['usuario'];
        $_SESSION['username'] = $usuario->nome;
        $_SESSION['user_id'] = $usuario->id; // mejor guardar ID también

        $resultado = $obj->getProdutos();

        $response = [
            'erro' => '0',
            'message' => 'Login realizado com sucesso!',
            'id_user' => $usuario->id,
            'nm_user' => $usuario->nome,
            'produtos' => $resultado['Data'] ?? []
        ];
    }
}

echo json_encode($response);
