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
</head>
<body>
	<div id="dashboardMainContainer">
		<?php include('partials/app-sidebar.php') ?>
		<div class="dasboard_content_container" id="dasboard_content_container">
			<div id="dashboardContent">
				<?php include('partials/app-topnav.php') ?>
				<!--<div id="dashboardUserScroll">-->
					<div class="dashboard_content">
						<div class="dashboard_content_main">		
							<div class="row">
							<div class="column column-12" style="height: 596px; overflow: auto;">
									<h1 class="section_header"> List of Users</h1>
									<div class="section_content">
									<div class="reportTypeContainer">
											<div class="reportType">
												<p>Search ID / Name</p>
												<input type="text" id="searchInput" value = "<?= isset($_GET['employee_Id']) ? $_GET['employee_Id'] : '' ?>" placeholder="Enter Employee ID or Name" style="width: 350px;" oninput="filterEmployeesByEmployeeId()" />
											</div>
											<div class="reportType">
												<p>Print Report Employees</p>
												<div class="alignRight">
													<a href="database/report_csv.php?report=employee" class="reportExportBtn">Excel</a>
													<a href="database/report_pdf.php?report=employee" class="reportExportBtn">PDF</a>
												</div>
											</div>
										</div>
										<div class="users">
										<p class="userCount"><?= count($users) ?> Active Users </p>
											<table>
												<thead>
													<tr>												
														<th>#</th>	
														<th>Employee ID</th>					
														<th>First Name</th>
														<th>Last Name</th>
														<th>Role</th>
														<th>Expertise</th>
														<th>Contact Details</th>
														<th>Created At</th>
														<th>Updated At</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php 
													$stmt = $conn->prepare("SELECT * FROM users where deleted = 0 ORDER BY created_at DESC");
													$stmt->execute();
													$stmt->setFetchMode(PDO::FETCH_ASSOC);
													$users2 = $stmt->fetchAll();
													foreach($users2 as $index => $user){ ?>
														<tr>
															<td><?= $index + 1 ?></td>
															<td class="employee_id"><?= $user['employee_id'] ?></td>
															<td class="firstName"><?= $user['first_name'] ?></td>
															<td class="lastName"><?= $user['last_name'] ?></td>
															<td class="role"><?= $user['role'] ?></td>
															<td class="experTise"><?= $user['expertise'] ?></td>
															<td><span  class="email"><?= $user['email'] ?></span><br><span class="c_number"><?= $user['c_number'] ?></span></td>
															<td><?= date('M d,Y @ h:i:s A', strtotime($user['created_at'])) ?></td>
															<td><?= date('M d,Y @ h:i:s A', strtotime($user['updated_at'])) ?></td>
															<td>
																<a href="#" class="updateUser" data-userid="<?= $user['id'] ?>"> <i class="fa-regular fa-pen-to-square"></i> Edit</a>
																<a href="" class="deleteUser" data-userid="<?= $user['id'] ?>" data-fname="<?= $user['first_name'] ?>" data-lname="<?= $user['last_name'] ?>" > <i class="fa fa-trash"></i> Delete</a>
															</td>
														</tr>
													<?php } ?>
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


<?php include('partials/app-scripts.php'); ?>


<script>
	function script(){
		this.initialize = function(){
			this.registerEvents();
		},

		this.registerEvents = function(){
			document.addEventListener('click', function(e){
				targetElement = e.target;
				classList = targetElement.classList;


				if(classList.contains('deleteUser')){
					e.preventDefault();
					userId = targetElement.dataset.userid;
					fname = targetElement.dataset.fname;
					lname = targetElement.dataset.lname;
					fullName = fname + ' ' + lname;

					BootstrapDialog.confirm({
						title: 'Delete User',
						type: BootstrapDialog.TYPE_DANGER,
						message: 'Are you sure to delete <strong>'+ fullName +'</strong> ?',
						callback: function(isDelete){
							if(isDelete){								
								$.ajax({
									method: 'POST',
									data: {									
										id: userId,
										table: 'users'
									},
									url: 'database/delete.php',
									dataType: 'json',
									success: function(data){
										message = data.success ? 
												fullName + ' successfully deleted!' : 'Error processing your request!';

										BootstrapDialog.alert({
											type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
											message: message,
											callback: function(){
												if(data.success) location.reload();
											}
										});
									}
								});
							}
						}
					});
				}

				if(classList.contains('updateUser')){
					e.preventDefault(); // Prevent loading.;

					// Get data.
					firstName = targetElement.closest('tr').querySelector('td.firstName').innerHTML;
					lastName = targetElement.closest('tr').querySelector('td.lastName').innerHTML;
					role = targetElement.closest('tr').querySelector('td.role').innerHTML;
					experTise = targetElement.closest('tr').querySelector('td.experTise').innerHTML;
					email = targetElement.closest('tr').querySelector('.email').innerHTML;
					c_number = targetElement.closest('tr').querySelector('.c_number').innerHTML;
					userId = targetElement.dataset.userid;


					BootstrapDialog.confirm({
						title: 'Update ' + firstName + ' ' + lastName,
						message: '<form>\
						  <div class="form-group">\
						    <label for="firstName">First Name:</label>\
						    <input type="text" class="form-control" id="firstName" value="'+ firstName +'">\
						  </div>\
						  <div class="form-group">\
						    <label for="lastName">Last Name:</label>\
						    <input type="text" class="form-control" id="lastName" value="'+ lastName +'">\
						  </div>\
						  	<div class="form-group">\
								<label for="role">Role </label>\
								<select class="appFormInput" id="role" name="role" required="">\
									<option value="manager" '+ (role == 'manager' ? "selected" : '') +'>Manager</option>\
									<option value="employee" '+ (role == 'employee' ? "selected" : '') +'>Employee</option>\
								</select>\
							</div>\
						<div class="form-group">\
						    <label for="expertise">Expertise:</label>\
						    <input type="text" class="form-control" id="experTise" value="'+ experTise +'">\
						</div>\
						  <div class="form-group">\
						    <label for="email">Email address:</label>\
						    <input type="email" class="form-control" id="emailUpdate" value="'+ email +'">\
						  </div>\
						  <div class="form-group">\
						    <label for="email">Phone number:</label>\
						    <input type="email" class="form-control" id="cnumberUpdate" value="'+ c_number +'">\
						  </div>\
						</form>',
						callback: function(isUpdate){
							if(isUpdate){ // If user click 'Ok' button.
								$.ajax({
									method: 'POST',
									data: {
										userId: userId,
										f_name: document.getElementById('firstName').value,
										l_name: document.getElementById('lastName').value,
										role: document.getElementById('role').value,
										expertise: document.getElementById('experTise').value,
										email: document.getElementById('emailUpdate').value,
										c_number: document.getElementById('cnumberUpdate').value,
									},
									url: 'database/update-user.php',
									dataType: 'json',
									success: function(data){
										if(data.success){
											BootstrapDialog.alert({
												type: BootstrapDialog.TYPE_SUCCESS,
												message: data.message,
												callback: function(){
													location.reload();
												}
											});
										} else 
											BootstrapDialog.alert({
												type: BootstrapDialog.TYPE_DANGER,
												message: data.message,
											});
									}
								});
							}
						}
					});
				}
			});
		}
	}	

			// Filter products based on search input
			filterEmployeesByEmployeeId();
		function filterEmployeesByEmployeeId() {
			var input = document.getElementById('searchInput').value.toLowerCase();
			var rows = document.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

			for (var i = 0; i < rows.length; i++) {
				var itemCode = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase(); // Change the column number to the item code column
				var employee_Id = rows[i].getElementsByTagName('td')[2].textContent.toLowerCase(); // Change the column number to the product name column

				if (itemCode.indexOf(input) > -1 || employee_Id.indexOf(input) > -1) {
					rows[i].style.display = '';
				} else {
					rows[i].style.display = 'none';
				}
			}
		}

	var script = new script;
	script.initialize();

</script>
<script src="js/js.js"></script>
</body>
</html>