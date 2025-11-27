<!DOCTYPE html>
<html lang="en">

<head>
	<title>Email Template</title>
	<meta charset="utf-8">
</head>

<body>
	<table style="border:1px solid #eee; width:80%; margin:0 auto; font-family:'Roboto', sans serif;" cellspacing="0">
		<thead style="background:#f8f9fa;margin:0px; padding:0px;">
			<tr style="margin:0px; padding:0px;">
				<th style="border:0px solid #eee;  margin:0px; padding:0px; width: 30%">
					<a href="{{url(env('APP_URL'))}}" style="display:inline-block">
						<img src="{{url(env('APP_URL')).env('APP_COMPANY_LOGO')}}" alt="Logo" class="img-fluid" style="max-height:60px">
					</a>
				</th>
				<th style="border:0px solid #eee; margin:0px; padding:0px;" colspan="2">
					<h4 style="font-size:21px;">Supplier Registration Form</h4>
				</th>
				<th style="border:0px solid #eee; margin:0px; padding:0px; width: 30%">
					<h4 style="font-size:16px;">SRF/2025/001</h4>
				</th>
			</tr>
		</thead>
		<tbody style="margin:0px; padding:0px;">
			<tr style="margin:0px; padding:0px;">
				<td style="margin:0px; padding:0px;" colspan="4">
					<table style="margin:0px; padding:20px;">
						<tr style="margin:0px; padding:0px;">
							<td style="margin:0px; padding:0px;">
								<h6 style="font-size:16px; color:#6c757d;margin:0;font-family:'Roboto', sans serif;">Our Ref</h6>
							</td>
							<td style="margin:0px; padding:0px;" colspan="3">
								<h4 style="font-size:16px; color:#6c757d;margin:0;padding:0px;font-family:'Roboto', sans serif;">{{ $details['reference'] }}</h4>
							</td>
						</tr>
						<tr>
							<td style="margin:0px; padding:0px;">
								<h6 style="font-size:16px; color:#6c757d;margin:0;padding:0px;font-family:'Roboto', sans serif;">Date</h6>
							</td>
							<td style="margin:0px; padding:0px;" colspan="3">
								<h4 style="font-size:16px; color:#6c757d;margin:0;padding:0px;font-family:'Roboto', sans serif;">{{ date("d F Y") }}</h4>
							</td>
						</tr>
						<tr style="margin:0px; padding:0px;">
							<td style="margin:0px; padding:0px;">
								<h6 style="font-size:16px; color:#6c757d;margin:0;padding:0px;font-family:'Roboto', sans serif;">Company Name</h6>
							</td>
							<td style="margin:0px; padding:0px;" colspan="3">
								<h4 style="font-size:16px; color:#6c757d;margin:0;padding:0px;font-family:'Roboto', sans serif;">{{ $details['company_name'] }}</h4>
							</td>
						</tr>
						<tr style="margin:0px; padding:0px;">
							<td style="margin:0px; padding:0px;">
								<h6 style="font-size:16px; color:#6c757d;margin:0;padding:0px;font-family:'Roboto', sans serif;">Attn</h6>
							</td>
							<td style="margin:0px; padding:0px;" colspan="3">
								<h4 style="font-size:16px; color:#6c757d;margin:0;padding:0px;font-family:'Roboto', sans serif;">{{ $details['person_name'] }}</h4>
							</td>
						</tr>
						<tr style="height:20px;margin:0px;padding:0px">
							<td colspan="4"></td>
						</tr>
						<tr style="margin:0px; padding:0px;">
							<td style="margin:0px; padding:0px;" colspan="4">
								<div style="width:100%">
									<p style="color:#6c757d;margin:0 0 10px 0px;font-size:16px;">Dear Sir/Madam</p>
									<h6 style="color:#343a40;margin:0 0 10px 0px;font-size:18px;">Re: Registration As {{
												env('APP_COMPANY_NAME') }} Approved Supplier</h6>
									<p style="color:#6c757d;margin:0 0 10px 0px;font-size:16px;">Please be informed that all Suppliers who are interested to participate in our projects are required to register with us. As such, you are required to complete the following sections and submit relevant documents for our evaluation prior to the registration. Kindly refer to our website via link:
										<a href="{{ env('APP_URL') }}/register/{{ $details['unique_id'] }}">Registration Link.</a> Then enter your business registration no. (without spaces and dash) to continue.
									</p>

									<p style="color:#6c757d;margin:0 0 10px 0px;font-size:16px;">Thank You</p>

									<p style="color:#6c757d;margin:0;font-size:16px;">Your Faithfully,</p>
									<p style="color:#343a40;margin:0;text-transform:uppercase;font-size:16px;"><b>{{ env('APP_COMPANY_NAME') }}</b></p>
									<p style="color:#6c757d;margin:0 0 10px 0px;font-size:16px;">Purchasing Department
									<p>

									<p style="color:#6c757d;margin:0 0 20px 0px;font-size:16px; "><i>This is computer generated signature is not required</i></p>
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</body>

</html>