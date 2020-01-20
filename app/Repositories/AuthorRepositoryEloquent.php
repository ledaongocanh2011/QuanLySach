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
        $authors = $this->get();

        return $authors;
    }

    public function authorList()
    {
        $authors = $this->orderBy('id', 'desc')->paginate(10);

        return compact('authors');
    }

    public function addAuthor(Request $authorRequest)
    {
        $author = $this->create([
            'name' => $authorRequest->name,
        ]);;

        return $author;
    }

    public function updateAuthor(Request $request)
    {
        $author = $this->find($request->id)->update($request->all());

        return $author;
    }

    public function deleteAuthor($id)
    {
        $author = $this->find($id);
        if ($author->book->status != 2) {
            $author->delete();
        }

    }

    public function restoreAuthor()
    {
        $authors = $this->onlyTrashed('deleted_at')->paginate(10);

        return compact('authors');
    }

    public function restoreAuthorById($id)
    {
        $dataAuthor = $this->model->withTrashed()->find($id);
        $dataAuthor->update([
            'deleted_at' => null
        ]);;

        return $dataAuthor;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
