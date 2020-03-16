<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Admin;
use Auth;
use Session;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    public function register(Request $request) {
        if($request->isMethod("post")) {
            //validate
            $this->validate($request, [
              'username' => ['required', 'string','min:5', 'max:15'],
              'email' => ['required', 'string', 'email', 'max:255', 'unique:admins','required_with:confirm_email','same:confirm_email'],
              'confirm_email'=> 'required',
              'password' => ['required', 'string', 'min:5','required_with:confirm_password','same:confirm_password'],
              'confirm_password'=>'required',
            ]);

            Admin::create([
              'username'=>$request->username,
              'email'=>$request->email,
              'password'=>bcrypt($request->password),
              'type'=>1,
              'status'=>1
            ]);
            Session::flash('success', 'User Registered successfully .');
            return redirect()->route('login');
        }
        return view('register');
    }

    public function showRegistrationForm() {
        return view('register');
    }
}
