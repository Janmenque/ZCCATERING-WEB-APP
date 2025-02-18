<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportUser implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    var $list;

    public function __construct($list)
    {
        $this->list = $list;
    }

    public function view(): View
    {
        return view('user.export', ['list' => $this->list]);
    }
}
