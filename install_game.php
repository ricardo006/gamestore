<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Usuário não logado']);
    exit;
}

// Configurações do banco
$host = "localhost";
$dbname = "gamestore";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Erro de conexão: ' . $e->getMessage()]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jogo_id'])) {
    $jogo_id = $_POST['jogo_id'];
    $usuario_id = $_SESSION['user_id'];
    
    try {
        // Atualizar o status de instalação
        $stmt = $pdo->prepare("UPDATE biblioteca SET instalado = 1 WHERE usuario_id = ? AND jogo_id = ?");
        $stmt->execute([$usuario_id, $jogo_id]);
        
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Jogo instalado com sucesso']);
    } catch(PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Erro ao instalar: ' . $e->getMessage()]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
}
?>