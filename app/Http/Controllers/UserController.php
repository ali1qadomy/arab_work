<?php

namespace App\Http\Controllers;

use App\Events\NewUser;
use App\Events\WelcomeEmail;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUser;
use App\Models\User;
use App\Traits\CustomTrait;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class UserController extends Controller
{
    use CustomTrait;

    public function getUsers()
    {
        try {
            $user = User::all();
            if ($user->isEmpty()) {
                return CustomTrait::ErrorResponse('no data found', 404);
            }

            return CustomTrait::SuccessResponse($user, 200);
        } catch (\Exception $e) {
            return CustomTrait::ErrorResponse('there is something error', 500);
        }
    }

    public function getUser($id)
    {

        //if use authntication can retrive user is loggin auth()->user()->id without pass id with url

        $user = User::find($id);
        if (!$user) {
            return CustomTrait::ErrorResponse('there is something error', 500);
        }
        return CustomTrait::SuccessResponse($user, 200);
    }

    public function create(CreateUser $request)
    {

        //in unhappy scnario can use db::transaction and roll back if user created and event get error or failure
        try {
            $validate = $request->validated();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone_number,
                'date_of_birth' => $request->date_of_birth,
            ]);

            event(new NewUser($user));
            return CustomTrait::SuccessResponse('user careated Successfully', 200);
        } catch (\Exception $e) {

            return  CustomTrait::ErrorResponse($e->getMessage(), 500);
        }
    }
}
