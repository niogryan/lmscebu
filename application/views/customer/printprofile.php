<html lang="en-ph">
	<head>
		<title>Customer Profile</title>
		<meta content="text/html; charset=utf-8" http-equiv="content-type" />
		<style>
			.table {
				width: 100%;
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
			
			table, td, th 
			{
				border-collapse: collapse;
				border: 1px solid  #dee2e6;
			}
			
			table td,th 
			{
				padding-left:5px;
				padding-right:5px;
			}
		</style>
	</head>
	<body>
		<div style="width:100%; text-align:center; margin-top:-20px;">
			<p style="font-size:12pt; font-weight:bold;">Lending Management System</p>
			<p style="font-size:12pt; margin-top:-10px;">Customers List</p>
		</div>
		<div style="clear:both; margin-left:1050px;">Date Genereated: <?php echo date("F d, Y"); ?></div>
		<div style="clear:both;"> 
			<table class="table table-bordered">
				<thead>                  
					<tr>
						<th style="text-align:center;">#</th>
						<th style="text-align:center;">Reference Number</th>
						<th style="text-align:center;">Previous<br /> Reference Number</th>
						<th style="text-align:center;">Name</th>
						<th style="text-align:center;">Address</th>
						<th style="text-align:center;">Mobile</th>
						<th style="text-align:center;">Branch</th>
						<th style="text-align:center;">Area</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$ctr=1;
						foreach($profile as $row)
						{
							echo '<tr>';
							echo '<td style="text-align:center;">'.$ctr.'</td>';
							echo '<td style="text-align:center;">'.$row['refnumber'].'</td>';
							echo '<td style="text-align:center;">'.$row['oldrefnumber'].'</td>';
							echo '<td>'.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname'].' '.$row['middlename']).'</td>';
							echo '<td>'.$this->mylibraries->returnreplacespecialcharacter($row['address']).'</td>';
							echo '<td style="text-align:center;">'.$this->mylibraries->returnreplacespecialcharacter($row['cellphonenumber']).'</td>';
							echo '<td style="text-align:center;">'.$this->mylibraries->returnreplacespecialcharacter($row['branchname']).'</td>';
							echo '<td style="text-align:center;">'.$this->mylibraries->returnreplacespecialcharacter($row['areaname']).'</td>';;
							echo '</tr>';
							$ctr++;
						}
						
					?>
				</tbody>
			</table>
		</div>
	</body>
</html>