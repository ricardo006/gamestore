document.addEventListener('DOMContentLoaded', () => {

    // ======================================================
    // BANCO DE DADOS SIMULADO
    // ======================================================
    const ownedGames = [
        { id: 'god-of-war', title: 'God of War Ragnarök', coverUrl: 'https://hype.games/blog/wp-content/uploads/2024/09/god-of-war-ragnarok.jpg', status: 'Launch', isInstalled: true, isFriendGame: false },
        { id: 'cyberpunk', title: 'Cyberpunk 2077', coverUrl: 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/1091500/e9047d8ec47ae3d94bb8b464fb0fc9e9972b4ac7/header.jpg?t=1756209867', status: 'Launch', isInstalled: true, isFriendGame: false },
        { id: 'elden-ring', title: 'Elden Ring', coverUrl: 'https://www.omegascopio.com.br/wp-content/uploads/2025/07/NIGHTREIGN_launch-trailer-1068x601.jpg', status: 'Install', isInstalled: false, isFriendGame: false },
        { id: 'forza-5', title: 'Forza Horizon 5', coverUrl: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1551360/header.jpg?t=1746471508', status: 'Launch', isInstalled: true, isFriendGame: false },
        { id: 'hollow-knight', title: 'Hollow Knight', coverUrl: 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/367520/header.jpg?t=1695270428', status: 'Launch', isInstalled: true, isFriendGame: true },
        { id: 'civilization-6', title: 'Civilization VI', coverUrl: 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/289070/header.jpg?t=1740607040', status: 'Install', isInstalled: false, isFriendGame: false },
        { id: 'control', title: 'Control', coverUrl: 'https://www.comboinfinito.com.br/principal/wp-content/uploads/2019/08/Control.jpg', status: 'Launch', isInstalled: true, isFriendGame: false },
        { id: 'witcher-3', title: 'The Witcher 3', coverUrl: 'https://s2-techtudo.glbimg.com/hA2yQ3BEaPAj60hpNy-_4pv_2hU=/0x0:695x434/1000x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_08fbf48bc0524877943fe86e43087e7a/internal_photos/bs/2021/J/R/c5uzBsRPCJyOTtCrrWgA/2015-05-20-witcher-31.jpg', status: 'Launch', isInstalled: true, isFriendGame: true }
    ];

    // ======================================================
    // ELEMENTOS DO DOM
    // ======================================================
    const gridContainer = document.getElementById('library-grid');
    const searchInput = document.getElementById('library-search-input');
    const gameCountElement = document.getElementById('game-count');
    const noResultsMessage = document.getElementById('no-results-lib');
    const libraryLinks = document.getElementById('library-links');

    let currentFilter = 'all';

    // ======================================================
    // FUNÇÃO PRINCIPAL DE RENDERIZAÇÃO
    // ======================================================
    function renderGames(gamesToRender) {

        gridContainer.innerHTML = '';

        noResultsMessage.style.display = gamesToRender.length === 0 ? 'block' : 'none';

        gamesToRender.forEach(game => {

            const cardLink = document.createElement('a');
            cardLink.href = `detalhes.html?jogo=${game.id}`;
            cardLink.classList.add('game-card-link');

            const isInstalled = game.isInstalled ?? false;
            const statusText = isInstalled ? 'INICIAR' : 'INSTALAR';
            const statusClass = isInstalled ? 'launch' : 'install';

            cardLink.innerHTML = `
                <div class="game-card">
                    <div class="game-banner">
                        <img src="${game.coverUrl}" alt="Banner ${game.title}">
                    </div>
                    <div class="game-info">
                        <h3>${game.title}</h3>
                        <p class="category-tag library-purchased">Comprado</p>
                        <button class="library-action ${statusClass}">${statusText}</button>
                    </div>
                </div>
            `;

            gridContainer.appendChild(cardLink);
        });

        gameCountElement.textContent = gamesToRender.length;
    }

    // ======================================================
    // APLICAÇÃO DE FILTROS
    // ======================================================
    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase().trim();

        let filteredByStatus = ownedGames.filter(game => {
            if (currentFilter === 'all') return true;
            if (currentFilter === 'installed') return game.isInstalled;
            if (currentFilter === 'not-installed') return !game.isInstalled;
            if (currentFilter === 'friends') return game.isFriendGame;
            return true;
        });

        const finalFilteredList = filteredByStatus.filter(game =>
            game.title.toLowerCase().includes(searchTerm)
        );

        renderGames(finalFilteredList);
    }

    // ======================================================
    // EVENTOS DA SIDEBAR
    // ======================================================
    libraryLinks.addEventListener('click', (e) => {
        if (e.target.tagName === 'LI') {

            document.querySelectorAll('#library-links li')
                .forEach(li => li.classList.remove('active'));

            e.target.classList.add('active');

            currentFilter = e.target.getAttribute('data-filter');

            applyFilters();
        }
    });

    searchInput.addEventListener('keyup', applyFilters);

    // ======================================================
    // INICIALIZAÇÃO
    // ======================================================
    applyFilters();
});

// ========================================================================
// 2) GAVETA MOBILE (MENU SANDUÍCHE) DA BIBLIOTECA
// ========================================================================

const libToggle = document.getElementById("library-menu-toggle");
const libDrawer = document.getElementById("library-mobile-drawer");
const libOverlay = document.getElementById("library-drawer-overlay");

// abrir gaveta
libToggle?.addEventListener("click", () => {
    libDrawer.classList.add("open");
    libOverlay.classList.add("show");
});

// fechar ao clicar fora
libOverlay?.addEventListener("click", () => {
    libDrawer.classList.remove("open");
    libOverlay.classList.remove("show");
});

// integrar com filtros
document.querySelectorAll(".library-mobile-drawer li").forEach(item => {
    item.addEventListener("click", () => {

        const filter = item.getAttribute("data-filter");

        const original = document.querySelector(`[data-filter="${filter}"]`);
        if (original) original.click();

        libDrawer.classList.remove("open");
        libOverlay.classList.remove("show");
    });
});