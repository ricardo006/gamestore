<?php
// login.php
session_start();

// Se já estiver logado, redireciona para a página principal
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Configurações do banco de dados
$host = "localhost";
$dbname = "gamestore";
$username = "root";
$password = "";

// Conectar ao banco de dados
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Em caso de erro, ainda mostra a página mas sem funcionalidade do banco
    $pdo = null;
}

// Processar login
$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error_msg = "Preencha todos os campos.";
    } else if ($pdo) {
        // Buscar usuário no banco
        try {
            $stmt = $pdo->prepare("SELECT id, username, password FROM usuarios WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            
            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Verificar senha
                if (password_verify($password, $user['password'])) {
                    // Login bem-sucedido
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    
                    // Atualizar último login
                    $update_stmt = $pdo->prepare("UPDATE usuarios SET ultimo_login = NOW() WHERE id = :id");
                    $update_stmt->bindParam(':id', $user['id']);
                    $update_stmt->execute();
                    
                    // Redirecionar para página principal
                    header("Location: index.php");
                    exit;
                } else {
                    $error_msg = "Usuário ou senha incorretos!";
                }
            } else {
                $error_msg = "Usuário ou senha incorretos!";
            }
        } catch(PDOException $e) {
            $error_msg = "Erro no login. Tente novamente.";
        }
    } else {
        $error_msg = "Erro de conexão com o banco de dados.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@300;400;600;700&display=swap" rel="stylesheet">
  <title>Login - GameStore</title>

  <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Oxanium', sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .container {
        background: rgba(240, 242, 247, 0.85);   /* Transparência do vidro */
        border-radius: 30px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(15px);            /* Efeito de desfoque atrás */
        -webkit-backdrop-filter: blur(15px);    /* Suporte Safari */
        border: 1px solid rgba(255, 255, 255, 0.3); /* Borda suave de vidro */

        padding: 40px;
        width: 100%;
        max-width: 450px;
    }

    .logo {
        text-align: center;
        margin-bottom: 30px;
    }

    .logo h1 {
        color: #333;
        font-size: 2.5em;
        font-weight: bold;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 30px;
        font-size: 1.8em;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-weight: 500;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e1e1e1;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .btn {
        width: 100%;
        min-height: 50px;
        padding: 12px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 16px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .message {
        text-align: center;
        margin: 20px 0;
        padding: 12px;
        border-radius: 8px;
        font-weight: 500;
    }

    .error {
        background-color: #fee;
        color: #c33;
        border: 1px solid #fcc;
    }

    .success {
        background-color: #efe;
        color: #363;
        border: 1px solid #cfc;
    }

    .register-link {
        text-align: center;
        margin-top: 25px;
        color: #666;
    }

    .register-link a {
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .register-link a:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    .forgot-password {
        text-align: center;
        margin-top: 15px;
    }

    .forgot-password a {
        color: #666;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s ease;
    }

    .forgot-password a:hover {
        color: #667eea;
        text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="logo">
        <h1>🎮 GameStore</h1>
    </div>
    
    <h2>Entrar na Conta</h2>
    
    <?php if (!empty($error_msg)): ?>
        <div class="message error"><?php echo $error_msg; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="username">Nome de Usuário:</label>
            <input type="text" id="username" name="username" placeholder="Digite seu usuário" required 
                   value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
        </div>
        
        <div class="form-group">
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
        </div>
        
        <button type="submit" class="btn">Entrar</button>
    </form>

    <div class="forgot-password">
        <a href="#">Esqueceu sua senha?</a>
    </div>
    
    <div class="register-link">
        Não tem uma conta? <a href="register.php">Crie uma conta aqui</a>
    </div>
  </div>
</body>
</html>