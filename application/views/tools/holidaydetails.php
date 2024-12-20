	<?php
		$attributes = array('name' => 'branchesareas','id'=>'branchesareas');
		echo form_open('tools/holidaydetails/'.$param1.'/'.$param2,$attributes);
	?>
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Branches and Areas Affected of Holiday: <span class="text-primary"><?php echo date('F j, Y',strtotime($holidays[0]['holidaydate'])).' '.$holidays[0]['holidayname']; ?></span></h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-6">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">&nbsp;</h3>
							<div class="card-tools">
								<?php 
									if ($accessmenu['toolsholidays']['isedit']=='T')			
									{
										echo form_submit('btnSave','Save','class="btn btn-success buttonclick"');
									}
								?>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							
							
							<table class="table table-bordered">
								<thead>                  
									<tr>
										<th style="text-align:center;"><input type="checkbox" name="chkall" id="chkall" class="chkbox"/></th>
										<th style="text-align:center;">Branch Name</th>
									</tr>
								</thead>
								<tbody>
									<?php
										if ($branches)
										{
											foreach($branches as $row)
											{
												echo '<tr>';
												if(array_search($row['branchid'], array_column($this->data['holidaybranches'], 'branchid')) !== false) 
												{
													echo '<td style="text-align:center;"><input type="checkbox" name="branch[]" value="'.$row['branchid'].'" checked="checked" class="chkbox"/></td>';
												}
												else 
												{
													echo '<td style="text-align:center;"><input type="checkbox" name="branch[]" value="'.$row['branchid'].'" class="chkbox"/></td>';
												}

												
												echo '<td>'.$row['branchname'].'</td>';
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