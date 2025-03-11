<?php
include 'database.php';
include 'header.php';
?>

<div class="container mt-5">
    <h2 class="text-center"><i class="bi bi-star-fill text-warning"></i> Produtos em Destaque</h2>
    <div class="row">
        <?php
        $produtos = [
            ["Samsung Galaxy A14", "1199.00", "img/galaxy_a14.jpg"],
            ["Notebook Lenovo IdeaPad 3", "2899.00", "img/ideapad_3.jpg"],
            ["Mouse Gamer Redragon Cobra", "149.90", "img/mouse_redragon.jpg"],
            ["Teclado Mecânico HyperX Alloy Origins", "499.90", "img/teclado_hyperx.jpg"],
            ["Fone de Ouvido JBL Tune 510BT", "229.00", "img/fone_jbl.jpg"],
            ["Monitor Gamer LG UltraGear 24” 144Hz", "1299.00", "img/monitor_lg.jpg"],
            ["Cadeira Gamer ThunderX3", "1199.00", "img/cadeira_thunderx3.jpg"],
            ["Console PlayStation 5 Slim", "3999.00", "img/ps5.jpg"]
        ];

        foreach ($produtos as $produto) {
            $stmt = $pdo->prepare("SELECT id FROM produtos WHERE nome = ?");
            $stmt->execute([$produto[0]]);
            if (!$stmt->fetch()) {
                $stmt = $pdo->prepare("INSERT INTO produtos (nome, preco, imagem) VALUES (?, ?, ?)");
                $stmt->execute([$produto[0], $produto[1], $produto[2]]);
            }
        }

        $stmt = $pdo->query("SELECT * FROM produtos ORDER BY criado_em DESC LIMIT 8");
        while ($produto = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <div class="col-md-3">
                <div class="card shadow-sm mb-4">
                    <img src="<?php echo $produto['imagem']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo htmlspecialchars($produto['nome']); ?></h5>
                        <p class="card-text"><strong>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></strong></p>
                        <a href="single-product.php?id=<?php echo $produto['id']; ?>" class="btn btn-primary btn-sm">Ver Detalhes</a>
                        <a href="cart.php?add=<?php echo $produto['id']; ?>" class="btn btn-success btn-sm"><i class="bi bi-cart-plus"></i> Adicionar</a>
                        <button class="btn btn-warning btn-sm favoritar" data-id="<?php echo $produto['id']; ?>"><i class="bi bi-star"></i> Favoritar</button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let favoritos = JSON.parse(localStorage.getItem("favoritos")) || [];
    
    document.querySelectorAll(".favoritar").forEach(botao => {
        let id = parseInt(botao.getAttribute("data-id")); // Garante que seja um número
        
        if (favoritos.includes(id)) {
            botao.innerHTML = "<i class='bi bi-star-fill'></i> Favoritado";
            botao.classList.add("btn-dark");
        }

        botao.addEventListener("click", function () {
            if (favoritos.includes(id)) {
                favoritos = favoritos.filter(fav => fav !== id);
                botao.innerHTML = "<i class='bi bi-star'></i> Favoritar";
                botao.classList.remove("btn-dark");
            } else {
                favoritos.push(id);
                botao.innerHTML = "<i class='bi bi-star-fill'></i> Favoritado";
                botao.classList.add("btn-dark");
            }
            localStorage.setItem("favoritos", JSON.stringify(favoritos));
        });
    });
});
</script>

<?php include 'footer.php'; ?>