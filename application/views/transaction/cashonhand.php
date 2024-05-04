<?php
	$CI =& get_instance();
	$CI->load->library('mylibraries');
	$CI2 =& get_instance();
	$CI2->load->model('transaction_model');
	
	$attributes = array('name' => 'form1','id'=>'form1');
	echo form_open('transaction/cashonhand/',$attributes);
	$availablecash=$servicecharge=$amountreleased=$addedcash=0;
	
	// PRINT_R($list);
	// DIE();
	
	
	if($list)
	{
		$addedcash=0; 
		foreach($list as $row)
		{
			$transamount=0;
			//$transamount=$CI->mylibraries->transactionamountperdate($row['date']);



			$collection=$CI->mylibraries->summarycollectionsperday($row['branchid'],$row['date']);
			$passbook=$CI->mylibraries->loanspassbookchargebybranchdate($row['branchid'],$row['date']);
			$expenses=$CI->mylibraries->expensesperdatebranch($row['branchid'],$row['date']);
			$remittance=$CI->mylibraries->remittanceperdatebranch($row['branchid'],$row['date']);
			
			$amountreleased=$CI->mylibraries->loanreleasedamountbybranchdate($row['branchid'],$row['date']);
			$servicecharge=$CI->mylibraries->loansservicechargebybranchdate($row['branchid'],$row['date']);
			$availablecash +=(($row['amount']+$servicecharge+$passbook+$collection)-($transamount+$expenses+$amountreleased+$remittance));
			
			$detail=$CI2->transaction_model->getcashonhanddetails($row['date']);
									
			foreach($detail as $rowdetails)
			{
				if (strpos($rowdetails['remarks'], 'Remaining Cash from') !== true  || strpos($rowdetails['remarks'], 'Forwarded Remaining Cash') !== true) 
				{
					$addedcash +=$rowdetails['amount'];
				}	
			}
										
			
		}
	}
	
	
?>
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cash on Hand</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12 col-md-8 col-lg-4">
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
							</div>
						</div>
						<div class="card-footer">
						</div>
					</div>
				</div>
			</div>
			
			<?php 
				if($selectedbranch)
				{
			?>
			
			<div class="row">
				
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="info-box mb-3 bg-success">
						  <span class="info-box-icon"><i class="fas fa-hand-holding-usd"></i></span>

						  <div class="info-box-content">
							<span class="info-box-text">Available Cash on Hand</span>
							<span class="info-box-number">Php <?php echo number_format($availablecash, 2, '.', ',');?></span>
						  </div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="info-box mb-3 bg-primary">
						  <span class="info-box-icon"><i class="fas fa-plus-square"></i></span>

						  <div class="info-box-content">
							<span class="info-box-text">Total Amount of Cash Added</span>
							<span class="info-box-number">Php <?php echo number_format($addedcash, 2, '.', ',');?></span>
						  </div>
					</div>
					
				</div>
			</div>
			
			<div class="card">
				<div class="card-header with-border">
					<h3 class="card-title">List of Recent Transaction</h3>
					<div class="card-tools">
						<?php 
							if ($accessmenu['transexpenses']['isadd']=='T')			
							{
								echo '<a href="#AddNew" data-toggle="modal" class="btn btn-primary">Add Transaction</a>';
							}
						?>
					</div>
				</div>
				
				<div class="card-body table-responsive">
					<br />
					<table class="table table-hover  table-condensed  table-bordered table-striped">
						<thead>
							<tr>
								<th style="text-align:center" class="col col-md-1 col-lg-1">Date</th>
								<!--
								<th style="text-align:center" class="col col-md-1 col-lg-1">Branch</th>
								-->
								<th style="text-align:center" class="col col-md-1 col-lg-1">Beginning Cash on Hand</th>
								<th style="text-align:center" class="col col-md-1 col-lg-1">Added Cash</th>
								<th style="text-align:center" class="col col-md-1 col-lg-1">Service Charge</th>
								<th style="text-align:center" class="col col-md-1 col-lg-1">Passbook Charge</th>
								<th style="text-align:center" class="col col-md-1 col-lg-1">Collection</th>
								<th style="text-align:center" class="col col-md-1 col-lg-1">Loan Released</th>
								
								<th style="text-align:center" class="col col-md-1 col-lg-1">Expenses</th>
								<th style="text-align:center" class="col col-md-1 col-lg-1">Remittance</th>
								<th style="text-align:center" class="col col-md-1 col-lg-1">Ending Cash on Hand</th>
							
								<th style="text-align:center" class="col col-md-1 col-lg-1">Remarks</th>
								<th style="text-align:center" class="col col-md-1 col-lg-1">Entry By</th>
								<th style="text-align:center" class="col col-md-1 col-lg-1"></th>
							</tr>
						</thead>
						<tbody>
							<?php
								if($list)
								{
									$totalamount=0;
									foreach($list as $row)
									{
										$availablecash=0;
										$detail=$CI2->transaction_model->getcashonhanddetails($row['date']);
										
										$addedcash=$begincash=0;
										foreach($detail as $rowdetails)
										{
											// if (strpos($rowdetails['remarks'], 'Remaining Cash from') !== false  || strpos($rowdetails['remarks'], 'Forwarded Remaining Cash') !== false) 
											// {
												// $addedcash +=$rowdetails['amount'];
											// }
											// else
											// {
												// $begincash +=$rowdetails['amount'];
											// }

											if (strpos($rowdetails['remarks'], 'Remaining Cash from') !== false) 
											{
												$begincash +=$rowdetails['amount'];
											}
											else if (strpos($rowdetails['remarks'], 'Forwarded Remaining Cash') !== false) 
											{
												
											}
											else
											{
												$addedcash +=$rowdetails['amount'];
												$totalamount +=$rowdetails['amount'];
											}

											if (strpos($rowdetails['remarks'], 'Remaining Cash from') !== true  || strpos($rowdetails['remarks'], 'Forwarded Remaining Cash') !== true) 
											{
												
											}
										}
										
										
										$expenses=$CI->mylibraries->expensesperdatebranch($row['branchid'],$row['date']);
										$loanreleased=$CI->mylibraries->loanreleasedamountbybranchdate($row['branchid'],$row['date']);
										
										// echo $amountreleased;
										// die();
										$collection=$CI->mylibraries->summarycollectionsperday($row['branchid'],$row['date']);
										//$transchange=$CI->mylibraries->transactionamountperdate($row['date']);
										$servicecharge=$CI->mylibraries->loansservicechargebybranchdate($row['branchid'],$row['date']);
										$passbook=$CI->mylibraries->loanspassbookchargebybranchdate($row['branchid'],$row['date']);
										$remittance=$CI->mylibraries->remittanceperdatebranch($row['branchid'],$row['date']);
										
										$availablecash=($row['amount']+$servicecharge+$passbook+$collection)-($expenses+$loanreleased+$remittance);
										
										
										
										
										echo '<tr>';
										echo '<td style="text-align:center; font-weight:bold;">'.date("m/d/Y", strtotime($row['date'])).'</td>';
										//echo '<td style=font-weight:bold;">['.$row['areaname'].'] '.$row['branchname'].'</td>';
										echo '<td style="text-align:right; font-weight:bold;">'.number_format($begincash, 2, '.', ',').'</td>';
										echo '<td style="text-align:right; font-weight:bold;">'.number_format($addedcash, 2, '.', ',').'</td>';
										echo '<td style="text-align:right; font-weight:bold;">'.number_format($passbook, 2, '.', ',').'</td>';
										echo '<td style="text-align:right; font-weight:bold;">'.number_format($servicecharge, 2, '.', ',').'</td>';
										echo '<td style="text-align:right; font-weight:bold;">'.number_format($collection, 2, '.', ',').'</td>';
										echo '<td style="text-align:right; font-weight:bold;">'.number_format($loanreleased, 2, '.', ',').'</td>';
										
										echo '<td style="text-align:right; font-weight:bold;">'.number_format($expenses, 2, '.', ',').'</td>';
										echo '<td style="text-align:right; font-weight:bold;">'.number_format($remittance, 2, '.', ',').'</td>';
										
										
										echo '<td style="text-align:right; font-weight:bold;">'.number_format($availablecash, 2, '.', ',').'</td>';
										echo '<td style="font-weight:bold; text-align:center;">';
										if(count($detail)==1)
										{
											echo $detail[0]['remarks'];
										}
										echo '</td>';
										echo '<td style="font-weight:bold; text-align:center;">';
										if(count($detail)==1)
										{
											echo $detail[0]['entryby'].' <br />'.$detail[0]['entrydate'];
										}
										echo '</td>';
										echo '<td style="text-align:center">';
										if($availablecash!=0)
										{
											echo '<a href="#ForwardCash" data-toggle="modal" data-id="'.$row['date'].'" class="btn btn-primary btn-sm btnforward  mr-1 mb-1" title="Forward Remaining Cash"><i class="fa fa-forward "></i> Cash</a>';
										}
										
										
										//if ($accessmenu['cashonhand']['isdelete']=='T' &&  count($detail)==1)
										//{
											echo anchor('app/cashonhand/d1/'.$row['date'].'/'.$CI->mylibraries->encrypt('d1'.$row['date']),'<i class="fa fa-trash"></i> Delete','class="btn btn-danger btn-sm buttonclick mr-1 mb-1"');
										//}
										
										echo '</td>';
										
										
										echo '</tr>';
										if(count($detail)>1)
										{
											foreach($detail as $rowdetails)
											{
												echo '<tr>';
												echo '<td style="text-align:center"></td>';
												
												if (strpos($rowdetails['remarks'], 'Remaining Cash from') !== false) 
												{
													echo '<td style="text-align:right;">Php '.number_format($rowdetails['amount'], 2, '.', ',').'</td>';
													echo '<td style="text-align:center;"></td>';
													echo '<td></td>';
													echo '<td style="text-align:center;"></td>';
													echo '<td style="text-align:center;"></td>';
													echo '<td style="text-align:center;"></td>';
													echo '<td style="text-align:center;"></td>';
													echo '<td style="text-align:center;"></td>';
													
													echo '<td style="text-align:center;"></td>';
												}
												else if (strpos($rowdetails['remarks'], 'Forwarded Remaining Cash') !== false) 
												{
													
													echo '<td style="text-align:center;"></td>';
													echo '<td></td>';
													echo '<td style="text-align:center;"></td>';
													echo '<td style="text-align:center;"></td>';
													echo '<td style="text-align:center;"></td>';
													echo '<td style="text-align:center;"></td>';
													echo '<td style="text-align:center;"></td>';
													echo '<td style="text-align:center;"></td>';
													echo '<td style="text-align:right;">Php '.number_format($rowdetails['amount'], 2, '.', ',').'</td>';
												}
												else
												{
													echo '<td></td>';
													echo '<td style="text-align:right;">Php '.number_format($rowdetails['amount'], 2, '.', ',').'</td>';
													echo '<td style="text-align:center;"></td>';
													echo '<td style="text-align:center;"></td>';
													echo '<td style="text-align:center;"></td>';
													echo '<td style="text-align:center;"></td>';
													echo '<td style="text-align:center;"></td>';
													echo '<td style="text-align:center;"></td>';
													echo '<td style="text-align:center;"></td>';
												}
												
												
												
												
												
												
												echo '<td>'.$rowdetails['remarks'].'</td>';
												echo '<td  style="text-align:center;">'.$rowdetails['entryby'].' <br />'.$rowdetails['entrydate'].'</td>';
												echo '<td style="text-align:center">';
												//if ($accessmenu['cashonhand']['isdelete']=='T')
												//{
													echo anchor('app/cashonhand/d/'.$rowdetails['cashonhandid'].'/'.$CI->mylibraries->encrypt('d'.$rowdetails['cashonhandid']),'<i class="fa fa-trash"></i> Delete','class="btn btn-danger btn-sm buttonclick  mr-1 mb-1"');
												//}
														
												echo '</td>';
												echo '</tr>';
											}
										}
										
									}
								}
							
							?>
						</tbody>
					</table>
				</div>
			</div>
   

			<?php 
				}//$selectedbranch
			?>
		</div>
	 </section>
	 
	<div class="modal" id="ForwardCash">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Forward Remaining Cash</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col col-sm-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="branch">Branch <code>Required</code></label>
								<select name="forwardbranch" id="forwardbranch" class="form-control  select2"  style="width: 100%;">
									<option value="">Select Branch</option>
									<?php
										foreach($branches as $row)
										{
											echo '<option value="'.$row['branchid'].'" '.($this->session->userdata('selectedbranch')==$row['branchid'] ? 'selected' : null).'>'.$row['branchname'].'</option>';
										}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col col-sm-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label>Date <code>Required</code></label>
								<input type="text" name="forwarddate" class="form-control required datefield" autocomplete="Off"/>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<?php	echo form_submit('btnForward', 'Save', 'class="btn btn-success btn-sm buttonclick"');?>
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal" id="AddNew">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Transaction</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col col-sm-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="branch">Branch <code>Required</code></label>
								<select name="branchoption" id="branchoption" class="form-control required">
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
					</div>
					<div class="row">
						<div class="col col-sm-6 col-md-6 col-lg-6">
							<div class="form-group">
								<label>Date <code>Required</code></label>
								<input type="text" name="date" class="form-control required datefield" autocomplete="Off"/>
							</div>
						</div>
						<div class="col col-sm-6 col-md-6 col-lg-6">
							<div class="form-group">
								<label for="principalamount">Amount <code>Required</code> </label>
								<input type="number" class="form-control required" name="amount" placeholder="1,000.00" min="0" step="0.01"autocomplete="off">
								<b id="formattedamount"></b>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col col-sm-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label for="remarks">Remarks </label>
								<textarea name="remarks" class="form-control" rows="3"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<?php	echo form_submit('btnSave', 'Save', 'class="btn btn-success btn-sm formvalidate"');?>
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="temp" id="temp" />

	<?php 	
		echo form_close();
	?>
	
					

    