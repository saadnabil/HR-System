<?php

namespace App\Exports;

use App\Models\EmployeePermission;
use App\Models\OverTimeRequest;
use App\Services\OverTimeService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class OverTimeExport implements FromView
{
    private OverTimeService $overTimeService;
    public function __construct()
    {
        $this->overTimeService = new OverTimeService();
    }

    public function view(): View
    {
       $overtimerequests = OverTimeRequest::with('employee')->latest();

       $this->overTimeService->filter($overtimerequests);

        return view('new-theme.exports.over-time', [
            'overtimerequests' =>  $overtimerequests->get()
        ]);
    }
}
