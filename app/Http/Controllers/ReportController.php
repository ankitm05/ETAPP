<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Admin;
use App\User;
use Session;
use App\Models\Event;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Report;

class ReportController extends Controller
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
        $reports = Report::where(['event_id'=>$id])->with('user')->orderBy('id','DESC')->get();

        if($reports) {
            $reportData = array();
            
            foreach($reports as $report) {
                $post = Post::where(['id'=>$report->post_id])->with('user')->first();

                if(strlen($post->post_image) > 0) {
                    $postimg = asset('storage/'.$post->post_image);
                } else {
                    $postimg = "";
                }

                if(strlen($post->user->profileImage) > 0) {
                    $profileimg = asset('storage/'.$post->user->profileImage);
                } else {
                    $profileimg = "";
                }

                $reportData[] = [
                    "id"=>$report->id,
                    "postid" => $post->id,
                    "content" => $post->post_content,
                    "postimage" => $postimg,
                    "postby" => $post->user->name,
                    "postbyemail" => $post->user->email,
                    "reportby" => $report->user->name,
                    "reportbyemail" => $report->user->email,
                    "reason" => $report->reason,
                    "desc" => $report->description,
                ];
            }
        } else {
            $reportData = [];
        }
        return view('report',compact('reportData','id'));
    }

    public function deletepost($id, $pid) {
        $id = $id;
        Post::where(['id'=>$pid])->delete();
        Comment::where(['post_id'=>$pid])->delete();
        Report::where(['id'=>$id])->delete();
        return redirect()->back();
    }

}
