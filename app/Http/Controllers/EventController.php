<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Event;
use App\Models\Feature;
use App\Models\About;
use App\Models\Speaker;
use App\Models\Sponser;
use App\Models\Exhibitor;
use App\Models\Schedule;
use App\Models\FloorPlan;
use App\Models\EventDetail;
use App\Models\Notification;
use App\Models\JoinEvent;
use Illuminate\Support\Facades\Storage;
use App\User;
use Session;
use Auth;
use Image;

class EventController extends Controller
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
    public function index() {
        $events = Event::where('userid',Auth::user()->id)->get();
        return view('eventmanagement', compact('events'));
    }

    public function create() {
        return view('createevent');
    }

    public function saveevent(Request $request) {
        $this->validate($request,[
            'eventname'=>'required',
            'fromdate'=>'required',
            'todate'=>'required',
            'desc'=>'required',
            'location'=>'required',
            'eventpic'=>'required|image|mimes:jpeg,png,jpg',
            'eventpic1'=>'required|image|mimes:jpeg,png,jpg',
            'email'=>'required|email',
            'phone'=>'required',
            'eventcode'=>'required',
        ]);

        if($request->hasFile('eventpic')) {
            $images = $request->eventpic->getClientOriginalName();
            $images = time().'_'.$images; // Add current time before image name
            // orginal image save
            $request->eventpic->storeAs('public/eventbanner',$images);
            $banner = "eventbanner/".$images;
        } else{
            $banner = "";
        }

        if($request->hasFile('eventpic1')) {
            $images = $request->eventpic1->getClientOriginalName();
            $images = time().'_'.$images; // Add current time before image name
            // orginal image save
            $request->eventpic1->storeAs('public/eventlogo',$images);
            $logo = "eventlogo/".$images;
        } else{
            $logo = "";
        }
        
        $data = Event::create([
            'userid'=>Auth::user()->id,
            'name' => $request->eventname,
            'datefrom' => $request->fromdate,
            'dateto' => $request->todate,
            'about' => $request->desc,
            'venu' => $request->location,
            'banner' => $banner,
            'logo' => $logo,
            'email' => $request->email,
            'phone' => $request->phone,
            'event_code' => $request->eventcode,
        ]);
        
        Notification::create([
            'notify_id'=> $data->id,
            'content'=> $request->eventname ." event invitation calling you, Book now",
        ]);

        return redirect()->route('features', ['id'=>$data->id]);
    }

    public function feature($id) {
        $id = $id;
        $featureLists = Feature::all();
        $event = Event::where(['id'=>$id])->first();
        $getEventDetails = EventDetail::select('id','feature_id','form_name')->where(['event_id'=>$id])->get();
        $eventDetails = array();
        $eventDetailid = array();

        if($getEventDetails) {

            foreach($getEventDetails as $getEventDetail) {
                $eventDetails[] = ["id"=>$getEventDetail->id,"fid"=>$getEventDetail->feature_id,"formname"=>$getEventDetail->form_name];
                $eventDetailid[] = $getEventDetail->feature_id;

            }
        } else {
            $eventDetails = [];
            $eventDetailid = [];
        }
        
        return view('features',compact('id','featureLists', 'event','eventDetails','eventDetailid'));
    }

    public function savefeature(Request $request, $id) {
        $this->validate($request,[
            'selectFeature'=>'required',
            'featurename'=>'required',
        ]);

        $selectFeature = $request->selectFeature;
        $featurename = $request->featurename;

        $featureName = Feature::where(["id"=>$selectFeature])->first();

        if($selectFeature == 1) {
            $featureType = 'about';
        } else if($selectFeature == 2) {
            $featureType = 'schedule';
        } else if($selectFeature == 3) {
            $featureType = 'exhibitors';
        } else if($selectFeature == 4) {
            $featureType = 'sponsers';
        } else if($selectFeature == 5) {
            $featureType = 'speakers';
        } else if($selectFeature == 6) {
            $featureType = 'floor_plan';
        }

        EventDetail::create([
            'event_id' => $id,
            'feature_id'=> $selectFeature,
            'type' => $featureType,
            'form_name' => $featurename,
        ]);

        return redirect()->back();
    }

    public function content($id, $tabing='null') {
        $id = $id;
        $event = Event::where(['id'=>$id])->first();
        $getEventDetails = EventDetail::select('id','feature_id','type','form_name')->where(['event_id'=>$id])->get();
        $featureDetails = array();
        $featuresdatas = array();

        if($getEventDetails) {

            foreach($getEventDetails as $getEventDetail) {
                
                if($getEventDetail->feature_id == 1) {
                    $featuresdatas = $this->about($id, $getEventDetail->id);

                } else if($getEventDetail->feature_id == 2) {
                    $featuresdatas = $this->schedule($id, $getEventDetail->id);

                } else if($getEventDetail->feature_id == 3) {
                    $featuresdatas = $this->exhibitor($id, $getEventDetail->id);

                } else if($getEventDetail->feature_id == 4) {
                    $featuresdatas = $this->sponser($id, $getEventDetail->id);

                } else if($getEventDetail->feature_id == 5) {
                    $featuresdatas = $this->speaker($id, $getEventDetail->id);

                } else if($getEventDetail->feature_id == 6) {
                    $featuresdatas = $this->floorplan($id, $getEventDetail->id);
                }
                
                $speakergets  = $this->schedulespeaker($id);                
                $featureDetails[] = [
                                     'id'=>$getEventDetail->id, 
                                     'fid'=>$getEventDetail->feature_id,
                                     'type'=>$getEventDetail->type,
                                     'formname'=>$getEventDetail->form_name,
                                     'featuresdatas'=>$featuresdatas
                                    ];
            }
        } else {
            $featureDetails = [];
        }
        
        if($tabing == 'null') {
            $tabing = '';
        } else {
            $tabing = base64_decode($tabing);
        }

        return view('content',compact('id','event','featureDetails','tabing','speakergets'));
    }
    
    public function about($id, $eid) {
        $id = $id;
        $getAbout = About::where(['event_id'=>$id,'detailsid'=>$eid])->first();
        $aboutData = array();
        
        if($getAbout) {
            $aboutData[] = ['title'=>$getAbout->title, 'content'=>$getAbout->content];
        } else {
            $aboutData = [];
        }
        
        return $aboutData;
    }

    public function schedulespeaker($id) {
        $id = $id;
        $speakerLists = Speaker::where(['event_id'=>$id])->get();
        $speakerData = array();
        
        if($speakerLists) {
            
            foreach($speakerLists as $speakerList) {
                $speakerData[] = ['id'=>$speakerList->id,'type'=>'speaker','name'=>$speakerList->name];
            }
        } else {
            $speakerData = [];
        }
        return $speakerData;
    }

    public function speaker($id, $eid) {
        $id = $id;
        $speakerLists = Speaker::where(['event_id'=>$id,'detailsid'=>$eid])->get();
        $speakerData = array();
        
        if($speakerLists) {
            
            foreach($speakerLists as $speakerList) {
                $speakerData[] = ['id'=>$speakerList->id,'type'=>'speaker','name'=>$speakerList->name];
            }
        } else {
            $speakerData = [];
        }
        return $speakerData;
    }

    public function exhibitor($id, $eid) {
        $id = $id;
        $exhibitorLists = Exhibitor::where(['event_id'=>$id,'detailsid'=>$eid])->get();
        $exhibitorData = array();
        
        if($exhibitorLists) {
            
            foreach($exhibitorLists as $exhibitorList) {
                $exhibitorData[] = ['id'=>$exhibitorList->id,'type'=>'exhibitor','name'=>$exhibitorList->name];
            }
        } else {
            $exhibitorData = [];
        }
        return $exhibitorData;
    }

    public function sponser($id, $eid) {
        $id = $id;
        $sponserLists = Sponser::where(['event_id'=>$id,'detailsid'=>$eid])->get();
        $sponserData = array();
        
        if($sponserLists) {
            
            foreach($sponserLists as $sponserList) {
                $sponserData[] = ['id'=>$sponserList->id,'type'=>'sponser','name'=>$sponserList->name];
            }
        } else {
            $sponserData = [];
        }
        return $sponserData;
    }

    public function schedule($id, $eid) {
        
        $id = $id;
        $scheduleLists = Schedule::where(['event_id'=>$id,'detailsid'=>$eid])->orderBy('event_from','ASC')->get();
        $scheduleData = array();
        
        if($scheduleLists) {
            
            foreach($scheduleLists as $scheduleList) {
                $scheduleData[] = ['id'=>$scheduleList->id,
                                   'type'=>'schedule',
                                   'name'=>$scheduleList->name,
                                   'event_date'=>$scheduleList->event_date,
                                   'event_from'=> Carbon::parse($scheduleList->event_from)->format('H:i'),
                                   'event_to'=> Carbon::parse($scheduleList->event_to)->format('H:i')
                                ];
            }
        } else {
            $scheduleData = [];
        }
        
        return $scheduleData;
    }

    public function floorplan($id, $eid) {
        $id = $id;
        $floorplans = FloorPlan::where(['event_id'=>$id,'detailsid'=>$eid])->get();
        $floorData = array();
        if($floorplans) {
            
            foreach($floorplans as $floorplan) {
                $floorData[] = ['id'=>$floorplan->id,'type'=>'floor','name'=>$floorplan->name,'floorimg'=>$floorplan->floor_image];
            }
        } else {
            $floorData = [];
        }
        return $floorData;
    }

    public function addabout(Request $request, $id) {
        $this->validate($request,[
            'title'=>'required',
            'content'=>'required'
        ]);
           
        $haveAbout = About::where(['event_id'=>$id, 'userid'=>Auth::user()->id, 'detailsid'=>$request->detail])->first();
        
        if($haveAbout) {
            $haveAbout->title = $request->title;
            $haveAbout->content = $request->content;
            $haveAbout->save();
        } else {
            About::create([
                'event_id'=>$id,
                'userid'=>Auth::user()->id,
                'detailsid'=>$request->detail,
                'title' => $request->title,
                'content' => $request->content,
            ]);
        }
        
        $tabing = base64_encode($request->detail);
        return redirect()->route('content', ['id'=>$id,'tabing'=>$tabing]);
    }

    public function addschedule(Request $request, $id) {

        Schedule::create([
            'userid'=>Auth::user()->id,
            'event_id'=>$id,
            'detailsid'=>$request->detail,
            'name' => $request->name,
            'event_date' => $request->event_date,
            'event_from' => $request->event_from,
            'event_to' => $request->event_to,
            'location' => $request->location,
            'description' => $request->desc,
            'speaker' => $request->speaker
        ]);
        $tabing = base64_encode($request->detail);
        return redirect()->route('content', ['id'=>$id,'tabing'=>$tabing]);
    }

    public function addspeaker(Request $request, $id) {
        $this->validate($request,[
            'name'=>'required',
            'cname'=>'required',
            'logo'=>'required|image|mimes:jpeg,png,jpg',
            'position'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'desc'=>'required'
        ]);

        if($request->hasFile('logo')) {
            $images = $request->logo->getClientOriginalName();
            $images = time().'_'.$images; // Add current time before image name
            // orginal image save
            $request->logo->storeAs('public/speakerlogo',$images);
            $banner = "speakerlogo/".$images;
        } else{
            $banner = "";
        }

        Speaker::create([
            'event_id'=>$id,
            'userid'=>Auth::user()->id,
            'detailsid'=>$request->detail,
            'name' => $request->name,
            'cname' => $request->cname,
            'image' => $banner,
            'position' => $request->position,
            'email' => $request->email,
            'phone' => $request->phone,
            'description' => $request->desc,
            'toprated' => $request->toprated?$request->toprated:0,
        ]);
        $tabing = base64_encode($request->detail);
        return redirect()->route('content', ['id'=>$id,'tabing'=>$tabing]);
    }

    public function addexhibitor(Request $request, $id) {
        $this->validate($request,[
            'name'=>'required',
            'booth'=>'required',
            'logo'=>'required|image|mimes:jpeg,png,jpg',
            'website'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'desc'=>'required'
        ]);

        if($request->hasFile('logo')) {
            $images = $request->logo->getClientOriginalName();
            $images = time().'_'.$images; // Add current time before image name
            // orginal image save
            $request->logo->storeAs('public/exhibitorlogo',$images);
            $banner = "exhibitorlogo/".$images;
        } else{
            $banner = "";
        }

        Exhibitor::create([
            'event_id'=>$id,
            'userid'=>Auth::user()->id,
            'detailsid'=>$request->detail,
            'name' => $request->name,
            'booth' => $request->booth,
            'image' => $banner,
            'website' => $request->website,
            'email' => $request->email,
            'phone' => $request->phone,
            'description' => $request->desc,
            'toprated' => $request->toprated?$request->toprated:0,
        ]);
        $tabing = base64_encode($request->detail);
        return redirect()->route('content', ['id'=>$id,'tabing'=>$tabing]);
    }

    public function addsponser(Request $request, $id) {
        $this->validate($request,[
            'name'=>'required',
            'level'=>'required',
            'logo'=>'required|image|mimes:jpeg,png,jpg',
            'website'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'desc'=>'required'
        ]);

        if($request->hasFile('logo')) {
            $images = $request->logo->getClientOriginalName();
            $images = time().'_'.$images; // Add current time before image name
            // orginal image save
            $request->logo->storeAs('public/sponserlogo',$images);
            $banner = "sponserlogo/".$images;
        } else{
            $banner = "";
        }

        Sponser::create([
            'userid'=>Auth::user()->id,
            'event_id'=>$id,
            'detailsid'=>$request->detail,
            'name' => $request->name,
            'level' => $request->level,
            'image' => $banner,
            'website' => $request->website,
            'email' => $request->email,
            'phone' => $request->phone,
            'description' => $request->desc,
            'toprated' => $request->toprated?$request->toprated:0,
        ]);
        $tabing = base64_encode($request->detail);
        return redirect()->route('content', ['id'=>$id,'tabing'=>$tabing]);
    }

    public function savefloorplan(Request $request, $id) {
        $this->validate($request,[
            'floorimages'=>'required',
        ]);

        if($request->hasFile('floorimages')) {
            
            foreach($request->floorimages as $floorimage) {

                    $images = $floorimage->getClientOriginalName();
                    $images = time().'_'.$images; // Add current time before image name
                    // orginal image save
                    $floorimage->storeAs('public/floorimages',$images);
                    $banner = "floorimages/".$images;

                FloorPlan::Create([
                    'event_id' => $id,
                    'detailsid'=>$request->detail,
                    'floor_image' => $banner,
                ]);
            }
        }
        $tabing = $request->detail;
        return redirect()->route('content', ['id'=>$id,'tabing'=>$tabing]);
    }


    public function eventstatuschange(Request $request) {

        $event = Event::where(['id'=>$request->eid])->first();

        if($event->status == 0) {
            $event->status = 1;
            $event->save();
        
        } else if($event->status == 1) {
            $event->status = 0;
            $event->save();
        
        } else if($event->status == 2) {
            $event->status = 1;
            $event->save();
        }

        echo "1";
    }

    public function viewevent($eid) {
        $event = Event::where(['id'=>$eid])->first();
        return view('viewevent', compact('event', 'eid'));
    }

    public function updateevent(Request $request, $eid) {
            $this->validate($request,[
                'eventname'=>'required',
                'fromdate'=>'required',
                'todate'=>'required',
                'desc'=>'required',
                'location'=>'required',
                'eventpic'=>'image|mimes:jpeg,png,jpg',
                'eventpic1'=>'image|mimes:jpeg,png,jpg',
                'email'=>'required|email',
                'phone'=>'required',
                'eventcode'=>'required',
            ]);

            $event = Event::where(['id'=>$eid])->first();

            if($event) {
                $event->name = $request->eventname;
                $event->datefrom = $request->fromdate;
                $event->dateto = $request->todate;
                $event->about = $request->desc;
                $event->venu = $request->location;
                $event->email = $request->email;
                $event->phone = $request->phone;
                $event->event_code = $request->eventcode;

                if($request->hasFile('eventpic')) {
                    $images = $request->eventpic->getClientOriginalName();
                    $images = time().'_'.$images; // Add current time before image name
                    // orginal image save
                    $request->eventpic->storeAs('public/eventbanner',$images);
                    $banner = "eventbanner/".$images;

                    $event->banner = $banner;
                }

                if($request->hasFile('eventpic1')) {
                    $images = $request->eventpic1->getClientOriginalName();
                    $images = time().'_'.$images; // Add current time before image name
                    // orginal image save
                    $request->eventpic1->storeAs('public/eventlogo',$images);
                    $logo = "eventlogo/".$images;

                    $event->logo = $logo;
                }
                
                $event->save();
            }
            
            return redirect()->route('features', ['id'=>$eid]);
    }

    public function deleteevent($eid) {
        $eid = $eid;
        $getEvent = Event::where(['id'=>$eid])->first();
        $getEvent->status = 2;
        $getEvent->save();
        return redirect()->route('event-management');
    }

    public function deletefeature(Request $request) {
        $joindelete = EventDetail::where(['id'=>$request->jid])->delete();
        return "true";
    }

    public function deletecontent(Request $request) {

        if($request->type == 'speaker') {
            $joindelete = Speaker::where(['id'=>$request->jid])->delete();
            return "true";
        } else if($request->type == 'sponser') {
            $joindelete = Sponser::where(['id'=>$request->jid])->delete();
            return "true";
        }  else if($request->type == 'exhibitor') {
            $joindelete = Exhibitor::where(['id'=>$request->jid])->delete();
            return "true";
        }  else if($request->type == 'floor') {
            $joindelete = FloorPlan::where(['id'=>$request->jid])->delete();
            return "true";
        
        }  else if($request->type == 'schedule') {
            $joindelete = Schedule::where(['id'=>$request->jid])->delete();
            return "true";
        }
    }

    //Sub admin list

    public function subadmineventlist($id) {
        $events = Event::where('userid', $id)->get();
        return view('subadminevents', compact('events'));
    }

    public function subadminviewevent($eid) {
        $event = Event::where(['id'=>$eid])->first();
        return view('subadminviewevents', compact('event', 'eid'));
    }

}
