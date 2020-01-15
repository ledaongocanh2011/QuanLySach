<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use SoftDeletes;
    protected $table = "authors";
    protected $fillable = ['name', 'deleted_at'];

    function dataAuthor()
    {
        $authors = $this->all();

        return $authors;
    }

    function showList()
    {
        $authors = Author::orderBy('id', 'desc')->paginate(10);

        return $authors;
    }

    function newAuthor($authorRequest)
    {
        $dataAuthor = Author::create([
            'name' => $authorRequest->name,
        ]);

        return $dataAuthor;
    }

    function updateAuthor($request)
    {
        $dataAuthor = Author::find($request->id)->update($request->all());

        return $dataAuthor;
    }

    function deleteAuhor($id)
    {
        $dataAuthor = Author::find($id)->delete();

        return $dataAuthor;
    }

    function restoreAuthor()
    {
        $authors = Author::onlyTrashed('deleted_at')->paginate(2);

        return $authors;
    }

    function restoreById($id)
    {
        $dataAuthor = Author::withTrashed()->find($id);
        $dataAuthor->update([   
            'deleted_at' => null
        ]);

        return $dataAuthor;
    }
}
