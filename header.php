<?php
// Iniciar sessão apenas se ainda não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace</title>
    
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Marketplace</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Carrinho</a></li>
                    <li class="nav-item"><a class="nav-link" href="pedidos.php">Meus Pedidos</a></li>
                    <li class="nav-item"><a class="nav-link" href="favoritos.php"><i class="bi bi-star-fill text-warning"></i> Favoritos</a></li>
                    
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Sair</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
                
                <!-- Barra de Pesquisa -->
                <form class="d-flex ms-3" action="pesquisa.php" method="GET">
                    <input class="form-control me-2" type="search" name="q" placeholder="Buscar produtos..." aria-label="Pesquisar" required>
                    <button class="btn btn-light" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>