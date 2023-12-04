// require("./bootstrap");

// require("alpinejs");

$(".dropdown-account").on("click", function (e) {
    $(".dropdown-account-menu").toggleClass("hidden");
    e.stopPropagation();
});

$(".toggle-dp-menu").on("click", function (e) {
    $(".dropdown-menu-link").toggleClass("hidden");
    e.stopPropagation();
});

$(".toggle-menu").on("click", function (e) {
    $(".sidebar").toggleClass("hidden");
    e.stopPropagation();
});

$(".dropdown-tb-toggle").on("click", function (e) {
    $(".dropdown-tb-menu").not(this).addClass("hidden");
    $(this).next(".dropdown-tb-menu").toggleClass("hidden");
    e.stopPropagation();
});

$(document).click(function (e) {
    if (e.target.closest(".dropdown-tb-menu")) return;
    $(".dropdown-tb-menu").addClass("hidden");
});

$(document).click(function (e) {
    if (e.target.closest(".dropdown-account-menu")) return;
    $(".dropdown-account-menu").addClass("hidden");
});
$(document).click(function (e) {
    if (e.target.closest(".sidebar")) return;
    $(".sidebar").addClass("hidden");
});

// modal
$(".open-modal").on("click", function () {
    $(".modal").css("animation", "swipe-in 0.4s ease-in-out");
    $(".modal-layout").css(
        "animation",
        "opacity-in 0.2s cubic-bezier(0.17, 0.67, 0.83, 0.67)"
    );
    const modalId = $(this).data("modal-id");
    $("#" + modalId).removeClass("hidden");
});

$(".modal-layout").click(function (e) {
    if (e.target.closest(".modal")) return;
    setTimeout(function () {
        $(".modal").css("animation", "swipe-out 0.2s ease-in-out");
        $(".modal-layout").css(
            "animation",
            "opacity-out 0.2s cubic-bezier(0.17, 0.67, 0.83, 0.67)"
        );
    }, 200);
    setTimeout(function () {
        $(".modal-layout").addClass("hidden");
    }, 400);
});

$(document).keyup(function (e) {
    if (e.key === "Escape") {
        setTimeout(function () {
            $(".modal").css("animation", "swipe-out 0.2s ease-in-out");
            $(".modal-layout").css(
                "animation",
                "opacity-out 0.2s cubic-bezier(0.17, 0.67, 0.83, 0.67)t"
            );
        }, 200);
        setTimeout(function () {
            $(".modal-layout").addClass("hidden");
        }, 400);
    }
});

$("[data-dismiss-id]").on("click", function () {
    const dismissId = $(this).data("dismiss-id");
    setTimeout(function () {
        $(".modal").css("animation", "swipe-out 0.2s ease-in-out");
        $(".modal-layout").css(
            "animation",
            "opacity-out 0.2s cubic-bezier(0.17, 0.67, 0.83, 0.67)"
        );
    }, 200);
    setTimeout(function () {
        $("#" + dismissId).addClass("hidden");
    }, 400);
});
// ==================================================================
