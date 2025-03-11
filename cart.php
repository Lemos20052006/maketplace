<?php
include 'database.php';
include 'header.php';

// Certifica-se de que a sessão está ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inicializa o carrinho se ainda não estiver definido
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Adicionar item ao carrinho
if (isset($_GET['add'])) {
    $id = (int) $_GET['add'];
    if (!isset($_SESSION['carrinho'][$id])) {
        $_SESSION['carrinho'][$id] = 1;
    } else {
        $_SESSION['carrinho'][$id]++;
    }
    header("Location: cart.php");
    exit();
}

// Remover item do carrinho
if (isset($_GET['remove'])) {
    $id = (int) $_GET['remove'];
    if (isset($_SESSION['carrinho'][$id])) {
        $_SESSION['carrinho'][$id]--;
        if ($_SESSION['carrinho'][$id] <= 0) {
            unset($_SESSION['carrinho'][$id]);
        }
    }
    header("Location: cart.php");
    exit();
}

$total = 0;
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">🛒 Meu Carrinho</h2>

    <?php if (empty($_SESSION['carrinho'])) : ?>
        <div class="alert alert-warning text-center" role="alert">
            Seu carrinho está vazio. <a href="index.php" class="alert-link">Voltar às compras</a>.
        </div>
    <?php else : ?>
        <div class="table-responsive">
            <table class="table table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Total</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($_SESSION['carrinho'] as $id => $quantidade) {
                        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
                        $stmt->execute([$id]);
                        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($produto) {
                            $subtotal = $produto['preco'] * $quantidade;
                            $total += $subtotal;
                    ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo htmlspecialchars($produto['imagem']); ?>" alt="Imagem do produto" class="img-thumbnail me-2" style="width: 50px; height: 50px;">
                                        <?php echo htmlspecialchars($produto['nome']); ?>
                                    </div>
                                </td>
                                <td><?php echo $quantidade; ?></td>
                                <td><strong>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></strong></td>
                                <td><strong>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></strong></td>
                                <td>
                                    <a href="cart.php?add=<?php echo $produto['id']; ?>" class="btn btn-success btn-sm">+</a>
                                    <a href="cart.php?remove=<?php echo $produto['id']; ?>" class="btn btn-danger btn-sm">-</a>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
            <h4>Total: <span class="text-success">R$ <?php echo number_format($total, 2, ',', '.'); ?></span></h4>
            <a href="checkout.php" class="btn btn-primary">🛍️ Finalizar Compra</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>