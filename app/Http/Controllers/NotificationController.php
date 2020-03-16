<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Admin;
use App\User;
use Session;
use Auth;
use App\Models\Notification;

class NotificationController extends Controller
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
    public function index($id) {
        $getNotify = Notification::where(['notify_id'=>$id])->orderBy('id','DESC')->get();
        $notifyDatas = array();

        if($getNotify) {

            foreach($getNotify as $getNotif) {
                $notifyDatas[] = ['content'=>$getNotif->content, 'date'=> date('d-M-Y', strtotime($getNotif->created_at))];
            }
        } else {
                $notifyDatas;
        }
        return view('notify',compact('id','notifyDatas'));
    }

}
