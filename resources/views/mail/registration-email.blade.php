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
        <h4 style="font-size: 21px">Registration</h4>
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
                  You have successfully initialized your registration with us.
                  Please find the login credentials below to complete your
                  registration details:
                </p>

                <p style="color: #6c757d; margin: 0 0 10px 0px; font-size: 16px">
                  Username: {{ $details['username'] }} <br />
                  Vendor No: {{ $details['vendor_no'] }}<br />
                  Password:{{ $details['password'] }}<br />
                </p>
                <a href="{{ env('APP_URL') }}/sign-in" target="_blank" style="
                    color: white;
                    background-color: #536de6;
                    border: 0;
                    padding: 16px 12px;
                    border-radius: 4px;
                    margin: 12px;
                    width: 40%;
                    display: block;
                    text-align: center;
                    text-decoration: none;
                    max-width: 200px;
                  ">
                  Login
                </a>

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
                <hr />
                <p>
                  <small style="color: #6c757d; margin: 0 0 5px 0px">
                    If you're having trouble clicking the "Reset Password"
                    button, copy and paste the URL below into your web browser:
                    <a href="{{ env('APP_URL') }}/sign-in">{{ env('APP_URL') }}/sign-in</a>
                  </small>
                </p>

                <small style="color: #6c757d; margin: 0 0 20px 0px">
                  <i>This is an automated email, please do not reply. Replies to
                    this message are routed to an unmonitored mailbox.</i>
                </small>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </tbody>
</table>