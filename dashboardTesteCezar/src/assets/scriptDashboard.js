document.addEventListener('DOMContentLoaded', () => {
    const elementoData = document.getElementById('chartData').textContent;
    const data = JSON.parse(elementoData);
    
    const ctx = document.getElementById('elementoChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.labels,
            datasets: data.datasets.map(dataset => ({
                label: dataset.label,
                data: dataset.data,
                backgroundColor: randomizarCores(),
                borderColor: dataset.borderColor,
                borderWidth: dataset.borderWidth,
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                }
            }))
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'right',
                },
            },
            
            

        }
    });


    function randomizarCores() {
        const codigos = '0123456789ABCDEF';
        let hashcor = '#';
        for (let i = 0; i < 6; i++) {
            hashcor += codigos[Math.floor(Math.random() * 16)];
        }
        return hashcor;
    }
});
