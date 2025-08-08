<?php 
// Get population statistics
$total_users = $conn->query("SELECT COUNT(*) as total FROM `users` WHERE status = 1 AND type = 2")->fetch_assoc()['total'];

// Sex distribution
$sex_stats = $conn->query("SELECT sex, COUNT(*) as count FROM `users` WHERE status = 1 AND type = 2 GROUP BY sex");
$sex_data = [];
while($row = $sex_stats->fetch_assoc()) {
    $sex_data[] = $row;
}

// Average age
$avg_age = $conn->query("SELECT AVG(age) as avg_age FROM `users` WHERE status = 1 AND type = 2 AND age > 0")->fetch_assoc()['avg_age'];

// Zone distribution
$zone_stats = $conn->query("SELECT zone, COUNT(*) as count FROM `users` WHERE status = 1 AND type = 2 GROUP BY zone ORDER BY zone");
$zone_data = [];
while($row = $zone_stats->fetch_assoc()) {
    $zone_data[] = $row;
}

// Age group distribution
$age_groups = $conn->query("
    SELECT 
        CASE 
            WHEN age BETWEEN 18 AND 25 THEN '18-25'
            WHEN age BETWEEN 26 AND 35 THEN '26-35'
            WHEN age BETWEEN 36 AND 45 THEN '36-45'
            WHEN age BETWEEN 46 AND 55 THEN '46-55'
            WHEN age > 55 THEN '55+'
            ELSE 'Unknown'
        END as age_group,
        COUNT(*) as count
    FROM `users` 
    WHERE status = 1 AND type = 2 AND age > 0
    GROUP BY age_group
    ORDER BY age_group
");
$age_group_data = [];
while($row = $age_groups->fetch_assoc()) {
    $age_group_data[] = $row;
}
?>

<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<style>
    .user-avatar{
        width:3rem;
        height:3rem;
        object-fit:scale-down;
        object-position:center center;
    }
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .stats-label {
        font-size: 1.1rem;
        opacity: 0.9;
    }
    .chart-container {
        position: relative;
        height: 350px;
        margin-bottom: 30px;
    }
    .chart-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    .chart-title {
        font-size: 1.3rem;
        font-weight: bold;
        margin-bottom: 15px;
        color: #333;
        text-align: center;
    }
</style>

<div class="container-fluid">
    <!-- Summary Statistics Row -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stats-card text-center">
                <div class="stats-number"><?php echo number_format($total_users) ?></div>
                <div class="stats-label">Total Population</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stats-card text-center">
                <div class="stats-number"><?php echo number_format($avg_age, 1) ?></div>
                <div class="stats-label">Average Age</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stats-card text-center">
                <div class="stats-number"><?php echo count($zone_data) ?></div>
                <div class="stats-label">Active Zones</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stats-card text-center">
                <div class="stats-number"><?php echo count($sex_data) ?></div>
                <div class="stats-label">Gender Groups</div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Sex Distribution Chart -->
        <div class="col-lg-6 col-md-12">
            <div class="chart-card">
                <div class="chart-title">Population by Gender</div>
                <div class="chart-container">
                    <canvas id="sexChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Zone Distribution Chart -->
        <div class="col-lg-6 col-md-12">
            <div class="chart-card">
                <div class="chart-title">Population by Zone</div>
                <div class="chart-container">
                    <canvas id="zoneChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Age Group Distribution Chart -->
        <div class="col-lg-12">
            <div class="chart-card">
                <div class="chart-title">Population by Age Group</div>
                <div class="chart-container">
                    <canvas id="ageChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url ?>plugins/chart.js/Chart.min.js"></script>
<script>
$(document).ready(function() {
    // Sex Distribution Chart
    const sexData = <?php echo json_encode($sex_data) ?>;
    const sexLabels = sexData.map(item => item.sex);
    const sexCounts = sexData.map(item => parseInt(item.count));
    
    const sexCtx = document.getElementById('sexChart').getContext('2d');
    new Chart(sexCtx, {
        type: 'doughnut',
        data: {
            labels: sexLabels,
            datasets: [{
                data: sexCounts,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                borderColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.raw / total) * 100).toFixed(1);
                            return context.label + ': ' + context.raw + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // Zone Distribution Chart
    const zoneData = <?php echo json_encode($zone_data) ?>;
    const zoneLabels = zoneData.map(item => 'Zone ' + item.zone);
    const zoneCounts = zoneData.map(item => parseInt(item.count));
    
    const zoneCtx = document.getElementById('zoneChart').getContext('2d');
    new Chart(zoneCtx, {
        type: 'bar',
        data: {
            labels: zoneLabels,
            datasets: [{
                label: 'Population',
                data: zoneCounts,
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Age Group Distribution Chart
    const ageData = <?php echo json_encode($age_group_data) ?>;
    const ageLabels = ageData.map(item => item.age_group);
    const ageCounts = ageData.map(item => parseInt(item.count));
    
    const ageCtx = document.getElementById('ageChart').getContext('2d');
    new Chart(ageCtx, {
        type: 'bar',
        data: {
            labels: ageLabels,
            datasets: [{
                label: 'Population',
                data: ageCounts,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 205, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 159, 64, 0.8)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
