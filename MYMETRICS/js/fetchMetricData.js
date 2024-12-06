async function fetchMetricData() {
    const response = await fetch('./fetch_metrics.php'); // Adjust the path if necessary
    const data = await response.json();
    return data;
}

async function renderChart() {
    const metricData = await fetchMetricData();

    // Grouping data by action_type to count occurrences
    const actionCounts = metricData.reduce((acc, item) => {
        acc[item.action_type] = (acc[item.action_type] || 0) + 1;
        return acc;
    }, {});

    // Extracting labels and data
    const labels = Object.keys(actionCounts);
    const data = Object.values(actionCounts);

    // Create the chart
    const ctx = document.getElementById('myChart').getContext('2d'); // Ensure this ID matches the canvas ID
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Number of Actions',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

renderChart();