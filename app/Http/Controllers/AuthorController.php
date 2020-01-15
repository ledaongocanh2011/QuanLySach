<?php

namespace App\Http\Controllers;

use App\Repositories\AuthorRepository;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * @var AuthorRepository
     */
    private $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    function index()
    {
        return view('author-managerment');
    }

    function authorList()
    {
        $authors = $this->authorRepository->authorList();

        return view('author-list', $authors);
    }

    function addAuthor(Request $authorRequest)
    {
        $dataAuthor = $this->authorRepository->addAuthor($authorRequest);

        return $dataAuthor;
    }


    function update(Request $request)
    {
        $author = $this->authorRepository->updateAuthor($request);

        return response()->json([
            'status' => true,
        ]);
    }

    function delete($id)
    {
        $this->authorRepository->deleteAuthor($id);
    }

    function restore()
    {
        $authors = $this->authorRepository->restoreAuthor();

        return view('restore-author', $authors);
    }

    function restoreById($id)
    {
        $this->authorRepository->restoreAuthorById($id);

        return redirect('admin/authors');
    }
}
