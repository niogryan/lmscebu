<?php
	$attributes = array('name' => 'addcustomer','id'=>'form1','enctype'=>'multipart/form-data');
	echo form_open('customer/add/',$attributes);
?>

	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Customer</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	<section class="content">
		<div class="container-fluid">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">
						&nbsp;
					</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-12  col-md-3 col-lg-3 text-center">
							
							<?php
								echo '<img src="'.$this->config->item('base_url').'resources/images/nophotoavailable.jpg" alt="Not Available" class="img-responsive img-rounded"/>';
							?>
							
							<div class="form-group">							
								
								<br />
								<div class="input-group">
									<input type="file" name="uploadimage" id="uploadimage" class="form-control btn btn-default" accept="image/*">
								</div>
								<p class="help-block">Maximum size is 2MB</p>
							</div>
						</div>	
						<div class="col-sm-12  col-md-9 col-lg-9">	
							
							
							<div class="row">
								<div class="col-sm-12  col-md-6 col-lg-6">
									<div class="form-group">
										<label>Branch <code>*</code></label>
										<select name="branch" id="branchselection" class="form-control required">
											<option value="">Select an Option</option>
											<?php
												foreach($branches as $row)
												{
													echo '<option value="'.$row['branchid'].'" '.($this->session->userdata('selectedbranch')==$row['branchid'] ? 'selected' : null).'>'.$row['branchname'].'</option>';
												}
											?>
										</select>
									</div>
									
								</div>
								<div class="col-sm-12  col-md-6 col-lg-6">
									<div class="form-group">
										<label>Area <code>*</code></label>
										
										<select name="area" id="areaselection" class="form-control required">
											<option value="">Select an Option</option>
											<?php
												if ($areas)
												{
													foreach($areas as $row)
													{
														echo '<option value="'.$row['branchareaid'].'">'.$row['areaname'].'</option>';
													}
												}
											?>
										</select>	
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label for="firstname">First name <code>*</code></label>
										<input type="text" class="form-control  required" name="firstname" autocomplete="off" />
									</div>
								</div>
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label for="middlename">Middle name </label>
										<input type="text" class="form-control" name="middlename"  autocomplete="off" />
									</div>
								</div>
								
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label for="lastname">Last name <code>*</code></label>
										<input type="text" class="form-control  required" name="lastname"  autocomplete="off" />
									</div>
								</div>
								
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label for="suffix">Suffix </label>
										<select name="suffix" class="form-control">
											<option value="">Select an Option</option>
											<option value="Jr.">Jr.</option>
											<option value="Sr.">Sr.</option>
											<option value="I">I</option>
											<option value="II">II</option>
											<option value="III">III</option>
											<option value="IV">IV</option>
											<option value="V">V</option>
											<option value="VI">VI</option>
											<option value="VII">VII</option>
											<option value="VIII">VIII</option>
											<option value="IX">IX</option>
											<option value="X">X</option>
										<select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label>Birthday  <code>*</code></label>
										<input type="text" name="birthday" class="form-control required datefield" autocomplete="off"  />
									
									</div>
								</div>
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label>Birth Place  <code>*</code></label>
										<input type="text" name="birthplace" class="form-control required " autocomplete="off"  />
									
									</div>
								</div>
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label for="birthday">Gender <code>*</code></label>
										<select name="gender" class="form-control required">
											<option value="">Select an Option</option>
											<option value="Male">Male</option>
											<option value="Female">Female</option>
										<select>
									</div>
								</div>
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label for="birthday">Marital Status <code>*</code></label>
										<select name="maritalstatus" class="form-control required">
											<option value="">Select an Option</option>
											<option value="Single">Single</option>
											<option value="Married">Married</option>
											<option value="Divorced">Divorced</option>
											<option value="Widowed">Widowed</option>
										<select>
									</div>
								</div>
								
							</div>
							<div class="row">
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label for="cellphonenumber">Cellphone Number <code>*</code></label>
										<input type="text" class="form-control  required" name="cellphonenumber" autocomplete="off" />
										<small class="text-muted">Type N/A if not applicable</small>
									</div>
									
								</div>
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label for="telephonenumber">Telephone Number <code>*</code></label>
										<input type="text" class="form-control  required" name="telephonenumber" autocomplete="off" />
										<small class="text-muted">Type N/A if not applicable</small>
									</div>
								</div>
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label for="emailaddress">Email Address <code>*</code></label>
										<input type="text" class="form-control required" name="emailaddress" autocomplete="off" />
										<small class="text-muted">Type N/A if not applicable</small>
									</div>
								</div>
								<div class="col col-sm-12 col-md-12 col-lg-12">
									<div class="form-group">
										<label for="address">Complete Address <code>*</code></label>
										<textarea name="address" class="form-control required" rows="5" autocomplete="off"></textarea>
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label for="employmentstatus">Employment Status <code>*</code></label>
										<input type="text" class="form-control required" name="employmentstatus" autocomplete="off" />
										<small class="text-muted">Type N/A if not applicable</small>
									</div>
								</div>
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label for="tinnumber">TIN Number <code>*</code></label>
										<input type="text" class="form-control required" name="tinnumber" autocomplete="off" />
										<small class="text-muted">Type N/A if not applicable</small>
									</div>
								</div>
								<div class="col col-sm-12 col-md-12 col-lg-12">
									<div class="form-group">
										<label for="address">Remarks</label>
										<textarea name="remarks" class="form-control" rows="5" autocomplete="off"></textarea>
									</div>
								</div>
							</div>	
						</div>
					</div>		
						

				
				</div>
				<div class="card-footer">
					<h3 class="card-title float-right">
						<?php	
							echo form_submit('btnSave', 'Save',  'id="formvalidateadd" class="btn btn-success pull-right"');
						?>
					</h3>
				</div>
            </div>  
        </div>	
	</section>
	
		<?php 	
		echo form_close();
	?>