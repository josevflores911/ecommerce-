$(document).ready(() => {

    console.log("debug");

    const toggle = document.getElementById("toggleSidebar");
    const sidebar = document.getElementById("sidebar");

    toggle.addEventListener("click", () => {
        sidebar.classList.toggle("show");
    });

    
//==========================================================================================================

     const toggle2 = $('#toggleSidebar');
    const sidebar2 = $('#sidebar');
    const settingsToggle = $('#settingsToggle');
    const settingsMenu = $('#settingsMenu');

    // Toggle da sidebar
    toggle2.on('click', () => {
        sidebar2.toggleClass('show');
    });

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

    // Função de logout
    $('#btnLogout').on('click', function (e) {
        e.preventDefault();
        $.post('./modules/logout.php', {}, function () {
            window.location.href = 'index.html'; 
        });
    });


});
