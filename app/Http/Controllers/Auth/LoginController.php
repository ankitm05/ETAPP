<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use App\Models\Admin;
use Session;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm() {
        return view('login');
    }

    public function index() {
        return view('login');
    }

    public function login(Request $request,MessageBag $message_bag) {
        
        if($request->isMethod("post")) {
            $this->validate($request, [
              'email'   => 'required|email',
              'password' => 'required|min:5'
            ]);
            
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password,'status'=>1],$request->remember)) {
                return redirect()->intended(route('dashboard'));

            } else {
                $check = Admin::where(['email'=>$request->email])->first();
              
                if($check) {

                    if($check->status == 0) {
                        Session::flash('_old_input.email',$request->email);
                        $message_bag->add('email','User is inactive.');
                    } else {
                        Session::flash('_old_input.email',$request->email);
                        $message_bag->add('email','These credentials do not match.');  
                    }
                } else{
                    Session::flash('_old_input.email',$request->email);
                    $message_bag->add('email','These credentials do not match.');
                }
                return view('login')->withErrors($message_bag);
            }
        }
        return view('login');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
