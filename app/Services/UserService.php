<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserService
{
    public function registerValidate($user)
    {
        $rules = [
            'username' => ['required','min:3','max:20','unique:users'],
            'email' => ['required','email','unique:users'],
            'password' =>['required','min:8','max:16','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[!@#$%^&*-])/'],
            'confirm_password' => ['required','same:password'],
            'phone' => ['required','unique:users','regex:/^[0-9]{10}$/']
        ];

    $validation = Validator::make($user, $rules);

    if ($validation->fails()) {
        $this->error = $validation->errors();
        return false;
        } else {
        return true;
        }
    }

    public function updateValidate($user)
    {
        $rules = [
            'username' => ['required','min:3','max:20','unique:users'],
            'email' => ['required','email','unique:users'],
            'phone' => ['required','unique:users','regex:/^[0-9]{10}$/']
        ];

    $validation = Validator::make($user, $rules);

    if ($validation->fails()) {
        $this->error = $validation->errors();
        return false;
        } else {
        return true;
        }
    }

    public function forgotValidate($user)
    {
        $rules = [
            'email' => ['required','email','exists:users']
            ];

    $validation = Validator::make($user, $rules);

    if ($validation->fails()) {
        $this->error = $validation->errors();
        return false;
        } else {
        return true;
        }
    }

    public function resetValidate($user)
    {
        $rules = [
            'email' => ['required','email','exists:users'],
            'token' => 'required|string',
            'password' => 'required|string',
            ];

    $validation = Validator::make($user, $rules);

    if ($validation->fails()) {
        $this->error = $validation->errors();
        return false;
        } else {
        return true;
        }
    }

    public function changeValidate($user)
    {
        $rules = [
            'current_password' => 'required',
            'new_password' =>['required','min:8','max:16','confirmed','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[!@#$%^&*-])/'],
            ];

    $validation = Validator::make($user, $rules);

    if ($validation->fails()) {
        $this->error = $validation->errors();
        return false;
        } else {
        return true;
        }
    }
}