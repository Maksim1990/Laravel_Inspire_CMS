<?php

namespace App\Office\Export;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\Auth;
use Modules\Post\Entities\Post;

class PostsExport implements FromCollection
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
        $posts=Post::where('user_id',Auth::id())->limit($this->count)->orderBy('id',$this->order)->get();


        if(!empty($this->columns)){
            //-- Add id column to the list of exported columns
            array_unshift($this->columns,'id');

        }else{
            $this->columns=['id'];
        }
        $postsExport = $posts->map(function ($post) {
            return collect($post->toArray())
                ->only($this->columns)
                ->all();
        });


        $postsHeader=array();
        foreach ($this->columns as $column){
            $postsHeader[$column]=$column;
        }

        $postsExport->prepend($postsHeader);

        return $postsExport;
    }
}
