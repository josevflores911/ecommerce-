$(document).ready(() => {

    console.log("debug");

    const sidebarToggle = $("#toggleSidebar");
    const sidebar = $("#sidebar");

    const settingsToggle = $("#settingsToggle");
    const settingsMenu = $("#settingsMenu");

    const contentArea = $(".content-area");
    const userIdField = $(".user_id");
    const userNameField = $(".user-name");
    const cartCount = $(".cart-count");
    const messageContainer = $(".message");

    /**
     * Toggle Sidebar
     */
    sidebarToggle.on("click", () => {
        sidebar.toggleClass("show");
    });

    /**
     * Toggle Settings Menu
     */
    settingsToggle.on("click", (e) => {
        e.stopPropagation();
        settingsMenu.toggleClass("show");
    });

    /**
     * Close Settings Menu when clicking outside
     */
    $(document).on("click", () => {
        settingsMenu.removeClass("show");
    });

    /**
     * Prevent closing the menu when clicking inside
     */
    settingsMenu.on("click", (e) => {
        e.stopPropagation();
    });

    /**
     * Logout Handler
     */
    $(".btnLogout").on("click", (e) => {
        e.preventDefault();
        $.post("./modules/logout.php", {}, () => {
            window.location.href = "index.html";
        });
    });

    /**
     * Load Dashboard
     */
    $("#sltDashboard").on("click", (e) => {
        e.preventDefault();

        const payload = {
            id_user: userIdField.val(),
            name_user: userNameField.text(),
        };

        $.post("./views/dashboard.html", payload, (response) => {
            contentArea.html(response);
        });
    });

    /**
     * Load Principal Page (Products)
     */
    $("#sltPrincipal").on("click", (e) => {
        e.preventDefault();

        $.post("./modules/load_products.php", (data) => {
            const { erro, message, produtos } = data;

            messageContainer.html(`<b>${message}</b>`);

            if (erro === "0") {
                cartCount.text(0).hide();

                const payload = { produtos };

                $.post("views/buy_page.php", payload, (response) => {
                    contentArea.html(response);
                });
            }
        }, "json");
    });
});
