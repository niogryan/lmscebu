<?php
	$attributes = array('name' => 'editcustomer','id'=>'editcustomer','enctype'=>'multipart/form-data');
	echo form_open('customer/edit/'.$param1.'/'.$param2,$attributes);
?>

	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Profile</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	<section class="content">
		<div class="container-fluid">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">
						<?php echo '<span style="font-size:20pt; font-weight:bold;">Reference Number: '.$profile[0]['refnumber'].'</span>'; ?>
					</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-12  col-md-3 col-lg-3 text-center">
							
							<?php
								if(!empty($image))
								{
									echo '<img src="data:image/png;base64,'.$image.'" alt="Image Picture"  class="img-responsive profile-user-img"/>';
								}
								else
								{
										echo '<img src="'.$this->config->item('base_url').'resources/images/nophotoavailable.jpg" alt="Not Available" class="img-responsive img-rounded"/>';
								}
							
							?>
							
							<?php
								//if($accessmenu['borrowerlist']['isedit']=='T')
								//{
							?>
							<div class="form-group">							
								
								<br />
								<div class="input-group">
									<input type="file" name="uploadimage" id="uploadimage" class="form-control btn btn-default" accept="image/*">
									<span class="input-group-btn">
									  <?php 
											echo form_submit('btnUpload','Upload','class="btn btn-primary buttonclick"');
										?>
									</span>	
								</div>
								<p class="help-block">Maximum size is 2MB</p>
							</div>
							<?php
								//}
							?>
						</div>
						<div class="col-sm-12  col-md-9 col-lg-9">
							
							<div class="row">
								<div class="col-sm-12  col-md-12 col-lg-12">
									<div class="form-group">
										<label>Branch Areas <code>*</code></label>
										<select name="branch" class="form-control required">
											<option value="">Select an Option</option>
											<?php
												foreach($branchesareas as $row)
												{
													echo '<option value="'.$row['branchareaid'].'" '.($profile[0]['branchareaid']==$row['branchareaid'] ? 'selected' : null).'>['.$row['branchname'].'] '.$row['areacity'].' - '.$row['areaname'].'</option>';
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
										<input type="text" class="form-control  required" name="firstname" autocomplete="off" value="<?php echo trim($profile[0]['firstname']); ?>" >
									</div>
								</div>
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label for="middlename">Middle name </label>
										<input type="text" class="form-control" name="middlename" autocomplete="off" value="<?php echo trim($profile[0]['middlename']); ?>">
									</div>
								</div>
								
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label for="lastname">Last name <code>*</code></label>
										<input type="text" class="form-control  required" name="lastname" autocomplete="off" value="<?php echo trim($profile[0]['lastname']); ?>">
									</div>
								</div>
								
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label for="suffix">Suffix </label>
										<select name="suffix" class="form-control">
											<option value="">Select an Option</option>
											<option value="Jr." <?php echo (trim($profile[0]['suffix'])=='Jr.' ? 'selected' : null); ?>>Jr.</option>
											<option value="Sr." <?php echo (trim($profile[0]['suffix'])=='Sr.' ? 'selected' : null); ?>>Sr.</option>
											<option value="I" <?php echo (trim($profile[0]['suffix'])=='I' ? 'selected' : null); ?>>I</option>
											<option value="II" <?php echo (trim($profile[0]['suffix'])=='II' ? 'selected' : null); ?>>II</option>
											<option value="III" <?php echo (trim($profile[0]['suffix'])=='III' ? 'selected' : null); ?>>III</option>
											<option value="IV" <?php echo (trim($profile[0]['suffix'])=='IV' ? 'selected' : null); ?>>IV</option>
											<option value="V" <?php echo (trim($profile[0]['suffix'])=='V' ? 'selected' : null); ?>>V</option>
											<option value="VI" <?php echo (trim($profile[0]['suffix'])=='VI' ? 'selected' : null); ?>>VI</option>
											<option value="VII" <?php echo (trim($profile[0]['suffix'])=='VII' ? 'selected' : null); ?>>VII</option>
											<option value="VIII" <?php echo (trim($profile[0]['suffix'])=='VIII' ? 'selected' : null); ?>>VIII</option>
											<option value="IX" <?php echo (trim($profile[0]['suffix'])=='IX' ? 'selected' : null); ?>>IX</option>
											<option value="X" <?php echo (trim($profile[0]['suffix'])=='X' ? 'selected' : null); ?>>X</option>
										<select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label>Birthday  <code>*</code></label>
										<input type="text" name="birthday" class="form-control required datefield" autocomplete="off"  value="<?php echo trim($profile[0]['bday']); ?>">
									
									</div>
								</div>
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label>Birth Place  <code>*</code></label>
										<input type="text" name="birthplace" class="form-control required " autocomplete="off"  value="<?php echo trim($profile[0]['birthplace']); ?>">
									
									</div>
								</div>
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label for="birthday">Gender <code>*</code></label>
										<select name="gender" class="form-control required">
											<option value="">Select an Option</option>
											<option value="Male" <?php echo (trim($profile[0]['gender'])=='Male' ? 'selected' : null); ?>>Male</option>
											<option value="Female" <?php echo (trim($profile[0]['gender'])=='Female' ? 'selected' : null); ?>>Female</option>
										<select>
									</div>
								</div>
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label for="birthday">Marital Status <code>*</code></label>
										<select name="maritalstatus" class="form-control required">
											<option value="">Select an Option</option>
											<option value="Single" 	<?php echo (trim($profile[0]['maritalstatus'])=='Single' ? 'selected' : null); ?>>Single</option>
											<option value="Married" <?php echo (trim($profile[0]['maritalstatus'])=='Married' ? 'selected' : null); ?>>Married</option>
											<option value="Divorced"<?php echo (trim($profile[0]['maritalstatus'])=='Divorced' ? 'selected' : null); ?>>Divorced</option>
											<option value="Widowed" <?php echo (trim($profile[0]['maritalstatus'])=='Widowed' ? 'selected' : null); ?>>Widowed</option>
										<select>
									</div>
								</div>
								
							</div>
							<div class="row">
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label for="cellphonenumber">Cellphone Number <code>*</code></label>
										<input type="text" class="form-control  required" name="cellphonenumber" autocomplete="off" value="<?php echo trim($profile[0]['cellphonenumber']); ?>">
										<small class="text-muted">Type N/A if not applicable</small>
									</div>
									
								</div>
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label for="telephonenumber">Telephone Number <code>*</code></label>
										<input type="text" class="form-control  required" name="telephonenumber" autocomplete="off" value="<?php echo trim($profile[0]['telephonenumber']); ?>">
										<small class="text-muted">Type N/A if not applicable</small>
									</div>
								</div>
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label for="emailaddress">Email Address <code>*</code></label>
										<input type="text" class="form-control required" name="emailaddress" autocomplete="off" value="<?php echo trim($profile[0]['emailaddress']); ?>">
										<small class="text-muted">Type N/A if not applicable</small>
									</div>
								</div>
								<div class="col col-sm-12 col-md-12 col-lg-12">
									<div class="form-group">
										<label for="address">Complete Address <code>*</code></label>
										<textarea name="address" class="form-control required" rows="5" autocomplete="off"><?php echo trim($profile[0]['address']); ?></textarea>
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label for="employmentstatus">Employment Status <code>*</code></label>
										<input type="text" class="form-control required" name="employmentstatus" autocomplete="off" value="<?php echo trim($profile[0]['employmentstatus']); ?>">
										<small class="text-muted">Type N/A if not applicable</small>
									</div>
								</div>
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">
										<label for="tinnumber">TIN Number <code>*</code></label>
										<input type="text" class="form-control required" name="tinnumber" autocomplete="off" value="<?php echo trim($profile[0]['tinnumber']); ?>">
										<small class="text-muted">Type N/A if not applicable</small>
									</div>
								</div>
								<div class="col col-sm-12 col-md-12 col-lg-12">
									<div class="form-group">
										<label for="address">Remarks</label>
										<textarea name="remarks" class="form-control" rows="5" autocomplete="off"><?php echo trim($profile[0]['remarks']); ?></textarea>
									</div>
								</div>
							</div>	
						</div>
					</div>

					<div class="row">
						<div class="col col-md-12 col-lg-12">
						
						</div>		
					</div>
				
				</div>
				<div class="card-footer">
					<h3 class="card-title float-right">
						<?php	
							echo anchor('customer/profile/'.$param1.'/'.$this->mylibraries->encrypt('v'.$param1),'Back','class="btn btn-primary mr-1"');
							echo form_submit('btnSave', 'Save', 'class="btn btn-success pull-right formvalidate"');
							
						?>
					</h3>
				</div>
            </div>  
        </div>	
	</section>
	
		<?php 	
		echo form_close();
	?>