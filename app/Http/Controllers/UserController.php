<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    function index()
    {
        return view('user-managerment');
    }

    function userList(User $user)
    {
        $users = $this->userRepository->userList();

        return view('userList', $users);
    }


    function update(Request $request)
    {
        $this->userRepository->updateUser($request);

        return response()->json([
            'status' => true,
        ]);
    }

    function delete($id)
    {
        return $this->userRepository->deleteUser($id);
    }
}
