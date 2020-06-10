<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DictionaryModel extends Model
{
    //

    protected $table = 'tbl_edict';
    public $timestamps = false;
    public $fillable = ['word', 'detail'];

    public function same(){
        return self::select('id', 'word')
            ->where([
                ['word', 'like','%'.$this->word .'%'],
                ['id', '<>', $this->id]
            ])->limit(5)->get();
    }
}
