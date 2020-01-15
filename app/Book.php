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

    //function User()
    //{
    //    return $this->belongsToMany(User::class, 'book_user');
    //}

    function dataBook()
    {
        $books = $this->orderBy('id', 'desc')->paginate('2');

        return $books;
    }

    function showBook($id)
    {
        $bookDetail = $this->find($id);
        $bookDetail->update([
            'status' => self::DANGXEM,
        ]);

        return $bookDetail;
    }

    function addDataBook($req)
    {
        $book = $this->create([
            'book_title' => $req->book_title,
            'author_id'  => $req->author_id,
        ]);

        return $book;
    }

    function showListWithAdmin()
    {
        $books = $this->orderBy('id', 'desc')->paginate(10);

        return $books;
    }

    function scopeRuleUser($query)
    {
        return $query->where('status', '!=', User::DAMUON);
    }

    function showListWithUser()
    {

        $books = $this->ruleUser()->orderBy('id', 'desc')->paginate(10);

        return $books;
    }

    function updateBook($request)
    {
        $dataBook = Book::find($request->id);

        $dataBook->update($request->all());

        return $dataBook;
    }

    function deleteBook($id)
    {
        $dataBook = Book::find($id)->delete();

        return $dataBook;
    }

    function restoreBook()
    {
        $books = $this->onlyTrashed('deleted_at')->paginate(2);

        return $books;
    }

    function restoreBookById($id)
    {
        $dataBook = Book::withTrashed()->find($id);
        $dataBook->update([
            'deleted_at' => null
        ]);

        return $dataBook;
    }

    function userBorrow($bookId)
    {
        // lay sach
        $book = Book::find($bookId);
        // chuyen trang thai cua sach sang da muon
        $status = $book->update([
            'status' => User::DAMUON
        ]);

        return $book;
    }

    function userPayBook($bookId)
    {
        $book = Book::find($bookId);
        $status = $book->update([
            'status' => Book::COTHEMUON
        ]);

        return $book;

    }
}
