<?php
// main.php - Página principal após login
session_start();

// Se não estiver logado, redireciona para login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <title>Game Store</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body class="home-page">
  <header>
    <div class="logo">
      <a href="main.php">Game Store</a>
    </div>
     <nav>
            <span style="color: var(--text-primary); margin-right: 15px;">Olá, <?php echo $_SESSION['username']; ?>!</span>
            <a href="perfil.php">Perfil</a>
            <a href="biblioteca.php">Biblioteca</a>
            <a href="historico_compras.php">Minhas Compras</a> <!-- LINK ADICIONADO AQUI -->
            <a href="carrinho.php" class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <?php
                $cart_count = isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : 0;
                if ($cart_count > 0): ?>
                    <span class="cart-count"><?php echo $cart_count; ?></span>
                <?php endif; ?>
            </a>
            <a href="logout.php">Sair</a>
        </nav>
  </header>
  
  <!-- Seu conteúdo principal aqui -->
  <div class="content">
    <h1>Bem-vindo à Game Store!</h1>
    <p>Conteúdo da sua loja de jogos...</p>
  </div>
</body>
</html>