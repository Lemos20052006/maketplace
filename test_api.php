<?php
function buscarEspecificacoesOnline($produto_nome)
{
    $produto_nome = urlencode($produto_nome);
    $url = "https://api.mercadolibre.com/sites/MLB/search?q=$produto_nome&limit=1"; 

    $response = file_get_contents($url);
    if (!$response) {
        return "Erro ao buscar especificações online.";
    }

    $data = json_decode($response, true);
    if (empty($data['results'][0]['id'])) {
        return "Nenhum produto encontrado na API.";
    }

    // Obtendo ID do produto
    $produto_id = $data['results'][0]['id'];
    $url_detalhes = "https://api.mercadolibre.com/items/$produto_id";

    $response_detalhes = file_get_contents($url_detalhes);
    if (!$response_detalhes) {
        return "Erro ao obter detalhes do produto.";
    }

    $detalhes = json_decode($response_detalhes, true);
    if (empty($detalhes['attributes'])) {
        return "Nenhuma especificação disponível.";
    }

    // Formatando especificações
    $especificacoes = "<ul>";
    foreach ($detalhes['attributes'] as $attr) {
        if (!empty($attr['name']) && !empty($attr['value_name'])) {
            $especificacoes .= "<li><strong>" . htmlspecialchars($attr['name']) . ":</strong> " . htmlspecialchars($attr['value_name']) . "</li>";
        }
    }
    $especificacoes .= "</ul>";

    return $especificacoes;
}

// Teste com um produto específico
$produto_nome = "Samsung Galaxy A14";
$especificacoes = buscarEspecificacoesOnline($produto_nome);
echo $especificacoes;
?>