	<?php
		$ci=& get_instance();
		$ci->load->model("loan_model");
		
		$attributes = array('name' => 'frmprofile','id'=>'frmprofile');
		echo form_open('customer/profile/',$attributes);
	?>
	
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Customer Profile</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12 col-md-8 col-lg-8">

				<!-- Profile Image -->
					<div class="card card-primary card-outline">
						<div class="card-header box-profile">
							<h3 class="card-title"><?php echo trim($profile[0]['firstname'].' '.$profile[0]['middlename'].' '.$profile[0]['lastname'].' '.$profile[0]['suffix']); ?></h3>
							<div class="card-tools">
								<?php
								if (!$loans && $accessmenu['customerindex']['isdelete']=='T')			
								{
									echo form_submit('btnDelete','Delete Profile','class="btn btn-danger buttonclick"');
								}
								
								if ($accessmenu['customerindex']['isedit']=='T')			
								{
									echo anchor('customer/edit/'.$param1.'/'.$this->mylibraries->encrypt('e'.$param1),'Edit','class="btn btn-primary"');
								}
						
								?>
							</div>
						</div>
						<div class="card-body box-profile">
							<div class="row">
								<div class="col-sm-12 col-md-4 col-lg-4">	
									<div class="mb-4">
									<?php
										if(!empty($image))
										{
											echo '<img src="data:image/png;base64,'.$image.'" alt="Image Picture"  class="img-responsive profile-user-img"/>';
										}
										else
										{
												echo '<img src="'.$this->config->item('base_url').'resources/images/nophotoavailable.jpg" alt="Not Available" class="img-responsive img-rounded"/>';
										}
									
									?>
									</div>
								</div>
								<div class="col-sm-12 col-md-8 col-lg-8">	
									<div class="row" style="border-bottom:1px solid #d9d9d9;">
										<div class="col-sm-12 col-md-12 col-lg-12">
											<strong><i class="fas fa-map-pin mr-1"></i>Branch Area Registered</strong>
											<p class="text-info text-bold" style="font-size:1.2em;">
											  <?php echo '['.trim($profile[0]['branchname'].'] '.$profile[0]['areaname']); ?>
											</p>
										</div>	
									</div>
									<div class="row" style="border-bottom:1px solid #d9d9d9;">
										<div class="col-sm-12 col-md-12 col-lg-6">
											<strong><i class="fas fa-fingerprint mr-1"></i> Reference Number</strong>
											<p class="text-primary text-bold" style="font-size:1.2em;">
											  <?php echo trim($profile[0]['refnumber']); ?>
											</p>
										</div>	
										<div class="col-sm-12 col-md-12 col-lg-6">
											<strong><i class="fas fa-fingerprint mr-1"></i>Previous Reference Number</strong>
											<p class="text-muted">
											  <?php echo $this->mylibraries->displaynaifempty($profile[0]['oldrefnumber']); ?>
											</p>
										</div>	
									</div>	
									<div class="row" style="border-bottom:1px solid #d9d9d9;">
										<div class="col-sm-12 col-md-6 col-lg-6">
											<strong><i class="far fa-id-card mr-1"></i> First Name</strong>
											<p class="text-muted">
											  <?php echo trim($profile[0]['firstname']); ?>
											</p>
										</div>	
										<div class="col-sm-12 col-md-6 col-lg-6">
											<strong><i class="far fa-id-card mr-1"></i> Middle Name</strong>
											<p class="text-muted">
											  <?php echo trim($profile[0]['middlename']); ?>
											</p>
										</div>
										<div class="col-sm-12 col-md-6 col-lg-6">
											<strong><i class="far fa-id-card mr-1"></i> Last Name</strong>
											<p class="text-muted">
											  <?php echo trim($profile[0]['lastname']); ?>
											</p>
										</div>
										<div class="col-sm-12 col-md-6 col-lg-6">
											<strong><i class="far fa-id-card mr-1"></i>Suffix</strong>
											<p class="text-muted">
											  <?php echo trim($profile[0]['suffix']); ?>
											</p>
										</div>
									</div>
									<div class="row" style="border-bottom:1px solid #d9d9d9;">
										<div class="col-sm-12 col-md-6 col-lg-6">
											<strong><i class="far fa-calendar-alt mr-1"></i> Birthday</strong>
											<p class="text-muted">
											  <?php echo trim($profile[0]['bday']); ?>
											</p>
										</div>	
										<div class="col-sm-12 col-md-6 col-lg-6">
											<strong><i class="fas fa-map-marker-alt mr-1"></i>Birth Place</strong>
											<p class="text-muted">
											  <?php echo $this->mylibraries->displaynaifempty($profile[0]['birthplace']); ?>
											</p>
										</div>	
									</div>	
									<div class="row"  style="border-bottom:1px solid #d9d9d9;">
										<div class="col-sm-12 col-md-6 col-lg-6">
											<strong><i class="fas fa-venus-mars mr-1"></i>Gender</strong>
											<p class="text-muted">
											  <?php echo $this->mylibraries->displaynaifempty($profile[0]['gender']); ?>
											</p>
										</div>	
										<div class="col-sm-12 col-md-6 col-lg-6">
											<strong><i class="fas fa-male mr-1"></i></i> Status</strong>
											<p class="text-muted">
											  <?php echo $this->mylibraries->displaynaifempty($profile[0]['maritalstatus']); ?>
											</p>
										</div>
									</div>
									<div class="row"  style="border-bottom:1px solid #d9d9d9;">	
										<div class="col-sm-12 col-md-12 col-lg-12">
											<strong><i class="fas fa-map-marker-alt  mr-1"></i>Address</strong>
											<p class="text-muted">
											  <?php echo $this->mylibraries->displaynaifempty($profile[0]['address']); ?>
											</p>
										</div>	
									</div>	
									<div class="row"  style="border-bottom:1px solid #d9d9d9;">
										<div class="col-sm-12 col-md-6 col-lg-6">
											<strong><i class="fas fa-phone-square-alt mr-1"></i> Telephone</strong>
											<p class="text-muted">
											  <?php echo $this->mylibraries->displaynaifempty($profile[0]['telephonenumber']); ?>
											</p>
										</div>	
										<div class="col-sm-12 col-md-6 col-lg-6">
											<strong><i class="fas fa-mobile-alt mr-1"></i>Mobile</strong>
											<p class="text-muted">
											  <?php echo $this->mylibraries->displaynaifempty($profile[0]['cellphonenumber']); ?>
											</p>
										</div>	
									</div>
									<div class="row"  style="border-bottom:1px solid #d9d9d9;">	
										<div class="col-sm-12 col-md-6 col-lg-6">
											<strong><i class="fas fa-at"></i> Email</strong>
											<p class="text-muted">
											  <?php echo $this->mylibraries->displaynaifempty($profile[0]['emailaddress']); ?>
											</p>
										</div>
									</div>		
									
									<div class="row" style="border-bottom:1px solid #d9d9d9;">
										<div class="col-sm-12 col-md-6 col-lg-6">
											<strong><i class="fas fa-id-card mr-1"></i> Employment Status</strong>
											<p class="text-muted">
											  <?php echo $this->mylibraries->displaynaifempty($profile[0]['employmentstatus']); ?>
											</p>
										</div>	
										<div class="col-sm-12 col-md-6 col-lg-6">
											<strong><i class="fas fa-id-card mr-1"></i> TIN Number</strong>
											<p class="text-muted">
											  <?php echo $this->mylibraries->displaynaifempty($profile[0]['tinnumber']); ?>
											</p>
										</div>
									</div>
									<div class="row"  style="border-bottom:1px solid #d9d9d9;">		
										<div class="col-sm-12 col-md-6 col-lg-6">
											<strong><i class="fas fa-user mr-1"></i>Remarks</strong>
											<p class="text-muted">
											  <?php echo $this->mylibraries->displaynaifempty($profile[0]['remarks']); ?>
											</p>
										</div>	
									</div>		
									<div class="row">		
										<div class="col-sm-12 col-md-6 col-lg-6">
											<strong><i class="fas fa-user mr-1"></i>Added By</strong>
											<p class="text-muted">
											  <?php echo trim($profile[0]['addedby']); ?>
											</p>
										</div>	
										<div class="col-sm-12 col-md-6 col-lg-6">
											<strong><i class="far fa-clock mr-1"></i> Date Added</strong>
											<p class="text-p">
											  <?php echo trim($profile[0]['entrydate']); ?>
											</p>
										</div>
									</div>		
								</div>
								
							</div>	
						
						</div>
					</div>

				</div>
				<div class="col-sm-12 col-md-4 col-lg-4">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Document Submitted</h3>
							<div class="card-tools">
								<?php 
								if ($accessmenu['customerindex']['isadd']=='T')			
								{
									echo '<a href="#UploadDocument" data-toggle="modal" class="btn btn-primary"> Upload Document</a>';
								}
								?>
							</div>
						</div>
						<div class="card-body">
							<?php
								
								if ($documents)
								{
									foreach($documents as $row)
									{
										echo '<strong><i class="fas fa-file-alt mr-1"></i>'.trim($row['documentname']).'</strong>';
										echo anchor('customer/document/'.$row['documentid'].'/'.$param1.'/'.$this->mylibraries->encrypt('cd'.$row['documentid'].$param1),'View','class="btn btn-primary btn-sm float-right" target="_blank"');
										if ($accessmenu['customerindex']['isdelete']=='T')			
										{
											echo anchor('customer/profile/d/'.$row['documentid'].'/'.$param1.'/'.$this->mylibraries->encrypt('d'.$row['documentid'].$param1),'Delete','class="btn btn-danger btn-sm float-right mr-1 buttonclick"');
										}
										echo '<hr>';
									}
								}
								else
								{
									echo '<i>Document not yet submitted</i><br /><br />';
								}
							?>

							
							
						</div>
					</div>
			  </div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">		
					<div class="card">
							<div class="card-header">
							<h3 class="card-title">Loans</h3>
						</div>
					  <div class="card-body">
							<table class="table table-bordered table1">
								<thead>                  
									<tr>
										<th style="text-align:center;">Reference Number</th>
										<th style="text-align:center;">Name</th>
										<th style="text-align:center;">Date</th>
										<th style="text-align:center;">Branch</th>
										<th style="text-align:center;">Area</th>
										<th style="text-align:center;">Status</th>
										<th style="text-align:center;">Loan Amount</th>
										<th style="text-align:center;">Payments</th>
										<th style="text-align:center;">Balance</th>
										<th style="text-align:center;"></th>
									</tr>
								</thead>
								<tbody>
									<?php
										if ($loans)
										{
											
											foreach($loans as $row)
											{
												echo '<tr class="'.($row['status']=='Overdue' ? 'bg-overdue' : ($row['status']=='Paid' ? 'bg-paid' : ($row['status']=='Default' ? 'bg-default' : null))).'">';
												echo '<td style="text-align:center;">'.$row['referencenumber'].'</td>';
												echo '<td>'.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname']).'</td>';
												echo '<td style="text-align:center;">'.($row['releaseddate']!='0000-00-00' ? date("F j, Y", strtotime($row['releaseddate'])) : '&nbsp;').'</td>';
												
												echo '<td style="text-align:center;">'.$this->mylibraries->returnreplacespecialcharacter($row['branchname']).'</td>';
												echo '<td style="text-align:center;">'.$this->mylibraries->returnreplacespecialcharacter($row['areaname']).'</td>';
												echo '<td style="text-align:center;">'.$row['status'].'</td>';
												echo '<td style="text-align:right;">Php '.number_format($row['principalamount']+$row['interest'], 2, '.', ',').'</td>';
												$payments=$ci->loan_model->gettotalloanpayments($row['loanid']);
												
												echo '<td style="text-align:right;">Php '.number_format($payments[0]['amount'], 2, '.', ',').'</td>';
												echo '<td style="text-align:right;">Php '.number_format($row['balance'], 2, '.', ',').'</td>';
												echo '<td style="text-align:center">';
												echo anchor('loan/details/'.$row['loanid'].'/'.$this->mylibraries->encrypt('v'.$row['loanid']),'View','class="btn btn-primary btn-sm"');
												echo '</td>';
												echo '</tr>';
											}
										}
									?>
								</tbody>
							</table>
					  </div><!-- /.card-body -->
					</div>
				</div>
			</div>	
					
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
	<?php 	
		echo form_close();
	?>
	
	<?php
		$attributes = array('name' => 'frmUploadDocument','id'=>'frmUploadDocument','enctype'=>'multipart/form-data');
		echo form_open('customer/profile/'.$param1.'/'.$param2,$attributes);
	?>
		<div class="modal fade" id="UploadDocument">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Upload Document</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="col-12">
							<div class="form-group">
								<label>Document Name<code>*</code></label>
								<input type="text" name="documentname" class="form-control required"/>
							</div>
							<div class="form-group">
								<label>Locate the file <code>*</code></label>
								<input type="file" name="uploaddocs" id="uploaddocs" class="form-control btn btn-default" accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/jpeg,image/png">
							</div>
						</div>
					</div>		
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<?php echo form_submit('btnUpload','Upload','class="btn btn-success buttonclick"');?>
					</div>
				</div>
			</div>
		</div>
	<?php 	
		echo form_close();
	?>