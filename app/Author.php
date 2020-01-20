<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use SoftDeletes;
    protected $table = "authors";
    protected $fillable = ['name', 'deleted_at'];

    //function dataAuthor()
    //{
    //    $authors = $this->all();
    //
    //    return $authors;
    //}
}
