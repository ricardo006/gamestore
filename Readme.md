# 🎮 GameStore - Loja de Jogos Digital

Uma aplicação web completa de loja de jogos digitais desenvolvida em PHP, MySQL e JavaScript.

## 📋 Pré-requisitos

- **Windows**
- **XAMPP** (PHP 8.0+ e MySQL)
- **Git** `git clone https://github.com/ricardo006/gamestore.git`
- **Navegador web moderno** (Chrome, Firefox, Edge)

## 🚀 Instalação do XAMPP

### 1. Download do XAMPP
Acesse [https://www.apachefriends.org/pt_br/index.html](https://www.apachefriends.org/pt_br/index.html) e baixe a versão mais recente para Windows.

### 2. Instalação
1. Execute o arquivo `.exe` baixado.
2. Se aparecer um aviso do Windows Defender, clique em "Mais informações" e "Executar mesmo assim".
3. No instalador, mantenha os componentes padrão selecionados (MySQL, PHP, phpMyAdmin, Apache Web Server).
4. Escolha o diretório de instalação (recomendado: `C:\xampp`).
5. Desmarque a opção "Learn more about Bitnami for XAMPP".
6. Clique em "Next" até completar a instalação.

### 3. Configuração do XAMPP
1. Abra o **XAMPP Control Panel** como Administrador.
2. Inicie os serviços:
   - 🟢 **Apache** (clique em "Start")
   - 🟢 **MySQL** (clique em "Start")
3. Verifique se os serviços ficaram com a porta verde.
4. Abra seu navegador e acesse: `http://localhost` para ver a página inicial do XAMPP.

## 📥 Clonagem do Repositório
- **Git** `git clone https://github.com/ricardo006/gamestore.git`

#### Digite code. que será aberto o projeto no VSCode


## 🗄️ Configuração do Banco de Dados

1.Acesse: http://localhost/phpmyadmin
2. Crie banco: gamestore
3. Execute os comandos em sequência, este SQL:

USE gamestore;

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100),
    password VARCHAR(255) NOT NULL,
    foto_perfil VARCHAR(255) DEFAULT 'https://cdn-icons-png.flaticon.com/512/847/847969.png',
    data_nascimento DATE NULL,
    bio TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de jogos
CREATE TABLE IF NOT EXISTS jogos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    imagem_url VARCHAR(500),
    categoria VARCHAR(50),
    desenvolvedora VARCHAR(100),
    publicadora VARCHAR(100),
    data_lancamento DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela biblioteca
CREATE TABLE IF NOT EXISTS biblioteca (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    jogo_id INT NOT NULL,
    data_aquisicao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    instalado BOOLEAN DEFAULT FALSE,
    data_instalacao TIMESTAMP NULL,
    venda_id INT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (jogo_id) REFERENCES jogos(id) ON DELETE CASCADE,
    UNIQUE KEY unique_usuario_jogo (usuario_id, jogo_id)
);

-- Tabela carrinho
CREATE TABLE IF NOT EXISTS carrinho (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    jogo_id INT NOT NULL,
    data_adicao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (jogo_id) REFERENCES jogos(id) ON DELETE CASCADE,
    UNIQUE KEY unique_usuario_jogo_carrinho (usuario_id, jogo_id)
);

-- Tabela de vendas
CREATE TABLE IF NOT EXISTS vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    data_venda TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pendente', 'concluida', 'cancelada') DEFAULT 'concluida',
    metodo_pagamento VARCHAR(50),
    data_conclusao TIMESTAMP NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabela itens_venda
CREATE TABLE IF NOT EXISTS itens_venda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venda_id INT NOT NULL,
    jogo_id INT NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (venda_id) REFERENCES vendas(id) ON DELETE CASCADE,
    FOREIGN KEY (jogo_id) REFERENCES jogos(id) ON DELETE CASCADE
);

-- Tabela métodos de pagamento
CREATE TABLE IF NOT EXISTS metodos_pagamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao VARCHAR(255),
    ativo BOOLEAN DEFAULT TRUE
);

-- Tabela galeria de imagens
CREATE TABLE jogo_galeria (
    id INT PRIMARY KEY AUTO_INCREMENT,
    jogo_id INT,
    imagem_url VARCHAR(500),
    ordem INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (jogo_id) REFERENCES jogos(id) ON DELETE CASCADE
);

-- Tabela requisitos do sistema
CREATE TABLE jogo_requisitos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    jogo_id INT,
    tipo ENUM('minimo', 'recomendado'),
    requisito TEXT,
    ordem INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (jogo_id) REFERENCES jogos(id) ON DELETE CASCADE
);

-- Inserir métodos de pagamento
INSERT INTO metodos_pagamento (nome, descricao) VALUES 
('cartao_credito', 'Cartão de Crédito'),
('cartao_debito', 'Cartão de Débito'),
('pix', 'PIX'),
('boleto', 'Boleto Bancário');

-- Inserir jogos
INSERT INTO jogos (titulo, descricao, preco, imagem_url, categoria, desenvolvedora, publicadora, data_lancamento) VALUES
('God of War Ragnarök', 'Kratos e Atreus embarcam em uma jornada épica em meio a mitologia nórdica', 249.90, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2322010/header.jpg?t=1750909504', 'acao-aventura', 'Santa Monica Studio', 'Sony Interactive Entertainment', '2022-11-09'),
('Forza Horizon 5', 'Experimente a aventura automotiva definitiva no México', 249.00, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1551360/header.jpg?t=1746471508', 'esportes-corrida', 'Playground Games', 'Xbox Game Studios', '2021-11-09'),
('Elden Ring', 'Um RPG de ação em mundo aberto cheio de segredos e perigos', 274.50, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1245620/header.jpg?t=1748630546', 'rpg', 'FromSoftware', 'Bandai Namco Entertainment', '2022-02-25'),
('Cyberpunk 2077', 'Um RPG de mundo aberto no distópico Night City', 199.90, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1091500/e9047d8ec47ae3d94bb8b464fb0fc9e9972b4ac7/header.jpg?t=1756209867', 'rpg', 'CD Projekt Red', 'CD Projekt', '2020-12-10'),
('Hollow Knight', 'Um aclamado jogo de ação e aventura em um mundo de insetos', 46.99, 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/367520/header.jpg?t=1695270428', 'indie', 'Team Cherry', 'Team Cherry', '2017-02-24'),
('Resident Evil 4', 'Remake do clássico de survival horror', 169.00, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2050650/header.jpg?t=1736385712', 'terror', 'Capcom', 'Capcom', '2023-03-24'),
('Minecraft', 'O famoso jogo de construção e aventura em mundo aberto', 199.00, 'https://store-images.s-microsoft.com/image/apps.29741.13774133678237924.b2fb64a6-d8b2-4e05-a188-b727d48563ed.f5bc1582-f67e-4ef4-8d8a-7aac86b324f9?q=90&w=336&h=200', 'sobrevivência', 'Mojang Studios', 'Xbox Game Studios', '2011-11-18'),
('Civilization VI', 'Construa um império para resistir ao teste do tempo no jogo de estratégia por turnos definitivo.', 129.00, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/289070/header.jpg?t=1740607040', 'estrategia', 'Firaxis Games', '2K Games', '2016-10-21'),
('Grand Theft Auto V', 'Entre nas vidas de três criminosos muito diferentes em assaltos ousados.', 224.90, 'https://www.memoriabit.com.br/wp-content/uploads/2013/09/gta-v-banner.webp', 'acao-aventura', 'Rockstar North', 'Rockstar Games', '2013-09-17'),
('Battlefield 6', 'Experimente a guerra moderna em grande escala com batalhas épicas.', 299.90, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2807960/c12d12ce3c7d217398d3fcad77427bfc9d57c570/header.jpg?t=1761693796', 'fps', 'EA DICE', 'Electronic Arts', '2021-11-19'),
('Ghost Of Tsushima', 'Enfrente invasores mongóis como um samurai lendário.', 249.90, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2215430/header.jpg?t=1761681181', 'rpg', 'Sucker Punch Productions', 'Sony Interactive Entertainment', '2020-07-17'),
('Flight Simulator 2024', 'A próxima geração do simulador de voo mais popular.', 299.99, 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/2537590/header.jpg?t=1747324291', 'simulação', 'Asobo Studio', 'Xbox Game Studios', '2024-11-19'),
('Euro Truck Simulator 2', 'Viaje pela Europa como rei da estrada.', 61.99, 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/227300/d3c44cfff95e8223687121b05c80e594d35c4c53/header_alt_assets_7.jpg?t=1760622979', 'simulação', 'SCS Software', 'SCS Software', '2012-10-18'),
('Jurassic World Evolution 3', 'Construa seu próprio parque jurássico.', 226.00, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2958130/df39f8c59232633e8e01ab63313b095402bdd0d5/header.jpg?t=1761208654', 'simulação', 'Frontier Developments', 'Frontier Developments', '2024-11-30'),
('No Man''s Sky', 'Explore um universo infinito.', 162.00, 'https://shared.fastly.steamstatic.com//store_item_assets/steam/apps/275850/00e3557fd1e8acc1605a6031099e1f41bc7f7d88/capsule_616x353_alt_assets_25.jpg?t=1761138171', 'aventura', 'Hello Games', 'Hello Games', '2016-08-12'),
('Dead by Daylight', 'Horror de sobrevivência multiplayer (4x1).', 69.99, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/381210/header.jpg?t=1760636583', 'acao', 'Behaviour Interactive', 'Behaviour Interactive', '2016-06-14'),
('Diablo® IV', 'A mais recente entrada na premiada série de RPG.', 229.00, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2344520/80f21a42e378b93e8fbb68ee43103be8ab84891b/header.jpg?t=1758649357', 'rpg', 'Blizzard Team 3', 'Blizzard Entertainment', '2023-06-05'),
('Control', 'Lute para retomar o controle de uma agência secreta.', 99.99, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/870780/header.jpg?t=1755611834', 'acao', 'Remedy Entertainment', '505 Games', '2019-08-27'),
('PEAK', 'Experiência indie única que combina puzzle e aventura.', 23.99, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/3527290/31bac6b2eccf09b368f5e95ce510bae2baf3cfcd/header.jpg?t=1761788282', 'indie', 'Peak Studios', 'IndiePub', '2024-12-31'),
('Resident Evil 7 Biohazard', 'Reinvenção da série Resident Evil.', 89.00, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/418370/header.jpg?t=1728436752', 'terror', 'Capcom', 'Capcom', '2017-01-24'),
('Resident Evil Village', '8ª sequência principal da franquia Resident Evil.', 169.00, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1196590/header.jpg?t=1741142800', 'terror', 'Capcom', 'Capcom', '2021-05-07'),
('Outlast', 'Survival horror em um hospital psiquiátrico.', 46.99, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/238320/header.jpg?t=1666817106', 'terror', 'Red Barrels', 'Red Barrels', '2013-09-04'),
('The Witcher 3: Wild Hunt', 'RPG de mundo aberto de fantasia premiado.', 129.99, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/292030/ad9240e088f953a84aee814034c50a6a92bf4516/header.jpg?t=1761131270', 'rpg', 'CD Projekt Red', 'CD Projekt', '2015-05-18'),
('Green Hell', 'Sobrevivência na selva amazônica.', 47.49, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/815370/header.jpg?t=1757690850', 'sobrevivência', 'Creepy Jar', 'Creepy Jar', '2019-09-05'),
('ARC Raiders', 'Tiro cooperativo contra ameaças mecânicas.', 171.80, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1808500/04baafaf64a5aa5f46ecda5d71889a4848dc0628/header.jpg?t=1762957298', 'acao', 'Embark Studios', 'Nexon', '2024-12-31'),
('Hollow Knight: Silksong', 'Aventura como Hornet em mundo totalmente novo.', 59.99, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1030300/7983574d464e6559ac7e24275727f73a8bcca1f3/header.jpg?t=1756994410', 'aventura', 'Team Cherry', 'Team Cherry', '2024-12-31'),
('Path Of Exile II', 'Próximo jogo de RPG de ação complexo.', 79.80, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2694490/bb2944f7d5c6e8e008c882938fddaa5ec6061457/header.jpg?t=1762717997', 'rpg', 'Grinding Gear Games', 'Grinding Gear Games', '2024-12-31'),
('Raft', 'Sobrevivência em oceano coletando detritos.', 36.99, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/648800/header.jpg?t=1727184011', 'sobrevivência', 'Redbeet Interactive', 'Axolot Games', '2018-05-23');

-- Galeria de imagens
INSERT INTO jogo_galeria (jogo_id, imagem_url, ordem) VALUES
(16, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/381210/ss_659500624438a4aa77bfdf304cba3ecebcd92ed9.600x338.jpg?t=1760636583', 1),
(16, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/381210/ss_ca6b39f2fcac8feb75d23976b1be31290d58d159.600x338.jpg?t=1760636583', 2),
(17, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2344520/11d4a9be127719b22681d823b83b0c6b4798bf1f/ss_11d4a9be127719b22681d823b83b0c6b4798bf1f.600x338.jpg?t=1758649357', 1),
(17, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2344520/ee4b4e1ba9c8a07f40aff563c7c43fd04477d60c/ss_ee4b4e1ba9c8a07f40aff563c7c43fd04477d60c.600x338.jpg?t=1758649357', 2);

-- Requisitos do sistema
INSERT INTO jogo_requisitos (jogo_id, tipo, requisito, ordem) VALUES
(16, 'minimo', 'SO: Windows 10 64-bit Operating System', 1),
(16, 'minimo', 'Processador: Intel Core i3-4170 or AMD FX-8120', 2),
(16, 'minimo', 'Memória: 8 GB de RAM', 3),
(16, 'recomendado', 'SO: Windows 10 64-bit Operating System', 1),
(16, 'recomendado', 'Processador: Intel Core i3-4170 or AMD FX-8300 or higher', 2),
(16, 'recomendado', 'Memória: 8 GB de RAM', 3);


## 🌐 Acesso à Aplicação

1. Acesse: http://localhost/gamestore
2. Cadastre-se ou faça Login
3. Explore a loja, biblioteca e carrinho