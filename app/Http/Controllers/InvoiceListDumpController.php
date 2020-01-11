<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class InvoiceListDumpController extends BaseController
{
    /**
     * Function to generate a cumulative master sheet for
     * 30 days
     *
     * @param Request $request
     */
    public function invoiceListDumpDownload(Request $request)
    {
        try {
            $name = 'Invoice List';
            $reportData = $this->getInvoiceListDumpReport($request);

            // Generate and return the spreadsheet
            return \Excel::create($name, function ($excel) use ($reportData) {

                // Set the spreadsheet title, creator, and description
                $excel->setTitle('Party List');
                $excel->setCreator('Admin')->setCompany('Mars Car Care');
                $excel->setDescription('Party List');

                foreach ($reportData as $key => $sheetData) {
                    // Build the spreadsheet, passing in the payments array
                    $excel->sheet($key, function ($sheet) use ($sheetData) {
                        $headerLength = count($sheetData[0]) - 1;
                        $endCell = \PHPExcel_Cell::stringFromColumnIndex($headerLength);

                        $sheet->cells('A1:' . $endCell . '1', function ($cells) {
                            // Set font weight to bold
                            $cells->setFontWeight('bold');
                            $cells->setAlignment('center');
                        });

                        $this->appendTotalRow($sheetData, $sheet);
                        $sheet->fromArray($sheetData, null, 'A1', true, false);
                    });
                }
            })->download('xls');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Function to generate cumulative master sheet
     */
    private function getInvoiceListDumpReport($request)
    {
        try {
            $reportData = \DB::table('invoices as i')
            ->join('invoice_details as id', 'id.invoice_id', '=', 'i.id')
            ->select([
                'i.id',
                \DB::raw('DATE_FORMAT(i.created_at, "%d-%b-%Y") AS invoice_date'),
                'i.invoice_number',
                'i.customer_name',
                'i.customer_address',
                'i.customer_state',
                'i.seller_state',
                'i.buyer_gstin',
                'id.tax_value',
                'i.total',
                'id.quantity',
                'id.item_cost_without_tax as price_without_tax',
                'id.item_name as product',
                'id.discount as discount',
                'id.tax_percent'
            ])
            ->orderBy('i.id', 'desc')
            ->get();

            $headers = $this->getInvoiceListDumpReportHeaders();
            $reportData = $this->getInvoiceListDumpReportExcelData($reportData);

            // merge header & data
            $sheetData = array_merge([$headers], $reportData);
            $cumulativeSheet['Report'] = $sheetData;

            return $cumulativeSheet;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Funtion to get the headers of cumulative DSR report
     *
     * @return array
     */
    private function getInvoiceListDumpReportHeaders()
    {
        $headers = [
            'S No.',
            'Date ',
            'Invoice No.',
            'Party Name',
            'Party Address',
            'GST No.',
            'Product/Service',
            'SAC No.',
            'QTY',
            'Rate',
            'Sub Total',
            'Discount %',
            'Tax %',
            'CGST',
            'SGST',
            'IGST',
            'Grand Total',
            'Cancelled',
        ];

        return $headers;
    }

    /**
     * Function to reform all the party data according to report
     *
     * @param array $reportData
     *
     * @return array
     */
    private function getInvoiceListDumpReportExcelData($reportData)
    {
        try {
            if ($reportData == null) {
                return [];
            }

            $sheetData = [];
            $count = 1;
            foreach ($reportData as $data) {
                $subTotal = (int)$data->quantity * (float)$data->price_without_tax;
                $subTotalAfterDiscount = $subTotal - ($subTotal * (float)$data->discount/100);

                $sheetData[$count] = [];
                $sheetData[$count]['sr_no'] = $count;
                $sheetData[$count]['invoice_date'] = strtoupper($data->invoice_date);
                $sheetData[$count]['invoice_number'] = strtoupper($data->invoice_number);
                $sheetData[$count]['customer_name'] = strtoupper($data->customer_name);
                $sheetData[$count]['customer_address'] = strtoupper($data->customer_address) . strtoupper(' '. $data->customer_state);
                $sheetData[$count]['buyer_gstin'] = strtoupper($data->buyer_gstin);
                $sheetData[$count]['product'] = strtoupper($data->product);
                $sheetData[$count]['sac'] = strtoupper(config('app-config.TREATMENT_SAC_NUMBER'));
                $sheetData[$count]['quantity'] = (int)$data->quantity;
                $sheetData[$count]['price_without_tax'] = (float)$data->price_without_tax;
                $sheetData[$count]['sub_total'] = $subTotal;
                $sheetData[$count]['discount'] = (float)$data->discount;
                $sheetData[$count]['tax_percent'] = (float)$data->tax_percent;
                $sheetData[$count]['cgst'] = ($data->customer_state == $data->seller_state)? round($data->tax_value/2, 2) * (int)$data->quantity: 0;
                $sheetData[$count]['sgst'] = ($data->customer_state == $data->seller_state)? round($data->tax_value/2, 2) * (int)$data->quantity: 0;
                $sheetData[$count]['igst'] = ($data->customer_state != $data->seller_state)?$data->tax_value * (int)$data->quantity:0;
                $sheetData[$count]['grant_total'] = $subTotalAfterDiscount + ($data->tax_percent * $subTotalAfterDiscount/100);
                $sheetData[$count]['cancelled'] = empty($data->deleted_at)?'NO':'YES';

                $count++;
            }

            return $sheetData;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Function to return exception response
     */
    public function returnExceptionResponse(\Exception $e)
    {
        return response()->json(['status' => '0', 'msg' => $e->getMessage() . " on line " . $e->getLine() . " in file " . $e->getFile(), 'data' => null]);
    }
}
