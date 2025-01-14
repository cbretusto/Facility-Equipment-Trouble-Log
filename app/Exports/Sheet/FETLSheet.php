<?php

namespace App\Exports\Sheet;

use Illuminate\Contracts\View\View;

Use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class FETLSheet implements FromView, ShouldAutoSize, WithEvents, WithTitle
{
    use Exportable;
    protected $trouble_logs_details;

    function __construct(
    $trouble_logs_details
    ){
        $this->trouble_logs_details = $trouble_logs_details;
    }

    public function view(): View {
        return view('exports.ExcelFETL', ['trouble_logs_details' => $this->trouble_logs_details]);
    }

    public function title(): string{
        $trouble_logs_details = $this->trouble_logs_details;
        // return 'Facility Equipment Trouble Logs Report';
        return ''.$trouble_logs_details[0]->trouble_logs_equipment_info->equipment.'';
    }

    public function registerEvents(): array{
        $trouble_logs_details = $this->trouble_logs_details;

        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $text_align_center = array(
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrap' => TRUE
            ]
        );

        $text_align_left = array(
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrap' => TRUE
            ]
        );

        $font_9_arial = array(
            'font' => [
                'name'      =>  'Arial',
                'size'      =>  9,
            ]
        );

        $font_9_arial_bold = array(
            'font' => [
                'name'      =>  'Arial',
                'size'      =>  9,
                'bold'      =>  true,
            ]
        );

        $font_12_arial_bold = array(
            'font' => [
                'name'      =>  'Arial',
                'size'      =>  12,
                'bold'      =>  true,
            ]
        );

        $font_14_arial_bold = array(
            'font' => [
                'name'      =>  'Arial',
                'size'      =>  14,
                'bold'      =>  true,
            ]
        );

        return[AfterSheet::class => function(AfterSheet $event) use(
            $trouble_logs_details, 
            $border, 
            $text_align_center, 
            $text_align_left, 
            $font_9_arial, 
            $font_9_arial_bold, 
            $font_12_arial_bold, 
            $font_14_arial_bold
        ){
            //==================== Excel Format =========================
            $event->sheet->getDelegate()->getStyle('A1:L2')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('B7D8FF');

            $event->sheet->getDelegate()->getStyle('A3:L5')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('70ECF9');

            $event->sheet->getDelegate()->getStyle('A1:L5')->applyFromArray($border);

            $event->sheet->getColumnDimension('A')->setWidth(20);
            $event->sheet->getColumnDimension('B')->setWidth(30);
            $event->sheet->getColumnDimension('C')->setWidth(30);
            $event->sheet->getColumnDimension('D')->setWidth(15);
            $event->sheet->getColumnDimension('E')->setWidth(20);
            $event->sheet->getColumnDimension('F')->setWidth(15);
            $event->sheet->getColumnDimension('G')->setWidth(30);
            $event->sheet->getColumnDimension('H')->setWidth(20);
            $event->sheet->getColumnDimension('I')->setWidth(30);
            $event->sheet->getColumnDimension('J')->setWidth(20);
            $event->sheet->getColumnDimension('K')->setWidth(20);
            $event->sheet->getColumnDimension('L')->setWidth(20);

            $event->sheet->getDelegate()->mergeCells('A1:L2');
            $event->sheet->getDelegate()->mergeCells('A3:A5');
            $event->sheet->getDelegate()->mergeCells('B3:B5');
            $event->sheet->getDelegate()->mergeCells('C3:L3');
            $event->sheet->getDelegate()->mergeCells('C4:C5');
            $event->sheet->getDelegate()->mergeCells('D4:D5');
            $event->sheet->getDelegate()->mergeCells('E4:E5');
            $event->sheet->getDelegate()->mergeCells('F4:F5');
            $event->sheet->getDelegate()->mergeCells('G4:G5');
            $event->sheet->getDelegate()->mergeCells('H4:H5');
            $event->sheet->getDelegate()->mergeCells('I4:I5');
            $event->sheet->getDelegate()->mergeCells('J4:J5');
            $event->sheet->getDelegate()->mergeCells('K4:K5');
            $event->sheet->getDelegate()->mergeCells('L4:L5');

            $event->sheet
                ->getDelegate()
                ->getStyle('A1')
                ->applyFromArray($text_align_center)
                ->applyFromArray($font_14_arial_bold)
                ->getAlignment()
                ->setWrapText(true);

            $event->sheet
                ->getDelegate()
                ->getStyle('A3:L5')
                ->applyFromArray($text_align_center)
                ->applyFromArray($font_9_arial_bold)
                ->getAlignment()
                ->setWrapText(true);
            
            $event->sheet->setCellValue('A1',"Troubleshooting and Repair History ");

            $event->sheet->setCellValue('A3',"Control No.");
            $event->sheet->setCellValue('B3',"Equipment Description");
            $event->sheet->setCellValue('C4',"Trouble");
            $event->sheet->setCellValue('C3',"Other Activities");
            $event->sheet->setCellValue('D4',"Date");
            $event->sheet->setCellValue('E4',"Parts Needed");
            $event->sheet->setCellValue('F4',"Date: Parts Replaced");
            $event->sheet->setCellValue('G4',"Action Done");
            $event->sheet->setCellValue('H4',"Status");
            $event->sheet->setCellValue('I4',"Remark");
            $event->sheet->setCellValue('J4',"Created By");
            $event->sheet->setCellValue('K4',"Noted By");
            $event->sheet->setCellValue('L4',"Checked By");
            $start_column = 6;
            for ($i=0; $i < count($trouble_logs_details); $i++) { 
                $event->sheet
                    ->getDelegate()
                    ->getStyle('A'.$start_column.':L'.$start_column)
                    ->applyFromArray($border)
                    ->applyFromArray($font_9_arial)
                    ->applyFromArray($text_align_left)
                    ->getAlignment()
                    ->setWrapText(true);

                $event->sheet->setCellValue('A'.$start_column,"\n".$trouble_logs_details[$i]->control_no."\n");
                $event->sheet->setCellValue('B'.$start_column,"\n".$trouble_logs_details[$i]->trouble_logs_equipment_model_info->equipment_model."\n");
                $event->sheet->setCellValue('C'.$start_column,"\n".$trouble_logs_details[$i]->trouble."\n");
                $event->sheet->setCellValue('D'.$start_column,"\n".$trouble_logs_details[$i]->date."\n");
                $event->sheet->setCellValue('E'.$start_column,"\n".$trouble_logs_details[$i]->parts_needed."\n");
                $event->sheet->setCellValue('F'.$start_column,"\n".$trouble_logs_details[$i]->date_parts_replaced."\n");
                $event->sheet->setCellValue('G'.$start_column,"\n".$trouble_logs_details[$i]->action_done."\n");
                $event->sheet->setCellValue('H'.$start_column,"\n".$trouble_logs_details[$i]->fetls_status."\n");
                $event->sheet->setCellValue('I'.$start_column,"\n".$trouble_logs_details[$i]->remark."\n");
                $event->sheet->setCellValue('J'.$start_column,"\n".$trouble_logs_details[$i]->created_by_info->name."\n");
                $event->sheet->setCellValue('K'.$start_column,"\n".$trouble_logs_details[$i]->noted_by_info->name."\n");
                $event->sheet->setCellValue('L'.$start_column,"\n".$trouble_logs_details[$i]->checked_by_info->name."\n");
                $start_column++;
            }
        }];
    }
}
