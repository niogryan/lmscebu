<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta content="noindex, nofollow" name="robots">
<meta content="CEBUCYBERBOB LMS" name="Description" />
<meta content="CEBUCYBERBOB LMS" name="abstract" />
<meta content="CEBUCYBERBOB" name="author" />
<meta content="CEBUCYBERBOB" name="copyright" />
<meta content="Business" name="category" />
<meta content="" name="timestamp" />
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>LMS</title>
<link href="https://cdn.pup.edu.ph/img/ico/favicon.ico" rel="icon" type="image/x-icon" />
<link href="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/dist/css/adminlte.min.css" rel="stylesheet" />
<link href="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/dist/css/si.css" rel="stylesheet" />
<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" />
<script src="https://kit.fontawesome.com/044ae73695.js" crossorigin="anonymous"></script>
<style>
.bgslide {
    min-height: 100vh;
    background: #888 url(<?php echo $this->config->item('base_url').'resources/images/bg.jpg'; ?>);
	background-repeat: no-repeat;
	background-attachment: fixed;
	background-size: 100% 100%;
    transition: background 0.3s;
}

.content-wrapper
{
    margin-left: 0px !important;
}

</style>
</head>

<body class="sidebar-collapse fixed">

<div class="wrapper">

	<div class="content-wrapper">
		<div class="bgslide">
			<div class="col-md-4 card frost">
				<div class="toplayer login-card-body">
					<div class="box-header with-border">
						<br /><br /><br /><br /><br /><br />
						<h1 class="box-title text-center "><b>Lending Management System <b></h1>
						<h2 class="box-title text-center ">Cebu Offices </h2>

					</div>
					<div class="box-body login-box-msg">
						<section id="introduction">
							<p>Sign in to start your session</p>
							<?php 				
								if($this->session->userdata('alert'))
								{
							?>
									<p class="text-danger" style="text-align:center;"><i>Your email address or password is incorrect</i></p>
							<?php 
									 $this->session->unset_userdata('alert');
								}							
							?>
						</section>
						<?php
							$attributes = array('name' => 'form1','class='=>'form-horizontal');
							echo form_open('site/authentication', $attributes);	
						?>
						<form id="form1" action="portal.signintemplate.html" class="form-horizontal" method="post">
							<div class="input-group mb-3">
								<input type="email" name="email" class="form-control" placeholder="jdelacruz@yahoo.com" autocomplete="off">
								<input type="hidden" name="hidloc" class="form-control" >
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-user"></span></div>
								</div>
							</div>
							<div class="input-group mb-3">
								<input type="password" name="password"  class="form-control" placeholder="password" autocomplete="off">
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-lock"></span></div>
								</div>
							</div>

							<div class="row">
								<div class="col-12">
									<?php
										echo form_submit('btnSignIn','Sign In','class="btn btn-primary btn-block btn-flat"');
									?>

								</div>
							</div>
							
						</form>

						<p class="mt-3 text-primary">Version <?php echo $this->session->userdata('Version');?></span></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/dist/js/adminlte.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
	$.getJSON("https://api.ipify.org/?format=json", function(e) 
	{
		$('input[name=hidloc]').val(e.ip);
	});
</script>
</body>

</html>
