	<?php
		$attributes = array('name' => 'frmuseraccounts','id'=>'frmuseraccounts');
		echo form_open('tools/useraccounts/',$attributes);
	?>
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Accounts</h1>
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
							<div class="card-tools">
							  <?php
								if ($accessmenu['toolsuseracounts']['isadd']=='T')			
								{
									ECHO '<a href="#AddEdit" class="btn btn-primary" data-toggle="modal">Add User Account</a>';
								}
							?>	
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							
							
							<table class="table table-bordered table1">
								<thead>                  
									<tr>
										<th style="text-align:center;">#</th>
										<th style="text-align:center;">Name</th>
										<th style="text-align:center;">Username</th>
										<th style="text-align:center;">Role</th>
										<th style="text-align:center;">Branch</th>
										<th style="text-align:center;">Status</th>
										<th style="text-align:center; width:15%;"></th>
									</tr>
								</thead>
								<tbody>
									<?php
										if ($useraccounts)
										{
											$ctr=1;
											foreach($useraccounts as $row)
											{
												echo '<tr class="'.($row['isactive']!='T' ? 'table-danger' : null).'">';
												echo '<td style="text-align:center;">'.$ctr.'</td>';
												echo '<td style="text-align:center;">'.$row['lastname'].', '.$row['firstname'].'</td>';
												echo '<td style="text-align:center;">'.$row['emailaddress'].'</td>';
												echo '<td style="text-align:center;">'.$row['role'].'</td>';
												echo '<td style="text-align:center;">'.$row['branchname'].'</td>';
												echo '<td style="text-align:center;">'.($row['isactive']=='T' ? 'Active' : 'Inactive').'</td>';
												echo '<td style="text-align:center;">';
												echo anchor('tools/userdetails/'.$row['userid'].'/'.$this->mylibraries->encrypt('vu'.$row['userid']),'View Details','class="btn btn-sm btn-info ml-1 mb-1"');
												if ($this->session->userdata('role')=='Administrator')
												{
													echo anchor('site/signinas/'.$row['userid'].'/'.$this->mylibraries->encrypt('1qaz45'.$row['userid']),'Sign-in As','class="btn btn-sm btn-danger ml-1 mb-1"');
												}
												echo '</td>';
												echo '</tr>';
												$ctr++;
											}
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
	
	
	<div class="modal fade" id="AddEdit">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add User Acount</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="hid" id="hid"/>
					<div class="row">
						<div class="col-4">
							<div class="form-group">
								<label>Email Address <code>*</code></label>
								<input type="email" name="emailaddress" class="form-control required" autocomplete="off"/>
							</div>
						</div>				
						<div class="col-4">
							<div class="form-group">
								<label>Password <code>*</code></label>
								<input type="password" name="password" class="form-control required" autocomplete="off"/>
						</div>
						</div>				
						<div class="col-4">
							<div class="form-group">
								<label>Confirm Password <code>*</code></label>
								<input type="password" name="confirmpassword" class="form-control required" autocomplete="off"/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-4">
							<div class="form-group">
								<label>First Name <code>*</code></label>
								<input type="text" name="firstname" class="form-control required" autocomplete="off"/>
							</div>
						</div>				
						<div class="col-4">
							<div class="form-group">
								<label>Last Name <code>*</code></label>
								<input type="text" name="lastname" class="form-control required" autocomplete="off"/>
							</div>
						</div>				
						<div class="col-4">
							<div class="form-group">
								<label>Middle Initial </label>
								<input type="text" name="mi" class="form-control required" autocomplete="off"/>
							</div>
						</div>				
					</div>	
					<div class="row">
						<div class="col-4">
							<div class="form-group">
								<label>Mobile Number</label>
								<input type="text" name="mobilenumber" class="form-control required" autocomplete="off"/>
							</div>
						</div>				
						<div class="col-8">
							<div class="form-group">
								<label>Address</label>
								<input type="text" name="address" class="form-control required" autocomplete="off"/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-4">
							<div class="form-group">
								<label>Role <code>*</code></label>
								<select name="role" class="form-control">
									<option value="">Select an Option</option>
									<?php
										foreach($roles as $row)
										{
											echo '	<option value="'.$row['roleid'].'">'.$row['role'].'</option>';
										}
									?>
								</select>
							</div>
						</div>
						<div class="col-4">
							<div class="form-group">
								<label for="userbranch">Branch</label>
								<select name="userbranch" class="form-control required">
									<option value="">Select an Option</option>
									<option value="0">None</option>
									<?php
										foreach($branches as $row)
										{
											
											echo '<option value="'.$row['branchid'].'" >'.$row['branchname'].'</option>';
										}
									?>
									
								</select>
							</div>
						</div>
						<div class="col-4">
							<div class="form-group">
								<label for="isstrictmachineaccess">Strict User Machine Access</label>
								<select name="isstrictmachineaccess" class="form-control required">
									<option value="">Select an Option</option>
									<option value="1">Enable</option>
									<option value="0">Disable</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label>Remarks</label>
								<textarea name="remarks" id="remarks" class="form-control required" autocomplete="off"></textarea>
							</div>
						</div>
					</div>
				</div>		
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<?php echo form_submit('btnSave','Save','class="btn btn-success buttonclick"');?>
				</div>
			</div>
		</div>
	</div>
	
	<?php 	
		echo form_close();
	?>
	

