<?php
include 'database.php';
include 'header.php';

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($q == '') {
    $produtos = [];
} else {
    // Busca produtos no banco de dados
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE nome LIKE ? OR descricao LIKE ?");
    $stmt->execute(["%$q%", "%$q%"]);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="container mt-5">
    <h2 class="text-center">Resultados para "<?php echo htmlspecialchars($q); ?>"</h2>

    <?php if (empty($produtos)) : ?>
        <p class="text-muted text-center mt-4">Nenhum produto encontrado.</p>
    <?php else : ?>
        <div class="row mt-4">
            <?php foreach ($produtos as $produto) : ?>
                <div class="col-md-3">
                    <div class="card shadow-sm mb-4">
                        <img src="<?php echo $produto['imagem']; ?>" class="card-img-top" alt="<?php echo $produto['nome']; ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo htmlspecialchars($produto['nome']); ?></h5>
                            <p class="card-text"><strong>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></strong></p>
                            <a href="produto.php?id=<?php echo $produto['id']; ?>" class="btn btn-primary btn-sm">Ver Detalhes</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>