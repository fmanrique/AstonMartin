<?php 

$user = $this->session->userdata("user_data");
$security = $this->session->userdata("security_data");

?>
 <!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<title><?php echo $title; ?></title>

	<!--=== CSS ===-->

	<!-- Bootstrap -->
	<link href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

	<!-- jQuery UI -->
	<!--<link href="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />-->
	<!--[if lt IE 9]>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/jquery-ui/jquery.ui.1.10.2.ie.css"/>
	<![endif]-->

	<!-- Theme -->
	<link href="<?php echo base_url(); ?>assets/css/main.css?v=2" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/css/plugins.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/css/icons.css" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fontawesome/font-awesome.min.css">
	<!--[if IE 7]>
		<link rel="stylesheet" href="assets/css/fontawesome/font-awesome-ie7.min.css">
	<![endif]-->

	<!--[if IE 8]>
		<link href="assets/css/ie8.css" rel="stylesheet" type="text/css" />
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

	<script type="text/javascript">
	var base_url = "<?php echo base_url() ?>";
	var user_period = <?php echo $user['period'] ?>;
	</script>

	<!--=== JavaScript ===-->

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/libs/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/libs/lodash.compat.min.js"></script>

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		<script src="assets/js/libs/html5shiv.js"></script>
	<![endif]-->

	<!-- Smartphone Touch Events -->
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/touchpunch/jquery.ui.touch-punch.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/event.swipe/jquery.event.move.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/event.swipe/jquery.event.swipe.js"></script>

	<!-- General -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/libs/breakpoints.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/respond/respond.min.js"></script> <!-- Polyfill for min/max-width CSS3 Media Queries (only for IE8) -->
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/cookie/jquery.cookie.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/slimscroll/jquery.slimscroll.horizontal.min.js"></script>

	<!-- Page specific plugins -->
	<!-- Charts -->
	<!--[if lt IE 9]>
		<script type="text/javascript" src="plugins/flot/excanvas.min.js"></script>
	<![endif]-->
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/sparkline/jquery.sparkline.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/daterangepicker/moment.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/blockui/jquery.blockUI.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/fullcalendar/fullcalendar.min.js"></script>

	<!-- Noty -->
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/noty/jquery.noty.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/noty/layouts/top.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/noty/themes/default.js"></script>


	<!-- Pickers -->
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/pickadate/picker.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/pickadate/picker.date.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>

	<!-- Forms -->
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/select2/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/fileinput/fileinput.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/inputlimiter/jquery.inputlimiter.min.js"></script>

	<!-- Form Validation -->
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/validation/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/validation/additional-methods.min.js"></script>

	<!-- DataTables -->
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/datatables/tabletools/TableTools.min.js"></script> <!-- optional -->
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/datatables/colvis/ColVis.min.js"></script> <!-- optional -->
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/datatables/columnfilter/jquery.dataTables.columnFilter.js"></script> <!-- optional -->
	<script type="text/javascript" src="<?php echo base_url(); ?>plugins/datatables/DT_bootstrap.js"></script>

	<!-- App -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/app.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins.js?v=2"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins.form-components.js"></script>

	<script>
	$(document).ready(function(){
		"use strict";

		App.init(); // Init layout and core plugins
		Plugins.init(); // Init all plugins
		FormComponents.init(); // Init all form-specific plugins

	});
	</script>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/custom.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/demo/form_validation.js"></script>

</head>

<body>

	<!-- Header -->
	<header class="header navbar navbar-fixed-top" role="banner">
		<!-- Top Navigation Bar -->
		<div class="container">

			<!-- Only visible on smartphones, menu toggle -->
			<ul class="nav navbar-nav">
				<li class="nav-toggle"><a href="javascript:void(0);" title=""><i class="icon-reorder"></i></a></li>
			</ul>

			<!-- Logo -->
			<a class="navbar-brand" href="<?php echo base_url(); ?>">
				<img src="<?php echo base_url(); ?>assets/img/logo_am.png" alt="logo" style="max-width: 100%; height: 36px" />
			</a>
			<!-- /logo -->

			<!-- Sidebar Toggler -->
			<a href="#" class="toggle-sidebar bs-tooltip" data-placement="bottom" data-original-title="Toggle navigation">
				<i class="icon-reorder"></i>
			</a>
			<!-- /Sidebar Toggler -->
			<span class="head-title">Dealer Marketing Plan Builder</span>

			
			<!-- Top Right Menu -->
			<ul class="nav navbar-nav navbar-right">
				<?php if ($user['user_type_id'] == 1) : ?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						Regions: <?php echo $user['region_name']; ?>
						<i class="icon-caret-down small"></i>
					</a>
					<ul class="dropdown-menu">
						<?php foreach($security['regions'] as $key => $region): ?>
							<?php if ($user['region_id'] == $region['id']) : ?>
								<li><a href="<?php echo base_url() . 'users/changeregion/' . $region['id'] . '/' . $this->uri->segment(1) . '/' . rand(); ?>"><i class="icon-ok"></i> <?php echo $region['description']; ?></a></li>
							<?php else: ?>
								<li><a href="<?php echo base_url() . 'users/changeregion/' . $region['id'] . '/' . $this->uri->segment(1) . '/' . rand(); ?>"><span style="margin-left: 21px"><?php echo $region['description']; ?></span></a></li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</li>
				<?php endif; ?>
				
				<?php if ($user['user_type_id'] == 1 || $user['user_type_id'] == 2) : ?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						Dealership: <?php echo $user['dealership_name']; ?>
						<i class="icon-caret-down small"></i>
					</a>
					<ul class="dropdown-menu">
						<?php foreach($security['dealers'] as $key => $dealer): ?>
							<?php if ($user['dealership_id'] == $dealer['id']) : ?>
								<li><a href="<?php echo base_url() . 'users/changedealer/' . $dealer['id'] . '/' . $this->uri->segment(1) . '/' . rand(); ?>"><i class="icon-ok"></i> <?php echo $dealer['name']; ?></a></li>
							<?php else: ?>
								<li><a href="<?php echo base_url() . 'users/changedealer/' . $dealer['id'] . '/' . $this->uri->segment(1) . '/' . rand(); ?>"><span style="margin-left: 21px"><?php echo $dealer['name']; ?></span></a></li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</li>
				<?php endif; ?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						Year: <?php echo $user['period'] ?>
						<i class="icon-caret-down small"></i>
					</a>
					<ul class="dropdown-menu">
						<?php foreach($security['periods'] as $key => $period): ?>
							<?php if ($user['period'] == $period) : ?>
								<li><a href="<?php echo base_url() . 'users/changeperiod/' . $period . '/' . $this->uri->segment(1) . '/' . rand(); ?>"><i class="icon-ok"></i> <?php echo $period; ?></a></li>
							<?php else: ?>
								<li><a href="<?php echo base_url() . 'users/changeperiod/' . $period . '/' . $this->uri->segment(1) . '/' . rand(); ?>"><span style="margin-left: 21px"><?php echo $period; ?></span></a></li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</li>
				<!-- User Login Dropdown -->
				<li class="dropdown user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<!--<img alt="" src="assets/img/avatar1_small.jpg" />-->
						<i class="icon-male"></i>
						<span class="username"><?php  echo $user['name']; ?></span>
						<i class="icon-caret-down small"></i>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url() . "users/myprofile/"; ?>"><i class="icon-user"></i> My Profile</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo base_url() . "logout/"; ?>"><i class="icon-key"></i> Log Out</a></li>
					</ul>
				</li>
				<!-- /user login dropdown -->
			</ul>
			<!-- /Top Right Menu -->
		</div>
		<!-- /top navigation bar -->
	</header> <!-- /.header -->
	<div id="container">
		<div id="sidebar" class="sidebar-fixed">
			<div id="sidebar-content">

				<!--=== Navigation ===-->
				<ul id="nav">
					<li <?php echo ($option == "dashboard") ? "class='current'" : ""; ?>>
						<a href="<?php echo base_url() . "dashboard" ?>">
							<i class="icon-dashboard"></i>
							Dashboard
						</a>
					</li>
					<?php if ($user['user_type_id'] == 1) : ?>
					<li <?php echo ($option == "catalogs" || $option == "categories" || $option == "audiences" ||  $option == "focus" || $option == "models" || $option == "metrics" || $option == "regions" || $option == "dealerships" || $option == "currencies") ? "class='current'" : ""; ?>>
						<a href="javascript:void(0);">
							<i class="icon-edit"></i>
							Catalogs
						</a>
						<ul class="sub-menu">
							<li <?php echo ($option == "categories") ? "class='current'" : ""; ?>>
								<a href="<?php echo base_url() . "categories" ?>">
								<i class="icon-angle-right"></i>
								Activity Types
								</a>
							</li>
							<li <?php echo ($option == "audiences") ? "class='current'" : ""; ?>>
								<a href="<?php echo base_url() . "audiences" ?>">
								<i class="icon-angle-right"></i>
								Audiences
								</a>
							</li>
							<li <?php echo ($option == "focus") ? "class='current'" : ""; ?>>
								<a href="<?php echo base_url() . "focus" ?>">
								<i class="icon-angle-right"></i>
								Activity Focus
								</a>
							</li>
							<li <?php echo ($option == "models") ? "class='current'" : ""; ?>>
								<a href="<?php echo base_url() . "models" ?>">
								<i class="icon-angle-right"></i>
								Model Focus
								</a>
							</li>
							<li <?php echo ($option == "metrics") ? "class='current'" : ""; ?>>
								<a href="<?php echo base_url() . "metrics" ?>">
								<i class="icon-angle-right"></i>
								Metrics
								</a>
							</li>
							<li <?php echo ($option == "dealerships") ? "class='current'" : ""; ?>>
								<a href="<?php echo base_url() . "dealerships" ?>">
								<i class="icon-angle-right"></i>
								Dealerships
								</a>
							</li>
							<li <?php echo ($option == "regions") ? "class='current'" : ""; ?>>
								<a href="<?php echo base_url() . "regions" ?>">
								<i class="icon-angle-right"></i>
								Regions
								</a>
							</li>
							<li <?php echo ($option == "currencies") ? "class='current'" : ""; ?>>
								<a href="<?php echo base_url() . "currencies" ?>">
								<i class="icon-angle-right"></i>
								Currencies
								</a>
							</li>
						</ul>
					</li>
					<li <?php echo ($option == "users") ? "class='current'" : ""; ?>>
						<a href="<?php echo base_url() . "users" ?>">
							<i class="icon-user"></i>
							Users
						</a>
					</li>
					<?php endif; ?>
					<li <?php echo ($option == "activities") ? "class='current'" : ""; ?>>
						<a href="<?php echo base_url() . "activities" ?>">
							<i class="icon-calendar "></i>
							Activities
						</a>
					</li>
					<li <?php echo ($option == "reports") ? "class='current'" : ""; ?>>
						<a href="<?php echo base_url() . "reports" ?>">
							<i class="icon-th-list"></i>
							Reports
						</a>
					</li>
				</ul>

			</div>
			<div id="divider" class="resizeable"></div>
		</div>
		<!-- /Sidebar -->

		<div id="content">
			<div class="container">
				<!--=== Page Header ===-->
				<div class="page-header">
					<div class="page-title">
						<h3><?php echo $title; ?></h3>
					</div>
				</div>
				<!-- /Page Header -->

				<!--=== Page Content ===-->
				<?php $this->load->view($content_view); ?>
				<!-- /Page Content -->
			</div>
			<!-- /.container -->

		</div>
	</div>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/main.js"></script>
</body>
</html>