<?php
	$CI=& get_instance();
	$CI->load->model("loan_model");
	$CI->load->model("tools_model");
	$attributes = array('name' => 'rptsummarydetails','id'=>'rptsummarydetails');
	echo form_open('rpt/summarydetails/',$attributes);
?>
	
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Summary Details</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	
	
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12 col-md-6 col-lg-8">
					<div class="card card-primary card-outline">
						<div class="card-header">
							<h3 class="card-title">
								Report's Configuration
							</h3>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12 col-md-8 col-lg-8">
									<div class="form-group">
										<!--<label>Enter the  keyword below: (Reference Number or Last Name or First Name)</label>
										<input type="text" name="searchtext" class="form-control" autocomplete="off" value="<?php //echo $this->session->userdata('searchtext'); ?>"placeholder="Enter your keyword here" />
										-->
										<label>Branch Areas <code>*</code></label>
										<select name="branch" class="form-control required">
											<option value="">Select an Option</option>
											<?php
												foreach($branchesareas as $row)
												{
													echo '<option value="'.$row['branchareaid'].'" '.($selectedbranch==$row['branchareaid'] ? 'selected' : null).'>'.$row['branchname'].' <b>['.$row['areacity'].']</b> - '.$row['areaname'].'</option>';
												}
											?>
										</select>	
									</div>
								</div>
								<div class="col col-sm-6 col-md-4 col-lg-4">
									<div class="form-group">
										<label for="period">Period <code>Required</code></label>
										<select name="period" class="form-control">
											<option value="">Select an Option</option>
											<option value="D" <?php echo ($selectedperiod=='D' ? 'selected' : null);?>>Daily</option>
											<option value="M" <?php echo ($selectedperiod=='M' ? 'selected' : null);?>>Monthly</option>
											<option value="R" <?php echo ($selectedperiod=='R' ? 'selected' : null);?>>Range</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col col-sm-6 col-md-4 col-lg-4 rptdaily">
									<div class="form-group">	
										<label for="date">Date <code>Required</code></label>
										<input type="text" name="date" class="form-control" placeholder="Date" value="<?php echo $selecteddate; ?>" autocomplete="off"/>
									</div>
								</div>
								<div class="col col-sm-6 col-md-4 col-lg-4 rptmonthly">
									<div class="form-group">
										<label for="month">Month <code>Required</code></label>
										<select name="month" class="form-control">
											<option value="1" <?php echo ($selectedmonth=='1' ? 'selected' : null);?>>January</option>
											<option value="2" <?php echo ($selectedmonth=='2' ? 'selected' : null);?>>February</option>
											<option value="3" <?php echo ($selectedmonth=='3' ? 'selected' : null);?>>March</option>
											<option value="4" <?php echo ($selectedmonth=='4' ? 'selected' : null);?>>April</option>
											<option value="5" <?php echo ($selectedmonth=='5' ? 'selected' : null);?>>May</option>
											<option value="6" <?php echo ($selectedmonth=='6' ? 'selected' : null);?>>June</option>
											<option value="7" <?php echo ($selectedmonth=='7' ? 'selected' : null);?>>July</option>
											<option value="8" <?php echo ($selectedmonth=='8' ? 'selected' : null);?>>August</option>
											<option value="9" <?php echo ($selectedmonth=='9' ? 'selected' : null);?>>September</option>
											<option value="10" <?php echo ($selectedmonth=='10' ? 'selected' : null);?>>October</option>
											<option value="11" <?php echo ($selectedmonth=='11' ? 'selected' : null);?>>November</option>
											<option value="12" <?php echo ($selectedmonth=='12' ? 'selected' : null);?>>December</option>
										</select>
									</div>
								</div>
								<div class="col col-sm-6 col-md-4 col-lg-4 rptmonthly">
									<div class="form-group">
										<label for="year">Year <code>Required</code></label>
										<select name="year" class="form-control">
											<?php
												for($ctr=intval(date("Y"));$ctr >= 2010;$ctr--)
												{
													echo '<option value="'.$ctr.'" '.($selectedyear==$ctr ? 'selected' : null).'>'.$ctr.'</option>';
												}
											?>
										</select>
									</div>
								</div>
								<div class="col col-sm-6 col-md-4 col-lg-4 rptdaterange">
									<div class="form-group">	
										<label for="datefrom">Date From <code>Required</code></label>
										<input type="text" name="datefrom" class="form-control" placeholder="Date From" value="<?php echo $selectedfrom; ?>" autocomplete="off"/>
									</div>
								</div>
								<div class="col col-sm-6 col-md-4 col-lg-4 rptdaterange">
									<div class="form-group">	
										<label for="dateto">Date To <code>Required</code></label>
										<input type="text" name="dateto" class="form-control" placeholder="Date To" value="<?php echo $selectedto; ?>" autocomplete="off"/>
									</div>
								</div>

							</div>
						</div>
						<div class="card-footer">
							<?php	echo form_submit('btnView', 'View', 'class="btn btn-primary float-right"');?>
						</div>
					</div>
				</div>
			</div>
			<?php 
				if (!empty($selectedbranch))
				{
			?>
					<div class="row">
						<div class="col-sm-12 col-md-12 col-lg-12">
							<div class="card card-primary card-outline">
								<div class="card-header">
									<h3 class="card-title">
										<?php 
											echo '<h3>Period: '.($selectedperiod=='D' ? date("F j, Y", strtotime($selecteddate)) : ($selectedperiod=='M' ?  date("F", mktime(0, 0, 0, $selectedmonth, 10)).' '.$selectedyear : 'From '.date("F j, Y", strtotime($selectedfrom)).' To '.date("F j, Y", strtotime($selectedto)))).'</h3>';
										?>
									</h3>
								</div>
								<div class="card-body">
							
									<table class="table table-bordered">
										<thead>
											<tr>
												<th style="text-align:center;">Branch</th>
												<th style="text-align:center;">City</th>
												<th style="text-align:center;">Area</th>
												<th style="text-align:center;">Type</th>
												<th style="text-align:center;">Amount</th>
											</tr>
										</thead>
										<tbody>
										<?php
											$loopbranch = null;
											if ($selectedbranch=='All')
											{
												$loopbranch = $branchesareas;
											}
											else
											{
												$loopbranch[0] = array('branchareaid' => $selectedbranch);
											}
											
											$totalloans=$totalpayments=0;
											foreach($loopbranch as $row)
											{
											
												$tempbrancharea=$CI->tools_model->branchesareasdetails($row['branchareaid']);
												$payments=$CI->report_model->getbranchloanpayments($row['branchareaid'],$selectedperiod,$selecteddate,$selectedmonth,$selectedyear,$selectedfrom,$selectedto);
												$loans=$CI->report_model->getbranchreleasedloans($row['branchareaid'],$selectedperiod,$selecteddate,$selectedmonth,$selectedyear,$selectedfrom,$selectedto);
												
												
												echo '<tr>
														<td style="text-align:left; vertical-align: middle;" rowspan="2">'.$tempbrancharea[0]['branchname'].'</td>
														<td style="text-align:left; vertical-align: middle;" rowspan="2">'.$tempbrancharea[0]['areacity'].'</td>
														<td style="text-align:left; vertical-align: middle;" rowspan="2">'.$tempbrancharea[0]['areaname'].'</td>
														<td style="text-align:center;">Received Payments</td>
														<th style="text-align:right;">Php '.number_format($payments[0]['amount'], 2, '.', ',').'</th>
													</tr>';
												echo '<tr>
														<td style="text-align:center;">Released Loans Amount</td>
														<th style="text-align:right;">Php '.number_format($loans[0]['amount'], 2, '.', ',').'</th>
													</tr>';	
												$totalloans +=$loans[0]['amount'];
												$totalpayments +=$payments[0]['amount'];
													
											}
										?>
										
										</tbody>
									</table>
								
									
									
									
									
								
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="card card-primary card-outline">
								<div class="card-header">
									<h3 class="card-title">
										Released Loans
									</h3>
								</div>
								<div class="card-body">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th style="text-align:center;">Loan Reference Number</th>
												<th style="text-align:center;">Name</th>
												<th style="text-align:center;">Released Date</th>
												<th style="text-align:center;">Principal + Interest</th>
												<th style="text-align:center;">Amount Released</th>
											</tr>
										</thead>
										<tbody>
										<?php
											
											
											$totalloans=$totalamountreleased=0;
											$loans=null;
											foreach($loopbranch as $rowloop)
											{
												$loans=$CI->report_model->getbranchreleasedloansdetails($rowloop['branchareaid'],$selectedperiod,$selecteddate,$selectedmonth,$selectedyear,$selectedfrom,$selectedto);
												
												if ($loans)
												{
													foreach($loans as $row)
													{
														echo '<tr>';
														echo '<td style="text-align:center;">'.$row['referencenumber'].'</td>';
														echo '<td>'.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname']).'</td>';
														echo '<td style="text-align:center;">'.($row['releaseddate']!='0000-00-00' ? date("F j, Y", strtotime($row['releaseddate'])) : '&nbsp;').'</td>';
														echo '<td style="text-align:right;">Php '.number_format(($row['principalamount']+$row['interest']), 2, '.', ',').'</td>';	
														echo '<td style="text-align:right;">Php '.number_format(($row['amountreleased']), 2, '.', ',').'</td>';	
														echo '</tr>';
														
														$totalamountreleased +=$row['amountreleased'];
														$totalloans +=($row['principalamount']+$row['interest']);
													}
												}
												else
												{
													echo '<tr>
														<td style="text-align:center;" colspan="5">No Data to Display</td>
													</tr>';
												}
													
											}
											if ($loans)
											{
												echo '<tr>
														<th style="text-align:right;" colspan="3"></th>
														<th style="text-align:right;">Php '.number_format($totalloans, 2, '.', ',').'</th>
														<th style="text-align:right;">Php '.number_format($totalamountreleased, 2, '.', ',').'</th>
													</tr>';
											}
										?>
										
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="card card-primary card-outline">
								<div class="card-header">
									<h3 class="card-title">
										Loans Payments
									</h3>
								</div>
								<div class="card-body">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th style="text-align:center;">Payment Reference Number</th>
												<th style="text-align:center;">Name</th>
												<th style="text-align:center;">Payment Date</th>
												<th style="text-align:center;">Type</th>
												<th style="text-align:center;">Amount</th>
											</tr>
										</thead>
										<tbody>
										<?php
											
											$totapayments=0;
											$payments=null;
											foreach($loopbranch as $rowloop)
											{
												$payments=$CI->report_model->getbranchloanpaymentsdetails($rowloop['branchareaid'],$selectedperiod,$selecteddate,$selectedmonth,$selectedyear,$selectedfrom,$selectedto);
												
												if ($payments)
												{
													foreach($payments as $row)
													{
														echo '<tr>';
														echo '<td style="text-align:center;">'.$row['ornumber'].'</td>';
														echo '<td>'.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname']).'</td>';
														echo '<td style="text-align:center;">'.($row['paymentdate']!='0000-00-00' ? date("F j, Y", strtotime($row['paymentdate'])) : '&nbsp;').'</td>';
														echo '<td style="text-align:center;">'.$row['paymenttype'].'</td>';
														echo '<td style="text-align:right;">Php '.number_format(($row['paymentamount']), 2, '.', ',').'</td>';	
														echo '</tr>';
														$totapayments +=$row['paymentamount'];
													}
												}
												else
												{
													echo '<tr>
														<td style="text-align:center;" colspan="5">No Data to Display</td>
													</tr>';
												}
													
											}
											if ($payments)
											{
												echo '<tr>
														<th style="text-align:right;" colspan="4"></th>
														<th style="text-align:right;">Php '.number_format($totapayments, 2, '.', ',').'</th>
													</tr>';
											}
										?>
										
										</tbody>
									</table>	
								</div>
							</div>
						</div>
					</div>
					
			<?php 				
				}//if (!empty($selectedbranch))
			?>	
		</div>
	 </section>	