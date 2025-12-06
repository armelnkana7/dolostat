<?php

namespace App\Exports;

use App\Models\SchoolClass;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SchoolClassesExport implements FromView
{
    public function view(): View
    {
        return view('exports.school_classes', [
            'classes' => SchoolClass::with('department')->get(),
        ]);
    }
}
