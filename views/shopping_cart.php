<?php
session_start();
$produtos = json_decode($_POST['produtos'], true);
$username = $_POST['name_user'] ?? '';
$userid   = $_POST['id_user'] ?? '';
?>

<head>
    <meta charset="UTF-8">
    <title>Resumo da Compra</title>
    <link rel="stylesheet" href="./assets/style/shopping_cart.css">
    <script src="./scripts/shopping_cart.js" defer></script>

    
</head>
<body >
    <div style="margin-top: 300px;">
        <h1>Resumo da Compra de <?= $username ?></h1>
    
        <?php if (!empty($produtos)): ?>
            <?php foreach ($produtos as $p): ?>
                <div class="produto">
                    <strong><?= htmlspecialchars($p['nome']) ?></strong><br>
                    Preço: R$ <?= number_format($p['preco'], 2, ',', '.') ?><br>
                    Quantidade: <?= $p['quantidade'] ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhum produto no carrinho.</p>
        <?php endif; ?>
    
        
        <button id="btnPagar" class="pagar-btn">Pagar</button>    

    </div>
</body>
