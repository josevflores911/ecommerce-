<?php

require_once '../classes/cls_mainpage.php';

    $produto = $_POST['produto'];
    
    $obj = new cls_mainpage();
    // $resultado = $obj->atualizarEstoque();

    $response = [
        'erro' => '0',
        'message' => 'Login realizado com sucesso!',
        'state' =>$resultado
    ];

    echo json_encode($response);


?>