<?php

namespace App\Http\Controllers\Api;

use App\Entities\User;
use App\Repositories\UserRepository;
use App\Validators\UserValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends ApiController
{
    public $repository;
    private $validator;

    public function __construct(UserRepository $repository, UserValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    public function store(Request $request)
    {
        $this->validator->isValid($request, 'RULE_CREATE');
        if (!$this->repository->skipCache()->findByField('email', $request->get('email'))->isEmpty()) {
            throw new ConflictHttpException('Email already exist', null, 1001);
        }

        $data           = $request->all();
        $user           = $this->repository->create($data);
        $user->password = Hash::make($data['password']);
        $user->status   = User::STATUS_ACTIVE;
        $user->save();

        $token = JWTAuth::fromUser($user);
        Auth::login($user);

        return $this->response->array(compact('token'));
    }
}
