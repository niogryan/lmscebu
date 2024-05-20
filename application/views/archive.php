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
			<span class="brand-text font-weight-light">LMS</span>
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
			<h1 class="m-0 text-dark">Archiving</h1>
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
                                
                  # Loans to archive: <span id="loancount"><?php echo number_format($output['count']); ?></span><br>
                  <!--
                  # Loans archived: <span id="loancountcompleted"><?php echo number_format($output['loancountcompleted']); ?></span><br>
                  # Payments to archive: <span id="paymentcount"><?php echo number_format($output['paymemntcount']); ?></span><br>
                  # Number of CRON Jobs called: <span id="crons">0</span><br>
                  <?php
                      //$percentage = $output['loancountcompleted'] > 0 ? ($output['loancountcompleted']/$output['totalloan'])*100 : 0;
                      //$percentage = number_format($percentage, 2);
                  ?>
                    <div class="progressstatus">
                        Archiving not yet started
                    </div>
                    <b id="elapse"></b>   
                    <div class="progress">
                    <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
                    aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percentage; ?>%">
                      <?php //echo $percentage; ?>% Completed
                    </div>
                    -->
</div>                          
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
<script src="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/dist/js/adminlte.min.js"></script>
<script>
   $(document).ready(function(){
    // Call the AJAX request after 5 seconds
    setTimeout(function() {
        callAjax(); // Call the AJAX function immediately after 5 seconds
        // Then switch to calling the AJAX function every 2 minutes
        //setInterval(callAjax, 3000000); // 2 minutes in milliseconds
    }, 5000); // 5 seconds in milliseconds

    function callAjax() {
        $('.progressstatus').text('archiving started...');
        //get the value of crons then add 1
        var crons = parseInt($('#crons').text()) + 1;
        $('#crons').text(crons);

        $.ajax({
            url: "<?php echo site_url('site/archiveprocess/'); ?>",
            type: "GET",
            dataType: "JSON",
            async: true,
            success: function(data){
                //if success reload ajax table

                //when success change the value of the progress bar
                // var percentage = data['loancountcompleted'] > 0 ? (data['loancountcompleted']/data['loancount'])*100 : 0;
                // percentage = percentage.toFixed(2);
                // $('.progress-bar').css('width', percentage+'%').attr('aria-valuenow', percentage);
                // $('.progress-bar').text(percentage+'% Completed');
                $('#loancount').text(data['count']);
                // $('#paymentcount').text(data['paymentcount']);
                // $('#loancountcompleted').text(data['loancountcompleted']);
                // $('#elapse').text('Last CRON elapse time:' + data['elapsed_time']);

                setTimeout(function() {
                    location.reload();
                }, 5000); // 30 seconds in milliseconds

            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('Error archiving!');
                $('.progressstatus').text(errorThrown);
                //on error refresh the page after 30 seconds
                setTimeout(function() {
                    location.reload();
                }, 20000); // 30 seconds in milliseconds
            }
        });
    }
});

</script>
</body>
</html>
