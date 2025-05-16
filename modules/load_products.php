<?php

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
        'produtos'=> $produtos
    ];

    echo json_encode($response);


?>
