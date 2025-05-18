<?php
session_start();
$produtos = $_POST['produtos'];
?>

<head>
    <meta charset="UTF-8">
    <title>Produtos em Estoque</title>
    <link rel="stylesheet" href="./assets/style/buy_page.css">
    <script src="./scripts/buy_page.js?v=1.10" defer></script>
</head>

<div class='contenido'>
    <div style="width: 60%;margin-right:30px;">
        <section class="cards-section">
            <h2>Produtos Disponíveis</h2>
            <div class="card-container">
                <?php if (count($produtos) > 0): ?>
    
                    <?php foreach ($produtos as $p): ?>
                        <div class="card"
                            data-id="<?= $p['id'] ?>"
                            data-nome="<?= htmlspecialchars($p['nome'], ENT_QUOTES) ?>"
                            data-preco="<?= $p['preco'] ?>"
                            data-quantidade="<?= $p['quantidade'] ?>">
                            <h3><?= htmlspecialchars($p['nome']) ?></h3>
                            <p><strong>Preço:</strong> R$ <?= number_format($p['preco'], 2, ',', '.') ?></p>
                            <p data-role="quantidade"><strong>Qtd:</strong> <?= $p['quantidade'] ?></p>
                            <a href="#" class="button">Comprar</a>
                        </div>
                    <?php endforeach; ?>
    
                <?php else: ?>
                    <p><strong>Nenhum produto disponível em estoque.</strong></p>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <div style="margin-top:70px;">
        <aside class="filter-section">
            <h3>Filtros</h3>
            <input type="text" placeholder="Buscar produto...">
            <br><br>
            <select>
                <option>Ordenar por</option>
                <option>Nome</option>
                <option>Preço</option>
            </select>
        </aside>
        <a href="#" class="button confirmar">Confirmar</a>
    </div>

</div>