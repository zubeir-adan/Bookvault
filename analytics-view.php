<?php

include_once 'body/header2.php';
include_once 'connection.php';

$captchaSuccess = false;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['g-recaptcha-response'])) {
        $recaptchaResponse = $_POST['g-recaptcha-response'];
        $secretKey = "6LeWOQ8qAAAAAI9HIJY4zs0qP79TKYq7nG65-LmX";
        $verifyUrl = "https://www.google.com/recaptcha/api/siteverify";
        
        $response = file_get_contents($verifyUrl . "?secret=" . $secretKey . "&response=" . $recaptchaResponse);
        $responseData = json_decode($response);
        
        if ($responseData->success) {
            $captchaSuccess = true;

            // Fetch user data (assuming user_id is obtained from session or some other method)
            $user_id = $_SESSION['user_id'];

            // Fetch username from database
            $sqlUser = "SELECT username FROM users WHERE user_id = $user_id";
            $resultUser = $conn->query($sqlUser);
            if ($resultUser->num_rows > 0) {
                $row = $resultUser->fetch_assoc();
                $username = $row['username'];
            } else {
                $username = "User"; // Default fallback
            }

            // SQL query for the pie chart
            $sqlPie = "
                SELECT 'Favorite' AS category, COUNT(*) AS count
                FROM favorite_books
                WHERE user_id = $user_id
                UNION ALL
                SELECT 'Have Read' AS category, COUNT(*) AS count
                FROM haveread
                WHERE user_id = $user_id
                UNION ALL
                SELECT 'Want to Read' AS category, COUNT(*) AS count
                FROM `want-to-read`
                WHERE user_id = $user_id
            ";

            $resultPie = $conn->query($sqlPie);

            $dataPointsPie = array();
            if ($resultPie->num_rows > 0) {
                while($row = $resultPie->fetch_assoc()) {
                    $dataPointsPie[] = array("label" => $row['category'], "y" => $row['count']);
                }
            } else {
                echo "0 results for pie chart";
            }

            // SQL query for the column chart
            $sqlColumn = "
                SELECT 'Favorite' AS category, MONTH(timestamp) AS month, COUNT(*) AS count
                FROM favorite_books
                WHERE user_id = $user_id
                GROUP BY category, month
                UNION ALL
                SELECT 'Have Read' AS category, MONTH(timestamp) AS month, COUNT(*) AS count
                FROM haveread
                WHERE user_id = $user_id
                GROUP BY category, month
                UNION ALL
                SELECT 'Want to Read' AS category, MONTH(timestamp) AS month, COUNT(*) AS count
                FROM `want-to-read`
                WHERE user_id = $user_id
                GROUP BY category, month
                ORDER BY month
            ";

            $resultColumn = $conn->query($sqlColumn);

            $dataPointsColumn = array(
                "Favorite" => array(),
                "Have Read" => array(),
                "Want to Read" => array()
            );

            if ($resultColumn->num_rows > 0) {
                while($row = $resultColumn->fetch_assoc()) {
                    $dataPointsColumn[$row['category']][] = array("x" => $row['month'], "y" => $row['count']);
                }
            } else {
                echo "0 results for column chart";
            }

            $conn->close();
        } else {
            echo "Please complete the CAPTCHA.";
        }
    } else {
        echo "CAPTCHA not completed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics</title>
    
    <!-- Include any additional stylesheets or meta tags -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .main-content {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }
        .main-content h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .main-content p {
            font-size: 16px;
            color: #666;
        }
        .chart-container {
            display: flex;
            justify-content: space-between;
        }
        .chart {
            width: 48%;
        }
        .hidden {
            display: none;
        }
    </style>
    <script>
    window.onload = function () {
        <?php if ($captchaSuccess): ?>
        document.getElementById('analytics-content').classList.remove('hidden');
        document.getElementById('captcha-form').classList.add('hidden');

        // Pie Chart
        var pieChart = new CanvasJS.Chart("pieChartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            title: {
                text: "<?php echo $username; ?>'s Book Data"
            },
            data: [{
                type: "pie",
                showInLegend: "true",
                legendText: "{label}",
                indexLabelFontSize: 16,
                indexLabel: "{label} - #percent%",
                yValueFormatString: "#,##0",
                dataPoints: <?php echo json_encode($dataPointsPie, JSON_NUMERIC_CHECK); ?>
            }]
        });
        pieChart.render();

        // Column Chart
        var columnChart = new CanvasJS.Chart("columnChartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light1",
            title:{
                text: "<?php echo $username; ?>'s Books Added Per Month by Category"
            },
            axisY:{
                includeZero: true
            },
            axisX:{
                title: "Month",
                interval: 1
            },
            data: [
                {
                    type: "column",
                    name: "Favorite",
                    showInLegend: true,
                    legendText: "Favorite",
                    dataPoints: <?php echo json_encode($dataPointsColumn["Favorite"], JSON_NUMERIC_CHECK); ?>
                },
                {
                    type: "column",
                    name: "Have Read",
                    showInLegend: true,
                    legendText: "Have Read",
                    dataPoints: <?php echo json_encode($dataPointsColumn["Have Read"], JSON_NUMERIC_CHECK); ?>
                },
                {
                    type: "column",
                    name: "Want to Read",
                    showInLegend: true,
                    legendText: "Want to Read",
                    dataPoints: <?php echo json_encode($dataPointsColumn["Want to Read"], JSON_NUMERIC_CHECK); ?>
                }
            ]
        });
        columnChart.render();
        <?php endif; ?>
    }
    </script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <div class="main-content">
        <h1>Analytics Page</h1>
        <p>This is your analytics view page content.</p>
        <form id="captcha-form" action="analytics-view.php" method="POST">
            <!-- Add your CAPTCHA here -->
            <div class="g-recaptcha" data-sitekey="6LeWOQ8qAAAAAJDi33TT_sejaPWHjJSPDEk7xhuj"></div>
            <input type="submit" value="Submit">
        </form>
        <div id="analytics-content" class="hidden">
            <div class="chart-container">
                <div class="chart" id="pieChartContainer" style="height: 370px;"></div>
                <div class="chart" id="columnChartContainer" style="height: 370px;"></div>
            </div>
        </div>
    </div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <?php include("body/footer.php"); ?>
</body>
</html>
