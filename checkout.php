<?php
include 'database.php';
include 'header.php';

// Certifica-se de que a sessão está ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inicializa o total da compra
$total = 0;
?>

<div class="container mt-5">
    <h2 class="text-center">Finalizar Compra</h2>
    <div class="row">
        <div class="col-md-6">
            <h4>Detalhes do Pedido</h4>

            <?php if (!empty($_SESSION['carrinho'])) : ?>
                <ul class="list-group">
                    <?php
                    foreach ($_SESSION['carrinho'] as $id => $quantidade) {
                        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
                        $stmt->execute([$id]);
                        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($produto) {
                            $subtotal = $produto['preco'] * $quantidade;
                            $total += $subtotal;
                    ?>
                            <li class="list-group-item d-flex align-items-center">
                                <img src="<?php echo htmlspecialchars($produto['imagem']); ?>" alt="Imagem do produto" class="img-thumbnail me-3" style="width: 80px; height: 80px;">
                                <div>
                                    <strong><?php echo htmlspecialchars($produto['nome']); ?></strong>
                                    <p class="mb-0">Preço: R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                                    <p class="mb-0">Quantidade: <?php echo $quantidade; ?></p>
                                </div>
                                <span class="ms-auto badge bg-primary fs-6">R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></span>
                            </li>
                    <?php
                        }
                    }
                    ?>
                </ul>
                <h4 class="mt-3">Total: <span class="text-success">R$ <?php echo number_format($total, 2, ',', '.'); ?></span></h4>
            <?php else : ?>
                <div class="alert alert-warning text-center" role="alert">
                    Seu carrinho está vazio. <a href="index.php" class="alert-link">Voltar às compras</a>.
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <h4>Informações de Pagamento</h4>
            <form action="pagamento.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Nome Completo</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Método de Pagamento</label>
                    <select name="metodo_pagamento" class="form-select" required>
                        <option value="pix">PIX</option>
                        <option value="boleto">Boleto</option>
                        <option value="cartao">Cartão de Crédito</option>
                    </select>
                </div>
                <input type="hidden" name="total" value="<?php echo $total; ?>">
                <button type="submit" class="btn btn-success w-100">Pagar Agora</button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>