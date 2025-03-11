<?php
include 'database.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $senha = trim($_POST['senha']);

    if ($email && $senha) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario'] = $usuario;
            header("Location: index.php");
            exit;
        } else {
            $erro = "E-mail ou senha incorretos!";
        }
    } else {
        $erro = "Preencha todos os campos corretamente!";
    }
}
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Login</h2>
    <form method="POST" class="mx-auto col-md-6 bg-light p-4 rounded shadow">
        <?php if (!empty($erro)) : ?>
            <div class='alert alert-danger'><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <?php if (!empty($_GET['cadastro_sucesso'])) : ?>
            <div class='alert alert-success'>Cadastro realizado! Faça login.</div>
        <?php endif; ?>

        <input type="email" name="email" class="form-control mb-3" placeholder="E-mail" required>
        <input type="password" name="senha" class="form-control mb-3" placeholder="Senha" required>
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
        <p class="mt-3 text-center"><a href="cadastro.php">Criar uma conta</a></p>
    </form>
</div>

<?php include 'footer.php'; ?>