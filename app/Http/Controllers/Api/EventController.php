<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use App\User;
use Lcobucci\JWT\Parser;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\Feature;
use App\Models\JoinEvent;
use App\Models\Post;
use App\Models\Questionnare;
use App\Models\UserQuestionnare;
use App\Models\About;
use App\Models\Speaker;
use App\Models\Sponser;
use App\Models\Exhibitor;
use App\Models\Schedule;
use App\Models\FloorPlan;
use App\Models\Bookmark;
use App\Models\Favourite;
use App\Models\Notification;
use App\Models\Comment;
use Session;
use Auth;

class EventController extends Controller {
    
    public function index() {
        try {
            $events = Event::where(['status'=>1])->get();
            $eventData = array();

            foreach($events as $event) {

                $eventData[] = [
                    "id" => $event->id,
                    "name" => $event->name,
                    "from" => date('d-M-Y',strtotime($event->datefrom)),
                    "to" => date('d-M-Y',strtotime($event->dateto)),
                    "venu" => $event->venu,
                    "banner" => asset('storage/'.$event->banner),
                    "logo" => asset('storage/'.$event->logo),
                ];
            }
            return response()->json(["events"=> $eventData,'status'=>'TRUE'],Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function eventfetch($id) {
        try {
            $event = Event::where(['id'=>$id, 'status'=>1])->first();

            $eventData = [
                "id" => $event->id,
                "name" => $event->name,
                "from" => date('d-M-Y',strtotime($event->datefrom)),
                "to" => date('d-M-Y',strtotime($event->dateto)),
                "venu" => $event->venu,
                "banner" => asset('storage/'.$event->banner),
                "logo" => asset('storage/'.$event->logo),
            ];

            return response()->json(["event"=> $eventData,'status'=>'TRUE'],Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function questionList($id) {
        try {
            $getQuestions = Questionnare::where(['event_id'=>$id])->get();
            $questionList = array();

            if(count($getQuestions) > 0) {
                
                foreach($getQuestions as $getQuestion) {
                    $flag = 0;
                    $getvotea = UserQuestionnare::where(['event_id'=>$id,'user_id'=>Auth::user()->id, 'question_id'=>$getQuestion->id, 'selected'=>1])->first();

                    if($getvotea) {
                        $votea = 1;
                        $flag = 1;
                    } else {
                        $votea =0;
                    }

                    $getvoteb = UserQuestionnare::where(['event_id'=>$id,'user_id'=>Auth::user()->id, 'question_id'=>$getQuestion->id, 'selected'=>2])->first();
                    if($getvoteb) {
                        $voteb = 1;
                        $flag = 1;
                    } else {
                        $voteb =0;
                    }

                    $getvotec = UserQuestionnare::where(['event_id'=>$id,'user_id'=>Auth::user()->id, 'question_id'=>$getQuestion->id, 'selected'=>3])->first();
                    if($getvotec) {
                        $votec = 1;
                        $flag = 1;
                    } else {
                        $votec =0;
                    }

                    $getvoted = UserQuestionnare::where(['event_id'=>$id,'user_id'=>Auth::user()->id, 'question_id'=>$getQuestion->id, 'selected'=>4])->first();
                    if($getvoted) {
                        $voted = 1;
                        $flag = 1;
                    } else {
                        $voted =0;
                    }

                    if(strlen($getQuestion->optionc) <= 0) {
                        $questionList[] = [
                            "id" => $getQuestion->id,
                            "question" => $getQuestion->question,
                            "answer"=> [
                                ["id"=>1,"option" => $getQuestion->optiona,"selected"=>$votea],
                                ["id"=>2,"option" => $getQuestion->optionb?$getQuestion->optionb:'',"selected"=>$voteb]
                            ],
                        ];
                    } else if(strlen($getQuestion->optiond) <= 0) {
                        $questionList[] = [
                            "id" => $getQuestion->id,
                            "question" => $getQuestion->question,
                            "answer"=> [
                                ["id"=>1,"option" => $getQuestion->optiona,"selected"=>$votea],
                                ["id"=>2,"option" => $getQuestion->optionb?$getQuestion->optionb:'',"selected"=>$voteb],
                                ["id"=>3,"option" => $getQuestion->optionc?$getQuestion->optionc:'',"selected"=>$votec]
                            ],
                        ];
                    } else {
                        $questionList[] = [
                            "id" => $getQuestion->id,
                            "question" => $getQuestion->question,
                            "answer"=> [
                                ["id"=>1,"option" => $getQuestion->optiona,"selected"=>$votea],
                                ["id"=>2,"option" => $getQuestion->optionb?$getQuestion->optionb:'',"selected"=>$voteb],
                                ["id"=>3,"option" => $getQuestion->optionc?$getQuestion->optionc:'',"selected"=>$votec],
                                ["id"=>4,"option" => $getQuestion->optiond?$getQuestion->optiond:'',"selected"=>$voted]
                            ],
                        ];
                    }
                }
            } else {
                $questionList = [];
                $flag = 1;
            }
            return response()->json(["questionnare"=> $questionList,"submited"=>$flag,'status'=>'TRUE'],Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function saveQuestion(Request $request) {
        try {
            $validator = Validator::make($request->all(),[
                'event_id' =>"required",
                'questions'=>'required',
                'answers'=>'required',
            ]);

            if($validator->fails()){
                return response()->json([
                'message' => $validator->errors()->first(),
                'status'=>'FALSE',
                "loginResponse"=>(object)[]
                ],Response::HTTP_OK);
            }

            $question = $request->questions;
            $answers = $request->answers;
            $x=0;

            foreach($question as $ques) {
                UserQuestionnare::create([
                    'event_id'=>$request->event_id,
                    'user_id'=>Auth::user()->id,
                    'question_id' => $ques,
                    'selected' => $answers[$x],
                ]);
                $x++;
            }

            return response()->json(['status'=>'TRUE','message'=>'Questionnare saved'],Response::HTTP_OK);
        }  catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        } 
    }

    public function searchevent(Request $request) {
        try {
            $events = Event::where('name', 'like', '%' . $request->keyword . '%')->where(['status'=>1])->get();
            $eventData = array();

            foreach($events as $event) {
                $eventData[] = [
                    "id" => $event->id,
                    "name" => $event->name,
                    "from" => date('d-M-Y',strtotime($event->datefrom)),
                    "to" => date('d-M-Y',strtotime($event->dateto)),
                    "banner" => asset('storage/'.$event->banner),
                    "logo" => asset('storage/'.$event->logo),
                    "venu" => $event->venu,
                ];
            }
            return response()->json(["events"=> $eventData,'status'=>'TRUE'],Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function loginsearchevent(Request $request) {
        try {
            $events = Event::where('name', 'like', '%' . $request->keyword . '%')->where(['status'=>1])->get();
            $eventData = array();

            foreach($events as $event) {
                $joinedevent = JoinEvent::where(['event_id'=>$event->id,'user_id'=> Auth::user()->id])->first();

                if($joinedevent) {
                } else {
                    $eventData[] = [
                        "id" => $event->id,
                        "name" => $event->name,
                        "from" => date('d-M-Y',strtotime($event->datefrom)),
                        "to" => date('d-M-Y',strtotime($event->dateto)),
                        "banner" => asset('storage/'.$event->banner),
                        "logo" => asset('storage/'.$event->logo),
                        "venu" => $event->venu,
                    ];
                }
            }
            return response()->json(["events"=> $eventData,'status'=>'TRUE'],Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function joinedeventcode(Request $request) {
        try {
            $validator= Validator::make($request->all(),[
                'id' =>"required",
                'verify_code'=>'required'
            ]);
    
            if($validator->fails()){
                return response()->json([
                'message' => $validator->errors()->first(),
                'status'=>'FALSE',
                "loginResponse"=>(object)[]
                ],Response::HTTP_OK);
            }

            $event = Event::where(['id'=>$request->id, 'event_code'=>$request->verify_code])->first();
            
            if($event) {
                $joinedevent = JoinEvent::where(['event_id'=>$request->id, 'user_id'=> Auth::user()->id])->first();
                
                if($joinedevent) {
                    $joinedevent->status = 1;
                    $joinedevent->save();
                }
                return response()->json(["message"=> 'Verified','status'=>'TRUE'],Response::HTTP_OK);
            } else {
                return response()->json(["message"=> 'Invalid Code','status'=>'FALSE'],Response::HTTP_OK);
            } 
        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function joinevent($id) {
        try {
            $event = Event::where(['id'=>$id, 'status'=>1])->first();
            
            if($event) {
                $joinedevent = JoinEvent::where(['event_id'=>$id,'user_id'=> Auth::user()->id])->first();
                
                if($joinedevent) {
                    
                    if($joinedevent->status == 1) {
                        return response()->json(["joinevent"=>["message"=> 'Already joined'], "message"=> 'Already joined','status'=>'TRUE'],Response::HTTP_OK);
                    } else {
                        return response()->json(["joinevent"=>["message"=> 'Event joined'],"message"=> 'Event joined','status'=>'TRUE'],Response::HTTP_OK);
                    }
                } else {
                    JoinEvent::create([
                        'event_id'=> $id,
                        'user_id'=> Auth::user()->id
                    ]);   
                }

                return response()->json(["joinevent"=>["message"=> 'Event joined'],"message"=> 'Event joined','status'=>'TRUE'],Response::HTTP_OK);
            } else {
                return response()->json(["message"=> 'Event not found','status'=>'FALSE'],Response::HTTP_OK);
            }
            
        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function joinedevents() {
        try {
            $joins = JoinEvent::where(['user_id'=>Auth::user()->id,'status'=>1])->get();
            $eventData = array();

            if($joins) {
                foreach($joins as $join) {
                    $event = Event::where(['id'=> $join->event_id,'status'=>1])->first();

                    if($event) {
                        $eventData[] = [
                            "id" => $event->id,
                            "name" => $event->name,
                            "from" => date('d-M-Y',strtotime($event->datefrom)),
                            "to" => date('d-M-Y',strtotime($event->dateto)),
                            "banner" => asset('storage/'.$event->banner),
                            "logo" => asset('storage/'.$event->logo),
                        ];
                    }
                }
            } else {
                $eventData = [];
            }
            return response()->json(["joinevents"=> $eventData,'status'=>'TRUE'],Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function joinedeventview($id) {
        try {
            $event = Event::where(['id'=>$id])->first();
            $features = EventDetail::where(['event_id'=>$event->id])->get();
            $joinedPeople = JoinEvent::where(['event_id'=>$event->id,'status'=>1])->count();
            $featureData = array();

            foreach($features as $feature) {
                $featureData[] =['id'=>$feature->id,'type'=>$feature->type,'name'=>$feature->form_name];
            }
            
            $eventData = [
                "id" => $event->id,
                "name" => $event->name,
                "from" => date('d-M-Y',strtotime($event->datefrom)),
                "to" => date('d-M-Y',strtotime($event->dateto)),
                "venu" => $event->venu,
                "banner" => asset('storage/'.$event->banner),
                "logo" => asset('storage/'.$event->logo),
                "sidemenu" => $featureData,
                "joinedPeople"=>$joinedPeople,
            ];

            $posts = Post::where(['event_id'=>$id])->with('user')->orderBy('id','DESC')->get();
            
            if($posts) {
                $postData = array();
                
                foreach($posts as $post) {
                    if(strlen($post->user->profileImage) > 0) {
                        $profileimg = asset('storage/'.$post->user->profileImage);
                    } else {
                        $profileimg = "";
                    }
                    $isfav = Favourite::where(["event_id"=>$event->id, "post_id"=>$post->id, "user_id"=> Auth::user()->id])->first();
                    if($isfav) {
                        $havefav = 1;
                    } else {
                        $havefav = 0;
                    }

                    $countfav = Favourite::where(["event_id"=>$event->id, "post_id"=>$post->id])->count();
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
            return response()->json(["event"=> $eventData, "posts"=>$postData, 'status'=>'TRUE'],Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function menus($id) {
        $features = EventDetail::where(['event_id'=>$id])->get();
        $featureData = array();

        foreach($features as $feature) {
            $featureData[] =['event_id'=>$id,'id'=>$feature->id,'type'=>$feature->type,'name'=>$feature->form_name];
        }
        return response()->json(["menus"=> $featureData,'event_id'=>$id,'status'=>'TRUE'],Response::HTTP_OK);

    }

    public function sidemenuList(Request $request) {
        try {
            $details = array();

            if($request->type == 'about') {
                $details = $this->aboutevent($request->id, $request->fid);

            } else if($request->type == 'schedule') {
                $details = $this->schedulelist($request->id, $request->fid);

            } else if($request->type == 'sponsers') {
                $details = $this->sponserList($request->id, $request->fid);

            } else if($request->type == 'exhibitors') {
                $details = $this->exhibitorList($request->id, $request->fid);

            } else if($request->type == 'speakers') {
                $details = $this->speakerList($request->id, $request->fid);
            
            } else if($request->type == 'floor_plan') {
                $details = $this->floorplan($request->id, $request->fid);

            } else if($request->type == 'people' || $request->type == 'People') {
                $details = $this->joinedpeoples($request->id);

            } else if($request->type == 'bookmark' || $request->type == 'Bookmark') {
                $details = $this->bookmarkLists($request->id);
            }

            return response()->json(["sidemenuList"=> $details,'status'=>'TRUE'],Response::HTTP_OK);
            
        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function aboutevent($id,$fid) {
        try {
            $getEvent = About::where(['event_id'=>$id,"detailsid"=>$fid])->first();

            $events = array();
            
            if($getEvent) {

                    $events = [
                        "id" => $getEvent->id,
                        "title" => $getEvent->title,
                        "content" => $getEvent->content,
                    ];
                
            } else {
                $events = [];
            }
            return $events;
        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function schedulelist($id,$fid) {
        try {
            $joins = Schedule::where(['event_id'=>$id,"detailsid"=>$fid])->orderBy('event_from','ASC')->get();
            
            if($joins) {
                $today = array();
                $upcoming = array();
                $past = array();

                foreach($joins as $join) {
                    $eventDate = new Carbon($join->event_date);
                    $eventDateFormated = Carbon::parse($eventDate)->format('d-M-Y');
                    //dd($eventDateFormated);

                    $currentDate = Carbon::now();
                    $currentDateFormated = Carbon::parse($currentDate)->format('d-M-Y');

                    $eventDate1 = strtotime($eventDateFormated);
                    $currentDate2 = strtotime($currentDateFormated);
                    
                    if($eventDate1 == $currentDate2) {
                        $today[]= [
                            'id'=>$join->id,
                            'name'=>'',
                            'venu'=>'',
                            'date'=>$eventDateFormated,
                            'timeFrom'=> Carbon::parse($join->event_from)->format('H:i'),
                            'timeTo'=> Carbon::parse($join->event_to)->format('H:i'),
                            'speaker'=>'',
                            'desc'=>$join->description,
                        ];
                    
                    } else if($eventDate1 >= $currentDate2) {
                        $upcoming[]= [
                            'id'=>$join->id,
                            'name'=>'',
                            'venu'=>'',
                            'date'=>$eventDateFormated,
                            'timeFrom'=>Carbon::parse($join->event_from)->format('H:i'),
                            'timeTo'=>Carbon::parse($join->event_to)->format('H:i'),
                            'speaker'=>'',
                            'desc'=>$join->description,
                        ];
                    
                    } else if($eventDate1 <= $currentDate2) {
                        $past[]= [
                            'id'=>$join->id,
                            'name'=>'',
                            'venu'=>'',
                            'date'=>$eventDateFormated,
                            'timeFrom'=>Carbon::parse($join->event_from)->format('H:i'),
                            'timeTo'=>Carbon::parse($join->event_to)->format('H:i'),
                            'speaker'=>'',
                            'desc'=>$join->description,
                        ];
                    
                    } else {
                        if(count($past) > 0) {} else {
                            $past =[];    
                        }
                        if(count($upcoming) > 0) {} else {
                            $upcoming =[];    
                        }
                        if(count($today) > 0) {} else {
                            $today =[];    
                        }

                    }
                }
                return $arr = ['todaylist'=>$today, 'upcominglist'=>$upcoming, 'pastlist'=> $past];
            } else {
                $today = [];
                $upcoming = [];
                $past = [];

                return $arr = ['todaylist'=>$today, 'upcominglist'=>$upcoming, 'pastlist'=> $past];
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function sponserList($id,$fid) {
        $getSponsers = Sponser::where(['event_id'=>$id,"detailsid"=>$fid])->orderBy('toprated','DESC')->get();
        $sponserList = array();
        
        if($getSponsers) {
            
            foreach($getSponsers as $getSponser) {
                
                $checkBookmark = Bookmark::where(['event_id'=>$id,'user_id'=>Auth::user()->id, 'bookmark_id' => $getSponser->id,'type'=>'sponsers'])->first();
                
                if($checkBookmark) {
                    $havebooked = 1;
                } else {
                    $havebooked = 0;
                }
                $sponserList[] = [
                    "event_id" => $id,
                    "id" =>$getSponser->id,
                    "fid"=>$fid,
                    "name" => $getSponser->name,
                    "image" => $getSponser->image? asset('storage/'.$getSponser->image):'',
                    "havebooked"=>$havebooked,
                    "website"=>$getSponser->website,
                    "type"=>'sponsers',
                ];
            }
        } else {
            $sponserList = [];
        }
        return $sponserList;
    }

    public function exhibitorList($id,$fid) {
        $getExhibitors = Exhibitor::where(['event_id'=>$id,"detailsid"=>$fid])->orderBy('toprated','DESC')->orderBy('toprated','DESC')->get();
        $exhibitorList = array();
        
        if($getExhibitors) {
            
            foreach($getExhibitors as $getExhibitor) {
                $checkBookmark = Bookmark::where(['event_id'=>$id,'user_id'=>Auth::user()->id, 'bookmark_id' => $getExhibitor->id,'type'=>'exhibitors'])->first();
            
                if($checkBookmark) {
                    $havebooked = 1;
                } else {
                    $havebooked = 0;
                }
                $exhibitorList[] = [
                    "event_id" => $id,
                    "id" =>$getExhibitor->id,
                    "fid"=>$fid,
                    "name" => $getExhibitor->name,
                    "image" => $getExhibitor->image? asset('storage/'.$getExhibitor->image):'',
                    "havebooked"=>$havebooked,
                    "website"=>$getExhibitor->website,
                    "type"=>'exhibitors',
                ];
            }
        } else {
            $exhibitorList = [];
        }
        return $exhibitorList;
    }

    public function speakerList($id,$fid) {
        $getSpeakers = Speaker::where(['event_id'=>$id,"detailsid"=>$fid])->orderBy('toprated','DESC')->get();
        $speakerList = array();
        
        if($getSpeakers) {
            
            foreach($getSpeakers as $getSpeaker) {
                $checkBookmark = Bookmark::where(['event_id'=>$id,'user_id'=>Auth::user()->id, 'bookmark_id' => $getSpeaker->id,'type'=>'speakers'])->first();
            
                if($checkBookmark) {
                    $havebooked = 1;
                } else {
                    $havebooked = 0;
                }
                $speakerList[] = [
                    "event_id" => $id,
                    "id" =>$getSpeaker->id,
                    "fid"=>$fid,
                    "name" => $getSpeaker->name,
                    "image" => $getSpeaker->image? asset('storage/'.$getSpeaker->image):'',
                    "position" => $getSpeaker->position,
                    "havebooked"=>$havebooked,
                    "website"=>$getSpeaker->website,
                    "type"=>'speakers',
                ];
            }
        } else {
            $speakerList = [];
        }
        return $speakerList;
    }

    public function floorplan($id,$fid) {
        $getFloorPlans = FloorPlan::where(['event_id'=>$id,"detailsid"=>$fid])->get();
        $floorPlans = array();
        
        if($getFloorPlans) {

            foreach($getFloorPlans as $getFloorPlan) {
                $floorPlans[] = [
                    "event_id" => $id,
                    "fid"=>$fid,
                    "name" => $getFloorPlan->name?$getFloorPlan->name:'',
                    "image" => $getFloorPlan->floor_image? asset('storage/'.$getFloorPlan->floor_image):'',
                    "type"=>'floor_plan',
                ];
            }
        } else {
            $floorPlans = [];
        }
        return $floorPlans;
    }


    public function joinedpeoples($id) {
        $joins = JoinEvent::where(['event_id'=>$id,'status'=>1])->get();
        
        if($joins) {
            $eventData = array();

            foreach($joins as $join) {
                $user = User::where(['id'=> $join->user_id])->first();
                
                $checkBookmark = Bookmark::where(['event_id'=>$id,'user_id'=>Auth::user()->id, 'bookmark_id' => $join->user_id, 'type' => 'People'])->first();
                if($checkBookmark) {
                    $havebooked = 1;
                } else {
                    $havebooked = 0;
                }
                $eventData[] = [
                    "event_id"=>$id,
                    "id" => $user->id,
                    "name" => $user->name,
                    "image" => $user->profileImage?asset('storage/'.$user->profileImage):'',
                    "position" => $user->position?$user->position:'',
                    "havebooked"=>$havebooked,
                    "type"=>'People',
                ];
            }
        } else {
            $eventData =[];
        }
        return $eventData;
    }

    public function detailview(Request $request) {
        try {
            $details = array();

            if($request->type == 'sponsers') {
                $details = $this->sponserSingle($request->id, $request->fid);

            } else if($request->type == 'exhibitors') {
                $details = $this->exhibitorSingle($request->id, $request->fid);

            } else if($request->type == 'speakers') {
                $details = $this->speakerSingle($request->id, $request->fid);
            }
            
            return response()->json(["detailview"=> $details,'status'=>'TRUE'],Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function sponserSingle($id,$fid) {
        $getSponser = Sponser::where(['id'=>$id, "detailsid"=>$fid])->first();

        $sponserList = array();
        
        if($getSponser) {

            $checkBookmark = Bookmark::where(['event_id'=>$getSponser->event_id,'user_id'=>Auth::user()->id,'bookmark_id'=>$id,'type'=>'sponsers'])->first();
        
            if($checkBookmark) {
                $havebooked = 1;
            } else {
                $havebooked = 0;
            }
            $sponserList[] = [
                "id" =>$getSponser->id,
                "image" => $getSponser->image? asset('storage/'.$getSponser->image):'',
                "havebooked"=>$havebooked,
                "type"=>'sponsers',
                "detailArray"=> [
                    "Name"=> '',
                    "CompanyName"=>$getSponser->name,
                    "Level"=> $getSponser->level,
                    "Booth"=> '',
                    "Position"=> '',
                    "Website"=> $getSponser->website,
                    "Email"=> $getSponser->email,
                    "Phone"=> $getSponser->phone,
                    "Description"=> $getSponser->description,
                ],
            ];
        } else {
            $sponserList = [];
        }
        return $sponserList;
    }

    public function exhibitorSingle($id,$fid) {
        $getSponser = Exhibitor::where(['id'=>$id, "detailsid"=>$fid])->first();
        $sponserList = array();
        
        if($getSponser) {
            
            $checkBookmark = Bookmark::where(['event_id'=>$getSponser->event_id,'user_id'=>Auth::user()->id,'bookmark_id'=>$id,'type'=>'exhibitors'])->first();
        
            if($checkBookmark) {
                $havebooked = 1;
            } else {
                $havebooked = 0;
            }
            $sponserList[] = [
                "id" =>$getSponser->id,
                "image" => $getSponser->image? asset('storage/'.$getSponser->image):'',
                "havebooked"=>$havebooked,
                "type"=>'exhibitors',
                "detailArray"=> [
                    "Name"=> '',
                    "Company Name"=> $getSponser->name,
                    "Booth"=> $getSponser->booth,
                    "Level"=> '',
                    "Position"=> '',
                    "Website"=> $getSponser->website,
                    "Email"=> $getSponser->email,
                    "Phone"=> $getSponser->phone,
                    "Description"=> $getSponser->description,
                ],

            ];
        } else {
            $sponserList = [];
        }
        return $sponserList;
    }

    public function speakerSingle($id,$fid) {
        $getSponser = Speaker::where(['id'=>$id, "detailsid"=>$fid])->first();
        $sponserList = array();
        
        if($getSponser) {

            $checkBookmark = Bookmark::where(['event_id'=>$getSponser->event_id,'user_id'=>Auth::user()->id,'bookmark_id'=>$id,'type'=>'speakers'])->first();
        
            if($checkBookmark) {
                $havebooked = 1;
            } else {
                $havebooked = 0;
            }
            $sponserList[] = [
                "id" =>$getSponser->id,
                "image" => $getSponser->image? asset('storage/'.$getSponser->image):'',
                "havebooked"=>$havebooked,
                "type"=>'speakers',
                "detailArray"=> [
                    "Name"=> $getSponser->name,
                    "CompanyName"=> $getSponser->cname,
                    "Booth"=> '',
                    "Level"=> '',
                    "Position"=> $getSponser->position,
                    "Email"=> $getSponser->email,
                    "Phone"=> $getSponser->phone,
                    "Description"=> $getSponser->description,
                ],
            ];
        } else {
            $sponserList = [];
        }
        return $sponserList;
    }

    public function bookmark(Request $request) {
        try {
            $validator= Validator::make($request->all(),[
                'event_id' =>"required",
                'bookmark_id' =>"required",
                'type' =>"required",
                'havebooked' =>"required",
            ]);

            if($validator->fails()){
                return response()->json([
                'message' => $validator->errors()->first(),
                'status'=>'FALSE',
                "loginResponse"=>(object)[]
                ],Response::HTTP_OK);
            }
            
            $checkBookmark = Bookmark::where(['event_id'=>$request->event_id,'user_id'=>Auth::user()->id, 'bookmark_id' => $request->bookmark_id, 'type' => $request->type])->first();
            
            if($checkBookmark) {
                if($request->havebooked == 1) {
                    return response()->json(['message'=>'Already Bookmarked','bookmark'=>1,'status'=>'TRUE'], Response::HTTP_OK);
                } else {
                    $checkBookmark->delete();
                    return response()->json(['message'=>'Unbookmarked successfully','bookmark'=>0,'status'=>'TRUE'], Response::HTTP_OK);
                }
            } else {
                $data = Bookmark::create([
                    'event_id'=>$request->event_id,
                    'user_id'=>Auth::user()->id,
                    'bookmark_id' => $request->bookmark_id,
                    'type' => $request->type,
                ]);
                return response()->json(['message'=>'Bookmarked successfully','bookmark'=>1,'status'=>'TRUE'], Response::HTTP_OK);
            }

        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function bookmarkLists($id) {
        $bookmarked = Bookmark::where(['event_id'=>$id,'user_id'=>Auth::user()->id])->get();
        
        if($bookmarked) {
            $eventData = array();

            foreach($bookmarked as $book) {
                
                if($book->type == 'sponsers') {
                    $details = Sponser::where(['id'=>$book->bookmark_id])->first();
                    $formname = EventDetail::where(['id'=>$details->detailsid])->first();
    
                } else if($book->type == 'exhibitors') {
                    $details = Exhibitor::where(['id'=>$book->bookmark_id])->first();
                    $formname = EventDetail::where(['id'=>$details->detailsid])->first();

                } else if($book->type == 'speakers') {
                    $details = Speaker::where(['id'=>$book->bookmark_id])->first();
                    $formname = EventDetail::where(['id'=>$details->detailsid])->first();

                } else if($book->type == 'People' || $book->type == 'people') {
                    $details = User::where(['id'=>$book->bookmark_id])->first();
                }

                if($book->type == 'People' || $book->type == 'people') {
                    $eventData[] = [
                        "event_id" => $id,
                        "id" => $details->id,
                        "name" => $details->name,
                        "fid" => '',
                        "image" => $details->profileImage?asset('storage/'.$details->profileImage):'',
                        "position" => $details->position?$details->position:'',
                        "type"=>"People",
                        "formname"=>"People",
                        "havebooked"=>1
                    ];
                } else {
                    $eventData[] = [
                        "event_id" => $id,
                        "id" => $details->id,
                        "name" => $details->name,
                        "fid" => $details->detailsid,
                        "image" => $details->image?asset('storage/'.$details->image):'',
                        "website"=>$details->website,
                        "type"=>$book->type,
                        "formname"=>$formname->form_name,
                        "havebooked"=>1,
                    ];
                }
            }
        } else {
            $eventData =[]; 
        }
        return $eventData;
    }

    public function eventsearch(Request $request) {
        try {
            $validator= Validator::make($request->all(),[
                'event_id' =>"required",
                'keyword' =>"required",
            ]);
    
            if($validator->fails()){
                return response()->json([
                'message' => $validator->errors()->first(),
                'status'=>'FALSE',
                "eventsearch"=>(object)[]
                ],Response::HTTP_OK);
            }
            
            $getSponsers = Sponser::where('name', 'like', '%' . $request->keyword . '%')->where(['event_id'=>$request->event_id])->get();
            
            $sponserList = array();
            
            if($getSponsers) {
                
                foreach($getSponsers as $getSponser) {
                    $checkBookmark = Bookmark::where(['event_id'=>$request->event_id,'user_id'=>Auth::user()->id, 'bookmark_id' => $getSponser->id, 'type' => 'Sponsors'])->first();
                
                    if($checkBookmark) {
                        $havebooked = 1;
                    } else {
                        $havebooked = 0;
                    }
                    $sponserList[] = [
                        "event_id" => $request->event_id,
                        "id" =>$getSponser->id,
                        "fid"=>$getSponser->detailsid,
                        "name" => $getSponser->name,
                        "image" => $getSponser->image? asset('storage/'.$getSponser->image):'',
                        "havebooked"=>$havebooked,
                        "website"=>$getSponser->website,
                        "type"=>'sponsers',
                    ];
                }
            } else {
                $sponserList = [];
            }
            
            $getExhibitors = Exhibitor::where('name', 'like', '%' . $request->keyword . '%')->where(['event_id'=>$request->event_id])->get();
            $exhibitorList = array();
            
            if($getExhibitors) {
                
                foreach($getExhibitors as $getExhibitor) {
                    $checkBookmark = Bookmark::where(['event_id'=>$request->event_id,'user_id'=>Auth::user()->id, 'bookmark_id' => $getExhibitor->id, 'type' => 'Exhibitors'])->first();
                
                    if($checkBookmark) {
                        $havebooked = 1;
                    } else {
                        $havebooked = 0;
                    }
                    $exhibitorList[] = [
                        "event_id" => $request->event_id,
                        "id" =>$getExhibitor->id,
                        "fid"=>$getExhibitor->detailsid,
                        "name" => $getExhibitor->name,
                        "image" => $getExhibitor->image? asset('storage/'.$getExhibitor->image):'',
                        "havebooked"=>$havebooked,
                        "website"=>$getExhibitor->website,
                        "type"=>'exhibitors',
                    ];
                }
            } else {
                $exhibitorList = [];
            }
            
            $getSpeakers = Speaker::where('name', 'like', '%' . $request->keyword . '%')->where(['event_id'=>$request->event_id])->get();
            $speakerList = array();
            
            if($getSpeakers) {
                
                foreach($getSpeakers as $getSpeaker) {
                    $checkBookmark = Bookmark::where(['event_id'=>$request->event_id,'user_id'=>Auth::user()->id, 'bookmark_id' => $getSpeaker->id, 'type' => 'Speakers'])->first();
                
                    if($checkBookmark) {
                        $havebooked = 1;
                    } else {
                        $havebooked = 0;
                    }
                    $speakerList[] = [
                        "event_id" => $request->event_id,
                        "id" =>$getSpeaker->id,
                        "fid"=>$getSpeaker->detailsid,
                        "name" => $getSpeaker->name,
                        "image" => $getSpeaker->image? asset('storage/'.$getSpeaker->image):'',
                        "position" => $getSpeaker->position,
                        "havebooked"=>$havebooked,
                        "website"=>$getSpeaker->website,
                        "type"=>'speakers',
                    ];
                }
            } else {
                $speakerList = [];
            }

            $joins = JoinEvent::where(['event_id'=>$request->event_id,'status'=>1])->get();
            
            if($joins) {
                $eventData = array();

                foreach($joins as $join) {
                    $users = User::where('name', 'like', '%' . $request->keyword . '%')->where(["id"=>$join->user_id])->get();
                    
                    if($users) {

                        foreach($users as $user) {

                            $checkBookmark = Bookmark::where(['event_id'=>$request->event_id,'user_id'=>Auth::user()->id, 'bookmark_id' => $join->user_id, 'type' => 'People'])->first();
                            
                            if($checkBookmark) {
                                $havebooked = 1;
                            } else {
                                $havebooked = 0;
                            }

                            $eventData[] = [
                                "event_id" => $request->event_id,
                                "id" => $user->id,
                                "fid"=>'',
                                "name" => $user->name,
                                "image" => $user->profileImage?asset('storage/'.$user->profileImage):'',
                                "position" => $user->position?$user->position:'',
                                "havebooked"=>$havebooked,
                                "type"=>'People',
                            ];
                        }
                    }
                }
            } else {
                $eventData =[];
            }
            
            $newdata = array();
            $newdata = array_merge($sponserList, $exhibitorList);
            $newdata = array_merge($newdata, $speakerList);
            $newdata = array_merge($newdata, $eventData);

            return response()->json(["eventsearch"=> $newdata,'status'=>'TRUE'],Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

    public function notifications($id ='null') {
        try {
            
            if($id == 'null') {

                $notifications = array();
                $notifyid = array();
                $joinedevents = JoinEvent::where(['user_id'=> Auth::user()->id])->orderBy('id','DESC')->get();

                if($joinedevents) {

                    foreach($joinedevents as $joinedevent) {
                         $notifyid[] = $joinedevent->event_id;
                    }

                    $getNotis = Notification::where("notify_id",$notifyid)->orderBy('id','DESC')->get();
                    foreach ($getNotis as $getNoti) {
                        $notifications[] = $getNoti;
                    }
                } else {
                    $notifications = [];
                }
                return response()->json(["notifications"=> $notifications,'status'=>'TRUE'],Response::HTTP_OK);

            } else {
                $notifications = Notification::where(["notify_id"=>$id])->orderBy('id','DESC')->get();
                return response()->json(["notifications"=> $notifications,'status'=>'TRUE'],Response::HTTP_OK);
            }
            
        } catch (\Exception $e) {
            return response()->json(['status'=>'FALSE','message'=>$e->getMessage()],Response::HTTP_OK);
        }
    }

}
?>