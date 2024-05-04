	<?php
		$attributes = array('name' => 'frmroles','id'=>'frmroles');
		echo form_open('tools/roles/',$attributes);
	?>
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Roles</h1>
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
								if ($accessmenu['toolsroles']['isadd']=='T')			
								{
									echo '<a href="#AddEdit" class="btn btn-primary" data-toggle="modal">Add Role</a>';
								}
								?>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							
							
							<table class="table table-bordered">
								<thead>                  
									<tr>
										<th style="text-align:center;">Role</th>
										<th style="text-align:center;">Remarks</th>
										<th style="text-align:center;">Status</th>
										<th style="text-align:center; width:15%;"></th>
									</tr>
								</thead>
								<tbody>
									<?php
										if ($roles)
										{
											foreach($roles as $row)
											{
												echo '<tr class="'.($row['isactive']!='T' ? 'table-danger' : null).'">';
												echo '<td style="text-align:center;">'.$row['role'].'</td>';
												echo '<td style="text-align:center;">'.($row['isactive']=='T' ? 'Active' : 'Inactive').'</td>';
												echo '<td style="text-align:center;">'.$row['remarks'].'</td>';
												echo '<td style="text-align:center;">';
												if ($accessmenu['toolsroles']['isedit']=='T')			
												{
													echo '<a href="#AddEdit" data-id="'.$row['roleid'].'" data-toggle="modal" class="btn btn-sm  btn-primary btneditrole mb-1">Edit</a>';
												}
												echo anchor('tools/roledetails/'.$row['roleid'].'/'.$this->mylibraries->encrypt('vr'.$row['roleid']),'View Details','class="btn btn-sm btn-info ml-1 mb-1"');
												echo '</td>';
												echo '</tr>';
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
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Role Maintenance</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="hid" id="hid"/>
					<div class="col-12">
						<div class="form-group">
							<label>Name <code>*</code></label>
							<input type="text" name="rolename" class="form-control required" autocomplete="off"/>
						</div>
						
						<div class="form-group">
							<label>Status <code>*</code></label>
							<select name="status" class="form-control">
								<option value="T">Active</option>
								<option value="F">Inactive</option>
							</select>
						</div>
						<div class="form-group">
							<label>Remarks</label>
							<textarea name="remarks" id="remarks" class="form-control required" autocomplete="off"></textarea>
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
	
