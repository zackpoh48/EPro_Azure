<table style="
    border: 1px solid #eee;
    width: 80%;
    margin: 0 auto;
    font-family: 'Roboto', sans serif;
  " cellspacing="0">
  <thead style="background: #f8f9fa; margin: 0px; padding: 0px">
    <tr style="margin: 0px; padding: 0px">
      <th style="border: 0px solid #eee; margin: 0px; padding: 0px; width: 30%">
        <a href="!#" style="display: inline-block">
          <img src="{{url(env('APP_COMPANY_LOGO'))}}" alt="Logo" class="img-fluid" style="max-height: 60px" />
        </a>
      </th>
      <th style="border: 0px solid #eee; margin: 0px; padding: 0px" colspan="2">
        <h4 style="font-size: 21px">Vendor Registration Approval</h4>
      </th>
      <th style="border: 0px solid #eee; margin: 0px; padding: 0px; width: 30%">
        <h4 style="font-size: 16px"></h4>
      </th>
    </tr>
  </thead>
  <tbody style="margin: 0px; padding: 0px">
    <tr style="margin: 0px; padding: 0px">
      <td style="margin: 0px; padding: 0px" colspan="4">
        <table style="margin: 0px; padding: 20px">
          <tr style="margin: 0px; padding: 0px">
            <td style="margin: 0px; padding: 0px" colspan="4">
              <div style="width: 100%">
                <p style="color: #6c757d; margin: 0 0 10px 0px; font-size: 16px">
                  Dear Sir/Madam
                </p>
                <p style="color: #6c757d; margin: 0 0 10px 0px; font-size: 16px">
                  You have received new Vendor Registration details for review.
                  Please find the information below:
                </p>

                <p style="color: #6c757d; margin: 0 0 10px 0px; font-size: 16px">
                  Vendor No: {{ $details['vendor_no'] }}<br />
                  Company: {{ $details['company_name'] }}<br />
                  Name: {{ $details['name'] }}<br />
                  Address:{{ $details['address'] }}<br />
                  Username: {{ $details['username']}}
                </p>

                <p style="color: #6c757d; margin: 0 0 20px 0px; font-size: 16px">
                  Please review the provided details and take necessary action
                  for approval or rejection of the vendor registration. You can
                  access the vendor profile and make a decision by clicking on
                  the respective buttons below:
                </p>
                <div style="
                    display: flex;
                    flex-direction: row;
                    flex-wrap: wrap;
                    justify-content: space-evenly;
                    padding: 16px;
                  ">
                  <a href="{{ env('APP_URL') }}/update-status/4/{{$details['unique_id']}}" target="_blank" style="
                      color: white;
                      background-color: green;
                      border: 0;
                      padding: 16px 12px;
                      border-radius: 4px;
                      width: 33%;
                      display: flex;
                      text-align: center;
                      align-items: center;
                      text-decoration: none;
                      max-width: 200px;
                      margin: 12px;
                    ">
                    Approve Vendor Registration
                  </a>
                  <a href="{{ env('APP_URL') }}/update-status/3/{{$details['unique_id']}}" target="_blank" style="
                      color: white;
                      background-color: red;
                      border: 0;
                      padding: 16px 12px;
                      border-radius: 4px;
                      width: 33%;
                      display: flex;
                      text-align: center;
                      align-items: center;
                      text-decoration: none;
                      max-width: 200px;
                      margin: 12px;
                    ">
                    Reject Vendor Registration
                  </a>
                </div>
                <p style="color: #6c757d; margin: 0 0 5px 0px; font-size: 16px">
                  If approved, the user will be granted access to the system's
                  dashboard.
                </p>

                <p style="color: #6c757d; margin: 0 0 5px 0px; font-size: 16px">
                  If you have any questions or require further information,
                  please feel free to reach out to us.
                </p>

                <p style="color: #6c757d; margin: 0 0 5px 0px; font-size: 16px">
                  Thank you for your attention to this matter.
                </p>
                <br />
                <br />
                <p style="color: #6c757d; margin: 0 0 5px 0px; font-size: 16px">
                  Best regards,<br />
                  Your Online System
                </p>
                <p></p>

                <p style="color: #6c757d; margin: 0 0 20px 0px; font-size: 16px">
                  <i>This is an automated email, please do not reply. Replies to
                    this message are routed to an unmonitored mailbox.</i>
                </p>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </tbody>
</table>