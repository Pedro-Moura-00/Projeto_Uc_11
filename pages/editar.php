<?php
// 1. Verifica se o ID foi passado na URL
if (!isset($_GET['id'])) {
    die("<div style='color: red;'>ID do usuário não fornecido.</div>");
}

$id = $_GET['id'];

// 2. Se o formulário foi enviado (Ação de Atualizar)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = htmlspecialchars($_POST['nome']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    if (!empty($nome) && !empty($email)) {
        try {
            // Se o campo de senha NÃO estiver vazio, atualiza a senha também
            if (!empty($senha)) {
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$nome, $email, $senha_hash, $id]);
            } else {
                // Se estiver vazio, atualiza apenas nome e email
                $sql = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$nome, $email, $id]);
            }
            echo "<div style='color: green; padding: 10px;'>Usuário atualizado com sucesso!</div>";
        } catch(PDOException $e) {
            echo "<div style='color: red; padding: 10px;'>Erro ao atualizar: " . $e->getMessage() . "</div>";
        }
    } else {
        echo "<div style='color: orange; padding: 10px;'>Nome e E-mail são obrigatórios.</div>";
    }
}

// 3. Busca os dados atuais do usuário para preencher o formulário
try {
    $sql = "SELECT nome, email FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        die("<div style='color: red;'>Usuário não encontrado.</div>");
    }
} catch(PDOException $e) {
    die("<div style='color: red;'>Erro ao buscar dados: " . $e->getMessage() . "</div>");
}
?>

<!-- Formulário HTML preenchido com os dados do PHP -->
<h2>Editar Usuário</h2>

<form action="?url=editar&id=<?= $id ?>" method="POST">
    <div style="margin-bottom: 10px;">
        <label for="nome">Nome Completo:</label><br>
        <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
    </div>

    <div style="margin-bottom: 10px;">
        <label for="email">E-mail:</label><br>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
    </div>

    <div style="margin-bottom: 10px;">
        <label for="senha">Nova Senha:</label><br>
        <input type="password" name="senha" id="senha" placeholder="Deixe em branco para manter a atual">
    </div>

    <button type="submit">Atualizar Usuário</button>
    <a href="?url=listar" style="margin-left: 15px; text-decoration: none; color: blue;">Voltar para a Lista</a>
</form>