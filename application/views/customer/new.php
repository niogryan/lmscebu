	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Customers</h1>
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
							<h3 class="card-title">List of Customers Profile</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table class="table table-bordered">
								<thead>                  
									<tr>
										<th style="text-align:center; width:160px;">Reference Number</th>
										<th style="text-align:center;">Name</th>
										<th style="text-align:center; width:160px;">Birthday</th>
										<th style="text-align:center;">Address</th>
										<th style="text-align:center;">Email Address</th>
										<th style="text-align:center;">Mobile <br /></th>
										<th style="text-align:center; width:120px;"></th>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach($this->session->userdata('customerexists') as $row)
										{
											echo '<tr>';
											echo '<td style="text-align:center;">'.$row['refnumber'].'</td>';
											echo '<td>'.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname'].' '.$row['middlename']).'</td>';
											echo '<td style="text-align:center;">'.($row['bday']!='0000-00-00' ? date("F j, Y", strtotime($row['bday'])) : '&nbsp;').'</td>';
											echo '<td>'.$this->mylibraries->returnreplacespecialcharacter($row['address']).'</td>';
											echo '<td style="text-align:center;">'.$this->mylibraries->returnreplacespecialcharacter($row['emailaddress']).'</td>';
											echo '<td style="text-align:center;">'.$this->mylibraries->returnreplacespecialcharacter($row['cellphonenumber']).'</td>';
											echo '<td style="text-align:center">';
											echo anchor('customer/profile/'.$row['customerid'].'/'.$this->mylibraries->encrypt('v'.$row['customerid']),'View Profile','class="btn btn-primary btn-sm"');
											echo '</td>';
											echo '</tr>';
										}
									?>
									<tr>
										
									</tr>
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