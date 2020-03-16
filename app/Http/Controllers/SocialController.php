<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Admin;
use App\User;
use Session;
use App\Models\Post;
use App\Models\Comment;

class SocialController extends Controller
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
        $id =$id;
        $posts = Post::where(['event_id'=>$id])->with('user')->orderBy('id','DESC')->get();

        if($posts) {
            $postData = array();
            
            foreach($posts as $post) {
                if(strlen($post->user->profileImage) > 0) {
                    $profileimg = asset('storage/'.$post->user->profileImage);
                } else {
                    $profileimg = "";
                }
                $commentCounts = Comment::where(['post_id'=>$post->id])->count();

                $postData[] = [
                    "id" => $post->id,
                    "content" => $post->post_content,
                    "image" => asset('storage/'.$post->post_image),
                    "created" => date('d-M-Y',strtotime($post->created_at)),
                    "userName" => $post->user->name,
                    "userImage" => $profileimg,
                    "totalCount"=>$commentCounts,
                ];
            }
        } else {
            $postData = [];
        }
        return view('social',compact('postData','id'));
    }

    public function deletepost($id) {
        $id = $id;
        Post::where(['id'=>$id])->delete();
        Comment::where(['post_id'=>$id])->delete();
        return redirect()->back();
    }

    public function comment($pid, $id) {
        $id = $id;
        $comments = Comment::where(['post_id'=>$pid])->with('user')->orderBy('id','DESC')->get();

        if($comments) {
            $commentData = array();
            
            foreach($comments as $comment) {
                $commentData[] = [
                    "id" => $comment->id,
                    "content" => $comment->content,
                    "created" => date('d-M-Y',strtotime($comment->created_at)),
                    "userName" => $comment->user->name,
                ];
            }
        } else {
            $commentData = [];
        }
        return view('comment',compact('commentData','id'));
    }

    public function deletecomment($id) {
        $id = $id;
        $comments = Comment::where(['id'=>$id])->delete();
        return redirect()->back();
    }
}
