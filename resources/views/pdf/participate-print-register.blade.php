<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PDF Document</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" />
    <!-- Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .page-break {
            page-break-after: avoid;
        }

        .padding-t-20 {
            margin-top: 30px;
        }

        .doc-container .pdf-document-wrapper {
            /* width: 750px;
         margin: auto; */
            width: 800px;
            max-width: 95%;
            margin: auto;
            font-family: sans-serif;
            font-size: 13px;
            padding: 10px;
            margin: 10px;
        }

        .document-content {
            padding-left: 20px;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .document-content>ol>li::marker {
            font-weight: bold;
        }

        .document-content>ol>li label.section-heading {
            font-weight: bold;
            display: inline-block;
        }

        .check-container {
            box-sizing: border-box;
            display: inline-block;
        }

        .check-container input[type="checkbox"] {
            box-sizing: border-box;
            width: 20px;
            height: 20px;
            vertical-align: middle;
        }

        .colon-separator {
            float: right;
        }

        .text-empty {
            width: 100%;
            border: none;
            border-bottom: 1px solid #000;
            height: 20px;
            display: inline-block;
        }

        .text-filled {
            width: 100%;
            border: none;
            border-bottom: 1px solid #000;
            display: inline-block;
            word-break: break-all;
        }

        .roman-number {
            margin-right: 10px;
            margin-bottom: 5px;
            height: 22px;
            display: inline-block;
            font-size: 16px;
        }

        .width-5 {
            width: 5%;
        }

        .width-10 {
            width: 10%;
        }

        .width-20 {
            width: 20%;
        }

        .width-22 {
            width: 22%;
        }

        .width-25 {
            width: 25%;
        }

        .width-27 {
            width: 27%;
        }

        .width-40 {
            width: 40%;
        }

        .width-70 {
            width: 70%;
        }

        .width-50 {
            width: 50%;
        }

        .width-75 {
            width: 75%;
        }

        .width-80 {
            width: 80%;
        }

        .width-100 {
            width: 100%;
        }

        .text-center {
            text-align: center;
        }

        .padding-10 {
            padding: 10px;
        }

        table {
            margin-bottom: 15px;
        }

        p {
            margin-top: 15px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="doc-container">
        <div class="pdf-document-wrapper">
            <table class="width-100" style="border:1px solid #000">
                <tr>
                    <td class="width-40 padding-10" style="border:1px solid #000"><img src="{{public_path($image_path)}}" alt="icon" style="width:30px;" /></td>
                    <td class="width-100 text-center padding-10" style="border:1px solid #000">
                        <h2>SUPPLIER REGISTRATION FORM</h2>
                    </td>
                    <td class="width-40 text-center padding-10" style="border:1px solid #000">
                        <p>SRF/2025/001</p>
                    </td>
                </tr>
            </table>
            <table class="width-100">
                <tr>
                    <td class="padding-10">
                        <label class="check-container">
                            <input type="checkbox" />
                            (Please tick whichever applicable)
                        </label>
                    </td>
                </tr>
            </table>
            <div class="document-content">
                <ol type="A" style="margin: 0;padding: 0;box-sizing: border-box;">
                    <li>
                        <label class="section-heading">ORGANIZATION PARTICULAR</label>
                        <table class="width-100 list-style">
                            <tr>
                                <td class="width-25 padding-10">Name of Company <span class="colon-separator">:</span></td>
                                @if(isset($company_name))
                                <td class="width-75  padding-10"><input type="text" class="text-filled" value="{!! $company_name !!}"></td>
                                @else
                                <td class="width-75  padding-10"><input type="text" class="text-empty"></td>
                                @endif
                            </tr>
                            <tr>
                                <td class="width-25  padding-10">(Company Reg. No. <span class="colon-separator">:</span></td>
                                <td class="width-70  padding-10"><input type="text" class="text-empty" value="{!! $company_reg_no !!}"></td>
                                <td class="width-5  padding-10">)</td>
                            </tr>
                        </table>
                        <table class="width-100 list-style">
                            <tr>
                                <td class="width-25 padding-10">Registered Address <span class="colon-separator">:</span></td>
                                <td class="width-75  padding-10"><input type="text" class="text-empty" value="{!! $registered_address_one !!}"></td>
                            </tr>
                            <tr>
                                <td class="width-25 padding-10"></td>
                                <td class="width-75  padding-10"><input type="text" class="text-empty" value="{!! $registered_address_two !!}"></td>
                            </tr>
                        </table>
                        <table class="width-100 list-style">
                            <tr>
                                <td class="width-25 padding-10">Mailing Address <span class="colon-separator">:</span></td>
                                <td class="width-75  padding-10"><input type="text" class="text-empty" value="{!! $mailing_address_one !!}, {!! $mailing_address_two !!}"></td>
                            </tr>
                            <tr>
                                <td class="width-25 padding-10"></td>
                                <td class="width-75  padding-10"><input type="text" class="text-empty" value="{!! $zip_code !!} {!! $city !!}, {!! $state !!} {!! $country !!}"></td>
                            </tr>
                        </table>
                        <table class="width-100 list-style">
                            <tr>
                                <td class="width-25 padding-10">Tel No. <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><input type="text" class="text-empty" value="{!! $tel_no !!}"></td>
                                <td class="width-25 padding-10">Fax No. <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><input type="text" class="text-empty" value="{!! $fax_no !!}"></td>
                            </tr>
                        </table>
                        <table class="width-100 list-style">
                            <tr>
                                <td class="width-25 padding-10">Company Website <span class="colon-separator">:</span></td>
                                <td class=" padding-10"><input type="text" class="text-empty" value="{!! $company_website !!}"></td>
                            </tr>
                        </table>
                        <table class="width-100 list-style">
                            <tr>
                                <td class="width-25 padding-10">Web Portal Email Address <span class="colon-separator">:</span></td>
                                <td class=" padding-10"><input type="text" class="text-empty" value="{!! $email !!}"></td>
                            </tr>
                        </table>
                         <table class="width-100 list-style">
                            <tr>
                                <td class="width-25 padding-10">Email Address <span class="colon-separator">:</span></td>
                                <td class=" padding-10"><input type="text" class="text-empty" value="{!! $registered_email_address !!}"></td>
                            </tr>
                        </table>
                        <table class="width-100 list-style">
                            <tr>
                                <td class="width-25 padding-10">Type of Company <span class="colon-separator">:</span></td>
                                <td class="width-25 padding-10">
                                    <label class="check-container">
                                        @if($type_of_company=='Sole Proprietor')
                                        <input type="checkbox" checked>
                                        @else
                                        <input type="checkbox">
                                        @endif
                                        Sole Proprietor
                                    </label>
                                </td>
                                <td class="width-25 padding-10">
                                    <label class="check-container">
                                        @if($type_of_company=='Partnership')
                                        <input type="checkbox" checked>
                                        @else
                                        <input type="checkbox">
                                        @endif
                                        Partnership
                                    </label>
                                </td>
                                <td class="width-25 padding-10">
                                    <label class="check-container">
                                        @if($type_of_company=='Private Limited')
                                        <input type="checkbox" checked>
                                        @else
                                        <input type="checkbox">
                                        @endif
                                        Private Limited
                                    </label>
                                </td>
                            <tr>
                        </table>
                        <table class="width-100 list-style">
                            <tr>
                                <td class="width-25 padding-10"></td>
                                <td class="width-25 padding-10">
                                    <label class="check-container">
                                        @if($type_of_company=='Public Listed')
                                        <input type="checkbox" checked>
                                        @else
                                        <input type="checkbox">
                                        @endif
                                        Public Listed
                                    </label>
                                </td>
                                <td class="width-27 padding-10">
                                    <label class="check-container">
                                        @if($type_of_company=='Others (Please Specify)')
                                        <input type="checkbox" checked>
                                        @else
                                        <input type="checkbox">
                                        @endif
                                        Others (Please Specify)
                                    </label>
                                </td>
                                <td class="width-20  padding-10"><input type="text" class="text-empty" value="{!! $type_of_company_other !!}"></td>
                                <td class="width-3  padding-10">)</td>
                            </tr>
                        </table>
                        <table class="width-100 list-style">
                            <tr>
                                <td class="width-25 padding-10">Date of Incorporation <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><input type="text" class="text-empty" value="{{ date('d M,Y',strtotime($date_of_incorporation))}}"></td>
                                <td class="width-25 padding-10"></td>
                                <td class="width-25 padding-10"></td>
                            </tr>
                            <tr>
                                <td class="width-25 padding-10">SST Registration No. <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><input type="text" class="text-empty" value="{!! $sst_registration_no !!}"></td>
                                <td class="width-25 padding-10"></td>
                                <td class="width-25 padding-10"></td>
                            </tr>
                        </table>
                        <table class="width-100 list-style">
                            <tr>
                                <td class="width-25 padding-10">Contact Person <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><span class="roman-number">i</span><input type="text" class="text-empty" value="{!! $contact_person_one !!}"></td>
                                <td class="width-25  padding-10"><span class="roman-number">ii</span><input type="text" class="text-empty" value="{!! $contact_person_two !!}"></td>
                                <td class="width-25  padding-10"><span class="roman-number">iii</span><input type="text" class="text-empty" value="{!! $contact_person_three !!}"></td>
                            </tr>
                            <tr>
                                <td class="width-25 padding-10">Designation <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><span class="roman-number">i</span><input type="text" class="text-empty" value="{!! $designation_one !!}"></td>
                                <td class="width-25  padding-10"><span class="roman-number">ii</span><input type="text" class="text-empty" value="{!! $designation_two !!}"></td>
                                <td class="width-25  padding-10"><span class="roman-number">iii</span><input type="text" class="text-empty" value="{!! $designation_three !!}"></td>
                            </tr>
                        </table>
                    </li>
                    <div class="page-break"></div>
                    <p>*Note : Please attach your Company Profile (including certified true copy of Form 9, 24, 49 / SSM Certificate)</p>
                    <div class="padding-t-20"></div>
                    <li>
                        <label class="section-heading">BANKING INFORMATION</label>
                        <table class="width-100">
                            <tr>
                                <td class="width-25 padding-10">Bank Name <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><input type="text" class="text-empty" value="{!! $bank_name !!}"></td>
                                <td class="width-25 padding-10">Swift Code <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><input type="text" class="text-empty" value="{!! $swift_code !!}"></td>
                            </tr>
                            <tr>
                                <td class="width-25 padding-10">Branch Name <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><input type="text" class="text-empty" value="{!! $bank_branch !!}"></td>
                                <td class="width-25 padding-10">Bank Account No <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><input type="text" class="text-empty" value="{!! $bank_account_no !!}"></td>
                            </tr>
                        </table>
                    </li>
                    <!-- Product  -->
                    <!-- Creditr TErm Offers -->
                    <li>
                        <label class="section-heading">CREDIT TERM OFFERED</label>
                        <table class="width-100">
                            <tr>
                                <td class="width-25 padding-10">
                                    <label class="check-container">
                                        @if($credit_term_offered=='30 days')
                                        <input type="checkbox" checked>
                                        @else
                                        <input type="checkbox">
                                        @endif
                                        30 Days
                                    </label>
                                </td>
                                <td class="width-25 padding-10">
                                    <label class="check-container">
                                        @if($credit_term_offered=='60 days')
                                        <input type="checkbox" checked>
                                        @else
                                        <input type="checkbox">
                                        @endif
                                        60 Days
                                    </label>
                                </td>
                                <td class="width-25 padding-10">
                                    <label class="check-container">
                                        @if($credit_term_offered=='90 days')
                                        <input type="checkbox" checked>
                                        @else
                                        <input type="checkbox">
                                        @endif
                                        90 Days
                                    </label>
                                </td>
                                <td class="width-25 padding-10">
                                </td>
                            </tr>
                        </table>
                        <table class="width-100">
                            <tr>
                                <td class="width-27 padding-10">
                                    <label class="check-container">
                                        @if($credit_term_offered=='other')
                                        <input type="checkbox" checked>
                                        @else
                                        <input type="checkbox">
                                        @endif
                                        Others (Please specify&nbsp;:
                                    </label>
                                </td>
                                <td class="width-20  padding-10">
                                    @if($credit_term_offered=='other')
                                    <input type="text" class="text-empty" value="{!! $credit_term_offered_other !!}">
                                    @else
                                    <input type="text" class="text-empty">
                                    @endif
                                </td>
                                <td class="width-3  padding-10">)</td>
                                <td class="width-50 padding-10"></td>
                            </tr>
                        </table>
                    </li>
                    <!-- Certification -->
                    <div class="page-break"></div>
                    <div class="padding-t-20"></div>
<!-- Legitation -->
                    <li>
                        <label class="section-heading">CORRUPTION / FRAUDULENT RECORDS</label>
                        <p>Acknowledgment Statemet to be provided</p>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</body>

</html>
