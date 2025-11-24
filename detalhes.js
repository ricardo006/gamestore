document.addEventListener('DOMContentLoaded', () => {
    // 1. Banco de dados com as informações dos seus jogos


    const gameData = {
        'god-of-war': {
            title: 'God of War Ragnarök',
            categorySimple: 'Ação / Aventura / RPG',
            price: 'R$ 249,90',
            image: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2322010/header.jpg?t=1750909504',
            description: 'A saga nórdica continua. Do Santa Monica Studio, em parceria com a Jetpack Interactive, chega God of War Ragnarök, uma jornada épica e comovente sobre laços, destino e superação. Sequência direta do aclamado God of War (2018), o jogo começa em meio ao Fimbulwinter, o rigoroso inverno que antecede o fim dos tempos. Kratos e Atreus embarcam em uma viagem pelos Nove Reinos em busca de respostas, enquanto as forças de Odin em Asgard se preparam para a batalha profetizada que decidirá o destino de todos. Nessa jornada, pai e filho explorarão paisagens míticas deslumbrantes, enfrentarão deuses poderosos e criaturas aterradoras, e descobrirão que o verdadeiro conflito pode estar dentro deles mesmos. À medida que o Ragnarök se aproxima, eles terão de escolher entre proteger o que amam ou salvar os reinos da destruição.',
            publisher: 'Sony Interactive Entertainment',
            developer: 'Santa Monica Studio',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2322010/ss_7c59382e67eadf779e0e15c3837ee91158237f11.600x338.jpg?t=1750909504',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2322010/ss_05f27139b15c5410d07cd59b7b52adbdf73e13da.600x338.jpg?t=1750909504',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2322010/ss_974a7b998c0c14da7fe52a342cf36c98850a57ac.600x338.jpg?t=1750909504',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2322010/ss_78350297511e81f287b4bc361935efbc3016f6db.600x338.jpg?t=1750909504',
            ],
            requirements: {
                min: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows 10 20H1",
                    "Processador: Intel i5-4670k or AMD Ryzen 3 1200",
                    "Memória: 8 GB RAM",
                    "Placa de vídeo: NVIDIA GTX 1060 (6GB) or AMD RX 5500 XT (8GB) or Intel Arc A750",
                    "DirectX: Versão 12",
                    "Armazenamento: 190 GB de espaço disponível"
                ],
                rec: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows 10 20H1",
                    "Processador: Intel i5-8600 or AMD Ryzen 5 3600",
                    "Memória: 16 GB RAM",
                    "Placa de vídeo: NVIDIA RTX 2060 Super or AMD RX 5700 or Intel Arc A770",
                    "DirectX: Versão 12",
                    "Armazenamento: 190 GB de espaço disponível"
                ]
            }
        },
        'forza-5': {
            title: 'Forza Horizon 5',
            categorySimple: 'Esportes / Corrida',
            price: 'R$ 249,00',
            image: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1551360/header.jpg?t=1746471508',
            description: 'Sua maior aventura Horizon te espera! Lidere expedições impressionantes por um mundo aberto vibrante e em constante evolução, ambientado nas deslumbrantes terras mexicanas. Participe de corridas eletrizantes e cheias de liberdade, pilotando centenas dos melhores carros do mundo enquanto desafia os limites da velocidade. Explore um mundo vasto e diverso, repleto de contrastes e beleza — de desertos vivos e selvas exuberantes a cidades históricas, ruínas misteriosas, praias intocadas, desfiladeiros profundos e até um imponente vulcão de cume nevado. Essa é a sua Aventura Horizon — um festival de exploração, velocidade e emoção sem fim.',
            publisher: 'Xbox Game Studios',
            developer: 'Playground Games',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1551360/ss_cf56e25a0290556ba83229eb0ab370d10be0407c.600x338.jpg?t=1746471508',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1551360/ss_00f0090174380eeaf8753bd3d1028b6772c3aebf.600x338.jpg?t=1746471508',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1551360/ss_b65236b365315ebb6da6114ce42cd74b59cab3c8.600x338.jpg?t=1746471508',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1551360/ss_0a13a7ccd38e7c3e6a5f1720050732833b53b6a8.600x338.jpg?t=1746471508',
            ],
            requirements: {
                min: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows® 10 versão 18362.0 ou superior",
                    "Processador: Intel® Core™ i5-4460 ou AMD Ryzen™ 3 1200",
                    "Memória: 8 GB de RAM",
                    "Placa de vídeo: NVIDIA® GeForce® GTX 970, AMD Radeon™ RX 470 ou Intel® Arc™ A380",
                    "DirectX: Versão 12",
                    "Rede: Conexão de internet banda larga",
                    "Armazenamento: 110 GB de espaço disponível"
                ],
                rec: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows® 10 versão 18362.0 ou superior",
                    "Processador: Intel® Core™ i5-8400 ou AMD Ryzen™ 5 1500X",
                    "Memória: 16 GB de RAM",
                    "Placa de vídeo: NVIDIA® GeForce® GTX 1070, AMD Radeon™ RX 590 ou Intel® Arc™ A750",
                    "DirectX: Versão 12",
                    "Rede: Conexão de internet banda larga",
                    "Armazenamento: 110 GB de espaço disponível"
                ]
            }
        },
        'elden-ring': {
            title: 'Elden Ring',
            categorySimple: 'Ação',
            price: 'R$ 274,50',
            image: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1245620/header.jpg?t=1748630546',
            description: 'O novo RPG de ação e fantasia chegou. Levante-se, Maculado, e siga o chamado da graça para empunhar o poder do Anel Prístino e se tornar um Lorde Prístino nas Terras Intermédias. Explore um mundo vasto e emocionante, onde campos abertos, masmorras colossais e ambientes tridimensionais se conectam de forma fluida, oferecendo descobertas constantes e desafios imprevisíveis. Aventure-se por paisagens grandiosas e enfrente ameaças poderosas e desconhecidas, sentindo a verdadeira emoção da conquista. Crie e personalize seu herói livremente — combine armas, armaduras e magias, moldando seu estilo de combate. Torne-se um guerreiro temível pela força bruta ou um mestre das artes arcanas. Em um mundo moldado por ambição, glória e ruína, apenas os dignos alcançarão a graça.',
            publisher: 'Bandai Namco',
            developer: 'FromSoftware',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1245620/ss_943bf6fe62352757d9070c1d33e50b92fe8539f1.600x338.jpg?t=1748630546',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1245620/ss_dcdac9e4b26ac0ee5248bfd2967d764fd00cdb42.600x338.jpg?t=1748630546',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1245620/ss_3c41384a24d86dddd58a8f61db77f9dc0bfda8b5.600x338.jpg?t=1748630546',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1245620/ss_e0316c76f8197405c1312d072b84331dd735d60b.600x338.jpg?t=1748630546',
            ],
            requirements: {
                min: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows® 10",
                    "Processador: Intel® Core™ i5-8400 ou AMD Ryzen™ 3 3300X",
                    "Memória: 12 GB de RAM",
                    "Placa de vídeo: NVIDIA® GeForce® GTX 1060 3 GB ou AMD Radeon™ RX 580 4 GB",
                    "DirectX: Versão 12",
                    "Armazenamento: 60 GB de espaço disponível",
                    "Placa de som: Dispositivo de áudio compatível com Windows",
                    "Outras Observações:"
                ],
                rec: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows® 10/11",
                    "Processador: Intel® Core™ i7-8700K ou AMD Ryzen™ 5 3600X",
                    "Memória: 16 GB de RAM",
                    "Placa de vídeo: NVIDIA® GeForce® GTX 1070 8 GB ou AMD Radeon™ RX Vega 56 8 GB",
                    "DirectX: Versão 12",
                    "Armazenamento: 60 GB de espaço disponível",
                    "Placa de som: Dispositivo de áudio compatível com Windows",
                    "Outras Observações:"
                ]
            }

        },
        'cyberpunk': {
            title: 'Cyberpunk 2077',
            categorySimple: 'Ação',
            price: 'R$ 199,90',
            image: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1091500/e9047d8ec47ae3d94bb8b464fb0fc9e9972b4ac7/header.jpg?t=1756209867',
            description: 'Cyberpunk 2077 é um RPG de ação e aventura em mundo aberto, ambientado na vibrante e caótica megalópole de Night City, onde você assume o papel de um mercenário cyberpunk em uma intensa luta pela sobrevivência. Com diversas melhorias e conteúdos adicionais gratuitos, personalize seu personagem e seu estilo de jogo enquanto aceita contratos, constrói sua reputação e desbloqueia aprimoramentos poderosos. Suas escolhas e relacionamentos moldarão o rumo da história e o destino do mundo ao seu redor. Aqui nascem as lendas — qual será a sua? Desfrute de novos recursos de direção e mobilidade com o AutoDrive™ e o serviço de táxi Delamain, encare missões inéditas para conquistar veículos exclusivos e use as tecnologias CrystalCoat e TwinTone para personalizar cada detalhe do seu carro. Capture tudo com profundidade no aprimorado Modo Fotografia, e viva Night City como nunca antes.',
            publisher: 'CD PROJEKT RED',
            developer: 'CD PROJEKT RED',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1091500/ss_2f649b68d579bf87011487d29bc4ccbfdd97d34f.600x338.jpg?t=1756209867',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1091500/ss_0e64170751e1ae20ff8fdb7001a8892fd48260e7.600x338.jpg?t=1756209867',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1091500/ss_af2804aa4bf35d4251043744412ce3b359a125ef.600x338.jpg?t=1756209867',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1091500/ss_7924f64b6e5d586a80418c9896a1c92881a7905b.600x338.jpg?t=1756209867',
            ],
            requirements: {
                min: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows® 10, 64-bit",
                    "Processador: Intel® Core™ i7-6700 ou AMD Ryzen™ 5 1600",
                    "Memória: 12 GB de RAM",
                    "Placa de vídeo: NVIDIA® GeForce® GTX 1060 6 GB ou AMD Radeon™ RX 580 8 GB ou Intel® Arc™ A380",
                    "DirectX: Versão 12",
                    "Armazenamento: 70 GB de espaço disponível",
                    "Outras Observações: Requer SSD. Atenção: Este jogo contém uma variedade de efeitos visuais que podem causar convulsões ou perda de consciência em uma minoria de pessoas. Se você ou alguém que você conhece apresentar qualquer um desses sintomas durante o jogo, pare imediatamente e procure atendimento médico."
                ],
                rec: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows® 10, 64-bit",
                    "Processador: Intel® Core™ i7-12700 ou AMD Ryzen™ 7 7800X3D",
                    "Memória: 16 GB de RAM",
                    "Placa de vídeo: NVIDIA® GeForce® RTX 2060 SUPER ou AMD Radeon™ RX 5700 XT ou Intel® Arc™ A770",
                    "DirectX: Versão 12",
                    "Armazenamento: 70 GB de espaço disponível",
                    "Outras Observações: Requer SSD."
                ]
            }

        },
        'civilization-6': {
            title: 'Civilization VI',
            categorySimple: 'Estratégia',
            price: 'R$ 129,00',
            image: 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/289070/header.jpg?t=1740607040',
            description: 'Construa um império destinado a atravessar os séculos. Em Sid Meier’s Civilization VI, você lidera sua civilização desde os primórdios da Idade da Pedra até as fronteiras da Era da Informação, guiando seu povo através dos maiores avanços da humanidade e dos desafios da história. Expanda suas cidades por vastos territórios, descubra tecnologias revolucionárias, estabeleça alianças diplomáticas e enfrente líderes lendários em uma batalha pela supremacia global. Pela primeira vez na série, as cidades se expandem de forma dinâmica pelo mapa, tornando cada decisão de posicionamento e desenvolvimento essencial para o sucesso. Gerencie recursos, planeje estratégias e adapte-se a um mundo vivo e em constante mudança. Explore terras desconhecidas, construa monumentos imponentes, negocie com sabedoria ou conquiste com poder — há múltiplos caminhos para a glória, seja militar, científica, cultural, religiosa ou diplomática. Cada movimento molda o futuro. Cada escolha define a história. Em Civilization VI, o destino do mundo está em suas mãos.',
            publisher: '2K Games',
            developer: 'Firaxis Games',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/289070/ss_12cc6e1f4084de5bc0f66bfdbe3aaf3e59388b53.600x338.jpg?t=1740607040',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/289070/ss_6c4a3cfb61f1a9677cf2ac549c2816a4e651f741.600x338.jpg?t=1740607040',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/289070/ss_b2bf12299c38214fe520af0f724a6349d17ed330.600x338.jpg?t=1740607040',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/289070/ss_7f598198526afc260d939a98af4d76d95f5349e4.600x338.jpg?t=1740607040',
            ],
            requirements: {
                min: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows® 7x64 / Windows® 8.1x64 / Windows® 10x64",
                    "Processador: Intel® Core™ i3 2.5 GHz ou AMD Phenom™ II 2.6 GHz ou superior",
                    "Memória: 4 GB de RAM",
                    "Placa de vídeo: 1 GB — AMD Radeon™ 5570 ou NVIDIA® GeForce® 450 ou Intel® Integrated Graphics 530",
                    "DirectX: Versão 11",
                    "Armazenamento: 17 GB de espaço disponível",
                    "Placa de som: Dispositivo de som compatível com DirectX",
                    "Outras Observações: A instalação inicial requer conexão única à Internet para autenticação via Steam; instalações de software necessárias (incluídas com o jogo) incluem o cliente Steam, as bibliotecas de tempo de execução Microsoft Visual C++ 2012 e 2015 e o Microsoft DirectX. Conexão com a Internet e aceitação do Acordo de Assinante Steam™ são obrigatórias para ativação."
                ],
                rec: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows® 7x64 / Windows® 8.1x64 / Windows® 10x64",
                    "Processador: Intel® Core™ i5 de quarta geração 2.5 GHz ou AMD FX™-8350 4.0 GHz ou superior",
                    "Memória: 8 GB de RAM",
                    "Placa de vídeo: 2 GB — AMD Radeon™ 7970 ou NVIDIA® GeForce® 770 ou superior",
                    "DirectX: Versão 11",
                    "Armazenamento: 23 GB de espaço disponível",
                    "Placa de som: Dispositivo de som compatível com DirectX"
                ]
            }

        },
        'hollow-knight': {
            title: 'Hollow Knight',
            categorySimple: 'Indie',
            price: 'R$ 46,99',
            image: 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/367520/header.jpg?t=1695270428',
            description: 'Abaixo da cidade moribunda de Dirtmouth jaz um reino antigo e arruinado. Muitos são atraídos para o subterrâneo em busca de riquezas, glórias ou respostas para antigos segredos. Hollow Knight é uma aventura de ação clássica em estilo 2D por um vasto mundo interligado.Explore cavernas serpenteantes, cidades antigas e ermos mortais; lute contra criaturas malignas e alie- se a insetos bizarros, e solucione mistérios antigos no centro do reino.',
            publisher: 'Team Cherry',
            developer: 'Team Cherry',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/367520/ss_d5b6edd94e77ba6db31c44d8a3c09d807ab27751.jpg',
                'https://i.pinimg.com/736x/e4/6c/d9/e46cd932609864801ce2ae8312faf855.jpg',
                'https://images.steamusercontent.com/ugc/919168520695744798/F763550B6580A7A0869171D28210973EFC6FDD5E/?imw=1024&imh=640&ima=fit&impolicy=Letterbox&imcolor=%23000000&letterbox=true',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/367520/ss_a81e4231cc8d55f58b51a4a938898af46503cae5.jpg'
            ],
            requirements: {
                min: [
                    "SO: Windows 7",
                    "Processador: Intel Core 2 Duo E5200",
                    "Memória: 4 GB RAM",
                    "Placa de vídeo: GeForce 9800GTX+",
                    "DirectX: Versão 10",
                    "Armazenamento: 9 GB"
                ],
                rec: [
                    "SO: Windows 10",
                    "Processador: Intel Core i5",
                    "Memória: 8 GB RAM",
                    "Placa de vídeo: GeForce GTX 560",
                    "DirectX: Versão 11",
                    "Armazenamento: 9 GB"
                ]
            }
        },
        'gta-v': {
            title: 'Grand Theft Auto V',
            categorySimple: 'Ação',
            price: 'R$ 224,90   ',
            image: 'https://www.memoriabit.com.br/wp-content/uploads/2013/09/gta-v-banner.webp',
            description: 'Quando um tratante inexperiente, um ladrão de bancos aposentado e um psicopata aterrorizante se envolvem com algumas das figuras mais assustadoras e problemáticas do submundo do crime, do governo dos EUA e da indústria do entretenimento, eles precisam realizar uma série de golpes ousados para sobreviver em uma cidade implacável onde não podem confiar em ninguém, nem mesmo um no outro.',
            publisher: 'Rokstar Games',
            developer: 'Rokstar North',
            gallery: [
                'https://media.rockstargames.com/rockstargames/img/global/news/upload/12_gtavpc_03272015.jpg',
                'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHKYzDKBTADcLfVaBYOBCYHYS3C8mfi17wCg&s',
                'https://i.redd.it/gta-v-enhanced-pc-screenshots-look-insane-v0-geusoalg9gme1.jpg?width=3840&format=pjpg&auto=webp&s=3e98c51689c13eeb55d450d17867694b44edb409',
                'https://media.rockstargames.com/rockstargames/img/global/news/upload/3_gtavpc_03272015.jpg'
            ],
            requirements: {
                min: [
                    "SO: Windows 10 64 Bit",
                    "Processador: Intel Core 2 Quad CPU Q6600 | AMD Phenom 9850",
                    "Memória: 4 GB RAM",
                    "Placa de vídeo: NVIDIA 9800 GT 1GB | AMD HD 4870 1GB",
                    "DirectX: Versão 10",
                    "Armazenamento: 120 GB HDD"
                ],
                rec: [
                    "SO: Windows 10 64 Bit",
                    "Processador: Intel Core i5 3470 | AMD X8 FX-8350",
                    "Memória: 8 GB RAM",
                    "Placa de vídeo: NVIDIA GTX 660 2GB | AMD HD7870 2GB",
                    "Armazenamento: 120 GB HDD"
                ]
            }
        },
        'bf-6': {
            title: 'Battlefield 6',
            categorySimple: 'FPS, Ação',
            price: 'R$ 299,90',
            image: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2807960/c12d12ce3c7d217398d3fcad77427bfc9d57c570/header.jpg?t=1761693796',
            description: 'A experiência da guerra total definitiva. Lute em combates de infantaria de alta intensidade. Corte os céus em combates aéreos. Destrua seu ambiente para ter uma vantagem estratégica. Use controle total sobre cada ação e movimento usando o Sistema de Combate Cinestésico. Numa guerra de tanques, jatos e enormes arsenais de combate, a arma mais mortal é o seu pelotão. Este é o Battlefield 6.',
            publisher: 'Eletronic Arts',
            developer: 'Battlefield Studios',
            gallery: [
                'https://i.redd.it/bf6-graphics-details-and-atmosphere-nailed-some-screenshots-v0-i19nzgl42z2f1.jpg?width=1280&format=pjpg&auto=webp&s=f264c2a4afa285adc32cb46b4e499f1d260d5e64',
                'https://static0.polygonimages.com/wordpress/wp-content/uploads/2025/07/bf6-screen-2.png?w=1600&h=1200&fit=crop',
                'https://i.redd.it/bf6-screenshots-v0-ghbbife3nytf1.jpg?width=2340&format=pjpg&auto=webp&s=b253842b4b2996a44cad8c889ff9a2e7a362669d',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2807960/a42a2caf3cb993befd5ef4eb9424934034538582/ss_a42a2caf3cb993befd5ef4eb9424934034538582.jpg'
            ],
            requirements: {
                min: [
                    "SO: Windows 10 64 Bit",
                    "Processador: Intel Core 2 Quad CPU Q6600 | AMD Phenom 9850",
                    "Memória: 4 GB RAM",
                    "Placa de vídeo: NVIDIA 9800 GT 1GB | AMD HD 4870 1GB",
                    "DirectX: Versão 10",
                    "Armazenamento: 120 GB HDD"
                ],
                rec: [
                    "SO: Windows 10 64 Bit",
                    "Processador: Intel Core i5 3470 | AMD X8 FX-8350",
                    "Memória: 8 GB RAM",
                    "Placa de vídeo: NVIDIA GTX 660 2GB | AMD HD7870 2GB",
                    "Armazenamento: 120 GB HDD"
                ]
            }
        },
        'ghost-of-tsushima': {
            title: 'Ghost Of Tsushima VERSÃO DO DIRETOR',
            categorySimple: 'RPG, Aventura',
            price: 'R$ 249,90',
            image: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2215430/header.jpg?t=1761681181',
            description: 'Viva a jornada de Jin Sakai pela primeira vez no PC e aproveite a experiência definitiva de Ghost of Tsushima: Versão do Diretor. No final do século XIII, o poderoso império mongol arrasou diversas nações em sua marcha de conquista pelo Oriente. A Ilha de Tsushima é a última barreira entre o Japão e a gigantesca frota mongol comandada pelo estrategista implacável Khotun Khan. Após a destruição causada pela primeira investida inimiga, Jin Sakai, um destemido samurai e um dos poucos sobreviventes de seu clã, precisa enfrentar uma escolha dolorosa. Para defender seu povo e libertar sua terra, ele deverá abandonar as tradições que o definiram como guerreiro e adotar um novo caminho — o caminho do Fantasma —, travando uma guerra diferente para garantir a liberdade de Tsushima.',
            publisher: 'Sony Interactive Entertainment (SIE)',
            developer: 'Sucker Punch Productions, Nixxes Software',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2215430/ss_4fe2e0938135765483d8ee5942be5562d8f31912.600x338.jpg?t=1761681181',
                'https://i.pinimg.com/1200x/d1/5f/e2/d15fe25a8a663e2f93644d583768a23f.jpg',
                'https://i.pinimg.com/1200x/3d/8a/06/3d8a06ee0b850a2beb79e84169ce67b2.jpg',
                'https://i.pinimg.com/1200x/d9/ba/7d/d9ba7dc5100c35e7e87664770d626c6f.jpg',
            ],
            requirements: {
                min: [
                    "SO: Windows 10",
                    "Processador: Intel Core i3-7100 or AMD Ryzen 3 1200",
                    "Memória:  8 GB de RAM",
                    "Placa de vídeo: NVIDIA GeForce GTX 960 or AMD Radeon RX 5500 XT",
                    "Armazenamento: 75 GB de espaço disponível",
                    "Outras Observações: SSD Recommended"
                ],
                rec: [
                    "SO: Windows 10",
                    "Processador: Intel Core i5-8600 or AMD Ryzen 5 3600",
                    "Memória: 16 GB de RAM",
                    "Placa de vídeo: NVIDIA GeForce RTX 2060 or AMD Radeon RX 5600 XT",
                    "Armazenamento: 75 GB de espaço disponível",
                    "Outras observações: SSD Required"
                ]
            }
        },
        'fl-simulator': {
            title: 'Flight Simulator 2024 Standard Edition',
            categorySimple: 'Simulação',
            price: 'R$ 299,99',
            image: 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/2537590/header.jpg?t=1747324291',
            description: 'Explore o mundo como nunca antes com o Microsoft Flight Simulator 2024 – Edição Standard. Com a maior frota de aviões já vista, leve a simulação de voo a um novo patamar de realismo e imersão. Viva a emoção de pilotar mais de 65 aeronaves detalhadas, desde jatos comerciais e aviões leves até helicópteros e planadores, cada um com física, sons e sistemas fiéis à realidade. Descubra mais de 150 aeroportos feitos à mão, recriados com precisão impressionante, e voe por um planeta dinâmico em constante transformação, com condições climáticas e tráfego aéreo em tempo real. Construa sua carreira de aviador transportando cargas, realizando voos executivos, participando de missões de resgate, combatendo incêndios aéreos e muito mais. O céu não é o limite — eleve sua experiência de voo com o Microsoft Flight Simulator 2024.',
            publisher: 'Xbox Game Studios',
            developer: 'Asobo Studio',
            gallery: [
                'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/2537590/ss_36d622f53dcfb8b1564a1edff4647bd487b10958.600x338.jpg?t=1747324291',
                'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/2537590/ss_f2d3074f57e94210c2e1d48341a644785c52d2ae.600x338.jpg?t=1747324291',
                'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/2537590/ss_860e895e1e8ada3b3db5d85743d1caff35650704.600x338.jpg?t=1747324291',
                'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/2537590/ss_95930ffacabdc250ae4b00c4229da1b279d53766.600x338.jpg?t=1747324291'
            ],
            requirements: {
                min: [
                    "SO: Windows 10",
                    "Processador: AMD Ryzen 5 2600X or Intel Core i7-6800K",
                    "Memória: 16 GB RAM",
                    "Placa de vídeo: Radeon RX 5700 or GeForce GTX 970",
                    "Armazenamento: 50 GB de espaço disponível",
                    "DirectX: Versão 12",
                    "Outras Observações: Internet Bandalarga com Velocidade Superior a 10mbps"
                ],
                rec: [
                    "SO: Windows 10",
                    "Processador: AMD Ryzen 7 2700X or Intel Core i7-10700K",
                    "Memória: 32 GB RAM",
                    "Placa de vídeo: Radeon RX 5700 XT or GeForce RTX 2080",
                    "Armazenamento: 50 GB de espaço disponível",
                    "DirectX: Versão 12",
                    "Outras observações: Internet Bandalarga com Velocidade Superior a 50mbps"
                ]
            }
        },
        'euro-2': {
            title: 'Euro Truck Simulator 2',
            categorySimple: 'Indie / Simulação',
            price: 'R$ 61,99',
            image: 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/227300/d3c44cfff95e8223687121b05c80e594d35c4c53/header_alt_assets_7.jpg?t=1760622979',
            description: 'Pegue a estrada e torne-se o rei do transporte europeu! Assuma o papel de um caminhoneiro experiente, entregando cargas valiosas por rotas vastas e cheias de paisagens deslumbrantes. Do Reino Unido e Alemanha até a Itália, Polônia, Holanda e muito mais — explore dezenas de cidades vibrantes e leve sua resistência, precisão e velocidade ao limite. Acha que tem o que é preciso para fazer parte da elite dos caminhoneiros da Europa? Então sente-se ao volante e prove o seu talento!',
            publisher: 'SCS Software',
            developer: 'SCS Software',
            gallery: [
                'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/227300/ss_e57e1ef726416e161007bc90d4160d5b529498a4.600x338.jpg?t=1760622979',
                'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/227300/ss_55d4cccdcea427ec4e9f19168a0f83716300c7b7.600x338.jpg?t=1760622979',
                'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/227300/ss_b3eba0d5e75836a7283014f677f8a364e6514367.600x338.jpg?t=1760622979',
                'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/227300/ss_75d924be54023a48270038c40216682a85c38e65.600x338.jpg?t=1760622979'
            ],
            requirements: {
                min: [
                    "SO: Windows 10 64 Bits",
                    "Processador: Intel Core i5-6400 or AMD Ryzen 3 1200 or similar",
                    "Memória: 8 GB RAM",
                    "Placa de vídeo: NVIDIA GeForce GTX 660 or AMD Radeon RX 460 or Intel HD 630 (2GB VRAM)",
                    "Armazenamento: 25 GB de espaço livre (Euro Truck Simulator 2 jogo base)",
                ],
                rec: [
                    "SO: Windows 10 64 Bits",
                    "Processador: Intel Core i5-9600 or AMD Ryzen 5 3600 or similar",
                    "Memória: 12 GB RAM",
                    "Placa de vídeo: NVIDIA GeForce GTX 1660 or AMD Radeon RX 590 (2GB VRAM)",
                    "Armazenamento: 25 GB de espaço livre (Euro Truck Simulator 2 jogo base)",
                ]
            }
        },
        'jurassic-3': {
            title: 'Jurassic World Evolution 3',
            categorySimple: 'Simulação / Estratégia',
            price: 'R$ 226,00',
            image: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2958130/df39f8c59232633e8e01ab63313b095402bdd0d5/header.jpg?t=1761208654',
            description: 'Pegue Em Jurassic World Evolution 3, o mais novo capítulo da premiada franquia, você assume o comando da criação e administração do seu próprio parque dos dinossauros. Dê vida ao passado e ajude a natureza a seguir seu curso ao sintetizar, cuidar e alimentar espécies pré-históricas únicas. Gerencie cada criatura para garantir que prosperem, formem laços, criem descendentes e transmitam seus genes às futuras gerações. Construa habitats impressionantes, projete atrações emocionantes para encantar os visitantes e mantenha tudo sob controle quando o imprevisível acontecer. A vida sempre encontra um caminho — e agora está em suas mãos.a estrada e torne-se o rei do transporte europeu! Assuma o papel de um caminhoneiro experiente, entregando cargas valiosas por rotas vastas e cheias de paisagens deslumbrantes. Do Reino Unido e Alemanha até a Itália, Polônia, Holanda e muito mais — explore dezenas de cidades vibrantes e leve sua resistência, precisão e velocidade ao limite. Acha que tem o que é preciso para fazer parte da elite dos caminhoneiros da Europa? Então sente-se ao volante e prove o seu talento!',
            publisher: 'Frontier Developments',
            developer: 'Frontier Developments',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2958130/0b20ad87376b89e206f5f32da3ee940b99ff2432/ss_0b20ad87376b89e206f5f32da3ee940b99ff2432.600x338.jpg?t=1761208654',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2958130/6d138092c50c82266ac6cc6224c05d2af2b78078/ss_6d138092c50c82266ac6cc6224c05d2af2b78078.600x338.jpg?t=1761208654',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2958130/6b01d4bbd5bcefdc9f771c7c2ec51cb637dd671d/ss_6b01d4bbd5bcefdc9f771c7c2ec51cb637dd671d.600x338.jpg?t=1761208654',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2958130/1e92657302af00353a8a195bd435d214ac5390c1/ss_1e92657302af00353a8a195bd435d214ac5390c1.600x338.jpg?t=1761208654',
            ],
            requirements: {
                min: [
                    "SO: Windows 10 64bit (min version 22H2)",
                    "Processador: Intel i5-6600K / AMD Ryzen 5 2600s",
                    "Memória: 16 GB de RAM",
                    "Placa de vídeo: NVIDIA GeForce GTX 1060 (6GB VRAM) / AMD Radeon RX 5600XT (6GB VRAM) / Intel Arc A750 (8GB VRAM)",
                    "DirectX: Versão 12",
                    "Armazenamento: 25 GB de espaço disponível",
                    "Outras Observações: SSD Recommended",
                ],
                rec: [
                    "SO: Windows 10, 11",
                    "Processador: Intel i7-10700K / AMD Ryzen 7 5800",
                    "Memória: 16 GB de RAM",
                    "Placa de vídeo: NVIDIA GeForce RTX 2070 Super (8GB VRAM) / AMD Radeon RX 6700 XT (12GB VRAM) / Intel Arc B580 (12GB VRAM)",
                    "DirectX: Versão 12",
                    "Armazenamento: 25 GB de espaço disponível",
                    "Outras Observações: SSD Required",
                ]
            }
        },
        'no-man-sky': {
            title: 'No Man\'s Sky',
            categorySimple: 'Ação / Aventura',
            price: 'R$ 162,00',
            image: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/275850/9ecc87d1062c690c96adeebd33ed761c1bda842f/header_alt_assets_25.jpg?t=1761138171',
            description: 'Inspirado na aventura e na imaginação dos grandes clássicos da ficção científica, No Man’s Sky convida você a explorar uma galáxia repleta de planetas e formas de vida únicas, cheia de mistérios, ação e descobertas sem fim. Cada estrela no céu é a luz de um sol distante, cercado por mundos vibrantes e cheios de vida — e você pode viajar até qualquer um deles. Decole do espaço profundo e pouse suavemente em superfícies alienígenas sem telas de carregamento e sem fronteiras. Neste universo gerado de forma procedural e praticamente infinita, você encontrará paisagens e criaturas jamais vistas por outro jogador — e talvez nunca vistas novamente.',
            publisher: 'Hallo Games',
            developer: 'Hallo Games',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/275850/d8de91e4a87f0e2c0fb70c84bd0f798bd4617eaf/ss_d8de91e4a87f0e2c0fb70c84bd0f798bd4617eaf.600x338.jpg?t=1761138171',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/275850/71f533720e58e1fb5dd61f23388abfe4f9caa6b5/ss_71f533720e58e1fb5dd61f23388abfe4f9caa6b5.600x338.jpg?t=1761138171',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/275850/ss_32256c21c6bfd9032debf56e1af47029e6d9f9b0.600x338.jpg?t=1761138171',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/275850/47005e90c31a62121610cbf29ce3dcc3c49dfa96/ss_47005e90c31a62121610cbf29ce3dcc3c49dfa96.600x338.jpg?t=1761138171',
            ],
            requirements: {
                min: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows 10/11 (64-bit versions)",
                    "Processador: Intel Core i3",
                    "Memória: 8 GB de RAM",
                    "Placa de vídeo: Nvidia GTX 1060 3GB, AMD RX 470 4GB, Intel UHD graphics 630",
                    "Armazenamento: 15 GB de espaço disponível",
                    "Compatibilidade com RV: GamesStoreVR",
                ],
                rec: [
                    "Requer um processador e sistema operacional de 64 bits"
                ]
            }
        },
        'dbd': {
            title: 'Dead by Daylight',
            categorySimple: 'Ação',
            price: 'R$ 69,99',
            image: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/381210/header.jpg?t=1760636583',
            description: 'Condenados a um mundo sombrio e impiedoso, onde nem a morte oferece descanso, quatro Sobreviventes lutam para escapar das garras de um Assassino implacável em um jogo cruel de coragem, estratégia e tensão constante. Escolha seu lado e mergulhe em um universo de horror psicológico com o sistema assimétrico mais intenso dos jogos de terror. Os Sobreviventes jogam em terceira pessoa, aproveitando uma visão ampla para planejar cada movimento, enquanto o Assassino enxerga em primeira pessoa, focado em caçar sua próxima vítima. Em cada partida, o objetivo é simples — fugir do Território de Abate antes que seja tarde demais —, mas a tarefa nunca é fácil, especialmente em cenários que se transformam a cada novo confronto.',
            publisher: 'Behaviour Interactive Inc.',
            developer: 'Behaviour Interactive Inc.',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/381210/ss_659500624438a4aa77bfdf304cba3ecebcd92ed9.600x338.jpg?t=1760636583',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/381210/ss_ca6b39f2fcac8feb75d23976b1be31290d58d159.600x338.jpg?t=1760636583',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/381210/ss_969a7841466e12f063c2d9a72520cce1c3b2f331.600x338.jpg?t=1760636583',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/381210/ss_cd57ce3a42d66d90164534ad71388527f1e0cf7b.600x338.jpg?t=1760636583',
            ],
            requirements: {
                min: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows 10 64-bit Operating System",
                    "Processador: Intel Core i3-4170 or AMD FX-8120",
                    "Memória: 8 GB de RAM",
                    "Placa de vídeo: DX11 Compatible GeForce GTX 460 1GB or AMD HD 6850 1GB",
                    'DiretX: Versão 12',
                    'Rede: Conexão de internet banda larga',
                    "Armazenamento: 50 GB de espaço disponível",
                    "Placa de som: DX11 compatible",
                    "Outras Observações: Com esses requisitos, é recomendado que o jogo seja jogado nas configurações de qualidade Baixa.",
                ],
                rec: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows 10 64-bit Operating System",
                    "Processador:  Intel Core i3-4170 or AMD FX-8300 or higher",
                    "Memória: 8 GB de RAM",
                    "Placa de vídeo: DX11 Compatible GeForce 760 or AMD HD 8800 or higher with 4GB of RAM",
                    'DiretX: Versão 11',
                    'Rede: Conexão de internet banda larga',
                    "Armazenamento: 50 GB de espaço disponível",
                    "Placa de som: DX11 compatible",
                ]
            }
        },
        're4-remake': {
            title: 'Resident Evil 4',
            categorySimple: 'Ação / Aventura',
            price: 'R$ 169,00',
            image: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2050650/header.jpg?t=1736385712',
            description: 'Sobreviver é apenas o começo. Seis anos após o desastre biológico em Raccoon City, o agente Leon S. Kennedy, um dos poucos sobreviventes daquela tragédia, é designado para uma missão de alto risco: resgatar a filha sequestrada do presidente dos Estados Unidos. Sua busca o leva a uma vila isolada na Europa, onde algo profundamente perturbador corrompe os moradores. Assim se inicia uma jornada de resgate e horror, em que vida e morte, medo e redenção, se entrelaçam em um pesadelo inesquecível. Com jogabilidade aprimorada, história reimaginada e gráficos de tirar o fôlego, Resident Evil 4 representa o renascimento de um ícone do terror de sobrevivência. Prepare-se para reviver o pesadelo que mudou tudo.',
            publisher: 'CAPCOM Co., Ltd.',
            developer: 'CAPCOM Co., Ltd.',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2050650/ss_59d1b19964cc532213df92c8287b75a0bffeb33c.116x65.jpg?t=1736385712',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2050650/ss_ab807f8ad9e968a620777caf483cb6020367b9ee.600x338.jpg?t=1736385712',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2050650/ss_0442f7fb4327d79802c2db8ea8d23d228a28d896.600x338.jpg?t=1736385712',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2050650/ss_69810f4cd155912fdfdd21da70181df7d454c874.600x338.jpg?t=1736385712',
            ],
            requirements: {
                min: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows 10 (64 bit)",
                    "Processador: AMD Ryzen 3 1200 / Intel Core i5-7500",
                    "Memória: 8 GB de RAM",
                    "Placa de vídeo: AMD Radeon RX 560 with 4GB VRAM / NVIDIA GeForce GTX 1050 Ti with 4GB VRAM",
                    'DiretX: Versão 12',
                    'Rede: Conexão de internet banda larga',
                    "Outras Observações: Desempenho estimado (com a opção Priorizar Desempenho ativada): 1080p/45fps. ・A taxa de quadros pode cair em cenas com uso intensivo de gráficos. ・É necessário um AMD Radeon RX 6700 XT ou NVIDIA GeForce RTX 2060 para suportar ray tracing.",
                ],
                rec: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows 10 (64 bit)/Windows 11 (64 bit)",
                    "Processador:  AMD Ryzen 5 3600 / Intel Core i7 8700",
                    "Memória: 16 GB de RAM",
                    "Placa de vídeo: AMD Radeon RX 5700 / NVIDIA GeForce GTX 1070",
                    'DiretX: Versão 12',
                    'Rede: Conexão de internet banda larga',
                    "Outras Observações: Desempenho aproximado: 1080p/60fps. ・A taxa de quadros pode cair em cenas que exigem recursos visuais mais pesados. ・O suporte ao traçado de raios requer uma placa AMD Radeon RX 6700 XT ou NVIDIA GeForce RTX 2070.",
                ]
            }
        },
        'diablo-4': {
            title: 'Diablo® IV',
            categorySimple: 'RPG',
            price: 'R$ 229,00',
            image: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2344520/80f21a42e378b93e8fbb68ee43103be8ab84891b/header.jpg?t=1758649357',
            description: 'Diablo® IV é a experiência definitiva de RPG de ação, repleta de incontáveis demônios para derrotar, habilidades para dominar, masmorras sombrias e saques lendários. Embarque em uma campanha épica, sozinho ou com amigos, e encontre personagens marcantes em uma história intensa ambientada em um mundo sombrio e devastado. Quando a jornada principal terminar, um vasto fim de jogo o aguarda: enfrente chefes colossais em busca de recompensas épicas, desafie o caos das Marés Infernais, forje armas supremas na Forja e construa heróis lendários com progressão e jogo cruzado entre todas as plataformas. O inferno o espera — você está pronto para enfrentá-lo?',
            publisher: 'Blizzard Entertainment, Inc.',
            developer: 'Blizzard Entertainment, Inc.',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2344520/11d4a9be127719b22681d823b83b0c6b4798bf1f/ss_11d4a9be127719b22681d823b83b0c6b4798bf1f.600x338.jpg?t=1758649357',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2344520/ee4b4e1ba9c8a07f40aff563c7c43fd04477d60c/ss_ee4b4e1ba9c8a07f40aff563c7c43fd04477d60c.600x338.jpg?t=1758649357',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2344520/7905f91c07b2cb828d0036389bc783300350fb74/ss_7905f91c07b2cb828d0036389bc783300350fb74.600x338.jpg?t=1758649357',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2344520/73d3413a15dcde01592a1e8e3c998ec128ef9676/ss_73d3413a15dcde01592a1e8e3c998ec128ef9676.600x338.jpg?t=1758649357',
            ],
            requirements: {
                min: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows® 10 de 64 bits versão 1909 ou mais recente",
                    "Processador: Intel® Core™ i5-2500K ou AMD™ FX-8350",
                    "Memória: 8 GB de RAM",
                    "Placa de vídeo: NVIDIA® GeForce® GTX 660 ou Intel® Arc™ A380 ou AMD Radeon™ R9 280",
                    'DiretX: Versão 12',
                    'Rede: Conexão de internet banda larga',
                    'Armazenamento: 90 GB de espaço disponível',
                    "Outras Observações: *Resolução nativa de 1080 pixels/resolução de renderização de 720 pixels, configurações gráficas baixas, 30 FPS, requer SSD",
                ],
                rec: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows® 10 de 64 bits versão 1909 ou mais recente",
                    "Processador: Intel® Core™ i5-4670K ou AMD Ryzen™ 1300X",
                    "Memória: 16 GB de RAM",
                    "Placa de vídeo: NVIDIA® GeForce® GTX 970 ou Intel® Arc™ A750 ou AMD Radeon™ RX 470",
                    'DiretX: Versão 12',
                    'Rede: Conexão de internet banda larga',
                    'Armazenamento: 90 GB de espaço disponível',
                    "Outras Observações: *Resolução de 1080 pixels, configurações gráficas médias, 60 FPS, requer SSD",
                ]
            }
        },
        'control': {
            title: 'Control Ultimate Edition',
            categorySimple: 'Ação',
            price: 'R$ 99,99',
            image: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/870780/header.jpg?t=1755611834',
            description: 'Control Ultimate Edition traz o jogo completo e todas as expansões lançadas — “A Fundação” e “EMA” — reunidas em um pacote imperdível. Uma força corrompida invadiu o Departamento Federal de Controle, e apenas você possui o poder para detê-la. O próprio mundo se torna sua arma em uma batalha épica contra um inimigo misterioso e aterrorizante, em meio a ambientes profundos e imprevisíveis. A contenção falhou. A humanidade está em perigo. Você será capaz de recuperar o controle? Vencedor de mais de 80 prêmios internacionais, Control é uma aventura de ação em terceira pessoa visualmente deslumbrante, que combina exploração, narrativa envolvente e jogabilidade intensa, criada pelos mestres da Remedy Entertainment — oferecendo uma experiência única, imersiva e inesquecível.',
            publisher: 'Remedy Entertainment',
            developer: 'Remedy Entertainment',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/870780/ss_8376498631b089e52fb5c75ffe119e0de5e6aed1.600x338.jpg?t=1755611834',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/870780/ss_5a16ce565951479e142c56a23f19d88333d84945.600x338.jpg?t=1755611834',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/870780/ss_c038bb7b20d72ba5d33cc95f7235aefa0b84a706.600x338.jpg?t=1755611834',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/870780/ss_949cf39deee737fec3aadff903ec5311dd22bdab.600x338.jpg?t=1755611834',
            ],
            requirements: {
                min: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows® 7, 64-bit",
                    "Processador: Intel® Core™ i5-4690 ou AMD™ FX-4350",
                    "Memória: 8 GB de RAM",
                    "Placa de vídeo: NVIDIA® GeForce® GTX 780 ou AMD Radeon™ R9 280X",
                    "DirectX: Versão 11",
                    "Armazenamento: 42 GB de espaço disponível",
                    "Outras Observações: Suporte a widescreen 21:9 / Controles remapeáveis / Taxa de quadros destravada / Suporte a G-Sync / Freesync"
                ],
                rec: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows® 10, 64-bit",
                    "Processador: Intel® Core™ i5-7600K ou AMD Ryzen™ 5 1600X",
                    "Memória: 16 GB de RAM",
                    "Placa de vídeo: NVIDIA® GeForce® GTX 1660/1060 ou AMD Radeon™ RX 580 / Para Ray Tracing: GeForce® RTX 2060",
                    "DirectX: Versão 12",
                    "Armazenamento: 42 GB de espaço disponível",
                    "Outras Observações: Suporte a widescreen 21:9 / Controles remapeáveis / Taxa de quadros destravada / Suporte a G-Sync / Freesync"
                ]
            }

        },
        'minecraft': {
            title: 'Minecraft',
            categorySimple: 'Sobrevivência / RPG / Aventura',
            price: 'R$ 199,00',
            image: 'https://store-images.s-microsoft.com/image/apps.29741.13774133678237924.b2fb64a6-d8b2-4e05-a188-b727d48563ed.f5bc1582-f67e-4ef4-8d8a-7aac86b324f9?q=90&w=336&h=200',
            description: 'Minecraft para Windows. Explore mundos gerados aleatoriamente e construa coisas incríveis, desde casas mais simples até grandiosos castelos. Jogue no modo criativo com recursos ilimitados ou minere as profundezas do mundo no modo sobrevivência, criando armas e armaduras para afastar criaturas perigosas. Escale montanhas íngremes, encontre cavernas complexas e extraia grandes veios de minério. Descubra biomas de cavernas verdejantes e com espeleotemas. Ilumine seu mundo com velas para mostrar que você sabe tudo sobre espeleologia e alpinismo!',
            publisher: 'Xbox Game Studios (Microsoft)',
            developer: 'Mojang Studios',
            gallery: [
                'https://store-images.s-microsoft.com/image/apps.48268.13510798885735219.85bdba62-631e-4ad9-9829-189064a9ffee.02218d33-1efe-4022-b751-49b43a3d73fc?q=90&w=320&h=180',
                'https://store-images.s-microsoft.com/image/apps.32986.13510798885735219.85bdba62-631e-4ad9-9829-189064a9ffee.b2b4cf73-6ab2-4820-b90a-74dc8ce05345?q=90&w=320&h=180',
                'https://store-images.s-microsoft.com/image/apps.46761.13510798885735219.85bdba62-631e-4ad9-9829-189064a9ffee.3c39f95c-6b79-436d-af7a-d5104d90ac96?q=90&w=320&h=180',
                'https://store-images.s-microsoft.com/image/apps.31052.13510798885735219.85bdba62-631e-4ad9-9829-189064a9ffee.6bebea99-82a9-4ba7-9763-8f61497fda7f?q=90&w=320&h=180',
            ],
            requirements: {
                min: [
                    "Sistema Operacional: Windows® 10 versão 18362.0 ou superior",
                    "Arquitetura: x64",
                    "Elementos gráficos: Intel® HD Graphics 4000 ou AMD Radeon™ R5",
                    "Processador: Intel® Celeron J4105 ou AMD FX-4100",
                    "DirectX: Versão 11",
                    "Memória: 4 GB",
                    "Headset: Não especificado",
                    "Controlador de movimentos: Não especificado"
                ],
                rec: [
                    "Sistema Operacional: Windows® 10 versão 18362.0 ou superior",
                    "Arquitetura: x64",
                    "Elementos gráficos: NVIDIA® GeForce® 940M ou AMD Radeon™ HD 8570D",
                    "Processador: Intel® Core™ i7-6500U ou AMD A8-6600K",
                    "DirectX: Não especificado",
                    "Memória: 8 GB",
                    "Headset: Headset imersivo do Windows Mixed Reality",
                    "Controlador de movimentos: Controladores de movimentos do Windows Mixed Reality"
                ]
            }
        },
        'peak': {
            title: 'PEAK',
            categorySimple: 'Indie',
            price: 'R$ 23,99',
            image: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/3527290/31bac6b2eccf09b368f5e95ce510bae2baf3cfcd/header.jpg?t=1761788282',
            description: 'PEAK é um jogo cooperativo de escalada emocionante, desenvolvido pela Aggro Crab em parceria com a Landfall, lançado em 16 de junho de 2025 para PC. Nele, você e seus amigos assumem o papel de sobreviventes de um acidente aéreo em uma ilha misteriosa e precisam escalar uma montanha desafiadora para alcançar a segurança. Cada sessão oferece novos desafios, graças à geração procedural diária do mapa, tornando cada tentativa única e exigindo planejamento e cooperação constantes. Para avançar, os jogadores devem usar ferramentas como cordas, grapples e piolets, gerenciar a estamina, cuidar de ferimentos e coordenar suas ações com a equipe. Embora seja possível jogar sozinho, a experiência brilha mesmo no co-op, quando a comunicação e a estratégia em grupo são essenciais para superar os obstáculos mais perigosos. Explore terrenos variados, supere desníveis traiçoeiros, encare quedas inesperadas e viva momentos de tensão e diversão com amigos ou outros jogadores online. Combinando mecânicas de sobrevivência, escalada e estratégia leve, PEAK oferece sessões rápidas e cheias de emoção, enquanto desafia os jogadores a pensar, colaborar e reagir rapidamente. O jogo recebeu elogios da crítica, alcançando uma média de 82 no Metacritic, e tornou-se um sucesso instantâneo de vendas, ultrapassando 5 milhões de cópias vendidas em menos de um mês. Se você gosta de desafios cooperativos, exploração dinâmica e diversão com amigos, PEAK promete horas de aventuras e risadas — mas cuidado: a montanha não perdoa erros, e cada decisão pode ser a diferença entre alcançar o topo ou cair no abismo.',
            publisher: 'Aggro Crab, Landfall',
            developer: 'Team PEAK',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/3527290/bac7b90dffb456afecc4517a3e1d69362b95d15b/ss_bac7b90dffb456afecc4517a3e1d69362b95d15b.600x338.jpg?t=1761788282',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/3527290/9c500124c060f162f111afa679bf5d3a32b3fb40/ss_9c500124c060f162f111afa679bf5d3a32b3fb40.600x338.jpg?t=1761788282',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/3527290/55365bfa09745df86bed72720a842f64d8724b9d/ss_55365bfa09745df86bed72720a842f64d8724b9d.600x338.jpg?t=1761788282',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/3527290/f157b9fd773acfbb122eaf09e7f008bfd77b02ab/ss_f157b9fd773acfbb122eaf09e7f008bfd77b02ab.600x338.jpg?t=1761788282',
            ],
            requirements: {
                min: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows® 10",
                    "Processador: Intel® Core™ i5 @ 2.5 GHz ou equivalente",
                    "Memória: 8 GB de RAM",
                    "Placa de vídeo: NVIDIA® GTX 1060 ou AMD RX 6600 XT",
                    "DirectX: Versão 12",
                    "Armazenamento: 4 GB de espaço disponível",
                    "Outras Observações: Requer processador e sistema operacional de 64 bits"
                ],
                rec: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows® 11",
                    "Processador: Intel® Core™ i5 @ 3.0 GHz ou AMD Ryzen™ 5 ou equivalente",
                    "Memória: 16 GB de RAM",
                    "Placa de vídeo: NVIDIA® RTX 2060 ou AMD RX 7600 XT ou equivalente",
                    "DirectX: Versão 12",
                    "Armazenamento: 6 GB de espaço disponível",
                    "Outras Observações: Requer processador e sistema operacional de 64 bits"
                ]
            }
        },
        'outlast': {
            title: 'Outlast',
            categorySimple: 'Terror',
            price: 'R$ 46,99',
            image: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/238320/header.jpg?t=1666817106',
            description: 'O inferno é um experimento que você não pode sobreviver. Em Outlast, um survival horror em primeira pessoa desenvolvido por veteranos de algumas das maiores franquias de games da história, você assume o papel do jornalista investigativo Miles Upshur. Seu objetivo é explorar o Mount Massive Asylum, um manicômio isolado e aterrorizante, e tentar sobreviver tempo suficiente para descobrir os segredos obscuros que ele esconde — se tiver coragem para enfrentar o que encontrará. Enquanto avança pelos corredores sombrios e cheios de armadilhas, você encontrará pacientes insanos, experimentos cruéis e horrores inimagináveis. Sem armas, Miles depende apenas de astúcia, furtividade e coragem, utilizando sombras e esconderijos para escapar de inimigos implacáveis. Cada passo é uma tensão constante, e cada decisão pode significar a diferença entre sobrevivência e morte. Com atmosfera opressiva, sons assustadores e um enredo perturbador, Outlast oferece uma experiência de terror imersiva e inesquecível, onde o medo está sempre ao virar da esquina e a adrenalina é constante.',
            publisher: 'Red Barrels',
            developer: 'Red Barrels',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/238320/ss_de19e8b1f41d9594bf64d02424a0ec5046c733f5.600x338.jpg?t=1666817106',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/238320/ss_1b4cc24b78f404c69fa18d42e5d5b00873c8852f.600x338.jpg?t=1666817106',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/238320/ss_c629aed2b6d7751222acb9bef1022338f9bc6b03.600x338.jpg?t=1666817106',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/238320/ss_bb9dffa1b9be7b4b4e27ac810f49ea62bf98f907.600x338.jpg?t=1666817106',
            ],
            requirements: {
                min: [
                    "SO: Windows® XP / Vista / 7 / 8 - 64 bits",
                    "Processador: 2.2 GHz Dual Core CPU",
                    "Memória: 2 GB de RAM",
                    "Placa de vídeo: 512 MB NVIDIA® GeForce® 9800GTX ou ATI Radeon™ HD 3xxx series",
                    "DirectX: Versão 9.0c",
                    "Rede: Conexão de internet banda larga",
                    "Armazenamento: 5 GB de espaço disponível",
                    "Placa de som: Compatível com DirectX",
                    "Outras Observações: Sistemas de 32 bits não são oficialmente suportados, mas podem funcionar se configurados para fornecer 3 GB de espaço de endereço em modo usuário."
                ],
                rec: [
                    "SO: Windows® Vista / 7 / 8 - 64 bits",
                    "Processador: 2.8 GHz Quad Core CPU",
                    "Memória: 3 GB de RAM",
                    "Placa de vídeo: 1 GB NVIDIA® GTX 460 ou ATI Radeon™ HD 6850 ou superior",
                    "DirectX: Versão 9.0c",
                    "Rede: Conexão de internet banda larga",
                    "Armazenamento: 5 GB de espaço disponível",
                    "Placa de som: Compatível com DirectX"
                ]
            }
        },
        're7': {
            title: 'Resident Evil 7 Biohazard',
            categorySimple: 'Terror',
            price: 'R$ 89,00',
            image: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/418370/header.jpg?t=1728436752',
            description: 'Resident Evil 7 biohazard é o próximo grande capítulo da renomada série Resident Evil, redefinindo a franquia ao resgatar suas raízes de horror e oferecer uma experiência verdadeiramente aterrorizante. Com uma mudança dramática para perspectiva em primeira pessoa e gráficos fotorrealistas alimentados pelo novo RE Engine da Capcom, o jogo proporciona um nível de imersão sem precedentes, tornando cada momento de terror mais próximo e pessoal. Situado nas áreas rurais dos Estados Unidos, após os dramáticos eventos de Resident Evil® 6, os jogadores vivem o medo intensamente, explorando ambientes opressivos, enfrentando horrores inimagináveis e resolvendo mistérios sombrios. Mantendo os elementos clássicos de exploração e atmosfera tensa que definiram o gênero de sobrevivência ao terror há mais de vinte anos, Resident Evil 7 também apresenta uma atualização completa dos sistemas de jogo, elevando a experiência de sobrevivência e suspense a um novo patamar de intensidade e realismo.',
            publisher: 'CAPCOM Co., Ltd.',
            developer: 'CAPCOM Co., Ltd.',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/418370/ss_d07fd9fca3644350782356667ce78d436c574680.600x338.jpg?t=1728436752',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/418370/ss_93663d90ead22ac9481b7c75eaea57509cdf41cb.600x338.jpg?t=1728436752',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/418370/ss_4ba2efde83e86ad41dd962b6802c45029efbe75d.600x338.jpg?t=1728436752',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/418370/ss_48bece562e150aa557b7debda63af059ef5ca1be.600x338.jpg?t=1728436752',
            ],
            requirements: {
                min: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows® 10 (64-bit Required)",
                    "Processador: Intel® Core™ i5-4460 2.70GHz ou AMD FX™-6300 ou superior",
                    "Memória: 8 GB de RAM",
                    "Placa de vídeo: NVIDIA® GeForce® GTX 960 ou AMD Radeon™ RX 460",
                    "DirectX: Versão 12",
                    "Armazenamento: 24 GB de espaço disponível",
                    "Placa de som: Compatível com DirectSound (deve suportar DirectX® 9.0c ou superior)",
                    "Outras Observações: Configuração de hardware alvo 1080P/30FPS. Pode ser necessário reduzir a qualidade das texturas ou desativar o Texture Streaming devido ao alto consumo de VRAM. Conexão com a Internet necessária para ativação do jogo."
                ],
                rec: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows® 10 (64-bit Required)",
                    "Processador: Intel® Core™ i7-3770 3.4GHz ou equivalente AMD ou superior",
                    "Memória: 8 GB de RAM",
                    "Placa de vídeo: NVIDIA® GeForce® GTX 1060 com 3GB de VRAM",
                    "DirectX: Versão 12",
                    "Armazenamento: 24 GB de espaço disponível",
                    "Placa de som: Compatível com DirectSound (deve suportar DirectX® 9.0c ou superior)",
                    "Outras Observações: Configuração de hardware alvo 1080P/60FPS. Conexão com a Internet necessária para ativação do jogo."
                ]
            }
        },
        're8': {
            title: 'Resident Evil Village',
            categorySimple: 'Terror',
            price: 'R$ 169,00',
            image: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1196590/header.jpg?t=1741142800',
            description: 'Vivencie o horror de sobrevivência como nunca antes em Resident Evil Village, a 8ª grande sequência da icônica franquia Resident Evil. Situado alguns anos após os eventos traumáticos de Resident Evil 7 biohazard, o enredo acompanha Ethan Winters e sua esposa Mia, que tentam reconstruir suas vidas em paz, livres dos horrores do passado. Porém, quando tudo parecia finalmente tranquilo, uma nova tragédia os arrasta de volta a um pesadelo ainda mais sombrio e aterrorizante. Com ação em primeira pessoa, os jogadores assumem o controle de Ethan e vivem cada perseguição e confronto de forma intensa e imersiva, sentindo a tensão e o perigo a cada passo. Rostos familiares se misturam a novos inimigos: Chris Redfield, herói clássico da série, surge com motivações misteriosas, enquanto uma horda de criaturas aterrorizantes habita o vilarejo, perseguindo Ethan sem descanso e colocando à prova sua coragem e habilidade. Entre exploração, combate e momentos de suspense extremo, Resident Evil Village combina história envolvente, atmosfera opressiva e jogabilidade refinada para entregar uma experiência de terror de sobrevivência que desafia todos os sentidos.',
            publisher: 'CAPCOM Co., Ltd.',
            developer: 'CAPCOM Co., Ltd.',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1196590/ss_d25704b01be292d1337df4fea0fba2aab322b58a.600x338.jpg?t=1741142800',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1196590/ss_8113ec993ec474055c4cdce5ee86f91f7cf6663f.600x338.jpg?t=1741142800',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1196590/ss_50283e6df9d2f3f24ff4a1a36a94ae307e21cee8.600x338.jpg?t=1741142800',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1196590/ss_363d9c05ee0a974b766938610a3352e7a89b9c92.600x338.jpg?t=1741142800',
            ],
            requirements: {
                min: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows® 10 (64-bit)",
                    "Processador: AMD Ryzen™ 3 1200 ou Intel® Core™ i5-7500",
                    "Memória: 8 GB de RAM",
                    "Placa de vídeo: AMD Radeon™ RX 560 com 4GB VRAM ou NVIDIA® GeForce® GTX 1050 Ti com 4GB VRAM",
                    "DirectX: Versão 12",
                    "Outras Observações: Desempenho estimado (configuração Priorizar Performance): 1080p/60fps. Taxa de quadros pode cair em cenas com gráficos intensivos. AMD Radeon™ RX 6700 XT ou NVIDIA® GeForce® RTX 2060 necessários para suportar ray tracing."
                ],
                rec: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows® 10 (64-bit)",
                    "Processador: AMD Ryzen™ 5 3600 ou Intel® Core™ i7-8700",
                    "Memória: 16 GB de RAM",
                    "Placa de vídeo: AMD Radeon™ RX 5700 ou NVIDIA® GeForce® GTX 1070",
                    "DirectX: Versão 12",
                    "Outras Observações: Desempenho estimado: 1080p/60fps. Taxa de quadros pode cair em cenas com gráficos intensivos. AMD Radeon™ RX 6700 XT ou NVIDIA® GeForce® RTX 2070 necessários para suportar ray tracing."
                ]
            }
        },
        'tw3': {
            title: 'The Witcher 3: Wild Hunt',
            categorySimple: 'RPG',
            price: 'R$ 129,99',
            image: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/292030/ad9240e088f953a84aee814034c50a6a92bf4516/header.jpg?t=1761131270',
            description: 'The Witcher 3: Wild Hunt é uma aventura épica de mundo aberto repleta de mistério, emoção e escolhas que moldam o destino. Você assume o papel de Geralt de Rívia, um caçador de monstros profissional em busca de sua filha adotiva, Ciri, enquanto foge da implacável Caçada Selvagem, um exército espectral determinado a capturá-la. Viaje por um vasto e detalhado mundo de fantasia sombria, repleto de cidades vibrantes, florestas densas, montanhas imponentes e mares perigosos. Cada região está viva, cheia de personagens cativantes, segredos antigos e decisões que podem mudar o rumo de reinos inteiros. Aprimore suas habilidades de combate, domine magias e poções e cace criaturas aterrorizantes usando estratégia e preparo. Com uma narrativa madura e envolvente, missões complexas e um universo rico em história e emoção, The Witcher 3: Wild Hunt oferece uma das experiências mais marcantes e premiadas da história dos videogames — uma jornada onde cada escolha tem um preço, e cada batalha conta uma história.',
            publisher: 'CD Projekt',
            developer: 'CD Projekt Red',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/292030/ss_5710298af2318afd9aa72449ef29ac4a2ef64d8e.1920x1080.jpg?t=1761131270',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/292030/ss_0901e64e9d4b8ebaea8348c194e7a3644d2d832d.1920x1080.jpg?t=1761131270',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/292030/ss_112b1e176c1bd271d8a565eacb6feaf90f240bb2.1920x1080.jpg?t=1761131270',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/292030/ss_d1b73b18cbcd5e9e412c7a1dead3c5cd7303d2ad.1920x1080.jpg?t=1761131270',
            ],
            requirements: {
                min: [
                    "SO: 64-bit Windows 7, 64-bit Windows 8 (8.1)",
                    "Processador: Intel Core i5-2500K 3.3GHz / AMD A10-5800K APU (3.8GHz)",
                    "Memória: 6 GB de RAM",
                    "Placa de vídeo: Nvidia GeForce GTX 660 / AMD Radeon HD 7870",
                    "DirectX: Versão 11",
                    "Armazenamento: 50 GB de espaço disponível"
                ],
                rec: [
                    "SO: 64-bit Windows 10/11",
                    "Processador: Intel Core i5-7400 / AMD Ryzen 5 1600",
                    "Memória: 8 GB de RAM",
                    "Placa de vídeo: Nvidia GeForce GTX 1070 / AMD Radeon RX 480",
                    "DirectX: Versão 12",
                    "Armazenamento: 50 GB de espaço disponível"
                ]
            }
        },
        'green-hell': {
            title: 'Green Hell',
            categorySimple: 'Indie / Sobrevivência',
            price: 'R$ 47,49',
            image: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/815370/header.jpg?t=1757690850',
            description: 'Embrenhe-se em uma intensa simulação de sobrevivência em mundo aberto, ambientada na profunda e misteriosa selva amazônica. Domine técnicas reais de sobrevivencialismo para fabricar armas e ferramentas, caçar, lutar e coletar recursos essenciais, enquanto cuida dos seus ferimentos através do modo de inspeção e mantém sua sanidade em meio ao isolamento e aos perigos constantes. Construa desde abrigos improvisados até verdadeiras fortalezas capazes de resistir às ameaças do ambiente selvagem. Enfrente sozinho cada desafio ou una forças com seus amigos para sobreviver às provações implacáveis da floresta.',
            publisher: 'Creepy Jar',
            developer: 'Creepy Jar',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/815370/ss_5acf01bcbf6f17e2fbeb9378f9e604f03d60e81b.1920x1080.jpg?t=1757690850',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/815370/ss_d87e2a79e9ac8de98c69a38b8447607d7ad3a4b5.1920x1080.jpg?t=1757690850',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/815370/ss_138caa0409f2a2afd94f2f38a7362f7c63169423.1920x1080.jpg?t=1757690850',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/815370/ss_a350eb858d655890495ba116fe641266d23315c0.1920x1080.jpg?t=1757690850',
            ],
            requirements: {
                min: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows 7/8/10 64-bit",
                    "Processador: 3.2 GHz Dual Core Processor",
                    "Memória: 4 GB de RAM",
                    "Placa de vídeo: GeForce GTX 660, Radeon RX 460 ou equivalente com 2 GB de VRAM",
                    "DirectX: Versão 11",
                    "Armazenamento: 8 GB de espaço disponível",
                    "Placa de som: DirectX compatible"
                ],
                rec: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows 7/8/10 64-bit",
                    "Processador: 3.2 GHz Dual Core Processor",
                    "Memória: 8 GB de RAM",
                    "Placa de vídeo: GeForce GTX 970, Radeon RX 580 ou equivalente com 4 GB de VRAM",
                    "DirectX: Versão 11",
                    "Armazenamento: 8 GB de espaço disponível",
                    "Placa de som: DirectX compatible"
                ]
            }

        },
        'arc-raiders': {
            title: 'ARC Raiders',
            categorySimple: 'Ação',
            price: 'R$ 171,80',
            image: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1808500/04baafaf64a5aa5f46ecda5d71889a4848dc0628/header.jpg?t=1762957298',
            description: 'Em ARC Raiders, você transita entre a superfície destruída e dominada por máquinas letais e a vibrante sociedade subterrânea de Speranza, onde pode fabricar, conserter e aprimorar seus equipamentos antes de se aventurar novamente em um mundo devastado, porém ainda impressionantemente belo. Vasculhe destroços em busca de itens valiosos, enfrente a ameaça constante das máquinas da ARC e lide com as escolhas imprevisíveis de outros sobreviventes enquanto decide que tipo de Combatente deseja se tornar. Explore quatro mapas imersivos disponíveis no lançamento — com mais surgindo conforme a sociedade subterrânea evolui —, cada um carregando cicatrizes de um planeta destruído duas vezes e marcado por conflitos antigos e recentes. A natureza retoma tudo ao redor, e a cada incursão as condições mudam: clima, inimigos e mecânicas variam dinamicamente, garantindo que nenhuma missão seja igual à outra. Jogue sozinho ou em grupos de até três jogadores e tente prosperar em meio ao caos de um mundo que insiste em continuar lutando.',
            publisher: 'Embark Studios',
            developer: 'Embark Studios',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1808500/1763664f3ea80080867eafa751685b7feec950c8/ss_1763664f3ea80080867eafa751685b7feec950c8.1920x1080.jpg?t=1762957298',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1808500/5188aa2b07920afe9753409ea9fe3d1324cfc294/ss_5188aa2b07920afe9753409ea9fe3d1324cfc294.1920x1080.jpg?t=1762957298',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1808500/155fc161a45949e61f41e473282f9ed7ec221efe/ss_155fc161a45949e61f41e473282f9ed7ec221efe.1920x1080.jpg?t=1762957298',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1808500/cb49dfbcd7175c86e297b35ffc54cf779708f0ae/ss_cb49dfbcd7175c86e297b35ffc54cf779708f0ae.1920x1080.jpg?t=1762957298',
            ],
            requirements: {
                min: [
                    "SO: Windows 10 or later 64-bit (latest update)",
                    "Processador: Intel Core i5-6600K or AMD Ryzen R5 1600",
                    "Memória: 12 GB de RAM",
                    "Placa de vídeo: NVIDIA GeForce GTX 1050 Ti or AMD Radeon RX 580 or Intel Arc A380",
                    "DirectX: Versão 12",
                    "Rede: Conexão de internet banda larga"
                ],
                rec: [
                    "SO: Windows 10 or later 64-bit (latest update)",
                    "Processador: Intel Core i5-9600K or AMD Ryzen 5 3600",
                    "Memória: 16 GB de RAM",
                    "Placa de vídeo: NVIDIA GeForce RTX 2070 or AMD Radeon RX 5700 XT or Intel Arc B570",
                    "DirectX: Versão 12",
                    "Rede: Conexão de internet banda larga"
                ]
            }
        },
        'hk-silksong': {
            title: 'Hollow Night: Silksong',
            categorySimple: 'Aventura',
            price: 'R$ 59,99',
            image: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1030300/7983574d464e6559ac7e24275727f73a8bcca1f3/header.jpg?t=1756994410',
            description: 'Assuma o papel de Hornet, a ágil e mortal Princesa Cavaleira, e embarque em uma jornada grandiosa por um reino moldado por seda, canções e antigos mistérios. Capturada e levada para um mundo desconhecido, você precisará enfrentar inimigos implacáveis, superar desafios brutais e desvendar segredos que ecoam por essas novas terras enquanto ascende em uma perigosa peregrinação rumo ao coração do reino. Hollow Knight: Silksong é a aguardada continuação do aclamado Hollow Knight, oferecendo uma aventura ainda mais intensa, refinada e expansiva, na qual você explorará regiões vibrantes e totalmente inéditas, descobrirá habilidades únicas, dominará novas ferramentas de combate e enfrentará hordas de insetos e criaturas ferozes determinadas a impedir sua ascensão. À medida que avança, revelará verdades antigas sobre a origem de Hornet, sua natureza e seu passado enigmático, em uma experiência marcada por combates ágeis, mundos deslumbrantes e uma atmosfera tão encantadora quanto ameaçadora — uma verdadeira ópera de seda, coragem e superação que eleva o gênero a um novo patamar.',
            publisher: 'Team Cherry',
            developer: 'Team Cherry',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1030300/26950369fe4b03c2268620eb9815c8a246aa0b06/ss_26950369fe4b03c2268620eb9815c8a246aa0b06.1920x1080.jpg?t=1756994410',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1030300/09ccaa6c16f158f9df8298feb5d196098506a028/ss_09ccaa6c16f158f9df8298feb5d196098506a028.1920x1080.jpg?t=1756994410',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1030300/d1a893ec6357b347a55ed929833ba793b57a79d2/ss_d1a893ec6357b347a55ed929833ba793b57a79d2.1920x1080.jpg?t=1756994410',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1030300/856e33e755a0b9a785c645d116036516ea08812b/ss_856e33e755a0b9a785c645d116036516ea08812b.1920x1080.jpg?t=1756994410',
            ],
            requirements: {
                min: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows 10 version 21H1 (build 19043) or newer",
                    "Processador: Intel Core i3-3240, AMD FX-4300",
                    "Memória: 4 GB de RAM",
                    "Placa de vídeo: GeForce GTX 560 Ti (1GB), Radeon HD 7750 (1GB)",
                    "DirectX: Versão 10",
                    "Armazenamento: 8 GB de espaço disponível"
                ],
                rec: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows 10 version 21H1 (build 19043) or newer",
                    "Processador: Intel Core i5-3470",
                    "Memória: 8 GB de RAM",
                    "Placa de vídeo: GeForce GTX 1050 (2GB), Radeon R9 380 (2GB)",
                    "DirectX: Versão 10",
                    "Armazenamento: 8 GB de espaço disponível"
                ]
            }
        },
        'poe2': {
            title: 'Path Of Exile II',
            categorySimple: 'RPG',
            price: 'R$ 79,80',
            image: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2694490/bb2944f7d5c6e8e008c882938fddaa5ec6061457/header.jpg?t=1762717997',
            description: 'Path of Exile 2 é a nova geração do aclamado RPG de ação da Grinding Gear Games, oferecendo uma experiência brutal, profunda e completamente repaginada. Ambientado em Wraeclast, um continente sombrio e decadente marcado por culturas antigas, magia proibida e perigos monstruosos, o jogo coloca você no centro de um mundo que tenta sobreviver enquanto uma ameaça sinistra, antes tida como destruída, ressurge nas fronteiras da civilização. Essa presença corruptora se espalha rapidamente, distorcendo criaturas, contaminando a terra e enlouquecendo todos que entram em contato com ela. Path of Exile 2 apresenta uma campanha inédita de 6 atos, construída com narrativa intensa e atmosfera densa, e oferece 100 ambientes distintos, cheios de segredos, desafios e histórias escondidas. Enfrente 600 monstros diferentes, cada um com comportamentos próprios, e encare 100 chefes imponentes, projetados para testar suas habilidades, estratégias e builds ao limite. Com suporte para jogo cooperativo com até seis jogadores, o título eleva sua fórmula ao combinar combate visceral, personalização extrema de personagens e um mundo cruel que recompensa apenas os mais determinados. Em Wraeclast, cada batalha é uma luta pela sobrevivência — e cada escolha molda seu destino.',
            publisher: 'Grinding Gear Games',
            developer: 'Grinding Gear Games',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2694490/cfee74ea0e4abcd5617b65b789b53541df3b5a31/ss_cfee74ea0e4abcd5617b65b789b53541df3b5a31.1920x1080.jpg?t=1762717997',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2694490/578654a7e1e88e6e186ffe1d3c055e9c1ceb0300/ss_578654a7e1e88e6e186ffe1d3c055e9c1ceb0300.1920x1080.jpg?t=1762717997',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2694490/2028c61a964a5e1f8a7ff3e6d8a6bee64153af1f/ss_2028c61a964a5e1f8a7ff3e6d8a6bee64153af1f.1920x1080.jpg?t=1762717997',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2694490/03c29d83816331321cbb49dc1e7230da9207de79/ss_03c29d83816331321cbb49dc1e7230da9207de79.1920x1080.jpg?t=1762717997',
            ],
            requirements: {
                min: [
                    "SO: Windows 10",
                    "Processador: 4 core 2.8GHz x64-compatible",
                    "Memória: 8 GB de RAM",
                    "Placa de vídeo: NVIDIA GeForce GTX 960 or ATI Radeon RX 470",
                    "DirectX: Versão 12",
                    "Rede: Conexão de internet banda larga",
                    "Armazenamento: 100 GB de espaço disponível",
                    "Outras observações: A GPU with at least 3GB of VRAM is required"
                ],
                rec: [
                    "SO: Windows 10",
                    "Processador: Intel Core i5-10500 or AMD Ryzen 5 3700X",
                    "Memória: 16 GB de RAM",
                    "Placa de vídeo: NVIDIA GeForce RTX 2060, Intel Arc A770, or ATI Radeon RX 5600XT",
                    "DirectX: Versão 12",
                    "Rede: Conexão de internet banda larga",
                    "Armazenamento: 100 GB de espaço disponível",
                    "Outras observações: Solid State Storage is recommended"
                ]
            }
        },
        'raft': {
            title: 'Raft',
            categorySimple: 'Sobrevivência',
            price: 'R$ 36,99',
            image: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/648800/header.jpg?t=1727184011',
            description: 'Sozinho ou com amigos, sua missão é sobreviver a uma épica aventura oceânica através de um mar perigoso! Presos em uma pequena jangada com nada além de um gancho feito de plástico velho, os jogadores despertam em um vasto oceano azul, totalmente sozinhos e sem terra à vista. Com a garganta seca e o estômago vazio, sobreviver não será fácil: é preciso recolher destroços, expandir sua jangada e zarpar em direção a ilhas esquecidas e cheias de perigos. Raft™ coloca você e seus amigos em uma aventura épica pelo mar aberto, com o objetivo de se manter vivo, reunir recursos e construir um lar flutuante digno de sobrevivência.',
            publisher: 'Axolot Games',
            developer: 'Redbeet Interactive',
            gallery: [
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/648800/ss_c22b2ff5ba5609f74e61b5feaa5b7a1d7fd1dbd3.1920x1080.jpg?t=1727184011',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/648800/ss_2adb248f4d501cf58344d9af1d8a9e56c74647ee.1920x1080.jpg?t=1727184011',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/648800/ss_56914c026da8c8411974bd0e2e8cb81a0331ba99.1920x1080.jpg?t=1727184011',
                'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/648800/ss_ef26440dc87e4d571139f5c64a22035d86723442.1920x1080.jpg?t=1727184011',
            ],
            requirements: {
                min: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows 7 or later",
                    "Processador: Intel Core i5 2.6GHz ou similar",
                    "Memória: 6 GB de RAM",
                    "Placa de vídeo: GeForce GTX 700 series ou similar",
                    "DirectX: Versão 11",
                    "Rede: Conexão de internet banda larga",
                    "Armazenamento: 10 GB de espaço disponível",
                    "Outras observações: 64-bit operating system is required"
                ],
                rec: [
                    "Requer um processador e sistema operacional de 64 bits",
                    "SO: Windows 7 or later",
                    "Processador: Intel Core i5-6600 3.3GHz ou similar",
                    "Memória: 8 GB de RAM",
                    "Placa de vídeo: GeForce GTX 1050 series ou similar",
                    "DirectX: Versão 11",
                    "Rede: Conexão de internet banda larga",
                    "Armazenamento: 10 GB de espaço disponível",
                    "Outras observações: 64-bit operating system is required"
                ]
            }
        },
    };

    // 2. Pegar o ID do jogo da URL
    const urlParams = new URLSearchParams(window.location.search);
    const jogoId = urlParams.get('jogo');

    // 3. Encontrar os dados do jogo
    const jogo = gameData[jogoId];

    // 4. Atualizar a página com os dados
    if (jogo) {
        // Título da Página
        document.title = `Games Store - ${jogo.title}`;
        // Breadcrumbs
        document.getElementById('detail-category-breadcrumb').textContent = jogo.categorySimple;
        document.getElementById('detail-title-breadcrumb').textContent = jogo.title;
        // Conteúdo principal
        document.getElementById('detail-image').src = jogo.image;
        document.getElementById('detail-title').textContent = jogo.title;
        document.getElementById('detail-description').textContent = jogo.description;
        // Info da Direita
        document.getElementById('detail-publisher-name').textContent = jogo.publisher;
        document.getElementById('detail-developer-name').textContent = jogo.developer;
        document.getElementById('detail-price').textContent = jogo.price;

        // 5. Popular Galeria e Requisitos
        const galleryContainer = document.getElementById('detail-gallery');
        if (jogo.gallery && jogo.gallery.length > 0) {
            jogo.gallery.forEach(imgUrl => {
                galleryContainer.innerHTML += `<img src="${imgUrl}" alt="Screenshot">`;
            });
        } else {
            galleryContainer.innerHTML = '<p class="no-data-message">Nenhuma imagem de galeria disponível.</p>';
        }

        const minList = document.getElementById('req-min');
        const recList = document.getElementById('req-rec');

        if (jogo.requirements && jogo.requirements.min.length > 0) {
            jogo.requirements.min.forEach(line => {
                minList.innerHTML += `<li>${line}</li>`;
            });
            jogo.requirements.rec.forEach(line => {
                recList.innerHTML += `<li>${line}</li>`;
            });
        } else {
            document.querySelector('.detail-requirements').innerHTML = '<p class="no-data-message">Requisitos de sistema não disponíveis.</p>';
        }

        // =======================================
        // 6. LÓGICA DO MODAL (ADICIONAR AO CARRINHO)
        // =======================================

        const buyButton = document.querySelector(".buy-button");

        buyButton.addEventListener("click", () => {
            const gameTitle = document.getElementById("detail-title").textContent;
            const gamePrice = document.getElementById("detail-price").textContent;
            const gameImage = document.getElementById("detail-image").src;

            const game = {
                title: gameTitle,
                price: gamePrice,
                image: gameImage
            };

            let cart = JSON.parse(localStorage.getItem("cart")) || [];

            // Verifica se o jogo já está no carrinho
            const alreadyInCart = cart.some(item => item.title === game.title);

            if (!alreadyInCart) {
                cart.push(game);
                localStorage.setItem("cart", JSON.stringify(cart));
            }

            // ABRE O MODAL
            openCartModal(gameTitle);
        });


    } else {
        // Se o jogo não for encontrado
        document.getElementById('detail-title').textContent = 'Jogo não encontrado';
        document.getElementById('detail-description').textContent = 'O jogo que você está procurando não existe ou o link está quebrado.';
    }

    // ==========================
    // FUNÇÃO PARA ABRIR O MODAL
    // ==========================
    function openCartModal(gameName) {
        const modal = document.getElementById("cart-modal");
        const closeBtn = document.getElementById("close-cart-modal");
        const title = document.getElementById("modal-game-name");

        title.textContent = gameName;
        modal.style.display = "flex";

        closeBtn.onclick = () => modal.style.display = "none";

        setTimeout(() => {
            modal.classList.add("modal-exit");

            // Espera a animação terminar para sumir de vez
            setTimeout(() => {
                modal.style.display = "none";
                modal.classList.remove("modal-exit");
            }, 250); // mesmo tempo da animação
        }, 2000);

    }

});
