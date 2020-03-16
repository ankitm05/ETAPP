@extends('layouts.admin')
@section('content')


<div class="product-status mg-b-15">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="bothwaysevt main-sparkline13-hd">
               <h1>Event Information</h1>
               <div class="setrgtbts">
                  <a class="btn btn-custon-four btn-danger" href="{{ route('delete-event', $eid) }}">Delete Event</a>
               </div>
            </div>

            <div class="row">
               <div class="col-md-12">
                  <div class="stepebentsd">
                     <ul>
                        <li>
                           <a href="{{ route('view-event', $eid) }}" class="active">
                              <span class="educate-icon educate-event icon-wrap"></span>
                              <p> Event Info</p>
                           </a>
                        </li>
                        <li>
                           <a href="{{ route('features', $eid) }}">
                              <span class="educate-icon educate-interface icon-wrap"></span> 
                              <p>Features</p>
                           </a>
                        </li>
                        <li>
                           <a href="{{ route('content', $eid) }}">
                              <span class="educate-icon educate-course icon-wrap"></span>
                              <p>Content</p>
                           </a>
                        </li>
                        <li>
                           <a href="{{ route('notifications', $eid) }}">
                              <span class="educate-icon educate-message icon-wrap"></span>
                              <p>Notification</p>
                           </a>
                        </li>
                        <li>
                           <a href="{{ route('social', $eid) }}">
                              <span class="educate-icon educate-professor icon-wrap"></span> 
                              <p>Social</p>
                           </a>
                        </li>
                        <li>
                           <a href="{{ route('polls', $eid) }}">
                              <span class="educate-icon educate-data-table icon-wrap"></span> 
                              <p>Polls</p>
                           </a>
                        </li>
                        <li>
                           <a href="{{ route('joined', $eid) }}">
                              <span class="educate-icon educate-department icon-wrap"></span> 
                              <p>Joined users</p>
                           </a>
                        </li>
                        <li>
                           <a href="{{ route('reports', $eid) }}">
                              <span class="educate-icon educate-charts icon-wrap"></span> 
                              <p>Reports</p>
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>
               
               <div class="col-md-7">

                     <!--detail-1  -->
                  <div class="ftrevents" id="form1">
                     <form method="POST" action="{{ route('update-event', $eid) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Event Name</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="text" name="eventname" class="form-control" placeholder="Enter Event Name" value="{{ $event->name}}">
                                 @if ($errors->has('eventname'))
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('eventname') }}</strong>
                                    </span>
                                 @endif
                              </div>
                           </div>
                        </div>
                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Event Duration</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <div class="row">
                                    <div class="col-lg-12 col-md-2 col-sm-2 col-xs-12">
                                       <div class="date-picker-inner">
                                          <div class="form-group data-custon-pick data-custom-mg" id="data_5">
                                             <div class="input-daterange input-group" id="datepicker">
                                                <input type="text" class="form-control" name="fromdate" value="{{ $event->datefrom}}" />
                                                <span class="input-group-addon">to</span>
                                                <input type="text" class="form-control" name="todate" value="{{ $event->dateto}}" />
                                                   @if ($errors->has('fromdate'))
                                                      <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $errors->first('fromdate') }}</strong>
                                                      </span>
                                                   @endif
                                                   @if ($errors->has('todate'))
                                                      <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $errors->first('todate') }}</strong>
                                                      </span>
                                                   @endif
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <!-- <div class="col-lg-6 col-md-2 col-sm-2 col-xs-12">
                                       <input type='text' name="fromdate" class="form-control" id='datetimepicker4' value="{{ $event->datefrom}}"/>
                                       @if ($errors->has('fromdate'))
                                          <span class="invalid-feedback" role="alert">
                                             <strong>{{ $errors->first('fromdate') }}</strong>
                                          </span>
                                       @endif
                                    </div>
                                    <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                                       <div class="form-select-list">
                                          <input type='text' name="todate" class="form-control" id='datetimepicker5' value="{{ $event->dateto}}"/>
                                          @if ($errors->has('todate'))
                                             <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('todate') }}</strong>
                                             </span>
                                          @endif
                                       </div>
                                    </div> -->
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Event Description</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <textarea class="form-control" name="desc" placeholder="Enter Event Info.."> {{$event->about}}</textarea>
                                 @if ($errors->has('desc'))
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('desc') }}</strong>
                                    </span>
                                 @endif
                              </div>
                           </div>
                        </div>
                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Venue</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input class="form-control" name="location" placeholder="Enter Location.." value="{{ $event->venu}}">
                                 @if ($errors->has('location'))
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('location') }}</strong>
                                    </span>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Upload Event Pic</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="file" name="eventpic" class="form-control" placeholder="Upload event ic">
                                 @if ($errors->has('eventpic'))
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('eventpic') }}</strong>
                                    </span>
                                 @endif
                              </div>
                           </div>
                        </div>
                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Company Logo Pic</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="file" name="eventpic1" class="form-control" placeholder="Upload Company Logo">
                                 @if ($errors->has('eventpic1'))
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('eventpic1') }}</strong>
                                    </span>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Email</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="text" name="email" class="form-control" placeholder="Enter Email id" value="{{ $event->email}}">
                                 @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Phone Number</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="text" name="phone" class="form-control" placeholder="Enter Phone Number" value="{{ $event->phone}}">
                                 @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Event Verification Code</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="text" name="eventcode" class="form-control" placeholder="Enter Event Verification Cod" value="{{ $event->event_code}}" style="text-transform:uppercase">
                                 @if ($errors->has('eventcode'))
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('eventcode') }}</strong>
                                    </span>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="gosubbtns">
                           <button type="submit" name="save" class="btn btn-custon-four btn-primary">Next</button>
                        </div>

                        </form>
                     </div>
                  </div>

                  <div class="col-md-5">
                     <div class="ftrevents">
                        <div class="evtgenare showcompic">
                           <div class="evtimage">
                              @if(strlen($event->banner) > 0)
                                 <img src="{{ asset('storage/'.$event->banner) }}">
                              @else
                                 <img src="{{asset('admin/img/evtpic.png')}}">
                              @endif
                           </div>
                           <div class="evtdates">
                              <div class="fromdt">
                                 <p>{{ date('d-M-Y', strtotime($event->datefrom)) }}</p>
                              </div>
                              <div class="todsn">
                                 <p>to</p>
                              </div>
                              <div class="fromdt todts">
                                 <p>{{ date('d-M-Y', strtotime($event->dateto))}}</p>
                              </div>
                           </div>
                           <div class="companythumbspic">
                              @if(strlen($event->logo) > 0)
                                 <img src="{{ asset('storage/'.$event->logo) }}">
                              @else
                                 <img src="{{asset('admin/img/compthumbs.png')}}">
                              @endif
                           </div>
                        </div>
                        <div class="evtnamedis">
                           <p>{{$event->name}}</p>
                        </div>
                        <div class="manageoptd">
                           <div class="btmng rightmngs">
                              @if($event)
                                @if($event->status == 1)
                                   <a href="#" class="publishevent" onclick="changestatus({{$event->id}})">Unpublish</a>
                                @else
                                   <a href="#" class="publishevent" onclick="changestatus({{$event->id}})" id="">Publish</a>
                                @endif
                              @endif
                           </div>
                        </div>
                     </div>
                     <div class="sparkline9-graph">
                        <div class="google-map-single">

                           <iframe width="400" style="border:0" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q={{$event->venu}} ?>&output=embed"></iframe>
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
   <script type="text/javascript">
      $(document).ready(function() {
         $('#datetimepicker4, #datetimepicker5').datetimepicker();
      });
   </script>
   <script type="text/javascript">
      function changestatus(id) {
         var eid = id;
         $.ajax({
            type: "POST",
            url: "{{ route('event-status-change') }}",
            data: {eid:eid, _token: '{{csrf_token()}}'},
            success: function(response)
            {
               location.reload(true);
           }
         });
      }
   </script>
 <script src="{{asset('admin/js/datapicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('admin/js/datapicker/datepicker-active.js')}}"></script>
@endsection