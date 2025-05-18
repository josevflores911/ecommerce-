$(document).ready(() => {

    console.log("debug");

    const toggle = document.getElementById("toggleSidebar");
    const sidebar = document.getElementById("sidebar");

    toggle.addEventListener("click", () => {
        sidebar.classList.toggle("show");
    });

    //  $('#toggleSidebar').on('click', function() {
    //     $('#sidebar').toggleClass('show');
    // });

//==========================================================================================================    

    const settingsToggle = $('#settingsToggle');
    const settingsMenu = $('#settingsMenu');

    // Toggle menu de configurações
    settingsToggle.on('click', (e) => {
        e.stopPropagation();
        settingsMenu.toggle();
    });

    // Fechar menu ao clicar fora
    $(document).on('click', function () {
        settingsMenu.hide();
    });

    // Evita que clique dentro do menu o feche
    settingsMenu.on('click', function (e) {
        e.stopPropagation();
    });

//==========================================================================================================


    $('#btnLogout').on('click', function (e) {
        e.preventDefault();
        $.post('./modules/logout.php', {}, function () {
            window.location.href = 'index.html';
        });
    });

//==========================================================================================================

    $('#sltDashboard').on('click', function (e) {
        e.preventDefault();

        const content = $(".content-area");
        const userid = $(".user_id");
        const username = $(".user-name");

        const payload = {
            id_user: userid.val(),
            name_user: username.html(),
        };

        $.post('./views/dashboard.html', payload, function (response) {

            content.html("");
            content.html(response);
        });
    });

//==========================================================================================================    

    $('#sltPrincipal').on('click', function (e) {
        e.preventDefault();

        const userid = $(".user_id");
        const username = $(".user-name");

        $.post("./modules/load_products.php", function (data) {

            var resp = data;
            var message = resp.message;


            $(".message").html("<b>" + message + "</b>");

            if (resp.erro == '0') {

                const $cartCount = window.parent.$('.cart-count');

                $cartCount.text(0);
                $cartCount.hide();

                // Retornar al main_page vía AJAX
                const content = $(".content-area");
                var parms = { produtos: resp.produtos};


                $.post("views/buy_page.php", parms, function (dat) {
                    content.html("");
                    content.html(dat);

                });
            }
        }, 'json');
    });

});
