<?php

namespace App\Repositories;

use App\BookUserModel;
use App\Validators\BookUserValidator;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class BookUserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BookUserRepositoryEloquent extends BaseRepository implements BookUserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BookUserModel::class;
    }

    public function createUser($bookId, Request $request)
    {
        $this->model->createUser($bookId, $request);
    }

    public function giveBookBack()
    {
        $giveBookBacks = $this->model->payBook();

        return $giveBookBacks;

    }

    public function payBook($process_id)
    {
        $this->model->userPayBook($process_id);
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
