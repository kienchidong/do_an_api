<?php

namespace App\Model\Question;

use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    //
    protected $table = 'levels';

    protected $fillable = ['name'];
    public $timestamps = false;
}
