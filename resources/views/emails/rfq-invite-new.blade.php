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
                        <img src="{{ $details->org_logo}}" alt="Logo" class="img-fluid" style="max-height:60px">
                    </a>
                </th>
                <th style="border:0px solid #eee; margin:0px; padding:0px;" colspan="2">
                    <h4 style="font-size:21px;">Request for Quotation (RFQ)</h4>
                </th>
                <th style="border:0px solid #eee; margin:0px; padding:0px; width: 30%">
                    <h4 style="font-size:16px;"></h4>
                </th>
            </tr>
        </thead>
        <tbody style="margin:0px; padding:0px;">
            <tr style="margin:0px; padding:0px;">
                <td style="margin:0px; padding:0px;" colspan="4">
                    <table style="margin:0px; padding:20px;">
                        <tr>
                            <td style="margin:0px; padding:0px;">
                                <h6 style="font-size:16px; color:#6c757d;margin:0;padding:0px;font-family:'Roboto', sans serif;">
                                    Date</h6>
                            </td>
                            <td style="margin:0px; padding:0px;" colspan="3">
                                <h4 style="font-size:16px; color:#6c757d;margin:0;padding:0px;font-family:'Roboto', sans serif;">
                                    {{ date("d F Y") }}
                                </h4>
                            </td>
                        </tr>
                        <tr style="height:20px;margin:0px;padding:0px">
                            <td colspan="4"></td>
                        </tr>
                        <tr style="margin:0px; padding:0px;">
                            <td style="margin:0px; padding:0px;" colspan="4">
                                <div style="width:100%">
                                    <p style="color:#6c757d;margin:0 0 10px 0px;font-size:16px;">Dear Sir/Madam</p>
                                    <h6 style="color:#343a40;margin:0 0 10px 0px;font-size:18px;">Project Title: {{
											$details->tender_title }}</h6>
                                    <p style="color:#6c757d;margin:0 0 10px 0px;font-size:16px;">{{
											env('APP_COMPANY_NAME') }} would like to invite you to participate in the
                                        Request for Quotation (RFQ) of the following project:</p>

                                    <table style="margin:0px 0px 20px;padding:0px;width:100%;border:1px solid #eee" cellspacing="0">
                                        <tr style="margin:0px; padding:0px;">
                                            <th style="margin:0px; padding:20px;background-color: #eee;text-align: left;border:1px solid #e0e0e0;
													color:#6c757d;">
                                                Description
                                            </th>
                                            <th style="margin:0px; padding:20px;text-align: left;background-color: #eee;border:1px solid #e0e0e0;color:#6c757d;">
                                                Open Date
                                            </th>
                                            <th style="margin:0px; padding:20px;text-align: left;background-color: #eee;border:1px solid #e0e0e0;
													color:#6c757d;">
                                                Closing Date
                                            </th>
                                        </tr>
                                        <tr style="margin:0px; padding:0px;">
                                            <td style="margin:0px; padding:20px;">
                                                <p style="text-transform: uppercase; margin:0px 0px 10px; padding:0px">
                                                    <b>{{$details->tender_title }}</b>
                                                </p>
                                                <p style="margin:0px 0px 5px; padding:00px;color:#6c757d;">
                                                    {{ $details->buyer_remarks }}
                                                </p>
                                            </td>
                                            <td style="margin:0px; padding:20px;">
                                                <p style="margin:0px 0px 10px; padding:0px;color:#6c75d;">{{ date('l, d F Y',strtotime($details->date_of_rfq)) }}</p>
                                            </td>
                                            <td style="margin:0px; padding:20px;">
                                                <p style="margin:0px 0px 10px; padding:0px;color:#6c757d;">
                                                    {{ date('l, d F Y',strtotime($details->date_of_expiry)) }}
                                                </p>
                                            </td>
                                        </tr>
                                    </table>

                                    <p style="color:#6c757d;margin:0 0 20px 0px;font-size:16px;">Information on the
                                        project and method of proposal submission can be uploaded at online portal.
                                    </p>
                                    <p style="color:#6c757d;margin:0 0 5px 0px;font-size:16px;">Login URL: <a href="{{ env('APP_URL') }}">{{ env('APP_URL') }}</a> </p>
                                    <p style="color:#6c757d;margin:0 0 5px 0px;font-size:16px;">RFQ ID: <span style="font-weight: bold;">{{ $details->rfq_id }}</span></p>
                                    <p style="color:#6c757d;margin:0 0 10px 0px;font-size:16px;">All proposals must
                                        be delivered in accordance with the instructions as contained in the RFP
                                        document.</p>
                                    <p style="color:#6c757d;margin:0 0 20px 0px;font-size:16px;">For further
                                        enquiries, please contact {{ env('APP_COMPANY_ENQUIRY') }}</p>
                                    <p style="color:#6c757d;margin:0 0 10px 0px;font-size:16px;">Thank You</p>

                                    <p style="color:#6c757d;margin:0;font-size:16px;">Your Faithfully,</p>
                                    <p style="color:#343a40;margin:0;text-transform:uppercase;font-size:16px;"><b>{{
												env('APP_COMPANY_NAME') }}</b></p>
                                    <p style="color:#6c757d;margin:0 0 10px 0px;font-size:16px;">Purchasing
                                        Department
                                    <p>

                                    <p style="color:#6c757d;margin:0 0 20px 0px;font-size:16px; ">
                                        <i>This is an automated email, please do not reply. Replies to this message
                                            are routed to an unmonitored mailbox.</i>
                                    </p>
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