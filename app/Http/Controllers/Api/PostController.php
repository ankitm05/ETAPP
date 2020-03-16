<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Parser;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Models\Event;
use App\Models\Post;
use App\Models\Favourite;
use App\Models\Comment;
use App\Models\Bookmark;
use App\Models\Notification;
use App\Models\Report;
use Session;
use Auth;
use Image;

class PostController extends Controller {
    
    public function postsave(Request $request) {
        try {
            $validator= Validator::make($request->all(),[
                'event_id' =>"required",
                'post_content'=>'required',
                'post_image'=>'image|mimes:jpeg,png,jpg,gif',
            ]);

            if($validator->fails()){
                return response()->json([
                'message' => $validator->errors()->first(),
                'status'=>'FALSE',
                "loginResponse"=>(object)[]
                ],Response::HTTP_OK);
            }

            if($request->hasFile('post_image')) {
                $images = $request->post_image->getClientOriginalName();
                $images = time().'_'.$images; // Add current time before image name
                // orginal image save
                $request->post_image->storeAs('public/postimage',$images);
                $pimage = "postimage/".$images;
            } else {
                $pimage = "";
            }

            $data = Post::create([
                'event_id'=>$request->event_id,
                'user_id'=>Auth::user()->id,
                'post_content' => $request->post_content,
                'post_image' => $pimage,
            ]);
            $event = Event::where(['id'=>$request->event_id])->first();
            
            $user = User::select('id','name','profileImage')->where(['id'=>Auth::user()->id])->first();
            if(strlen($user->profileImage) > 0) {
                $profileimg = asset('storage/'.$user->profileImage);
            } else {
                $profileimg = "";
            }

            Notification::create([
                'notify_id'=> $request->event_id,
                'content'=> "New post has submited on ". $event->name ." event by ". $user->name,
            ]);
            
            if($request->hasFile('post_image')) {
                $postData = [
                    "id" => $data->id,
                    "content" => $data->post_content,
                    "image" => asset('storage/'.$data->post_image),
                    "created" => date('d-M-Y',strtotime($data->created_at)),
                    "userId" => $user->id,
                    "userName" => $user->name,
                    "userImage" => $profileimg,
                ];
            } else {
                $postData = [
                    "id" => $data->id,
                    "content" => $data->post_content,
                    "image" => '',
                    "created" => date('d-M-Y',strtotime($data->created_at)),
                    "userId" => $user->id,
                    "userName" => $user->name,
                    "userImage" => $profileimg,
                ];
            }
            return response()->json(['postsave'=>$postData,'status'=>'TRUE'], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function favouritesave(Request $request) {
        $validator= Validator::make($request->all(),[
            'event_id' =>"required",
            'post_id'=>'required',
            'is_fav'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
            'message' => $validator->errors()->first(),
            'status'=>'FALSE',
            "loginResponse"=>(object)[]
            ],Response::HTTP_OK);
        }

        $isfav = Favourite::where(["event_id"=>$request->event_id, "post_id"=>$request->post_id, "user_id"=> Auth::user()->id])->first();
        
        if($isfav) {
            
            if($request->is_fav == 1) {
                return response()->json(['havefav'=>'1','status'=>'TRUE'], Response::HTTP_OK);
            } else {
                $isfav->delete();
                return response()->json(['havefav'=>'0','status'=>'TRUE'], Response::HTTP_OK);
            }
        } else {
            Favourite::create([
                'event_id'=>$request->event_id,
                'post_id'=>$request->post_id,
                'user_id'=>Auth::user()->id,
                'fav' => $request->is_fav,
            ]);
            $event = Event::where(['id'=>$request->event_id])->first();
            $user = User::select('name','profileImage')->where(['id'=>Auth::user()->id])->first();
            Notification::create([
                'notify_id'=> $request->event_id,
                'content'=> $user->name . " like on ". $event->name ." event post",
            ]);
        }
        return response()->json(['havefav'=>'1','status'=>'TRUE'], Response::HTTP_OK);
    }

    public function commentsave(Request $request) {
        try {
            $validator= Validator::make($request->all(),[
                'post_id' =>"required",
                'content'=>'required',
            ]);

            if($validator->fails()){
                return response()->json([
                'message' => $validator->errors()->first(),
                'status'=>'FALSE',
                "loginResponse"=>(object)[]
                ],Response::HTTP_OK);
            }

            $data = Comment::create([
                'post_id'=>$request->post_id,
                'user_id'=>Auth::user()->id,
                'content' => $request->content,
            ]);
            
            $user = User::select('name','profileImage')->where(['id'=>Auth::user()->id])->first();
            if(strlen($user->profileImage) > 0) {
                $profileimg = asset('storage/'.$user->profileImage);
            } else {
                $profileimg = "";
            }
            $commentData = [
                "id" => $data->id,
                "content" => $data->content,
                "created" => date('d-M-Y',strtotime($data->created_at)),
                "userName" => $user->name,
                "userImage" => $profileimg,
            ];

            $postt = Post::where(['id'=>$request->post_id])->first();
            $event = Event::where(['id'=>$postt->event_id])->first();
            
            Notification::create([
                'notify_id'=> $request->event_id,
                'content'=> $user->name." comment on ". $event->name ." event post",
            ]);

            return response()->json(['commentsave'=>$commentData,'status'=>'TRUE'], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function commentview($id) {
        try {
            
            $post = Post::where(['id'=>$id])->with('user')->first();
            $isfav = Favourite::where(["event_id"=>$post->event_id, "post_id"=>$post->id, "user_id"=> Auth::user()->id])->first();
            if($isfav) {
                $havefav = 1;
            } else {
                $havefav = 0;
            }
            
            if(strlen($post->user->profileImage) > 0) {
                $profileimg = asset('storage/'.$post->user->profileImage);
            } else {
                $profileimg = "";
            }

            $countfav = Favourite::where(["event_id"=>$post->event_id, "post_id"=>$post->id])->count();
            $countComment = Comment::where(['post_id'=>$post->id])->count();

            $postData = [
                "id" => $post->id,
                "event_id" => $post->event_id,
                "post_content" => $post->post_content,
                "post_image" => $post->post_image?asset('storage/'.$post->post_image):'',
                "created" => date('d-M-Y',strtotime($post->created_at)),
                "userId" => $post->user->id,
                "userName" => $post->user->name,
                "userImage" => $profileimg,
                "havefav"=>$havefav,
                "countFav"=>$countfav,
                "countComment" => $countComment,
            ];

            $comments = Comment::where(['post_id'=>$id])->with('user')->get();
            
            if($comments) {
                $commentData = array();
                
                foreach($comments as $comment) {
                    if(strlen($comment->user->profileImage) > 0) {
                        $profileimg1 = asset('storage/'.$comment->user->profileImage);
                    } else {
                        $profileimg1 = "";
                    }
                    $commentData[] = [
                        "id" => $comment->id,
                        "content" => $comment->content,
                        "created" => date('d-M-Y',strtotime($comment->created_at)),
                        "userName" => $comment->user->name,
                        "userImage" => $profileimg1,
                    ];
                }
            } else {
                $commentData = [];
            }
            return response()->json(["commentview"=> $postData, "comments"=>$commentData, 'status'=>'TRUE'],Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function userdetails(Request $request) {
        try {
            $user = User::where(['id'=>$request->user_id])->first();
            if(strlen($user->profileImage) > 0) {
                $profileimg = asset('storage/'.$user->profileImage);
            } else {
                $profileimg = "";
            }
            
            $checkBookmark = Bookmark::where(['event_id'=>$request->event_id,'user_id'=>Auth::user()->id, 'bookmark_id' => $request->user_id, 'type' => 'People'])->first();
            if($checkBookmark) {
                $havebooked = 1;
            } else {
                $havebooked = 0;
            }

            $userData = [
                "id" => $user->id,
                "userImage" => $profileimg,
                "userName" => $user->name,
                "position" => $user->position,
                "companyName" => $user->company_name,
                "website" => $user->website,
                "location" => $user->location,
                "phone" => $user->phone,
                "haveBooked" =>$havebooked,
                "type"=>'People'
            ];

            $posts = Post::where(['event_id'=>$request->event_id,'user_id'=>$request->user_id])->with('user')->orderBy('id','DESC')->get();
            
            if($posts) {
                $postData = array();
                
                foreach($posts as $post) {
                    if(strlen($post->user->profileImage) > 0) {
                        $profileimg = asset('storage/'.$post->user->profileImage);
                    } else {
                        $profileimg = "";
                    }
                    $isfav = Favourite::where(["event_id"=>$request->event_id, "post_id"=>$post->id, "user_id"=> Auth::user()->id])->first();
                    if($isfav) {
                        $havefav = 1;
                    } else {
                        $havefav = 0;
                    }

                    $countfav = Favourite::where(["event_id"=>$request->event_id, "post_id"=>$post->id])->count();
                    $countComment = Comment::where(['post_id'=>$post->id])->count();
                    
                    $postData[] = [
                        "id" => $post->id,
                        "content" => $post->post_content,
                        "image" => $post->post_image?asset('storage/'.$post->post_image):'',
                        "created" => date('d-M-Y',strtotime($post->created_at)),
                        "userId" => $post->user->id,
                        "userName" => $post->user->name,
                        "userImage" => $profileimg,
                        "haveFav"=>$havefav,
                        "countFav"=>$countfav,
                        "countComment" => $countComment,
                    ];
                }
            } else {
                $postData = [];
            }
            
            return response()->json(["profile"=> $userData,'posts'=>$postData, 'status'=>'TRUE'],Response::HTTP_OK);
            
        } catch (\Exception $e) {
          
          return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function reportpost(Request $request) {
        try {
            $validator= Validator::make($request->all(),[
                'event_id' =>"required",
                'post_id' =>"required",
                'reason'=>'required',
            ]);

            if($validator->fails()){
                return response()->json([
                'message' => $validator->errors()->first(),
                'status'=>'FALSE',
                "loginResponse"=>(object)[]
                ],Response::HTTP_OK);
            }

            $data = Report::create([
                'event_id'=>$request->event_id,
                'post_id'=>$request->post_id,
                'user_id'=>Auth::user()->id,
                'reason' => $request->reason,
                'description' => $request->description?$request->description:'',
            ]);

            return response()->json(['message'=>'Report Saved','status'=>'TRUE'], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

}
?>