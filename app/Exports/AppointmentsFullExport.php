<?php

namespace App\Exports;

use App\Models\Appointments;
use Maatwebsite\Excel\Concerns\FromCollection;

class AppointmentsFullExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Appointments::all();
    }
}
