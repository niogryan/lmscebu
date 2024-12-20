	<?php
		$CI=& get_instance();
		$CI->load->model("report_model");
		$attributes = array('name' => 'servicecharge','id'=>'form1');
		echo form_open('rpt/lendersattendance/',$attributes);
	?>
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lender's Attendance</h1>
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
						<div class="card-body table-responsive">
							<div class="row">
								<div class="col-sm-12 col-md-3 col-lg-3">
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
								<div class="col-sm-12 col-md-3 col-lg-2">
									<div class="form-group">
										<label>Area <code>*</code></label>
										
										<select name="area" id="areaselection" class="form-control required">
											<option value="">Select an Option</option>
											
											<?php
												if ($areas)
												{
													echo '<option value="ALL" '.($this->session->userdata('selectedarea')=='ALL' ? 'selected' : null).'>ALL</option>';
													foreach($areas as $row)
													{
														echo '<option value="'.$row['areaid'].'" '.($this->session->userdata('selectedarea')==$row['areaid'] ? 'selected' : null).'>'.$row['areaname'].'</option>';
													}
												}
											?>
										</select>	
									</div>
								</div>
	
								<div class="col-sm-12 col-md-3 col-lg-2">
									<div class="form-group">	
										<label for="datefrom">Date <code>Required</code></label>
										<input type="text" name="date" class="form-control" placeholder="Date From" value="<?php echo $this->session->userdata('selecteddate'); ?>" autocomplete="off"/>
									</div>
								</div>
								
								<div class="col-sm-12 col-md-3 col-lg-2">
									<div class="form-group">	
										<label for="datefrom">Type <code>Required</code></label>
										<select name="type"  class="form-control">
											<option value="Active" <?php echo ($this->session->userdata('selectedtype')=='Active' ? 'selected' : null); ?>>Active</option>
											<option value="BadAccounts" <?php echo ($this->session->userdata('selectedtype')=='BadAccounts' ? 'selected' : null); ?>>Bad Accounts</option>
											<option value="BadWithPayment" <?php echo ($this->session->userdata('selectedtype')=='BadWithPayment' ? 'selected' : null); ?>>Bad Accounts with Payment</option>
											<option value="Paid" <?php echo ($this->session->userdata('selectedtype')=='Paid' ? 'selected' : null); ?>>Fully Paid</option>
										</select>
										
									</div>
								</div>
								<div class="col-sm-12 col-md-3 col-lg-2">
									<div class="form-group">	
										<label for="datefrom">Sort By </label>
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
										echo anchor('rptprint/lendersattenadance/'.$this->session->userdata('selectedbranch').'/'.$this->session->userdata('selectedarea').'/'.$this->session->userdata('selecteddate').'/'.$this->session->userdata('selectedtype'),'Print','class="btn btn-success ml-1" target="_BLANK"');
									//echo anchor('customer/printprofile1/'.$this->session->userdata('selectedbranch').'/'.($this->session->userdata('selectedarea')=='ALL' ? '0' : $this->session->userdata('selectedarea')),'Print','class="btn btn-success ml-1" target="_BLANK"');
									}
								?>
							</div>
						</div>
						<!-- /.card-header -->
						
						
						<div class="card-body table-responsive">		
							<br />
							<table class="table table-bordered table-striped table2">
								<thead>                  
									
									<tr>
										<th style="text-align:center;" valign="middle">#</th>
										<th style="text-align:center;" valign="middle">Customer Name</th>
										<th style="text-align:center;">Loan No.</th>
										<?php 
											if ($this->session->userdata('role')=='Administrator')
											{
										?>
										<th style="text-align:center;">Principal Amount</th>
										<th style="text-align:center;">Interest</th>
										<?php 
											}
										?>
										<th style="text-align:center;">Loan Balance</th>
										<th style="text-align:center;">Daily Payment</th>
										<th style="text-align:center;">B/A Loan Balance</th>
										
										<th style="text-align:center;">Balance <br />Advance <br />Payment</th>
										<th style="text-align:center;">Balance <br />Advance <br />Deduction</th>
										<th style="text-align:center;">New <br />Advance <br />Payment</th>
										<th style="text-align:center;">Special  <br />Payment</th>
										<th style="text-align:center;">Due Date</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$totapaiddaily=$totalbuhopayments=$total_new_advance_payments=$total_bad_accounts_payments=$total_daily_absent=$total_balanceadvancededuction=0;
										$totalprincipal=$totalinterest=$total_balance=$total_dailyabsentbalance_asofyesterday=$total_advancepayment_asofyesterday=0;
										
										if ($list)
										{
											$ctr=1;
										
											foreach($list as $row)
											{
												$date_yesterday = date("Y-m-d", strtotime($this->session->userdata('selecteddate') . "-1 days")); 
												//$overallpaymentsasofyesterday=$CI->report_model->gettotalpaymentsasbydate($row['loanid'],$date_yesterday);
												$overallpaymentsasofyesterday=$row['TotalPaymentYesterday'];
												$balance=($row['principalamount']+$row['interest'])-$overallpaymentsasofyesterday;
												
												echo '<tr>';
												echo '<td style="text-align:center;">'.$ctr.'</td>';
												echo '<td>'.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname'].' '.$row['middlename']).'</td>';
												echo '<td style="text-align:center;">'.$row['referencenumber'].'</td>';
											
												if ($this->session->userdata('role')=='Administrator')
												{
													echo '<td style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($row['principalamount']).'</td>';
													echo '<td style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($row['interest']).'</td>';
												}
												echo '<td style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($balance).'</td>';
												echo '<td style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($row['paidamount']).'</td>';
												echo '<td style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($balance-$row['paidamount']).'</td>';
												
												echo '<td style="text-align:right;"></td>';
												echo '<td style="text-align:right;"></td>';
												echo '<td style="text-align:right;"></td>';
												echo '<td style="text-align:right;"></td>';
												echo '<td style="text-align:center;">'.($row['duedate']!='0000-00-00' ? date("F j, Y", strtotime($row['duedate'])) : '&nbsp;').'</td>';
												echo '</tr>';
												
												$totalprincipal +=$row['principalamount'];
												$totalinterest +=$row['interest'];
												$totapaiddaily+=$row['paidamount'];
												$total_balance += $balance;
												$ctr++;
												
											}
											
											
											echo '<tr>';
											echo '<th style="text-align:left;" colspan="3">Total</th>';
										
											if ($this->session->userdata('role')=='Administrator')
											{
												echo '<th style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($totalprincipal).'</th>';
												echo '<th style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($totalinterest).'</th>';
											}

											
											echo '<th style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($total_balance).'</th>';
											echo '<th style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($totapaiddaily).'</th>';
											echo '<th style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($total_balance-$totapaiddaily).'</th>';
											echo '<th style="text-align:right;"></th>';
											echo '<th style="text-align:right;"></th>';
											echo '<th style="text-align:right;"></th>';
											echo '<th style="text-align:right;"></th>';
											echo '<th style="text-align:right;"></th>';
											echo '</tr>';
											
											
											
										}
										
										
									?>
								</tbody>
							
							</table>
						
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
	
