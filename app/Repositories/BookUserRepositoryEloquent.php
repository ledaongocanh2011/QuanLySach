<?php

namespace App\Repositories;

use App\BookUserModel;
use App\Validators\BookUserValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return $this->create([
            'user_id' => Auth::id(),
            'book_id' => $bookId,
            'status'  => 0,
            'pay_day' => $request->pay_day,
        ]);
    }

    public function giveBookBack()
    {
        $giveBookBacks = $this->where('user_id', Auth::id())->paginate(10);

        return $giveBookBacks;

    }

    public function payBook($process_id)
    {
        $bookUser = $this->find($process_id);

        $bookUser->update([
            'status' => 1
        ]);;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
