	<?php
		$attributes = array('name' => 'frmindex','id'=>'frmindex');
		echo form_open('customer/index/',$attributes);
	?>
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
							<h3 class="card-title">&nbsp;</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
						
						
							<div class="row">
								<div class="col-sm-12  col-md-4 col-lg-4">
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
								<div class="col-sm-12  col-md-4 col-lg-4">
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
								<div class="col-sm-12  col-md-4 col-lg-4">
									<div class="form-group">
										<label>&nbsp;</label>
										<?php	echo form_submit('btnView', 'View', 'class="btn btn-primary btn-block"');?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
						if ($profile)
						{
					?>		
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">List of Customers Profile</h3>
								<div class="card-tools">
									<?php 
										echo anchor('rptprint/customerprofile/'.$this->session->userdata('selectedbranch').'/'.($this->session->userdata('selectedarea')=='ALL' ? '0' : $this->session->userdata('selectedarea')),'Print','class="btn btn-success ml-1" target="_BLANK"');
									?>
								</div>
							</div>
							<!-- /.card-header -->
							<div class="card-body">
								
								
								<table class="table table-bordered table1">
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
											<th style="text-align:center;"></th>
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
												echo '<td style="text-align:center;">'.$this->mylibraries->returnreplacespecialcharacter($row['areaname']).'</td>';
												echo '<td style="text-align:center">';
												echo anchor('customer/profile/'.$row['customerid'].'/'.$this->mylibraries->encrypt('v'.$row['customerid']),'View Profile','class="btn btn-primary btn-sm mb-1"');
												if ($accessmenu['customerindex']['isdelete']=='T')
												{
													echo anchor('customer/index/d/'.$row['customerid'].'/'.$this->mylibraries->encrypt('d'.$row['customerid']),'Delete Profile','class="btn btn-danger btn-sm buttonclick ml-1  mb-1"');
												}
												echo '</td>';
												echo '</tr>';
												$ctr++;
											}
											
										?>
									</tbody>
								</table>
						  </div>
						  <!-- /.card-body -->
						</div>
					<?php
						}
					?>	
				</div>
            <!-- /.card -->
			</div>
		</div><!-- /.container-fluid -->
    </section>
	
	<?php 	
		echo form_close();
	?>