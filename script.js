document.addEventListener('DOMContentLoaded', () => {
    const categoryList = document.getElementById('category-list');
    const searchInput = document.getElementById('search-input');
    const searchButton = document.getElementById('search-button');
    // MUDANÇA: Selecionamos os LINKS (os 'pais' dos cards)
    const gameLinks = document.querySelectorAll('.game-card-link'); 
    const breadcrumb = document.querySelector('.breadcrumb');
    const noResultsMessage = document.querySelector('.no-results');

    // Função para formatar a categoria para o breadcrumb
    function formatCategoryName(category) {
        if (category === 'all') return 'Todos os Jogos';
        return category.replace(/([a-z])([A-Z])/g, '$1 $2').split('-').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' / ');
    }

    // Função para filtrar os jogos
    function filterGames(category, searchTerm = '') {
        let gamesFound = 0;
        
        // Atualiza o Breadcrumb
        const categoryText = formatCategoryName(category);
        const searchLabel = searchTerm ? ` / Pesquisa por "${searchTerm}"` : '';
        breadcrumb.textContent = `Loja / ${categoryText}${searchLabel}`;

        // MUDANÇA: Iteramos sobre os LINKS
        gameLinks.forEach(link => {
            const card = link.querySelector('.game-card'); // Pegamos o card dentro do link
            const cardCategories = card.getAttribute('data-category').split(' ');
            const cardTitle = card.querySelector('h3').textContent.toLowerCase();
            
            const categoryMatch = category === 'all' || cardCategories.includes(category);
            const searchMatch = !searchTerm || cardTitle.includes(searchTerm.toLowerCase());

            if (categoryMatch && searchMatch) {
                link.style.display = 'block'; // Mostramos o LINK
                gamesFound++;
            } else {
                link.style.display = 'none'; // Escondemos o LINK
            }
        });
        
        noResultsMessage.style.display = gamesFound === 0 ? 'block' : 'none';
    }

    // Event listener para as categorias
    categoryList.addEventListener('click', (e) => {
        const target = e.target;
        if (target.tagName === 'LI') {
            document.querySelectorAll('#category-list li').forEach(li => li.classList.remove('active'));
            target.classList.add('active');
            
            const category = target.getAttribute('data-category');
            filterGames(category, searchInput.value.trim()); 
        }
    });

    // Event listener para a pesquisa (botão e tecla Enter/tempo real)
    function handleSearch() {
        const activeCategory = document.querySelector('#category-list li.active').getAttribute('data-category');
        filterGames(activeCategory, searchInput.value.trim());
    }

    searchButton.addEventListener('click', handleSearch);
    searchInput.addEventListener('keyup', handleSearch); 

    // Filtro inicial (para mostrar todos os jogos ao carregar a página)
    filterGames('all');
    // embaralhar os jogos a cada 5 segundos
setInterval(() => {
  const catalog = document.getElementById('game-catalog');
  const games = Array.from(catalog.children);
  const shuffled = games.sort(() => Math.random() - 0.5);
  catalog.innerHTML = ''; // limpa
  shuffled.forEach(game => catalog.appendChild(game)); // reinsere em nova ordem
}, 50000); // 50000ms = 50 segundos
});
// Abrir painel de categorias no mobile
const mobileBtn = document.querySelector(".mobile-categories-btn");
const mobilePanel = document.getElementById("mobile-categories-panel");
const closeBtn = document.getElementById("close-categories");

if (mobileBtn) {
    mobileBtn.addEventListener("click", () => {
        mobilePanel.classList.add("open");
    });

    closeBtn.addEventListener("click", () => {
        mobilePanel.classList.remove("open");
    });
}

// Reaproveita o filtro da sidebar:
document.querySelectorAll(".mobile-category-list li").forEach(li => {
    li.addEventListener("click", () => {
        const cat = li.dataset.category;

        const cards = document.querySelectorAll(".game-card");
        cards.forEach(card => {
            card.style.display =
                cat === "all" || card.dataset.category.includes(cat)
                ? "block"
                : "none";
        });

        mobilePanel.classList.remove("open");
    });
});

// =====================================================
// MODAL: Adicionado ao Carrinho + Função de adicionar
// =====================================================

function addToCart(gameObject) {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart.push(gameObject);
    localStorage.setItem("cart", JSON.stringify(cart));
}

function openAddCartModal(title) {
    const modal = document.getElementById("add-cart-modal");
    const modalName = document.getElementById("add-cart-name");
    const closeBtn = document.getElementById("add-cart-close");

    modalName.textContent = title;
    modal.style.display = "flex";

    closeBtn.onclick = () => modal.style.display = "none";

    setTimeout(() => {
        modal.style.display = "none";
    }, 2000);
}
