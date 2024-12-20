	<?php
		$CI=& get_instance();
		$CI->load->model("report_model");
		$CI2=& get_instance();
		$CI2->load->model("loan_model");

		$attributes = array('name' => 'collectionlist','id'=>'form2');
		echo form_open('rpt/collectionlistv2/',$attributes);
	?>
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Collection List</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">&nbsp;</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12 col-md-3 col-lg-3">
									<div class="form-group">
										<label>Branch <code>*</code></label>
										
										<select name="branch" id="branchajxselection" class="form-control required">
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
										<label>Area <code>*</code></label>
										
										<select name="area" id="areaajxselection" class="form-control required">
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
								<div class="col-sm-12 col-md-3 col-lg-3">
									<div class="form-group">
										<label>Type <code>*</code></label>
										
										<select name="status" id="statusselection" class="form-control required">
											<option value="Active" <?php echo ($selectedstatus=='Active' ? 'selected' : null); ?>>Active</option>
											<option value="Bad" <?php echo ($selectedstatus=='Bad' ? 'selected' : null); ?>>Bad Accounts</option>
										</select>	
									</div>
								</div>
								<div class="col-sm-12 col-md-3 col-lg-2">
									<div class="form-group">	
										<label for="datefrom">Sort By <code>Required</code></label>
										<select name="sortby"  class="form-control">
											<option value="1" <?php echo ($selectedsort=='1' ? 'selected' : null); ?>>By Lastname</option>
											<option value="2" <?php echo ($selectedsort=='2' ? 'selected' : null); ?>>By Due Date</option>
										</select>
										
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-sm-12 col-md-2 col-lg-2">
									<?php
										echo form_submit('btnView','View','class="btn btn-primary btn-block"'); 
									?>	
								</div>
								<div class="col-sm-12 col-md-2 col-lg-2">
									<?php
										echo form_submit('btnPrint','Print','formtarget="_blank" class="btn btn-success btn-block"'); 
									?>	
								</div>
							</div>
						</div>
					</div>	
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">&nbsp;</h3>
							<div class="card-tools">
								<?php 
									if ($list)
									{
										echo anchor('rptprint/collectionlistv2/'.$selectedbranch.'/'.$selectedarea.'/'.$selectedstatus.'/'.$selectedsort,'Print','class="btn btn-success ml-1" target="_BLANK"');
									}
								?>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">			
							<?php
								if ($selectedstatus=='Active')
								{
							?>
									<table class="table table-bordered">
										<thead>                  
											<tr>
												<th style="text-align:center;">#</th>
												<th style="text-align:center;">Customer Name</th>
												<th style="text-align:center;">Loan No.</th>
												<th style="text-align:center;">Daily Due</th>
												<th style="text-align:center;">Buho Balance</th>
												<th style="text-align:center;">Balance</th>
												<th style="text-align:center;">Due Date</th>
											</tr>
										</thead>
										<tbody>
											<?php
												if ($list)
												{
													$selecteddate = date("Y-m-d");
													
													$totalloan=$totalbalance=$totaldailydues=$totalbuhopayments=$total_dailyabsentbalance_asofyesterday=$total_total_dailyabsentbalance_asofyesterday=0;
													$ctr=1;


													foreach($list as $row)
													{
														
													
														$dailyabsent=$buhobalance=$dailyabsentbalance_asofyesterday=$advancepayment_asofyesterday=$remainingadvancepayment=0;
														$paymenttoday=$newadvancepayment=$balanceadvancededuction=$buho_payments=0;
														//yesterday
														$dateYesterday = date("Y-m-d", strtotime($selecteddate . "-1 days")); 
														$paymenttoday=$CI->report_model->gettotalamountbydate($row['loanid'],$selecteddate);
														$overallpaymentsasofyesterday= $row['totalamountpaid']-$paymenttoday;
														
														$no_of_days_to_be_paid=$this->mylibraries->no_of_days_to_be_paid($row['releaseddate'],$dateYesterday);
														$total_ideal_payments_asofyesterday = $no_of_days_to_be_paid * $row['dailyduesamount'];
														$dailyabsentbalance_asofyesterday=$total_ideal_payments_asofyesterday-$overallpaymentsasofyesterday;
														$remainingadvancepayment=$overallpaymentsasofyesterday-$total_ideal_payments_asofyesterday;
														
														if($remainingadvancepayment<0)
														{
															$remainingadvancepayment=0;
														}
														
														if ($dailyabsentbalance_asofyesterday < 0)
														{
															$dailyabsentbalance_asofyesterday=0;
														}
														
														if ($overallpaymentsasofyesterday>$total_ideal_payments_asofyesterday)
														{
															$advancepayment_asofyesterday=$overallpaymentsasofyesterday-$total_ideal_payments_asofyesterday;
														}
														
														if ($paymenttoday>$row['dailyduesamount'])
														{
															$newadvancepayment=$paymenttoday-$row['dailyduesamount'];
														}

														if($dailyabsentbalance_asofyesterday > 0 && $newadvancepayment > 0) 
														{ 
															if($dailyabsentbalance_asofyesterday >= $newadvancepayment) 
															{ 
																$buho_payments = $newadvancepayment; 
																$dailyabsentbalance_asofyesterday = $dailyabsentbalance_asofyesterday - $newadvancepayment;
																$newadvancepayment = 0; 
															} 
															else 
															{
																$buho_payments = $dailyabsentbalance_asofyesterday; 
																$newadvancepayment = $newadvancepayment - $dailyabsentbalance_asofyesterday; 
																$dailyabsentbalance_asofyesterday = 0;
															}
														} 
														
														
														$total_dailyabsentbalance_asofyesterday +=$dailyabsentbalance_asofyesterday;
														if($buho_payments > 0) $dailyabsentbalance_asofyesterday += $buho_payments;	

														$buho_payments=	$total_ideal_payments_asofyesterday-$overallpaymentsasofyesterday;
														$totalbuhopayments +=$buho_payments;
														
														echo '<t>';
														echo '<td style="text-align:center;">'.$ctr.'</td>';
														echo '<td>'.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname'].' '.$row['middlename']).'</td>';
														echo '<td style="text-align:center;">'.$row['referencenumber'].'</td>';
														echo '<td style="text-align:right;">Php '.number_format($row['dailyduesamount'], 2, '.', ',').'</td>';
														echo '<td style="text-align:right;">'.'Php '.number_format($buho_payments, 2, '.', ',').'</td>';
														
														echo '<td style="text-align:right;">Php '.number_format($row['balance'], 2, '.', ',').'</td>';
														echo '<td style="text-align:center;">'.($row['duedate']!='0000-00-00' ? date("F j, Y", strtotime($row['duedate'])) : '&nbsp;').'</td>';
														echo '</tr>';
														$totalloan +=$row['principalamount'];
														$totalbalance +=$row['balance'];
														$totaldailydues +=$row['dailyduesamount'];
														$total_total_dailyabsentbalance_asofyesterday +=$total_dailyabsentbalance_asofyesterday;
														$ctr++;
													}
													
													echo '<tr>';
													echo '<th style="text-align:left;" colspan="3">Total</th>';
													echo '<th style="text-align:right;">Php '.number_format($totaldailydues, 2, '.', ',').'</th>';
													echo '<th style="text-align:right;">Php '.number_format($totalbuhopayments, 2, '.', ',').'</th>';
													echo '<th style="text-align:right;">Php '.number_format($totalbalance, 2, '.', ',').'</th>';
													echo '<th style="text-align:right;"></th>';
													echo '</tr>';
													
													
												}
											?>
										</tbody>
									</table>
					 
							<?php
								}
								else
								{
							?>
									<table class="table table-bordered">
										<thead>                  
											<tr>
												<th style="text-align:center;">#</th>
												<th style="text-align:center;">Customer Name</th>
												<th style="text-align:center;">Loan No.</th>
												<th style="text-align:center;">Daily Due</th>
												<th style="text-align:center;">Balance</th>
												<th style="text-align:center;">Due Date</th>
											</tr>
										</thead>
										<tbody>
											<?php
												if ($list)
												{
													$selecteddate = date("Y-m-d");
													
													$totalloan=$totalbalance=$totaldailydues=$totalbuhopayments=$total_dailyabsentbalance_asofyesterday=$total_total_dailyabsentbalance_asofyesterday=0;
													$ctr=1;
													foreach($list as $row)
													{

														echo '<t>';
														echo '<td style="text-align:center;">'.$ctr.'</td>';
														echo '<td>'.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname'].' '.$row['middlename']).'</td>';
														echo '<td style="text-align:center;">'.$row['referencenumber'].'</td>';
														echo '<td style="text-align:right;">Php '.number_format($row['dailyduesamount'], 2, '.', ',').'</td>';
														echo '<td style="text-align:right;">Php '.number_format($row['balance'], 2, '.', ',').'</td>';
														echo '<td style="text-align:center;">'.($row['duedate']!='0000-00-00' ? date("F j, Y", strtotime($row['duedate'])) : '&nbsp;').'</td>';
														echo '</tr>';
														$totalloan +=$row['principalamount'];
														$totalbalance +=$row['balance'];
														$totaldailydues +=$row['dailyduesamount'];
														$total_total_dailyabsentbalance_asofyesterday +=$total_dailyabsentbalance_asofyesterday;
														$ctr++;
													}
													
													echo '<tr>';
													echo '<th style="text-align:left;" colspan="3">Total</th>';
													echo '<th style="text-align:right;">Php '.number_format($totaldailydues, 2, '.', ',').'</th>';
													echo '<th style="text-align:right;">Php '.number_format($totalbalance, 2, '.', ',').'</th>';
													echo '<th style="text-align:right;"></th>';
													echo '</tr>';
													
													
												}
											?>
										</tbody>
									</table>

							<?php
								}
								$time = new DateTime($timestart);
								$diff = $time->diff(new DateTime());
								$elapsed = $diff->format('%i minutes %s seconds');
								echo '<br />Page rendered in: <b>'.$elapsed.'</b>';
							?>
					 </div>
					  <!-- /.card-body -->
					</div>
				</div>
            <!-- /.card -->
			</div>
		</div><!-- /.container-fluid -->
    </section>

	
	<?php 	
		echo form_close();
	?>

<?php 
	
?>	
	
