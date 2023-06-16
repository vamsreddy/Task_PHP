<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;    
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules\Password as RulesPassword;

class UserController extends UserService
{
    public function index()
    {
        $user = User::all();  //getting the list of users
        return response()->json([
            "status" => true,
            "message" => "users List.",
            "data" => $user
        ]);
    }

    public function register(Request $request)
    {
        $validData = $this->registerValidate($request->all());

        if ($validData) {

        $user = new User();  //registration of the new user
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->confirm_password = bcrypt($request->confirm_password);
        $user->phone = $request->phone;
        $user->save();

        return response()->json([
                "status" => true,
                "message" => "Registration successfully.",
                "data" => $user],201);
            }else{
            return response()->json([
                "status" => false,
                "message" => "Not Registered.",
                "errors" => $this->error],422);
            }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password'); //user login with credentials

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token')->accessToken;

            return response()->json([
                "status" => true,
                "message" => "logged in successfully.",
                "token" => $token],200);
        } else {
            return response()->json([
                "status" => false,
                "message" => "log in failed.",
                "error" => "Invalid credentials"],422);
        }
    }

    public function getProfile()
    {
        $user = auth()->user();

        return response()->json([   // getting the user profile details
            'username' => $user->username,
            'email' => $user->email,
            'phone' => $user->phone 
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validData = $this->updateValidate($request->all());

            if ($validData) {
                $user->username = $request->username;
                $user->phone = $request->phone;

                $user->save();     //  updating the user profile details
                return response()->json([
                            "status" => true,
                            "message" => "user profile updated successfully.",
                            "data" => $user
                        ]);
            }else{ 
                return response()->json([
                    "status" => false,
                    "message" => "Validation errors",
                    "errors" => $this->error]); 
                }  
    }

    public function forgotPassword(Request $request)
    {
        $validData = $this->forgotValidate($request->all());

        if ($validData) {
        }else{ 
            return response()->json([
            "status" => false,
            "message" => "Validation errors",
            "errors" => $this->error]);
            }

        $response = Password::sendResetLink($request->only('email'));  // sending reset link to registered mail

        if ($response) {
                return response()->json([
                    "status" => true,
                    "message" => "Password reset email sent successfully"]);
        }
    }

    public function resetPassword(Request $request)
    {
        $validData = $this->resetValidate($request->all());

        if ($validData) {
        }else{ 
            return response()->json([
            "status" => false,
            "message" => "Validation errors",
            "errors" => $this->error]);
            }

        $response = Password::reset($request->only(
            'email', 'password', 'password_confirmation', 'token'
        ), function ($user, $password) {      //reset the user password using token 
            $user->forceFill([
                'password' => bcrypt($password),
                'remember_token' => Str::random(60),
            ])->save();
            $user->tokens()->delete();
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return response()->json([
                    "status" => true,
                    "message" => "Password reset successfully"]);

            case Password::INVALID_TOKEN:
                return response()->json([
                    "status" => false,
                    "message" => "Given Token is Invalid"]);
        }
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();

        $validData = $this->changeValidate($request->all());

        if ($validData) {
        }else{ 
            return response()->json([
            "status" => false,
            "message" => "Validation errors",
            "errors" => $this->error]);
            }
       
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([    //changing the password by entering old password
                    "status" => false,
                    "message" => "Current password is incorrect"]);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                "status" => true,
                "message" => "Password changed successfully"]);
    }

}