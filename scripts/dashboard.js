$(document).ready(function () { 
    $('.btn-carregar').on('click', function (e) { 
        e.preventDefault();

        let nome = $("#nome").val();
        let descricao = $("#descricao").val();
        let preco = $("#preco").val();
        let quantidade = $("#quantidade").val();
        const ativo = $("#ativo").val();

        const payload = {
            nome: nome,
            descricao: descricao,
            preco: preco,
            quantidade: quantidade,
            ativo: ativo
        };

        $.post("modules/save_products.php", payload, function (data) { 
            alert("Produto carregado exitosamente.");

            nome = "";
            descricao = "";
            preco = "";
            quantidade = "";

            console.log(data);
        }, 'json');
    });
});
