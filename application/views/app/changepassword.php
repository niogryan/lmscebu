<?php
	$attributes = array('name' => 'frmchangepassword','id'=>'frmchangepassword');
	echo form_open('app/changepassword/',$attributes);
?>

    <section class="content-header">
		<h1>
			Change Password
		</h1>
    </section>
	
    <section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-sm-12 col-md-3 col-lg-3">
					<div class="card card-primary">
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<div class="form-group">
										<label>Password</label>
										<input type="password" class="form-control" name="password">
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<div class="form-group">
										<label>Confirm Password</label>
										<input type="password" class="form-control" name="confirmpassword">
									</div>
								</div>
							</div>		
						</div>
						<div class="card-footer">
							<?php	

								echo form_submit('btnSave', 'Save', 'class="btn btn-success btn-block float-right"');
								
							?>
						</div>
					</div>
				</div>
			</div>		
		</div>
   </section>
	
	
<?php 	
	echo form_close();
?>
