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

// Buscar dados do usuário (sem foto_perfil)
$stmt = $pdo->prepare("SELECT id, username, email FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    // Se não encontrou o usuário, faz logout
    session_destroy();
    header("Location: login.php");
    exit;
}

// Processar atualização do perfil
$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_username = trim($_POST['username'] ?? '');
    $novo_email = trim($_POST['email'] ?? '');
    $nova_senha = $_POST['password'] ?? '';
    
    if (!empty($novo_username)) {
        // Atualizar dados do usuário
        try {
            if (!empty($nova_senha)) {
                // Se tem nova senha, atualiza com senha
                $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE usuarios SET username = ?, email = ?, password = ? WHERE id = ?");
                $stmt->execute([$novo_username, $novo_email, $senha_hash, $_SESSION['user_id']]);
            } else {
                // Sem nova senha, mantém a senha atual
                $stmt = $pdo->prepare("UPDATE usuarios SET username = ?, email = ? WHERE id = ?");
                $stmt->execute([$novo_username, $novo_email, $_SESSION['user_id']]);
            }
            
            // Atualizar dados na sessão
            $_SESSION['username'] = $novo_username;
            $usuario['username'] = $novo_username;
            $usuario['email'] = $novo_email;
            
            $mensagem = "Perfil atualizado com sucesso!";
            
        } catch(PDOException $e) {
            $mensagem = "Erro ao atualizar perfil: " . $e->getMessage();
        }
    } else {
        $mensagem = "O nome de usuário não pode estar vazio.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <title>Perfil do Usuário - Games Store</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-color: var(--bg-dark);
      color: var(--text-light);
      margin: 0;
      padding: 20px;
    }

    .profile-container {
      background-color: var(--bg-medium);
      padding: 30px;
      border-radius: 10px;
      width: 400px;
      max-width: 90%;
      box-shadow: 0 0 15px rgba(0,0,0,0.5);
      text-align: center;
    }

    h1 {
      color: var(--text-primary);
      margin-bottom: 20px;
    }

    .profile-pic {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--text-primary);
      margin-bottom: 15px;
    }

    .file-input {
      display: none;
    }

    .edit-btn {
      display: inline-block;
      background-color: var(--text-primary);
      color: white;
      padding: 8px 15px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
      margin: 8px 0;
      transition: background-color 0.3s ease;
    }

    .edit-btn:hover {
      background-color: var(--hover-color);
    }

    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: none;
      border-radius: 5px;
      outline: none;
      background-color: var(--bg-dark);
      color: var(--text-light);
      box-sizing: border-box;
    }

    button.save-btn {
      width: 100%;
      padding: 10px;
      background-color: var(--price-color);
      color: var(--bg-dark);
      font-weight: bold;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 10px;
      transition: opacity 0.3s ease;
    }

    button.save-btn:hover {
      opacity: 0.9;
    }

    .back-btn {
      margin-top: 15px;
      display: inline-block;
      color: var(--hover-color);
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s ease;
    }

    .back-btn:hover {
      color: var(--text-primary);
    }

    .logout-btn {
      margin-top: 20px;
      background: none;
      border: none;
      color: #777;
      font-size: 14px;
      cursor: pointer;
      transition: color 0.3s;
      padding: 5px 10px;
    } 

    .logout-btn:hover {
      color: #ff4c4c;
    }

    .mensagem {
      margin: 15px 0;
      padding: 10px;
      border-radius: 5px;
      background-color: rgba(76, 175, 80, 0.2);
      color: #4CAF50;
      border: 1px solid #4CAF50;
    }

    .mensagem.erro {
      background-color: rgba(244, 67, 54, 0.2);
      color: #f44336;
      border: 1px solid #f44336;
    }

    .photo-section {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="profile-container">
    <h1>Meu Perfil</h1>

    <?php if ($mensagem): ?>
      <div class="mensagem <?php echo strpos($mensagem, 'Erro') !== false ? 'erro' : ''; ?>">
        <?php echo htmlspecialchars($mensagem); ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="perfil.php">
      <div class="photo-section">
        <img id="profile-pic" class="profile-pic" 
             src="https://cdn-icons-png.flaticon.com/512/847/847969.png" 
             alt="Foto de perfil">
        <br>
        <!-- Removido o botão de alterar foto temporariamente -->
        <!-- <button type="button" class="edit-btn" onclick="document.getElementById('foto-input').click()">Alterar Foto</button> -->
        <!-- <input type="file" id="foto-input" name="foto" class="file-input" accept="image/*" onchange="previewFoto(this)"> -->
      </div>

      <input type="text" id="username" name="username" placeholder="Nome de usuário" 
             value="<?php echo htmlspecialchars($usuario['username']); ?>" required>
      
      <input type="email" id="email" name="email" placeholder="E-mail" 
             value="<?php echo htmlspecialchars($usuario['email'] ?? ''); ?>">
      
      <input type="password" id="password" name="password" placeholder="Nova senha (opcional)">

      <button type="submit" class="save-btn" id="save-btn">Salvar Alterações</button>
    </form>

    <a href="index.php" class="back-btn">← Voltar para a loja</a>
    
    <form method="POST" action="logout.php" style="margin-top: 20px;">
      <button type="submit" class="logout-btn">Sair da conta</button>
    </form>
  </div>

  <script>
    // Validação do formulário
    document.querySelector('form').addEventListener('submit', function(e) {
      const username = document.getElementById('username').value.trim();
      if (!username) {
        e.preventDefault();
        alert("O nome de usuário não pode estar vazio.");
        return;
      }
    });
  </script>
</body>
</html>