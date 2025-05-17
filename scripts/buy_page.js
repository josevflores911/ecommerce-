$(document).ready(() => {

    //==========================================================================================================    

    const produtosSelecionados = []; // ⬅️ Array para armazenar os produtos clicados

    let cartCount = 0;

    $('.card').on('click', function (e) {
        const card = $(this); 
        const id = card.data('id');
        const nome = card.data('nome');
        const preco = card.data('preco');
        const quantidade = card.data('quantidade');

        const produto = {
            id,
            nome,
            preco,
            quantidade
        };

        // Adiciona o produto ao array
        produtosSelecionados.push(produto);

        cartCount++;

        const $cartCount = window.parent.$('.cart-count');

        $cartCount.text(cartCount);

        if (cartCount > 0) {
            $cartCount.show();
        } else {
            $cartCount.hide();
        }

        console.log('Produto clicado:');
        console.log(produto);

        // Exibe todos os produtos já clicados
        console.log('Todos os produtos clicados até agora:', produtosSelecionados);
    });

//==========================================================================================================

     // Abrir nova aba com carrinho
    // $('.confirmar-btn, .confirmar').on('click', function (e) {
    //     e.preventDefault();

    //     if (produtosSelecionados.length === 0) {
    //         alert("Nenhum produto selecionado.");
    //         return;
    //     }

    //     // Cria formulário oculto
    //     const form = $('<form>', {
    //         method: 'POST',
    //         action: './views/shopping_cart.php',
    //         target: '_blank'
    //     });

    //     $('<input>', {
    //         type: 'hidden',
    //         name: 'produtos',
    //         value: JSON.stringify(produtosSelecionados)
    //     }).appendTo(form);

    //     form.appendTo('body').submit().remove();
    // });

$('.confirmar-btn, .confirmar').on('click', function (e) {
    e.preventDefault();

    if (produtosSelecionados.length === 0) {
        alert("Nenhum produto selecionado.");
        return;
    }

    const content = $(".content-area");
    const userid = $(".user_id");
    const username = $(".user-name");

    $.post('./views/shopping_cart.php', {
        id_user: userid.val(),
        name_user: username.html(),
        produtos: JSON.stringify(produtosSelecionados)
    }, function (response) {
        content.html("");          // Limpia el área de contenido
        content.html(response);   // Inserta el contenido de la respuesta (carrinho)
    });
});


});