<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use App\User;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;


class ChatController extends Controller {
    
    public function index(Request $request) {
    	$validator = Validator::make($request->all(),[
            'sender_id' =>"required",
            'reciver_id' =>"required",
        ]);

        if($validator->fails()){
            return response()->json([
	            'message' => $validator->errors()->first(),
	            'status'=>'FALSE',
	            "history"=>(object)[]
            ],Response::HTTP_OK);
        }
        
    	$sender_id = request()->sender_id;
    	$reciver_id = request()->reciver_id;
    	$chartroom = DB::table('chat_room')->select("room_id")->where(['sender_id'=>$sender_id, 'reciver_id' => $reciver_id])->first();
    	if($chartroom){
    		return Response()->json(["room"=>$chartroom->room_id,"status"=>"TRUE"],Response::HTTP_OK);
    	}	

    	$roomId = 'room'.$sender_id.$reciver_id;

    	if(DB::table('chat_room')->insert([
	    		[
	    			'sender_id' => $sender_id, 
	    			'reciver_id' => $reciver_id,
	    			'room_id'=>$roomId
	    		],
	    		[
	    			'sender_id' => $reciver_id, 
	    			'reciver_id' => $sender_id,
	    			'room_id'=>$roomId
	    		]
	    		])
    		)
    	{
    		return Response()->json(["room"=>$roomId,"status"=>"TRUE"],Response::HTTP_OK) ; 
    	} else {
    		return Response()->json(["message"=>"Room id not created","status"=>"FALSE"],Response::HTTP_ERROR);
    	}

    }

    public function history(Request $request) {
    	$validator = Validator::make($request->all(),[
            'room_id' =>"required",
        ]);

        if($validator->fails()){
            return response()->json([
	            'message' => $validator->errors()->first(),
	            'status'=>'FALSE',
	            "history"=>(object)[]
            ],Response::HTTP_OK);
        }

        $roomId = request()->room_id;
        $history = DB::table('chat')->select("sender_id","reciver_id","message","created_at")->where(['room_id'=>$roomId])->get();

        $historyArr = array();
        if($history) {

            foreach($history as $his) {
                $historyArr[] = ["sender_id"=>(string)$his->sender_id, "reciver_id"=>(string)$his->reciver_id, "message"=>$his->message, "created_on"=> date('Y-m-d H:m:s',strtotime($his->created_at))];
            }
        	return Response()->json(["history"=>$historyArr,"status"=>"TRUE"],Response::HTTP_OK) ;
        } else {
        	return Response()->json(["message"=>"No Chat found","status"=>"FALSE"],Response::HTTP_ERROR);
        }
    }

    public function lists(Request $request) {

        $history = DB::table('chat_room')->select("sender_id","reciver_id","last_message","room_id","updated_at")->where('reciver_id',Auth::user()->id)->orderBy('updated_at','DESC')->get();


        $historyArr = array();
        if($history) {

            foreach($history as $his) {

                if(strlen($his->last_message) > 0) {

                    if(Auth::user()->id != $his->sender_id) {
                        $user = DB::table('users')->select("name","profileImage","position")->where(['id'=>$his->sender_id])->first();
                        $uName = $user->name;
                        $uPosition = $user->position;
                        $uImage = $user->profileImage?asset('storage/'.$user->profileImage):'';

                        $newtime = Carbon::createFromTimeStamp(strtotime($his->updated_at))->diffForHumans();
                        $historyArr[] = ["userName"=>$uName, "userImage"=>$uImage, "position"=>$uPosition, "id"=>(string)$his->sender_id, "message"=>$his->last_message, "room_id"=>$his->room_id, "created_on"=>$newtime];
                    }
                }
            }
            return Response()->json(["lists"=>$historyArr,"status"=>"TRUE"],Response::HTTP_OK) ;
        } else {
            return Response()->json(["message"=>"No Chat found","status"=>"FALSE"],Response::HTTP_ERROR);
        }
    }

}
?>