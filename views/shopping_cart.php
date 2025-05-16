<?php
session_start();
$produtos = json_decode($_POST['produtos'], true);
?>


<head>
    <meta charset="UTF-8">
    <title>Resumo da Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #222;
            color: #fff;
            padding: 20px;
        }

        .produto {
            border-bottom: 1px solid #444;
            margin-bottom: 10px;
            padding: 10px 0;
        }

        .pagar-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .pagar-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <h1>Resumo da Compra</h1>

    <?php if (!empty($produtos)): ?>
        <?php foreach ($produtos as $p): ?>
            <div class="produto">
                <strong><?= htmlspecialchars($p['nome']) ?></strong><br>
                Preço: R$ <?= number_format($p['preco'], 2, ',', '.') ?><br>
                Quantidade: <?= $p['quantidade'] ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nenhum produto no carrinho.</p>
    <?php endif; ?>

    <!-- Botão Pagar -->
    <button id="btnPagar" class="pagar-btn">Pagar</button>


    <!-- Script para redirecionar -->
    <script>
        $(document).ready(function () {
            $('#btnPagar').on('click', function () {


            $.post("modules/load_products.php",  function (data) {
                  
                  // var resp = JSON.parse(data);
                  var resp = data;
                var message = resp.message;
                
                $(".message").html("<b>" + message + "</b>");
  
                if (resp.erro == '0') {
                    
                    // validación si es necesario antes

                    
                    alert("🎉 Compra realizada com sucesso!");

                    // Retornar al main_page vía AJAX
                    const content = $(".content-area");
                    var parms = { produtos:resp.produtos}; 

                    $.post("views/buy_page.php", parms, function (data) {
                        content.html("");
                        content.html(data);

                        
                    });

                } 
              },'json');



            
        });
    });
    </script>

</body>
