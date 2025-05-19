$(document).ready(function () {

    function atualizarEstoque(payload, callback) {
        $.post("modules/update_stock.php", payload, callback, 'json')
            .fail(function (xhr, status, error) {
                alert("❌ Erro na requisição de atualização do estoque.");
                console.error(error);
            });
    }

    function carregarProdutos(callback) {
        $.post("./modules/load_products.php", callback, 'json')
            .fail(function (xhr, status, error) {
                alert("❌ Erro na requisição de carregamento dos produtos.");
                console.error(error);
            });
    }

    $('.pagar-btn').on('click', function () {
        const produtosSelecionados = JSON.parse(document.getElementById("produtosJson").value);
        const userId = $(".user_id").val();

        const payload = {
            userId: userId,
            produto: produtosSelecionados.map(p => ({
                id: p.id,
                quantidade: p.quantidade,
                preco: p.preco
            }))
        };

        atualizarEstoque(payload, function (data) {
            if (data.erro === '1') {
                alert("❌ Erro ao atualizar estoque.");
                console.log(data.message);
                return;
            }

            carregarProdutos(function (data) {
                $(".message").html("<b>" + data.message + "</b>");

                if (data.erro == '0') {
                    alert("🎉 Compra realizada com sucesso!");

                    const $cartCount = window.parent.$('.cart-count');
                    $cartCount.text(0).hide();

                    const content = $(".content-area");
                    var parms = { produtos: data.produtos, id_user: userId };

                    $.post("views/buy_page.php", parms, function (data) {
                        content.html(data);
                    });
                }
            });
        });
    });
});
