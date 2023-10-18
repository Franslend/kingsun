<?php
	// Start the session.
	session_start();
	if(!isset($_SESSION['user'])) header('location: login.php');

	$user = $_SESSION['user'];

	// Get graph data - purchase order by status
	include('database/po_status_pie_graph.php');

	// Ger graph data - supplier product count
	include('database/supplier_product_bar_graph.php');

	// Get line graph data - delivery history per day
	include('database/delivery_history.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard - KingSun</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<script src="https://kit.fontawesome.com/8bf423e820.js" crossorigin="anonymous"></script>
</head>
<body>
	<div id="dashboardMainContainer">
		<?php include('partials/app-sidebar.php') ?>
		<div class="dasboard_content_container" id="dasboard_content_container">
				<div id="dashboardContent">
				<?php include('partials/app-topnav.php') ?>
					<div class="dashboard_content">
					<div class="column column-12" style="height: 623px; overflow: auto;">
						<div class="dashboard_content_main">
							<div class="co150" style="margin:3px;">
								<br>
								<form action="dashboard.php" method="get">
								<label for="">YEAR FILTER</label>
								<div class="row">
									<div class="col-md-10">
										<select name="date" id="" class="form-control" style="margin-bottom: 1px; margin-top: 3px">
											<option value="" disabled selected>-Select-</option>
											<option value="2020" <?=  isset($_GET['date']) && $_GET['date'] == '2020' ? 'selected' : '' ?>>2020</option>
											<option value="2021" <?=  isset($_GET['date']) && $_GET['date'] == '2021' ? 'selected' : '' ?>>2021</option>
											<option value="2022" <?=  isset($_GET['date']) && $_GET['date'] == '2022' ? 'selected' : '' ?>>2022</option>
											<option value="2023" <?=  isset($_GET['date']) && $_GET['date'] == '2023' ? 'selected' : '' ?>>2023</option>
											<option value="2024" <?=  isset($_GET['date']) && $_GET['date'] == '2024' ? 'selected' : '' ?>>2024</option>
											<option value="2025" <?=  isset($_GET['date']) && $_GET['date'] == '2025' ? 'selected' : '' ?>>2025</option>
										</select>
									</div>
									<div class="col-md-2"><button class="btn btn-primary" type="submit">Find</button></div>
								</div>
								</form>
								
								<figure class="highcharts-figure">
									<div id="container"></div>
								</figure>
							</div>
							<div class="co150" style="margin:3px;">
							<br>
										<form action="dashboard.php" method="get">
											<label for="">Monthly</label>
											<div class="row">
												<div class="col-md-3">
													<div class="input-group">
														<input type="month" value = "<?= isset($_GET['sale_overview']) ? $_GET['sale_overview'] : '' ?>" class="form-control" name="sale_overview" style="margin-bottom: 1px; margin-top: 3px; margin-left:10px">
														<span class="input-group-btn">
															<button class="btn btn-primary" type="submit">Find</button>
														</span>
													</div><!-- /input-group -->
												</div>
											</div>
										</form>
								
								<div id="deliveryHistory"></div>				
							</div>
						</div>
							<br>
							<div class="dashboard_content_main">
								<div class="row" style="margin-bottom: 1px; margin-top: 20px">
									<div class="col-md-12">

										<label for="">
											BEST SALES OVERVIEW 
										</label> 
										<form action="dashboard.php" method="get">
											<div class="row">
												<div class="col-md-3">
													<div class="input-group">
														<input type="month" value = "<?= isset($_GET['best_sale']) ? $_GET['best_sale'] : '' ?>" class="form-control" name="best_sale" style="margin-bottom: 1px; margin-top: 0px">
														<span class="input-group-btn">
															<button class="btn btn-primary" type="submit">Find</button>
														</span>
													</div><!-- /input-group -->
												</div>
											</div>
										</form>
										<figure class="highcharts-figure" style="max-width:2000px;">
											<div id="containerv2"></div>
										</figure>
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
	<!-- Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Order Details</h4>
      </div>
      <div class="modal-body">
          <table id="cartItems" class="cart-items">
            <thead>
            <tr>
              <th>#</th>
			  <th>Item code</th>
              <th>Product name</th>
              <th>Quantity ordered</th>
              <th>Quantity received</th>
			  <th>Status</th>
			  <th>Order by</th>
			  <th>Created at</th>
			  <th>Action</th>
            </tr>
            </thead>
            <tbody id="fetchSelectedProduct-1"></tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="statusModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Delivery Histories</h4>
      </div>
      <div class="modal-body">
          <table id="cartItems2" class="cart-items2">
            <thead>
            <tr>
              <th>#</th>
              <th>DATE RECEIVED</th>
              <th>QUANTITY RECEIVED</th>
            </tr>
            </thead>
            <tbody id="fetchSelectedProduct-2"></tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="statusModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Transaction Histories</h4>
      </div>
      <div class="modal-body">
          <table id="cartItems2" class="cart-items2">
            <thead>
            <tr>
              <th>#</th>
			  <th>ITEM CODE</th>
              <th>PRODUCT NAME</th>
              <th>QUANTITY RECEIVED</th>
			  <th>DATE RECEIVED</th>
            </tr>
            </thead>
            <tbody id="fetchSelectedProduct-3"></tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="js/script.js"></script>
<script src="js/new_script.js"></script>
<script>
	//pie chart//
	$(document).on('click', '#modal-2', function() {
		var data = {fetchSelectedProductDashboard:1,action:'single_product',id:$(this).data('id')};
		fetchSelectedProduct(data,2);
		$('#statusModal2').modal('show');
	});

	function fetchSelectedProduct(data,id_num){
			$.ajax({
				url: "fetchProduct.php",
				type: "POST",
				data: data,
				dataType: "json",
				success: function(response) {
					$("#fetchSelectedProduct-" + id_num).html(response.products);
				},
				error: function(xhr, status, error) {
					console.error("AJAX Error:", status, error);
				}
			});
	}
	var graphData = <?= json_encode($results) ?>;
	Highcharts.chart('container', {
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'pie'
		},
		title: {
			text: 'Order Status, <?=  isset($_GET['date']) ? $_GET['date'] : 'ALL' ?>',
			align: 'left',
			style: {
                	fontSize: '20px' // Custom font size for y-axis title
            	}
		},
		tooltip: {
			pointFormatter: function(){
				var point = this,
					series = point.series;

				return `<b>${point.name}</b>: ${point.y}`
			},
			style: {
            	fontSize: '15px' // Custom font size for title
        	}	
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					format: '<b>{point.name}</b>: {point.y}',
					style: {
						fontSize: '15px' // Custom font size for title
					}	
				},
				point: {
                    events: {
                        click: function() {
                            // Open the Bootstrap modal when a pie slice is clicked
                            $('#statusModal').modal('show');
							var data = {fetchSelectedProductDashboard:1,action:'pie',status:this.name};
							fetchSelectedProduct(data,1)
							
                        }
                    }
                }
			}
		},
		series: [{
			name: 'Status',
			colorByPoint: true,
			data: graphData
		}]
	});
	




	/////Line Chart////
	var lineCategories = <?= json_encode($line_categories) ?>;
	var lineData = <?= json_encode($line_data) ?>;
	Highcharts.chart('deliveryHistory', {
		chart: {
			type: 'spline'
		},
		title: {
			text: 'Sales Overview',
			align: 'left',
			style: {
                	fontSize: '20px' // Custom font size for y-axis title
            	}
		},

		yAxis: {
			title: {
				text: 'Product Sold',
				style: {
                	fontSize: '15px' // Custom font size for y-axis title
            	}
			},
			labels: {
				style: {
					fontSize: '15px' // Custom font size for y-axis labels
				}
        	}
		},

		xAxis: {
			categories: lineCategories,
			labels: {
				style: {
					fontSize: '15px' // Custom font size for x-axis labels
				}
        	}
		},

		legend: {
			layout: 'vertical',
			align: 'right',
			verticalAlign: 'middle',
			itemStyle: {
            fontSize: '15px' // Custom font size for legend items
        	}
		},
		tooltip: {
			shared: true, // Show shared tooltips for multiple series
			crosshairs: true, // Show crosshair lines for each point
			headerFormat: '<b>{point.x}</b><br/>', // Format for the tooltip header
			pointFormat: '{series.name}: {point.y}<br/>', // Format for each point in the tooltip
			style: {
				fontSize: '12px' // Custom font size for the tooltip content
			}
    	},
		plotOptions: {
			series: {
				label: {
					connectorAllowed: false
				},
				
			point: {
                    events: {
                        click: function() {
							$('#statusModal3').modal('show');
							var data = {fetchSelectedProductDashboard:1,action:'line',date_received:this.category};
							fetchSelectedProduct(data,3)
                        }
                    }
            }
			}
		},

		series: [{
			name: 'Product Sold',
			data: lineData
		}], 

		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					legend: {
						layout: 'horizontal',
						align: 'center',
						verticalAlign: 'bottom'
					}
				}
			}]
		}
	});



	//dari
Highcharts.chart('containerv2', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'TOP 10 BEST SELLING PRODUCT FOR THIS MONTH ',
        align: 'left',
		style: {
                	fontSize: '20px' // Custom font size for y-axis title
            	}
    },
    xAxis: {
		categories: <?php echo json_encode($productFetch) ?> ,
        title: {
            text: null,
            style: {
                fontSize: '50px' // Custom font size for x-axis categories
            }
        },
        labels: {
            style: {
                fontSize: '20px' // Custom font size for x-axis labels (categories)
            }
        },
        gridLineWidth: 1,
        lineWidth: 0
    },
    yAxis: {
        min: 0,
        title: {
			text: null,
            align: 'high',
			style: {
                	fontSize: '20px' // Custom font size for y-axis title
            	}
        },
        labels: {
            overflow: 'justify',
			style: {
                	fontSize: '15px' // Custom font size for y-axis title
            	}
        },
        gridLineWidth: 0
    },
    tooltip: {
        valueSuffix: ' pcs',
		style: {
            fontSize: '20px' // Custom font size for tooltip
        }
    },
    plotOptions: {
        bar: {
            borderRadius: '50%',
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '16px' // Custom font size for data labels
                }
            },
            groupPadding: 0.1
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -40,
        y: 80,
        floating: true,
        borderWidth: 1,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
        shadow: true,
		itemStyle: {
            fontSize: '16px' // Custom font size for legend
        }
    },
    credits: {
        enabled: false
    },
    // series: [{
    //     data: [307500,103600,45500,35000,35000,35000,35000,33600,30000,1728]
    // }]
	series: [{ data: <?php echo json_encode($total_new) ?> }]
});





</script>
</body>
</html>

