<?php
session_start();
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
?>


<head>
    <meta charset="UTF-8">
    <title>Produtos em Estoque</title>
    <link rel="stylesheet" href="./views/mainpage.css">
    <script src="./scripts/main_page.js?v=1.10" defer></script>
</head>
<body class="dark-theme">

<header class="main-header">
    <button id="toggleSidebar" class="sidebar-btn"><i class="fa fa-bars"></i></button>
    <h1>Estoque</h1>
    <div class="header-right">
        <i class='fa fa-cart-arrow-down'></i>
        <span class="user-name"><?= $_SESSION['nm_user'] ?? 'Visitante' ?></span>
        <button class="settings-btn"><i class="fa fa-gear"></i></button>
    </div>
</header>

<aside class="sidebar" id="sidebar">
    <h3>Menu</h3>
    <ul>
        <li><a href="#">Dashboard</a></li>
        <li><a href="#">Meus Pedidos</a></li>
        <li><a href="#">Sair</a></li>
    </ul>
</aside>

<main class="content-area">
    <section class="cards-section">
        <h2>Produtos Disponíveis</h2>
        <div class="card-container">
            <?php if (count($produtos) > 0): ?>
                <?php foreach ($produtos as $p): ?>
                    <div class="card">
                        <h3><?= htmlspecialchars($p['nome']) ?></h3>
                        <p><strong>Preço:</strong> R$ <?= number_format($p['preco'], 2, ',', '.') ?></p>
                        <p><strong>Qtd:</strong> <?= $p['quantidade'] ?></p>
                        <a href="#" class="button">Comprar</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p><strong>Nenhum produto disponível em estoque.</strong></p>
            <?php endif; ?>
        </div>
    </section>

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
</main>

</body>

