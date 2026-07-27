<?php

namespace App\Http\Controllers;

use App\Exports\DashboardExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /**
     * Export Excel.
     */
    public function excel()
    {
        return Excel::download(
            new DashboardExport(),
            'candidatures.xlsx'
        );
    }
}