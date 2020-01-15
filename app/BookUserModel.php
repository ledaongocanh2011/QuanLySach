<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookUserModel extends Model
{

    protected $table = "book_user";
    protected $fillable = ['user_id', 'book_id', 'status', 'pay_day', 'sendToEmail'];

    function getUser()
    {
        $user = User::find(1);
    }

    function book()
    {
        return $this->belongsTo(Book::class);
    }

    function User()
    {
        return $this->belongsTo(User::class);
    }

    function createUser($bookId, Request $request)
    {
        //isert vao bang book_user
        $userBook = BookUserModel::create([
            'user_id' => Auth::id(),
            'book_id' => $bookId,
            'status'  => 0,
            'pay_day' => $request->pay_day,
        ]);

        return $userBook;
    }

    function payBook()
    {
        $giveBookBacks = BookUserModel::where('user_id', Auth::id())->get();

        return $giveBookBacks;
    }

    function userPayBook($process_id)
    {
        $bookUser = BookUserModel::find($process_id);

        $bookUser->update([
            'status' => 1
        ]);

        return $bookUser;
    }

}
