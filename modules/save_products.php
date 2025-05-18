<?php
require_once '../classes/cls_mainpage.php';

$nome = $_POST['nome'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$preco = $_POST['preco'] ?? 0;
$quantidade = $_POST['quantidade'] ?? 0;
$ativo = $_POST['ativo'] ?? 1;

$obj = new cls_mainpage();
$resultado = $obj->salvarProduto($nome, $descricao, $preco, $quantidade, $ativo);

$response = [
    'erro' => '0',
    'message' => 'Produto salvo com sucesso!',
    'state' => $resultado
];

echo json_encode($response);
?>
