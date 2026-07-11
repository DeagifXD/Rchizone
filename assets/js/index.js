//下拉菜单
document.addEventListener("DOMContentLoaded", function () {
    const dropdown = document.querySelector(".nav-dropdown");
    const toggle = document.querySelector(".dropdown-toggle");

    toggle.addEventListener("click", function (e) {
        e.stopPropagation();
        dropdown.classList.toggle("active");
    });

    document.addEventListener("click", function () {
        dropdown.classList.remove("active");
    });
});