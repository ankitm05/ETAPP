<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use App\User;
use Lcobucci\JWT\Parser;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Event;


class UserController extends Controller {
    
    public function profile(Request $request) {
        try {
            $user = User::where('id',auth()->user()->id)->first();
        
            if(!$user) {
                return response(['status'=>'FALSE','message'=>'User not found',"login"=>(object)[]]);
            }
            
            return response()->json(["profile"=>['user' => new UserResource($user)],'status'=>'TRUE'],Response::HTTP_OK);
            
        } catch (\Exception $e) {
          
          return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }
    
    public function editProfile(Request $request) {
        try {
            $validator= Validator::make($request->all(),[
                'name'=>'required',
            ]);

            if($validator->fails()){
                return response()->json([
                'message' => $validator->errors()->first(),
                'status'=>'FALSE',
                "register"=>(object)[]
                ],Response::HTTP_OK);
            }

            $checkUser = User::where('id',auth()->user()->id)->first();
            
            if($checkUser) {
                $checkUser->name = $request->name;
                $checkUser->position = $request->position?$request->position:'';
                $checkUser->company_name = $request->company_name?$request->company_name:'';
                $checkUser->website = $request->website?$request->website:'';
                $checkUser->phone = $request->phone?$request->phone:'';
                $checkUser->location = $request->location?$request->location:'';

                if($request->hasFile('user_image')) {
                    $images = $request->user_image->getClientOriginalName();
                    $images = time().'_'.$images; // Add current time before image name
                    $request->user_image->storeAs('public/userimage',$images);
                    $pimage = "userimage/".$images;
                 
                    $checkUser->profileImage = $pimage;
                }
                
                $checkUser->save();
            
                return response()->json(["editProfile"=>['user' => new UserResource($checkUser)],'status'=>'TRUE'], Response::HTTP_OK);
            } else {
                return response()->json(['status'=>'FALSE','message'=>'User not exists'],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }
    
    public function changepassword(Request $request) {
        try {
            $validator= Validator::make(request()->all(),[
                'old_password'=>'required',
                'new_password'=>'required',
            ]);
            
            if($validator->fails()){
                return response()->json(['message' => $validator->errors()->first(),'status'=>'false',"response"=>[]],Response::HTTP_OK);
            }
            
            $user = User::where('id',auth()->user()->id)->first();

            if(!Hash::check($request->old_password, $user->password)) {
                return response()->json(
                [
                    'status'=>'false',
                    'message'=>'Old password does not match',
        
                ],Response::HTTP_OK);
            }
            $user->password = bcrypt($request->new_password);
            $user->save();
            return response()->json(
            [
                'status'=>'TRUE',
                'message'=>'User Password Updated',
            ], Response::HTTP_OK );
        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function notifystatuschange() {
        $user = User::where('id',auth()->user()->id)->first();
        
        if($user) {

            if($user->notify_status == 1) {
                $user->notify_status = 0;
                $user->save();
                $status = 'off';
            } else {
                $user->notify_status = 1;
                $user->save();
                $status = 'on';
            }
            return response()->json(['status'=>'TRUE','notifystatus'=>$status],Response::HTTP_OK);
        } else {
            return response()->json(['status'=>'FALSE','notifystatus'=>'User not exists'],Response::HTTP_OK);
        }
    }

    public function notifystatus() {
        $user = User::where('id',auth()->user()->id)->first();
        
        if($user) {

            if($user->notify_status == 1) {
                $status = 'on';
            } else {
                $status = 'off';
            }
            return response()->json(['status'=>'TRUE','notifystatus'=>$status],Response::HTTP_OK);
        } else {
            return response()->json(['status'=>'FALSE','notifystatus'=>'User not exists'],Response::HTTP_OK);
        }
    }

}

?>