<?php
include 'database.php'; // Garante a conexão com o banco

// Verifica se há IDs na requisição
if (!isset($_GET['ids']) || empty($_GET['ids'])) {
    echo "<p class='text-muted text-center'>Nenhum favorito encontrado.</p>";
    exit;
}

// Converte os IDs para um array seguro
$ids = explode(',', $_GET['ids']);
$ids = array_filter(array_map('intval', $ids)); // Garante que sejam números inteiros

if (empty($ids)) {
    echo "<p class='text-muted text-center'>Nenhum favorito encontrado.</p>";
    exit;
}

// Prepara a query de forma segura com placeholders
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$query = "SELECT id, nome, imagem, preco FROM produtos WHERE id IN ($placeholders)";
$stmt = $pdo->prepare($query);
$stmt->execute($ids);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($result) {
    foreach ($result as $row) {
        echo "<div class='col-md-4 mb-3' id='produto-{$row['id']}'>
                <div class='card h-100 shadow-sm'>
                    <img src='{$row['imagem']}' class='card-img-top' alt='{$row['nome']}' style='max-height: 200px; object-fit: cover;'>
                    <div class='card-body text-center'>
                        <h5 class='card-title'>{$row['nome']}</h5>
                        <p class='card-text text-success fw-bold'>R$ " . number_format($row['preco'], 2, ',', '.') . "</p>
                        <button class='btn btn-danger btn-sm btn-remover' data-id='{$row['id']}'>❌ Remover</button>
                    </div>
                </div>
              </div>";
    }
} else {
    echo "<p class='text-muted text-center'>Nenhum produto encontrado.</p>";
}
?>