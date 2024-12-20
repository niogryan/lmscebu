<script>
	$(function () 
	{
		$( '.searchcustomer,.branchareaselection,.branchselection1,.branchselection2,.daterange' ).hide();

		

		$('select[name="searchtype"]').on('change', function() 
		{
			$( '.searchcustomer,.branchareaselection,.branchselection1,.branchselection2,.daterange' ).hide();

			if ($( 'select[name="searchtype"]' ).val()==1)
			{
				$( '.searchcustomer,.branchselection1' ).show();
			}
			else if ($( 'select[name="searchtype"]' ).val()==2)
			{
				$( '.daterange,.branchselection2' ).show();
			}
			else if ($( 'select[name="searchtype"]' ).val()==3)
			{
				$( '.branchareaselection,.daterange' ).show();
			}
			else
			{
				$( '.searchcustomer,.branchareaselection,.branchselection1,.branchselection2,.daterange' ).hide();
			}

				
		});
		
		<?php
			if ($selectedsearchtype)
			{
				if($selectedsearchtype==1)
				{
					echo "$( '.searchcustomer,.branchselection1' ).show();";
				}
				else if($selectedsearchtype==2)
				{
					echo "$( '.daterange,.branchselection2' ).show();";
				}
				else if($selectedsearchtype==3)
				{
					echo "$( '.branchareaselection,.daterange' ).show();";
				}
			}
		?>
		
		var nowDate = new Date("<?php echo date('Y-m-d H:i:s'); ?>");
		var prevDate =new Date(nowDate);
		
		var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
		
		$('.select2').select2();
		
		$('input[name="bday"],input[name="birthday"],input[name="releasedate"],input[name="date"],input[name="datefrom"],input[name="dateto"],.datefield').daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
			minYear: 1901,
			locale: {
					format: 'YYYY-MM-DD'
					}	
			});
		
		$('.paymentdatecustom1').daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
			minYear: 1901,
			setDate: today,
			locale: {
					format: 'YYYY-MM-DD'
					},	
		 });
		 
		 prevDate =new Date(nowDate);
		 prevDate.setDate(prevDate.getDate() - 2);
		 $('.paymentdatecustom2').daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
			 minYear: 1901,
			 minDate: prevDate,
			 maxDate: today,
			locale: {
					format: 'YYYY-MM-DD'
					},	
		 });
		 
		 prevDate =new Date(nowDate);
		 prevDate.setDate(prevDate.getDate() - 5);
		 $('.paymentdatecustom4').daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
			 minYear: 1901,
			 minDate: prevDate,
			 maxDate: today,
			locale: {
					format: 'YYYY-MM-DD'
					},	
		 });
		 
		 prevDate =new Date(nowDate);
		 prevDate.setDate(prevDate.getDate() - 10);
		 $('.paymentdatecustom5').daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
			 minYear: 1901,
			 minDate: prevDate,
			 maxDate: today,
			locale: {
					format: 'YYYY-MM-DD'
					},	
		 });
		  
		  
		$('#branchpayment').on('change', function() {
			$('#frmpayments').submit();
		});  
		
		$('#branchaddloan').on('change', function() {
			$('#addloan').submit();
		});  
		
		// $('#customeraddloan').change(function()
		// {
			// window.location = '<?php echo base_url(); ?>loan/add/a/'+$(this).val();
		// });
		
		
		$('#branchselection').on('change', function() {
			$('#form1').submit();
		});
		
		//collectorsaccess
		$('#branchajxselection').on('change', function() 
		{

			$('#areaajxselection').empty();
			$('#areaajxselection').append('<option value="">Select an Option</option>');
				
			$.ajax({
				type: "POST",
				async: true,
				url: "<?php echo base_url(); ?>payment/systemfunction",
				data:  {type: 'a',param: $( "#branchajxselection" ).val(),<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
				dataType: 'json',
				cache: false, 
				success: function (data) 
				{
					$('#areaajxselection').empty();
					$('#areaajxselection').append(data);
				},
				error: function(xhr, status, error) 
				{
					console.log(xhr.responseText);
				}
			});
		});
		
	
		
		
		$('#addloanbranchselection').on('change', function() 
		{
			<?php $selectedprofile=null; ?>
			
			$('#addcustomerselection').empty();
			$('#addloanareaselection').empty();
			$('#addcustomerselection,#addloanareaselection').append('<option value="">Select an Option</option>');

				
			$.ajax({
				type: "POST",
				async: true,
				url: "<?php echo base_url(); ?>loan/systemfunction",
				data:  {type: 'd',param: $( "#addloanbranchselection" ).val(),<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
				dataType: 'json',
				cache: false, 
				success: function (data) 
				{
					$('#addloanareaselection').empty();
					$('#addloanareaselection').append(data);
				},
				error: function(xhr, status, error) 
				{
					console.log(xhr.responseText);
				}
			});
		});
		
		$('#addloanareaselection').on('change', function() 
		{
			$.ajax({
				type: "POST",
				async: true,
				url: "<?php echo base_url(); ?>loan/systemfunction",
				data:  {type: 'e',param: $( "#addloanareaselection" ).val(),<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
				dataType: 'json',
				cache: false, 
				success: function (data) 
				{
					$('#addcustomerselection').empty();
					$('#addcustomerselection').append(data);
				},
				error: function(xhr, status, error) 
				{
					console.log(xhr.responseText);
				}
			});
		});
		
		$('#paymentinquiry1branch').on('change', function() 
		{
			$.ajax({
				type: "POST",
				async: true,
				url: "<?php echo base_url(); ?>payment/systemfunction",
				data:  {type: 'c',param: $( "#paymentinquiry1branch" ).val(),<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
				dataType: 'json',
				cache: false, 
				success: function (data) 
				{
					$('#customer').empty();
					$('#customer').append(data);
				},
				error: function(xhr, status, error) 
				{
					console.log(xhr.responseText);
				}
			});
		});
		
		
		$('#paymentbranchselection').on('change', function() 
		{
			<?php $selectedprofile=null; ?>
			
			$('#paymentareaselection').empty();
			$('#paymentcustomerselection').empty();
			$('#paymentareaselection,#paymentcustomerselection').append('<option value="">Select an Option</option>');

				
			$.ajax({
				type: "POST",
				async: true,
				url: "<?php echo base_url(); ?>payment/systemfunction",
				data:  {type: 'a',param: $( "#paymentbranchselection" ).val(),<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
				dataType: 'json',
				cache: false, 
				success: function (data) 
				{
					$('#paymentareaselection').empty();
					$('#paymentareaselection').append(data);
				},
				error: function(xhr, status, error) 
				{
					console.log(xhr.responseText);
				}
			});
		});

		$('#paymentareaselection').on('change', function() 
		{
			$.ajax({
				type: "POST",
				async: true,
				url: "<?php echo base_url(); ?>payment/systemfunction",
				data:  {type: 'b',param: $( "#paymentareaselection" ).val(),<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
				dataType: 'json',
				cache: false, 
				success: function (data) 
				{
					$('#paymentcustomerselection').empty();
					$('#paymentcustomerselection').append(data);
				},
				error: function(xhr, status, error) 
				{
					console.log(xhr.responseText);
				}
			});
		});
		
		
		
		
		$(document).on("click", ".btnforward", function (event) 
		{ 
			$('#temp').val($(this).data("id"));
			
		});	
		  
		  
		  
		$( "input[name=paymentamount]" ).change(function() 
		{
			$.ajax({
				type: "POST",
				async: true,
				url: "<?php echo base_url(); ?>loan/systemfunction",
				data:  {type: 'b',paramamount : $( "input[name=paymentamount]" ).val(),<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
				dataType: 'json',
				cache: false, 
				success: function (data) 
				{
					$('#formattedprincipal').empty();
					$('#formattedprincipal').append(data['formatamount']);
				},
				error: function(xhr, status, error) 
				{
					console.log(xhr.responseText);
				}
			});
		});		
		
			
		$( "input[name=releasedate],input[name=amount],input[name=passbokcharge],input[name=advancepayment]" ).change(function() 
		{
			$.ajax({
				type: "POST",
				async: true,
				url: "<?php echo base_url(); ?>loan/systemfunction",
				data:  {type: 'a',paramdate : $( "input[name=releasedate]" ).val(),parambranch : $("input[name=hbranch]").val(),paramamount : $( "input[name=amount]" ).val(),parampassbook : $( "select[name=passbokcharge]" ).val(),paramadvancepayment: $( "input[name=advancepayment]" ).val(),<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
				dataType: 'json',
				cache: false, 
				success: function (data) 
				{
					$('#formattedprincipal').empty();
					$('#formattedprincipal').append(data['formatamount']);
					$('input[name=duedate]').val(data['duedate']);
					$('input[name=holidaycount]').val(data['count']);
					$('input[name=interest]').val(data['interest']);
					$('input[name=dailydues]').val(data['dailydues']);
					$('input[name=servicecharge]').val(data['servicecharge']);
					$('input[name=specialpayment]').val(data['specialpayment']);
					$('input[name=totalamountreleased]').val(data['totalamountrelease']);
					$('input[name=principalinterest]').val(data['amountinterest']);
					
				},
				error: function(xhr, status, error) 
				{
					console.log(xhr.responseText);
				}
			});
		});
		
		
		$( ".btnedit" ).click(function() 
		{
			
			var tempid= $(this).data("id");
			$("input[name=edithid]").val(tempid);
			if(tempid>0)
			{
				$.ajax({
					type: "POST",
					async: true,
					url: "<?php echo base_url(); ?>loan/systemfunction",
					data:  {type: 'c',paramid : tempid,<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
					dataType: 'json',
					cache: false, 
					success: function (data) 
					{
						$('input[name=editpaymentdateadmin]').val(data[0]['paymentdate']);
						$('input[name=editpaymentamount]').val(data[0]['paymentamount']);
						$('select[name=editpaymenttype]').val(data[0]['paymenttype']);
						$('input[name=editremarks]').val(data[0]['paymentremarks']);
						
					},
					error: function(xhr, status, error) 
					{
						console.log(xhr.responseText);
					}
				});
			}
		});
		
		$( ".btneditexpenses" ).click(function() 
		{
			
			var tempid= $(this).data("id");
			$("input[name=hid]").val(tempid);
			if(tempid>0)
			{
				$.ajax({
					type: "POST",
					async: true,
					url: "<?php echo base_url(); ?>transaction/systemfunction",
					data:  {type: 'a',paramid : tempid,<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
					dataType: 'json',
					cache: false, 
					success: function (data) 
					{
						$('input[name=optionbranch]').val(data[0]['branchid']);
						$('select[name=type]').val(data[0]['expensestypeid']);
						$('input[name=date]').val(data[0]['expensedate']);
						$('input[name=voucher]').val(data[0]['voucher']);
						$('input[name=payee]').val(data[0]['payee']);
						$('input[name=description]').val(data[0]['description']);
						$('input[name=amount]').val(data[0]['amount']);
						$('input[name=remarks]').val(data[0]['remarks']);
						
					},
					error: function(xhr, status, error) 
					{
						console.log(xhr.responseText);
					}
				});
			}
		});
		
		$( ".btneditremittance" ).click(function() 
		{
			
			var tempid= $(this).data("id");
			$("input[name=hid]").val(tempid);
			if(tempid>0)
			{
				$.ajax({
					type: "POST",
					async: true,
					url: "<?php echo base_url(); ?>transaction/systemfunction",
					data:  {type: 'b',paramid : tempid,<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
					dataType: 'json',
					cache: false, 
					success: function (data) 
					{
						$('input[name=optionbranch]').val(data[0]['branchid']);
						$('input[name=date]').val(data[0]['remittancedate']);
						$('input[name=amount]').val(data[0]['amount']);
						$('input[name=remarks]').val(data[0]['remarks']);
						
					},
					error: function(xhr, status, error) 
					{
						console.log(xhr.responseText);
					}
				});
			}
		});
		
	$('#customerloan').change(function()
	{
		window.location = '<?php echo base_url(); ?>loan/payments/p/'+$(this).val();
	});
		
		
		
		$(".table1").DataTable({
			  "responsive": true,
			  "autoWidth": false,
			    "order": [],
			  "info": false,
			  "lengthMenu": [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ]
		});
		
		$(".table2").DataTable({
			  "responsive": true,
			  "autoWidth": false,
			   "order": [],
			  "paging":   false,
			  "info": false,
		});
		
	
		// $("#chkall").click(function(){
			// $('input:checkbox').not(this).prop('checked', this.checked);
		// });
		
		$("#chkall").click(function(){
			$('.chkbranch').not(this).prop('checked', this.checked);
		});
		
		$("#chkallareas").click(function(){
			$('.chkarea').not(this).prop('checked', this.checked);
		});
		
		$(document).on("click", ".btneditholiday", function (event)
		{

			var tempid= $(this).data("id");
			$("#hid").val(tempid);
			if (tempid>0)
			{
				$.ajax({
					type: "POST",
					async: true,
					url: "<?php echo base_url(); ?>tools/ajxsrc/holiday",
					data:  {paramid : tempid,<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
					dataType: 'json',
					cache: false, 
					success: function (data) 
					{
						$("input[name='date']").val(data[0]['holidaydate']);
						$("input[name='holidayname']").val(data[0]['holidayname']);
						$("select[name='isnational']").val(data[0]['isnational']);
						$("input[name='remarks']").val(data[0]['holidayremarks']);
						
					},
					error: function(xhr, status, error) 
					{
						console.log(xhr.responseText);
						alert('Oops, something went wrong');
					}
				});
			}
		});
	
		
		$(document).on("click", ".btneditrole", function (event)
		{
			var tempid= $(this).data("id");
			$("#hid").val(tempid);
			if (tempid>0)
			{
				$.ajax({
					type: "POST",
					async: true,
					url: "<?php echo base_url(); ?>tools/ajxsrc/role",
					data:  {paramid : tempid,<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
					dataType: 'json',
					cache: false, 
					success: function (data) 
					{
						$("input[name='rolename']").val(data[0]['role']);
						$("#remarks").val(data[0]['remarks']);
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
		
		
		$(document).on("click", ".btneditareas", function (event)
		{
			event.preventDefault();
			
			var tempid= $(this).data("id");
			$("#hid").val(tempid);
			if (tempid>0)
			{
				$.ajax({
					type: "POST",
					async: true,
					url: "<?php echo base_url(); ?>tools/ajxsrc/areas",
					data:  {paramid : tempid,<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
					dataType: 'json',
					cache: false, 
					success: function (data) 
					{
						$("input[name='areacity']").val(data[0]['areacity']);
						$("input[name='areaname']").val(data[0]['areaname']);
						$("select[name='areastatus']").val(data[0]['isactive']);
						
					},
					error: function(xhr, status, error) 
					{
						console.log(xhr.responseText);
						alert('Oops, something went wrong');
					}
				});
			}
		});
		
		$(document).on("click", ".btneditbranch", function (event)
		{
			var tempid= $(this).data("id");
			$("#hid").val(tempid);
			if (tempid>0)
			{
				$.ajax({
					type: "POST",
					async: true,
					url: "<?php echo base_url(); ?>tools/ajxsrc/branches",
					data:  {paramid : tempid,<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
					dataType: 'json',
					cache: false, 
					success: function (data) 
					{
						$("input[name='name']").val(data[0]['branchname']);
						$("input[name='shortdesc']").val(data[0]['branchshortdesc']);
						$("input[name='address']").val(data[0]['branchaddress']);
						$("input[name='contactperson']").val(data[0]['branchcontactperson']);
						$("input[name='contactnumber']").val(data[0]['branchcontactnumber']);
						$("input[name='ipaddress']").val(data[0]['ipaddress']);
						
					},
					error: function(xhr, status, error) 
					{
						console.log(xhr.responseText);
						alert('Oops, something went wrong');
					}
				});
			}
		});
		
		
		$(document).on("click", ".btneditbranchareas", function (event)
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
						/*
						$("input[name='address']").val(data[0]['address']);
						$("input[name='contactperson']").val(data[0]['contactperson']);
						$("input[name='contactnumber']").val(data[0]['contactnumber']);
						*/
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

		
		
		
		function transsuccess() 
		{
			toastr.success('Process Complete');
		};
		
		function transerror() 
		{
			toastr.options.fadeOut = 8000;
			toastr.error('<?php echo $this->session->userdata('alertred'); ?>');
		};
		
		
	<?php 				
		if($this->session->userdata('alertgreen'))
		{
			echo "transsuccess();";
			$this->session->unset_userdata('alertgreen');
		}
					
		if($this->session->userdata('alertred'))
		{
			echo "transerror();";
			$this->session->unset_userdata('alertred');
		}
	?>
	
		$(document).on("click", ".buttonclick", function (event) 
		 {
				
			var temp= confirm("Are you sure?\n\n Click OK Button to proceed. Otherwise, Click Cancel Button");
			if (!temp)
			{
				return false;
			}
			$('#processingmodal').modal('show');
		});
		
		$(document).on("click", "#formvalidate", function (event) 
		{ 
			var temp=0;
			

			$('#form1').find('.required').each(function()
			{
				if (($(this).val())== "")
				{
					$(this).addClass("highlight");
					temp = 1;
				}
				else
				{
					$(this).removeClass("highlight");
				}
			});
			
			if(temp==0)
			{
				if (confirm('Are you sure?\n\n Click OK Button to proceed. Otherwise, Click Cancel Button'))
				{
					$('#processingmodal').modal('show');
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				alert("Please complete all required fields");
				return false;
			}
		});
		
		$(document).on("click", "#formvalidateadd", function (event) 
		{ 
			var temp=0;
			

			$('#form1').find('.required').each(function()
			{
				if (($(this).val())== "")
				{
					$(this).addClass("highlight");
					temp = 1;
				}
				else
				{
					$(this).removeClass("highlight");
				}
			});
			
			if(temp==0)
			{
				if (confirm('Are you sure?\n\n Click OK Button to proceed. Otherwise, Click Cancel Button'))
				{
					$('#processingmodal').modal('show');
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				alert("Please complete all required fields");
				return false;
			}
		});
		
		$(document).on("click", "#frmvalidateuserdetails", function (event) 
		{ 
			var temp=0;
			

			$('#frmuserdetails').find('.required').each(function()
			{
				if (($(this).val())== "")
				{
					$(this).addClass("highlight");
					temp = 1;
				}
				else
				{
					$(this).removeClass("highlight");
				}
			});
			
			if(temp==0)
			{
				if (confirm('Are you sure?\n\n Click OK Button to proceed. Otherwise, Click Cancel Button'))
				{
					$('#processingmodal').modal('show');
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				alert("Please complete all required fields");
				return false;
			}
		});
			

		
		
		$(document).on("click", ".formvalidate", function (event) 
		{ 
			var temp=0;
			

			$('#editcustomer').find('.required').each(function()
			{
				if (($(this).val())== "")
				{
					$(this).addClass("highlight");
					temp = 1;
				}
				else
				{
					$(this).removeClass("highlight");
				}
			});
			
			if(temp==0)
			{
				if (confirm('Are you sure?\n\n Click OK Button to proceed. Otherwise, Click Cancel Button'))
				{
					$('#processingmodal').modal('show');
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				alert("Please complete all required fields");
				return false;
			}
		});
		
		$(document).on("click", ".buttonclickpayment", function (event) 
		{ 
			var temp=0;
			

			$('#frmpayments').find('.required').each(function()
			{
				if (($(this).val())== "")
				{
					$(this).addClass("highlight");
					temp = 1;
				}
				else
				{
					$(this).removeClass("highlight");
				}
			});
			
			if(temp==0)
			{
				if (confirm('Are you sure?\n\n Click OK Button to proceed. Otherwise, Click Cancel Button'))
				{
					$('#processingmodal').modal('show');
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				alert("Please complete all required fields");
				return false;
			}
		});
		
		
		
		
		
	});
			
</script>			
