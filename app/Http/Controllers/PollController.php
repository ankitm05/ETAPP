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
use App\Models\Questionnare;
use App\Models\UserQuestionnare;
use App\Models\JoinEvent;

class PollController extends Controller
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
        $quess = Questionnare::where(['event_id'=>$id])->get();

        if($quess) {
            $quesData = array();
            
            foreach($quess as $ques) {
                $quesDataModals = array();

                $noOfVotes = UserQuestionnare::where(['event_id'=>$id, 'question_id'=>$ques->id])->count();

                $noOfjoined = JoinEvent::where(['event_id'=>$id])->count();

                $optionaVotes = UserQuestionnare::where(['event_id'=>$id, 'question_id'=>$ques->id, 'selected'=>1])->count();
                $optionaPre = $optionaVotes / $noOfjoined * 100;

                $optionbVotes = UserQuestionnare::where(['event_id'=>$id, 'question_id'=>$ques->id, 'selected'=>2])->count();
                $optionbPre = $optionbVotes / $noOfjoined * 100;

                $optioncVotes = UserQuestionnare::where(['event_id'=>$id, 'question_id'=>$ques->id, 'selected'=>3])->count();
                $optioncPre = $optioncVotes / $noOfjoined * 100;

                $optiondVotes = UserQuestionnare::where(['event_id'=>$id, 'question_id'=>$ques->id, 'selected'=>4])->count();
                $optiondPre = $optiondVotes / $noOfjoined * 100;

                $quesDataModals[] = [
                    "optiona" => ["name"=>$ques->optiona, "votes"=>$optionaVotes,"per"=>$optionaPre],
                    "optionb" => ["name"=>$ques->optionb, "votes"=>$optionbVotes,"per"=>$optionbPre],
                    "optionc" => ["name"=>$ques->optionc, "votes"=>$optioncVotes,"per"=>$optioncPre],
                    "optiond" => ["name"=>$ques->optiond, "votes"=>$optiondVotes,"per"=>$optiondPre],
                ];

                $quesData[] = [
                    "id" => $ques->id,
                    "question" => $ques->question,
                    "optiona" => $ques->optiona,
                    "optionb" => $ques->optionb,
                    "optionc" => $ques->optionc?$ques->optionc:'',
                    "optiond" => $ques->optiond?$ques->optiond:'',
                    "votes" => $noOfVotes,
                    "quesDataModals" => $quesDataModals
                ];
            }
        } else {
            $quesData = [];
        }

        
        return view('poll',compact('quesData','id'));
    }

    public function addpoll(Request $request, $id) {

        Questionnare::create([
            'event_id'=>$id,
            'id'=>$request->id,
            'question'=>$request->ques,
            'optiona' => $request->optiona,
            'optionb' => $request->optionb,
            'optionc' => $request->optionc,
            'optiond' => $request->optiond,
        ]);
        return redirect()->back();
    }

    public function deletepoll(Request $request) {
        Questionnare::where(['id'=>$request->id])->delete();
        return redirect()->back();
    }

    
}
