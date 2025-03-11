<?php
session_start(); // Garante que a sessão seja iniciada no começo

include 'database.php';
include 'header.php';

// Se o usuário não estiver logado, salva a página atual e redireciona para login
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI']; // Salva a página atual dinamicamente
    header("Location: login.php");
    exit();
}

// Obtém os pedidos do usuário logado
$stmt = $pdo->prepare("SELECT * FROM pedidos WHERE usuario_id = ? ORDER BY criado_em DESC");
$stmt->execute([$_SESSION['usuario_id']]);
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="text-center mb-4"><i class="bi bi-box-seam"></i> Meus Pedidos</h2>

        <?php if (empty($pedidos)) : ?>
            <div class="text-center">
                <i class="bi bi-cart-x fs-1 text-danger"></i>
                <p class="mt-3 fs-5">Você não tem nenhum pedido no momento.</p>
                <a href="index.php" class="btn btn-primary btn-lg">
                    <i class="bi bi-bag-plus"></i> Ir às Compras
                </a>
            </div>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Endereço</th>
                            <th>Forma de Pagamento</th>
                            <th>Total</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pedido) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($pedido['id']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['nome']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['endereco']); ?></td>
                                <td><?php echo ucfirst(htmlspecialchars($pedido['pagamento'])); ?></td>
                                <td><strong>R$ <?php echo number_format($pedido['total'], 2, ',', '.'); ?></strong></td>
                                <td><?php echo date("d/m/Y H:i", strtotime($pedido['criado_em'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>