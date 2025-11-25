<?php
// detalhes.php - Página de detalhes do jogo
session_start();

// Verificar se usuário está logado
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

// Buscar jogo pelo ID
$jogo_id = $_GET['id'] ?? null;

if (!$jogo_id) {
    header("Location: index.php");
    exit;
}

// Buscar dados do jogo
$stmt = $pdo->prepare("SELECT * FROM jogos WHERE id = ?");
$stmt->execute([$jogo_id]);
$jogo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$jogo) {
    die("Jogo não encontrado");
}

// Buscar galeria de imagens
$stmt_galeria = $pdo->prepare("SELECT imagem_url FROM jogo_galeria WHERE jogo_id = ? ORDER BY ordem");
$stmt_galeria->execute([$jogo_id]);
$galeria = $stmt_galeria->fetchAll(PDO::FETCH_ASSOC);

// Buscar requisitos
$stmt_requisitos_min = $pdo->prepare("SELECT requisito FROM jogo_requisitos WHERE jogo_id = ? AND tipo = 'minimo' ORDER BY ordem");
$stmt_requisitos_min->execute([$jogo_id]);
$requisitos_minimos = $stmt_requisitos_min->fetchAll(PDO::FETCH_COLUMN);

$stmt_requisitos_rec = $pdo->prepare("SELECT requisito FROM jogo_requisitos WHERE jogo_id = ? AND tipo = 'recomendado' ORDER BY ordem");
$stmt_requisitos_rec->execute([$jogo_id]);
$requisitos_recomendados = $stmt_requisitos_rec->fetchAll(PDO::FETCH_COLUMN);

// Buscar categoria para o breadcrumb
$categoria_nome = ucfirst(str_replace('-', ' ', $jogo['categoria']));

// Verificar se o jogo já está na biblioteca do usuário e se está instalado
$stmt_lib = $pdo->prepare("SELECT id, instalado FROM biblioteca WHERE usuario_id = ? AND jogo_id = ?");
$stmt_lib->execute([$_SESSION['user_id'], $jogo_id]);
$library_info = $stmt_lib->fetch(PDO::FETCH_ASSOC);
$in_library = $library_info !== false;
$is_installed = $in_library ? $library_info['instalado'] : false;

// Contar itens do carrinho
$cart_count = isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : 0;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Games Store - <?php echo htmlspecialchars($jogo['titulo']); ?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="detalhes.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="shortcut icon" href="favicon/fav.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@300;400;600;700&display=swap" rel="stylesheet">
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
                   
                <a href="index.php" class="nav-link" style="color: #4CAF50;">
                    <i class="fas fa-store"></i>
                    <span>Loja</span>
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
            
            <a href="index.php" class="mobile-nav-link" style="color: #4CAF50;">
                <i class="fas fa-store"></i>
                Loja
            </a>

            <a href="carrinho.php" class="mobile-nav-link cart-icon">
                <i class="fas fa-shopping-cart"></i>
                Carrinho
                <?php if ($cart_count > 0): ?>
                    <span class="cart-count"><?php echo $cart_count; ?></span>
                <?php endif; ?>
            </a>
            
            <a href="logout.php" class="mobile-nav-link" style="color: #ff6b6b;">
                <i class="fas fa-sign-out-alt"></i>
                Sair
            </a>
        </div>
    </header>

    <main class="main-detail">
        <div class="detail-breadcrumb">
            <a href="index.php">Loja</a>
            / <span id="detail-category-breadcrumb"><?php echo $categoria_nome; ?></span> 
            / <span id="detail-title-breadcrumb"><?php echo htmlspecialchars($jogo['titulo']); ?></span>
        </div>

        <section class="content-detail">
            <div class="detail-left">
                <div class="detail-banner">
                    <img id="detail-image" src="<?php echo htmlspecialchars($jogo['imagem_url']); ?>" 
                         alt="<?php echo htmlspecialchars($jogo['titulo']); ?>">
                </div>

                <h2>SOBRE ESTE JOGO</h2>
                <p id="detail-description"><?php echo nl2br(htmlspecialchars($jogo['descricao'] ?? $jogo['descrizao'] ?? 'Descrição não disponível')); ?></p>

                <h2>INFORMAÇÕES</h2>
                <div class="game-info-details">
                    <p><strong>Data de Lançamento:</strong> 
                        <?php echo !empty($jogo['data_lancamento']) && $jogo['data_lancamento'] != '[000]' ? 
                            date('d/m/Y', strtotime($jogo['data_lancamento'])) : 'Não informada'; ?>
                    </p>
                    <p><strong>Categoria:</strong> <?php echo $categoria_nome; ?></p>
                    <p><strong>Desenvolvedora:</strong> <?php echo htmlspecialchars($jogo['desenvolvedora'] ?? $jogo['desenvolvidos'] ?? 'Não informada'); ?></p>
                    <p><strong>Publicadora:</strong> <?php echo htmlspecialchars($jogo['publicadora'] ?? $jogo['publicados'] ?? 'Não informada'); ?></p>
                </div>

                <!-- Seção de Fotos -->
                <h2>FOTOS</h2>
                <div class="detail-gallery" id="detail-gallery">
                    <?php if (count($galeria) > 0): ?>
                        <?php foreach ($galeria as $foto): ?>
                            <img src="<?php echo htmlspecialchars($foto['imagem_url']); ?>" 
                                 alt="Screenshot do jogo" 
                                 onclick="openImageModal('<?php echo htmlspecialchars($foto['imagem_url']); ?>')">
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-data-message">
                            <i class="fas fa-camera" style="font-size: 48px; margin-bottom: 10px;"></i>
                            <p>Galeria de fotos não disponível</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Seção de Requisitos -->
                <h2>REQUISITOS DO SISTEMA</h2>
                <div class="detail-requirements">
                    <?php if (count($requisitos_minimos) > 0 || count($requisitos_recomendados) > 0): ?>
                        <div class="req-column">
                            <h3>MÍNIMOS</h3>
                            <ul class="requisitos-lista" id="req-min">
                                <?php foreach ($requisitos_minimos as $req): ?>
                                    <li><?php echo htmlspecialchars($req); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="req-column">
                            <h3>RECOMENDADOS</h3>
                            <ul class="requisitos-lista" id="req-rec">
                                <?php foreach ($requisitos_recomendados as $req): ?>
                                    <li><?php echo htmlspecialchars($req); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php else: ?>
                        <div class="no-data-message">
                            <i class="fas fa-desktop" style="font-size: 48px; margin-bottom: 10px;"></i>
                            <p>Requisitos do sistema não disponíveis</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="detail-right">
                <h1 id="detail-title"><?php echo htmlspecialchars($jogo['titulo']); ?></h1>
                
                <div class="game-meta-info">
                    <p class="detail-publisher">
                        <strong>Publicado por:</strong> 
                        <span id="detail-publisher-name"><?php echo htmlspecialchars($jogo['publicadora'] ?? $jogo['publicados'] ?? 'Não informada'); ?></span>
                    </p>
                    
                    <p class="detail-developer">
                        <strong>Desenvolvido por:</strong> 
                        <span id="detail-developer-name"><?php echo htmlspecialchars($jogo['desenvolvedora'] ?? $jogo['desenvolvidos'] ?? 'Não informada'); ?></span>
                    </p>
                </div>

                <!-- Badge de Status na Biblioteca -->
                <?php if ($in_library): ?>
                    <div class="library-status-badge">
                        <div class="badge-header">
                            <i class="fas fa-gamepad"></i>
                            <span>Status na Biblioteca</span>
                        </div>
                        <div class="badge-content">
                            <?php if ($is_installed): ?>
                                <span class="status-badge installed">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Instalado</span>
                                </span>
                            <?php else: ?>
                                <span class="status-badge not-installed">
                                    <i class="fas fa-cloud"></i>
                                    <span>Na Biblioteca</span>
                                </span>
                            <?php endif; ?>
                            <div class="badge-actions">
                                <?php if ($is_installed): ?>
                                    <button class="action-btn play-btn" onclick="playGame(<?php echo $jogo_id; ?>)">
                                        <i class="fas fa-play"></i> Jogar
                                    </button>
                                <?php else: ?>
                                    <button class="action-btn install-btn" onclick="installGame(<?php echo $jogo_id; ?>)">
                                        <i class="fas fa-download"></i> Instalar
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="buy-box">
                    <span class="detail-price" id="detail-price">
                        R$ <?php echo number_format($jogo['preco'], 2, ',', '.'); ?>
                    </span>
                    
                    <?php if ($in_library): ?>
                        <button class="buy-button" disabled>
                            <i class="fas fa-check"></i> Já Adquirido
                        </button>
                    <?php else: ?>
                        <form method="POST" action="add_to_cart.php" class="add-to-cart-form">
                            <input type="hidden" name="jogo_id" value="<?php echo $jogo['id']; ?>">
                            <input type="hidden" name="jogo_titulo" value="<?php echo htmlspecialchars($jogo['titulo']); ?>">
                            <input type="hidden" name="jogo_preco" value="<?php echo $jogo['preco']; ?>">
                            <input type="hidden" name="jogo_imagem" value="<?php echo htmlspecialchars($jogo['imagem_url']); ?>">
                            <button type="submit" class="buy-button">
                                <i class="fas fa-shopping-cart"></i> Adicionar ao Carrinho
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <!-- MODAL: Adicionado ao Carrinho -->
    <div id="cart-modal" class="modal-overlay" style="display:none;">
        <div class="modal-content" style="position:relative; text-align:center;">
            <span class="close-btn" id="close-cart-modal">&times;</span>
            <i class="fas fa-check-circle" style="font-size:60px; color:#55ff99;"></i>
            <h2>Adicionado ao Carrinho!</h2>
            <p><strong id="modal-game-name"></strong> foi adicionado ao seu carrinho.</p>
        </div>
    </div>

    <!-- MODAL: Imagem Ampliada -->
    <div id="image-modal" class="modal-overlay" style="display:none;">
        <div class="modal-content" style="position:relative; text-align:center; max-width:90%;">
            <span class="close-btn" id="close-image-modal">&times;</span>
            <img id="modal-image" src="" alt="Imagem ampliada" style="max-width:100%; max-height:80vh;">
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

        // Adicionar ao carrinho com AJAX
        document.querySelector('.add-to-cart-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('add_to_cart.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('modal-game-name').textContent = data.jogo_titulo;
                    document.getElementById('cart-modal').style.display = 'flex';
                    
                    // Atualizar contador do carrinho
                    const cartCount = document.querySelector('.cart-count');
                    if (cartCount) {
                        cartCount.textContent = parseInt(cartCount.textContent) + 1;
                    } else {
                        const cartIcons = document.querySelectorAll('.cart-icon');
                        cartIcons.forEach(icon => {
                            icon.innerHTML = '<i class="fas fa-shopping-cart"></i><span class="cart-count">1</span>' + (icon.querySelector('span:not(.cart-count)') ? '<span>Carrinho</span>' : '');
                        });
                    }
                    
                    // Fechar modal após 2 segundos e recarregar
                    setTimeout(() => {
                        document.getElementById('cart-modal').style.display = 'none';
                        window.location.reload();
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao adicionar ao carrinho');
            });
        });

        // Fechar modais
        document.getElementById('close-cart-modal').addEventListener('click', function() {
            document.getElementById('cart-modal').style.display = 'none';
        });

        document.getElementById('close-image-modal').addEventListener('click', function() {
            document.getElementById('image-modal').style.display = 'none';
        });

        // Abrir imagem em modal
        function openImageModal(imageUrl) {
            document.getElementById('modal-image').src = imageUrl;
            document.getElementById('image-modal').style.display = 'flex';
        }

        // Fechar modal ao clicar fora
        document.querySelectorAll('.modal-overlay').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.style.display = 'none';
                }
            });
        });

        // Funções para instalar/jogar
        function installGame(gameId) {
            if (confirm('Deseja instalar este jogo?')) {
                fetch('install_game.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'jogo_id=' + gameId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Jogo instalado com sucesso!');
                        window.location.reload();
                    } else {
                        alert('Erro ao instalar o jogo: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao instalar o jogo');
                });
            }
        }

        function playGame(gameId) {
            alert('Iniciando jogo... (Simulação)');
        }
    </script>
</body>
</html>