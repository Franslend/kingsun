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
	<style>
		.form-control{
			margin-bottom: 1px !important; 
			margin-top: 3px !important;
			
		}
		#ex-datatables-basic_paginate{
			margin-right: -31px !important; 
		} 
		#ex-datatables-basic_filter{
			margin-right: -31px !important; 
		} 
	</style>
	<div id="dashboardMainContainer">
		<?php include('partials/app-sidebar.php') ?>
		<div class="dasboard_content_container" id="dasboard_content_container">
			<div id="dashboardContent">
				<?php include('partials/app-topnav.php') ?>
				<div class="dashboard_content">
					<div class="dashboard_content_main">		
						<div class="row">
							<div class="column column-12" style="height: 596px; overflow: auto;">
								<h1 class="section_header"> List of History</h1>
								<div class="section_content">


											<div class="row">
												<div class="col-xs-12">
													<table class="table table-striped table-hover table-condensed" id="ex-datatables-basic">
														<thead>
															<tr>
																<th>#</th>
																<th>Module name</th>
																<th>Description</th>
																<th>Deleted at</th>
																<th>Action</th>
															</tr>
														</thead>
														<tbody>
															<!-- <tr>
																<td>59</td>
																<td>Ciara</td>
																<td>Franks</td>
																<td>IB3545</td>
																<td>
																	<button type="button" data-module_name="" data-primary_id="" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
																</td>
															</tr> -->
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
	</div>


<div class="modal fade" id="statusModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
		<h3 class="text-center" id="modalTitle"></h3>
		<input type="hidden" id="table_name">
		<input type="hidden" id="primary_id">
      </div>
      <div class="modal-footer">
		<span id="btnAction"></span>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php include('partials/app-scripts.php'); ?>
<script src='https://cdn.datatables.net/1.10.0/js/jquery.dataTables.js'></script>
<script src='https://cdn.datatables.net/plug-ins/28e7751dbec/integration/bootstrap/3/dataTables.bootstrap.js'></script>

<script>
$(function () {
	var main_table = $('#ex-datatables-basic').DataTable({
		"ajax": {
			"url": "fetchProduct.php",
			"type": "POST",
			"data": {historys_view: "view"}
		},
		"columns": [
			{ "data": "#" }, 
			{ "data": "module_name" },
			{ "data": "desc" }, 
			{ "data": "deleted_at" }, 
			{ "data": "action" }
		]
	});
	$(document).on('click', '#restore', function() {
		$('#table_name').val($(this).data('table_name'))
		$('#primary_id').val($(this).data('primary_id'))
		$('#modalTitle').html('Are you sure you want to restore this?');
		$('#btnAction').html('<button type="button" class="btn btn-primary" id="restoreNow">Restore now</button>');
		$('#statusModal3').modal('show');
	});
	$(document).on('click', '#restoreNow', function() {
		$.ajax({
				url: "fetchProduct.php",
				type: "POST",
				data: {
					restore_data:'RESTORE',
					table_name:$('#table_name').val(),
					id:$('#primary_id').val()
				},
				dataType: "json",
				success: function(response) {
                    alert('Restore Successfully!');
					$('#statusModal3').modal('hide');
					main_table.ajax.reload();
				},
				error: function(xhr, status, error) {
					console.error("AJAX Error:", status, error);
				}
			});
	});

	$(document).on('click', '#delete_perma', function() {
		$('#table_name').val($(this).data('table_name'))
		$('#primary_id').val($(this).data('primary_id'))
		$('#modalTitle').html('Are you sure you want to delete this completely in the system?');
		$('#btnAction').html('<button type="button" class="btn btn-danger" id="deleteNow">Delete now</button>');
		$('#statusModal3').modal('show');
	});
	$(document).on('click', '#deleteNow', function() {
		$.ajax({
				url: "fetchProduct.php",
				type: "POST",
				data: {
					restore_data:'delete',
					table_name:$('#table_name').val(),
					id:$('#primary_id').val()
				},
				dataType: "json",
				success: function(response) {
                    alert('Deleted Successfully!');
					$('#statusModal3').modal('hide');
					main_table.ajax.reload();
				},
				error: function(xhr, status, error) {
					console.error("AJAX Error:", status, error);
				}
			});
	});

});

</script>