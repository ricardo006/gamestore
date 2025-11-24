<?php
// test_connection.php
echo "<h2>Teste de Conexão MySQL</h2>";

$host = "localhost";
$username = "root";
$password = "";

// Testar conexão básica
try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Conectado ao MySQL com sucesso!<br>";
    
    // Verificar se o banco existe
    $stmt = $pdo->query("SHOW DATABASES LIKE 'gamestore'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Banco 'gamestore' existe!<br>";
        
        // Verificar tabela
        $pdo2 = new PDO("mysql:host=$host;dbname=gamestore", $username, $password);
        $stmt2 = $pdo2->query("SHOW TABLES LIKE 'usuarios'");
        if ($stmt2->rowCount() > 0) {
            echo "✅ Tabela 'usuarios' existe!<br>";
        } else {
            echo "❌ Tabela 'usuarios' NÃO existe.<br>";
        }
    } else {
        echo "❌ Banco 'gamestore' NÃO existe.<br>";
    }
    
} catch(PDOException $e) {
    echo "❌ Erro de conexão: " . $e->getMessage() . "<br>";
    echo "<h3>Possíveis soluções:</h3>";
    echo "1. Verifique se o MySQL está rodando no XAMPP<br>";
    echo "2. Verifique se a senha está correta (vazia neste caso)<br>";
    echo "3. Verifique se o usuário 'root' tem acesso<br>";
}
?>