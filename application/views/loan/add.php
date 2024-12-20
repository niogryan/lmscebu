<?php
	$attributes = array('name' => 'addloan','id'=>'form1');
	echo form_open('loan/add/',$attributes);
?>
	
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Loan</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">
								Select Customer
							</h3>
						</div>
						<div class="card-body">
							<div class="row">
									<div class="col-sm-12  col-md-4 col-lg-4">
									<div class="form-group">
										<label>Branch Areas <code>*</code></label>
										<select name="branch" id="addloanbranchselection" class="form-control required">
											<option value="">Select an Option</option>
											<?php
												foreach($branches as $row)
												{
													echo '<option value="'.$row['branchid'].'" '.($selectedbranch==$row['branchid'] ? 'selected' : null).'>'.$row['branchname'].'</option>';
												}
											?>
										</select>	
									</div>
								</div>
								<div class="col-sm-12  col-md-4 col-lg-4">
									<div class="form-group">
										<label>Area <code>*</code></label>
										
										<select name="area" id="addloanareaselection" class="form-control required">
											<option value="">Select an Option</option>
											<?php
												if ($areas)
												{
													foreach($areas as $row)
													{
														echo '<option value="'.$row['branchareaid'].'" '.($selectedarea==$row['branchareaid'] ? 'selected' : null).'>'.$row['areaname'].'</option>';
													}
												}
											?>
										</select>	
									</div>
								</div>
								<div class="col-sm-12  col-md-4 col-lg-4">
									<div class="form-group">
										<label>Customer <code>*</code></label>
										<select name="customer" id="addcustomerselection" class="form-control select2"  style="width:100%;">
											<option value="">Select an Option</option>
											<?php
												foreach($profile as $row)
												{
													echo '<option value="'.$row['customerid'].'" '.($selectedcustomer==$row['customerid'] ? 'selected' : null).'>'.$row['referencenumber'].' '.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname']).'</option>';
												}
											?>
										</select>	
									</div>
								</div>
							</div>
								
						</div>
						<div class="card-footer">
							<div class="row ">
								<div class="col-sm-12  col-md-3 col-lg-3">
									<?php echo form_submit('btnView','View','class="btn btn-primary btn-block"');?>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</div>
			
			
			<?php 
				if (!empty($selectedprofile))
				{
			?>
			<div class="row">
				<div class="col-sm-12 col-md-4 col-lg-4">

				
					<div class="card card-primary card-outline">
						<div class="card-header">
							<h3 class="card-title">
								Customer Profile
							</h3>
						</div>
					  <div class="card-body box-profile">
						
						
						
						<div class="text-center">
							<?php
								if(!empty($image))
								{
									echo '<img src="data:image/png;base64,'.$image.'" alt="Image Picture"  class="profile-user-img img-fluid img-thumbnail"/>';
								}
								else
								{
										echo '<img src="'.$this->config->item('base_url').'resources/images/nophotoavailable.jpg" alt="Not Available" class="profile-user-img img-fluid img-thumbnail"/>';
								}
							?>
						
						</div>

						<h3 class="profile-username text-center"><?php echo trim($selectedprofile[0]['firstname'].' '.$selectedprofile[0]['middlename'].' '.$selectedprofile[0]['lastname'].' '.$selectedprofile[0]['suffix']); ?></h3>
						<div class="row" style="border-bottom:1px solid #d9d9d9;">
							<input type="hidden" name="hid" value="<?php echo trim($selectedprofile[0]['customerid']); ?>" />
							<div class="col-sm-12 col-md-6 col-lg-6">
								<strong><i class="fas fa-fingerprint mr-1"></i> Reference Number</strong>
								<p class="text-primary text-bold" style="font-size:1.5em;">
								  <?php echo trim($selectedprofile[0]['refnumber']); ?>
								</p>
							</div>	
							<div class="col-sm-12 col-md-6 col-lg-6">
								<strong><i class="fas fa-fingerprint mr-1"></i>Previous Reference Number</strong>
								<p class="text-muted">
								  <?php echo $this->mylibraries->displaynaifempty($selectedprofile[0]['oldrefnumber']); ?>
								</p>
							</div>	
						</div>		

						<div class="row" style="border-bottom:1px solid #d9d9d9;">
							<div class="col-sm-12 col-md-6 col-lg-6">
								<strong><i class="far fa-calendar-alt mr-1"></i> Birthday</strong>
								<p class="text-muted">
								  <?php echo trim($selectedprofile[0]['bday']); ?>
								</p>
							</div>	
							<div class="col-sm-12 col-md-6 col-lg-6">
								<strong><i class="fas fa-map-marker-alt mr-1"></i>Birth Place</strong>
								<p class="text-muted">
								  <?php echo $this->mylibraries->displaynaifempty($selectedprofile[0]['birthplace']); ?>
								</p>
							</div>	
						</div>		
						<div class="row"  style="border-bottom:1px solid #d9d9d9;">
							<div class="col-sm-12 col-md-6 col-lg-6">
								<strong><i class="fas fa-venus-mars mr-1"></i>Gender</strong>
								<p class="text-muted">
								  <?php echo $this->mylibraries->displaynaifempty($selectedprofile[0]['gender']); ?>
								</p>
							</div>	
							<div class="col-sm-12 col-md-6 col-lg-6">
								<strong><i class="fas fa-male mr-1"></i></i> Status</strong>
								<p class="text-muted">
								  <?php echo $this->mylibraries->displaynaifempty($selectedprofile[0]['maritalstatus']); ?>
								</p>
							</div>
						</div>		
						<div class="row"  style="border-bottom:1px solid #d9d9d9;">	
							<div class="col-sm-12 col-md-12 col-lg-12">
								<strong><i class="fas fa-map-marker-alt  mr-1"></i>Address</strong>
								<p class="text-muted">
								  <?php echo $this->mylibraries->displaynaifempty($selectedprofile[0]['address']); ?>
								</p>
							</div>	
						</div>	
						<div class="row"  style="border-bottom:1px solid #d9d9d9;">
							<div class="col-sm-12 col-md-6 col-lg-6">
								<strong><i class="fas fa-phone-square-alt mr-1"></i> Telephone</strong>
								<p class="text-muted">
								  <?php echo $this->mylibraries->displaynaifempty($selectedprofile[0]['telephonenumber']); ?>
								</p>
							</div>	
							<div class="col-sm-12 col-md-6 col-lg-6">
								<strong><i class="fas fa-mobile-alt mr-1"></i>Mobile</strong>
								<p class="text-muted">
								  <?php echo $this->mylibraries->displaynaifempty($selectedprofile[0]['cellphonenumber']); ?>
								</p>
							</div>	
						</div>		
						<div class="row"  style="border-bottom:1px solid #d9d9d9;">	
							<div class="col-sm-12 col-md-6 col-lg-6">
								<strong><i class="fas fa-at"></i> Email</strong>
								<p class="text-muted">
								  <?php echo $this->mylibraries->displaynaifempty($selectedprofile[0]['emailaddress']); ?>
								</p>
							</div>
						</div>		
						
						<div class="row" style="border-bottom:1px solid #d9d9d9;">
							<div class="col-sm-12 col-md-6 col-lg-6">
								<strong><i class="fas fa-id-card mr-1"></i> Employment Status</strong>
								<p class="text-muted">
								  <?php echo $this->mylibraries->displaynaifempty($selectedprofile[0]['employmentstatus']); ?>
								</p>
							</div>	
							<div class="col-sm-12 col-md-6 col-lg-6">
								<strong><i class="fas fa-id-card mr-1"></i> TIN Number</strong>
								<p class="text-muted">
								  <?php echo $this->mylibraries->displaynaifempty($selectedprofile[0]['tinnumber']); ?>
								</p>
							</div>
						</div>
						<div class="row"  style="border-bottom:1px solid #d9d9d9;">		
							<div class="col-sm-12 col-md-6 col-lg-6">
								<strong><i class="fas fa-user mr-1"></i>Remarks</strong>
								<p class="text-muted">
								  <?php echo $this->mylibraries->displaynaifempty($selectedprofile[0]['remarks']); ?>
								</p>
							</div>	
						</div>		
					  </div>
					  
					</div>

				</div>
				<div class="col-sm-12 col-md-8 col-lg-8">
					<div class="card card-primary card-outline">
						<div class="card-header">
							<h3 class="card-title">
								Loan Details
							</h3>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12  col-md-12 col-lg-12">
									<div class="form-group">
										<label>Branch Area <code>*</code></label>
										<input type="hidden" name="hbrancharea" value="<?php echo $selectedarea; ?>" />
										<input type="hidden" name="hbranch" value="<?php echo $selectedbranch; ?>" />
										<select name="branch" class="form-control" disabled>
											<option value="">Select an Option</option>
											<?php
												foreach($branchesareas as $row)
												{
													echo '<option value="'.$row['branchareaid'].'" '.($selectedarea==$row['branchareaid'] ? 'selected' : null).'>'.$row['branchname'].' '.$row['areaname'].'</option>';
												}
											?>
										</select>
									</div>
									
								</div>
								
								
								<div class="col-sm-12  col-md-12 col-lg-12">
									<div class="row">
										<div class="col col-sm-12 col-md-6 col-lg-4">
											<div class="form-group">
												<label>Date Released <code>*</code></label>
												<input type="text" name="releasedate" id="releasedate"  class="form-control datefield required" autocomplete="off" readonly="readonly"/>
											</div>
										</div>
										<div class="col col-sm-12 col-md-6 col-lg-4">
											<div class="form-group">
												<label for="firstname">Amount <code>*</code></label>
												<input type="text" class="form-control  required" name="amount" autocomplete="off" min="0" step="0.01" style="text-align:right;"/>
												<div style="text-align:right; padding-right:5px;"><b  id="formattedprincipal">Php 0.00</b></div>
											</div>
										</div>
										
										
										
										

									</div>
									<div class="row">
										<div class="col col-sm-12 col-md-6 col-lg-4">
											<div class="form-group">
												<label for="firstname">Due Date </label>
												<input type="text" class="form-control" name="duedate" autocomplete="off" readonly="readonly"/>
											</div>
										</div>
										<div class="col col-sm-12 col-md-6 col-lg-4">
											<div class="form-group">
												<label for="firstname">Interest </label>
												<input type="text" class="form-control" name="interest" autocomplete="off" readonly="readonly"/>
											</div>
										</div>
										
										<div class="col col-sm-12 col-md-6 col-lg-4">
											<div class="form-group">
												<label for="firstname">Daily Dues </label>
												<input type="text" class="form-control" name="dailydues" autocomplete="off" readonly="readonly"/>
											</div>
										</div>
										
										<div class="col col-sm-12 col-md-6 col-lg-4">
											<div class="form-group">
												<label for="firstname">Service Charge </label>
												<input type="text" class="form-control" name="servicecharge" autocomplete="off" readonly="readonly"/>
											</div>
										</div>
									
										<div class="col col-sm-12 col-md-6 col-lg-4">
											<div class="form-group">
												<label for="firstname">Number of Holiday(s) </label>
												<input type="text" class="form-control " name="holidaycount" autocomplete="off" value="0" readonly="readonly"/>
											</div>
										</div>
										
										<div class="col col-sm-12 col-md-6 col-lg-4">
											<div class="form-group">
												<label for="firstname">Special Payments </label>
												<input type="text" class="form-control" name="specialpayment" autocomplete="off" readonly="readonly"/>
											</div>
										</div>
										
										<div class="col col-sm-12 col-md-6 col-lg-4">
											<div class="form-group">
												<label for="firstname">Passbook Charge <code>*</code></label>
												<select name="passbokcharge" class="form-control">
													<option value="0">Php 0</option>
													<option value="15">Php 15.00</option>
													<option value="20">Php 20.00</option>
												</select>
											</div>
										</div>
										<div class="col col-sm-12 col-md-6 col-lg-4">
											<div class="form-group">
												<label for="firstname">Advance Payment </label>
												<input type="text" class="form-control" name="advancepayment" autocomplete="off" min="0" step="0.01" style="text-align:right;" />
												<b id="formattedadvancepayment"></b>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col col-sm-12 col-md-6 col-lg-4">
											<div class="form-group">
												<label for="firstname">Total Amount Release </label>
												<input type="text" class="form-control" name="totalamountreleased" autocomplete="off" style="border:2px solid green" readonly="readonly"/>
											</div>
										</div>
										<div class="col col-sm-12 col-md-6 col-lg-4">
											<div class="form-group">
												<label for="firstname">Principal + Interest </label>
												<input type="text" class="form-control" name="principalinterest" autocomplete="off" style="border:2px solid green" readonly="readonly"/>
											</div>
										</div>
									</div>
									<div class="row">	
										<div class="col col-sm-12 col-md-12 col-lg-12">
											<div class="form-group">
												<label for="firstname">Remarks </label>
												<textarea name="remarks" class="form-control"></textarea>
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
							
								<?php	
									echo form_submit('btnContinue', 'Continue', 'id="formvalidate" class="btn btn-success btn-block"');
									
								?>
							
						</div>
					</div>	
            </div>  
	
			  
				</div>
			<?php 
				}
			?>
        </div>	
	</section>
	
	<?php 	
		echo form_close();
	?>
	