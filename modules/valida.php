<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

require_once '../classes/cls_mainpage.php';

// Get POST data safely
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';

$response = [
    'erro' => '1',
    'message' => 'Usurio ou senha invlidos.'
];

// Decode password 
if (strpos($senha, ';') !== false) {
    $senha = decode_password($senha);
}

// Decode masked password (if contains ";")
function decode_password($encoded) {
    // return base64_decode($encoded);
    $chars = explode(';', rtrim($encoded, ';'));
    $decoded = '';
    foreach ($chars as $char) {
        if ($char !== '') {
            $decoded .= chr(ord($char) - 32);
        }
    }

    // var_dump($decoded);
    // exit;
    // return mb_convert_encoding($decoded, 'UTF-8', 'ISO-8859-1');
    return $encoded;
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