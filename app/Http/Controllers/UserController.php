<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Interfaces\UserInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function edit()
    {
        return $this->userRepository->edit();
    }

    public function update(UserRequest $request)
    {
        return $this->userRepository->update($request);
    }

    public function delete(Request $request)
    {
        return $this->userRepository->delete($request);
    }

    public function enrollment()
    {
        return $this->userRepository->enrollment();
    }
    public function userEnrollment(Request $request)
    {
        return $this->userRepository->userEnrollment($request);
    }
}
