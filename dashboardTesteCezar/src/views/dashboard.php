<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Teste Cezar</title>
    <link rel="stylesheet" href="/dashboardTesteCezar/src/styles/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Dashboard Teste Cezar</h1>
    <canvas id="elementoChart" width="400" height="200"></canvas>
    <script id="chartData" type="application/json">
        <?php echo json_encode($apiChartData); ?>
    </script>

    <script src="/dashboardTesteCezar/src/assets/scriptDashboard.js"></script>
</body>
</html>



