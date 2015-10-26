<?php

namespace app\Helpers;

use Exception;

class Excel
{
    protected $app;

    protected $excel;

    protected $sheet;

    protected $amount;

    protected $gear;

    public function __construct($app)
    {
        $this->app = $app;

        $this->excel = new \PHPExcel();
    }

    public function sendGearReport($gear, $email = false)
    {
        $this->gear = $gear;

        $this->gear->checkout_history = json_decode($this->gear->checkout_history);

        $this->genCellData();
        $this->styleCells();
        $this->setProp();

        if ($email == false) {
            return $this->excel;
        }

        $objWriter = \PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

        ob_start();
        $objWriter->save('php://output');
        $output = ob_get_clean();

        $mail = [
            "excel" => $output,
            "gear" => $this->gear,
            "email" => $email,
        ];

        $this->app->mail->send('templates/email/reports/report.twig', ['gear' => $gear],
            function ($message) use ($mail) {
                $message->to($mail["email"]);
                $message->subject('Gear Report for ' . $mail["gear"]->name);
                $message->attachment($mail["excel"], "Report.xlsx", "string");
            }
        );
    }

    protected function genCellData()
    {
        $this->sheet = $this->excel->getSheet(0);
        $this->sheet->setTitle('Data');

        $this->writeDataCells();

        $this->writeHistoryCells();
    }

    protected function writeHistoryCells()
    {
        $this->sheet->setCellValue('d1', "Checkout History");

        $this->sheet->setCellValue('d3', "Name");
        $this->sheet->setCellValue('e3', "Date Out");
        $this->sheet->setCellValue('f3', "Date In");

        $x = 4;

        foreach ($this->gear->checkout_history as $history) {
            $this->sheet->setCellValue('d' . $x, $history->name);
            $this->sheet->setCellValue('e' . $x, $history->dateOut);

            if (!empty($history->dateIn)) {
                $this->sheet->setCellValue('f' . $x, $history->dateIn);
            }

            $x++;
        }

        $this->amount = $x;
    }

    protected function writeDataCells()
    {
        $this->sheet->setCellValue('a1', 'Gear Report for ' . ucwords(strtolower($this->gear->brand)) . " " . ucwords(strtolower($this->gear->name)));
        $this->sheet->setCellValue('a3', 'Name:');
        $this->sheet->setCellValue('a4', 'Brand:');
        $this->sheet->setCellValue('a5', 'Status:');
        $this->sheet->setCellValue('a6', 'Serial Number:');
        $this->sheet->setCellValue('a7', 'Amount Available:');
        $this->sheet->setCellValue('a8', 'Amount Left:');
        $this->sheet->setCellValue('b3', $this->gear->name);
        $this->sheet->setCellValue('b4', $this->gear->brand);
        $this->sheet->setCellValue('b5', $this->gear->status);
        $this->sheet->setCellValueExplicit('b6', $this->gear->serial, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $this->sheet->setCellValue('b7', $this->gear->amount);

        $x = $this->gear->amount;

        foreach ($this->gear->checkout_history as $gear) {
            if ($gear->dateOut && empty($gear->dateIn)) {
                $x = $x - 1;
            }
        }

        if ($x < 0) {
            throw new Exception("Invalid Gear Amount");
        }

        $this->sheet->setCellValue('b8', $x);
    }

    protected function styleCells()
    {
        $headerCells = [
            'main' => 'a1:b1',
            'history' => 'd1:f1',
            'history_sub' => 'd3:f3',
        ];

        $historyCells = 'e4:f' . $this->amount;

        $dataCells = 'b3:b5';

        $numCells = 'b6:b8';

        $headerStyle = [
            'borders' => [
                'bottom'	=> [
                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
                    'color' => [
                        'rgb' => '000000'
                    ],
                ],
            ],
            'alignment' => [
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $dataCellsStyle = [
            'alignment' => [
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ],
        ];

        $numCellsStyle = [
            'alignment' => [
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ],
        ];

        $historyCellsStyle = [
            'alignment' => [
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ],
        ];

        foreach ($headerCells as $cells) {
            $this->sheet->getStyle($cells)->applyFromArray($headerStyle);
        }

        $this->sheet->getStyle($dataCells)->applyFromArray($dataCellsStyle);
        $this->sheet->getStyle($numCells)->applyFromArray($numCellsStyle);
        $this->sheet->getStyle($historyCells)->applyFromArray($historyCellsStyle);

        for ($col = ord('a'); $col <= ord('b'); $col++) {
            $this->sheet->getColumnDimension(chr($col))->setAutoSize(true);
        }

        for ($col = ord('d'); $col <= ord('f'); $col++) {
            $this->sheet->getColumnDimension(chr($col))->setAutoSize(true);
        }
    }

    protected function setProp()
    {
        $this->excel->getProperties()
           ->setCreator('Merit Tracker/PHPExcel 1.8.X')
           ->setTitle('Gear Report')
           ->setDescription('Gear Report for ' . $this->gear->name)
           ->setSubject('Gear Report');
    }
}
