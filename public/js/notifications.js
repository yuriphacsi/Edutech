document.addEventListener("DOMContentLoaded", () => {

    const btn = document.getElementById("notificationBtn");
    const panel = document.getElementById("notificationPanel");

    if (!btn || !panel) {
        console.log("❌ Notificaciones no encontradas");
        return;
    }

    // abrir / cerrar
    btn.addEventListener("click", (e) => {
        e.stopPropagation();
        panel.classList.toggle("show");
    });

    // cerrar al hacer click fuera
    document.addEventListener("click", () => {
        panel.classList.remove("show");
    });

    // evitar cierre al hacer click dentro
    panel.addEventListener("click", (e) => {
        e.stopPropagation();
    });

});