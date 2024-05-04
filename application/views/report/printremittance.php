<html lang="en-ph">
	<head>
		<title>Remittance</title>
		<meta content="text/html; charset=utf-8" http-equiv="content-type" />
		<style>
			.table {
				width: 1280px;
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
				border: 1px solid #dee2e6;
			}
			
			.table-striped tbody tr:nth-of-type(odd) 
			{
				background-color: rgba(0,0,0,.05);
			}
			
			table, td, th 
			{
				border-collapse: collapse;
				border: 1px solid  #dee2e6;
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
			<p style="font-size:12pt; margin-top:-10px;">Remittance Report</p>
			<p style="font-size:12pt; margin-top:-10px;"><?php echo $branch[0]['branchname']; ?></p>
		</div>
		<div style="clear:both; margin-left:1050px;">Date Genereated: <?php echo date("F d, Y"); ?></div>
		<div style="clear:both;"> 
			<h3>Recent Remittance</h3>
			<table class="table table-bordered">
					<thead>                  
						<tr>
							<th style="text-align:center;">#</th>
							<th style="text-align:center;">Date</th>
							<th style="text-align:center;">Branch</th>
							<th style="text-align:center;">Amount</th>
							<th style="text-align:center;">Remarks</th>
							<th style="text-align:center;">Entry By</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if ($remittance)
							{
								$ctr=1;
								$totalremittance=0;
								foreach($remittance as $row)
								{
									echo '<t>';
									echo '<td style="text-align:center;">'.$ctr.'</td>';
									echo '<td style="text-align:center;">'.($row['remittancedate']!='0000-00-00' ? date("Y-m-d", strtotime($row['remittancedate'])) : '&nbsp;').'</td>';
									echo '<td style="text-align:center;">'.$row['branchname'].'</td>';
									echo '<td style="text-align:right;">Php '.number_format(($row['amount']), 2, '.', ',').'</td>';
									echo '<td style="text-align:center;">'.$row['remarks'].'</td>';
									echo '<td style="text-align:center;">'.$row['addedby'].'</td>';
									echo '</tr>';
									$ctr++;
									$totalremittance +=$row['amount'];
								}
								echo '<tr>';
								echo '<th style="text-align:right;" colspan="3">Total</th>';
								echo '<th style="text-align:right;">Php '.number_format($totalremittance, 2, '.', ',').'</th>';
								echo '<th style="text-align:right;"></th>';
								echo '<th style="text-align:right;"></th>';
								echo '</tr>';
							}
						?>
					</tbody>
				</table>
			
			<h3>Summary</h3>
			<table class="table table-bordered">
				<thead>                  
					<tr>
						<th style="text-align:center;">#</th>
						<th style="text-align:center;">Year</th>
						<th style="text-align:center;">Month</th>
						<th style="text-align:center;">Amount</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if ($summary)
						{
							$ctr=1;
							$totalexpenses=0;
							foreach($summary as $row)
							{
								echo '<tr>';
								echo '<td style="text-align:center;">'.$ctr.'</td>';
								echo '<td style="text-align:center;">'.$row['Year'].'</td>';
								echo '<td style="text-align:center;">'.$row['Month'].'</td>';
								echo '<td style="text-align:right;">Php '.number_format(($row['Amount']), 2, '.', ',').'</td>';
								echo '</tr>';
								$ctr++;
								$totalexpenses +=$row['Amount'];
							}
							
							echo '<tr>';
							echo '<th style="text-align:right;" colspan="3">Total</th>';
							echo '<th style="text-align:right;">Php '.number_format($totalexpenses, 2, '.', ',').'</th>';
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
			
					
					
					
		</div>
	</body>
</html>