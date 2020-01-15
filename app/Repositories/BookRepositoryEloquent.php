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
        $this->model->dataBook();

    }

    public function bookList()
    {
        if (Auth::User()->role == User::ADMIN) {
            $books = $this->model->showListWithAdmin();
        } else {
            $books = $this->model->showListWithUser();
        }

        return $books;
    }

    public function addBook(Request $request)
    {
        $this->model->addDataBook($request);
    }

    public function updateBook(Request $request)
    {
        $books = $this->model->updateBook($request);

        return $books;
    }

    public function deleteBook($id)
    {
        $this->model->deleteBook($id);
    }

    public function restoreBook($id)
    {
        $this->model->restoreBookById($id);
    }

    public function restore()
    {
        $books = $this->model->restoreBook();

        return $books;
    }

    public function show($id)
    {
        $bookDetail = $this->model->showBook($id);
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
        $this->model->userBorrow($bookId);
    }
    public function userPayBook($bookId)
    {
        $this->model->userPayBook($bookId);
    }

}
