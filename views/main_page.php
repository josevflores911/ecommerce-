<?php
session_start();

// Validar e sanitizar dados recebidos
$produtos = $_POST['produtos'] ?? [];
if (!is_array($produtos)) {
    $produtos = [];
}

$id = $_POST['id_user'] ?? '';
$id = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Produtos em Estoque</title>
    <link rel="stylesheet" href="./assets/style/main_page.css">
    <link rel="stylesheet" href="./assets/style/general.css">
    <script src="./scripts/main_page.js?v=1.10" defer></script>
</head>
<body class="dark-theme">

    <input type="hidden" class="user_id" name="user_id" value="<?php echo $id; ?>">

    <header role="banner" class="main-header">
        <button id="toggleSidebar" class="sidebar-btn"><i class="fa fa-bars"></i></button>
        <h1>Estoque</h1>
        <div class="header-right">
            <button class="confirmar-btn" aria-label="Confirmar compra">
                <i class="fa fa-cart-arrow-down"></i>
                <span class="cart-count" style="display: none;">0</span>
            </button>

            <span class="user-name"><?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?></span>
            <div class="settings-wrapper">
                <button id="settingsToggle" class="settings-btn" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-gear"></i>
                </button>
                <div class="settings-menu" id="settingsMenu" role="menu" aria-label="Configurações">
                    <ul>
                        <li><a href="#" role="menuitem">Perfil</a></li>
                        <li><a href="#" class="btnLogout" role="menuitem">Sair</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <nav role="navigation" class="sidebar" id="sidebar">
        <ul>
            <li><a href="#" id="sltPrincipal"><i class="fa fa-home"></i> Principal</a></li>
            <li><a href="#" id="sltDashboard"><i class="fa fa-chart-bar"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-box"></i> Meus Pedidos</a></li>
            <li><a href="#" class="btnLogout"><i class="fa fa-sign-out"></i> Sair</a></li>
        </ul>
    </nav>

    <main role="main" class="content-area">
    </main>

</body>
</html>
