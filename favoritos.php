<?php
// Inicia a sessão apenas se ainda não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'header.php'; // Inclui o cabeçalho
?>

<div class="container mt-5">
    <h2 class="text-primary text-center mb-4">Meus Favoritos ❤️</h2>

    <div id="lista-favoritos" class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col text-center">
            <p class="text-muted">Carregando favoritos...</p>
        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let favoritos = JSON.parse(localStorage.getItem("favoritos")) || [];
    let listaFavoritos = document.getElementById("lista-favoritos");

    if (favoritos.length === 0) {
        listaFavoritos.innerHTML = "<p class='text-muted text-center'>Nenhum produto favoritado.</p>";
        return;
    }

    fetch("get_favoritos.php?ids=" + favoritos.join(","))
        .then(response => response.text())
        .then(data => {
            listaFavoritos.innerHTML = data;
            ativarBotoesRemover();
        });
});

function ativarBotoesRemover() {
    document.querySelectorAll(".btn-remover").forEach(botao => {
        botao.addEventListener("click", function () {
            let id = parseInt(this.getAttribute("data-id"));
            removerFavorito(id);
        });
    });
}

function removerFavorito(id) {
    let favoritos = JSON.parse(localStorage.getItem("favoritos")) || [];

    favoritos = favoritos.filter(produtoId => produtoId !== id);

    localStorage.setItem("favoritos", JSON.stringify(favoritos));

    document.getElementById(`produto-${id}`).remove();

    if (favoritos.length === 0) {
        document.getElementById("lista-favoritos").innerHTML = "<p class='text-muted text-center'>Nenhum produto favoritado.</p>";
    }
}
</script>
<?php include 'footer.php'; // Inclui o rodapé ?>