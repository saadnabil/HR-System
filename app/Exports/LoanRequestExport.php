<?php

namespace App\Exports;

use App\Models\Employee_shift;
use App\Models\LoanPending;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LoanRequestExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('new-theme.exports.loanrequest', [
            'loans' =>    LoanPending::where([
                            'created_by' => auth()->user()->creatorId(),
                        ])->latest()->get()
        ]);
    }
}
