@extends('layouts.admin')
@section('content')

<div class="product-status mg-b-15">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="bothwaysevt main-sparkline13-hd">
               <h1>Event Information</h1>
               <div class="setrgtbts">
                  
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="stepebentsd">
                     <ul>
                        <li>
                           <a href="{{ route('view-event', $id) }}">
                              <span class="educate-icon educate-event icon-wrap"></span>
                              <p> Event Info</p>
                           </a>
                        </li>
                        <li>
                           <a href="{{ route('features', $id) }}" class="active">
                              <span class="educate-icon educate-interface icon-wrap"></span> 
                              <p>Features</p>
                           </a>
                        </li>
                        <li>
                           <a href="{{ route('content', $id) }}">
                              <span class="educate-icon educate-course icon-wrap"></span>
                              <p>Content</p>
                           </a>
                        </li>
                        <li>
                           <a href="{{ route('notifications', $id) }}">
                              <span class="educate-icon educate-message icon-wrap"></span>
                              <p>Notification</p>
                           </a>
                        </li>
                        <li>
                           <a href="{{ route('social', $id) }}">
                              <span class="educate-icon educate-professor icon-wrap"></span> 
                              <p>Social</p>
                           </a>
                        </li>
                        <li>
                           <a href="{{ route('polls', $id) }}">
                              <span class="educate-icon educate-data-table icon-wrap"></span> 
                              <p>Polls</p>
                           </a>
                        </li>
                        <li>
                           <a href="{{ route('joined', $id) }}">
                              <span class="educate-icon educate-department icon-wrap"></span> 
                              <p>Joined users</p>
                           </a>
                        </li>
                        <li>
                           <a href="{{ route('reports', $id) }}">
                              <span class="educate-icon educate-charts icon-wrap"></span> 
                              <p>Reports</p>
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>

                <div class="col-md-7">
                    <div class="ftrevents" style="min-height: 416px;">
                     
                        <div class="col-md-12" style="padding-top:100px;">
                            <form action="{{ route('savefeature', $id) }}" method="post">
                              @csrf
                                <div class="form-group-inner">
                                   <div class="row">
                                      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                         <label class="login2 pull-right pull-right-pro"> Select Features </label>
                                      </div>
                                      <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <select name="selectFeature" data-placeholder="Choose a Features..." class="chosen-select" tabindex="-1">
                                            <option value="">Select</option>
                                        @if($featureLists)
                                            @foreach($featureLists as $featureList)
                                              <option value="{{ $featureList->id}}"> {{ $featureList->usename}} </option>
                                            @endforeach
                                        @endif
                                        </select>
                                      </div>
                                   </div>
                                   <div class="row">
                                      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                         <label class="login2 pull-right pull-right-pro"> Name </label>
                                      </div>
                                      <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                          <input type="text" class="form-control" name="featurename" placeholder="Choose a feature name">
                                      </div>
                                   </div>
                                </div>

                                <div class="gosubbtns">
                                     <button type="submit" class="btn btn-custon-four btn-primary" name="save"> Add </button>
                                </div>
                            </form>
                        </div>

                        <div class="" style="float: left; padding-top:50px;">
                           @if($eventDetails)
                              @if(count($eventDetails) > 0)
                                 @foreach($eventDetails as $eventDetail)
                                    <div class="col-md-12 well well-sm"> 
                                       <span style="float:left;width:80%;"> {{$eventDetail['formname']}} </span>
                                       <span class="btn btn-warning" onclick="deletefunction({{$eventDetail['id']}})" style="float:right;"> <i class="fa fa-trash" aria-hidden="true"></i> </span> 
                                    </div>
                                 @endforeach
                                    <div style="clear:both;"></div>
                              @endif
                           @endif
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
<script>
   function deletefunction(id) {

      $.ajax({
           type: "POST",
           url: "{{ route('delete_feature') }}",
           data: {jid:id, _token: '{{csrf_token()}}'},
           success: function(response)
           {
              location.reload(true);
           },
      });
   }
</script>
@endsection