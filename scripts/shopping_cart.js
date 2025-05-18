$(document).ready(function () {

    $('.pagar-btn').on('click', function () {

        const produtosSelecionados = JSON.parse(document.getElementById("produtosJson").value);
        
        const payload = {
        produto: JSON.stringify(produtosSelecionados.map(p => ({
            id: p.id,
            quantidade: p.quantidade
        })))
        };

        $.post("modules/update_stock.php", payload, function (data) { 

        
            $.post("./modules/load_products.php", function (data) {
            // var resp = JSON.parse(data);
            var resp = data;
            var message = resp.message;

            $(".message").html("<b>" + message + "</b>");

            if (resp.erro == '0') {

                // validación si es necesario antes


                alert("🎉 Compra realizada com sucesso!");

                const $cartCount = window.parent.$('.cart-count');

                $cartCount.text(0);
                $cartCount.hide();

                // Retornar al main_page vía AJAX
                const content = $(".content-area");
                var parms = { produtos: resp.produtos };

                $.post("views/buy_page.php", parms, function (data) {

                    
                    content.html("");
                    content.html(data);


                });

            }
        }, 'json');

            console.log(data);
        }, 'json');

        
        

    });
});