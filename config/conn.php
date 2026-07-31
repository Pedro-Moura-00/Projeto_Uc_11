<?php
// Define o caminho absoluto para o arquivo .env
$envPath = __DIR__ . '/../.env';

// Verifica se o arquivo .env existe antes de tentar ler
if (file_exists($envPath)) {
    $env = parse_ini_file($envPath);
    
    $host   = $env['DB_HOST'];
    $user   = $env['DB_USER'];
    $pass   = $env['DB_PASS'];
    $dbname = $env['DB_NAME'];
} else {
    die("Erro: Arquivo .env não encontrado. Verifique a configuração.");
}

// Tenta realizar a conexão usando PDO
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    
    // Configura o PDO para lançar exceções em caso de erro (ótimo para debugar)
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Descomente a linha abaixo apenas uma vez para testar se funcionou:
     //echo "Conexão com o banco de dados realizada com sucesso!"; 
    
} catch(PDOException $e) {
    // Se der erro, a execução para e mostra o problema
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>