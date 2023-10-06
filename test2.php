<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>CodePen - DataTables 1.10 - Bootstrap 3.3.7 Integration</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">



<link rel='stylesheet' href='https://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://cdn.datatables.net/plug-ins/28e7751dbec/integration/bootstrap/3/dataTables.bootstrap.css'>


</head>
<body>
<!-- partial:index.partial.html -->
<div class="container-fluid">
		<div class="row">
				<div class="col-xs-12">
					<header class="text-center">
						<h1>DataTables 1.10 and Bootstrap 3.3.7 Integration</h1>
						<p class="text-center">Basic table example implementing Bootstrap styles and framework with dataTables. This example uses previous versions of both Bootstrap (3.3.6) and dataTables (1.10.0).</p>
					</header>
				</div>
		</div>
		<div class="row">
				<div class="col-xs-12">
						<table class="table table-striped table-hover table-condensed" id="ex-datatables-basic">
						<thead>
										<tr>
												<th>ID</th>

												<th>Agt FN</th>

												<th>Agt LN</th>

												<th>EMPID</th>

												<th>Call eDT</th>

												<th>Call eTM</th>

												<th>Acct No.</th>

												<th>City</th>

												<th>Customer</th>

												<th>State</th>

												<th>Hold Time</th>

												<th>Xfer</th>

												<th>Xfer Agt</th>
										</tr>
								</thead>
								<tbody>
								<tr>
												<td>59</td>

												<td>Ciara</td>

												<td>Franks</td>

												<td>IB3545</td>

												<td>06/05/2014</td>

												<td>46:16</td>

												<td>0384786-EJ</td>

												<td>JaÃ©n</td>

												<td>Ebony Mullins</td>

												<td>AN</td>

												<td>7</td>

												<td>0</td>

												<td>Caesar Z. Townsend</td>
										</tr>

								</tbody>
						</table>
				</div>
		</div>
</div>
<!-- partial -->
  <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js'></script>
<script src='https://cdn.datatables.net/1.10.0/js/jquery.dataTables.js'></script>
<script src='https://cdn.datatables.net/plug-ins/28e7751dbec/integration/bootstrap/3/dataTables.bootstrap.js'></script>
<script>
	/* The DataTables integration plug-in script can be found at https://cdn.datatables.net/plug-ins/28e7751dbec/integration/bootstrap/3/dataTables.bootstrap.js
*/
//  TEST BASIC INITIALIZATION - BASIC DATATABLE
$(function () {
	// $('#ex-datatables-basic').dataTable({
	// 		pageLength: 10,
	// 		processing: true,
	// 		pagingType: 'full_numbers',
	// 		orderMulti: 'true',
	// 		order: [
	// 				[3, 'asc'],
	// 				[2, 'asc']
	// 		]
	// });
	$('#ex-datatables-basic').DataTable();
});

</script>
</body>
</html>
