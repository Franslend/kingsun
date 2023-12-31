<?php
	// Start the session.
	session_start();
	if(!isset($_SESSION['user'])) header('location: login.php');
	$_SESSION['table'] = 'users';
	$user = $_SESSION['user'];


	$show_table = 'users';
	$users = include('database/show.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>View Users - Inventory Management System</title>
	<?php include('partials/app-header-scripts.php'); ?>
	<link rel="stylesheet" type="text/css" href="css/login.css ?v=<?php echo time(); ?>">
    <link rel='stylesheet' href='https://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
	<link rel='stylesheet' href='https://cdn.datatables.net/plug-ins/28e7751dbec/integration/bootstrap/3/dataTables.bootstrap.css'>	
</head>
<body>
	<div id="dashboardMainContainer">
		<?php include('partials/app-sidebar.php') ?>
		<div class="dasboard_content_container" id="dasboard_content_container">
            <div id="dashboardContent">
				<?php include('partials/app-topnav.php') ?>
                <div class="dashboard_content">
                    <div class="dashboard_content_main">		
                        <div class="row">
                            <div class="column column-12" style="height: 596px; overflow: auto;">
                                <h1 class="section_header"> Sale's Logs</h1>
                                <div class="section_content">
                                        <h4>Monthly sales</h5>
                                            <style>
                                                .bor{
                                                    border: 5px solid red;
                                                }
                                                table, th, td {
                                                    border:none;
                                                    border-collapse: none;
                                                }
                                                .containers {
                                                    display: flex;
                                                    justify-content: center;
                                                    align-items: center;
                                                }
                                                .text-center{
                                                    text-align:center !important;
                                                }
                                                .text-left{
                                                    text-align:left !important;
                                                }
                                                .text-right{
                                                    text-align:right !important;
                                                }

                                            </style>

                                                    <div class="panel panel-default" id="print-preview">
                                                        <div class="panel-heading"> 
                                                            <span class="no-print">FROM</span> 
                                                            <input type="date" class="form-controls no-print" id="start" value="<?= date('Y-m-d') ?>"> 
                                                            <span class="no-print">TO</span>
                                                            <input type="date" class="form-controls no-print" id="end" value="<?= date('Y-m-d') ?>">  
                                                            <button type="button"  id="find-summarySoldItems" class="btn btn-sm btn-primary no-print">Find</button>
                                                            <button type="button"  id="find-summarySoldItems-today" class="btn btn-sm btn-success no-print">Today</button>
                                                            
                                                            <button type="button"  id="print-summarySoldItems" class="btn btn-sm btn-default no-print">Print</button>
                                                        </div>
                                                        <div class="panel-body">
                                                                <div class="containers">
                                                                    <table class="" style="width: 50%;">
                                                                        <tr>
                                                                            <td><p style="float:right !important"><img src="images/log.png" alt=""></p></td>
                                                                            <td>
                                                                            <h4 style="text-align:center !important;">
                                                                                KING SUN ENTERPRISES <br> 
                                                                                049 Corrales Ave., cor. Domingo Velez St.<br> 
                                                                                Cagayan de Oro City, Mis. Or. Philippines <br>
                                                                                Cell No. 0922-872-6189 <br> 
                                                                                NEMIA LAO SING - Prop.<br>
                                                                                VAT REG. TIN: 180-808-484-00000 <br> 
                                                                            </h4>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>

                                                        </div>
                                                        <div><span class="no-print">DATE:</span> (<span id="start-span"></span> - <span id="end-span"></span>)</div>
                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th class="text-left">Product name</th>
                                                                <th class="text-left">Price per item</th>
                                                                <th class="text-left">Sold item</th>
                                                                <th class="text-left">Total price</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="summarySoldItems">
                                                            </tbody>
                                                        </table>
                                                    </div>


                                </div>
                            </div>
                        </div>					
                    </div>
                </div>
            </div>
		</div>
	</div>


<?php include('partials/app-scripts.php'); ?>
<script>
       $(document).ready(function() {
        var start = $('#start').val();
            var end = $('#end').val();
            var data = {
                summarySoldItems: 'all',
                start:start,
                end:end
            };
        summarySoldItems(data);
        function summarySoldItems(data){
			$.ajax({
				url: "fetchProduct.php",
				type: "POST",
				data: data,
				dataType: "json",
                beforeSend: function(response){
                    $('#summarySoldItems').html(`<tr style="cursor:pointer">
                                                <td colspan="5" class="text-center">LOADING....</td>
                                                </tr>`);
                },
				success: function(response) {
                    if (response.msg) {
                        $('#summarySoldItems').html(response.output);

                        $('#start-span').html(response.start);
                        $('#end-span').html(response.end);
                    }else{
                        alert('INVALID DATE RANGE');
                        $('#summarySoldItems').html(`<tr style="cursor:pointer">
                                                <td colspan="5" class="text-center">NO DATA</td>
                                                </tr>`);
                    }
				},
				error: function(xhr, status, error) {
					console.error("AJAX Error:", status, error);
				}
			});
            //alert(2)
	    }
        $(document).on('click', '#find-summarySoldItems', function() {
            var start = $('#start').val();
            var end = $('#end').val();
            var data = {
                summarySoldItems: 'all',
                start:start,
                end:end
            };
            summarySoldItems(data);
        });
        $(document).on('click', '#find-summarySoldItems-today', function() {
            var start = '<?= date('Y-m-d') ?>';
            var end = '<?= date('Y-m-d') ?>';
            var data = {
                summarySoldItems: 'all',
                start:start,
                end:end
            };
            summarySoldItems(data);
            var start = $('#start').val(start);
            var end = $('#end').val(end);
        });
        function printPreview(content, css) {
            var printWindow = window.open('', '_blank');
            var printContent = $('#' + content + '').html();
            //printContent = printContent.replace(/<br\s*\/?>/gi, '');
            printWindow.document.open();
            printWindow.document.write('<html><head><title>Print</title>');
            printWindow.document.write('<link media="print" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">');
            printWindow.document.write(`</head><style>` + css + `</style><body class="container">` + printContent + `</body></html>`);
            printWindow.document.close();
            printWindow.focus();
            setTimeout(function() {
                printWindow.print();
                printWindow.close();
            }, 1000);
        };
        $(document).on('click', '#print-summarySoldItems', function() {
            var css = `
                @page {
                  margin-top: 30px;
                  margin-left: 3px;
                  margin-right: 3px;
                  margin-bottom: 3px;
                }
                @media print {
                  .col-md-5 {
                    flex: 0 0 auto;
                    width: 41.66666667%;
                  }
                  .no-print{
                    display:none;
                  }
                  .text-right{
                    text-align:right;
                }`;
            printPreview('print-preview', css);
        });
	   });
</script>
<script src="js/js.js"></script>
</body>
</html>