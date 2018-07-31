<?php

namespace App\Office\Export;


use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Modules\Dashboard\Entities\Language;

class LanguagesExport implements FromCollection
{
    public function collection()
    {
        return Language::where('user_id',Auth::id())->get();
    }
}