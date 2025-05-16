$(document).ready(() => {

    console.log("hola")

    const toggle = document.getElementById("toggleSidebar");
    const sidebar = document.getElementById("sidebar");

    toggle.addEventListener("click", () => {
        sidebar.classList.toggle("show");
    });

});