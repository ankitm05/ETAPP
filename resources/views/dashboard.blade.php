@extends('layouts.admin')
@section('content')



<div class="product-sales-area mg-tb-30">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
            <div class="eventgridsa">
               <div class="centctns">
                  @if(count($eventData) > 0 )
                  <div class="ftrevents">
                     <div class="evtgenare">
                        <div class="evtimage">
                           <img src="{{ asset('storage/'.$eventData['banner'])}}">
                        </div>
                        <div class="evtdates">
                           <div class="fromdt">
                              <p> {{ date('d-M-Y', strtotime($eventData['datefrom'])) }} </p>
                           </div>
                           <div class="todsn">
                              <p>to</p>
                           </div>
                           <div class="fromdt todts">
                              <p> {{ date('d-M-Y', strtotime($eventData['dateto'])) }} </p>
                           </div>
                        </div>
                     </div>
                     <div class="evtnamedis">
                        <p> {{$eventData['name']}} </p>
                     </div>
                     <div class="manageoptd">
                        <div class="btmng">
                           <a href="{{ route('view-event', $eventData['id']) }}">Manage Event <i class="fa fa-sliders"></i></a>
                        </div>
                        <div class="btmng rightmngs">
                                    <a href="#" class="publishevent" onclick="changestatus({{$eventData['id']}})" id="">Unpublish</a>
                        </div>
                     </div>
                  </div>
                  @endif

                  <div class="createevtsd">
                     <div class="add-product">
                        <a href="{{route('create-event')}}">Create Event</a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="myappslides">
               <div class="appscrplay owl-carousel owl-theme">
                  <div class="item">
                     <img src="{{ asset('admin/img/appscr.png')}}">
                  </div>
                  <div class="item">
                     <img src="{{ asset('admin/img/mobile.png')}}">
                  </div>
                  <div class="item">
                     <img src="{{ asset('admin/img/appscr.png')}}">
                  </div>
                  <div class="item">
                     <img src="{{ asset('admin/img/mobile.png')}}">
                  </div>
                  <div class="item">
                     <img src="{{ asset('admin/img/appscr.png')}}">
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="white-box analytics-info-cs mg-b-10 res-mg-b-30 res-mg-t-30 table-mg-t-pro-n tb-sm-res-d-n dk-res-t-d-n">
               <h3 class="box-title">Total Events</h3>
               <ul class="list-inline two-part-sp">
                  <li>
                     <div id="sparklinedash"></div>
                  </li>
                  <li class="text-right sp-cn-r"><i class="fa fa-level-up" aria-hidden="true"></i> <span class="counter text-success">{{$eventCount}}</span></li>
               </ul>
            </div>
            <div class="white-box analytics-info-cs mg-b-10 res-mg-b-30 tb-sm-res-d-n dk-res-t-d-n">
               <h3 class="box-title">Total Sponsors</h3>
               <ul class="list-inline two-part-sp">
                  <li>
                     <div id="sparklinedash2"></div>
                  </li>
                  <li class="text-right graph-two-ctn"><i class="fa fa-level-up" aria-hidden="true"></i> <span class="counter text-purple">{{$sponserTotal}}</span></li>
               </ul>
            </div>
            <div class="white-box analytics-info-cs mg-b-10 res-mg-b-30 tb-sm-res-d-n dk-res-t-d-n">
               <h3 class="box-title">Total Users</h3>
               <ul class="list-inline two-part-sp">
                  <li>
                     <div id="sparklinedash3"></div>
                  </li>
                  <li class="text-right graph-three-ctn"><i class="fa fa-level-up" aria-hidden="true"></i> <span class="counter text-info">{{$userCount}}</span></li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="traffic-analysis-area">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="social-media-edu">
               <i class="fa fa-facebook"></i>
               <div class="social-edu-ctn">
                  <h3>50k Likes</h3>
                  <p>You main list growing</p>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="social-media-edu twitter-cl res-mg-t-30 table-mg-t-pro-n">
               <i class="fa fa-twitter"></i>
               <div class="social-edu-ctn">
                  <h3>30k followers</h3>
                  <p>You main list growing</p>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="social-media-edu linkedin-cl res-mg-t-30 res-tablet-mg-t-30 dk-res-t-pro-30">
               <i class="fa fa-linkedin"></i>
               <div class="social-edu-ctn">
                  <h3>7k Connections</h3>
                  <p>You main list growing</p>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="social-media-edu youtube-cl res-mg-t-30 res-tablet-mg-t-30 dk-res-t-pro-30">
               <i class="fa fa-youtube"></i>
               <div class="social-edu-ctn">
                  <h3>50k Subscribers</h3>
                  <p>You main list growing</p>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection

@section('scripts')
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
@endsection