<?php

namespace App\Repositories;

use App\User;
use App\Validators\UserValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $users = $this->where('id', '!=', Auth::id())->orderBy('id', 'desc')->paginate(10);

        return compact('users');
    }

    public function updateUser(Request $request)
    {
        return $this->find($request->id)->update($request->all());
    }

    public function deleteUser($id)
    {
        $dataUser = $this->find($id);
        if (Auth::id() != $dataUser->id) {
            $dataUser->delete();
        }

        return $dataUser;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
