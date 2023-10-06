<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Log</title>
    <link rel="stylesheet" type="text/css" href="css/s_rep.css">
</head>
<body>
	<div id="dashboardMainContainer">
		<?php include('partials/app-sidebar.php') ?>
		<div class="dasboard_content_container" id="dasboard_content_container">
			<?php include('partials/app-topnav.php') ?>
			<div class="dashboard_content" style="height: 600px; overflow: auto;">
				<div class="dashboard_content_main">
					<div class="co150">
                        <div class="container">
                            <h1>Sales Log</h1>
                            <table id="salesTable">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Quantity Sold</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Sales records will be populated here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        populateSalesLog();
        });

        function populateSalesLog() {
            const salesData = [
                { itemName: "Product A", quantity: 5, price: 20, total: 100 },
                { itemName: "Product B", quantity: 3, price: 50, total: 150 },
                // Add more sample sales data as needed
            ];

            const tableBody = document.querySelector("#salesTable tbody");

            salesData.forEach(sale => {
                let row = document.createElement("tr");
                row.innerHTML = `
                    <td>${sale.itemName}</td>
                    <td>${sale.quantity}</td>
                    <td>${sale.price}</td>
                    <td>${sale.total}</td>
                `;
                tableBody.appendChild(row);
            });
        }

    </script>
</html>

