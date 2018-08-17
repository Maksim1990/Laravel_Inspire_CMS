<?php

namespace App\Office\Export;

use App\Menu\MenuLang;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class MenusExport implements FromCollection
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

    private $languages;


    function __construct($arrOptions)
    {
        $this->count=$arrOptions['count'];
        $this->order=$arrOptions['order'];
        $this->columns=$arrOptions['columns'];
        $this->languages=$arrOptions['languages'];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $menus = MenuLang::where('user_id', Auth::id())
            ->when(!empty($this->languages), function ($query) {
            $query->whereIn('lang',$this->languages);
        })->when(empty($this->languages), function ($query) {
            $query->where('lang',"");
        })->limit($this->count)->orderBy('id', $this->order)->get();


        if (!empty($this->columns)) {
            //-- Add id column to the list of exported columns
            array_unshift($this->columns, 'id');

        } else {
            $this->columns = ['id'];
        }
        $menusExport = $menus->map(function ($menu) {
            return collect($menu->toArray())
                ->only($this->columns)
                ->all();
        });


        $menusHeader = array();
        foreach ($this->columns as $column) {
            $menusHeader[$column] = $column;
        }

        $menusExport->prepend($menusHeader);

        return $menusExport;
    }

}
