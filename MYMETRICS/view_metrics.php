<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metrics</title>
    <link rel="stylesheet" href="./stylesheets/metrics.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="./js/fetchMetricData.js" defer></script>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="view_metrics.php">Metrics</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Metric Data Chart</h1>
        <canvas id="myChart" width="800" height="400"></canvas>
    </main>

    <footer>
        <p>&copy; 2024 EventTrack. All rights reserved.</p>
    </footer>
</body>
</html>