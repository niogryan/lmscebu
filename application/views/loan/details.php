<?php
/*
2021-08-16 instructed by bob
delete loan
	from date of released loan to 3 days allowed to delete
delete payments
	from allowed two days to delete to 3 days allowed to delete
2022-04-13 instructed by bob
add 5 and 10 days selection in date

*/
	
	$attributes = array('name' => 'details','id'=>'details');
	echo form_open('loan/details/'.$param1.'/'.$param2,$attributes);
	$amountloan=$loandetails[0]['principalamount']+$loandetails[0]['interest'];
	$nowdate = new DateTime();
?>
	
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Loan Reference Number: <?php echo $loandetails[0]['referencenumber']; ?></h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12 col-md-9 col-lg-9">
					<div class="card card-primary card-outline">
						<div class="card-header">
							<h3 class="card-title">
								Loan Details
							</h3>
							<div class="card-tools">
							  <h4>Balance: <span class="<?php echo ($loandetails[0]['balance']>0 ? 'text-danger' : 'text-success');?> text-bold"> Php <?php echo  number_format($loandetails[0]['balance'], 2, '.', ','); ?></span></h4>
							</div>
						</div>
						<div class="card-body">
							
							<div class="row">
								<div class="col-sm-6  col-md-3 col-lg-3">
									<dl>
									  <dt>Branch</dt>
									  <dd><?php echo $loandetails[0]['branchname']; ?></dd>
									  <dt>Area</dt>
									  <dd><?php echo $loandetails[0]['areaname']; ?></dd>
									</dl>
								</div>
								<div class="col-sm-6  col-md-3 col-lg-3">
									<dl>
									  <dt>Date Released</dt>
									  <dd><?php echo date("F j, Y", strtotime($loandetails[0]['releaseddate'])); ?></dd>
									  <dt>Due Date</dt>
									  <dd><?php echo date("F j, Y", strtotime($loandetails[0]['duedate'])); ?></dd>
									  <dt>Principal Amount</dt>
										<dd>Php <?php echo  number_format($loandetails[0]['principalamount'], 2, '.', ','); ?></dd>
										<dt>Interest</dt>
										<dd>Php <?php echo  number_format($loandetails[0]['interest'], 2, '.', ','); ?></dd>
										<dt>Daily Dues</dt>
										<dd class="text-danger text-bold">Php <?php echo  number_format($loandetails[0]['dailyduesamount'], 2, '.', ','); ?></dd>
									</dl>									
								</div>
							
								<div class="col-sm-6  col-md-3 col-lg-3">
									<dl>
										<dt>Service Charge</dt>
										<dd>Php <?php echo  number_format($loandetails[0]['servicecharge'], 2, '.', ','); ?></dd>
										<dt>Number of Holiday(s)</dt>
										<dd><?php echo $loandetails[0]['numholidays']; ?></dd>
										<dt>Special Payments </dt>
										<dd>Php <?php echo  number_format($loandetails[0]['specialpayment'], 2, '.', ','); ?></dd>
										<dt>Passbook Charge </dt>
										<dd>Php <?php echo  number_format($loandetails[0]['passbookcharge'], 2, '.', ','); ?></dd>
										<dt>Advance Payment </dt>
										<dd>Php <?php echo  number_format($loandetails[0]['advancepayment'], 2, '.', ','); ?></dd>
									</dl>									
								</div>
								<div class="col-sm-6  col-md-3 col-lg-3">
									<dl>
										<dt>Principal Amount + Interest</dt>
										<dd>Php <?php echo  number_format($amountloan, 2, '.', ','); ?></dd>
										<dt>Total Amount Release</dt>
										<dd>Php <?php echo  number_format($loandetails[0]['amountreleased'], 2, '.', ','); ?></dd>
										<dt>Total Amount Paid</dt>
										<dd>Php <?php echo  number_format($totalpayments[0]['amount'], 2, '.', ','); ?></dd>
										<dt>Remarks</dt>
										<dd><?php echo $loandetails[0]['remarks']; ?></dd>
									</dl>									
								</div>
							</div>
						</div>	
						<div class="card-footer">

							<?php
								
								
								$date = new DateTime($loandetails[0]['releaseddate']);
								IF ($userdetails[0]['role']=='Administrator')
								{
									if(empty($payments))
									{
										echo form_submit('btnDelete','Delete Loan','class="btn btn-danger float-right buttonclick"');
										//echo anchor('loan/edit/'.$param1.'/'.$param2,'Edit Loan','class="btn btn-primary float-right buttonclick mr-1"');
									}
								}
								else if ($date->diff($nowdate)->format("%a")<=3 && $accessmenu['loanindex']['isdelete']=='T')			
								{
									if(empty($payments))
									{
										echo form_submit('btnDelete','Delete Loan','class="btn btn-danger float-right buttonclick"');
										//echo anchor('loan/edit/'.$param1.'/'.$param2,'Edit Loan','class="btn btn-primary float-right buttonclick mr-1"');
									}
								}
							?>
						</div>	
					</div>	
					
					<div class="card card-primary card-outline">
						<div class="card-header">
							<h3 class="card-title">
								Payment Details
							</h3>
							<div class="card-tools">
							  <?php
								if ($accessmenu['loanindex']['isadd']=='T')			
								{
									echo '<a href="#Add" class="btn btn-primary" data-toggle="modal">Add Payment</a>';
								}
							?>
							</div>
						</div>
						<div class="card-body">
							<h3>Total Amount Paid: Php <?php echo number_format($totalpayments[0]['amount'], 2, '.', ',');?></h3>
							<table class="table table-bordered">
								<thead>
									<tr>
										<th style="text-align:center;">Payment Date</th>
										<th style="text-align:center;">OR Number</th>
										<th style="text-align:center;">Type</th>
										<th style="text-align:center;">Remarks</th>
										<th style="text-align:center;">Entry By</th>
										<th style="text-align:center;">Paid Amount</th>
										<th style="text-align:center;">Balance</th>
										<th style="text-align:center;"></th>
									</tr>
									
								</thead>
								<tbody>
									<?php
									
										$balance=$amountloan;
										if($payments)
										{
											$totalpayments=0;
											foreach($payments as $row)
											{
												echo '<tr>';
												echo '<td style="text-align:center;">'.date("F j, Y", strtotime($row['paymentdate'])).'</td>';
												echo '<td style="text-align:center;">'.$row['ornumber'].'</td>';
												echo '<td style="text-align:center;">'.$row['paymenttype'].'</td>';
												echo '<td>'.$row['paymentremarks'].'</td>';
												echo '<td style="text-align:center;">'.$row['addedby'].'<br /> '.$row['entrydate'].'</td>';
												echo '<td style="text-align:right;">Php '.number_format($row['paymentamount'], 2, '.', ',').'</td>';
												$balance -=$row['paymentamount'];
												
												echo '<td style="text-align:right;">Php '.number_format(($balance), 2, '.', ',').'</td>';
												echo '<td style="text-align:center;">';
												
												$date = new DateTime($row['entrydate']);
												
											
												IF ($userdetails[0]['role']=='Administrator')
												{
													echo anchor('loan/details/d/'.$row['loanpaymentid'].'/'.$param1.'/'.$this->mylibraries->encrypt('d'.$row['loanpaymentid'].$param1),'Delete' ,'class="btn btn-sm btn-danger buttonclick mb-1 mr-1"');
													echo '<a href="#Edit" data-id="'.$row['loanpaymentid'].'" data-toggle="modal" class="btn btn-primary btn-sm  mb-1 mr-1 btnedit">Edit</a>';
												}
												ELSE
												{
													if ($accessmenu['loanindex']['isdelete']=='T')
													{
														if($date->diff($nowdate)->format("%a")<=3)
														{
															echo anchor('loan/details/d/'.$row['loanpaymentid'].'/'.$param1.'/'.$this->mylibraries->encrypt('d'.$row['loanpaymentid'].$param1),'Delete' ,'class="btn btn-sm btn-danger buttonclick mb-1 mr-1"');
														}
													}
													
													if ($accessmenu['loanindex']['isedit']=='T')
													{
														if($date->diff($nowdate)->format("%a")<=3)
														{	
															echo '<a href="#Edit" data-id="'.$row['loanpaymentid'].'" data-toggle="modal" class="btn btn-primary btn-sm  mb-1 mr-1 btnedit">Edit</a>';
														}
													}
												}

												echo '</td>';
												echo '</tr>';
											}
										}
									?>
								</tbody>
							</table>
							
							
						</div>	

					</div>	
						
				</div>  
				<div class="col-sm-12 col-md-3 col-lg-3">

				
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
	
			  
			</div>
	
        </div>	
	</section>
	
	
	<div class="modal fade" id="Add">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Payment</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="col-12">
						<div class="form-group">
							<label>Date <code>*</code></label>
							<?php	
								if ($userdetails[0]['dateaccess']==5)
								{
									echo '<input type="text" name="paymentdate" class="form-control required paymentdatecustom5" autocomplete="off"/>';
							
								}
								else if ($userdetails[0]['dateaccess']==4)
								{
									echo '<input type="text" name="paymentdate" class="form-control required paymentdatecustom4" autocomplete="off"/>';
							
								}
							
								else if ($userdetails[0]['dateaccess']==3)
								{
							
									echo '<input type="text" name="paymentdate" class="form-control paymentdatecustom1" autocomplete="off"/>';
							
								}
								else if ($userdetails[0]['dateaccess']==2)
								{
							
									echo '<input type="text" name="paymentdate" class="form-control paymentdatecustom2" autocomplete="off"/>';
							
								}
								else if ($userdetails[0]['dateaccess']==1)
								{
							
									echo '<input type="text" name="paymentdate" class="form-control" autocomplete="off" value="'.date("Y-m-d").'" readonly="readonly"/>';
							
								}
							?>
						</div>
						<div class="form-group">
							<label for="firstname">Amount <code>*</code></label>
							<input type="number" class="form-control required" name="paymentamount" autocomplete="off" min="0" step="0.01" style="text-align:right;"/>
							<div style="text-align:right; padding-right:5px;"><b  id="formattedprincipal">Php 0.00</b></div>
						</div>
						<div class="form-group">
							<label>Type <code>*</code></label>
							<select name="paymenttype" class="form-control required">
								<option value="Regular">Regular</option>
								<!--
								<option value="">Select an Option</option>
								<option value="Regular">Regular</option>
								<option value="Advance">Advance</option>
								<option value="Special">Special</option>
								-->
							</select>
						</div>
						
						<div class="form-group">
							<label>Remarks </label>
							<input type="text" name="remarks" id="remarks"  class="form-control" autocomplete="off"/>
						</div>
					</div>
				</div>		
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<?php echo form_submit('btnSave','Save','class="btn btn-success "');?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="Edit">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Payment</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="edithid"/>
					<div class="col-12">
						<div class="form-group">
							<label>Date <code>*</code></label>
							<?php
								if ($userdetails[0]['dateaccess']==5)
								{
									echo '<input type="text" name="editpaymentdateadmin" class="form-control required paymentdatecustom5" autocomplete="off"/>';
							
								}
								else if ($userdetails[0]['dateaccess']==4)
								{
									echo '<input type="text" name="editpaymentdateadmin" class="form-control required paymentdatecustom4" autocomplete="off"/>';
							
								}
								else if ($userdetails[0]['dateaccess']==3)
								{
							
									echo '<input type="text" name="editpaymentdateadmin" class="form-control required paymentdatecustom1" autocomplete="off"/>';
							
								}
								else if ($userdetails[0]['dateaccess']==2)
								{
							
									echo '<input type="text" name="editpaymentdateadmin" class="form-control required paymentdatecustom2" autocomplete="off"/>';
						
								}
								else if ($userdetails[0]['dateaccess']==1)
								{
							
									echo '<input type="text" name="editpaymentdateadmin" class="form-control required" autocomplete="off" value="'.date("Y-m-d").'" readonly="readonly"/>';
							
								}
							?>
						</div>
						<div class="form-group">
							<label for="firstname">Amount <code>*</code></label>
							<input type="number" class="form-control required" name="editpaymentamount" autocomplete="off" min="0" step="0.01" style="text-align:right;"/>
							<div style="text-align:right; padding-right:5px;"><b  id="formattedprincipal">Php 0.00</b></div>
						</div>
						<div class="form-group">
							<label>Type <code>*</code></label>
							<select name="editpaymenttype" class="form-control required">
								<option value="Regular">Regular</option>
							</select>
						</div>
						
						<div class="form-group">
							<label>Remarks </label>
							<input type="text" name="editremarks" id="editremarks"  class="form-control" autocomplete="off"/>
						</div>
					</div>
				</div>		
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<?php echo form_submit('btnUpdate','Update','class="btn btn-success"');?>
				</div>
			</div>
		</div>
	</div>
	
	<?php 	
		echo form_close();
	?>
	
