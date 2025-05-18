$(document).ready(() => {
    let produtosSelecionados = window.produtosSelecionados || [];
    let cartCount = window.cartCount || 0;

    $('.card').on('click', function (e) {
        e.preventDefault();

        const card = $(this);
        const id = card.data('id');
        const nome = card.data('nome');
        const preco = parseFloat(card.data('preco'));
        let quantidadeRestante = parseInt(card.data('quantidade'));

        if (quantidadeRestante <= 0) {
            alert("Produto sem estoque.");
            return;
        }

        // Atualiza a quantidade no HTML e no data attribute
        quantidadeRestante--;
        card.data('quantidade', quantidadeRestante);
        card.find('[data-role="quantidade"]').text('Qtd: ' + quantidadeRestante);

        // Verifica se produto já está no carrinho
        let existente = produtosSelecionados.find(p => p.id === id);
        if (existente) {
            existente.quantidade++;
        } else {
            produtosSelecionados.push({ id, nome, preco, quantidade: 1 });
        }

        // Atualiza contador no carrinho
        cartCount++;
        const $cartCount = window.parent.$('.cart-count');
        $cartCount.text(cartCount);
        if (cartCount > 0) $cartCount.show();
        else $cartCount.hide();
    });

    $('.confirmar-btn').on('click', function (e) {
        e.preventDefault();

        // if (produtosSelecionados.length === 0) {
        if (cartCount == 0) {
            alert("Nenhum produto selecionado.");
            console.log("here",cartCount)
            return;
        }

        const content = $(".content-area");
        const userid = $(".user_id").val();
        const username = $(".user-name").text();

        const payload = {
            id_user: userid,
            name_user: username,
            produtos: JSON.stringify(produtosSelecionados)
        };

        $.post('./views/shopping_cart.php', payload, function (response) {
            window.produtosSelecionados = [];
            window.cartCount = 0;

            window.parent.$('.cart-count').hide();
            content.html(response);
        });
    });
});
