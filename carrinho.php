<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

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

// Processar remoção do carrinho
if (isset($_GET['remover'])) {
    $jogo_id = $_GET['remover'];
    if (isset($_SESSION['carrinho'])) {
        foreach ($_SESSION['carrinho'] as $key => $item) {
            if ($item['id'] == $jogo_id) {
                unset($_SESSION['carrinho'][$key]);
                break;
            }
        }
        $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
    }
    header("Location: carrinho.php");
    exit;
}

// Buscar métodos de pagamento
$stmt_metodos = $pdo->query("SELECT * FROM metodos_pagamento WHERE ativo = 1");
$metodos_pagamento = $stmt_metodos->fetchAll(PDO::FETCH_ASSOC);

$carrinho = $_SESSION['carrinho'] ?? [];
$total = 0;
foreach ($carrinho as $item) {
    $total += $item['preco'];
}

// Mensagens de sucesso/erro
$success_msg = $_SESSION['success'] ?? '';
$error_msg = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Meu Carrinho - Games Store</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        .cart-count {
            background: #ff4444;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            position: absolute;
            top: -8px;
            right: -8px;
        }
        
        .cart-layout {
            display: flex;
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 80px auto;
        }
        
        .cart-left {
            flex: 2;
        }
        
        .cart-right {
            flex: 1;
        }
        
        .cart-item {
            display: flex;
            align-items: center;
            background: var(--bg-medium);
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            transition: transform 0.2s;
        }
        
        .cart-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .cart-item img {
            width: 100px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 15px;
        }
        
        .cart-info {
            flex: 1;
        }
        
        .cart-info h3 {
            margin: 0 0 5px 0;
            color: var(--text-primary);
        }
        
        .cart-price {
            font-weight: bold;
            margin-right: 15px;
            color: var(--text-primary);
            font-size: 1.1em;
        }
        
        .remove-btn {
            background: #ff4444;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 16px;
            min-width: 40px;
            min-height: 40px;
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        
        .remove-btn:hover {
            background: #cc0000;
        }
        
        .summary-box {
            background: var(--bg-medium);
            padding: 20px;
            border-radius: 20px;
            position: sticky;
            top: 20px;
        }
        
        .checkout-btn {
            background: var(--text-primary);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            width: 100%;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 15px;
            transition: background 0.3s;
        }
        
        .checkout-btn:hover {
            background: var(--hover-color);
        }
        
        .checkout-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        
        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
        
        .empty-cart i {
            font-size: 80px;
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            border-left: 4px solid;
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            border-left-color: #28a745;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            border-left-color: #dc3545;
        }
        
        .payment-methods {
            margin: 20px 0;
        }
        
        .payment-method {
            display: flex;
            align-items: center;
            padding: 10px;
            margin-bottom: 10px;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .payment-method:hover {
            border-color: var(--text-primary);
        }
        
        .payment-method.selected {
            border-color: var(--text-primary);
            background: rgba(102, 126, 234, 0.1);
        }
        
        .payment-method input {
            margin-right: 10px;
        }
        
        .payment-icon {
            font-size: 24px;
            margin-right: 10px;
            width: 30px;
            text-align: center;
        }
        
        .payment-info {
            flex: 1;
        }
        
        .payment-name {
            font-weight: bold;
            margin: 0;
        }
        
        .payment-desc {
            margin: 0;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <a href="index.php">Games Store</a>
        </div>
        <nav>
            <span style="color: var(--text-primary); margin-right: 15px;">Olá, <?php echo $_SESSION['username']; ?>!</span>
            <a href="perfil.php">Perfil</a>
            <a href="biblioteca.php">Biblioteca</a>
            <a href="carrinho.php" class="cart-icon active" style="position:relative;">
                <i class="fas fa-shopping-cart"></i>
                <?php if (count($carrinho) > 0): ?>
                    <span class="cart-count"><?php echo count($carrinho); ?></span>
                <?php endif; ?>
            </a>
            <a href="logout.php">Sair</a>
        </nav>
    </header>

    <main class="cart-layout">
        <section class="cart-left">
            <h1><i class="fas fa-shopping-cart"></i> Meu Carrinho</h1>
            
            <?php if ($success_msg): ?>
                <div class="message success"><?php echo $success_msg; ?></div>
            <?php endif; ?>
            
            <?php if ($error_msg): ?>
                <div class="message error"><?php echo $error_msg; ?></div>
            <?php endif; ?>
            
            <div id="cart-container" class="cart-container">
                <?php if (count($carrinho) === 0): ?>
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart"></i>
                        <h3>Seu carrinho está vazio</h3>
                        <p>Adicione jogos incríveis à sua coleção!</p>
                        <a href="index.php" class="checkout-btn" style="text-decoration: none; display: inline-block; margin-top: 20px; width: auto; padding: 10px 20px;">
                            Explorar Loja
                        </a>
                    </div>
                <?php else: ?>
                    <?php foreach ($carrinho as $item): ?>
                        <div class="cart-item">
                            <img src="<?php echo htmlspecialchars($item['imagem']); ?>" alt="<?php echo htmlspecialchars($item['titulo']); ?>">
                            <div class="cart-info">
                                <h3><?php echo htmlspecialchars($item['titulo']); ?></h3>
                            </div>
                            <span class="cart-price">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></span>
                            <a href="carrinho.php?remover=<?php echo $item['id']; ?>" class="remove-btn" title="Remover do carrinho">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <?php if (count($carrinho) > 0): ?>
        <aside class="cart-right">
            <div class="summary-box">
                <h2>Resumo da Compra</h2>
                <div id="cart-summary">
                    <p><strong>Itens:</strong> <?php echo count($carrinho); ?></p>
                    <h3>Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></h3>
                </div>
                
                <div class="payment-methods">
                    <h3>Método de Pagamento</h3>
                    <?php foreach ($metodos_pagamento as $metodo): ?>
                        <div class="payment-method" onclick="selectPayment('<?php echo $metodo['nome']; ?>')">
                            <input type="radio" name="metodo_pagamento" value="<?php echo $metodo['nome']; ?>" id="pay-<?php echo $metodo['nome']; ?>" required>
                            <div class="payment-icon">
                                <?php 
                                $icons = [
                                    'cartao_credito' => 'fa-credit-card',
                                    'cartao_debito' => 'fa-credit-card',
                                    'pix' => 'fa-qrcode',
                                    'boleto' => 'fa-barcode'
                                ];
                                $icon = $icons[$metodo['nome']] ?? 'fa-money-bill';
                                ?>
                                <i class="fas <?php echo $icon; ?>"></i>
                            </div>
                            <div class="payment-info">
                                <p class="payment-name">
                                    <?php 
                                    $nomes = [
                                        'cartao_credito' => 'Cartão de Crédito',
                                        'cartao_debito' => 'Cartão de Débito',
                                        'pix' => 'PIX',
                                        'boleto' => 'Boleto Bancário'
                                    ];
                                    echo $nomes[$metodo['nome']] ?? $metodo['nome'];
                                    ?>
                                </p>
                                <p class="payment-desc"><?php echo htmlspecialchars($metodo['descricao']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <form method="POST" action="processar_compra.php" id="checkout-form">
                    <input type="hidden" name="metodo_pagamento" id="selected-payment" required>
                    <button type="submit" class="checkout-btn" id="checkout-btn" disabled>
                        <i class="fas fa-credit-card"></i> Finalizar Compra
                    </button>
                </form>
                
                <p style="text-align: center; margin-top: 10px; font-size: 0.9em; color: #666;">
                    <i class="fas fa-lock"></i> Compra 100% segura
                </p>
            </div>
        </aside>
        <?php endif; ?>
    </main>

    <script>
        function selectPayment(metodo) {
            document.querySelectorAll('.payment-method').forEach(el => {
                el.classList.remove('selected');
            });
            
            const selectedEl = document.querySelector(`input[value="${metodo}"]`).parentElement;
            selectedEl.classList.add('selected');
            
            document.getElementById('selected-payment').value = metodo;
            document.getElementById('checkout-btn').disabled = false;
        }
        
        // Selecionar primeiro método por padrão
        document.addEventListener('DOMContentLoaded', function() {
            const firstPayment = document.querySelector('input[name="metodo_pagamento"]');
            if (firstPayment) {
                selectPayment(firstPayment.value);
            }
        });
        
        // Confirmar remoção
        document.querySelectorAll('.remove-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (!confirm('Tem certeza que deseja remover este jogo do carrinho?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>