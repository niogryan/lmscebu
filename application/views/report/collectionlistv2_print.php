<?php
	$CI=& get_instance();
	$CI->load->model("report_model");
?>
<html lang="en-ph">
	<head>
		<title>Collection List</title>
		<meta content="text/html; charset=utf-8" http-equiv="content-type" />
		<style>
			.table {
				width: 720px;
				margin-bottom: 1rem;
				font-family: arial, sans-serif;
			}
			
			thead {
				display: table-header-group;
				vertical-align: middle;
				font-size:10pt;
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
			
			table, td, th 
			{
				border-collapse: collapse;
				border: 1px solid  #637383;
			}
			
			table td,th 
			{
				padding-left:2px;
				padding-right:2px;
			}
		</style>
	</head>
	<body>
		<div style="width:100%; text-align:center; margin-top:-20px;">
			<p style="font-size:12pt; font-weight:bold;">Lending Management System</p>
			<p style="font-size:12pt; margin-top:-10px;">Collection List Report</p>
			<p style="font-size:12pt; margin-top:-10px;"><?php echo $branch[0]['branchname'].' '.$area; ?></p>
			<p style="font-size:12pt; margin-top:-10px;"><?php echo $type.' Accounts'; ?></p>
		</div>
		<div style="clear:both; margin-left:500px;">Date Genereated: <?php echo date("F d, Y"); ?></div>
		<div style="clear:both;"> 
				<?php
					if ($type=='Active')
					{
				?>
						<table class="table table-bordered">
							<thead>                  
								<tr>
									<th style="text-align:center; width:20px;">#</th>
									<th style="text-align:center; width:170px;">Customer Name</th>
									<th style="text-align:center;">Actual Payment</th>
									<th style="text-align:center;">Signature</th>
									
									<th style="text-align:center; width:80px;">Loan No.</th>
									<th style="text-align:center; width:70px;">Daily Due</th>
									<th style="text-align:center; width:70px;">Delayed Due (Buho)</th>
									<th style="text-align:center; width:70px;">Balance</th>
									<th style="text-align:center; width:70px;">Due Date</th>
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
											//yesterday
											$date_yesterday = date("Y-m-d", strtotime($selecteddate . "-1 days")); 
											//$paymentyesterday=$CI->report_model->gettotalpaymentsasbydate($row['loanid'],$date_yesterday);
											$overallpaymentsasofyesterday=$CI->report_model->gettotalpaymentsasbydate($row['loanid'],$date_yesterday);
	
											
											$no_of_days_to_be_paid=$this->mylibraries->no_of_days_to_be_paid($row['releaseddate'],$date_yesterday);
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
							
											$paymenttoday=$newadvancepayment=$balanceadvancededuction=$buho_payments=0;
											$paymenttoday=$CI->report_model->gettotalamountbydate($row['loanid'],$selecteddate);
												

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
											
											$buho_payments=	$total_ideal_payments_asofyesterday-$overallpaymentsasofyesterday;
											$totalbuhopayments +=$buho_payments;
											$total_dailyabsentbalance_asofyesterday +=$dailyabsentbalance_asofyesterday;
											if($buho_payments > 0) $dailyabsentbalance_asofyesterday += $buho_payments;					
											
											echo '<t>';
											echo '<td style="text-align:center;">'.$ctr.'</td>';
											echo '<td>'.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname'].' '.$row['middlename']).'</td>';
											echo '<td style="text-align:center;"></td>';
											echo '<td style="text-align:center;"></td>';
											echo '<td style="text-align:center;">'.$row['referencenumber'].'</td>';
											echo '<td style="text-align:right;">'.number_format($row['dailyduesamount'], 2, '.', ',').'</td>';
											echo '<td style="text-align:right;">'.number_format($buho_payments, 2, '.', ',').'</td>';
											
											echo '<td style="text-align:right;">'.number_format($row['balance'], 2, '.', ',').'</td>';
											echo '<td style="text-align:center;">'.($row['duedate']!='0000-00-00' ? date("Y-m-d", strtotime($row['duedate'])) : '&nbsp;').'</td>';
											echo '</tr>';
											$totalloan +=$row['principalamount'];
											$totalbalance +=$row['balance'];
											$totaldailydues +=$row['dailyduesamount'];
											$total_total_dailyabsentbalance_asofyesterday +=$total_dailyabsentbalance_asofyesterday;
											$ctr++;
										}
										
										echo '<tr>';
										echo '<th style="text-align:left;" colspan="5">Total</th>';
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
									<th style="text-align:center; width:20px;">#</th>
									<th style="text-align:center; width:250px;">Customer Name</th>
									<th style="text-align:center;">Actual Payment</th>
									<th style="text-align:center;">Signature</th>
									<th style="text-align:center; width:90px;">Loan No.</th>
									<th style="text-align:center; width:80px;">Balance</th>
									<th style="text-align:center; width:80px;">Running Balance</th>
									<th style="text-align:center; width:80px;">Due Date</th>
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
											echo '<td style="text-align:center;"></td>';
											echo '<td style="text-align:center;"></td>';
											echo '<td style="text-align:center;">'.$row['referencenumber'].'</td>';
											echo '<td style="text-align:right;">'.number_format($row['balance'], 2, '.', ',').'</td>';
											$totalbalance +=$row['balance'];
											echo '<td style="text-align:right;">'.number_format($totalbalance, 2, '.', ',').'</td>';
											echo '<td style="text-align:center;">'.($row['duedate']!='0000-00-00' ? date("Y-m-d", strtotime($row['duedate'])) : '&nbsp;').'</td>';
											echo '</tr>';
											$totalloan +=$row['principalamount'];
											
											$totaldailydues +=$row['dailyduesamount'];
											$total_total_dailyabsentbalance_asofyesterday +=$total_dailyabsentbalance_asofyesterday;
											$ctr++;
										}
										
										echo '<tr>';
										echo '<th style="text-align:left;" colspan="5">Total</th>';
										echo '<th style="text-align:right;">Php '.number_format($totalbalance, 2, '.', ',').'</th>';
										echo '<th style="text-align:right;"></th>';
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
	</body>
</html>
