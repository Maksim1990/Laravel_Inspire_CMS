<?php

namespace App\Office\Export;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\TranslationLoader\LanguageLine;

class LabelsExport implements FromCollection
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

    /**
     * Names of languages of labels to be exported
     */
    private $languages;

    function __construct($arrOptions)
    {
        $this->count = $arrOptions['count'];
        $this->order = $arrOptions['order'];
        $this->columns = $arrOptions['columns'];
        $this->languages = $arrOptions['languages'];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $labels = LanguageLine::where('user_id', Auth::id())->limit($this->count)->orderBy('id', $this->order)->get();


        if (!empty($this->columns)) {
            //-- Add id column to the list of exported columns
            array_unshift($this->columns, 'id');

        } else {
            $this->columns = ['id'];
        }


        //-- Add language columns to exporting array
        if (!empty($this->languages)) {
            foreach ($this->languages as $column) {
                $this->columns[$column] = strtoupper($column);
            }
        }


        //-- Sort resulting collection and add language elements
        $labelsExport = $labels->map(function ($label) {
            if (!empty($this->languages)) {
                $collection = collect($label->toArray());
                foreach ($label->text as $strKey => $translation) {
                    if (in_array(strtolower($strKey), $this->languages)) {
                        $collection->put(strtoupper($strKey), $translation);
                    }
                }

                return $collection->only($this->columns)->all();
            }
            return array();
        });


        $labelsHeader = array();
        foreach ($this->columns as $column) {
            $labelsHeader[$column] = $column;
        }


        $allAvailableLanguages = LaravelLocalization::getSupportedLocales();
        if (!empty($this->languages)) {
            foreach ($this->languages as $column) {

                //-- Remove unnecessary language key columns in the header
                if (($key = array_search(strtoupper($column), $labelsHeader)) !== false) {
                    unset($labelsHeader[$key]);
                }

                $labelsHeader[$column] = $allAvailableLanguages[strtolower($column)]['native'];
            }
        }

        $labelsExport->prepend($labelsHeader);

        return $labelsExport;
    }
}
