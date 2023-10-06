<?php
	// Start the session.
	session_start();
	if(!isset($_SESSION['user'])) header('location: login.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard - KingSun Inventory System</title>
	<link rel="stylesheet" type="text/css" href="css/login.css ?v=<?php echo time(); ?>">
	<script src="https://kit.fontawesome.com/8bf423e820.js" crossorigin="anonymous"></script>
</head>
<body>
	<div id="dashboardMainContainer">
		<?php include('partials/app-sidebar.php') ?>
		<div class="dasboard_content_container" id="dasboard_content_container">
			<?php include('partials/app-topnav.php') ?>
            <div class="reportTypeContainer">
                <div class="reportType">
                    <p>Print Report Products</p>
                    <div class="alignRight">
                        <a href="database/report_csv.php?report=product" class="reportExportBtn">Excel</a>
                        <a href="database/report_pdf.php?report=product" class="reportExportBtn">PDF</a>
                    </div>
                </div>
                <div class="reportType">
                    <p>Print Report Suppliers</p>
                    <div class="alignRight">
                        <a href="database/report_csv.php?report=supplier" class="reportExportBtn">Excel</a>
                        <a href="database/report_pdf.php?report=supplier" class="reportExportBtn">PDF</a>
                    </div>
                </div>
            </div>
            <div class="reportTypeContainer">
                <div class="reportType">
                    <p>Print Report Deliveries</p>
                    <div class="alignRight">
                        <a href="database/report_csv.php?report=delivery" class="reportExportBtn">Excel</a>
                        <a href="database/report_pdf.php?report=delivery" class="reportExportBtn">PDF</a>
                    </div>
                </div>
                <div class="reportType">
                    <p>Print Report Purchase Orders</p>
                    <div class="alignRight">
                        <a href="database/report_csv.php?report=purchase_orders" class="reportExportBtn">Excel</a>
                        <a href="database/report_pdf.php?report=purchase_orders" class="reportExportBtn">PDF</a>
                    </div>
                </div>
            </div>
		</div>
	</div>


<script src="js/script.js"></script>
<script src="js/new_script.js"></script>

</body>
</html>