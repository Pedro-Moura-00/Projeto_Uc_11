<?php
// 1. Pega o que foi digitado na URL. Se estiver vazio, define 'home' como padrão.
$url = isset($_GET['url']) ? $_GET['url'] : 'home';

// 2. Remove barras extras no final (ex: site.com/sobre/ vira site.com/sobre)
$url = rtrim($url, '/');

// 3. Segurança: Limpa a URL para evitar tentativas de invasão (Directory Traversal)
$url = filter_var($url, FILTER_SANITIZE_URL);

// 4. Monta o caminho de onde o arquivo deveria estar
$caminho_arquivo = "pages/" . $url . ".php";

// 5. Verifica se o arquivo físico realmente existe na pasta 'pages'
if (file_exists($caminho_arquivo)) {
    // Se existir, carrega a página na tela
    include_once $caminho_arquivo;
} else {
    // Se não existir, mostra um erro 404 (Página não encontrada)
    echo "<div style='text-align: center; padding: 50px;'>";
    echo "<h2>Erro 404</h2>";
    echo "<p>A página que você está procurando não existe.</p>";
    echo "</div>";
}
?>