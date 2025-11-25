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

// Contar itens do carrinho
$cart_count = isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : 0;

// Alternativa se não existir coluna quantidade
$stmt_vendas = $pdo->prepare("
    SELECT 
        v.*, 
        COUNT(iv.id) as total_itens,
        COUNT(iv.id) as total_jogos,  -- Usa a mesma contagem
        u.username
    FROM vendas v 
    LEFT JOIN itens_venda iv ON v.id = iv.venda_id 
    LEFT JOIN usuarios u ON v.usuario_id = u.id
    WHERE v.usuario_id = ? 
    GROUP BY v.id 
    ORDER BY v.data_venda DESC
");
$stmt_vendas->execute([$_SESSION['user_id']]);
$vendas = $stmt_vendas->fetchAll(PDO::FETCH_ASSOC);

// Buscar detalhes para cada venda
foreach ($vendas as &$venda) {
    $stmt_itens = $pdo->prepare("
        SELECT 
            iv.*, 
            j.titulo, 
            j.imagem_url,
            j.categoria,
            j.desenvolvedora
        FROM itens_venda iv 
        JOIN jogos j ON iv.jogo_id = j.id 
        WHERE iv.venda_id = ?
    ");
    $stmt_itens->execute([$venda['id']]);
    $venda['itens'] = $stmt_itens->fetchAll(PDO::FETCH_ASSOC);
}
unset($venda);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Histórico de Compras - Games Store</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        /* Estilos melhorados para a navegação */
        .user-nav {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-divider {
            color: rgba(255,255,255,0.3);
            margin: 0 5px;
        }

        .user-welcome {
            color: var(--text-primary);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-welcome i {
            color: #853fb0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-2px);
        }

        .nav-link.active {
            background: linear-gradient(45deg, #4f219e, #853fb0);
            box-shadow: 0 4px 12px rgba(79, 33, 158, 0.3);
        }

        .cart-icon {
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cart-count {
            background: #ff4757;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7em;
            font-weight: bold;
            position: absolute;
            top: -8px;
            right: -8px;
        }

        .mobile-nav-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5em;
            cursor: pointer;
        }

        .mobile-nav-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: var(--bg-dark);
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            min-width: 200px;
            z-index: 1000;
        }

        .mobile-nav-menu.active {
            display: block;
        }

        .mobile-nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .mobile-nav-link:hover {
            background: rgba(255,255,255,0.1);
        }

        .mobile-nav-link i {
            width: 20px;
            text-align: center;
        }

        /* Responsividade */
        @media (max-width: 968px) {
            .user-welcome span {
                display: none;
            }

            .nav-link span {
                display: none;
            }

            .nav-link {
                padding: 10px;
            }

            .nav-link i {
                font-size: 1.2em;
            }
        }

        @media (max-width: 768px) {
            .desktop-nav {
                display: none;
            }

            .mobile-nav-toggle {
                display: block;
            }

            .user-welcome {
                display: none;
            }
        }

        @media (min-width: 769px) {
            .mobile-nav-menu {
                display: none !important;
            }
        }

        /* Estilos do histórico de compras */
        .purchase-history {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            margin-top: 80px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .page-title {
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .back-button {
            background: #6c757d;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .back-button:hover {
            background: #5a6268;
            transform: translateX(-3px);
            color: white;
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--bg-medium);
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            border-left: 4px solid var(--text-primary);
        }

        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: var(--text-primary);
            margin-bottom: 5px;
        }

        .stat-label {
            color: #dfdcfc;
            font-size: 0.9em;
        }
        
        .purchase-card {
            background: var(--bg-medium);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
            border-left: 6px solid var(--text-primary);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
        }

        .purchase-card:hover {
            transform: translateY(-2px);
        }
        
        .purchase-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .purchase-info {
            flex: 1;
        }
        
        .purchase-id {
            font-weight: bold;
            color: var(--text-primary);
            font-size: 1.1em;
        }
        
        .purchase-date {
            color: #dfdcfc;
            margin-top: 5px;
            display: block;
        }
        
        .purchase-details {
            text-align: right;
        }
        
        .purchase-total {
            font-size: 1.4em;
            font-weight: bold;
            color: var(--text-primary);
            margin-bottom: 8px;
        }
        
        .purchase-method {
            background: var(--text-primary);
            color: #e6dff5;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            display: inline-block;
        }

        .purchase-status {
            background: #28a745;
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.8em;
            margin-left: 8px;
        }
        
        .purchase-items {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 15px;
        }
        
        .purchase-item {
            display: flex;
            align-items: center;
            background: rgba(255,255,255,0.05);
            padding: 15px;
            border-radius: 12px;
            transition: background 0.3s ease;
        }

        .purchase-item:hover {
            background: rgba(255,255,255,0.08);
        }
        
        .purchase-item img {
            width: 60px;
            height: 40px;
            object-fit: cover;
            border-radius: 6px;
            margin-right: 15px;
        }
        
        .purchase-item-info {
            flex: 1;
        }
        
        .purchase-item-title {
            font-size: 0.95em;
            margin: 0 0 5px 0;
            font-weight: 600;
        }
        
        .purchase-item-details {
            font-size: 0.8em;
            color: #dfdcfc;
            margin: 2px 0;
        }
        
        .purchase-item-price {
            font-size: 0.9em;
            color: var(--text-primary);
            margin: 0;
            font-weight: 600;
        }

        .item-actions {
            display: flex;
            gap: 8px;
            margin-top: 8px;
        }

        .action-btn {
            background: rgba(255,255,255,0.1);
            border: none;
            color: #dfdcfc;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.8em;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .action-btn:hover {
            background: var(--text-primary);
            color: white;
        }
        
        .empty-history {
            text-align: center;
            padding: 80px 20px;
            color: #d7ecf0;
            background: var(--bg-medium);
            border-radius: 16px;
            margin-top: 20px;
        }
        
        .empty-history i {
            font-size: 80px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-history h3 {
            margin-bottom: 10px;
            color: var(--text-primary);
        }

        .empty-history p {
            margin-bottom: 25px;
            opacity: 0.8;
        }

        .filters {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .filter-select {
            background: var(--bg-medium);
            border: 1px solid rgba(255,255,255,0.1);
            color: white;
            padding: 8px 15px;
            border-radius: 8px;
            min-width: 150px;
        }

        @media (max-width: 768px) {
            .purchase-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .purchase-details {
                text-align: left;
                width: 100%;
            }
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .stats-cards {
                grid-template-columns: 1fr;
            }
            
            .purchase-items {
                grid-template-columns: 1fr;
            }
        }

        .category-badge {
            background: rgba(79, 33, 158, 0.3);
            color: #b8a9f0;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.7em;
            margin-left: 5px;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <a href="index.php">Games Store</a>
        </div>

        <!-- Navegação Desktop -->
        <nav class="desktop-nav">
            <div class="user-nav">
                <span class="user-welcome">
                    <i class="fas fa-user"></i>
                    <span>Olá, <?php echo mb_convert_case($_SESSION['username'], MB_CASE_TITLE, "UTF-8"); ?>!</span>
                </span>
                
                <span class="nav-divider">|</span>
                
                <a href="perfil.php" class="nav-link">
                    <i class="fas fa-user-cog"></i>
                    <span>Perfil</span>
                </a>
                
                <a href="biblioteca.php" class="nav-link">
                    <i class="fas fa-gamepad"></i>
                    <span>Biblioteca</span>
                </a>
                
                <a href="historico_compras.php" class="nav-link active">
                    <i class="fas fa-history"></i>
                    <span>Compras</span>
                </a>
                
                <a href="carrinho.php" class="nav-link cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Carrinho</span>
                    <?php if ($cart_count > 0): ?>
                        <span class="cart-count"><?php echo $cart_count; ?></span>
                    <?php endif; ?>
                </a>
                
                <a href="logout.php" class="nav-link" style="color: #ff6b6b;">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Sair</span>
                </a>
            </div>
        </nav>

        <!-- Navegação Mobile -->
        <button class="mobile-nav-toggle" id="mobileNavToggle">
            <i class="fas fa-bars"></i>
        </button>

        <div class="mobile-nav-menu" id="mobileNavMenu">
            <div class="user-welcome" style="display: flex; padding: 10px 15px; margin-bottom: 10px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                <i class="fas fa-user"></i>
                <span>Olá, <?php echo $_SESSION['username']; ?>!</span>
            </div>
            
            <a href="perfil.php" class="mobile-nav-link">
                <i class="fas fa-user-cog"></i>
                Perfil
            </a>
            
            <a href="biblioteca.php" class="mobile-nav-link">
                <i class="fas fa-gamepad"></i>
                Biblioteca
            </a>
            
            <a href="historico_compras.php" class="mobile-nav-link">
                <i class="fas fa-history"></i>
                Minhas Compras
            </a>
            
            <a href="carrinho.php" class="mobile-nav-link">
                <i class="fas fa-shopping-cart"></i>
                Carrinho
                <?php if ($cart_count > 0): ?>
                    <span style="background: #ff4757; color: white; padding: 2px 8px; border-radius: 10px; font-size: 0.8em; margin-left: auto;">
                        <?php echo $cart_count; ?>
                    </span>
                <?php endif; ?>
            </a>
            
            <a href="logout.php" class="mobile-nav-link" style="color: #ff6b6b;">
                <i class="fas fa-sign-out-alt"></i>
                Sair
            </a>
        </div>
    </header>

    <main class="purchase-history">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-history"></i> 
                Histórico de Compras
            </h1>
            <a href="index.php" class="back-button">
                <i class="fas fa-arrow-left"></i> Voltar para Loja
            </a>
        </div>

        <!-- Estatísticas -->
        <?php if (count($vendas) > 0): ?>
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-number"><?php echo count($vendas); ?></div>
                <div class="stat-label">Total de Compras</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php 
                    // Calcula total de jogos de forma segura
                    $totalJogos = 0;
                    foreach ($vendas as $venda) {
                        $totalJogos += isset($venda['total_jogos']) ? $venda['total_jogos'] : 0;
                    }
                    echo $totalJogos;
                ?></div>
                <div class="stat-label">Jogos Adquiridos</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">R$ <?php 
                    $totalGasto = 0;
                    foreach ($vendas as $venda) {
                        $totalGasto += isset($venda['total']) ? $venda['total'] : 0;
                    }
                    echo number_format($totalGasto, 2, ',', '.');
                ?></div>
                <div class="stat-label">Total Gasto</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php 
                    // Calcula categorias únicas
                    $categorias = [];
                    foreach ($vendas as $venda) {
                        foreach ($venda['itens'] as $item) {
                            if (isset($item['categoria'])) {
                                $categorias[$item['categoria']] = true;
                            }
                        }
                    }
                    echo count($categorias);
                ?></div>
                <div class="stat-label">Categorias</div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Filtros -->
        <?php if (count($vendas) > 0): ?>
        <div class="filters">
            <select class="filter-select" onchange="filterPurchases(this.value)">
                <option value="all">Todas as Compras</option>
                <option value="recent">Últimos 30 dias</option>
                <option value="high-value">Maiores Valores</option>
            </select>
            
            <select class="filter-select" onchange="filterByMethod(this.value)">
                <option value="all">Todos os Métodos</option>
                <option value="cartao_credito">Cartão de Crédito</option>
                <option value="pix">PIX</option>
                <option value="boleto">Boleto</option>
            </select>
        </div>
        <?php endif; ?>
        
        <?php if (count($vendas) > 0): ?>
            <?php foreach ($vendas as $venda): ?>
                <div class="purchase-card" data-date="<?php echo $venda['data_venda']; ?>" data-total="<?php echo $venda['total']; ?>" data-method="<?php echo $venda['metodo_pagamento']; ?>">
                    <div class="purchase-header">
                        <div class="purchase-info">
                            <span class="purchase-id">
                                Compra #<?php echo str_pad($venda['id'], 6, '0', STR_PAD_LEFT); ?>
                                <span class="purchase-status">Concluída</span>
                            </span>
                            <span class="purchase-date">
                                <i class="far fa-calendar"></i>
                                <?php echo date('d/m/Y \à\s H:i', strtotime($venda['data_venda'])); ?>
                                • <?php echo $venda['total_itens']; ?> item(ns) • <?php echo $venda['total_jogos']; ?> jogo(s)
                            </span>
                        </div>
                        
                        <div class="purchase-details">
                            <div class="purchase-total">R$ <?php echo number_format($venda['total'], 2, ',', '.'); ?></div>
                            <span class="purchase-method">
                                <i class="fas fa-credit-card"></i>
                                <?php 
                                $metodos = [
                                    'cartao_credito' => 'Cartão de Crédito',
                                    'cartao_debito' => 'Cartão de Débito',
                                    'pix' => 'PIX',
                                    'boleto' => 'Boleto'
                                ];
                                echo $metodos[$venda['metodo_pagamento']] ?? $venda['metodo_pagamento'];
                                ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="purchase-items">
                        <?php foreach ($venda['itens'] as $item): ?>
                            <div class="purchase-item">
                                <img src="<?php echo htmlspecialchars($item['imagem_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($item['titulo']); ?>"
                                     onerror="this.src='https://via.placeholder.com/60x40/2a2a2a/666666?text=Game'">
                                <div class="purchase-item-info">
                                    <p class="purchase-item-title">
                                        <?php echo htmlspecialchars($item['titulo']); ?>
                                        <span class="category-badge"><?php echo ucfirst($item['categoria']); ?></span>
                                    </p>
                                    <p class="purchase-item-details">
                                        <?php echo htmlspecialchars($item['desenvolvedora']); ?>
                                        <?php if (isset($item['quantidade']) && $item['quantidade'] > 1): ?>
                                            • <?php echo $item['quantidade']; ?> unidades
                                        <?php endif; ?>
                                    </p>
                                    <p class="purchase-item-price">
                                        R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?>
                                    </p>
                                    <div class="item-actions">
                                        <a href="detalhes.php?id=<?php echo $item['jogo_id']; ?>" class="action-btn">
                                            <i class="fas fa-eye"></i> Ver Detalhes
                                        </a>
                                        <a href="biblioteca.php" class="action-btn">
                                            <i class="fas fa-download"></i> Instalar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-history">
                <i class="fas fa-receipt"></i>
                <h3>Nenhuma compra encontrada</h3>
                <p>Quando você fizer compras na nossa loja, elas aparecerão aqui.</p>
                <a href="index.php" class="checkout-btn" style="text-decoration: none; display: inline-block; margin-top: 20px; padding: 12px 24px;">
                    <i class="fas fa-shopping-bag"></i> Explorar Loja
                </a>
            </div>
        <?php endif; ?>
    </main>

    <script>
        // Menu mobile toggle
        document.getElementById('mobileNavToggle').addEventListener('click', function() {
            document.getElementById('mobileNavMenu').classList.toggle('active');
        });

        // Fechar menu mobile ao clicar fora
        document.addEventListener('click', function(event) {
            const mobileNav = document.getElementById('mobileNavMenu');
            const toggleButton = document.getElementById('mobileNavToggle');
            
            if (mobileNav.classList.contains('active') && 
                !mobileNav.contains(event.target) && 
                !toggleButton.contains(event.target)) {
                mobileNav.classList.remove('active');
            }
        });

        // Filtros simples (podem ser implementados com AJAX posteriormente)
        function filterPurchases(filter) {
            const purchases = document.querySelectorAll('.purchase-card');
            const now = new Date();
            const thirtyDaysAgo = new Date(now.getTime() - (30 * 24 * 60 * 60 * 1000));
            
            purchases.forEach(purchase => {
                let show = true;
                const purchaseDate = new Date(purchase.dataset.date);
                const total = parseFloat(purchase.dataset.total);
                
                switch(filter) {
                    case 'recent':
                        show = purchaseDate >= thirtyDaysAgo;
                        break;
                    case 'high-value':
                        show = total > 100;
                        break;
                    default:
                        show = true;
                }
                
                purchase.style.display = show ? 'block' : 'none';
            });
        }

        function filterByMethod(method) {
            const purchases = document.querySelectorAll('.purchase-card');
            
            purchases.forEach(purchase => {
                let show = true;
                const purchaseMethod = purchase.dataset.method;
                
                if (method !== 'all') {
                    show = purchaseMethod === method;
                }
                
                purchase.style.display = show ? 'block' : 'none';
            });
        }

        // Adicionar confete para compras recentes (últimos 7 dias)
        document.addEventListener('DOMContentLoaded', function() {
            const sevenDaysAgo = new Date(Date.now() - 7 * 24 * 60 * 60 * 1000);
            const recentPurchases = document.querySelectorAll('.purchase-card');
            
            recentPurchases.forEach(purchase => {
                const purchaseDate = new Date(purchase.dataset.date);
                if (purchaseDate >= sevenDaysAgo) {
                    purchase.style.borderLeft = '6px solid #28a745';
                }
            });
        });
    </script>
</body>
</html>