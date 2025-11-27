<?php

namespace App\Exports;

use App\Models\Organization;
use App\Services\StatementService;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use stdClass;

class ExportVendorStatement implements
    FromArray,
    WithHeadings,
    WithStyles,
    WithColumnWidths
{
    public string $vendorNo;
    public ?Organization $organization = null;
    /**
     * Create a new message instance.
     */
    public function __construct($vendorNo, $organization)
    {
        $this->vendorNo = $vendorNo;
        $this->organization = $organization;
    }

    public function array(): array
    {
        // For order list
        $response = StatementService::getVendorStatements(
            $this->vendorNo,
            $this->organization
        );
        $vendorStatements = [];
        if (
            // isset(
            //     $response->SoapBody->ReadMultiple_Result->ReadMultiple_Result
            //         ->eProcurement_Vendor_Statement
            // )
            isset($response->value)
        ) {
            // $statements =
            //     $response->SoapBody->ReadMultiple_Result->ReadMultiple_Result
            //     ->eProcurement_Vendor_Statement;

            $statements = $response->value;

            if (is_object($statements)) {
                $statements = [$statements];
            }

            foreach ($statements as $statement) {
                $vendorStatement = new stdClass();
                // $vendorStatement->Key = isset($statement->Key)
                //     ? $statement->Key
                //     : "NA";
                // $vendorStatement->Vendor_No = isset($statement->Vendor_No)
                //     ? $statement->Vendor_No
                //     : "NA";
                // $vendorStatement->Posting_Date = isset($statement->Posting_Date)
                //     ? $statement->Posting_Date
                //     : "NA";
                $vendorStatement->Document_Date = isset(
                    $statement->date
                )
                    ? $statement->date
                    : "NA";
                // $vendorStatement->Document_Type = isset(
                //     $statement->Document_Type
                // )
                //     ? $statement->Document_Type
                //     : "NA";
                $vendorStatement->PO_Number = isset($statement->PONo)
                    ? $statement->PONo
                    : "NA";
                $vendorStatement->Invoice_No = isset($statement->documentNo)
                    ? $statement->documentNo
                    : "NA";
                // $vendorStatement->External_Document_No = isset(
                //     $statement->External_Document_No
                // )
                //     ? $statement->External_Document_No
                //     : "NA";
                $vendorStatement->Description = isset($statement->description)
                    ? $statement->description
                    : "NA";
                $vendorStatement->Currency = isset($statement->currency)
                    ? $statement->currency
                    : "NA";
                // $vendorStatement->Amount = isset($statement->Amount)
                //     ? $statement->Amount
                //     : "NA";
                // $vendorStatement->Amount_LCY = isset($statement->Amount_LCY)
                //     ? $statement->Amount_LCY
                //     : "NA";
                $vendorStatement->Original_Amount = isset(
                    $statement->originalAmount
                )
                    ? $statement->originalAmount
                    : "NA";

                $vendorStatement->Remaining_Amount = isset(
                    $statement->remainingAmount
                )
                    ? $statement->remainingAmount
                    : "NA";
                // $vendorStatement->Remaining_Amt_LCY = isset(
                //     $statement->Remaining_Amt_LCY
                // )
                //     ? $statement->Remaining_Amt_LCY
                //     : "NA";
                // $vendorStatement->Due_Date = isset($statement->Due_Date)
                //     ? $statement->Due_Date
                //     : "NA";
                // $vendorStatement->Original_Amt_LCY = isset(
                //     $statement->Original_Amt_LCY
                // )
                //     ? $statement->Original_Amt_LCY
                //     : "NA";
                $vendorStatement->LastPaymentDateText = isset(
                    $statement->lastPaymentDate
                )
                    ? $statement->lastPaymentDate
                    : "NA";
                array_push($vendorStatements, $vendorStatement);
            }
        }

        return $vendorStatements;
    }

    public function headings(): array
    {
        return [
            // "Key",
            // "Vendor No",
            // "Posting Date",
            "Document Date",
            // "Document Type",
            "PO Number",
            "Invoice No.",
            // "External Document No",
            "Description",
            "Currency",
            // "Amount",
            // "Amount LCY",
            "Original Amount",
            "Remaining Amount",
            // "Remaining Amt LCY",
            // "Due Date",
            // "Original Amt LCY",
            "Last Payment Date",
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ["font" => ["bold" => true]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            "A" => 11,
            "B" => 11,
            "C" => 11,
            "D" => 30,
            "E" => 10,
            "F" => 10,
            "G" => 10,
            "H" => 11,
        ];
    }
}
