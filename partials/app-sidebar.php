<?php
	$user = $_SESSION['user'];
	echo ($user['role'] != 'manager') ? '<script>window.location.href = "pos.php"</script>' : '';
?>
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<script src="https://kit.fontawesome.com/8bf423e820.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="css/fontawesome/css/all.min.css">
<div class="dashboard_sidebar" id="dashboard_sidebar">
	<div class="jayann_logo">
		<img src="images/user/log.png" alt="User image." id="userImage" />
	</div>
	<h3 class="dashboard_logo" id="dashboard_logo">KING SUN ENT.</h3>
	<div class="dashboard_sidebar_user">
		<span><?= $user['first_name'] . ' ' . $user['last_name'] ?></span>
		<br>
		<span><?= $user['role'] ?></span>
	</div>
	<div class="dashboard_sidebar_menus">
		<ul class="dashboard_menu_lists">
			<!-- class="menuActive"  -->
			<li class="liMainMenu">
				<a href="./dashboard.php" ><i class="fa fa-dashboard"></i> <span class="menuText">Dashboard</span></a>
			</li>
			<li class="liMainMenu">
				<a href="javascript:void(0);" class="showHideSubMenu" >
					<i class="fa fa-tag showHideSubMenu"></i> 
					<span class="menuText showHideSubMenu" >Product</span>
					<i class="fa fa-angle-right mainMenuIconArrow showHideSubMenu" ></i> 
				</a>

				<ul class="subMenus">
					<li><a class="subMenuLink" href="./product-view.php"> <i class="fa fa-circle-o"></i> View Product</a></li>
					<li><a class="subMenuLink" href="./product-add.php"> <i class="fa fa-circle-o"></i> Add Product</a></li>
				</ul>
			</li>			
			<li class="liMainMenu">
				<a href="javascript:void(0);" class="showHideSubMenu" >
					<i class="fa fa-truck showHideSubMenu"></i> 
					<span class="menuText showHideSubMenu" >Supplier</span>
					<i class="fa fa-angle-right mainMenuIconArrow showHideSubMenu" ></i> 
				</a>

				<ul class="subMenus">
					<li><a class="subMenuLink" href="./supplier-view.php"> <i class="fa fa-circle-o"></i> View Supplier</a></li>
					<li><a class="subMenuLink" href="./supplier-add.php"> <i class="fa fa-circle-o"></i> Add Supplier</a></li>
				</ul>
			</li>

			<li class="liMainMenu">
				<a href="javascript:void(0);" class="showHideSubMenu" >
					<i class="fa fa-shopping-cart showHideSubMenu"></i> 
					<span class="menuText showHideSubMenu" >Order Logs</span>
					<i class="fa fa-angle-right mainMenuIconArrow showHideSubMenu" ></i> 
				</a>

				<ul class="subMenus">
					<li><a class="subMenuLink" href="./view-order.php"> <i class="fa fa-circle-o"></i> View Orders</a></li>
					<li><a class="subMenuLink" href="./product-order.php"> <i class="fa fa-circle-o"></i> Create Order</a></li>
				</ul>
			</li>
			<li class="liMainMenu showHideSubMenu" >
				<a href="javascript:void(0);" class="showHideSubMenu" >
					<i class="fa fa-user-plus showHideSubMenu"></i> 
					<span class="menuText showHideSubMenu" >User</span>
					<i class="fa fa-angle-right mainMenuIconArrow showHideSubMenu" ></i> 
				</a>

				<ul class="subMenus">
					<li><a class="subMenuLink" href="./users-view.php"> <i class="fa fa-circle-o"></i> View Users</a></li>
					<li><a class="subMenuLink" href="./users-add.php"> <i class="fa fa-circle-o"></i> Add User</a></li>
				</ul>
			</li>
			<li class="liMainMenu showHideSubMenu" >
				<a href="javascript:void(0);" class="showHideSubMenu" >
					<i class="fa fa-clipboard showHideSubMenu"></i> 
					<span class="menuText showHideSubMenu" >Sales Log</span>
					<i class="fa fa-angle-right mainMenuIconArrow showHideSubMenu" ></i> 
				</a>

				<ul class="subMenus">
					<li><a class="subMenuLink" href="./sales-log.php"> <i class="fa fa-circle-o"></i> View Sales Log</a></li>
					<li><a class="subMenuLink" href="./collection-receipts.php"> <i class="fa fa-circle-o"></i> Collection Receipts</a></li>
				</ul>
			</li>
			<li class="liMainMenu">
				<a href="./history.php" ><i class="fas fa-recycle"></i> <span class="menuText">History Bin</span></a>
			</li>
		</ul>
	</div>
</div>