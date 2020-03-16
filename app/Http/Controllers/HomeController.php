<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Session;
use Auth;
use App\Models\Event;
use App\Models\Sponser;
use App\User;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        // dd(Auth::user()->id);
        $eventCount = Event::where('userid',Auth::user()->id)->count();
        $events = Event::where('userid',Auth::user()->id)->where(['status'=>1])->get();
        $eventData = array();

        if($events) {
            $sponserTotal = 0;
            
            foreach($events as $event) {
                $sponserLists = Sponser::where(['event_id'=>$event->id])->count();
                
                if($sponserTotal == 0) {
                    $eventData = [
                            'banner'=>$event->banner,
                            'datefrom'=>$event->datefrom,
                            'dateto'=>$event->dateto,
                            'name'=>$event->name,
                            'id'=>$event->id,
                            'status'=>$event->status
                    ];
                }
                $sponserTotal = $sponserLists + $sponserTotal;
            }
        } else {
            $sponserTotal = 0;
            $eventData = [];
        }

        $userCount = User::where(['status'=>1])->count();
        return view('dashboard', compact('eventCount','sponserTotal','userCount','eventData'));
    }

  

    public function myprofile() {
        $myprofile = Admin::where('id',Auth::user()->id)->first();
        return view('myaccount', compact('myprofile'));
    }

    public function subadminlist() {
        $getUsers = Admin::whereNotIn('type', [0])->get();
        $users = array();

        foreach($getUsers as $getUser) {
            $eventCount = Event::where('userid',$getUser->id)->count();
            $users[] = [
                        "id"=>$getUser->id,
                        "username"=>$getUser->username,
                        "email"=>$getUser->email,
                        "status"=>$getUser->status,
                        "created_at"=>$getUser->created_at,
                        "eventCount"=>$eventCount,
                    ];
        }

        return view('subadmin',compact('users'));
    }

    public function subadminStatus($id) {
        $checkUser = Admin::where(['id'=>$id])->first();
        
        if($checkUser->status == 1) {
            $checkUser->status = 0;
            $checkUser->save();

            DB::table('events')->where('userid',$id)->update(['status' => 0]);

        } else {
            $checkUser->status = 1;
            $checkUser->save();
        }
        return redirect()->back();
    }


}
