<?php
session_start();

// Se já estiver logado, redireciona
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Configurações MySQL
$host = "localhost";
$dbname = "gamestore";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Criar tabela se não existir
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
            ultimo_login DATETIME NULL
        )
    ");
    
} catch (PDOException $e) {
    // Verifica se o erro é de banco não encontrado
    if ($e->getCode() == 1049) {
        die("Erro: Banco de dados 'gamestore' não encontrado. 
             <br><br>
             <strong>Solução:</strong>
             <ol>
             <li>Abra o phpMyAdmin (http://localhost/phpmyadmin)</li>
             <li>Clique em 'Novo' no menu lateral</li>
             <li>Digite 'gamestore' como nome do banco</li>
             <li>Clique em 'Criar'</li>
             <li>Atualize esta página</li>
             </ol>");
    } else {
        die("Erro de conexão: " . $e->getMessage());
    }
}

// Processamento do formulário
$error_msg = "";
$success_msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm_password']);

    // Validações
    if (empty($username) || empty($password) || empty($confirm)) {
        $error_msg = "Preencha todos os campos.";
    } elseif (strlen($username) < 3) {
        $error_msg = "O nome de usuário deve ter pelo menos 3 caracteres.";
    } elseif ($password !== $confirm) {
        $error_msg = "As senhas não coincidem.";
    } elseif (strlen($password) < 6) {
        $error_msg = "A senha deve ter pelo menos 6 caracteres.";
    } else {
        try {
            // Verificar duplicidade
            $check = $pdo->prepare("SELECT id FROM usuarios WHERE username = ?");
            $check->execute([$username]);

            if ($check->fetch()) {
                $error_msg = "Este nome de usuário já está em uso.";
            } else {
                // Criar usuário
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $insert = $pdo->prepare("
                    INSERT INTO usuarios (username, password)
                    VALUES (?, ?)
                ");

                if ($insert->execute([$username, $hash])) {
                    $success_msg = "Conta criada com sucesso! Redirecionando para login...";
                    header("refresh:2;url=login.php");
                } else {
                    $error_msg = "Erro ao criar conta.";
                }
            }
        } catch (PDOException $e) {
            $error_msg = "Erro no banco: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - GameStore</title>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@300;400;600;700&display=swap" rel="stylesheet">

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

        .login-link {
            text-align: center;
            margin-top: 25px;
            color: #666;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .requirements {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .requirements h4 {
            margin-bottom: 10px;
            color: #333;
        }

        .requirements ul {
            list-style: none;
            padding-left: 0;
        }

        .requirements li {
            margin-bottom: 5px;
            padding-left: 20px;
            position: relative;
        }

        .requirements li:before {
            content: "•";
            color: #667eea;
            position: absolute;
            left: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1>🎮 GameStore</h1>
        </div>
        
        <h2>Criar Conta</h2>
        
        <?php if ($error_msg): ?>
            <div class="message error"><?php echo $error_msg; ?></div>
        <?php endif; ?>
        
        <?php if ($success_msg): ?>
            <div class="message success"><?php echo $success_msg; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="username">Nome de Usuário:</label>
                <input type="text" id="username" name="username" required 
                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirmar Senha:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="btn">Criar Conta</button>
        </form>
        
        <div class="requirements">
            <h4>Requisitos da conta:</h4>
            <ul>
                <li>Nome de usuário deve ter pelo menos 3 caracteres</li>
                <li>Senha deve ter pelo menos 6 caracteres</li>
                <li>As senhas devem coincidir</li>
            </ul>
        </div>
        
        <div class="login-link">
            Já tem uma conta? <a href="login.php">Faça login aqui</a>
        </div>
    </div>
</body>
</html>