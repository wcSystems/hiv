<?php

namespace App\Exports;

use App\Device;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class DevicesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $output = [];
        foreach ($this->request as $item)
        {
          $output[] = [
            $item->username,
          ];
        }
        return collect($output);
    }

    public function headings(): array
    {
        return [
            'Name',
        ];
    }
}
