<?php

include_once 'includes/navbar.php';
?>
<section>
    <h1>Bem-vindo ao Novo Sistema!</h1>
    <p>A estrutura inicial foi carregada com sucesso.</p>
</section>

<?php
include_once 'includes/footer.php';
?>
<?php
// Inicia a conexão com o banco de dados e carrega funções
require_once 'config/conn.php';
// require_once 'includes/functions.php'; // Descomente quando criar este arquivo

// Inclui o topo do site (Header e Nav)
include_once 'includes/navbar.php';
?>

<!-- O miolo do site começa aqui -->
<main>
    <?php
    // O roteador vai analisar a URL e carregar a página interna aqui dentro!
    require_once 'config/router.php';
    ?>
</main>
<!-- O miolo do site termina aqui -->

<?php
// Inclui o rodapé
include_once 'includes/footer.php';
?>