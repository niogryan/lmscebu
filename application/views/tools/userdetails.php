<?php

	$CI=& get_instance();
	$CI->load->model("tools_model");
	$attributes = array('name' => 'frmuuserdetails','id'=>'frmuserdetails');
	echo form_open('tools/userdetails/'.$param1.'/'.$param2,$attributes);
?>

    <section class="content-header">
		<h1>
			User Account Details
		</h1>
    </section>
	
    <section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-sm-12 col-md-12 col-lg-12">
					<div class="card card-primary">
						<div class="card-header with-border">
							<h3 class="card-title">&nbsp;</h3>
							<div class="card-tools">
								<?php	
									echo anchor('tools/useraccounts', 'Back', 'class="btn btn-primary mr-1"');
		
									if ($accessmenu['toolsuseracounts']['isedit']=='T')			
									{
										//echo form_submit('btnDeactivate', 'Deactivate Account', 'class="btn btn-danger buttonclick"');
										echo form_submit('btnSave', 'Save', 'id="frmvalidateuserdetails" class="btn btn-success float-right "');
									}
								?>
							</div>
						</div>
						<div class="card-body">
							<div class="row">	
								<div class="col-sm-12 col-md-4 col-lg-4">
									<div class="form-group">
										<label for="emailaddress">Email Address <code>*</code> </label>
										<input type="text" class="form-control required" name="emailaddress" placeholder="Email Address" autocomplete="off" value="<?php echo $details[0]['emailaddress']; ?>">
									</div>
								</div>
								<div class="col col-sm-12 col-md-4 col-lg-4">
									<div class="form-group">
										<label for="status">Status <code>*</code></label>
										<select name="status" class="form-control required">
											<option value="">Select an Option</option>
											<option value="T" <?php echo ($details[0]['isactive']=='T' ? 'selected' : null);?>>Active</option>
											<option value="F" <?php echo ($details[0]['isactive']=='F' ? 'selected' : null);?>>Inactive</option>
										</select>
									</div>
								</div>
								<div class="col col-sm-12 col-md-4 col-lg-4">
									<div class="form-group">
										<label for="iscollector">Role <code>*</code></label>
										<select name="role" class="form-control required">
											<option value="">Select an Option</option>
											<?php
												foreach($roles as $row)
												{
													echo '	<option value="'.$row['roleid'].'" '.($details[0]['roleid']==$row['roleid'] ? 'selected' : null).'>'.$row['role'].'</option>';
												}
											?>
										</select>
									</div>
								</div>
							</div>
							<b>Account Password: To reset the password enter a new one below   </b>
							<div class="row">
								<div class="col-sm-12 col-md-4 col-lg-4">
									<div class="form-group">
										<label>Password</label>
										<input type="password" class="form-control" name="password">
									</div>
								</div>

								<div class="col-sm-12 col-md-4 col-lg-4">
									<div class="form-group">
										<label>Confirm Password</label>
										<input type="password" class="form-control" name="confirmpassword">
									</div>
								</div>
							</div>	
							<div class="row">	
								<div class="col col-sm-12 col-md-4 col-lg-4">
									<div class="form-group">
										<label for="firstname">First Name <code>*</code> </label>
										<input type="text" class="form-control required" name="firstname" placeholder="First Name" autocomplete="off" value="<?php echo $details[0]['firstname']; ?>">
									</div>
								</div>
								<div class="col col-sm-12 col-md-4 col-lg-4">
									<div class="form-group">
										<label for="middleinitial">Middle Initial </label>
										<input type="text" class="form-control" name="middleinitial" placeholder="Middle Initial " autocomplete="off" value="<?php echo $details[0]['middleinitial']; ?>">
									</div>
								</div>
								<div class="col col-sm-12 col-md-4 col-lg-4">
									<div class="form-group">
										<label for="lastname">Last Name <code>*</code></label>
										<input type="text" class="form-control required" name="lastname" placeholder="Last Name" autocomplete="off" value="<?php echo $details[0]['lastname']; ?>">
									</div>
								</div>
							</div>	
							<div class="row">	
								<div class="col col-sm-12 col-md-4 col-lg-4">
									<div class="form-group">
										<label for="contactnumber">Mobile Number</label>
										<input type="text" class="form-control" name="mobilenumber" placeholder="Mobile" autocomplete="off" value="<?php echo $details[0]['mobilenumber']; ?>">
									</div>
								</div>
								<div class="col col-sm-12 col-md-8 col-lg-8">
									<div class="form-group">
										<label for="contactnumber">Address </label>
										<textarea name="address" class="form-control" rows="3"><?php echo $details[0]['address']; ?></textarea>
									</div>
								</div>
							</div>	
							
							<div class="row">	
								<div class="col col-sm-12 col-md-4 col-lg-4">
									<div class="form-group">
										<label for="collectiondateaccess">Collection Date Access</label>
										<select name="collectiondateaccess" class="form-control required">
											<option value="1">Default</option>
											<option value="2" <?php echo ($details[0]['dateaccess']=='2' ? 'selected' : null);?>>Two Days Prior the Current Date</option>
											<option value="4" <?php echo ($details[0]['dateaccess']=='4' ? 'selected' : null);?>>Five Days Prior the Current Date</option>
											<option value="5" <?php echo ($details[0]['dateaccess']=='5' ? 'selected' : null);?>>Ten Days Prior the Current Date</option>
											<option value="3" <?php echo ($details[0]['dateaccess']=='3' ? 'selected' : null);?>>Any Dates</option>
											
										</select>
									</div>
								</div>
								<div class="col col-sm-12 col-md-4 col-lg-4">
									<div class="form-group">
										<label for="userbranch">Branch</label>
										<select name="userbranch" class="form-control required">
											<option value="">Select an Option</option>
											<option value="0" <?php echo ($details[0]['branch']=='0' ? 'selected' : null);?>>None</option>
											<?php
												foreach($branches as $row)
												{
													
													echo '<option value="'.$row['branchid'].'" '.($details[0]['branch']==$row['branchid'] ? 'selected' : null).'>'.$row['branchname'].'</option>';
												}
											?>
											
										</select>
									</div>
								</div>
								<div class="col col-sm-12 col-md-4 col-lg-4">
									<div class="form-group">
										<label for="isstrictmachineaccess">Strict User Machine Access</label>
										<select name="isstrictmachineaccess" class="form-control required">
											<option value="">Select an Option</option>
											<option value="1" <?php echo ($details[0]['isstrictmachineaccess']=='1' ? 'selected' : null);?>>Enable</option>
											<option value="0" <?php echo ($details[0]['isstrictmachineaccess']=='0' ? 'selected' : null);?>>Disable</option>
										</select>
									</div>
								</div>
								<!--
								<div class="col col-sm-12 col-md-4 col-lg-4">
									<div class="form-group">
										<label for="collectiondateaccess">IP Address</label>
										<input type="text" class="form-control" name="ipaddress" placeholder="IP Address" autocomplete="off" value="<?php echo $details[0]['ipaddress']; ?>">
									</div>
								</div>
								-->
							</div>
						</div>
						<div class="card-footer">
							<?php	
								if ($accessmenu['toolsuseracounts']['isedit']=='T')			
								{
									//echo form_submit('btnDeactivate', 'Deactivate Account', 'class="btn btn-danger buttonclick"');
									echo form_submit('btnSave', 'Save', 'id="frmvalidateuserdetails" class="btn btn-success float-right "');
								}
							?>
						</div>
					</div>
				</div>
			</div>		
			<div class="row">	
				<div class="col col-sm-12 col-md-12 col-lg-12">	
					
					<div class="card card-primary">
						<div class="card-header with-border">
						  <h3 class="card-title">Branches Access</h3>
						  <div class="card-tools">
							<?php
								if ($accessmenu['toolsuseracounts']['isedit']=='T')			
								{
									echo form_submit('btnSaveBranch','Save','class="btn btn-success buttonclick"');
								}
							?>
						  </div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<div class="row">
								<div class="col col-md-12 col-lg-12">
									<table class="table table-bordered">
										<thead>                  
											<tr>
												<th style="text-align:center;"><input type="checkbox" name="chkall" id="chkall" class="chkbox"/></th>
												<th style="text-align:center;">Branch</th>
												<th style="text-align:center;">Address</th>
												<th style="text-align:center;">Contact Person</th>
												<th style="text-align:center;">IP Address</th>
											</tr>
										</thead>
										<tbody>
											<?php
												if ($branches)
												{
													foreach($branches as $row)
													{
														echo '<tr>';
														echo '<td style="text-align:center;"><input type="checkbox" name="branch[]" value="'.$row['branchid'].'"  class="chkbranch chkbox" '.(in_array($row['branchid'], $userbranch) ? 'checked' : null).'/></td>';
														echo '<td>'.$row['branchname'].'</td>';
														echo '<td>'.$row['branchaddress'].'</td>';
														echo '<td style="text-align:center;">'.$row['branchcontactperson'].'</td>';
														echo '<td style="text-align:center;">'.$row['ipaddress'].'</td>';
														echo '</tr>';
													}
												}
											?>
										</tbody>
									</table>
									
									
								</div>
							</div>
						</div>
					</div>
				</div>
		
			</div>			
			<div class="row">	
				<div class="col col-sm-12 col-md-12 col-lg-12">	
					
					<div class="card card-primary">
						<div class="card-header with-border">
						  <h3 class="card-title">Areas Access (<code>For Collectors Only</code>)</h3>
						  <div class="card-tools">
							<?php
								if ($accessmenu['toolsuseracounts']['isedit']=='T')			
								{
									echo form_submit('btnSaveArea','Save','class="btn btn-success buttonclick"');
								}
							?>
						  </div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<div class="row">
								<div class="col col-md-12 col-lg-12">
									<table class="table table-bordered">
										<thead>                  
											<tr>
												<th style="text-align:center;"><input type="checkbox" name="chkallareas" id="chkallareas" class="chkbox"/></th>
												<th style="text-align:center;">Branch Name</th>
												<th style="text-align:center;">Area Name</th>
											</tr>
										</thead>
										<tbody>
											<?php
												
												if ($userbranch)
												{
												
													
													foreach($userbranch as $row)
													{
														$areas=$CI->tools_model->getareasbybranch($row);
														foreach($areas as $rowarea)
														{
															echo '<tr>';
															echo '<td style="text-align:center;"><input type="checkbox" name="areas[]" value="'.$rowarea['branchareaid'].'"  class="chkarea chkbox" '.(in_array($rowarea['branchareaid'], $userareas) ? 'checked' : null).'/></td>';
															echo '<td>'.$rowarea['branchname'].'</td>';
															echo '<td>'.$rowarea['areaname'].'</td>';
															echo '</tr>';
														}
														
													}
												}
											?>
										</tbody>
									</table>
									
									
								</div>
							</div>
						</div>
					</div>
				</div>
		
			</div>	
		</div>
   </section>
	
	
<?php 	
	echo form_close();
?>

