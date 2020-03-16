<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use App\User;
use Session;
use Auth;
Use App\Models\EmailVerification;
Use App\Models\PasswordVerification;
use Lcobucci\JWT\Parser;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerificationCode;
use App\Mail\PasswordChange;


class AuthController extends Controller {
    
    public function login(Request $request) {

        try {
            $validator= Validator::make($request->all(),[
                'email' =>"required|email",
                'password'=>'required',
                'device_type'=>'required',
                'device_token'=>'required',
                'latitude'=>'required',
                'longitude'=>'required',
            ]);
    
            $user= User::where('email',$request->email)->first();

            if($validator->fails()){
                return response()->json([
                'message' => $validator->errors()->first(),
                'status'=>'FALSE',
                "loginResponse"=>(object)[]
                ],Response::HTTP_OK);
            }
        
            if(!$user){
                return response(['status'=>'FALSE','message'=>'User not found',"login"=>(object)[]]);
            }
        
            if($user->status !=1) {
                return response(['status'=>'FALSE','message'=>'User is block']);
            }

            if($user->is_email_verify !=1) {
                return response(['status'=>'FALSE','message'=>'Email not verified',"login"=>(object)[]]);
            }
          
            if(Hash::check($request->password, $user->password)) {
                $user->device_type = $request->device_type;
                $user->device_token = $request->device_token;
                $user->latitude = $request->latitude;
                $user->longitude = $request->longitude;
                $user->save();
                $http = new Client;
        
                $response = $http->post(url('oauth/token'), [
                        'form_params' => [
                        'grant_type' => 'password',
                        'client_id' => '2',
                        'client_secret' => env('PASSPORT_CLIENT_SECRET',null),
                        'username' => $user->email,
                        'password' => $request->password,
                        'scope' => '',
                    ],
                ]);
                return response()->json(["login"=>['auth' => json_decode((string)$response->getBody(), true), 'user' => new UserResource($user)],'status'=>'TRUE'],Response::HTTP_OK);
            } else {
                return response()->json(['message'=>'password not match','status'=>'FALSE'],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
          
          return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function emailotp(Request $request) {
        try {
            $validator= Validator::make($request->all(),[
                'email'=>'required|email',
            ]);

            if($validator->fails()){
                return response()->json([
                'message' => $validator->errors()->first(),
                'status'=>'FALSE',
                "email_verification_code"=>(object)[]
                ],Response::HTTP_OK);
            }
            $email = $request->email;
            $otp = $this->random_strings(4);

            $haveEmail = EmailVerification::where(['email'=>$request->email])->first();
            
            if($haveEmail) {
                $haveEmail->verify_code = $otp;
                $haveEmail->save();
            } else {
                $EmailVerification = new EmailVerification;
                $EmailVerification->email = $email;
                $EmailVerification->verify_code = $otp;
                $EmailVerification->save();
            }
            Mail::to($email)->send(new EmailVerificationCode($email, $otp));

            return response()->json(['status'=>'TRUE','message'=>'Email verification code has been send to your email id'],Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function verifyemailotp(Request $request) {
        try {
            $validator= Validator::make($request->all(),[
                'verify_code'=>'required',
                'email'=>'required',
            ]);

            if($validator->fails()){
                return response()->json([
                'message' => $validator->errors()->first(),
                'status'=>'FALSE',
                "email_verification"=>(object)[]
                ],Response::HTTP_OK);
            }
            
            $verify = EmailVerification::where(['email'=>$request->email,'verify_code'=>$request->verify_code])->first();
            
            if($verify) {
                $verify->delete();
                return response()->json(['status'=>'TRUE','message'=>'Email Verified'],Response::HTTP_OK);
            } else {
                return response()->json(['status'=>'FALSE','message'=>'Email Verification code invalid'],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function checkemail(Request $request) {
        try {
            $validator= Validator::make($request->all(),[
                'email'=>'required',
            ]);

            if($validator->fails()){
                return response()->json([
                'message' => $validator->errors()->first(),
                'status'=>'FALSE',
                "checkemail"=>(object)[]
                ],Response::HTTP_OK);
            }
            
            $verify = User::where(['email'=>$request->email])->first();
            
            if($verify) {
                return response()->json(['status'=>'TRUE','message'=>'Email found'],Response::HTTP_OK);
            } else {
                return response()->json(['status'=>'TRUE','message'=>'Email not found'],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }
    
    public function register(Request $request) {
        try {
            $validator= Validator::make($request->all(),[
                'name'=>'required',
                'email'=>'required|email|unique:users,email',
                'password'=>'required|max:20|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation'=>'required',
                'latitude'=>'required',
                'longitude'=>'required',
                'device_type'=>'required',
                'device_token'=>'required'
            ]);

            if($validator->fails()){
                return response()->json([
                'message' => $validator->errors()->first(),
                'status'=>'FALSE',
                "register"=>(object)[]
                ],Response::HTTP_OK);
            }
            
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->device_type = $request->device_type;
            $user->device_token = $request->device_token;
            $user->latitude = $request->latitude;
            $user->longitude = $request->longitude;
            $user->password = bcrypt($request->password);
            $user->is_email_verify = 1;
            $user->status = 1;
            $user->save();
      
            $http = new Client;
            $response = $http->post(url('oauth/token'), [
                'form_params' => [
                'grant_type' => 'password',
                'client_id' => '2',
                'client_secret' =>env('PASSPORT_CLIENT_SECRET',null),
                'username' => $request->email,
                'password' => $request->password,
                'scope' => '',
                ],
            ]);
            return response()->json(["register"=>['auth' => json_decode((string)$response->getBody(), true), 'user' => new UserResource($user)],'status'=>'TRUE'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function forgotpassword(Request $request) {
        try {
            $validator= Validator::make($request->all(),[
                'email'=>'required|email',
            ]);

            if($validator->fails()){
                return response()->json([
                'message' => $validator->errors()->first(),
                'status'=>'FALSE',
                "email_verification_code"=>(object)[]
                ],Response::HTTP_OK);
            }
            $email = $request->email;
            $newPassword = $this->random_strings(8);
            
            $haveEmail = User::where(['email'=>$email])->first();
            
            if($haveEmail) {
                
                $haveEmail->password = bcrypt($newPassword);
                $haveEmail->save();

                Mail::to($email)->send(new PasswordChange($email, $newPassword));
                return response()->json(['status'=>'TRUE','message'=>'New Password has been send to your email id'],Response::HTTP_OK);
            } else {
                return response()->json(['status'=>'FALSE','message'=>'Email id not exists'],Response::HTTP_OK);
            }
            
        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function random_strings($length_of_string) {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($str_result), 0, $length_of_string); 
    }

    public function logout(Request $request) {
        try {
            $value = $request->bearerToken();
            $id = (new Parser())->parse($value)->getHeader('jti');
            $token = $request->user()->tokens->find($id);
            $token->revoke();

            $user = User::where('id',Auth::user()->id)->first();
            if($user) {
                $user->device_token = "";
                $user->save();
            }

            return response()->json(['message'=>"successful",'status'=>'TRUE'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_INTERNAL_SERVER_ERROR);
        } 
    }

    public function changepassword(Request $request) {
        try {
            $validator= Validator::make(request()->all(),[
                'email'=>'required',
                'old_password'=>'required',
                'new_password'=>'required',
            ]);
            
            if($validator->fails()){
                return response()->json(['message' => $validator->errors()->first(),'status'=>'FALSE',"response"=>[]],Response::HTTP_OK);
            }
            
            $user = User::where('email',$request->email)->first();

            if(!Hash::check($request->old_password, $user->password)) {
                return response()->json(
                [
                    'status'=>'FALSE',
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
}

?>