<?php
// Verifica se o ID foi passado na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Prepara a query para deletar o usuário específico
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);

        // Redireciona de volta para a lista após deletar
        header("Location: ?url=listar");
        exit; // Para a execução do script aqui

    } catch(PDOException $e) {
        echo "<div style='color: red;'>Erro ao deletar: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<div style='color: orange;'>ID do usuário não fornecido.</div>";
}
?>