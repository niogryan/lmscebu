<?php

	$CI=& get_instance();
	$CI->load->model("tools_model");
	$attributes = array('name' => 'frmuusermachinevalidation','id'=>'frmusermachinevalidation');
	echo form_open('tools/usermachinevalidation/',$attributes);
?>

    <section class="content-header">
		<h1>
			Users Machine Validation
		</h1>
    </section>
	
    <section class="content">
		<div class="container-fluid">
			<div class="row">	
				<div class="col col-sm-12 col-md-12 col-lg-12">	
					
					<div class="card card-primary">
						<div class="card-header with-border">
						  <h3 class="card-title">&nbsp;</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<div class="row">
								<div class="col col-md-12 col-lg-12">
									<h5>Pending</h5>
									<table class="table table-bordered">
										<thead>                  
											<tr>
												<th class="col-md-1" style="text-align:center;">Date Requested</th>
                                                <th class="col-md-1" style="text-align:center;">Requested By</th>
												<th class="col-md-1" style="text-align:center;">IP Address</th>
												<th style="text-align:center;">User Agent</th>
												<th  class="col-md-1" style="text-align:center;"></th>
											</tr>
										</thead>
										<tbody>
											<?php
												if ($cookiesPending){
													foreach($cookiesPending as $row){
														echo '<tr>';
														echo '<td>'.$row['created_at'].'</td>';
                                                        echo '<td>'.$row['firstname'].' '.$row['lastname'].'</td>';
														echo '<td>'.$row['ip_address'].' <br /> <a href="https://iplocation.io/ip/'.$row['ip_address'].'" class="btn btn-xs btn-primary" target="_blank">View Location</a></td>';
														echo '<td>'.$row['user_agent'].'</td>';
														echo '<td class="text-center">';
														echo '<a href="'.base_url().'tools/usermachinevalidation/cookie/1/'.$row['usercookieid'].'" class="btn btn-success btn-xs mr-1">Approve</a>';
														echo '<a href="'.base_url().'tools/usermachinevalidation/cookie/0/'.$row['usercookieid'].'" class="btn btn-danger btn-xs">Deny</a>';
														echo '</td>';
														echo '</tr>';
													}
												}
											?>
										</tbody>
									</table>
									<h5>Active</h5>
									<table class="table table-bordered">
										<thead>                  
											<tr>
												<th class="col-md-1" style="text-align:center;">Expiration Date</th>
                                                <th class="col-md-1" style="text-align:center;">Requested By</th>
												<th class="col-md-1" style="text-align:center;">IP Address</th>
												<th style="text-align:center;">User Agent</th>
												<th  class="col-md-1"  style="text-align:center;"></th>
											</tr>
										</thead>
										<tbody>
											<?php
												if ($cookiesActive){
													foreach($cookiesActive as $row){
														echo '<tr>';
														echo '<td>'.$row['expires_at'].'</td>';
                                                        echo '<td>'.$row['firstname'].' '.$row['lastname'].'</td>';
                                                        echo '<td>'.$row['ip_address'].' <br /> <a href="https://iplocation.io/ip/'.$row['ip_address'].'" class="btn btn-xs btn-primary" target="_blank">View Location</a></td>';
														echo '<td>'.$row['user_agent'].'</td>';
														echo '<td class="text-center">';
														echo '<a href="'.base_url().'tools/usermachinevalidation/cookie/0/'.$row['usercookieid'].'" class="btn btn-danger btn-xs">Deny</a>';
														echo '</td>';
														echo '</tr>';
													}
												}
											?>
										</tbody>
									</table>
                                    <h5>Unauthorize</h5>
									<table class="table table-bordered">
										<thead>                  
											<tr>
												<th class="col-md-1" style="text-align:center;">Date Requested</th>
                                                <th class="col-md-1" style="text-align:center;">Requested By</th>
												<th class="col-md-1" style="text-align:center;">IP Address</th>
												<th style="text-align:center;">User Agent</th>
												<th  class="col-md-1" style="text-align:center;"></th>
											</tr>
										</thead>
										<tbody>
											<?php
												if ($cookiesUnathorize){
													foreach($cookiesUnathorize as $row){
														echo '<tr>';
														echo '<td>'.$row['created_at'].'</td>';
                                                        echo '<td>'.$row['firstname'].' '.$row['lastname'].'</td>';
														echo '<td>'.$row['ip_address'].' <br /> <a href="https://iplocation.io/ip/'.$row['ip_address'].'" class="btn btn-xs btn-primary" target="_blank">View Location</a></td>';
														echo '<td>'.$row['user_agent'].'</td>';
														echo '<td class="text-center">';
														echo '<a href="'.base_url().'tools/usermachinevalidation/cookie/1/'.$row['usercookieid'].'" class="btn btn-success btn-xs mr-1">Approve</a>';
														echo '<a href="'.base_url().'tools/usermachinevalidation/cookie/2/'.$row['usercookieid'].'" class="btn btn-primary btn-xs">Set as Expired</a>';
														echo '</td>';
														echo '</tr>';
													}
												}
											?>
										</tbody>
									</table>
									<h5>Expired</h5>
									<table class="table table-bordered">
										<thead>                  
											<tr>
												<th class="col-md-1" style="text-align:center;">Requested Date</th>
                                                <th class="col-md-1" style="text-align:center;">Requested By</th>
												<th class="col-md-1" style="text-align:center;">IP Address</th>
												<th style="text-align:center;">User Agent</th>
												<th class="col-md-1"  style="text-align:center;">Expiration Date</th>
												<th class="col-md-1" style="text-align:center;">Status</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$ctr=0;
												if ($cookiesOthers){
													foreach($cookiesOthers as $row){
														echo '<tr>';
														echo '<td>'.$row['created_at'].'</td>';
                                                        echo '<td>'.$row['firstname'].' '.$row['lastname'].'</td>';
														echo '<td>'.$row['ip_address'].'</td>';
														echo '<td>'.$row['user_agent'].'</td>';
														echo '<td>'.$row['expires_at'].'</td>';
														echo '<td  style="text-align:center;">';
														echo $row['status'];
														echo '</td>';
														echo '</tr>';
														$ctr =1;
													}
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
		
			</div>	
		</div>
   </section>
	
	
<?php 	
	echo form_close();
?>

