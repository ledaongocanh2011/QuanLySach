<?php

namespace App\Repositories;

use App\User;
use App\Validators\UserValidator;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    public function userList()
    {
        $users = $this->model->showListUser();

        return compact('users');
    }
    public function updateUser(Request $request)
    {
        $this->model->updateUser($request);
    }
    public function deleteUser($id)
    {
        $this->model->deleteUser($id);
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
