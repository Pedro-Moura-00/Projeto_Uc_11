<?php
// Verifica se o formulário foi enviado através do método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe e limpa os dados digitados
    $nome = htmlspecialchars($_POST['nome']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    // Verifica se os campos não estão vazios
    if (!empty($nome) && !empty($email) && !empty($senha)) {
        
        // Criptografa a senha de forma irreversível e segura
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        try {
            // Prepara a query SQL para inserir no banco
            // Os "?" são os placeholders de segurança do PDO
            $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            
            // Executa a query substituindo os "?" pelos dados reais
            $stmt->execute([$nome, $email, $senha_hash]);

            echo "<div style='color: green; padding: 10px;'>Usuário cadastrado com sucesso!</div>";
            
        } catch(PDOException $e) {
            // Verifica se o erro é de e-mail duplicado (código 23000 do MySQL)
            if ($e->getCode() == 23000) {
                echo "<div style='color: red; padding: 10px;'>Erro: Este e-mail já está cadastrado.</div>";
            } else {
                echo "<div style='color: red; padding: 10px;'>Erro ao cadastrar: " . $e->getMessage() . "</div>";
            }
        }
    } else {
        echo "<div style='color: orange; padding: 10px;'>Por favor, preencha todos os campos.</div>";
    }
}
?>

<!-- Formulário HTML -->
<h2>Cadastro de Novo Usuário</h2>

<form action="?url=cadastrar" method="POST">
    <div style="margin-bottom: 10px;">
        <label for="nome">Nome Completo:</label><br>
        <input type="text" name="nome" id="nome" required>
    </div>

    <div style="margin-bottom: 10px;">
        <label for="email">E-mail:</label><br>
        <input type="email" name="email" id="email" required>
    </div>

    <div style="margin-bottom: 10px;">
        <label for="senha">Senha:</label><br>
        <input type="password" name="senha" id="senha" required>
    </div>

    <button type="submit">Cadastrar Usuário</button>
</form>