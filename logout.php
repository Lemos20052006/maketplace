<?php
session_start(); // Inicia a sessão

// Destroi todas as sessões ativas
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - Saiu da Conta</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100" style="background-color: #f8f9fa;">
    <div class="text-center">
        <h2 class="mb-3">Você saiu da sua conta</h2>
        <p class="text-muted">Se deseja acessar outra conta, clique no botão abaixo.</p>
        <a href="login.php" class="btn btn-primary btn-lg">
            <i class="bi bi-box-arrow-in-right"></i> Entrar com outra conta
        </a>
    </div>
</body>
</html>