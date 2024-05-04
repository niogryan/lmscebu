<?php
	$CI=& get_instance();
	$CI->load->model("loan_model");
	$CI->load->model("tools_model");
	$attributes = array('name' => 'rptsummary','id'=>'rptsummary');
	echo form_open('rpt/summary/',$attributes);
?>
	
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Daily Collection Report</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	
	
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<div class="card card-primary card-outline">
						<div class="card-header">
							<h3 class="card-title">
								Report's Configuration
							</h3>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12 col-md-3 col-lg-3">
									<div class="form-group">
										<!--<label>Enter the  keyword below: (Reference Number or Last Name or First Name)</label>
										<input type="text" name="searchtext" class="form-control" autocomplete="off" value="<?php //echo $this->session->userdata('searchtext'); ?>"placeholder="Enter your keyword here" />
										-->
										<label>Branch <code>*</code></label>
										<select name="branch" class="form-control required">
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
								<div class="col-sm-12 col-md-3 col-lg-3">
									
										<div class="form-group">	
											<label for="date">Date <code>Required</code></label>
											<input type="text" name="date" class="form-control" placeholder="Date" value="<?php echo $selecteddate; ?>" autocomplete="off"/>
										</div>
									
									
									<!--
									<div class="form-group">
										<label for="period">Period <code>Required</code></label>
										<select name="period" class="form-control">
											<option value="">Select an Option</option>
											<option value="D" <?php echo ($selectedperiod=='D' ? 'selected' : null);?>>Daily</option>
											<option value="M" <?php echo ($selectedperiod=='M' ? 'selected' : null);?>>Monthly</option>
											<option value="R" <?php echo ($selectedperiod=='R' ? 'selected' : null);?>>Range</option>
										</select>
									</div>
									-->
								</div>
								<div class="col-sm-12 col-md-3 col-lg-3">
									<div class="form-group">
										<label>&nbsp;</label>
										<?php echo form_submit('btnView','View','class="btn btn-primary btn-block"'); ?>	
									</div>
								</div>
								<div class="col-sm-12 col-md-3 col-lg-3">
									<div class="form-group">
										<label>&nbsp;</label>
										<?php echo form_submit('btnPrint','Print','formtarget="_blank" class="btn btn-success btn-block"'); ?>	
									</div>
								</div>
							</div>
							
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
											if(strtolower(date("l", strtotime($selecteddate))) == "saturday")
											{
												echo '<h3>Period: '.date("F j, Y", strtotime($selecteddate )).' to '.date("F j, Y", strtotime($selecteddate. "+1 days")).'</h3>';
											}
											else
											{
												echo '<h3>Period: '.($selectedperiod=='D' ? date("F j, Y", strtotime($selecteddate)) : ($selectedperiod=='M' ?  date("F", mktime(0, 0, 0, $selectedmonth, 10)).' '.$selectedyear : 'From '.date("F j, Y", strtotime($selectedfrom)).' To '.date("F j, Y", strtotime($selectedto)))).'</h3>';
											}
											
										?>
									</h3>
									<div class="card-tools">
									<?php 
										if ($selectedbranch)
										{
											echo anchor('rptprint/summary/'.$selectedbranch.'/'.$selecteddate,'Print','class="btn btn-success ml-1" target="_BLANK"');
										}
									?>
								</div>
								</div>
								<div class="card-body">
									<div class="row">
										<?php
												
												
											$areas=$this->tools_model->getareasbybranch($selectedbranch);
											$list=$CI->report_model->getsummarycollectionsreport2($selectedbranch,$selecteddate);
											if ($areas)
											{
												$totalcollection=$totalnewreleases=0;
												foreach($areas as $rowareas)
												{

													
													$totaldues=$totalnew=$totalduetoday=0;
													foreach($list as $row)
													{
														if ($row['branchareaid']==$rowareas['branchareaid'])
														{
														
															$totalpaymentsasoftoday=$row['totalamountpaid'];
															$last_payment_date = $row['lastpaymentdate']; 
															$loan_balance = ($row['principalamount'] + $row['interest']) - $totalpaymentsasoftoday; 
															
															$is_advanced_fully_paid = FALSE;
															
															if(strtotime($selecteddate) > strtotime($row['duedate'])) continue;
											
															// nag advance fully paid
															$temp_lastpaymentdate = $temp_selecteddate=null;
															
															if ($last_payment_date)
															{
																if($loan_balance <= 0 && strtotime($last_payment_date) < strtotime($row['duedate'])) 
																{
																	
																	$temp_lastpaymentdate = new DateTime($last_payment_date);
																	$temp_selecteddate = new DateTime($selecteddate);

																	if ($temp_lastpaymentdate->diff($temp_selecteddate)->format("%a")>0)
																	{		
																		$is_advanced_fully_paid = true;
																	}
																}
															}
															
															if ($is_advanced_fully_paid==false)
															{
																$totaldues += $row['dailyduesamount'];
															}
														}
													}

													echo '<div class="col-lg-6">
																<div class="card">
																  <div class="card-header">
																	<h5 class="card-title m-0">'.$rowareas['areaname'].' - Php '.number_format($totaldues, 2, '.', ',').'</h5>
																  </div>
																  <div class="card-body">
																	<h6 class="card-title">Add: Releases</h6><br />';

																	$newloan=$CI->report_model->getnewloanperdateandbrancharea($rowareas['branchareaid'],$selecteddate);
														
																	if ($newloan)
																	{
																		foreach($newloan as $newrow)
																		{
																			
																			echo '
																				<p class="card-text ml-4">'.$newrow['lastname'].', '.$newrow['firstname'].' - '.$newrow['referencenumber'].'
																				- Php '.number_format($newrow['dailyduesamount'], 2, '.', ',').'</p>
																			';
																			$totalnew +=$newrow['dailyduesamount'];
																			$totalnewreleases += $newrow['principalamount'];
																		}	
																	}
																	
																	
														echo '		<b>Total: Php '.number_format($totalnew+$totaldues, 2, '.', ',').'</b>
																	<br /><br /><h6 class="card-title">Less: Duedate</h6><br />';
																	
																if(strtolower(date("l", strtotime($selecteddate))) != "sunday")
																{		
																	$loanduedatetoday=$CI->report_model->getloanduedateperdaybrancharea($rowareas['branchareaid'],$selecteddate);
																	
																	
																	if ($loanduedatetoday)
																	{
																		
																		foreach($loanduedatetoday as $newrow)
																		{
																			
																			echo '
																				<p class="card-text ml-4">'.$newrow['lastname'].', '.$newrow['firstname'].' - '.$newrow['referencenumber'].'
																				- Php '.number_format($newrow['dailyduesamount'], 2, '.', ',').'</p>
																			';
																			$totalduetoday +=$newrow['dailyduesamount'];
																		}	
																	}
																	
																	if(strtolower(date("l", strtotime($selecteddate))) == "saturday")
																	{
																		$loanduedatetoday=$CI->report_model->getloanduedateperdaybrancharea($rowareas['branchareaid'],date("Y-m-d", strtotime($selecteddate . "+1 days")));
																		if ($loanduedatetoday)
																		{
																			foreach($loanduedatetoday as $newrow)
																			{
																				
																				echo '
																					<p class="card-text ml-4">'.$newrow['lastname'].', '.$newrow['firstname'].' - '.$newrow['referencenumber'].'
																					- Php '.number_format($newrow['dailyduesamount'], 2, '.', ',').'</p>
																				';
																				$totalduetoday +=$newrow['dailyduesamount'];
																			}	
																		}
																	} 
																	
																	
																	$loanfullypaidtoday=$CI->report_model->getloanlfullypaidbypaymentbydate($rowareas['branchareaid'],$selecteddate);
																	if ($loanfullypaidtoday)
																	{
																		foreach($loanfullypaidtoday as $newrow)
																		{
																			
																			echo '
																				<p class="card-text ml-4">'.$newrow['lastname'].', '.$newrow['firstname'].' - '.$newrow['referencenumber'].'
																				- Php '.number_format($newrow['dailyduesamount'], 2, '.', ',').'</p>
																			';
																				$totalduetoday +=$newrow['dailyduesamount'];
																		}
																		
																	}
																}
																	
														echo '</div><div class="card-footer"><h5 class="text-primary text-bold">Total: Php '.number_format(($totaldues+$totalnew)-$totalduetoday , 2, '.', ',').'</h5> </div>
																 
																</div>
															  </div>';
															  
														$totalcollection +=($totaldues+$totalnew)-$totalduetoday ;	  
															  
												}
											}


										?>
									</div>
								</div>
								<div class="card-body">
									<h1>DAILY COLLECTION: Php <?php echo number_format($totalcollection, 2, '.', ','); ?> 
										<br />TOTAL RELEASES: Php <?php echo number_format($totalnewreleases, 2, '.', ','); ?> 
									</h1>
								</div>
							</div>
						</div>
					</div>
					
			<?php 
					$time = new DateTime($timestart);
					$diff = $time->diff(new DateTime());
					$elapsed = $diff->format('%i minutes %s seconds');
					echo $elapsed;
			
				}//if (!empty($selectedbranch))
			?>	
		</div>
	 </section>	