<?php

namespace App\Http\Controllers;

use App\Repositories\AuthorRepository;
use App\Repositories\BookRepository;
use App\Repositories\BookUserRepository;
use App\Rules\BorrowBookRule;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * @var BookRepository
     */
    private $bookRepository;
    /**
     * @var AuthorRepository
     */
    private $authorRepository;
    /**
     * @var BookUserRepository
     */
    private $bookUserRepository;

    public function __construct(BookRepository $bookRepository,
                                AuthorRepository $authorRepository,
                                BookUserRepository $bookUserRepository)
    {
        $this->bookRepository = $bookRepository;
        $this->authorRepository = $authorRepository;
        $this->bookUserRepository = $bookUserRepository;
    }

    function create()
    {
        return view('borrow-book');
    }

    function index()
    {
        $books = $this->bookRepository->dataBook();

        return view('list-book', compact('books'));
    }

    function book()
    {
        return view('book-manager');
    }

    function show($id)
    {
        $data = $this->bookRepository->show($id);

        return view('borrow-book', $data);
    }

    function getAuthor()
    {
        $authors = $this->authorRepository->DataAuthors();

        return view('book-manager', compact('authors'));
    }


    function restore()
    {
        $books = $this->bookRepository->restore();

        return view('restore-book', compact('books'));
    }

    function restoreById($id)
    {

        $result = $this->bookRepository->restoreBook($id);
        if ($result == true) {
            return redirect('admin/getUthor');
        }
    }

    function addBook(Request $request)
    {
        $this->bookRepository->addBook($request);

        return response()->json([]);
    }

    function bookList(Request $request)
    {
        $filterData = $request->only(['page', 'type']);
        $filterData['type'] = isset($filterData['type']) ? $filterData['type'] : 0;
        $books = $this->bookRepository->bookList($filterData);
        $authors = $this->authorRepository->DataAuthors();

        return view('bookList', compact('books', 'authors'));
    }

    function update(Request $request)
    {
        $this->bookRepository->updateBook($request);

        return response()->json([
            'status' => true,
        ]);
    }

    function delete($id)
    {
        $this->bookRepository->deleteBook($id);

        return response()->json([]);
    }

    function borrowBook(Request $request, $bookId)
    {
        $this->validate($request, [
            'pay_day' => [
                new BorrowBookRule()
            ]
        ]);
        $this->bookRepository->borrowBook($bookId);
        $this->bookUserRepository->createUser($bookId, $request);

        return redirect()->route("giveBookBack");

    }

    function giveBookBack()
    {
        $giveBookBacks = $this->bookUserRepository->giveBookBack();

        return view('give-book-back', compact('giveBookBacks'));
    }

    function payBook($bookId, $process_id)
    {
        $this->bookRepository->userPayBook($bookId);
        $this->bookUserRepository->payBook($process_id);

        return redirect()->route('books');
    }

}
