<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;

use PhpOffice\PhpSpreadsheet\Style\Alignment;

Use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use App\Exports\Sheet\FETLSheet;

class ExportData implements WithMultipleSheets
{
    use Exportable;
    protected $trouble_logs_details;

    function __construct(
        $trouble_logs_details
    ){
        $this->trouble_logs_details = $trouble_logs_details;
    }

    public function sheets(): array{
        $sheets = [];
        $sheets[] = new FETLSheet($this->trouble_logs_details);

        return $sheets;
    }
}
