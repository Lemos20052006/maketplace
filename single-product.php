<?php
include 'database.php';
include 'header.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT id, nome, descricao, preco, imagem, categoria, especificacoes FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    echo "<div class='container mt-5'><h2 class='text-center text-danger'>Produto não encontrado!</h2></div>";
    include 'footer.php';
    exit();
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <img src="<?php echo htmlspecialchars($produto['imagem']); ?>" class="img-fluid rounded shadow" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
        </div>
        <div class="col-md-6">
            <h2 class="text-primary"><?php echo htmlspecialchars($produto['nome']); ?></h2>
            <p class="text-muted"><strong>Categoria:</strong> <?php echo htmlspecialchars($produto['categoria']); ?></p>
            <h4 class="text-success">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></h4>
            <p class="mt-3"><?php echo nl2br(htmlspecialchars($produto['descricao'])); ?></p>
            <a href="cart.php?add=<?php echo $produto['id']; ?>" class="btn btn-lg btn-success mt-3">Adicionar ao Carrinho</a>

            <!-- Botão de Favoritar -->
            <button class="btn btn-outline-danger mt-3" id="favoritar" data-id="<?php echo $produto['id']; ?>">❤️ Favoritar</button>
        </div>
    </div>

    <hr>

    <h3 class="mt-4">Especificações</h3>
    <div class="border p-3 bg-light rounded">
        <?php echo $produto['especificacoes']; ?>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const botaoFavoritar = document.getElementById("favoritar");

    if (botaoFavoritar) {
        const produtoId = botaoFavoritar.getAttribute("data-id");
        let favoritos = JSON.parse(localStorage.getItem("favoritos")) || [];

        if (favoritos.includes(produtoId)) {
            botaoFavoritar.classList.add("btn-danger");
            botaoFavoritar.textContent = "💔 Remover dos Favoritos";
        }

        botaoFavoritar.addEventListener("click", function () {
            if (favoritos.includes(produtoId)) {
                favoritos = favoritos.filter(id => id !== produtoId);
                botaoFavoritar.classList.remove("btn-danger");
                botaoFavoritar.classList.add("btn-outline-danger");
                botaoFavoritar.textContent = "❤️ Favoritar";
            } else {
                favoritos.push(produtoId);
                botaoFavoritar.classList.add("btn-danger");
                botaoFavoritar.textContent = "💔 Remover dos Favoritos";
            }

            localStorage.setItem("favoritos", JSON.stringify(favoritos));
        });
    }
});
</script>

<?php include 'footer.php'; ?>