<?php

namespace App\Repositories;

use App\Author;
use App\Validators\AuthorValidator;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class AuthorRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AuthorRepositoryEloquent extends BaseRepository implements AuthorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Author::class;
    }

    public function DataAuthors()
    {
        $authors = $this->model->dataAuthor();

        return $authors;
    }

    public function authorList()
    {
        $authors = $this->model->showList();

        return compact('authors');
    }

    public function addAuthor(Request $authorRequest)
    {
        $author = $this->model->newAuthor($authorRequest);

        return $author;
    }

    public function updateAuthor(Request $request)
    {
        $author = $this->model->updateAuthor($request);

        return $author;
    }

    public function deleteAuthor($id)
    {
        $this->model->deleteAuhor($id);
    }

    public function restoreAuthor()
    {
        $authors = $this->model->restoreAuthor();

        return compact('authors');
    }
    public function restoreAuthorById($id)
    {
        $this->model->restoreById($id);
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
