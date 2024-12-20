<?php
	$CI=& get_instance();
	$CI->load->model("report_model");
?>
<html lang="en-ph">
	<head>
		<title>Service Charge</title>
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
			<p style="font-size:12pt; margin-top:-10px;">Service Charge Report</p>
			<p style="font-size:12pt; margin-top:-10px;"><?php echo $branch[0]['branchname'].' '.$area; ?></p>
			<p style="font-size:12pt; margin-top:-10px;"><?php echo $datefrom.' to '.$dateto; ?></p>
		</div>
		<div style="clear:both; margin-left:1050px;">Date Genereated: <?php echo date("F d, Y"); ?></div>
		<div style="clear:both;"> 
			<table class="table table-bordered">
				<thead>                  
					<tr>
						<th style="text-align:center;">#</th>
						<th style="text-align:center;">Released Date</th>
						<th style="text-align:center;">Customer Name</th>
						<th style="text-align:center;">Loan No.</th>
						<th style="text-align:center;">Principal Amount</th>
						<th style="text-align:center;">Interest</th>
						<th style="text-align:center;">Service Charge</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if ($list)
						{
							$totalloan=$totalinterest=$totalservicecharge=0;
							$ctr=1;
							foreach($list as $row)
							{
								echo '<t>';
								echo '<td style="text-align:center;">'.$ctr.'</td>';
								echo '<td style="text-align:center;">'.($row['releaseddate']!='0000-00-00' ? date("F j, Y", strtotime($row['releaseddate'])) : '&nbsp;').'</td>';
								echo '<td>'.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname'].' '.$row['middlename']).'</td>';
								echo '<td style="text-align:center;">'.$row['referencenumber'].'</td>';
								echo '<td style="text-align:right;">Php '.number_format($row['principalamount'], 2, '.', ',').'</td>';
								echo '<td style="text-align:right;">Php '.number_format($row['interest'], 2, '.', ',').'</td>';
								echo '<td style="text-align:right;">Php '.number_format($row['servicecharge'], 2, '.', ',').'</td>';
								echo '</tr>';
								
								$totalloan +=$row['principalamount'];
								$totalinterest +=$row['interest'];
								$totalservicecharge +=$row['servicecharge'];
								$ctr++;
							}
							
							echo '<tr>';
							echo '<th style="text-align:right;" colspan="4">Total</th>';
							echo '<th style="text-align:right;">Php '.number_format($totalloan, 2, '.', ',').'</th>';
							echo '<th style="text-align:right;">Php '.number_format($totalinterest, 2, '.', ',').'</th>';
							echo '<th style="text-align:right;">Php '.number_format($totalservicecharge, 2, '.', ',').'</th>';
							echo '</tr>';
							
							
						}
					?>
				</tbody>
			</table>
					
					
					
		</div>
	</body>
</html>