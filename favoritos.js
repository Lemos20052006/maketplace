document.addEventListener("DOMContentLoaded", function () {
    const botaoFavoritar = document.getElementById("favoritar");
    
    if (botaoFavoritar) {
        const produtoId = botaoFavoritar.getAttribute("data-id");
        let favoritos = JSON.parse(localStorage.getItem("favoritos")) || [];

        // Atualiza o botão se o produto já for favorito
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