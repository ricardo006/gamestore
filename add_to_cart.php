<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jogo_id = $_POST['jogo_id'] ?? null;
    $jogo_titulo = $_POST['jogo_titulo'] ?? '';
    $jogo_preco = $_POST['jogo_preco'] ?? 0;
    $jogo_imagem = $_POST['jogo_imagem'] ?? '';
    
    if ($jogo_id) {
        // Inicializar carrinho se não existir
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }
        
        // Verificar se o jogo já está no carrinho
        $item_existente = false;
        foreach ($_SESSION['carrinho'] as &$item) {
            if ($item['id'] == $jogo_id) {
                $item_existente = true;
                break;
            }
        }
        
        if (!$item_existente) {
            // Adicionar ao carrinho
            $_SESSION['carrinho'][] = [
                'id' => $jogo_id,
                'titulo' => $jogo_titulo,
                'preco' => $jogo_preco,
                'imagem' => $jogo_imagem
            ];
        }
        
        echo json_encode([
            'success' => true,
            'jogo_titulo' => $jogo_titulo,
            'cart_count' => count($_SESSION['carrinho'])
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'ID do jogo não fornecido']);
    }
} else {
    header("Location: index.php");
    exit;
}
?>