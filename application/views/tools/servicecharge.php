	<?php
		$attributes = array('name' => 'branchesareas','id'=>'branchesareas');
		echo form_open('tools/branchesareas/',$attributes);
	?>
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Service Charge Configuration: <span class="text-primary"><?php echo $branch[0]['branchname']; ?></span></h1>
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
							
							
							<table class="table table-bordered table-striped">
								<thead>                  
									<tr>
										<th style="text-align:center;">Name</th>
										<th style="text-align:center;">Amount From</th>
										<th style="text-align:center;">Amount To</th>
										<th style="text-align:center;">Service Charge Amount</th>
									</tr>
								</thead>
								<tbody>
									<?php
										if ($servicecharge)
										{
											foreach($servicecharge as $row)
											{
												echo '<tr>';
												echo '<td>'.$row['servicechargename'].'</td>';
												echo '<td><input type="number" name=""  min="0" max="9999999" class="form-control" value="'.$row['servicechargefrom'].'"/></td>';
												echo '<td><input type="number" name=""  min="0" max="9999999" class="form-control" value="'.$row['servicechargeto'].'"/></td>';
												echo '<td><input type="number" name=""  min="0" max="9999999" class="form-control" value="'.$row['servicechargeamount'].'"/></td>';
											
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
					<h4 class="modal-title">Branch Area Maintenance</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="hid" id="hid"/>
					<div class="col-12">
						<div class="form-group">
							<label>Branch <code>*</code></label>
							<select name="branch" class="form-control">
								<?php
									foreach($branches as $row)
									{
										echo '<option value="'.$row['branchid'].'">'.$row['branchname'].'</option>';
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<label>Area <code>*</code></label>
							<select name="area" class="form-control">
								<?php
									foreach($areas as $row)
									{
										echo '<option value="'.$row['areaid'].'">['.$row['areacity'].'] '.$row['areaname'].'</option>';
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<label>Address <code>*</code></label>
							<input type="text" name="address" class="form-control required"/>
						</div>
						<div class="form-group">
							<label>Contact Person <code>*</code></label>
							<input type="text" name="contactperson" class="form-control required"/>
						</div>
						<div class="form-group">
							<label>Contact Number <code>*</code></label>
							<input type="text" name="contactnumber" class="form-control required"/>
						</div>
						<div class="form-group">
							<label>Status <code>*</code></label>
							<select name="status" class="form-control">
								<option value="T">Active</option>
								<option value="F">Inactive</option>
							</select>
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
	
	<script>
	

		$(document).on("click", ".btnedit", function (event)
		{
			event.preventDefault();
			
			var tempid= $(this).data("id");
			$("#hid").val(tempid);
			if (tempid>0)
			{
				$.ajax({
					type: "POST",
					async: true,
					url: "<?php echo base_url(); ?>tools/ajxsrc/branchesareas",
					data:  {paramid : tempid,<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
					dataType: 'json',
					cache: false, 
					success: function (data) 
					{
						$("select[name='branch']").val(data[0]['branchid']);
						$("select[name='area']").val(data[0]['areaid']);
						$("input[name='address']").val(data[0]['address']);
						$("input[name='contactperson']").val(data[0]['contactperson']);
						$("input[name='contactnumber']").val(data[0]['contactnumber']);
						$("select[name='status']").val(data[0]['isactive']);
						
					},
					error: function(xhr, status, error) 
					{
						console.log(xhr.responseText);
						alert('Oops, something went wrong');
					}
				});
			}
		});


</script>	