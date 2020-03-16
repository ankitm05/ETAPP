@extends('layouts.admin')
@section('content')

<div class="product-status mg-b-15">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="bothwaysevt main-sparkline13-hd">
               <h1>Event Information</h1>
               <div class="setrgtbts">
                  <a class="btn btn-custon-four btn-danger" href="#">Delete Event</a>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="stepebentsd">
                     <ul>
                        <li>
                           <a href="#">
                              <span class="educate-icon educate-event icon-wrap"></span>
                              <p> Event Info</p>
                           </a>
                        </li>
                        <li>
                           <a href="#">
                              <span class="educate-icon educate-professor icon-wrap"></span> 
                              <p>Organisers</p>
                           </a>
                        </li>
                        <li>
                           <a href="#">
                              <span class="educate-icon educate-student icon-wrap"></span>
                              <p>Speakers</p>
                           </a>
                        </li>
                        <li>
                           <a href="#">
                              <span class="educate-icon educate-department icon-wrap"></span>
                              <p>Exhibitors</p>
                           </a>
                        </li>
                        <li>
                           <a href="#">
                              <span class="educate-icon educate-professor icon-wrap"></span> 
                              <p>Sponsers</p>
                           </a>
                        </li>
                        
                        <li>
                           <a href="#">
                              <span class="educate-icon educate-home icon-wrap"></span>
                              <p>Ministeries</p>
                           </a>
                        </li>
                        
                        <li>
                           <a href="#" class="active">
                              <span class="educate-icon educate-professor icon-wrap"></span>
                              <p>Floor Plan</p>
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>

                <div class="col-md-7">
                    <div class="ftrevents" style="min-height: 416px;">

                        <div class="col-md-12">
                            <form action="{{ route('savefloorplan', $id) }}" method="post" enctype="multipart/form-data">
                              @csrf
                                <div class="form-group-inner">
                                   <div class="row">
                                      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                         <label class="login2 pull-right pull-right-pro"> Upload Floor Plan images</label>
                                      </div>
                                      <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <input type="file" name="floorimages[]" class="form-control" placeholder="Upload logo" multiple>
                                        ( Upload Max 5 images )
                                      </div>
                                   </div>
                                </div>

                                <div class="gosubbtns">
                                     <button type="submit" class="btn btn-custon-four btn-primary" name="save"> Save </button>
                                     <a href="{{route('event-management')}}" class="btn btn-custon-four btn-primary" name="save"> Exit </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                  <div class="col-md-5">
                     <div class="ftrevents">
                        <div class="evtgenare showcompic">
                           <div class="evtimage">
                              @if($event)
                                @if(strlen($event->banner) > 0)
                                   <img src="{{ asset('storage/'.$event->banner) }}">
                                @else
                                   <img src="{{asset('admin/img/evtpic.png')}}">
                                @endif
                              @else
                                <img src="{{asset('admin/img/evtpic.png')}}">
                              @endif
                           </div>
                           <div class="evtdates">
                              <div class="fromdt">
                                @if($event)
                                  <p>{{ date('d-M-Y', strtotime($event->datefrom)) }}</p>
                                @else
                                  <p> -- </p>
                                @endif
                              </div>
                              <div class="todsn">
                                 <p>to</p>
                              </div>
                              <div class="fromdt todts">
                                @if($event)
                                  <p>{{ date('d-M-Y', strtotime($event->dateto))}}</p>
                                @else
                                  <p> -- </p>
                                @endif
                              </div>
                           </div>
                           <div class="companythumbspic">
                              @if($event)
                                  @if(strlen($event->logo) > 0)
                                     <img src="{{ asset('storage/'.$event->logo) }}">
                                  @else
                                     <img src="{{asset('admin/img/compthumbs.png')}}">
                                  @endif
                              @else
                                <img src="{{asset('admin/img/compthumbs.png')}}">
                              @endif
                           </div>
                        </div>
                        <div class="evtnamedis">
                          @if($event)
                            <p>{{$event->name}}</p>
                          @else
                            <p></p>
                          @endif
                        </div>
                        <div class="manageoptd">
                           <div class="btmng rightmngs">
                              @if($event)
                                @if($event->status == 1)
                                   <a href="#" class="publishevent" onclick="changestatus({{$event->id}})">Publish</a>
                                @else
                                   <a href="#" class="publishevent" onclick="changestatus({{$event->id}})" id="">Unpublish</a>
                                @endif
                              @endif
                           </div>
                        </div>
                     </div>
                     <div class="sparkline9-graph">
                        <div class="google-map-single">
                           @if($event)
                           <iframe width="400" style="border:0" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q={{$event->venu}} ?>&output=embed"></iframe>
                          @endif
                        </div>
                     </div>
                  </div>
            </div>
         </div>
      </div>
   </div>
</div>



@endsection

@section('scripts')
@endsection