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
                           <a href="{{ route('features', $id) }}">
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
                           <a href="{{ route('notifications', $id) }}"  class="active">
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
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="ftrevents" style="min-height: 416px;">
                        <div class="row">
                           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                              <h3>Notifications</h3>
                           </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-md-12">
                              <ul class="message-menu mCustomScrollbar _mCS_2 mCS-autoHide" style="position: relative; overflow: visible;">
                                <div id="mCSB_2_container" class="mCSB_container" style="position:relative; top:0; left:0;" dir="ltr">
                                  @if(count($notifyDatas) > 0)
                                    @foreach($notifyDatas as $notifyData)
                                       <li>
                                          <a href="#">
                                             <div class="message-img">
                                                <img src="{{asset('admin/img/notifyiconnew.png')}}" alt="" class="mCS_img_loaded">
                                             </div>
                                             <div class="message-content">
                                                <span class="message-date"> {{ $notifyData['date'] }} </span>
                                                <p> {{ $notifyData['content'] }} </p>
                                             </div>
                                          </a>
                                       </li>
                                    @endforeach
                                  @endif
                             </ul>
                          </div>
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