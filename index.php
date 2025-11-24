<?php
// index.php - Página principal com catálogo
session_start();

// Verificar se usuário está logado, se não, redirecionar para login
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

// Buscar jogos do banco
$categoria = $_GET['categoria'] ?? 'all';
$search = $_GET['search'] ?? '';

$sql = "SELECT * FROM jogos WHERE 1=1";
$params = [];

if ($categoria !== 'all') {
    $sql .= " AND categoria = :categoria";
    $params[':categoria'] = $categoria;
}

if (!empty($search)) {
    $sql .= " AND titulo LIKE :search";
    $params[':search'] = "%$search%";
}

$sql .= " ORDER BY titulo";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$jogos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Contar itens do carrinho
$cart_count = isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : 0;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Games Store - Catálogo</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="shortcut icon" href="favicon/fav.png" type="image/x-icon">
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

        /* Estilos para os botões */
        .add-to-cart-btn {
            background: linear-gradient(45deg, #4f219e, #853fb0, #b75ec1, #e87fd3);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 30px 0 0;
            cursor: pointer;
            margin-top: 10px;
            width: 90%;
            margin-left: 30px;
            height: 50px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .add-to-cart-btn:hover {
            background: var(--hover-color);
        }

        .in-library-btn {
            background: linear-gradient(45deg, #27ae60, #2ecc71, #34d399, #4ade80);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 30px 0 0;
            margin-top: 15px;
            width: 90%;
            margin-left: 30px;
            height: 50px;
            font-weight: bold;
            cursor: default;
            opacity: 0.9;
        }
        
        .game-card {
            position: relative;
        }
        
        .in-library-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #4CAF50;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        /* Responsividade melhorada */
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
    </style>
</head>

<body class="home-page">

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
                
                <a href="biblioteca.php" class="nav-link">
                    <i class="fas fa-gamepad"></i>
                    <span>Biblioteca</span>
                </a>
                
                <a href="historico_compras.php" class="nav-link">
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

                 <a href="perfil.php" class="nav-link">
                    <i class="fas fa-user-cog"></i>
                    <span>Perfil</span>
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

        <!-- Menu de categorias mobile (mantido do código original) -->
        <button class="mobile-categories-btn">
            <i class="fas fa-bars"></i> Categorias
        </button>

        <div class="mobile-categories-panel" id="mobile-categories-panel">
            <div class="panel-header">
                <span>Categorias</span>
                <button id="close-categories"><i class="fas fa-times"></i></button>
            </div>

            <ul class="mobile-category-list">
                <li data-category="all">🎮 Todos os Jogos</li>
                <li data-category="acao-aventura">🗺️ Ação / Aventura</li>
                <li data-category="fps">💥 FPS</li>
                <li data-category="indie">✨ Indie</li>
                <li data-category="acao">🔥 Ação</li>
                <li data-category="rpg">🛡️ RPG</li>
                <li data-category="aventura">⚔️ Aventura</li>
                <li data-category="esportes-corrida">🏎️ Esportes / Corrida</li>
                <li data-category="estrategia">♟️ Estratégia</li>
                <li data-category="simulação">🕹️ Simulação</li>
                <li data-category="terror">👻 Terror</li>
                <li data-category="sobrevivência">🌲 Sobrevivência</li>
            </ul>
        </div>
    </header>

    <main>
        <!-- Sidebar fixa -->
        <aside class="sidebar">
            <h2>CATEGORIAS</h2>
            <ul id="category-list">
                <li data-category="all" class="<?php echo $categoria === 'all' ? 'active' : ''; ?>">🎮 Todos os Jogos</li>
                <li data-category="acao-aventura" class="<?php echo $categoria === 'acao-aventura' ? 'active' : ''; ?>">🗺️ Ação / Aventura</li>
                <li data-category="fps" class="<?php echo $categoria === 'fps' ? 'active' : ''; ?>">💥 FPS</li>
                <li data-category="indie" class="<?php echo $categoria === 'indie' ? 'active' : ''; ?>">✨ Indie</li>
                <li data-category="acao" class="<?php echo $categoria === 'acao' ? 'active' : ''; ?>">🔥 Ação</li>
                <li data-category="rpg" class="<?php echo $categoria === 'rpg' ? 'active' : ''; ?>">🛡️ RPG</li>
                <li data-category="aventura" class="<?php echo $categoria === 'aventura' ? 'active' : ''; ?>">⚔️ Aventura</li>
                <li data-category="esportes-corrida" class="<?php echo $categoria === 'esportes-corrida' ? 'active' : ''; ?>">🏎️ Esportes / Corrida</li>
                <li data-category="estrategia" class="<?php echo $categoria === 'estrategia' ? 'active' : ''; ?>">♟️ Estratégia</li>
                <li data-category="simulação" class="<?php echo $categoria === 'simulação' ? 'active' : ''; ?>">🕹️ Simulação</li>
                <li data-category="terror" class="<?php echo $categoria === 'terror' ? 'active' : ''; ?>">👻 Terror</li>
                <li data-category="sobrevivência" class="<?php echo $categoria === 'sobrevivência' ? 'active' : ''; ?>">🌲 Sobrevivência</li>
            </ul>
        </aside>

        <!-- Área principal rolável -->
        <section class="content">

            <div class="content-header">
                <p class="breadcrumb">Loja / <?php 
                    if ($categoria === 'all') {
                        echo 'Todos os Jogos';
                    } else {
                        echo ucfirst(str_replace('-', ' ', $categoria));
                    }
                ?> (<?php echo count($jogos); ?>)</p>

                <form method="GET" action="index.php" class="search-box">
                    <input type="text" name="search" id="search-input" placeholder="Pesquisar jogos..." 
                           value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit" id="search-button"><i class="fas fa-search"></i></button>
                    <?php if ($categoria !== 'all'): ?>
                        <input type="hidden" name="categoria" value="<?php echo $categoria; ?>">
                    <?php endif; ?>
                </form>
            </div>

            <div class="game-catalog" id="game-catalog">
                <?php if (count($jogos) > 0): ?>
                    <?php foreach ($jogos as $jogo): ?>
                        <?php
                        // Verificar se o jogo já está na biblioteca do usuário
                        $stmt_lib = $pdo->prepare("SELECT id FROM biblioteca WHERE usuario_id = ? AND jogo_id = ?");
                        $stmt_lib->execute([$_SESSION['user_id'], $jogo['id']]);
                        $in_library = $stmt_lib->fetch();
                        ?>
                        
                        <div class="game-card" data-category="<?php echo htmlspecialchars($jogo['categoria']); ?>">
                            <a href="detalhes.php?id=<?php echo $jogo['id']; ?>" class="game-card-link">
                                <div class="game-banner">
                                    <img src="<?php echo htmlspecialchars($jogo['imagem_url']); ?>" 
                                        alt="<?php echo htmlspecialchars($jogo['titulo']); ?>"
                                        loading="lazy">
                                </div>
                                <div class="game-info">
                                    <h3><?php echo htmlspecialchars($jogo['titulo']); ?></h3>
                                    
                                    <!-- Preço e Categoria na mesma linha -->
                                    <div class="price-category-row">
                                        <span class="price">R$ <?php echo number_format($jogo['preco'], 2, ',', '.'); ?></span>
                                        <span class="category-tag"><?php echo htmlspecialchars($jogo['categoria']); ?></span>
                                    </div>
                                </div>
                            </a>
                            
                            <?php if ($in_library): ?>
                                <!-- Botão verde "Na Biblioteca" para jogos já adquiridos -->
                                <button class="in-library-btn" disabled>
                                    <i class="fas fa-check-circle"></i> Na Biblioteca
                                </button>
                            <?php else: ?>
                                <!-- Botão normal de adicionar ao carrinho -->
                                <form method="POST" action="add_to_cart.php" class="add-to-cart-form">
                                    <input type="hidden" name="jogo_id" value="<?php echo $jogo['id']; ?>">
                                    <input type="hidden" name="jogo_titulo" value="<?php echo htmlspecialchars($jogo['titulo']); ?>">
                                    <input type="hidden" name="jogo_preco" value="<?php echo $jogo['preco']; ?>">
                                    <input type="hidden" name="jogo_imagem" value="<?php echo htmlspecialchars($jogo['imagem_url']); ?>">
                                    <button type="submit" class="add-to-cart-btn">
                                        <i class="fas fa-shopping-cart"></i> Adicionar ao Carrinho
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-games">
                        <i class="fas fa-search" style="font-size: 64px; color: #666; margin-bottom: 20px;"></i>
                        <h3>Nenhum jogo encontrado</h3>
                        <p>Tente alterar os filtros de busca ou categoria.</p>
                    </div>
                <?php endif; ?>
            </div>

            <p class="no-results" style="display:<?php echo count($jogos) === 0 ? 'block' : 'none'; ?>;">
                Nenhum jogo encontrado nesta categoria ou busca.
            </p>

        </section>
    </main>

    <!-- MODAL: Adicionado ao Carrinho -->
    <div id="add-cart-modal" class="modal-overlay" style="display:none;">
        <div class="modal-content" style="position: relative; text-align: center;">
            <span class="close-btn" id="add-cart-close">&times;</span>
            <i class="fas fa-check-circle" style="font-size: 60px; color: #55ff99;"></i>
            <h2>Adicionado ao Carrinho!</h2>
            <p><strong id="add-cart-name"></strong> foi adicionado ao seu carrinho.</p>
        </div>
    </div>

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

        // Filtros de categoria (mantido do código original)
        document.querySelectorAll('#category-list li, .mobile-category-list li').forEach(item => {
            item.addEventListener('click', function() {
                const category = this.getAttribute('data-category');
                const url = new URL(window.location.href);
                url.searchParams.set('categoria', category);
                window.location.href = url.toString();
            });
        });

        // Menu mobile de categorias (mantido do código original)
        document.querySelector('.mobile-categories-btn').addEventListener('click', function() {
            document.getElementById('mobile-categories-panel').classList.add('active');
        });

        document.getElementById('close-categories').addEventListener('click', function() {
            document.getElementById('mobile-categories-panel').classList.remove('active');
        });

        // Fechar modal (mantido do código original)
        document.getElementById('add-cart-close').addEventListener('click', function() {
            document.getElementById('add-cart-modal').style.display = 'none';
        });

        // Adicionar ao carrinho com AJAX (mantido do código original)
        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                fetch('add_to_cart.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('add-cart-name').textContent = data.jogo_titulo;
                        document.getElementById('add-cart-modal').style.display = 'flex';
                        
                        // Atualizar contador do carrinho
                        const cartCount = document.querySelector('.cart-count');
                        if (cartCount) {
                            cartCount.textContent = parseInt(cartCount.textContent) + 1;
                        } else {
                            const cartIcon = document.querySelector('.cart-icon');
                            cartIcon.innerHTML = '<i class="fas fa-shopping-cart"></i><span class="cart-count">1</span>';
                        }
                        
                        // Recarregar após 2 segundos para mostrar badge "Na Biblioteca"
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao adicionar ao carrinho');
                });
            });
        });
    </script>
</body>
</html>