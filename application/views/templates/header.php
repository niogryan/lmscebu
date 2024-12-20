<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="noindex, nofollow" name="robots">
	<meta content="CEBUCYBERBOB LMS" name="Description" />
	<meta content="CEBUCYBERBOB LMS" name="abstract" />
	<meta content="CEBUCYBERBOB" name="author" />
	<meta content="CEBUCYBERBOB" name="copyright" />
	<meta content="Business" name="category" />
	<meta content="" name="timestamp" />
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>LMS</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/dist/css/adminlte.min.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/plugins/toastr/toastr.min.css">
	<link rel="stylesheet" href="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/plugins/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" href="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/plugins/select2/css/select2.min.css">
	<link rel="stylesheet" href="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
	<!--
	<link href="<?php echo $this->config->item('base_url').'resources/'; ?>datepicker/css/datepicker.css" rel="stylesheet" type="text/css">
-->
	<?php
		$this->load->view('templates/style');
	?>
</head>
<body class="hold-transition sidebar-mini layout-navbar-fixed">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark navbar-danger">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
		<li class="nav-item">
			<?php
				echo anchor('/','Sign Out <i class="fas fa-sign-out-alt"></i>','class="nav-link"');
			?>
        </li>
    </ul>
  </nav>

  <aside class="main-sidebar elevation-4 sidebar-dark-danger">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <span class="brand-text font-weight-light">Lending Management System</span>
    </a>
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info ">
          <a href="#" class="d-block"><b class="text-warning"><?php echo $this->session->userdata('name').'</b> ['.$this->session->userdata('role').']'; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
		<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
			<li class="nav-item">
				<?php
					echo anchor('app/index','<i class="fas fa-home"></i> <p>Home</p>','class="nav-link '.($mainmenu=='home' ? 'active' : null).'"');
				?>
			</li>	
			<?php
				if($accessmenu['appbadaccounts']['isaccess']!='F')
				{	
			?>
					<li class="nav-item">
						<?php
							echo anchor('app/badaccounts','<i class="fas fa-user-times"></i> <p>Bad Accounts</p>','class="nav-link '.($mainmenu=='badaccounts' ? 'active' : null).'"');
						?>
					</li>
			<?php
				}	
			?>
			<?php
				if(	$accessmenu['customerindex']['isaccess']!='F'
					|| $accessmenu['customeradd']['isaccess']!='F'
					)
				{
			
			?>
			<li class="nav-item has-treeview <?php echo ($mainmenu=='customer' ? 'menu-open' :null); ?>">
				<a href="#" class="nav-link <?php echo ($mainmenu=='customer' ? 'active' :null); ?>">
					<i class="fas fa-users"></i>
					<p>
						Customers
						<i class="right fas fa-angle-left"></i>
					</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<?php
							if($accessmenu['customerindex']['isaccess']!='F')
							{
								echo anchor('customer/index',' <i class="nav-icon far fa-circle text-warning"></i> <p>View All Customers</p>','class="nav-link '.($submenu=='index' ? 'active' : null).'"');
							}
						?>
					</li>
					<li class="nav-item">
						<?php
							if($accessmenu['customeradd']['isaccess']!='F')
							{
								echo anchor('customer/add',' <i class="nav-icon far fa-circle text-warning"></i> <p>Add Customers</p>','class="nav-link '.($submenu=='add' ? 'active' : null).'"');	
							}
						?>
					</li>
				</ul>
			</li>
			<?php
			}	
			?>
			<?php
				if(	$accessmenu['loanindex']['isaccess']!='F'
					|| $accessmenu['loanadd']['isaccess']!='F'
					)
				{
			
			?>
			<li class="nav-item has-treeview <?php echo ($mainmenu=='loan' ? 'menu-open' :null); ?>">
				<a href="#" class="nav-link <?php echo ($mainmenu=='loan' ? 'active' :null); ?>">
					<i class="far fa-credit-card"></i>
					<p>
						Loans
						<i class="right fas fa-angle-left"></i>
					</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<?php
							if($accessmenu['loanindex']['isaccess']!='F')
							{
								echo anchor('loan/index',' <i class="nav-icon far fa-circle text-warning"></i> <p>View All Loans</p>','class="nav-link '.($submenu=='loanindex' ? 'active' : null).'"');
							}
						?>
					</li>
					<li class="nav-item">
						<?php
							if($accessmenu['loanadd']['isaccess']!='F')
							{	
								echo anchor('loan/add',' <i class="nav-icon far fa-circle text-warning"></i> <p>Add Loan</p>','class="nav-link '.($submenu=='addloan' ? 'active' : null).'"');
							}
						?>
					</li>
					<li class="nav-item">
						<?php
							if($accessmenu['loaninquiry']['isaccess']!='F')
							{	
								echo anchor('loan/inquiry',' <i class="nav-icon far fa-circle text-warning"></i> <p>Inquiry</p>','class="nav-link '.($submenu=='loaninquiry' ? 'active' : null).'"');
							}
						?>
					</li>
				</ul>
			</li>
			<?php
				}
			?>
			<?php
				if($accessmenu['paymentadd']['isaccess']!='F')
				{
			
			?>
			<li class="nav-item has-treeview <?php echo ($mainmenu=='payment' ? 'menu-open' :null); ?>">
				<a href="#" class="nav-link <?php echo ($mainmenu=='payment' ? 'active' :null); ?>">
					<i class="fas fa-cash-register"></i>
					<p>
						Loan Payments
						<i class="right fas fa-angle-left"></i>
					</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<?php
							if($accessmenu['paymentadd']['isaccess']!='F')
							{	
								echo anchor('payment/add',' <i class="nav-icon far fa-circle text-warning"></i> <p>Add Payments</p>','class="nav-link '.($submenu=='add' ? 'active' : null).'"');
							}
						?>
					</li>
					<li class="nav-item">
						<?php
							if($accessmenu['paymentinquiry']['isaccess']!='F')
							{	
								echo anchor('payment/inquiry',' <i class="nav-icon far fa-circle text-warning"></i> <p>Inquiry</p>','class="nav-link '.($submenu=='inquiry' ? 'active' : null).'"');
							}
						?>
					</li>
				</ul>
			</li>
			<?php
				}
			?>
			<li class="nav-item has-treeview <?php echo ($mainmenu=='report' ? 'menu-open' :null); ?>">
				<a href="#" class="nav-link <?php echo ($mainmenu=='report' ? 'active' :null); ?>">
					<i class="far fa-list-alt"></i>
					<p>
						Reports
						<i class="right fas fa-angle-left"></i>
					</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<?php
							if($accessmenu['rptcollectionlist']['isaccess']!='F')
							{
								//echo anchor('rpt/collectionlist',' <i class="far fa-circle nav-icon"></i> <p>Collection List</p>','class="nav-link '.($submenu=='collectionlist' ? 'active' : null).'"');
								echo anchor('rpt/collectionlistv2',' <i class="far fa-circle nav-icon"></i> <p>New Collection List <span class="right badge badge-danger">Beta</span></p>','class="nav-link '.($submenu=='collectionlistv2' ? 'active' : null).'"');
							}
						?>
					</li>
					<li class="nav-item">
						<?php
							if($accessmenu['rptdaily']['isaccess']!='F')
							{
								//echo anchor('rpt/summary',' <i class="far fa-circle nav-icon"></i> <p>Daily Summary</p>','class="nav-link '.($submenu=='summary' ? 'active' : null).'"');
								echo anchor('rpt/newsummary',' <i class="far fa-circle nav-icon"></i> <p>Daily Summary </p>','class="nav-link '.($submenu=='newsummary' ? 'active' : null).'"');
							
							}
						?>
					</li>
					<li class="nav-item">
						<?php
							if($accessmenu['rptlenders']['isaccess']!='F')
							{
								echo anchor('rpt/lendersattendance',' <i class="far fa-circle nav-icon"></i> <p>Lender\'s Attendance</p>','class="nav-link '.($submenu=='lendersattendance' ? 'active' : null).'"');
							}
						?>
					</li>
					
					
					<li class="nav-item">
						<?php
							if($accessmenu['rptpassbookcharge']['isaccess']!='F')
							{
								echo anchor('rpt/passbookcharge',' <i class="far fa-circle nav-icon"></i> <p>Passbook Charge</p>','class="nav-link '.($submenu=='passbookcharge' ? 'active' : null).'"');
							}
						?>
					</li>
					
					<li class="nav-item">
						<?php
							if($accessmenu['rptservicecharge']['isaccess']!='F')
							{
								echo anchor('rpt/servicecharge',' <i class="far fa-circle nav-icon"></i> <p>Service Charge</p>','class="nav-link '.($submenu=='servicecharge' ? 'active' : null).'"');
							}
						?>
					</li>
					
					
					
				</ul>
			</li>
			
			
			<?php
				// if(	$accessmenu['toolsareas']['isaccess']!='F'
					// || $accessmenu['toolsbranches']['isaccess']!='F'
					// || $accessmenu['toolsbranchesareas']['isaccess']!='F'
					// || $accessmenu['toolsholidays']['isaccess']!='F'
					// || $accessmenu['toolsroles']['isaccess']!='F'
					// || $accessmenu['toolsuseracounts']['isaccess']!='F'
					// )
				// {
			
			?>
					<li class="nav-item has-treeview <?php echo ($mainmenu=='transactions' ? 'menu-open' :null); ?>">
						<a href="#" class="nav-link <?php echo ($mainmenu=='transactions' ? 'active' :null); ?>">
							<i class="fas fa-pen-alt"></i>
							<p>
								Transactions
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<?php
									// if($accessmenu['transexpenses']['isaccess']!='F')
									// {
										// echo anchor('transaction/cashonhand','<i class="far fa-circle nav-icon"></i> <p>Cash on Hand</p>','class="nav-link '.($submenu=='cashonhand' ? 'active' : null).'"');
									// }
								?>
							</li>
							<li class="nav-item">
								<?php
									if($accessmenu['transexpenses']['isaccess']!='F')
									{
										echo anchor('transaction/expenses','<i class="far fa-circle nav-icon"></i> <p>Expenses</p>','class="nav-link '.($submenu=='expenses' ? 'active' : null).'"');
									}
								?>
							</li>
							<li class="nav-item">
								<?php
									if($accessmenu['transremittance']['isaccess']!='F')
									{
										echo anchor('transaction/remittance','<i class="far fa-circle nav-icon"></i> <p>Remittance</p>','class="nav-link '.($submenu=='remittance' ? 'active' : null).'"');
									}
								?>
							</li>
						</ul>
					</li>
			<?php
				//}
			
			?>	
			
			
			<?php
				if(	$accessmenu['toolsareas']['isaccess']!='F'
					|| $accessmenu['toolsbranches']['isaccess']!='F'
					|| $accessmenu['toolsbranchesareas']['isaccess']!='F'
					|| $accessmenu['toolsholidays']['isaccess']!='F'
					|| $accessmenu['toolsroles']['isaccess']!='F'
					|| $accessmenu['toolsuseracounts']['isaccess']!='F'
					)
				{
			
			?>
					<li class="nav-item has-treeview <?php echo ($mainmenu=='tools' ? 'menu-open' :null); ?>">
						<a href="#" class="nav-link <?php echo ($mainmenu=='tools' ? 'active' :null); ?>">
							<i class="fas fa-cogs"></i>
							<p>
								Tools
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
						
							<li class="nav-item">
								<?php
									if($accessmenu['toolsareas']['isaccess']!='F')
									{
										echo anchor('tools/areas','<i class="fas fa-map-marked-alt mr-1"></i> <p>Areas</p>','class="nav-link '.($submenu=='areas' ? 'active' : null).'"');
									}
								?>
							</li>
							<li class="nav-item">
								<?php
									if($accessmenu['toolsbranches']['isaccess']!='F')
									{
										echo anchor('tools/branches','<i class="fas fa-warehouse mr-1"></i> <p>Branches</p>','class="nav-link '.($submenu=='branches' ? 'active' : null).'"');
									}
								?>
							</li>
							<li class="nav-item">	
								
								<?php

									if($accessmenu['toolsbranchesareas']['isaccess']!='F')
									{
										echo anchor('tools/branchesareas',' <i class="fas fa-map-pin mr-1"></i> <p>Branches Areas</p>','class="nav-link '.($submenu=='branchesareas' ? 'active' : null).'"');
									}
								?>
							</li>
							<li class="nav-item">	
								
								<?php
									if($accessmenu['toolsholidays']['isaccess']!='F')
									{
										echo anchor('tools/holidays','<i class="far fa-calendar-check mr-1"></i> <p>Holidays</p>','class="nav-link '.($submenu=='holidays' ? 'active' : null).'"');
									}
								?>
							</li>	
							<li class="nav-item">
								<?php
									if($accessmenu['toolsroles']['isaccess']!='F')
									{
										echo anchor('tools/roles','<i class="fas fa-tags"></i> <p>Roles</p>','class="nav-link '.($submenu=='roles' ? 'active' : null).'"');
									}
								?>
							</li>	
							<li class="nav-item">	
								<?php
									if($accessmenu['toolsuseracounts']['isaccess']!='F')
									{
										echo anchor('tools/useraccounts',' <i class="fas fa-users"></i> <p>User Accounts</p>','class="nav-link '.($submenu=='useraccounts' ? 'active' : null).'"');
									}
								?>
							</li>	
							<li class="nav-item">
								<?php 
									echo anchor('site/backup',' <i class="fas fa-file-download"></i> <p>Backup</p>','class="nav-link"');
								?>
							</li>	
							
						</ul>
					</li>
			<?php
				}
			
			?>	
			
			<li class="nav-item">
				<?php
					echo anchor('app/changepassword','<i class="fas fa-key"></i> <p>Change Password</p>','class="nav-link '.($mainmenu=='changepassword' ? 'active' : null).'"');
				?>
			</li>	
			

        </ul>
		</nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <div class="content-wrapper">
