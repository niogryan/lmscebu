	<?php
		$CI=& get_instance();
		$CI->load->model("report_model");
	?>
<html lang="en-ph">
	<head>
		<title><?php echo $date; ?> LENDER'S ATTENDANCE REPORT</title>
		<meta content="text/html; charset=utf-8" http-equiv="content-type" />
		<style>
			  #header { position: fixed; top: -100px; left: 0px; right: 0px; height: 100px; }
			 @page { margin-top: 100px; }
			.table {
				width: 1280px;
				margin-bottom: 1rem;
				font-family: arial, sans-serif;
			}
			
			thead {
				display: table-header-group;
				vertical-align: middle;
				font-size:9pt;
			}
						
			tbody {
				display: table-row-group;
				vertical-align: middle;
				font-size:10pt;
			}
			
			.table-bordered 
			{
				border: 1px solid #637383;
			}
			
			.table-striped tbody tr:nth-of-type(odd) 
			{
				background-color: rgba(0,0,0,.05);
			}
			
			.table1, .table1 td, .table1 th 
			{
				border-collapse: collapse;
				border: 1px solid  #637383;
			}
			
			.table1, .table1 td, .table1 th 
			{
				padding-left:2px;
				padding-right:2px;
			}
		</style>
	</head>
	<body>
		<div id="header" style="width:100%; text-align:center;">
			<p style="font-size:12pt; font-weight:bold;">Lending Management System</p>
			<p style="font-size:12pt; margin-top:-15px;">LENDER'S ATTENDANCE REPORT</p>
			<p style="font-size:12pt; margin-top:-15px; "><?php echo $branch[0]['branchname'].' '.$area; ?></p>
			<p style="font-size:12pt; margin-top:-15px;"><?php echo $date.' Bad Accounts'; ?> </p>
		</div>
		
		<div id="body" style="clear:both;"> 
					<table class="table table-bordered table-striped table1">
								<thead>                  
									
									<tr>
										<th style="text-align:center;" valign="middle">#</th>
											<th style="text-align:center; width:200px;" valign="middle">Customer Name</th>
										<th style="text-align:center; width:80px;">Loan No.</th>
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
										<th style="text-align:center;  width:80px;">Due Date</th>
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
												$date_yesterday = date("Y-m-d", strtotime($date . "-1 days")); 
												//$overallpaymentsasofyesterday=$CI->report_model->gettotalpaymentsasbydate($row['loanid'],$date_yesterday);
											
												$overallpaymentsasofyesterday=$row['TotalPaymentYesterday'];
												$balance=($row['principalamount']+$row['interest'])-$overallpaymentsasofyesterday;
												//$balance=$row['balance']
												
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
												echo '<td style="text-align:center;">'.($row['duedate']!='0000-00-00' ? date("Y-m-d", strtotime($row['duedate'])) : '&nbsp;').'</td>';
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
	</body>
</html>