<?php
// Busca todos os usuários no banco de dados, ordenando do mais recente para o mais antigo
try {
    $sql = "SELECT id, nome, email, data_cadastro FROM usuarios ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Transforma os resultados em um array associativo
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("<div style='color: red;'>Erro ao buscar usuários: " . $e->getMessage() . "</div>");
}
?>

<h2>Lista de Usuários Cadastrados</h2>

<!-- Tabela simples para exibir os dados -->
<table border="1" style="width: 100%; border-collapse: collapse; text-align: left;">
    <thead>
       
    </thead>
    <tbody>
        <?php if (count($usuarios) > 0): ?>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td style="padding: 10px;"><?= $usuario['id'] ?></td>
                    <td style="padding: 10px;"><?= htmlspecialchars($usuario['nome']) ?></td>
                    <td style="padding: 10px;"><?= htmlspecialchars($usuario['email']) ?></td>
                    <td style="padding: 10px;"><?= date('d/m/Y H:i', strtotime($usuario['data_cadastro'])) ?></td>
                    <td style="padding: 10px;">
                        <!-- Estes botões ainda não funcionam, faremos na próxima etapa -->
                        <a href="?url=editar&id=<?= $usuario['id'] ?>" style="color: blue;">Editar</a> | 
                        <a href="?url=deletar&id=<?= $usuario['id'] ?>" style="color: red;">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" style="padding: 10px; text-align: center;">Nenhum usuário cadastrado ainda.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>