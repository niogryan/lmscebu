<?php 
 if (!defined('BASEPATH')) exit('No direct script access allowed');
class mylibraries
{
	
   
   function encrypt($string=null)
   {
		$encrypted=null;
		$encrypted = sha1('-0MyS@LT**'.sha1('-0MyS@LT**'.$string.'-0MyS@LT**').'2021*');
		return $encrypted;
   }
   
	function getcustomerreferencenumber($param) 
	{
		$CI =& get_instance();
		$CI->load->model('customer_model');
		$refno=$result=null;
		
		$count=$CI->customer_model->getcountcustomerprofile();
		$refno = sprintf("CN%1$08d", ($count+$param));
		return $refno;
	}
	
	function getloanreferencenumber($param1,$param2) 
	{
		$CI =& get_instance();
		$CI->load->model('loan_model');
		$refno=$result=null;
		
		$count=$CI->loan_model->getcountloansperbrancharea($param1);
		$refno = sprintf(date("Y")."%1$03d%2$04d",$param1,($count+$param2));
		return $refno;
		
	}
	
	function getornumber($param) 
	{
		$CI =& get_instance();
		$CI->load->model('loan_model');
		$refno=$result=null;
		
		$count=$CI->loan_model->getcountpayment();
		$refno = sprintf(date("Ymd")."%1$05d",($count+$param));
		return $refno;
		
	}
	
	function replaceszerotoblank($param)
	{
		$param =  ($param=='0' || $param=='0.00' ? '' : ' '.number_format($param));
		return $param;
	}
	
   
  
	function replacespecialcharacter($param)
	{
		$param = ascii_to_entities(trim($param));
		$param = str_replace("'","&#39;",$param);
		return $param;
	}
	
	function displaynaifempty($param)
	{
		if (empty(trim($param)))
		{
			$param='N/A';
		}
		return $param;
	}
	
	function returnreplacespecialcharacter($param)
	{
		$param = ascii_to_entities(trim($param));
		$param = str_replace("&#39;","'",$param);
		return $param;
	}
	
	
	function enyereplacespecialcharacter($param)
	{
		$param =  str_replace("Ñ","&ntilde;",utf8_encode($param));
		return $param;
	}
	
	function enyereplacespecialcharacter2($param)
	{
		$param =  str_replace("ñ","&#209;",utf8_encode($param));
		return $param;
	}
	
	function validatedate($date)
	{
		$tempDate = explode('-', $date);
		if(!empty($tempDate))
		{
			return checkdate($tempDate[1], $tempDate[2], $tempDate[0]);
		}
		
		return false;
	}
   
   function myucwords($string=null)
   {
		$temp=null;
		$temp =  ucwords(mb_convert_case($string, MB_CASE_LOWER, "UTF-8"));
		return $temp;
   }
   
   function mystrtoupper($string=null)
   {
		$temp=null;
		$temp =  strtoupper(mb_convert_case($string, MB_CASE_LOWER, "UTF-8"));
		return $temp;
   }
   
   function ismenuaccess($menu,$menuarray)
   {
		if (!empty(array_search($menu, array_column($menuarray, 'url')))  
			&& $menuarray[array_search($menu, array_column($menuarray, 'url'))]['ismember']==1)
		{
			return true;
		}
		else
		{
			return false;
		}  
   }
   
    function validation_errors_message($param)
	{
		$temp=null;
		foreach($param as $row)
		{
			$temp .=trim($row).'<br />';
		}
		return $temp;
	}
		
  
    function show_message($temp)
	{
		switch ($temp) 
		{
			case "incomplete":
				$value = 'Please complete all the necessary fields';
				break;
			case "exists":
				$value = 'Record already exists.';
				break;
			case "success":
				$value= 'Process Complete';
				break;
			case "duplicate":
				$value = 'Duplicate Entry. Transaction Denied';
				break;						
			case "denied":
				$value = 'Transaction Denied';
				break;
			case "accessdenied":
				$value = ' Access Denied';
				break;
			case "deleted":
				$value = 'Record has been successfully deleted';
				break;
			case "transferred":
				$value = 'Record has been transferred successfully';
				break;
			case "inuse":
				$value = 'The operation can’t be completed because data is being used';
				break;
			case "invaliddate":
				$value = 'Invalid date';
				break;	
			case "filelarge":
				$value = 'The import file is too large to upload<br />';
				break;	
			case "filetype":
				$value = 'Invalid file type<br />';	
				break;
			default:
			$value = $temp;
			break;		
				
		}
		return $value;
	}
	
	function imagevalidation($param)
    {
		$mb=1048576;
		$errors     = array();
		
		$maxsize    = 3*$mb;

		$acceptable = array(
			'image/jpeg',
			'image/png'
		); 
		
		
		if(($param['size'] >= $maxsize) || ($param["size"] == 0)) 
		{
			$errors[] =  $this->show_message('filelarge');
		}
		
		if((!in_array($param['type'], $acceptable)) && (!empty($param["type"]))) 
		{
			$errors[] = $this->show_message('filetype');
		}

		return $errors;
   }
	
	function attachmenvalidation($param)
    {
		$mb=1048576;
		$errors     = array();
		
		$maxsize    = 3*$mb;
		
		
		$acceptable = array(
			'application/pdf',
			'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'application/msword',
			'image/jpeg',
			'image/png'
		); 
		
		
		if(($param['size'] >= $maxsize) || ($param["size"] == 0)) 
		{
			$errors[] =  $this->show_message('filelarge');
		}
		
		if((!in_array($param['type'], $acceptable)) && (!empty($param["type"]))) 
		{
			$errors[] = $this->show_message('filetype');
		}

		return $errors;
   }
	
	function sendMail($toemail,$subject,$message)
	{
		$config = Array(
				'protocol' 		=> 'smtp',
				'smtp_host' 	=> '192.168.4.7',
				'smtp_port' 	=> 587,
				'newline'   	=> "\r\n",
				'mailtype' 		=> 'html',
				'charset' 		=> 'UTF-8',
				);
		
		$CI =& get_instance();
		$CI->load->library('email', $config);
		
		$CI->email->from('noreply@pup.edu.ph');
		$CI->email->to($toemail);
		//$CI->email->to('rrlniog@pup.edu.ph');
		//$CI->email->cc('niog.ryan@yahoo.com');
		$CI->email->subject($subject);
		$CI->email->message(wordwrap($message,60,"\n",FALSE));
		$CI->email->set_crlf( "\r\n" );
		
		if($CI->email->send())
		{
			return 'Email Sent';
		}
		else
		{
			return $CI->email->print_debugger();
		}	
	}
	
	function emailtemplate($paramlink,$paramservices)
	{

		$template ='<html>
				<head>
					<meta charset="UTF-8">
					<style>
							.btn {
								width:300px;
								display: inline-block;
								font-weight: 400;
								color: #212529;
								text-align: center;
								vertical-align: middle;
								cursor: pointer;
								-webkit-user-select: none;
								-moz-user-select: none;
								-ms-user-select: none;
								user-select: none;
								background-color: transparent;
								border: 1px solid transparent;
								padding: .375rem .75rem;
								font-size: 1rem;
								line-height: 1.5;
								border-radius: .25rem;
								transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
								
							}
							
							.btn.btn-flat {
								border-radius: 0;
								border-width: 1px;
								box-shadow: none;
							}
							
							
							.btn-primary 
							{
								color: #fff;
								background-color: #007bff;
								border-color: #007bff;
								box-shadow: none;
							}
							
							.tablecontent
							{
								border-collapse: collapse;
							}
							
							.tablecontent th,td
							{
								width:300px; 
								text-align:center;
							}
							
							table, td, th 
							{
							  border: 1px solid black;
							}
							
						</style>
					</head>
					<body>
			
					Hi,<br /><br />
					To help us improve, we would like to ask you a few questions about your experience so far. It will only take one minute, and your answer will help us make our services even better for you.
					<br /><br />
					<table class="tablecontent">
						<tr>
							<th>OCSS Reference Number</th>
							<th>Service Provided</th>
							<th>Service Provided by</th>
							<th>Acknowledgement Date</th>
							<th>Completion Date</th>
						</tr>
						<tr>
							<td>'.$paramservices[0]['ReferenceNumber'].'</td>
							<td>'.$paramservices[0]['ServiceName'].'</td>
							<td>'.$paramservices[0]['Office'].'</td>
							<td>'.$paramservices[0]['StartTransaction'].'</td>
							<td>'.$paramservices[0]['CloseTransaction'].'</td>
						</tr>
					</table>
					<p><b>Reminder:</b> Please complete this survey on or before <b>'.$paramservices[0]['ExpirationDate'].'</b>.</p>
					<div style="text-align:center;">
						<a href="'.$paramlink.'" target="_BLANK" class="btn btn-primary btn-block btn-flat" style="text-decoration: none !important; padding:5px !important; border-radius:5px !important; ">Evaluate the Service</a>
					</div>
					<br /><br /><br />
					Thanks,<br />
					<b>OCSS Team  </b>
					<br />
					<br />
					<div style="text-align:center; color:#990000;">
						<i>This is a system-generated notification. Do not reply to this email</i>
					</div>
				</body>
			</html>
		';
		return $template;
	}
	
	
	function feedbackemailtemplate($paramservices,$content)
	{
		try
		{
			$template ='<html>
				<head>
					<meta charset="UTF-8">

					<style>
						table
						{ 
							margin-left: auto;
							margin-right: auto;
						}
											
						.tablecontent
						{
							border-collapse: collapse;

						}
						
						.tablecontent th,td
						{
							width:300px; 
							text-align:center;
						}
						
						table, td, th 
						{
						  border: 1px solid black;
						}
						
					</style>
				
				</head>
				<body>
					<table class="tablecontent">
						<tr>
							<th>OCSS Reference Number</th>
							<th>Service Requested</th>
							<th>Service Provided by</th>
						</tr>
						<tr>
							<td>'.$paramservices['ReferenceNumber'].'</td>
							<td>'.$paramservices['ServiceName'].'</td>
							<td>'.$paramservices['Office'].'</td>
						</tr>
					</table><br /><br />
			
					<div style="text-align:justify;">'.$content.'</div>
			
					<br /><br />
					<div style="text-align:center; color:#990000;">
						<i>This is a system-generated notification. Do not reply to this email</i>
					</div>
				</body>
			</html>
					';
			
			return $template;
		}
		catch (Exception $e) 
		{
			return $e->getMessage();
		}
	}
	
	function internalemailtemplate($paramlink,$paramservices)
	{

		$template ='
			<html>
				<head>
					<meta charset="UTF-8">
					<style>
					.btn {
						width:300px;
						display: inline-block;
						font-weight: 400;
						color: #212529;
						text-align: center;
						vertical-align: middle;
						cursor: pointer;
						-webkit-user-select: none;
						-moz-user-select: none;
						-ms-user-select: none;
						user-select: none;
						background-color: transparent;
						border: 1px solid transparent;
						padding: .375rem .75rem;
						font-size: 1rem;
						line-height: 1.5;
						border-radius: .25rem;
						transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
						
					}
					
					.btn.btn-flat {
						border-radius: 0;
						border-width: 1px;
						box-shadow: none;
					}
					
					
					.btn-primary 
					{
						color: #fff;
						background-color: #007bff;
						border-color: #007bff;
						box-shadow: none;
					}
					
					.tablecontent
					{
						border-collapse: collapse;

					}
					
					.tablecontent th,td
					{
						width:300px; 
						text-align:center;
					}
					
					table, td, th 
					{
					  border: 1px solid black;
					}
					
				</style>
			</head>
			<body>
			
			Hi,<br /><br />
			To help us improve, we would like to ask you a few questions about your experience so far. It will only take one minute, and your answer will help us make our services even better for you.
			<br /><br />
			
			<table class="tablecontent">
				<tr>
					<th>OCSS Reference Number</th>
					<th>Service Provided</th>
					<th>Service Provided by</th>
					<th>Acknowledgement Date</th>
					<th>Completion Date</th>
				</tr>
				<tr>
					<td>'.$paramservices['ReferenceNumber'].'</td>
					<td>'.$paramservices['ServiceName'].'</td>
					<td>'.$paramservices['Office'].'</td>
					<td>'.$paramservices['StartTransaction'].'</td>
					<td>'.$paramservices['CloseTransaction'].'</td>
				</tr>
			</table>
			<p><b>Reminder:</b> Please complete this survey on or before <b>'.$paramservices['ExpirationDate'].'</b>.</p>
			<div style="text-align:center;">
				<a href="'.$paramlink.'" target="_BLANK" class="btn btn-primary btn-block btn-flat" style="text-decoration: none !important; padding:5px !important; border-radius:5px !important; ">Evaluate the Service</a>
			</div>
			<br /><br /><br />
			Thanks,<br />
			<b>OCSS Team  </b>
			<br /><br />
			<div style="text-align:center; color:#990000;">
				<i>This is a system-generated notification. Do not reply to this email</i>
			</div>
			</body>
		</html>
		';
		
		return $template;
	}
	
	
	function loancomputation($parambranch,$paramdate,$paramamount,$parampassbook)
	{
		$CI=&get_instance();
		$CI->load->model('tools_model');
		
		$result=null;
		$servicecharge=0;
		$startdate = $paramdate;
		$paramamount=(trim($paramamount)=='' ? 0 : trim($paramamount));
		$parampassbook=(trim($parampassbook)=='' || trim($parampassbook)< '1'  ? 0 : trim($parampassbook));
		//$paramadvancepayment=(trim($paramadvancepayment)=='' || trim($paramadvancepayment)< '1'  ? 0 : $paramadvancepayment);
		
		$date_due = date("Y-m-d", strtotime($startdate . " + 60 days"));
		$numberholiday=$CI->tools_model->getnumberofholidays($parambranch,$startdate,$date_due);
		$queryresult=$CI->tools_model->getnumberofholidays($parambranch,$startdate,$date_due);
		
		if ($paramamount>0 && trim($paramamount)!='' && $parambranch!='')
		{
			$scresult=$CI->tools_model->getservicechargebybranchamount($parambranch,$paramamount);
			if ($scresult)
			{
				$servicecharge=$scresult[0]['servicechargeamount'];
			}
		}

		$result['dailydues'] =(($paramamount + ($paramamount * .20)) / 60);
		$result['interest'] = ($paramamount * .20);
		$result['formatamount'] = 'Php '.number_format($paramamount, 2, '.', ',');
		$result['duedate']=$date_due ;
		$result['count']=$queryresult;
		$result['servicecharge'] = ($paramamount<1000 ? 50 : $servicecharge);
		$result['specialpayment'] = ($result['dailydues'] * $numberholiday);
		
		if ($paramamount>0 && trim($paramamount)!='' && $parambranch!='')
		{
			$result['totalamountrelease'] = $paramamount - ($result['servicecharge'] + $parampassbook);
		}
		else
		{
			$result['totalamountrelease'] = null;
		}
		
		return $result;
		
		

	}
	
	function externalemailtemplate($paramlink,$paramservices)
	{

		$template ='<html>
				<head>
				<meta charset="UTF-8">
				<style>
					.btn {
						width:300px;
						display: inline-block;
						font-weight: 400;
						color: #212529;
						text-align: center;
						vertical-align: middle;
						cursor: pointer;
						-webkit-user-select: none;
						-moz-user-select: none;
						-ms-user-select: none;
						user-select: none;
						background-color: transparent;
						border: 1px solid transparent;
						padding: .375rem .75rem;
						font-size: 1rem;
						line-height: 1.5;
						border-radius: .25rem;
						transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
						
					}
					
					.btn.btn-flat {
						border-radius: 0;
						border-width: 1px;
						box-shadow: none;
					}
					
					
					.btn-primary 
					{
						color: #fff;
						background-color: #007bff;
						border-color: #007bff;
						box-shadow: none;
					}
					
					.tablecontent
					{
						border-collapse: collapse;
						margin-left: auto;
						margin-right: auto;
					}
					
					.tablecontent th,td
					{
						width:300px; 
						text-align:center;
					}
					
					table, td, th 
					{
					  border: 1px solid black;
					}
					
				</style>
			</head>
			<body>
			
				Hi,<br /><br />
				To help us improve, we\'d like to ask you a few questions about your experience so far. It will take less than a minute and your answer will help us make our services even better for you.
				<br /><br />
				<table class="tablecontent">
					<tr>
						<th>Reference Number</th>
						<th>Service Provided</th>
						<th>Service Provided by</th>
					</tr>
					<tr>
						<td>'.$paramservices['ReferenceNumber'].'</td>
						<td>'.$paramservices['ServiceName'].'</td>
						<td>'.$paramservices['Office'].'</td>
					</tr>
				</table>
				<p><b>Reminder:</b> Please complete this survey on or before <b>'.$paramservices['ExpirationDate'].'</b>.</p>
				<div style="text-align:center;">
					<a href="'.$paramlink.'" target="_BLANK" class="btn btn-primary btn-block btn-flat" style="text-decoration: none !important; padding:5px !important; border-radius:5px !important; ">Evaluate the Service</a>
				</div>
				<br /><br /><br />
				Thanks,<br />
				<b>OCSS Team  </b>
				<br /><br />
				<div style="text-align:center; color:#990000;">
					<i>This is a system-generated notification. Do not reply to this email</i>
				</div>
			</body>
		</html>	
		';
		
		return $template;
	}
	
	function checkDateFormat($date) 
	{
		if (!empty(trim($date)))
		{
			if (strlen($date)>10)
			{
				return false;
			}
			if(checkdate(substr($date, 5, 2), substr($date, 8, 2), substr($date, 0, 4)))
			{
				return true;
			}
			else
			{
				return false;
			}

		}
		else
		{
			return true;
		}
	}
	
	function expensesperdatebranch($branch,$date)
	{
		$CI =& get_instance();
		$CI->load->model('transaction_model');
		$result=$CI->transaction_model->getexpensesbybranchdate($branch,$date);
		return $result[0]['expenses'];
	}
	
	function remittanceperdatebranch($branch,$date)
	{
		$CI =& get_instance();
		$CI->load->model('transaction_model');
		$result=$CI->transaction_model->getremittancebybranchdate($branch,$date);
		return $result[0]['amount'];
	}
	
	
	function summarycollectionsperday($branch,$date)
	{
		$CI =& get_instance();
		$CI->load->model('report_model');
		$list=$CI->report_model->getsummarycollectionsperday($branch,$date);
		
		$totalcollection=0;

		if ($list)
		{
			foreach($list as $row)
			{
				$totalcollection +=$row['totaldailydues'];
			}
		}
		
		return $totalcollection;
		
	}
	
	
	
	
	function loanreleasedamountbybranchdate($branch,$date)
	{
		$CI =& get_instance();
		$CI->load->model('loan_model');
		$result=$CI->loan_model->getloansbybranchdate($branch,$date);
		return $result[0]['amountreleased'];
	}
	
	function loansservicechargebybranchdate($branch,$date)
	{
		$CI =& get_instance();
		$CI->load->model('transaction_model');
		$result=$CI->transaction_model->getloansservicechargebybranchdate($branch,$date);
		return $result[0]['amount'];
	}
	
	function loanspassbookchargebybranchdate($branch,$date)
	{
		$CI =& get_instance();
		$CI->load->model('transaction_model');
		$result=$CI->transaction_model->getloanspassbookchargebybranchdate($branch,$date);
		return $result[0]['amount'];
	}
	
	
	
	// function transactionamountperdate($date)
	// {
		// $CI =& get_instance();
		// $CI->load->model('transaction_model');
		// $result=$CI->transaction_model->gettranscationamountbydate($date);
		// $amount=0;
		// if($result)
		// {
			// foreach($result as $row)
			// {
				// $amount += $row['amountreceived']-$row['paymentamount'];
			// }
		// }
	
		// return $amount;
	// }
	
	
	function echodie($param) 
	{
		echo '<pre>';
		print_r($param);
		echo '</pre>';
		die();
	}
	
	
	
	
	/*----------------------------------------------------------*/
	
	function to_date($date) 
	{
		return date("Y-m-d", strtotime($date));
	}
	
	function no_of_days_to_be_paid($first, $last) 
	{
		$first = strtotime($first);
		$last = strtotime($last);

		$timeDiff = abs($last - $first);
		$numberDays = $timeDiff/86400;  // 86400 seconds in one day
		return intval($numberDays);
	}
}