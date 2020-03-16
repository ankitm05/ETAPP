<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Admin;
use App\User;
use Session;
use App\Models\JoinEvent;
use App\Models\Event;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $users = User::all();
        return view('usermanagement',compact('users'));
    }

    public function userEdit($id) {
        $user = User::where(['id'=>$id])->first();
        return view('edituser',compact('user'));
    }

    public function userUpdate(Request $request, $id) {
        $validator= Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email'
        ]);
        $checkUser = User::where(['id'=>$id])->first();
        $checkUser->name = $request->name;
        $checkUser->position = $request->position?$request->position:'';
        $checkUser->company_name = $request->company_name?$request->company_name:'';
        $checkUser->website = $request->website?$request->website:'';
        $checkUser->phone = $request->phone?$request->phone:'';
        $checkUser->location = $request->location?$request->location:'';
        $checkUser->save();
        
        return redirect()->route('user-management');
    }

    public function userStatus($id) {
        $checkUser = User::where(['id'=>$id])->first();
        
        if($checkUser->status == 1) {
            $checkUser->status = 0;
            $checkUser->save();
        } else {
            $checkUser->status = 1;
            $checkUser->save();
        }
        return redirect()->back();
    }

    public function joinedusers($id) {
        $joins = JoinEvent::where(['event_id'=>$id])->orderBy('id','DESC')->get();
        
        if($joins) {
            $eventData = array();

            foreach($joins as $join) {
                $user = User::where(['id'=> $join->user_id])->first();
                $eve = Event::where(['id'=> $id])->first();
                $eventData[] = [
                    "name" => $user->name,
                    "email" => $user->email,
                    "phone" => $user->phone?$user->phone:'',
                    "status" => $join->status,
                    "eventcode"=>$eve->event_code
                ];
            }
        } else {
            $eventData =[];
        }
        return view('joins',compact('id','eventData'));
    }

    public function subadminjoinedusers($id) {
        $joins = JoinEvent::where(['event_id'=>$id])->orderBy('id','DESC')->get();
        
        if($joins) {
            $eventData = array();

            foreach($joins as $join) {
                $user = User::where(['id'=> $join->user_id])->first();
                $eve = Event::where(['id'=> $id])->first();
                $eventData[] = [
                    "name" => $user->name,
                    "email" => $user->email,
                    "phone" => $user->phone?$user->phone:'',
                    "status" => $join->status,
                    "eventcode"=>$eve->event_code
                ];
            }
        } else {
            $eventData =[];
        }
        return view('subadminjoins',compact('id','eventData'));
    }

    public function adminUpdate(Request $request, $id) {
        $validator= Validator::make($request->all(),[
            'password' => ['required', 'string', 'min:5','required_with:confirm_password','same:confirm_password'],
            'confirm_password'=>'required',
        ]);
        
        $checkUser = Admin::where(['id'=>$id])->first();
        $checkUser->password = bcrypt($request->password);
        $checkUser->save();

        Session::flash('success', 'Password Updated successfully .');
        
        return redirect()->back();
    }
}
