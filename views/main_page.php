<?php
session_start();
$produtos = $_POST['produtos'];
?>

<head>
    <meta charset="UTF-8">
    <title>Produtos em Estoque</title>
    <link rel="stylesheet" href="./assets/style/main_page.css">
    <script src="./scripts/main_page.js?v=1.10" defer></script>
</head>

<body class="dark-theme">


    <header class="main-header">
        <button id="toggleSidebar" class="sidebar-btn"><i class="fa fa-bars"></i></button>
        <h1>Estoque</h1>
        <div class="header-right">

            <button class="confirmar-btn"><i class="fa fa-cart-arrow-down"></i></button>

            <span class="user-name"><?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Visitante' ?></span>
            <div class="settings-wrapper">
                <button id="settingsToggle" class="settings-btn"><i class="fa fa-gear"></i></button>
                <div class="settings-menu" id="settingsMenu">
                    <ul>
                        <li><a href="#">Perfil</a></li>
                        <li><a href="#" id="btnLogout">Sair</a></li>
                    </ul>
                </div>
            </div>
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
    </main>

    <script>
            const toggle = document.getElementById("toggleSidebar");
            const sidebar = document.getElementById("sidebar");

            toggle.addEventListener("click", () => {
                sidebar.classList.toggle("show");
            });

    </script>

</body>