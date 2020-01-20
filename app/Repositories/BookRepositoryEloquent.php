<?php

namespace App\Repositories;

use App\Book;
use App\Jobs\delayWhenBorrow;
use App\User;
use App\Validators\BookValidator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class BookRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BookRepositoryEloquent extends BaseRepository implements BookRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Book::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function index()
    {
        return $this->orderBy('id', 'desc')->paginate('2');
    }

    public function bookList($options = array())
    {
        //dd($options);
        if (Auth::User()->role == User::ADMIN) {
            if ($options['type'] == 3) {
                return $this->orderBy('id', 'desc')->paginate('10');
            }
            $books = $this->where('status', '=', $options['type'])->orderBy('id', 'desc')->paginate(10);
        } else {
            $books = $this->where('status', '!=', User::DAMUON)->orderBy('id', 'desc')->paginate(10);
        }

        return $books;
    }

    public function addBook(Request $req)
    {
        return $this->create([
            'book_title' => $req->book_title,
            'author_id'  => $req->author_id,
        ]);
    }

    public function updateBook(Request $request)
    {
        $dataBook = $this->find($request->id);
        $dataBook->update($request->all());

        return $dataBook;
    }

    public function deleteBook($id)
    {
        return $this->find($id)->delete();
    }

    public function restoreBook($id)
    {
        $dataBook = $this->withTrashed()->find($id);
        $dataBook->update([
            'deleted_at' => null
        ]);

        return $dataBook;
    }

    public function restore()
    {
        $books = $this->onlyTrashed('deleted_at')->paginate(10);

        return $books;
    }

    public function show($id)
    {
        $bookDetail = $this->find($id);
        $bookDetail->update([
            'status' => Book::DANGXEM,
        ]);
        $current = Carbon::now();
        /** run job */
        // de dua mot job vao queues su dung dispatch
        delayWhenBorrow::dispatch($bookDetail)->delay(Carbon::now()->addMinutes(1));

        /**
         * compact [
         *      'bookDetail' => $bookDetail,
         *      'current' => $current
         * ]
         */
        return compact('bookDetail', 'current');
    }

    public function borrowBook($bookId)
    {
        $book = $this->find($bookId);
        $status = $book->update([
            'status' => User::DAMUON
        ]);

        return $book;
    }

    public function userPayBook($bookId)
    {
        $book = $this->find($bookId);
        $status = $book->update([
            'status' => Book::COTHEMUON
        ]);

        return $book;
    }

}
