<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

require_once '../classes/cls_mainpage.php';

// Get POST data safely
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';

$response = [
    'erro' => '1',
    'message' => 'Usuario ou senha invalidos.'
];

// Decode password 
if (strpos($senha, ';') !== false) {
    $senha = decode_password($senha);
}

// Decode masked password (if contains ";")
// return base64_decode($encoded);
function decode_password($encoded) {
    $chars = explode(';', rtrim($encoded, ';'));
    $decoded = '';

    foreach ($chars as $char) {
        if ($char !== '') {
            $codepoint = ord($char);   // converte o caractere para código numérico
            $original = $codepoint - 32;
            $letra = chr($original);   // converte de volta para caractere
            $decoded .= $letra;
        }
    }

    // var_dump($decoded);
    return $decoded;
}

// Autenticação com banco
if (!empty($email) && !empty($senha)) {
    $obj = new cls_mainpage();
    $auth = $obj->getUsuarioByEmailSenha($email, $senha);

    if ($auth['erro'] === '0') {
        $usuario = $auth['usuario'];
        $_SESSION['username'] = $usuario->nome;

        // Consultar produtos com estoque > 0
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
 ?>