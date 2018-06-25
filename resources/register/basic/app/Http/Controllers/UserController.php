<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Http\Requests\StoreUser;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(StoreUser $request)
    {
        if (!$this->repository->skipCache()->findByField('email', $request->get('email'))->isEmpty()) {
            return redirect()->back()->with(['flash_level' => 'warning', 'flash_message' => 'Email already exists']);
        }

        $data           = $request->all();
        $user           = $this->repository->create($data);
        $user->password = Hash::make($data['password']);
        $user->status   = User::STATUS_ACTIVE;
        $user->save();

        Auth::login($user);

        return redirect('/')->with(['flash_level' => 'success', 'flash_message' => 'User registered success']);
    }
}
