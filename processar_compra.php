<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
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
    die("Erro de conexão: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $metodo_pagamento = $_POST['metodo_pagamento'] ?? '';
    $carrinho = $_SESSION['carrinho'] ?? [];
    
    if (empty($carrinho)) {
        $_SESSION['error'] = "Carrinho vazio!";
        header("Location: carrinho.php");
        exit;
    }
    
    if (empty($metodo_pagamento)) {
        $_SESSION['error'] = "Selecione um método de pagamento!";
        header("Location: carrinho.php");
        exit;
    }
    
    try {
        $pdo->beginTransaction();
        
        // Calcular total
        $total = 0;
        foreach ($carrinho as $item) {
            $total += $item['preco'];
        }
        
        // 1. Criar registro da venda
        $stmt_venda = $pdo->prepare("
            INSERT INTO vendas (usuario_id, total, metodo_pagamento, data_conclusao) 
            VALUES (?, ?, ?, NOW())
        ");
        $stmt_venda->execute([$_SESSION['user_id'], $total, $metodo_pagamento]);
        $venda_id = $pdo->lastInsertId();
        
        // 2. Registrar itens da venda e adicionar à biblioteca
        foreach ($carrinho as $item) {
            // Registrar item na venda
            $stmt_item = $pdo->prepare("
                INSERT INTO itens_venda (venda_id, jogo_id, preco) 
                VALUES (?, ?, ?)
            ");
            $stmt_item->execute([$venda_id, $item['id'], $item['preco']]);
            
            // Verificar se já está na biblioteca
            $stmt_check = $pdo->prepare("
                SELECT id FROM biblioteca 
                WHERE usuario_id = ? AND jogo_id = ?
            ");
            $stmt_check->execute([$_SESSION['user_id'], $item['id']]);
            
            if (!$stmt_check->fetch()) {
                // Adicionar à biblioteca vinculando à venda
                $stmt_biblioteca = $pdo->prepare("
                    INSERT INTO biblioteca (usuario_id, jogo_id, venda_id, data_aquisicao) 
                    VALUES (?, ?, ?, NOW())
                ");
                $stmt_biblioteca->execute([$_SESSION['user_id'], $item['id'], $venda_id]);
            }
        }
        
        $pdo->commit();
        
        // Limpar carrinho e redirecionar com sucesso
        $_SESSION['carrinho'] = [];
        $_SESSION['success'] = "Compra realizada com sucesso! Venda #" . $venda_id;
        header("Location: biblioteca.php");
        exit;
        
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Erro ao processar compra: " . $e->getMessage();
        header("Location: carrinho.php");
        exit;
    }
} else {
    header("Location: carrinho.php");
    exit;
}