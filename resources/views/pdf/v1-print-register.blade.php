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
            page-break-after: always;
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
            padding: 5px; 
        }

        .document-content {
            padding-left: 20px;
            padding-top: 20px;
            padding-bottom: 10px;
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
    table, tr, td { page-break-inside: avoid; }
</style>
</head>

<body>
    <div class="doc-container">
        <div class="pdf-document-wrapper">
            <table class="width-100" style="border:1px solid #000">
                <tr>
                    <td class="width-40 text-center" style="border:1px solid #000; padding: 0px 10px;">
                        <div style="height: 57px">
                            @if ($image_path && $image_path !== null && $image_path !== '')
                                <img src={{$image_path}} alt="icon" style="width:100%; height: 100%" />
                            @endif
                        </div>
                    </td>
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
                                @if(isset($name_of_company))
                                <td class="width-75  padding-10"><input type="text" class="text-filled" value="{!! $name_of_company !!}"></td>
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
                                <td class="width-75  padding-10"><input type="text" class="text-empty" value="{!! $mailing_address_zip_code !!} {!! $mailing_address_city !!}, {!! $mailing_address_state !!} {!! $mailing_address_country !!}"></td>
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
                                <td class="width-25 padding-10">Email Address <span class="colon-separator">:</span></td>
                                <td class=" padding-10"><input type="text" class="text-empty" value="{!! $email_address !!}"></td>
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
                                <td class="width-25 padding-10">No. of year in Operation <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><input type="text" class="text-empty" value="{!! $year_in_operation !!}"></td>
                            </tr>
                        </table>
                        <table class="width-100 list-style">
                            <tr>
                                <td class="width-25 padding-10">SST Registration No. <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><input type="text" class="text-empty" value="{!! $sst_registration_no !!}"></td>
                                <td class="width-25  padding-10"></td>
                                <td class="width-25  padding-10"></td>
                            </tr>
                        </table>
                        <table class="width-100 list-style">
                            <tr>
                                <td class="width-25 padding-10">Vendor Type <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><input type="text" class="text-empty" value="{!! $vendor_type !!}"></td>
                                <td class="width-25 padding-10">Account Type <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><input type="text" class="text-empty" value="{!! $account_type !!}"></td>
                            </tr>
                        </table>
                        <table class="width-100 list-style">
                            <tr>
                                <td class="width-25 padding-10">MSIC Code <span class="colon-separator">:</span></td>
                                <td class=" padding-10"><input type="text" class="text-empty" value="{!! $msic_code !!}"></td>
                            </tr>
                        </table>
                        <div class="padding-t-20"></div>
                        <table class="width-100 list-style">
                            <tr>
                                <td class="width-25 padding-10">ID Type <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><input type="text" class="text-empty" value="{!! $id_type !!}"></td>
                                <td class="width-25 padding-10">ID Value <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><input type="text" class="text-empty" value="{!! $id_value !!}"></td>
                            </tr>
                        </table>
                        <table class="width-100 list-style">
                            <tr>
                                <td class="width-25 padding-10">Company TIN No. <span class="colon-separator">:</span></td>
                                <td class=" padding-10"><input type="text" class="text-empty" value="{!! $tin !!}"></td>
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
                    {{-- <div class="page-break"></div> --}}
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
                                <td class="width-25 padding-10">Bank Branch <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><input type="text" class="text-empty" value="{!! $bank_branch !!}"></td>
                                <td class="width-25 padding-10">Bank Account No. <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><input type="text" class="text-empty" value="{!! $bank_account_no !!}"></td>
                            </tr>
                            <tr>
                                <td class="width-25 padding-10">Bank Address <span class="colon-separator">:</span></td>
                                <td class="padding-10" colspan="3">
                                    <input type="text" class="text-empty" value="{!! $bank_address_one !!}, {!! $bank_address_two !!}">
                                </td>
                            </tr>
                        </table>
                    </li>
                    <li>
                        <label class="section-heading">FINANCIAL INFORMATION</label>
                        <table class="width-100">
                            <tr>
                                <td class="width-25 padding-10">Annual Turnover* <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><input type="text" class="text-empty" value="{!! number_format($annual_turnover, 2, '.', ',') !!}"></td>
                                <td class="width-25 padding-10">Working Capital* <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><input type="text" class="text-empty" value="{!! number_format($working_capital, 2, '.', ',') !!}"></td>
                            </tr>
                            <tr>
                                <td class="width-25 padding-10">Net Worth* <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><input type="text" class="text-empty" value="{!! number_format($net_worth, 2, '.', ',') !!}"></td>
                                <td class="width-25 padding-10">Cash & Bank Balance** <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><input type="text" class="text-empty" value="{!! number_format($cash_bank_balance, 2, '.', ',') !!}"></td>
                            </tr>
                            <tr>
                                <td class="width-25 padding-10">Paid-up Capital <span class="colon-separator">:</span></td>
                                <td class="width-25  padding-10"><input type="text" class="text-empty" value="{!! number_format($paid_up_capital, 2, '.', ',') !!}"></td>
                                <td class="width-25 padding-10"></td>
                                <td class="width-25  padding-10"></td>
                            </tr>
                        </table>
                        <p>Note : </p>
                        <p>* Average of last 3 years figures base on Audited Financial Statement</p>
                        <p>** Base on latest month end balance. Only applicable for Purchase Order amount above RM1 million.</p>
                        <p>i. Working Capital = Total Current Assets - Total Current Liabilities</p>
                        <p>ii. Net Worth = Total Assets - Total Liabilities</p>
                    </li>
                    <li>
                        <label class="section-heading">PRODUCT DESCRIPTION</label>
                        <table class="width-100">
                            <tr>
                                <td class="width-40 padding-10"><span class="roman-number">1.</span><input type="text" class="text-empty" value="{!! $product_desc_one !!}"></td>
                                <td class="width-10 padding-10"></td>
                                <td class="width-40 padding-10"><span class="roman-number">2.</span><input type="text" class="text-empty" value="{!! $product_desc_two !!}"></td>
                                <td class="width-10 padding-10"></td>
                            </tr>
                            <tr>
                                <td class="width-40 padding-10"><span class="roman-number">3.</span><input type="text" class="text-empty" value="{!! $product_desc_three !!}"></td>
                                <td class="width-10 padding-10"></td>
                                <td class="width-40 padding-10"><span class="roman-number">4.</span><input type="text" class="text-empty" value="{!! $product_desc_four !!}"></td>
                                <td class="width-10 padding-10"></td>
                            </tr>
                            <tr>
                                <td class="width-40 padding-10"><span class="roman-number">5.</span><input type="text" class="text-empty" value="{!! $product_desc_five !!}"></td>
                                <td class="width-10 padding-10"></td>
                                <td class="width-40 padding-10"><span class="roman-number">6.</span><input type="text" class="text-empty" value="{!! $product_desc_six !!}"></td>
                                <td class="width-10 padding-10"></td>
                            </tr>
                        </table>
                        {{-- <div class="page-break"></div> --}}
                        <div class="padding-t-20"></div>
                        <p>Note : </p>
                        <p>i. Please attach Product Catalogues / Brochures / Specification (if any) and complete the Referral Projects in Appendix A.</p>
                        <p>ii. Please attach a copy of the latest Product Certificate for respective products (if any).</p>
                    </li>
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
                    <li>
                        <label class="section-heading">CERTIFICATION</label>
                        <table class="width-100">
                            <tr>
                                <td class="width-25 padding-10">
                                    <label class="check-container">
                                        <?php
                                        $certStr = $certification;
                                        $certArr = explode(',', $certStr);
                                        ?>
                                        @if(in_array("ISO 9001", $certArr))
                                        <input type="checkbox" checked>
                                        @else
                                        <input type="checkbox">
                                        @endif
                                        ISO 9001
                                    </label>
                                </td>
                                <td class="width-25 padding-10">
                                    <label class="check-container">
                                        @if(in_array("ISO-14001", $certArr))
                                        <input type="checkbox" checked>
                                        @else
                                        <input type="checkbox">
                                        @endif
                                        ISO 14001
                                    </label>
                                </td>
                                <td class="width-50 padding-10">
                                    <label class="check-container">
                                        @if(in_array("ISO 45001", $certArr))
                                        <input type="checkbox" checked>
                                        @else
                                        <input type="checkbox">
                                        @endif
                                        ISO 45001
                                    </label>
                                </td>
                            </tr>
                        </table>
                        <table class="width-100">
                            <tr>
                                <td class="width-50 padding-10">
                                    <label class="check-container">
                                        @if(in_array("ISO 37001", $certArr))
                                        <input type="checkbox" checked>
                                        @else
                                        <input type="checkbox">
                                        @endif
                                        ISO 37001 (Anti-Bribery Management System)
                                    </label>
                                </td>
                            </tr>
                        </table>
                        <table class="width-100">
                            <tr>
                                <td class="width-27 padding-10">
                                    <label class="check-container">
                                        @if(in_array("other", $certArr))
                                        <input type="checkbox" checked>
                                        @else
                                        <input type="checkbox">
                                        @endif
                                        Other (Please specify):
                                    </label>
                                </td>
                                <td class="width-50 padding-10">
                                    @if(in_array("other", $certArr))
                                    <input type="text" class="text-empty" value="{!! $certification_other !!}">
                                    @else
                                    <input type="text" class="text-empty">
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <p>* Note : Please attach a copy of the latest Certificate(s).</p>
                    </li>
                    {{-- <div class="page-break"></div> --}}
                    <div class="padding-t-20"></div>
                    <li>
                        <label class="section-heading">LITIGATION RECORDS</label>
                        <p>Is / was your Company involved in any past, pending or potential litigation / arbitration?</p>
                        <div class="padding-t-20"></div>
                        <table class="width-100">
                            <tr>
                                <td class="width-25 padding-10">
                                    <label class="check-container">
                                        @if($litigation_records==1)
                                        <input type="checkbox" checked>
                                        @else
                                        <input type="checkbox">
                                        @endif
                                        Yes (Please describe&nbsp;:
                                    </label>
                                </td>
                                <td class="width-75  padding-10">
                                    @if($litigation_records==1)
                                    <input type="text" class="text-empty" value="{!! $litigation_records_other !!}">
                                    @else
                                    <input type="text" class="text-empty">
                                    @endif
                                </td>
                                <td class="width-3  padding-10">)</td>
                            </tr>
                            <tr>
                                <td class="width-25 padding-10">
                                    <label class="check-container">
                                        @if($litigation_records==0)
                                        <input type="checkbox" checked>
                                        @else
                                        <input type="checkbox">
                                        @endif
                                        No&nbsp;:
                                    </label>
                                </td>
                                <td class="width-75  padding-10"></td>
                            </tr>
                        </table>
                    </li>
                    <li>
                        <label class="section-heading">CORRUPTION / FRAUDULENT RECORDS</label>
                        <p>Has any of your employees (including Directors and top management) committed any crime related to bribery, fraud, dishonesty or similar misconduct or have been investigated, convicted, sanctioned, debarred for bribery or similar conduct?</p>
                        <table class="width-100">
                            <tr>
                                <td class="width-25 padding-10">
                                    <label class="check-container">
                                        @if($corruption_fraudulent_records==1)
                                        <input type="checkbox" checked>
                                        @else
                                        <input type="checkbox">
                                        @endif
                                        Yes (Please describe&nbsp;:
                                    </label>
                                </td>
                                <td class="width-75  padding-10">
                                    @if($corruption_fraudulent_records==1)
                                    <input type="text" class="text-empty" value="{!! $corruption_fraudulent_records_other !!}">
                                    @else
                                    <input type="text" class="text-empty">
                                    @endif
                                </td>
                                <td class="width-3  padding-10">)</td>
                            </tr>
                            <tr>
                                <td class="width-25 padding-10">
                                    <label class="check-container">
                                        @if($corruption_fraudulent_records==0)
                                        <input type="checkbox" checked>
                                        @else
                                        <input type="checkbox">
                                        @endif
                                        No&nbsp;:
                                    </label>
                                </td>
                                <td class="width-75  padding-10"></td>
                            </tr>
                        </table>
                    </li>
                    <li>
                        <label class="section-heading">DECLARATION BY SUPPLIER</label>
                        <p>I / We hereby confirm that all particulars given above (Item A to G) are true, accurate and up to date. Mudajaya Group Berhad or its relevant subsidiaries (MGB) will be updated promptly should there be any change of such information. I / We hereby declare and affirm that I am authorized to make this declaration on the Company's behalf. </p>
                        <p>I / We hereby agree to adhere strictly to MGB's Integrated Management Systems, Anti-Bribery Management System, all relevant legal requirements and other requirements whichever applicable.</p>
                        <p>MGB shall reserve the absolute right to approve or reject my / our application as MGB deems fit without assigning any reason.</p>
                        <p>The Undersigned also UNDERTAKE to notify MGB soonest possible should there be any litigation or arbitration is taken against the Company, and MGB upon receipt of the said notification reserve the right to terminate the registration if the Company's performance is determined to be affected by the said litigation or arbitration.</p>
                        <div class="padding-t-20"></div>
                        <table class="width-100" style="margin-top:60px">
                            <tr>
                                <td class="width-40 padding-10">
                                    <hr>Authorized Company Director</td>
                                <td class="width-10 padding-10"></td>
                                <td class="width-25 padding-10">Company Stamp&nbsp;:</td>
                                <td class="width-25 padding-10"></td>
                            </tr>
                        </table>
                        <table class="width-100">
                            <tr>
                                <td class="width-20 padding-10">Name&nbsp;:</td>
                                <td class="width-80 padding-10">{!! $name !!}</td>
                            </tr>
                            <tr>
                                <td class="width-20 padding-10">Designation&nbsp;:</td>
                                <td class="width-80 padding-10">{!! $designation !!}</td>
                            </tr>
                            <tr>
                                <td class="width-20 padding-10">NRIC No.&nbsp;:</td>
                                <td class="width-80 padding-10">{!! $nric_no !!}</td>
                            </tr>
                            <tr>
                                <td class="width-20 padding-10">Date&nbsp;:</td>
                                <td class="width-80 padding-10">{{date('d M,Y',strtotime($date))}}</td>
                            </tr>
                        </table>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</body>

</html>
