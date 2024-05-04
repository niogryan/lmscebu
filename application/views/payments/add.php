<?php
	$attributes = array('name' => 'frmpayments','id'=>'frmpayments');
	echo form_open('payment/add/',$attributes);
?>
	
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Payment</h1>
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
										<select name="branch" id="paymentbranchselection" class="form-control required">
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
										
										<select name="area" id="paymentareaselection" class="form-control required">
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
										<label>Customer Loan<code>*</code></label>
										<select name="customerloan" id="paymentcustomerselection" class="form-control select2"  style="width:100%;">
											<option value="">Select an Option</option>
											<?php
												foreach($customerloans as $row)
												{
													echo '<option value="'.$row['loanid'].'" '.($selectedloan==$row['loanid'] ? 'selected' : null).'>'.$row['referencenumber'].' '.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname']).'</option>';
												}
											?>
										</select>	
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer pull-right">
							<?php echo form_submit('btnView','View','class="btn btn-primary float-right" style="width:20%;"');?>
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
										Add Payment
									</h3>
								</div>
								<div class="card-body">
									
									
									<?php
										
										if ($userdetails[0]['dateaccess']==5)
										{
									?>
											<div class="form-group">
												<label>Date <code>*</code></label>
													<input type="text" name="paymentdate" class="form-control required paymentdatecustom5" autocomplete="off"/>
											</div>
											
											
									<?php
										}
										else if ($userdetails[0]['dateaccess']==4)
										{
									?>
											<div class="form-group">
												<label>Date <code>*</code></label>
													<input type="text" name="paymentdate" class="form-control required paymentdatecustom4" autocomplete="off"/>
											</div>
									<?php
										}
										else if ($userdetails[0]['dateaccess']==3)
										{
									?>
									
											<div class="form-group">
												<label>Date <code>*</code></label>
													<input type="text" name="paymentdate" class="form-control required paymentdatecustom1" autocomplete="off"/>
											</div>
									<?php
										}
										else if ($userdetails[0]['dateaccess']==2)
										{
									?>
											
											<div class="form-group">
												<label>Date <code>*</code></label>
													<input type="text" name="paymentdate" class="form-control required paymentdatecustom2" autocomplete="off"/>
											</div>
									
									
									<?php
										}
										else if ($userdetails[0]['dateaccess']==1)
										{
									?>
											<div class="form-group">
												<label>Date <code>*</code></label>
												<input type="text" name="paymentdate" id="paymentdate"  class="form-control required" autocomplete="off" value="<?php echo date("Y-m-d"); ?>" readonly="readonly"/>
											</div>
									<?php
										}
									?>
									
									
									<div class="form-group">
										<label for="firstname">Amount <code>*</code></label>
										<input type="number" class="form-control required" name="paymentamount" autocomplete="off" style="text-align:right;"/>
										<div style="text-align:right; padding-right:5px;"><b  id="formattedprincipal">Php 0.00</b></div>
									</div>
									<div class="form-group">
										<label>Type <code>*</code></label>
										<select name="paymenttype" class="form-control required">
											<option value="Regular" selected>Regular</option>
										</select>
									</div>
									
									<div class="form-group">
										<label>Remarks </label>
										<textarea name="remarks" id="remarks"  class="form-control" autocomplete="off"></textarea>
									</div>
								</div>
								<div class="card-footer">
									<?php 
										if ($accessmenu['paymentadd']['isadd']=='T')			
										{
											echo form_submit('btnSave','Save Payment','class="btn btn-success buttonclickpayment float-right"');
										}	
									?>
								</div>
									
							</div>	
						</div>
						<div class="col-sm-12 col-md-8 col-lg-8">
							<div class="card card-primary card-outline">
								<div class="card-header">
									<h2 class="card-title text-primary text-bold">
										<?php echo $loandetails[0]['referencenumber']; ?>: <?php echo trim($selectedprofile[0]['firstname'].' '.$selectedprofile[0]['middlename'].' '.$selectedprofile[0]['lastname'].' '.$selectedprofile[0]['suffix']); ?>
									</h2>
									<div class="card-tools">
									  <h4>Balance: <span class="<?php echo ($loandetails[0]['balance']>0 ? 'text-danger' : 'text-success');?> text-bold"> Php <?php echo  number_format($loandetails[0]['balance'], 2, '.', ','); ?></span></h4>
									</div>
								</div>
								<div class="card-body">
									<input type="hidden" name="hid" value="<?php echo trim($loandetails[0]['loanid']); ?>" />
									<div class="row">
										
										<div class="col-sm-12  col-md-4 col-lg-4">
											<dl>
											  <dt>Customer Reference Number</dt>
											  <dd><?php echo $selectedprofile[0]['refnumber']; ?></dd>
											</dl> 
										</div>	  
										<div class="col-sm-12  col-md-4 col-lg-4">
											 <dl> 
												<dt>Customer Previous Reference Number</dt>
												<dd><?php echo $selectedprofile[0]['oldrefnumber']; ?></dd>
											</dl>
										</div>
									</div>	
									<hr />
									<div class="row">	
										<div class="col-sm-6  col-md-4 col-lg-4">
											<dl>
											  <dt>Branch</dt>
											  <dd><?php echo $loandetails[0]['branchname']; ?></dd>
											  <dt>Area</dt>
											  <dd><?php echo $loandetails[0]['areaname']; ?></dd>
											</dl>
										</div>
										<div class="col-sm-6  col-md-4 col-lg-4">
											<dl>
											  <dt>Date Released</dt>
											  <dd><?php echo date("F j, Y", strtotime($loandetails[0]['releaseddate'])); ?></dd>
											  <dt>Due Date</dt>
											  <dd><?php echo date("F j, Y", strtotime($loandetails[0]['duedate'])); ?></dd>
											 
											</dl>									
										</div>
										<div class="col-sm-6  col-md-4 col-lg-4">
											<dl>
												<dt>Principal + Interest</dt>
												<dd>Php <?php echo  number_format($loandetails[0]['amountreleased']+$loandetails[0]['interest'], 2, '.', ','); ?></dd>
												<dt>Principal Amount</dt>
												<dd>Php <?php echo  number_format($loandetails[0]['amountreleased'], 2, '.', ','); ?></dd>
												<dt>Interest</dt>
												<dd>Php <?php echo  number_format($loandetails[0]['interest'], 2, '.', ','); ?></dd>
												<dt>Daily Dues</dt>
												<dd class="text-danger text-bold">Php <?php echo  number_format($loandetails[0]['dailyduesamount'], 2, '.', ','); ?></dd>
												
											</dl>									
										</div>
									</div>
								</div>	
								<div class="card-footer">
									<h4 class="float-right">
											Total Amount Paid: <span class="text-success text-bold"> Php <?php echo  number_format($totalpayments[0]['amount'], 2, '.', ','); ?></span>
									</h4>
								</div>	
							</div>	
						</div> 
						
						
						<div class="col-sm-12 col-md-12 col-lg-12">
							<div class="card card-primary card-outline">
								<div class="card-header">
									<h3 class="card-title">
										Payment Details
									</h3>
									<div class="card-tools">
										<?php
											if ($accessmenu['loanindex']['isedit']=='T')
											{
												echo anchor('loan/details/'.$loandetails[0]['loanid'].'/'.$this->mylibraries->encrypt('v'.$loandetails[0]['loanid']),'Edit Payments','class="btn btn-primary btn-sm" target="_BLANK"');
												
											}	
										?>
									</div>
									
								
								</div>
								
								
								
								<div class="card-body">
									
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
											</tr>
											
										</thead>
										<tbody>
											<?php
												$balance=0;
												$totalpayment=0;
												if($payments)
												{
													$balance=$loandetails[0]['principalamount']+$loandetails[0]['interest'];
													
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
									
														echo '</tr>';
														$totalpayment += $row['paymentamount'];
													}
												}
											?>
											<tr>
												<th  style="text-align:right;"colspan="5">Total Amount Paid</th>
												<th  style="text-align:right;"><?php echo 'Php '.number_format(($totalpayment), 2, '.', ','); ?></th>
												<th  style="text-align:right;">Balance: <?php echo 'Php '.number_format(($balance), 2, '.', ','); ?></th>
											</tr>
											
										</tbody>
									</table>
									
									
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
	