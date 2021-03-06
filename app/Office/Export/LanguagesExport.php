<?php

namespace App\Office\Export;


use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Modules\Dashboard\Entities\Language;

class LanguagesExport implements FromCollection
{

    /**
     * Number of lines to be exported
     */
    private $count;

    /**
     * Order of exported records
     */
    private $order;

    /**
     * Names of columns to be exported
     */
    private $columns;


    function __construct($arrOptions)
    {
        $this->count=$arrOptions['count'];
        $this->order=$arrOptions['order'];
        $this->columns=$arrOptions['columns'];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $languages=Language::where('user_id',Auth::id())->limit($this->count)->orderBy('id',$this->order)->get();


        if(!empty($this->columns)){
            //-- Add id column to the list of exported columns
            array_unshift($this->columns,'id');

        }else{
            $this->columns=['id'];
        }
            $languagesExport = $languages->map(function ($lang) {
                return collect($lang->toArray())
                    ->only($this->columns)
                    ->all();
            });


        $languagesHeader=array();
        foreach ($this->columns as $column){
            $languagesHeader[$column]=$column;
        }

        $languagesExport->prepend($languagesHeader);

        return $languagesExport;
    }
}