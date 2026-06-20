document.addEventListener("DOMContentLoaded", () => {

    const ctx =
        document.getElementById('usersChart');

    if (!ctx) return;

    new Chart(ctx, {

        type: 'line',

        data: {

            labels: [
                'Ene',
                'Feb',
                'Mar',
                'Abr',
                'May',
                'Jun'
            ],

            datasets: [{
                label: 'Usuarios',
                data: [5, 8, 12, 15, 20, 25]
            }]
        }

    });

});