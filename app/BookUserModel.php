<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookUserModel extends Model
{

    protected $table = "book_user";
    protected $fillable = ['user_id', 'book_id', 'status', 'pay_day', 'sendToEmail'];


    function book()
    {
        return $this->belongsTo(Book::class);
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }

}
