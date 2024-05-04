 </div><!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> <?php echo $this->session->userdata('Version');?>
    </div>
        <strong>2021 <a class="aterms" href="https://www.google.com.ph/" target="_BLANK">Cyberbob</a>.</strong> All rights reserved.
 
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
  </aside>

</div>
 <?php
	$attributes = array('name' => 'frmNewDocument','id'=>'frmNewDocument');
	echo form_open('customer/addnew/',$attributes);
  ?>
		<div class="modal fade" id="NewCustomer">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Add New Customer</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="col-12">
							<div class="form-group">
								<label>First Name <code>*</code></label>
								<input type="text" name="fname" class="form-control required"/>
							</div>
							<div class="form-group">
								<label>Last Name <code>*</code></label>
								<input type="text" name="lname" class="form-control required"/>
							</div>
							<div class="form-group">
								<label>Birthday <code>*</code></label>
								<input type="text" name="bday" class="form-control required" autocomplete="off"/>
							</div>
						</div>
					</div>		
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<?php echo form_submit('btnContinue','Continue','class="btn btn-success buttonclick"');?>
					</div>
				</div>
			</div>
		</div>
	<?php 	
		echo form_close();
	?>

	<div id="processingmodal" class="modal fade">
		<div class="modal-dialog modal-m">
			<div class="modal-content">
				<div class="modal-header"><h3 style="margin:0;">Processing</h3></div>
				<div class="modal-body">
					<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>
				</div>
			</div>
		</div>
	</div>

</body>

	
	
	<script src="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/plugins/jquery/jquery.min.js"></script>
	<script src="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/plugins/toastr/toastr.min.js"></script>
	<script src="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	
	<script src="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/plugins/select2/js/select2.full.min.js"></script>
	<!--
	<script src="<?php echo $this->config->item('base_url').'resources/'; ?>datepicker/js/bootstrap-datepicker.js"></script>
	-->
	<script src="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/plugins/moment/moment.min.js"></script>
	<script src="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/plugins/daterangepicker/daterangepicker.js"></script>
	
	<script src="<?php echo $this->config->item('base_url').'vendor/almasaeed2010/adminlte'; ?>/dist/js/adminlte.min.js"></script>
	
	
	<?php
		$this->load->view('templates/script');
	?>
	

</html>