document.addEventListener("DOMContentLoaded", () => {

    const ctx = document.getElementById("usersChart");

    if (!ctx) return;

    const data = window.usuariosUltimos12Meses || [];

    const labels = data.map(item => item.mes);
    const values = data.map(item => item.total);

    new Chart(ctx, {
        type: "line",
        data: {
            labels: labels,
            datasets: [{
                label: "Usuarios (12 meses)",
                data: values,
                borderColor: "#2563eb",
                backgroundColor: "rgba(37,99,235,0.1)",
                tension: 0.4,
                fill: true
            }]
        }
    });

});