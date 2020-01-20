<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;
    const DANGXEM = 1;
    const COTHEMUON = 0;
    const DAMUON = 2;
    protected $table = "books";
    protected $fillable = ['book_title', 'status', 'author_id', 'deleted_at'];

    function Author()
    {
        return $this->belongsTo('App\Author');
    }

}
