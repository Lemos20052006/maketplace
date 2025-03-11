<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // Verifica se o e-mail já está cadastrado
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        $erro = "E-mail já cadastrado!";
    } else {
        // Insere novo usuário
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, 'cliente')");
        if ($stmt->execute([$nome, $email, $senha])) {
            header("Location: login.php?cadastro_sucesso=1");
            exit;
        } else {
            $erro = "Erro ao cadastrar. Tente novamente!";
        }
    }
}
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Cadastro</h2>
    <form method="POST" class="mx-auto col-md-6 bg-light p-4 rounded shadow">
        <?php if (!empty($erro)) echo "<p class='alert alert-danger'>$erro</p>"; ?>
        <input type="text" name="nome" class="form-control mb-3" placeholder="Nome" required>
        <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
        <input type="password" name="senha" class="form-control mb-3" placeholder="Senha" required>
        <button type="submit" class="btn btn-success w-100">Cadastrar</button>
        <p class="mt-3 text-center"><a href="login.php">Já tem conta? Faça login</a></p>
    </form>
</div>

<?php include 'footer.php'; ?>