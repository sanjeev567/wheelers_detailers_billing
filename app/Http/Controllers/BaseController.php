<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    /**
     * Function to append total row in excel
     */
    public function appendTotalRow(&$sheetData, &$sheet)
    {
        $rowCount = count($sheetData);

        if (!empty($sheetData[0]) && count($sheetData[0]) > 1) {
            $colNum = count($sheetData[0]);
        } else if (!empty($sheetData[1]) && count($sheetData[1]) >= 1) {
            $colNum = count($sheetData[1]);
        } else {
            $colNum = 0;
        }

        $row = [];
        $row[] = 'Total';
        for ($i = 1; $i < $colNum; $i++) {
            $colName = \PHPExcel_Cell::stringFromColumnIndex($i);
            $row[] = '=SUM(' . $colName . '1:' . $colName . $rowCount . ')';
        }
        $sheetData[] = $row;

        $headerLength = $colNum - 1;
        $sheet->cells('A' . count($sheetData) . ':' . \PHPExcel_Cell::stringFromColumnIndex($headerLength) . count($sheetData), function ($cells) {
            // Set font weight to bold
            $cells->setFontWeight('bold');
        });

        $sheet->getStyle('A1:' . \PHPExcel_Cell::stringFromColumnIndex($headerLength) . count($sheetData))
            ->applyFromArray([
                'borders' => [
                    'allborders' => [
                        'style' => 'thin',
                    ],
                ],
            ]);
    }

    /**
     * Function to prepend party name row in excel
     */
    public function addPartyName(&$sheetData, &$sheet, $partyName)
    {
        if ($partyName == null) {
            return;
        }

        $headerLength = (isset($sheetData[0])) ? count($sheetData[0]) - 1 : 0;
        $endCell = \PHPExcel_Cell::stringFromColumnIndex($headerLength);

        // Add before first row
        $sheet->prependRow(1, array(
            $partyName,
        ));

        $sheet->mergeCells('A1:' . $endCell . '1');

        $sheet->cell('A1', function ($cell) {
            // manipulate the cell
            $cell->setAlignment('center');
        });

        $sheet->cells('A1', function ($cells) {
            // Set font weight to bold
            $cells->setFontWeight('bold');
        });

        $sheet->getStyle('A1:' . \PHPExcel_Cell::stringFromColumnIndex($headerLength) . count($sheetData))
            ->applyFromArray([
                'borders' => [
                    'allborders' => [
                        'style' => 'thin',
                    ],
                ],
            ]);
    }
}
