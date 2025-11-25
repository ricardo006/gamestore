<?php
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

// Processar filtros
$filter = $_GET['filter'] ?? 'all';
$search = $_GET['search'] ?? '';

// Buscar jogos da biblioteca do usuário
$sql = "SELECT b.*, j.titulo, j.descricao, j.imagem_url, j.categoria, j.desenvolvedora 
        FROM biblioteca b 
        JOIN jogos j ON b.jogo_id = j.id 
        WHERE b.usuario_id = :usuario_id";

$params = [':usuario_id' => $_SESSION['user_id']];

// Aplicar filtros
if ($filter === 'installed') {
    $sql .= " AND b.instalado = 1";
} elseif ($filter === 'not-installed') {
    $sql .= " AND b.instalado = 0";
}

// Aplicar busca
if (!empty($search)) {
    $sql .= " AND j.titulo LIKE :search";
    $params[':search'] = "%$search%";
}

$sql .= " ORDER BY b.data_aquisicao DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$jogos_biblioteca = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Contar jogos instalados e não instalados
$installed_count = 0;
$not_installed_count = 0;
foreach ($jogos_biblioteca as $jogo) {
    if ($jogo['instalado']) {
        $installed_count++;
    } else {
        $not_installed_count++;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Games Store - Minha Biblioteca</title>
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

        /* Botões mantidos como estavam */
        .install-btn {
            background: linear-gradient(45deg, #2196F3, #21CBF3, #03A9F4, #0288D1);
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
        
        .install-btn:hover {
            background: linear-gradient(45deg, #1976D2, #0288D1, #0277BD, #01579B);
            transform: translateY(-2px);
        }
        
        .play-btn {
            background: linear-gradient(45deg, #4CAF50, #66BB6A, #81C784, #43A047);
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
        
        .play-btn:hover {
            background: linear-gradient(45deg, #388E3C, #43A047, #2E7D32, #1B5E20);
            transform: translateY(-2px);
        }
        
        .installed-badge {
            background: linear-gradient(45deg, #4CAF50, #66BB6A);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .not-installed-badge {
            background: linear-gradient(45deg, #757575, #9E9E9E);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* SISTEMA DE GRID CORRIGIDO */
        .game-catalog {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            padding: 20px 0;
        }

        /* Responsividade do grid */
        @media (max-width: 768px) {
            .game-catalog {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 20px;
                padding: 15px 0;
            }
        }

        @media (max-width: 480px) {
            .game-catalog {
                grid-template-columns: 1fr;
                gap: 15px;
                padding: 10px 0;
            }
        }

        /* Quando o grid estiver vazio, ocultar completamente */
        .game-catalog:empty {
            display: none;
        }

        /* Estilos para o card da biblioteca */
        .game-card {
            position: relative;
            background: var(--bg-medium);
            border-radius: 30px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .game-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            border-color: var(--text-primary);
        }

        .game-card-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .game-card-link:hover {
            color: inherit;
        }

        .game-banner {
            width: 100%;
            height: 180px;
            overflow: hidden;
        }

        .game-banner img {
            width: 100%;
            height: 100%;
            transition: transform 0.3s ease;
        }

        .game-card:hover .game-banner img {
            transform: scale(1.05);
        }

        .game-info {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .game-info h3 {
            font-size: 1.2em;
            font-weight: 700;
            color: #fff;
            margin: 0;
            line-height: 1.3;
        }

        .category-tag {
            background: rgba(133, 63, 176, 0.2);
            color: #b8a9f0;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.8em;
            align-self: flex-start;
            margin: 0;
        }

        .developer {
            color: #dfdcfc;
            font-size: 0.9em;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .developer i {
            color: #853fb0;
            font-size: 0.8em;
        }

        .game-status {
            margin-top: 10px;
            padding: 0 10px;
        }

        .game-count {
            background: var(--text-primary);
            color: var(--bg-dark);
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 12px;
            margin-left: 5px;
        }

        /* Estilo melhorado para biblioteca vazia */
        .empty-library {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 80px 40px;
            color: #ecebfaff;
            background: var(--bg-medium);
            border-radius: 20px;
            margin: 40px 0;
            min-height: 400px;
            border: 2px dashed rgba(255,255,255,0.1);
        }

        .empty-library i {
            font-size: 80px;
            margin-bottom: 10px;
            color: #fff;
            opacity: 0.7;
        }

        .empty-library h3 {
            font-size: 2em;
            margin-bottom: 15px;
            color: var(--text-primary);
            font-weight: 700;
        }

        .empty-library p {
            font-size: 1.2em;
            margin-bottom: 35px;
            opacity: 0.8;
            max-width: 500px;
            line-height: 1.6;
        }

        .empty-library .btn-primary {
            background: linear-gradient(45deg, #4f219e, #853fb0);
            color: white;
            padding: 15px 30px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1em;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            border: none;
            cursor: pointer;
            line-height: 1;
            vertical-align: middle;
        }

        .empty-library .btn-primary i {
            font-size: 1.1em;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .empty-library .btn-primary:hover {
            background: linear-gradient(45deg, #853fb0, #4f219e);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(79, 33, 158, 0.3);
        }

        /* Estilo para mensagem de nenhum resultado */
        .no-results {
            text-align: center;
            padding: 40px 20px;
            color: #dfdcfc;
            font-size: 1.1em;
            background: var(--bg-medium);
            border-radius: 15px;
            margin: 20px 0;
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

            .empty-library {
                padding: 60px 20px;
                min-height: 300px;
            }

            .empty-library i {
                font-size: 80px;
            }

            .empty-library h3 {
                font-size: 1.6em;
            }

            .empty-library p {
                font-size: 1.1em;
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

            .empty-library {
                padding: 40px 20px;
                min-height: 250px;
            }

            .empty-library i {
                font-size: 60px;
                margin-bottom: 20px;
            }

            .empty-library h3 {
                font-size: 1.4em;
            }

            .empty-library p {
                font-size: 1em;
                margin-bottom: 25px;
            }
        }

        @media (min-width: 769px) {
            .mobile-nav-menu {
                display: none !important;
            }
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
            
            <a href="biblioteca.php" class="nav-link active">
                <i class="fas fa-gamepad"></i>
                <span>Biblioteca</span>
            </a>
            
            <a href="historico_compras.php" class="nav-link">
                <i class="fas fa-history"></i>
                <span>Compras</span>
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
        
        <a href="logout.php" class="mobile-nav-link" style="color: #ff6b6b;">
            <i class="fas fa-sign-out-alt"></i>
            Sair
        </a>
    </div>
</header>

<main>
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="search-box">
            <form method="GET" action="biblioteca.php" id="search-form">
                <input type="text" name="search" id="library-search-input" placeholder="Pesquisar biblioteca..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" id="library-search-button"><i class="fas fa-search"></i></button>
                <?php if ($filter !== 'all'): ?>
                    <input type="hidden" name="filter" value="<?php echo $filter; ?>">
                <?php endif; ?>
            </form>
        </div>

        <ul id="library-links">
            <li class="<?php echo $filter === 'all' ? 'active' : ''; ?>" data-filter="all">
                📚 Todos os Jogos (<?php echo count($jogos_biblioteca); ?>)
            </li>
            <li class="<?php echo $filter === 'installed' ? 'active' : ''; ?>" data-filter="installed">
                ⚙️ Instalados (<?php echo $installed_count; ?>)
            </li>
            <li class="<?php echo $filter === 'not-installed' ? 'active' : ''; ?>" data-filter="not-installed">
                ☁️ Não Instalados (<?php echo $not_installed_count; ?>)
            </li>
        </ul>
    </aside>

    <!-- CONTEÚDO PRINCIPAL -->
    <section class="content">
        <div class="content-header">
            <h2>
                <?php 
                    if ($filter === 'all') echo 'Todos os Jogos';
                    elseif ($filter === 'installed') echo 'Jogos Instalados';
                    else echo 'Jogos Não Instalados';
                ?> 
                (<span id="game-count"><?php echo count($jogos_biblioteca); ?></span>)
            </h2>
        </div>

        <!-- GRID DE JOGOS -->
        <?php if (count($jogos_biblioteca) > 0): ?>
            <div class="game-catalog" id="library-grid">
                <?php foreach ($jogos_biblioteca as $jogo): ?>
                    <div class="game-card" data-installed="<?php echo $jogo['instalado'] ? 'true' : 'false'; ?>">
                        <!-- Card clicável para detalhes -->
                        <a href="detalhes.php?id=<?php echo $jogo['jogo_id']; ?>" class="game-card-link">
                            <div class="game-banner">
                                <img src="<?php echo htmlspecialchars($jogo['imagem_url']); ?>" alt="<?php echo htmlspecialchars($jogo['titulo']); ?>">
                            </div>
                            <div class="game-info">
                                <h3><?php echo htmlspecialchars($jogo['titulo']); ?></h3>
                                <p class="category-tag"><?php echo htmlspecialchars($jogo['categoria']); ?></p>
                                <p class="developer">
                                    <i class="fas fa-building"></i>
                                    <?php echo htmlspecialchars($jogo['desenvolvedora']); ?>
                                </p>
                                <div class="game-status">
                                    <?php if ($jogo['instalado']): ?>
                                        <span class="installed-badge">
                                            <i class="fas fa-check-circle"></i> Instalado
                                        </span>
                                    <?php else: ?>
                                        <span class="not-installed-badge">
                                            <i class="fas fa-cloud"></i> Não Instalado
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                        
                        <!-- Botão NÃO é parte do link clicável -->
                        <?php if ($jogo['instalado']): ?>
                            <button class="play-btn" onclick="playGame(<?php echo $jogo['jogo_id']; ?>)">
                                <i class="fas fa-play"></i> Jogar
                            </button>
                        <?php else: ?>
                            <button class="install-btn" onclick="installGame(<?php echo $jogo['jogo_id']; ?>)">
                                <i class="fas fa-download"></i> Instalar
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- MENSAGEM DE BIBLIOTECA VAZIA (FORA DO GRID) -->
            <div class="empty-library">
                <i class="fas fa-gamepad"></i>
                <h3>
                    <?php if (!empty($search)): ?>
                        Nenhum jogo encontrado
                    <?php else: ?>
                        Sua biblioteca está vazia
                    <?php endif; ?>
                </h3>
                <p>
                    <?php if (!empty($search)): ?>
                        Não foram encontrados jogos correspondentes à sua pesquisa "<?php echo htmlspecialchars($search); ?>".
                    <?php else: ?>
                        Adquira jogos incríveis na nossa loja para começar sua coleção de games!
                    <?php endif; ?>
                </p>
                <a href="index.php" class="btn-primary">
                    <i class="fas fa-shopping-bag"></i> Explorar Loja
                </a>
            </div>
        <?php endif; ?>

        <!-- Mensagem específica para busca sem resultados -->
        <?php if (count($jogos_biblioteca) === 0 && !empty($search)): ?>
            <p class="no-results" id="no-results-lib">
                Sugestão: tente usar termos diferentes ou verifique a ortografia.
            </p>
        <?php endif; ?>
    </section>
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

// Funções para instalar/jogar com AJAX
function installGame(gameId) {
    if (confirm('Deseja instalar este jogo?')) {
        // Mostrar loading no botão
        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Instalando...';
        button.disabled = true;
        
        // Requisição AJAX para atualizar o banco
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
                button.innerHTML = '<i class="fas fa-check"></i> Instalado!';
                button.style.background = 'linear-gradient(45deg, #4CAF50, #45a049)';
                setTimeout(() => {
                    window.location.href = 'biblioteca.php?filter=installed';
                }, 1000);
            } else {
                button.innerHTML = originalText;
                button.disabled = false;
                alert('Erro ao instalar o jogo: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            button.innerHTML = originalText;
            button.disabled = false;
            alert('Erro ao instalar o jogo');
        });
    }
}

function playGame(gameId) {
    // Simulação de jogo iniciando
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Iniciando...';
    button.disabled = true;
    
    setTimeout(() => {
        button.innerHTML = originalText;
        button.disabled = false;
        alert('Jogo iniciado! (Simulação)');
    }, 2000);
}

// Filtros da biblioteca
document.querySelectorAll('#library-links li').forEach(item => {
    item.addEventListener('click', function() {
        const filter = this.getAttribute('data-filter');
        const search = document.getElementById('library-search-input').value;
        
        let url = `biblioteca.php?filter=${filter}`;
        if (search) {
            url += `&search=${encodeURIComponent(search)}`;
        }
        
        window.location.href = url;
    });
});

// Busca na biblioteca
document.getElementById('search-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const search = document.getElementById('library-search-input').value;
    let url = `biblioteca.php?filter=<?php echo $filter; ?>`;
    if (search) {
        url += `&search=${encodeURIComponent(search)}`;
    }
    window.location.href = url;
});

// Prevenir que o clique no card seja acionado quando clicar no botão
document.querySelectorAll('.install-btn, .play-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.stopPropagation();
    });
});

// Atualizar dinamicamente a contagem de jogos visíveis
function updateVisibleGameCount() {
    const visibleGames = document.querySelectorAll('.game-catalog .game-card:not([style*="display: none"])').length;
    document.getElementById('game-count').textContent = visibleGames;
}

// Inicializar quando a página carregar
document.addEventListener('DOMContentLoaded', function() {
    updateVisibleGameCount();
});
</script>

</body>
</html>