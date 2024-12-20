<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>LMS</title>
  <link rel="stylesheet" href="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
		<a href="../../index3.html" class="navbar-brand">
			<span class="brand-text font-weight-light">Migration Tool</span>
		</a>
      
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<div class="content-header">
	  <div class="container">
		<div class="row mb-2">
		  <div class="col-sm-6">
			<h1 class="m-0 text-dark"> Match Branches and Areas</h1>
		  </div><!-- /.col -->
		</div><!-- /.row -->
	  </div><!-- /.container-fluid -->
	</div>
	<?php
		$attributes = array('name' => 'migrationtool','id'=>'migrationtool');
		echo form_open('site/migrationtool/',$attributes);
	?>
		<div class="content">
			  <div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-body">
								<table class="table table-bordered">
									<tr>
										<th>New Branch and Area</th>
										<th>Branch</th>
										<th>Areas</th>
									</tr>
									<?php
										foreach($branches as $row)
										{
											echo '<tr>';
											echo '<td>	<select name="branch'.$row['uqid'].'" class="form-control">
															<option value="">Select an Option</option>';
														foreach($branchesareas as $row2)
														{
															echo '<option value="'.$row2['branchareaid'].'" '.($row2['branchareaid']==$row['mbranchareaid'] ? 'selected' : null).'> '.$row2['branchname'].' '.$row2['areaname'].'</option>';
														}													
											echo '		</select></td>';
											echo '<td>'.$row['bname'].'</td>';
											echo '<td>'.$row['aname'].'</td>';
											echo '</tr>';
										}
									?>
								</table>
							
							</div>
							<div class="card-footer">
								<?php
									echo form_submit('btnSave','Update','class="btn btn-primary float-right"');
									echo form_submit('btnMigrate','Start Migration','class="btn btn-danger"');
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php 	
		echo form_close();
	?>
  </div>

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>

<script src="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/dist/js/adminlte.min.js"></script>
</body>
</html>
