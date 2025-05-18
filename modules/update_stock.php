<?php
require_once '../classes/cls_mainpage.php';

header('Content-Type: application/json; charset=utf-8');

// Verifica se os dados foram enviados
if (!isset($_POST['produto'])) {
    echo json_encode([
        'erro' => '1',
        'message' => 'Dados não recebidos.'
    ]);
    exit;
}

// Decodifica JSON se for string JSON
$produtosComprados = is_string($_POST['produto']) 
    ? json_decode($_POST['produto'], true)
    : $_POST['produto'];

$iduser = $_POST['userId'];    

if (!is_array($produtosComprados)) {
    echo json_encode([
        'erro' => '1',
        'message' => 'Formato inválido de dados.'
    ]);
    exit;
}

$obj = new cls_mainpage();
$resultado = $obj->atualizarEstoqueComPedido($produtosComprados,$iduser);

echo json_encode($resultado);
