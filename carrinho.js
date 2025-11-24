document.addEventListener('DOMContentLoaded', () => {
    const cartContainer = document.getElementById('cart-container');
    const cartSummary = document.getElementById('cart-summary');
    const checkoutBtn = document.getElementById('checkout-btn');

    const modal = document.getElementById('checkout-modal');
    const closeModalBtn = document.getElementById('close-checkout-modal');

    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // ======================================
    // RENDERIZA O CARRINHO NA TELA
    // ======================================
    function renderCart() {
        cartContainer.innerHTML = '';
        cartSummary.innerHTML = '';

        if (cart.length === 0) {
            cartContainer.innerHTML = `<p>Seu carrinho está vazio.</p>`;
            checkoutBtn.style.display = 'none';
            return;
        }

        let total = 0;

        cart.forEach(item => {
            const div = document.createElement('div');
            div.classList.add('cart-item');

            const img = document.createElement('img');
            img.src = item.image;
            div.appendChild(img);

            const info = document.createElement('div');
            info.classList.add('cart-info');
            info.innerHTML = `<h3>${item.title}</h3><p>${item.category || ''}</p>`;
            div.appendChild(info);

            const price = document.createElement('span');
            price.classList.add('cart-price');
            price.textContent = item.price;
            div.appendChild(price);

            const removeBtn = document.createElement('button');
            removeBtn.classList.add('remove-btn');
            removeBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';
            removeBtn.onclick = () => {
                cart = cart.filter(g => g.title !== item.title);
                localStorage.setItem('cart', JSON.stringify(cart));
                renderCart();
            };
            div.appendChild(removeBtn);

            cartContainer.appendChild(div);

            total += parseFloat(item.price.replace('R$', '').replace(',', '.'));
        });

        cartSummary.innerHTML = `
            <p>Itens: ${cart.length}</p>
            <h3>Total: R$ ${total.toFixed(2).replace('.', ',')}</h3>
        `;

        checkoutBtn.style.display = 'block';
    }

    renderCart();

    // ======================================
    // FINALIZAR COMPRA — MODAL PREMIUM
    // ======================================
    checkoutBtn.addEventListener("click", () => {
        const modalContent = modal.querySelector(".modal-content");

        // 1. LIMPAR CARRINHO
        cart = [];
        localStorage.setItem('cart', JSON.stringify([]));
        renderCart(); // atualiza a tela imediatamente

        // 2. ABRIR O MODAL PREMIUM
        modal.style.display = "flex";
        modal.classList.remove("modal-bg-exit");
        modalContent.classList.remove("modal-exit");

        // 3. FECHAR COM ANIMAÇÃO DE SAÍDA
        setTimeout(() => {
            modal.classList.add("modal-bg-exit");
            modalContent.classList.add("modal-exit");

            setTimeout(() => {
                modal.style.display = "none";
                modal.classList.remove("modal-bg-exit");
                modalContent.classList.remove("modal-exit");
            }, 250);
        }, 4000); // 4 segundos na tela
    });

    // ======================================
    // FECHAR O MODAL PELO BOTÃO "X"
    // ======================================
    closeModalBtn.addEventListener('click', () => {
        const modalContent = modal.querySelector(".modal-content");

        modal.classList.add("modal-bg-exit");
        modalContent.classList.add("modal-exit");

        setTimeout(() => {
            modal.style.display = "none";
            modal.classList.remove("modal-bg-exit");
            modalContent.classList.remove("modal-exit");
        }, 250);
    });

});
