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
			<?php include('partials/app-topnav.php') ?>
			<div class="dashboard_content">
				<div class="dashboard_content_main">		
					<div class="row">
						<div class="column column-12">
							<h1 class="section_header"> List of Users</h1>
							<div class="section_content">
								<div class="users">
									<table>
										<thead>
											<tr>												
												<th>#</th>	
												<th>Employee ID</th>					
												<th>First Name</th>
												<th>Last Name</th>
												<th>Role</th>
												<th>Speciality</th>
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
													<td class="speciality"><?= $user['speciality'] ?></td>
													<td><span class="email"><?= $user['email'] ?></span><br><span class="c_number"><?= $user['c_number'] ?></span></td>
						
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
									<p class="userCount"><?= count($users) ?> Users </p>
								</div>
							</div>
						</div>
					</div>					
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="statusModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title" id="myModalLabel">SEND EMAIL</h4>
		</div>
		<div class="modal-body bootstrap-dialog-message">
				<label for="" style="margin-bottom: 1px; margin-top: 3px">FROM</label>
				<input id="fromEmail" type="text" class= "form-control" style="margin-bottom: 1px; margin-top: 3px" value="kingsun@gmail.com">													
				<label for="" style="margin-bottom: 1px; margin-top: 3px">TO</label>
				<input id="toEmail" type="text" class= "form-control" style="margin-bottom: 1px; margin-top: 3px" readonly>													
				<label for="" style="margin-bottom: 1px; margin-top: 3px">SUBJECT</label>
				<input id="subject" type="text" class= "form-control" style="margin-bottom: 1px; margin-top: 3px" >		
				<label for="">MESSAGE</label>
				<textarea id="msg" name="" id="" style="margin-bottom: 1px; margin-top: 3px" class= "form-control" cols="5" rows="5"></textarea>		
		</div>
		<div class="modal-footer">
			<button type="button" id="sendEmailTo" class="btn btn-success">Send now</button>
			<button type="button" id="closeModal" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


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
								<label for="role">Role</label>\
								<select class="appFormInput" id="role" name="role" required="">\
									<option value="manager">Manager</option>\
									<option value="employee">Employee</option>\
								</select>\
							</div>\
							<div class="form-group">\
								<label for="speciality">Speciality</label>\
								<select class="appFormInput" id="speciality" name="speciality" required="">\
									<option value="car_technitian">Car Technitian</option>\
									<option value="employee">Employee</option>\
								</select>\
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

	var script = new script;
	script.initialize();

	$(document).on('click', '#emailTo', function() {
		$('#toEmail').val($(this).data('email'));
		$('#statusModal2').modal('show');
	});
	$(document).on('click', '#sendEmailTo', function() {
		var fromEmail = $('#fromEmail').val();
		var toEmail = $('#toEmail').val();
		var subject = $('#subject').val();
		var msg = $('#msg').val();
		if(fromEmail != '' && toEmail != '' && subject != '' && msg != ''){
			var data = { 
			fromEmail: fromEmail, 
			toEmail: toEmail, 
			subject: subject, 
			msg: msg, 
			phpmailer:'send_email' 
			};
			phpMailer(data);
		}else{
			alert('All fields required!')
		}
  	});

	function phpMailer(data) {
		$.ajax({
			url: "fetchProduct.php",
			type: "POST",
			data: data,
			dataType: "json",
			beforeSend: function(response){
				$('#sendEmailTo').prop('disabled', true).html('Please wait sending...');
				$('#closeModal').prop('disabled', true);
			},
			success: function(response) {
				$('#sendEmailTo').prop('disabled', false).html('Send now');
				$('#closeModal').prop('disabled', false);
				switch (data.phpmailer) {
				case 'send_email':
					if (response.msg) {
						var toEmail = $('#toEmail').val('');
						var subject = $('#subject').val('');
						var msg = $('#msg').val('');
						alert('Message Sent!');
						$('#statusModal2').modal('hide');
					}else{
						alert("Email doesn't exist!");
					}
					break;
				default:
					alert("ERROR");
					break;
				}
			},
			error: function(xhr, status, error) {
				console.error("AJAX Error:", status, error);
			}
		});
	}

</script>
<script src="js/js.js"></script>
</body>
</html>